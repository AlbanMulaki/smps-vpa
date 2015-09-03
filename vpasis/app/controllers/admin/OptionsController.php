<?php

class OptionsController extends \BaseController {

    public function getIndex() {
        $settings = Settings::getAllSettings();
        return View::make('admin/options/index', [
                    'settings' => $settings
        ]);
    }

    /*
     * 
     * Perditesimi i operacioneve
     * 
     */

    public function postUpdateOptions() {


        $rule = array('name_company' => 'required',
            'adressa' => 'required',
            'phone' => 'required',
            'info_email' => 'required',
            'support_email' => 'required',
            'website' => 'required',
            'provim_active' => 'required'
        );
        $valid = Validator::make(Input::all(), $rule);

        if ($valid->passes()) {
            $update = array('name_company' => Input::get('name_company'),
                'adressa' => Input::get('adressa'),
                'phone' => Input::get('phone'),
                'info_email' => Input::get('info_email'),
                'support_email' => Input::get('support_email'),
                'website' => Input::get('website'),
                'provim_active' => Input::get('provim_active')
            );
            // update logo
            if (Input::hasFile('logo')) {
                $destination = $_SERVER['DOCUMENT_ROOT'] . '/img/';
                $logo = str_random(20) . date('Y_m_d_(H_i_s)') . '.' . Input::file('logo')->getClientOriginalExtension();
                Input::file('logo')->move($destination, $logo);
                // $logo = logo.png
                $update['logo'] = $logo;
            }
            Settings::where('id', '=', '1')->update($update);
            return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.success_update')]);
        } else {
            return Redirect::back()->with(['message' => Enum::failed, "reason" => Lang::get('warn.error_undefined')]);
        }
    }

}
