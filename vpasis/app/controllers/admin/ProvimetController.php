<?php

class ProvimetController extends \BaseController {

    /**
     * Filtrimi raportit te notave dhe kerkimi ne baz te id
     * @param type year
     * @param type month
     * @param type reportSearchId
     * @param type drejtimi
     * @return view
     */
    public function getRaportiNotave() {
        $year = 0;
        $month = 0;
        $drejtimi = 0;
        $year = Input::get('year');
        $month = Input::get('month');
        $drejtimi = Input::get('drejtimi');
        $reportSearchId = Input::get('reportSearchId');

        $drejtimet = Drejtimet::getComboDrejtimetGroupedAll();
        if ($reportSearchId > 0) {
            $raportet = RaportiNotave::where('id', 'like', '%' . $reportSearchId . '%')
                    ->orderBy('id', 'DESC')
                    ->paginate(15);

            return View::make('admin.provimet.raporti_notave', ['drejtimi' => $drejtimet,
                        'raportet' => $raportet]);
        } else if ($year == 0 && $month == 0 && $drejtimi == 0) {
            $raportedEFundit = RaportiNotave::orderBy('id', 'DESC')->paginate(15);
            return View::make('admin.provimet.raporti_notave', ['drejtimi' => $drejtimet,
                        'raportet' => $raportedEFundit]);
        } else {
            $raportet = RaportiNotave::query();
            if ($year > 0) {
                $raportet->where('data_provimit', 'like', $year . '%');
            }
            if ($month > 0) {
                $raportet->where('afati_provimit', $month);
            }
            if ($drejtimi > 0) {
                $raportet->join('lendet', 'lendet.idl', '=', 'raporti_notave.idl');
                $raportet->where('lendet.Drejtimi', $drejtimi);
            }
            return View::make('admin.provimet.raporti_notave', ['drejtimi' => $drejtimet,
                        'raportet' => $raportet->paginate(15),
                        'year' => $year,
                        'month' => $month,
                        'drejtimSel' => $drejtimi]);
        }
    }

    /**
     * 
     * Delete student from report grade
     * @param type $idraportit
     * @param type $idstudenti
     * @return redirect
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
     * @return redirect
     */
    public function getDeleteReportGrade($idraportit) {
        $raportiNotave = RaportiNotave::find($idraportit);
        foreach ($raportiNotave->raportiNotaveStudent as $value) {
            $value->delete();
        }
        $raportiNotave->delete();
        return Redirect::back()->with('message', Enum::successful)->with('reason', Lang::get('warn.succes_report_grade_deleted', ['id' => $idraportit]));
    }

    /**
     * Lock report grade
     * @param type $idraportit
     * @return redirect
     */
    public function getLockReportGrade($idraportit) {
        RaportiNotave::where('id', $idraportit)
                ->update(array('locked' => Enum::locked));
        return Redirect::back()->with('message', Enum::successful);
    }

    /**
     * Get list of students included on report grade based on id of report grade
     * @param type $idraportit
     * @return view
     */
    public function getRegisterNotat($idraportit) {
        $raporti = RaportiNotave::find($idraportit);
        return View::make('admin.provimet.regjistrimi_raportit_notave', ['raporti' => $raporti]);
    }

