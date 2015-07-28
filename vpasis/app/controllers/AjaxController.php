<?php

class AjaxController extends BaseController {
    /*
     * |-------------------------------------------------------------------------- | Return Lendet |-------------------------------------------------------------------------- |@ Return @var | input Drejtimin |
     */

    private $script;

    public function getPrintParaqitur() {
        $paraqitja = Notimet::join('studenti', 'studenti.uid', '=', 'notimet.studenti')
                ->where('paraqitja', '=', Enum::paraqitur)
                ->where('idl', '=', Input::get('crs'))
                ->where('notimet.grp', '=', Enum::grupiA)
                ->select(DB::raw("CONCAT(studenti.emri,' ',studenti.mbiemri) as studenti"), 'notimet.grp', 'studenti.semestri as semestri', 'studenti.uid', 'notimet.paraqitja')
                ->get();
        $pdf = PDF::loadView('admin.provimet.print_paraqitura', ['i' => 0,
                    'paraqitja' => $paraqitja,
                    'title' => Lang::get('general.exams_list_apply'), 't' => Input::get('crs')]);
        return $pdf->download(self::printdir('Lista_provimev_' . Input::get('crs'), str_random(5)));
    }

    public function postProvimVijushmeri() {
        $paraqitura = Notimet::where('paraqitja', '=', Enum::paraqitur)
                ->where('idl', '=', Input::get('lenda'))
                ->where('notimet.grp', '=', Enum::grupiA)
                ->where('paraqitja', '=', '1')
                ->where('studenti', '=', Input::get('studenti'))
                ->update(array('paraqitja' => Enum::paraqiturprezent));
        return Input::all();
    }

    public function postResetpass() {
        $rules = array('oldp' => 'required',
            'newp' => 'required',
            'confnewp' => 'required');
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            $pass = Admin::where('uid', '=', Session::get('uid'))
                    ->select('password')
                    ->get();
            if (Input::get('confnewp') == Input::get('newp')) {
                if (Hash::check(Input::get('oldp'), $pass[0]['password'])) {
                    if (Input::get('newp') == Input::get('confnewp')) {
                        $update = array('password' => Hash::make(Input::get('newp')));
                        Admin::where('uid', '=', Session::get('uid'))->update($update);
                        return "<div class=\"alert alert-success\" role=\"alert\"> " . Lang::get('warn.success_resetpass') . "</div>";
                    }
                } else {
                    return "<div class=\"alert alert-danger\" role=\"alert\"> " . Lang::get('warn.warning_resetpass') . "</div>";
                }
            } else {
                return "<div class=\"alert alert-danger\" role=\"alert\"> " . Lang::get('warn.warning_confirmpass') . "</div>";
            }
        } else {
            return "Error";
        }
    }

