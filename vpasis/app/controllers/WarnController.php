<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WarnController
 *
 * @author Alban
 */
class WarnController extends BaseController {

    public function postKontrata($id) {
        $rules = array('shuma' => 'required|numeric',
            'desccont' => 'required');
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            $kontrata = new Kontratat();
            $kontrata->uid = $id;
            $kontrata->shuma = Input::get('shuma');
            $kontrata->pershkrimi = Input::get('desccont');
            $kontrata->logs = Session::get('uid');
            $kontrata->length = 3;
            $kontrata->type = 0;
            $kontrata->save();
        }

        return Redirect::to('/smps/admin/person/' . $id.'/edit');
    }


}