    /**
     * Update report of grade
     * @return redirect
     */
    public function postUpdateReport() {

        $raportiNotave = RaportiNotave::find(Input::get('idraportit'));
        $i = 0;
        $userDoesntExistError = [];
        for ($i = 0; $i < count(Input::get('uid')); $i++) {
            $uid = Input::get('uid.' . $i);
            //If uid isset
            if ($uid == "") {
                continue;
            }
            $doesStudentExist = RaportiNotaveStudent::where('idraportit', Input::get('idraportit'))
                    ->where('studenti', $uid)
                    ->first();
            $isStudent = Studenti::where('uid', $uid)->first();
            //If student id doesnt exist return save for error
            if ($doesStudentExist == NULL && $isStudent == NULL) {
                $userDoesntExistError[] = $uid;
                continue;
            }

            if ($doesStudentExist != NULL) {
                $doesStudentExist->studenti = Input::get('uid.' . $i);
                $doesStudentExist->testi_semestral = Input::get('testi_semestral.' . $i);
                $doesStudentExist->testi_gjysem_semestral = Input::get('testi_gjysemsemestral.' . $i);
                $doesStudentExist->nota = Input::get('nota.' . $i);
                $doesStudentExist->seminari = Input::get('seminari.' . $i);
                $doesStudentExist->pjesmarrja = Input::get('pjesmarrja.' . $i);
                $doesStudentExist->puna_praktike = Input::get('praktike.' . $i);
                $doesStudentExist->testi_final = Input::get('testi_final.' . $i);
                $doesStudentExist->refuzim = Input::get('refuzim.' . $i);
                $doesStudentExist->paraqit_prezent = Input::get('paraqit_prezent.' . $i);
                $doesStudentExist->save();
            } else if (is_numeric(Input::get('uid.' . $i))) {
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
                $raportiNotaveStudent->locked = Enum::nolocked;
                $raportiNotaveStudent->paraqit_prezent = Input::get('paraqit_prezent.' . $i);
                $raportiNotaveStudent->save();
            }
        }
        return Redirect::back()->withErrors($userDoesntExistError, 'userDoesntExistError');
    }

    /**
     * Print report of grade based id,and print type
     * @param type $idraportit
     * @param type $print
     * @return PDF File, print
     */
    public function getPrintReportNotat($idraportit, $print = false) {
        $raportiNotave = RaportiNotave::find($idraportit);
        $statsGrade = array(
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0
        );
        for ($i = 5; $i <= 10; $i++) {
            $tempStats = null;
            $tempStats = $raportiNotave->raportiNotaveStudent->filter(function($value) use($i) {
                if($value->nota == $i){
                    return $value;
                }
            });
            $statsGrade[$i] = $tempStats->count();
        }
        $abstenim = $raportiNotave->raportiNotaveStudent->filter(function($value){
                if($value->paraqit_prezent == Enum::NO){
                    return $value;
                }
            });
        $abstenim = $abstenim->count();
        $pdf = PDF::loadView('admin.provimet.print_raporti_notave', [ 'title' => Lang::get('printable.title_report_grade'),
                    'raportiNotave' => $raportiNotave,'statsGrade'=>$statsGrade,'abstenim'=>$abstenim])->setOrientation('landscape');
        if ($print) {
            return $pdf->download("RaportiNotave-" . $raportiNotave->id . ".pdf");
        }
        return $pdf->stream("RaportiNotave-" . $raportiNotave->id . ".pdf");
    }

    /**
     * Print report of grade based id,and print type
     * @param type $idraportit
     * @param type $print
     * @return PDF File, print
     */
    public function getAddRaportiNotave() {
        $raportiNotave = Lendet::getComboLendetAll();
        $prof = Admin::where('grp', Enum::prof)->orderBy('emri')->get();
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
     * @return redirect
     */
    public function postAddRaportiNotave() {
        $validator = Validator::make(Input::all(), array(
                    'statusi_studentve' => 'required',
                    'prof' => 'required|numeric',
                    'idl' => 'required|numeric',
                    'data_provimit' => 'required'
                        )
        );
        if ($validator->passes()) {
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
                    $raportiNotaveStudent->idl = Input::get('idl');
                    $raportiNotaveStudent->paraqit_prezent = Input::get('paraqit_prezent.' . $i);
                    $raportiNotaveStudent->save();
                }
            }
            return Redirect::to(action('ProvimetController@getRegisterNotat', [$raportiNotave->id]));
        } else {
            return Redirect::back()->withErrors($validator, 'validator');
        }
    }

}