// Afishon listen e studenteve te cilet kan paraqitur provimin
    public function postLendetprov() {
        $paraqitja = Notimet::join('studenti', 'studenti.uid', '=', 'notimet.studenti')
                ->where('paraqitja', '>=', Enum::paraqitur)
                ->where('idl', '=', Input::get('crs'))
                ->where('notimet.grp', '=', Enum::grupiA)
                ->select(DB::raw("CONCAT(studenti.emri,' ',studenti.mbiemri) as studenti"), 'notimet.grp', 'studenti.uid', 'notimet.paraqitja')
                ->get();
        return View::make('admin.provimet.p_paraqitura', ['i' => 0, 'paraqitja' => $paraqitja]);
    }

    public function postDrejtimet() {
        $lendet = Lendet::where('Drejtimi', '=', Input::get('drejtimi'))->get();
        if (count($lendet) > 0) {
            foreach ($lendet as $val) {
                $lendethtml[$val ['idl']] = $val ['Emri'];
            }

            self::nestajax("#lendetin", "#prof", "/smps/admin/ajax/lopac");
            return View::make('admin.input.olendet', ['lendethtml' => $lendethtml,
                        'script' => $this->script,
                        'formid' => 'form1']);
        } else {
            return "<div class=\"input-group\"><div class=\"input-group-addon\">" .
                    Form::label('lendet', Lang::get('general.course')) .
                    "</div>" .
                    Form::select('null', array('0' => Lang::get('general.null')), null, array('class' => 'form-control', 'disabled')) . "
     		</div><br><div id=\"prof\"><div class=\"input-group\"><div class=\"input-group-addon\">" .
                    Form::label('lendet', Lang::get('general.professor')) .
                    "</div>" .
                    Form::select('null', array('0' => Lang::get('general.null')), null, array('class' => 'form-control', 'disabled'))
                    . "</div></div>";
        }
    }

    /*
     * |-------------------------------------------------------------------------- | Return Listen e orarit |-------------------------------------------------------------------------- |@ Return View::make | input Drejtimin |
     */

    public function postListorari() {
        $orari = Orari::join('lendet', 'lendet.idl', '=', 'orari.idl')->join('drejtimet', 'drejtimet.idDrejtimet', '=', 'orari.idd')->join('administrata', 'administrata.uid', '=', 'orari.uid')->where('orari.idd', '=', Input::get('drejtimetlist'))->where('locked', '=', '0')->select(DB::raw('CONCAT(administrata.Emri," ",administrata.Mbiemri) as Prof'), 'drejtimet.Emri as DrejtimiEmri', 'lendet.Emri as Landa', 'orari.uid AS Ouid', 'dita', 'ora', 'idOrari', 'orari.idd')->orderBy('dita', 'ASC')->get();
        $drejtimet = array(
            ''
        );

        foreach (Drejtimet::all() as $value) {
            $drejtimet [$value ['idDrejtimet']] = $value ['Emri'];
        }
        $lendet = array();
        foreach (Lendet::where('Drejtimi', '=', Input::get('drejtimetlist'))->get() as $value) {
            $lendet [$value ['idl']] = $value ['Emri'];
        }
        return View::make('admin.orari.edit', [
                    'orari' => $orari,
                    'drejtimet' => $drejtimet,
                    'lendet' => $lendet
        ]);
    }

    /*
     * |-------------------------------------------------------------------------- | Prof Active Course |-------------------------------------------------------------------------- |@ Return View::make | input idl |-------------------------------------------------------------------------- | Kthen professorat qe jan te active ne landen e caktume |
     */

    public function postLopac() {
        $i = - 1;
        $pre_prof = AssignProf::join('administrata', 'administrata.uid', '=', 'assign_prof.uid')
                ->select(DB::raw('CONCAT(administrata.Emri," ",administrata.Mbiemri) as EmriProf'), 'administrata.uid as uid')
                ->where('idl', '=', Input::get('lendet'))
                ->where('deleted', '=', Enum::notdeleted)
                ->get();

        foreach ($pre_prof as $value) {
            $prof [$value['uid']] = $value ['EmriProf'];

            $i ++;
        }

        if ($i == - 1) {
            $nulltemp = "<div class=\"input-group\"><div class=\"input-group-addon\">";
            $nulltemp .= Form::label('lendet', Lang::get('general.professor'));
            $nulltemp .=" </div>";
            $nulltemp .= Form::select('prof', array('0' => Lang::get('general.null')), null, array('class' => 'form-control', 'disabled'));
            $nulltemp .= "</div>";
            return $nulltemp;
        } else {
            $nulltemp = "<div class=\"input-group\"><div class=\"input-group-addon\">";
            $nulltemp .= Form::label('lendet', Lang::get('general.professor'));
            $nulltemp .=" </div>";
            $nulltemp .= Form::select('prof', $prof, current($prof), array('class' => 'form-control'));
            $nulltemp .= "</div>";
            return $nulltemp;
        }
    }

    private function nestajax($listen, $put, $dir, $method = "POST") {
        $this->script = "<script>  $('" . $listen . "').change(function(e){
		 e.preventDefault();
				var dataString = $('" . $listen . "').serialize();
				$.ajax({
						type: \"" . $method . "\",
						 
						url:\"" . $dir . "\",
						data: dataString,
						success: function(data){console.log(data);
						 
						$('.succesupd').modal('show');
						$('" . $put . "').empty().append(data);
						}
						},
			   \"json\");
		
				});</script>";
    }

    public function postListprovimet() {
        $provimet = Provimet::where('provimet.drejtimi', '=', Input::get('drejtimetlist'))
                ->join('lendet', 'lendet.idl', '=', 'provimet.idl')
                ->join('administrata', 'administrata.uid', '=', 'provimet.profid')
                ->where('locked', '=', 0)
                ->where('provimet.grp', '=', 0)
                ->select('lendet.Emri', DB::raw('CONCAT(administrata.Emri," ",administrata.Mbiemri) AS Prof'), DB::raw('DATE_FORMAT(`data`," %Y-%m-%d - %H:%i") AS data'), 'lendet.Semestri', 'provimet.idprovimet')
                ->get();
        return View::make('admin.provimet.edit', ['provimet' => $provimet]);
    }

}
