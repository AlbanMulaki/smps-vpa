<?php

class ProvimetController extends \BaseController {

    public function getRaportiNotave() {
        $year = 0;
        $month = 0;
        $drejtimi = 0;
        $year = Input::get('year');
        $month = Input::get('month');
        $drejtimi = Input::get('drejtimi');
        if ($year == 0 && $month == 0 && $drejtimi == 0) {
            $drejtimet = Drejtimet::getComboDrejtimetGroupedAll();
            return View::make('admin.provimet.raporti_notave', ['drejtimi' => $drejtimet]);
        } else {
            $drejtimet = Drejtimet::getComboDrejtimetGroupedAll();
            $raportet = RaportiNotave::select('lendet.Emri as lenda', DB::raw("CONCAT(administrata.emri,' ',administrata.mbiemri) as prof"), "administrata.uid as profuid", "drejtimet.emri as drejtimi", "raporti_notave.data_provimit as data_provimit", "raporti_notave.id as idraportit", "raporti_notave.locked as locked")
                    ->join('lendet', 'lendet.idl', '=', 'raporti_notave.idl')
                    ->join('administrata', 'administrata.uid', '=', 'raporti_notave.prof')
                    ->join('drejtimet', 'drejtimet.idDrejtimet', '=', 'raporti_notave.drejtimi')
                    ->where('data_provimit', 'LIKE', $year . "-" . $month . "%")
                    ->where('raporti_notave.drejtimi', '=', $drejtimi)
                    ->get();
            $reportlist = array();
            foreach ($raportet as $value) {
                $temp = RaportiNotaveStudent::getRaportNotaveList($value['idraportit']);
                $reportlist[$value['idraportit']] = $temp;
            }
            return View::make('admin.provimet.raporti_notave', ['drejtimi' => $drejtimet,
                        'raportet' => $raportet,
                        'year' => $year,
                        'month' => $month,
                        'drejtimSel' => $drejtimi,
                        'reportList' => $reportlist]);
        }
    }

    /*
     * Delete student prej raportit te notave
     */

    public function getDeleteStudent($idraportit, $idstudenti) {
        $update = array('deleted' => Enum::deleted);
        RaportiNotaveStudent::where('studenti', '=', $idstudenti)
                ->where('idraportit', '=', $idraportit)
                ->update($update);
    }

    public function getRegisterNotat($idraportit) {
        $raporti = RaportiNotaveStudent::getRaportNotaveList($idraportit);
        $raport_details = RaportiNotave::select('lendet.Emri as lenda', DB::raw("CONCAT(administrata.emri,' ',administrata.mbiemri) as prof"), "administrata.uid as profuid", "drejtimet.emri as drejtimi", "raporti_notave.data_provimit as data_provimit", "drejtimet.idDrejtimet as drejtimiId", "raporti_notave.id as idraportit", "raporti_notave.locked as locked")
                ->join('lendet', 'lendet.idl', '=', 'raporti_notave.idl')
                ->join('administrata', 'administrata.uid', '=', 'raporti_notave.prof')
                ->join('drejtimet', 'drejtimet.idDrejtimet', '=', 'raporti_notave.drejtimi')
                ->where('raporti_notave.id', '=', $idraportit)
                ->where('raporti_notave.locked', '=', Enum::nolocked)
                ->get();
        $raportiNotave = RaportiNotave::find($idraportit);

        return View::make('admin.provimet.regjistrimi_raportit_notave', ['raporti' => $raporti,
                    'details' => $raport_details[0],
                    'raportiNotave' => $raportiNotave]);
    }

    public function postUpdateReport() {
        $raportiNotave = RaportiNotave::find(1)->raportiNotaveStudent;
        $i = 0;
        for ($i = 0; $i < count(Input::get('uid')); $i++) {
            if (isset($raportiNotave[$i]) == false) {
                $raportiNotaveNew = new RaportiNotaveStudent();
                $create = array(
                    'studenti' => Input::get('uid.' . $i),
                    'testi_semestral' => Input::get('testi_semestral.' . $i),
                    'nota' => Input::get('nota.' . $i),
                    'seminari' => Input::get('seminari.' . $i),
                    'pjesmarrja' => Input::get('pjesmarrja.' . $i),
                    'puna_praktike' => Input::get('puna_praktike.' . $i),
                    'testi_final' => Input::get('testi_final.' . $i),
                    'refuzim' => Input::get('refuzim.' . $i),
                    'paraqit' => Input::get('paraqit.' . $i),
                    'paraqit_prezent' => Input::get('paraqit_prezent.' . $i),
                    'idraportit' => Input::get('idraportit'),
                    'idl' => Input::get('idl')
                );
                $raportiNotaveNew->create($create);
            } else {
                $raportiNotave[$i]->studenti = Input::get('uid.' . $i);
                $raportiNotave[$i]->testi_semestral = Input::get('testi_semestral.' . $i);
                $raportiNotave[$i]->nota = Input::get('nota.' . $i);
                $raportiNotave[$i]->seminari = Input::get('seminari.' . $i);
                $raportiNotave[$i]->pjesmarrja = Input::get('pjesmarrja.' . $i);
                $raportiNotave[$i]->puna_praktike = Input::get('puna_praktike.' . $i);
                $raportiNotave[$i]->testi_final = Input::get('testi_final.' . $i);
                $raportiNotave[$i]->refuzim = Input::get('refuzim.' . $i);
                $raportiNotave[$i]->paraqit = Input::get('paraqit.' . $i);
                $raportiNotave[$i]->paraqit_prezent = Input::get('paraqit_prezent.' . $i);
                $raportiNotave[$i]->save();
            }
        }
        return Redirect::back();
    }

