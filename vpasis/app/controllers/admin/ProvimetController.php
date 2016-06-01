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

    /**
     * 
     * Delete student from report grade
     * @param type $idraportit
     * @param type $idstudenti
     * @return type
     */

    public function getDeleteStudent($idraportit, $idstudenti) {
        RaportiNotaveStudent::where('studenti', '=', $idstudenti)
                ->where('idraportit', '=', $idraportit)
                ->delete();
        return Redirect::back();
    }
    
    /**
     * Delete report grade with all students on it
     * @param type $idraportit
     * @return type
     */
    
    
    public function getDeleteReportGrade($idraportit) {
        $raportiNotave = RaportiNotave::find($idraportit);
        foreach($raportiNotave->raportiNotaveStudent as $value){
            $value->delete();
        }
        $raportiNotave->delete();
        return Redirect::back()->with('message',Enum::successful)->with('reason',Lang::get('warn.succes_report_grade_deleted',['id'=>$idraportit]));
    }
    
    /**
     * Lock report grade
     * @param type $idraportit
     * @return type
     */

    public function getLockReportGrade($idraportit) {
        RaportiNotave::where('id', $idraportit)
                ->update(array('locked'=>Enum::locked));
        return Redirect::back()->with('message',Enum::successful);
    }
    
    /**
     * Get list of students included on report grade based on id of report grade
     * @param type $idraportit
     * @return type
     */
    public function getRegisterNotat($idraportit) {
        $raporti = RaportiNotave::find($idraportit);
        return View::make('admin.provimet.regjistrimi_raportit_notave', ['raporti' => $raporti]);
    }
    
    /**
     * Update report of grade
     * @return type
     */

    public function postUpdateReport() {

        $raportiNotave = RaportiNotave::find(Input::get('idraportit'));
        $i = 0;
        $userDoesntExistError = [];
        for ($i = 0; $i < count(Input::get('uid')); $i++) {
            $uid = Input::get('uid.' . $i);
            //If uid isset
            if($uid == ""){
                continue;
            }
            $doesStudentExist = RaportiNotaveStudent::where('idraportit', Input::get('idraportit'))
                    ->where('studenti', $uid)
                    ->first();
            //If student id doesnt exist return save for error
            if($doesStudentExist == NULL){
                $userDoesntExistError[] = $uid;
                continue;
            }
            
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
        return Redirect::back()->withErrors($userDoesntExistError,'userDoesntExistError');
    }
    /**
     * Print report of grade based id,and print type
     * @param type $idraportit
     * @param type $print
     * @return PDF File, print
     */
    public function getPrintReportNotat($idraportit,$print=false) {
        $raportiNotave = RaportiNotave::find($idraportit);
        $pdf = PDF::loadView('admin.provimet.print_raporti_notave', [ 'title' => Lang::get('printable.title_report_grade'),
                    'raportiNotave' => $raportiNotave])->setOrientation('landscape');
        if($print){
            return $pdf->download("RaportiNotave-".$raportiNotave->id.".pdf");
        }
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
     * Convert DateToExams
     * @param type $month
     * @return type
     */

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
                $raportiNotaveStudent->paraqit_prezent = Input::get('paraqit_prezent.' . $i);
                $raportiNotaveStudent->save();
            }
        }
        return Redirect::to(action('ProvimetController@getRegisterNotat',[$raportiNotave->id]));
    }

}
