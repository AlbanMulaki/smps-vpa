
<?php

class FeeController extends \BaseController {

    public function getIndex() {
        $pagesat = Pagesat::where('deleted','=',Enum::notdeleted)->orderBy('created_at','DESC')->paginate(25);
        return View::make('admin/pagesat/index', ['pagesat' => $pagesat]);
    }

    public function postRegister() {

        $rules = array('paguesi' => "required",
            "emri_bankes" => "required",
            "pershkrimi" => "required",
            "shuma" => "required",
            'data'=>'required');


        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            $new = new Pagesat();
            $new->paguesi = Input::get('paguesi');
            $new->emri_bankes = Input::get('emri_bankes');
            $new->pershkrimi = Input::get('pershkrimi');
            $new->tipi = Input::get('tipi');
            $new->shuma = Input::get('shuma');
            $new->data = Input::get('data');
            $new->save();
            return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.succes_register_fee')]);
        }
        return Redirect::back()->with(['message' => Enum::failed, "reason" => Lang::get('warn.error_undefined')]);
    }

}
