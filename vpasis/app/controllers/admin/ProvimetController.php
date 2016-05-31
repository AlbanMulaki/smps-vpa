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
            $raportedEFundit = RaportiNotave::take(15)->orderBy('id', 'DESC')->get();
            return View::make('admin.provimet.raporti_notave', ['drejtimi' => $drejtimet,
                        'raportet' => $raportedEFundit]);
        } else {
            $drejtimet = Drejtimet::getComboDrejtimetGroupedAll();
            $raportet = RaportiNotave::where('afati_provimit', $month)
                    ->get();
            $raportet = $raportet->filter(function($raport)use($drejtimi) {
                if ($raport->lendet->drejtimi->idDrejtimet == $drejtimi) {
                    return $raport;
                }
            });
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
        $raporti = RaportiNotave::find($idraportit);
//        $raport_details = RaportiNotave::select('lendet.Emri as lenda', DB::raw("CONCAT(administrata.emri,' ',administrata.mbiemri) as prof"), "administrata.uid as profuid", "drejtimet.emri as drejtimi", "raporti_notave.data_provimit as data_provimit", "drejtimet.idDrejtimet as drejtimiId", "raporti_notave.id as idraportit", "raporti_notave.locked as locked")
//                ->join('lendet', 'lendet.idl', '=', 'raporti_notave.idl')
//                ->join('administrata', 'administrata.uid', '=', 'raporti_notave.prof')
//                ->join('drejtimet', 'drejtimet.idDrejtimet', '=', 'raporti_notave.drejtimi')
//                ->where('raporti_notave.id', '=', $idraportit)
//                ->where('raporti_notave.locked', '=', Enum::nolocked)
//                ->get();
//        $raport_details = RaportiNotave::where('raporti_notave.id',$idraportit)
//                ->where('raporti_notave.locked',Enum::nolocked)
//                ->get();

        $raport_details = $raporti->raportiNotaveStudent;
//        return $raport_details->count();
//        $raport_details = $raport_details->filter(function($raport)use($idraportit){
//            if($raport->idraportit == $idraportit){
//                return $raport;
//            }    
//            
//        });
//        return $raport_details->count();
        $raportiNotave = RaportiNotave::find($idraportit);

        return View::make('admin.provimet.regjistrimi_raportit_notave', ['raporti' => $raporti,
                    'details' => $raport_details,
                    'raportiNotave' => $raportiNotave]);
    }

    public function postUpdateReport() {

        $raportiNotave = RaportiNotave::find(Input::get('idraportit'));
        $i = 0;
        for ($i = 0; $i < count(Input::get('uid')); $i++) {
            $uid = Input::get('uid.' . $i);
            $doesStudentExist = RaportiNotaveStudent::where('idraportit', Input::get('idraportit'))
                    ->where('studenti', $uid)
                    ->first();
             if($doesStudentExist != NULL){
                $doesStudentExist->studenti = Input::get('uid.' . $i);
                $doesStudentExist->testi_semestral = Input::get('testi_semestral.' . $i);
                $doesStudentExist->testi_gjysem_semestral = Input::get('testi_gjysemsemestral.' . $i);
                $doesStudentExist->nota = Input::get('nota.' . $i);
                $doesStudentExist->seminari = Input::get('seminari.' . $i);
                $doesStudentExist->pjesmarrja = Input::get('pjesmarrja.' . $i);
                $doesStudentExist->puna_praktike = Input::get('praktike.' . $i);
                $doesStudentExist->testi_final = Input::get('testi_final.' . $i);
                $doesStudentExist->refuzim = Input::get('refuzim.' . $i);
                $doesStudentExist->paraqit = Input::get('paraqit.' . $i);
                $doesStudentExist->paraqit_prezent = Input::get('paraqit_prezent.' . $i);
                $doesStudentExist->save();
            }else if (is_numeric(Input::get('uid.'.$i))) {
                $raportiNotaveStudent = null; 
                $raportiNotaveStudent = new RaportiNotaveStudent;
                $raportiNotaveStudent->idraportit = Input::get('idraportit');
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
                $raportiNotaveStudent->locked = Enum::nolocked;
                $raportiNotaveStudent->paraqit_prezent = Input::get('paraqit_prezent.' . $i);
                $raportiNotaveStudent->save();
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

    public function convertDateToExamsDate($month) {
        if ($month >= Enum::january && $month < Enum::april) {
            return Enum::january;
        } elseif ($month >= Enum::april && $month < Enum::june) {
            return Enum::april;
        } elseif ($month >= Enum::june && $month < Enum::september) {
            return Enum::june;
        } elseif ($month >= Enum::september && $month < Enum::november) {
            return Enum::september;
        } elseif ($month >= Enum::november) {
            return Enum::november;
        }
    }

    /**
     * Save new report grade for student
     * @return 
     */
    public function postAddRaportiNotave() {
//        return Input::all();
        $raportiNotave = new RaportiNotave;
        $raportiNotave->idl = Input::get('idl');
        $raportiNotave->prof = Input::get('prof');
        $raportiNotave->data_provimit = date("Y-m-d H:i:s", strtotime(Input::get('data_provimit')));
        $raportiNotave->afati_provimit = self::convertDateToExamsDate(date("m", strtotime(Input::get('data_provimit'))));
        $raportiNotave->statusi_studentve = Input::get('statusi_studentve');
        $raportiNotave->locked = Enum::nolocked;
        $raportiNotave->save();
        for ($i = 0; $i < count(Input::get('uid')); $i++) {
            $raportiNotaveStudent = null;
            if (!empty(Input::get('uid.' . $i))) { 
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
        }

        // not completed



        return Redirect::to('/smps/admin/provimet/add-raporti-notave');
    }

}
