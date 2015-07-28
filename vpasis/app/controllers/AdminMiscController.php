<?php

class AdminMiscController extends BaseController {

    public function postLendet() {
        $lendet = Lendet::getComboLendetAll(Input::get('drejtimi'));
        return Form::select('crs', $lendet, current($lendet), array('class' => 'form-control', 'id' => 'crs'))
                . '</div>';
    }

    public function postVijushmeria() {
        $rules = array('');
        foreach (Input::get('student') as $value) {
            $prof = Notimet::where('studenti', '=', $value)->where('idl', '=', Input::get('crs'))->get();
            try {
                $save = new Vijushmeria();
                $save->studenti = $value;
                $save->uid = Session::get('uid');
                $save->idl = Input::get('crs');
                $save->professor = $prof[0]['professori'];
                $save->locksem = 0;
                $save->deleted = 0;
                $save->save();
            } catch (Exception $e) {
                $this->error .= "<span class=\"label label-default\" >" . $value . "</span><br>";
                Session::flash('notification', self::getErrorMsg(Lang::get('warn.error_vijushmeria') . $this->error));
            }
        }
        Session::flash('notification', self::getErrorMsg(Lang::get('warn.success_register')));

        return Redirect::back()->withInput();
    }

}
