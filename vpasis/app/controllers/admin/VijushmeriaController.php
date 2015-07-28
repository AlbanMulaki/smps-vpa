<?php

class VijushmeriaController extends \BaseController {

    public function postRegisterVijushmeria() {
        $student = Input::get('vijushmeria');

        $rules = array(
            'drejtimi' => "required",
            "idl" => "required",
            "professor" => "required|numeric",
            "ora" => "required",
            "data" => "required"
        );
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            foreach ($student as $value) {
                $add = new Vijushmeria();
                $add->studenti = $value;
                $add->uid = Session::get('uid');
                $add->idl = Input::get('idl');
                $add->professor = Input::get('professor');
                $add->drejtimi = Input::get('drejtimi');
                $add->ora = Input::get('ora');
                $add->data = Input::get('data');
                $dep = Drejtimet::where('idDrejtimet', '=', Input::get('drejtimi'))->get();
                $add->departmenti = $dep[0]['idd'];
                $add->semestri = Input::get('semestri');
                $add->save();
            }

            return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.success_register_attendance')]);
        }
        return Redirect::back()->with(['message' => Enum::failed, "reason" => Lang::get('warn.error_undefined')]);
    }

    public function getVijushmeria($drejtimi = 0, $semestri = 0) {
        $drejtimet = Drejtimet::getComboDrejtimetGroupedAll();
        $lendet = array('');
        if ($drejtimi > 0) {
            $lendet = Lendet::getComboLendetAll($drejtimi);
        }
        $students = array();
        if ($semestri > 0 && $drejtimi > 0) {
            $students = Studenti::where('semestri', '=', $semestri)
                    ->where('drejtimi', '=', $drejtimi)
                    ->where('locked', '=', Enum::nolocked)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->get();
            $professor = ProfLendet::join('vpa_smps.administrata', 'vpa_smps.administrata.uid', '=', 'prof_lendet.professor')
                    ->where('drejtimi', '=', $drejtimi)
                    ->where('prof_lendet.deleted', '=', Enum::notdeleted)
                    ->get();
        } else if ($drejtimi > 0) {
            $students = Studenti::where('locked', '=', Enum::nolocked)
                    ->where('drejtimi', '=', $drejtimi)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->get();
            $professor = ProfLendet::join('vpa_smps.administrata', 'vpa_smps.administrata.uid', '=', 'prof_lendet.professor')
                    ->where('drejtimi', '=', $drejtimi)
                    ->where('prof_lendet.deleted', '=', Enum::notdeleted)
                    ->get();
        } else {
            $students = array();
            $professor = array();
        }

        $professorCmb = array();
        foreach ($professor as $value) {
            $professorCmb[$value['uid']] = $value['emri'] . ' ' . $value['mbiemri'];
        }
        return View::make('admin.students.vijushmeria.index', [
                    'drejtimet' => $drejtimet,
                    "selDrejtimi" => $drejtimi,
                    'lendet' => $lendet,
                    'semestri' => $semestri,
                    'students' => $students,
                    "professor" => $professorCmb
        ]);
    }

}