    public function getPrintReportNotat($idraportit) {
        $drejtimet = Drejtimet::getComboDrejtimetGroupedAll();
        $raporti = RaportiNotave::select('departmentet.Emri as departmenti', 'lendet.Emri as lenda', DB::raw("CONCAT(administrata.emri,' ',administrata.mbiemri) as prof"), "administrata.uid as profuid", "drejtimet.emri as drejtimi", "raporti_notave.data_provimit as data_provimit", "raporti_notave.id as idraportit", "raporti_notave.viti_aka as viti_aka", "raporti_notave.locked as locked")
                ->join('lendet', 'lendet.idl', '=', 'raporti_notave.idl')
                ->join('administrata', 'administrata.uid', '=', 'raporti_notave.prof')
                ->join('drejtimet', 'drejtimet.idDrejtimet', '=', 'raporti_notave.drejtimi')
                ->join('departmentet', 'departmentet.idDepartmentet', '=', 'raporti_notave.departmenti')
                ->where('raporti_notave.id', '=', $idraportit)
                ->get();
        $reportlist = array();

        // Fetch sudents for report
        $reportlist = RaportiNotaveStudent::getRaportNotaveList($raporti[0]['idraportit']);

        $pdf = PDF::loadView('admin.provimet.print_raporti_notave', [ 'title' => Lang::get('printable.title_report_grade'),
                    'students' => $reportlist,
                    'raporti' => $raporti[0]])->setOrientation('landscape');
        return $pdf->stream();
    }

    public function getAddRaportiNotave() {
        $raportiNotave = Lendet::getComboLendetAll();
        $prof = Admin::all()->sortBy('emri');
        return View::make('admin.provimet.add_new_report', [
                    'raportiNotave' => $raportiNotave,
                    'prof' => $prof]);
    }

    /**
     * Save new report grade for student
     * @return 
     */
    public function postAddRaportiNotave() {

        $raportiNotave = new RaportiNotave;
        $raportiNotave->idl = Input::get('idl');
        $raportiNotave->prof = Input::get('prof');
        $raportiNotave->data_provimit = date("Y-m-d H:i:s", strtotime(Input::get('data_provimit')));
        $raportiNotave->statusi_studentve = Input::get('statusi_studentve');
        $raportiNotave->locked = Enum::nolocked;
        $raportiNotave->save();
        for ($i = 0; $i < count(Input::get('uid')); $i++) {
            $raportiNotaveStudent = null;
            $raportiNotaveStudent = new RaportiNotaveStudent;
            $raportiNotaveStudent->idraportit = $raportiNotave->id;
            $raportiNotaveStudent->studenti = Input::get('uid.' . $i);
            $raportiNotaveStudent->nota = Input::get('nota.' . $i);
            $raportiNotaveStudent->testi_semestral = Input::get('testi_semestral.' . $i);
            $raportiNotaveStudent->testi_gjysem_semestral = Input::get('testi_gjysemsemestral.' . $i);
            $raportiNotaveStudent->seminari = Input::get('seminari.' . $i);
            $raportiNotaveStudent->pjesmarrja = Input::get('pjesmarrja.' . $i);
            $raportiNotaveStudent->puna_praktike = Input::get('praktike.' . $i);
            $raportiNotaveStudent->testi_final = Input::get('testi_final.' . $i);
            $raportiNotaveStudent->refuzim = Input::get('refuzim.' . $i);
            $raportiNotaveStudent->paraqit = Input::get('paraqit.' . $i);
            $raportiNotaveStudent->idl = Input::get('idl');
            $raportiNotaveStudent->locked = Enum::nolocked;
            $raportiNotaveStudent->paraqit_prezent = Input::get('paraqit_prezent.' . $i);
            $raportiNotaveStudent->save();
        }
        
        // not completed



        return Input::all();
        return View::make('admin.provimet.add_new_report');
    }

}
