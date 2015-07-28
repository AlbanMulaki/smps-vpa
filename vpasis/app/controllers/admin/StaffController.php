<?php
class StaffController extends \BaseController {

    public function getRegister() {
        return View::make('admin.puntoret.register_staff');
    }

    public function postRegister() {
        $rules = array(
            'emri' => "required",
            "mbiemri" => "required",
            "gjinia" => "required|numeric",
            "nrpersonal" => "required|numeric",
            "detyra" => "required|numeric"
        );

        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            // kontrollimi avatar
            $avatar = "";
            if (Input::file('avatar')) {
                $destination = $_SERVER['DOCUMENT_ROOT'] . "/smpsfl/doc/avatar/";
                $avatar = Input::get('emri') . Input::get('mbiemri') . "_" . date('Y_m_d_(H_i_s)') . '_' . Session::get('uid') . '_' . str_random(4) . '.' . Input::file('avatar')->getClientOriginalExtension();
                Input::file('avatar')->move($destination, $avatar);
            } else {
                $avatar = "default-avatar.png";
            }
            // kontrollimi cv
            $cv = "";
            if (Input::file('cv')) {
                $destination = $_SERVER['DOCUMENT_ROOT'] . "/smpsfl/doc/cv/";
                $cv = Input::get('emri') . Input::get('mbiemri') . "_" . date('Y_m_d_(H_i_s)') . '_' . Session::get('uid') . '_' . str_random(4) . '.' . Input::file('cv')->getClientOriginalExtension();
                Input::file('cv')->move($destination, $cv);
            }

            $administrata = new Admin();
            $administrata->emri = ucwords(Input::get('emri'));
            $administrata->mbiemri = ucwords(Input::get('mbiemri'));
            $administrata->gjinia = Input::get('gjinia');
            $administrata->vendlindja = ucwords(Input::get('vendlindja'));
            $administrata->vendbanimi = ucwords(Input::get('vendbanimi'));
            $administrata->datalindjes = Input::get('datalindjes');
            $administrata->adressa = ucwords(Input::get('adressa'));
            $administrata->shtetas = ucwords(Input::get('shtetas'));
            $administrata->telefoni = Input::get('telefoni');
            $administrata->email = Input::get('email');
            $administrata->nrpersonal = Input::get('nrpersonal');
            $administrata->password = Hash::make(Input::get('nrpersonal'));
            $administrata->xhirollogaria = Input::get('xhirollogaria');
            $administrata->avatar = $avatar;
            $administrata->detyra = Input::get('detyra');
            $administrata->grp = Input::get('detyra');
            $administrata->grada_shkencore = Input::get('grada_shkencore');
            $administrata->eksperienca = ucwords(Input::get('eksperienca'));
            $administrata->kualifikimi = ucwords(Input::get('kualifikimi'));
            $administrata->bank_name = ucwords(Input::get('bank_name'));
            $administrata->cv = $cv;
            $administrata->vpa_registrar = Session::get('uid');
            $administrata->save();
            // redirekt to profile


            return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.success_register_administration', array('person' => ucwords(Input::get('emri') . " " . Input::get('mbiemri'))))]);
        }
        return Redirect::back()->with(['message' => Enum::failed, "reason" => Lang::get('warn.error_undefined')]);
    }

    /*
     * Afishon listen e staffit
     */

    public function getDisplayStaff() {

        $staff = Admin::getListStaff();

        return View::make('admin.puntoret.list_staff', [
                    'staff' => $staff
        ]);
    }

    public function getProfile($idstaff) {
        $profile = Admin::where('uid', '=', $idstaff)->where('deleted', '=', Enum::notdeleted)->get();
        return View::make('admin.puntoret.profile', ['profile' => $profile[0]]);
    }

    public function postUpdate() {
        $rules = array(
            'uid' => "required",
            'emri' => "required",
            "mbiemri" => "required",
            "gjinia" => "required|numeric",
            "nrpersonal" => "required|numeric",
            "detyra" => "required|numeric"
        );

        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            // kontrollimi avatar
            if (Input::file('avatar')) {
                $destination = $_SERVER['DOCUMENT_ROOT'] . "/smpsfl/doc/avatar/";
                $avatar = Input::get('emri') . Input::get('mbiemri') . "_" . date('Y_m_d_(H_i_s)') . '_' . Session::get('uid') . '_' . str_random(4) . '.' . Input::file('avatar')->getClientOriginalExtension();
                Input::file('avatar')->move($destination, $avatar);
            } else {
                $avatar = Input::get('avatarname');
            }
            // kontrollimi cv
            if (Input::file('cv')) {
                $destination = $_SERVER['DOCUMENT_ROOT'] . "/smpsfl/doc/cv/";
                $cv = Input::get('emri') . Input::get('mbiemri') . "_" . date('Y_m_d_(H_i_s)') . '_' . Session::get('uid') . '_' . str_random(4) . '.' . Input::file('cv')->getClientOriginalExtension();
                Input::file('cv')->move($destination, $cv);
            } else {
                $cv = Input::get('cvname');
            }
            $update = array(
                "emri" => ucwords(Input::get('emri')),
                "mbiemri" => ucwords(Input::get('mbiemri')),
                "gjinia" => ucwords(Input::get('gjinia')),
                "vendlindja" => ucwords(Input::get('vendlindja')),
                "vendbanimi" => ucwords(Input::get('vendbanimi')),
                "datalindjes" => ucwords(Input::get('datalindjes')),
                "adressa" => ucwords(Input::get('adressa')),
                "shtetas" => ucwords(Input::get('shtetas')),
                "telefoni" => ucwords(Input::get('telefoni')),
                "email" => Input::get('email'),
                "nrpersonal" => Input::get('nrpersonal'),
                "xhirollogaria" => ucwords(Input::get('xhirollogaria')),
                "avatar" => $avatar,
                "detyra" => ucwords(Input::get('detyra')),
                "grp" => ucwords(Input::get('detyra')),
                "grada_shkencore" => ucwords(Input::get('grada_shkencore')),
                "eksperienca" => ucwords(Input::get('eksperienca')),
                "kualifikimi" => ucwords(Input::get('kualifikimi')),
                "bank_name" => ucwords(Input::get('bank_name')),
                "cv" => $cv
            );
            Admin::where('uid', '=', Input::get('uid'))->update($update);
            return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.success_update')]);
        }
        return Redirect::back()->with(['message' => Enum::failed, "reason" => Lang::get('warn.error_undefined')]);
    }

    public function getPrintPdfDirect() {
        $listStaff = Admin::where('deleted', '=', Enum::notdeleted)->get();
        $pdf = PDF::loadView('admin.puntoret.print_list_staff', [ 'title' => Lang::get('printable.title_list_staff'),
                    'listStaff' => $listStaff]);
        return $pdf->stream();
    }

    public function getPrintPdf() {
        $listStaff = Admin::where('deleted', '=', Enum::notdeleted)->get();
        $pdf = PDF::loadView('admin.puntoret.print_list_staff', [ 'title' => Lang::get('printable.title_list_staff'),
                    'listStaff' => $listStaff]);
        file_put_contents(self::printdir('ListStaffit', null, Session::get('uid')), $pdf->output());
        return $pdf->download(self::printdir('ListStaffit', null, Session::get('uid')));
    }

}
