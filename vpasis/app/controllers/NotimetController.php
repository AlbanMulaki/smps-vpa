<?php

class NotimetController extends BaseController {

    public function getIndex() {
        $drejtimet = Drejtimet::all();
        $dre = array('');
        $lendet = array('');
        foreach ($drejtimet as $val) {
            $dre[$val['idDrejtimet']] = $val['Emri'];
        }
        return View::make('admin.notimet.index', ['title' => Lang::get('header.title_register_grade'), 'drejtimet' => $dre, 'lendet' => $lendet]);
    }

    public function getStore() {

        // Munges duhet me i kriju validatori
        $rule = array('lendet' => 'required',
            'drejtimi' => 'required',
            'nota' => 'required',
            'uid' => 'required|numeric'
        );
        $valid = Validator::make(Input::all(), $rule);
        $idraportit = Notimet::select(DB::raw('MAX(`idraportit`) as idraportit'))->get();
        $notat = Input::get('nota');
        $uid = Input::get('uid');

        for ($i = 0; $i < count(Input::get('nota')); $i++) {
            Notimet::where('studenti', '=', $uid[$i])
                    ->where('idl', '=', Input::get('lendet'))
                    ->where('locked', '=', 0)
                    ->update(array('locked' => 1,
                        'nota' => $notat[$i],
                        'idraportit' => $idraportit[0]['idraportit'] + 1));
        }

        $raporti = Notimet::join('studenti', 'studenti.uid', '=', 'notimet.studenti')
                ->join('administrata', 'administrata.uid', '=', 'notimet.professori')
                ->join('lendet', 'lendet.idl', '=', 'notimet.idl')
                ->select(DB::raw("CONCAT(administrata.`emri`,' ',administrata.`mbiemri`) as Prof "), DB::raw("CONCAT(studenti.`emri`,' ',studenti.`mbiemri`) as Student "), "studenti.uid as Suid ", 'notimet.idraportit', 'nota', 'lendet.Emri as Lendet')
                ->where('idraportit', '=', $idraportit[0]['idraportit'] + 1)
                ->get();
        if($raporti != null){
        $pdf = PDF::loadView('admin.notimet.raportiRegjsitrimi', ['title' => Lang::get('printable.report_grades'),
                    'raporti' => $raporti, 'i' => 0])->setOrientation('landscape');
        return $pdf->download("raporti_notave" . date('Y') . $idraportit[0]['idraportit'] + 1 . '.pdf');
        } else {
            return "Error, Provoni perseri";
        }
    }

    public function postLendet() {
        $lendet = Lendet::where('Drejtimi', '=', Input::get('drejtimi'))->get();

        $lendet_ready = array();
        foreach ($lendet as $val) {
            $lendet_ready[$val['idl']] = $val['Emri'];
        }
        return Form::select('lendet', $lendet_ready, $lendet[0]['idl'], array('class' => 'form-control', 'id' => 'lendet'));
    }

    public function getRaport() {
        $notimet = Notimet::where('idraportit', '=', Input::get('notimetidrpt'))
                ->join('lendet', 'lendet.idl', '=', 'notimet.idl')
                ->join('administrata', 'administrata.uid', '=', 'notimet.professori')
                ->join('studenti', 'studenti.uid', '=', 'notimet.studenti')
                ->select(DB::raw("CONCAT(administrata.`Emri`,' ',administrata.`Mbiemri`) as Prof"), DB::raw("lendet.emri as Landa"), 'nota', 'refuzimi', DB::raw("CONCAT(studenti.`emri`,' ',studenti.`mbiemri`) as Studenti"))
                ->get();

        $pdf = PDF::loadView('admin.notimet.raporti', ['title' => Lang::get('printable.report_grades'),
                    'notimet' => $notimet])->setOrientation('landscape');
        return $pdf->download("raporti_notave" . date('Y') . '.pdf');
    }

}
