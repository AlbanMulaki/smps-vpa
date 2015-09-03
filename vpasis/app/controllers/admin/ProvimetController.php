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

    public function postRegisterNotat() {
        echo "<pre>";
        print_r(Input::all());
    }

    public function getPrintReportNotat($idraportit) {


        $drejtimet = Drejtimet::getComboDrejtimetGroupedAll();
        $raporti = RaportiNotave::select('departmentet.Emri as departmenti','lendet.Emri as lenda', DB::raw("CONCAT(administrata.emri,' ',administrata.mbiemri) as prof"), "administrata.uid as profuid", "drejtimet.emri as drejtimi", "raporti_notave.data_provimit as data_provimit", "raporti_notave.id as idraportit","raporti_notave.viti_aka as viti_aka", "raporti_notave.locked as locked")
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

}
