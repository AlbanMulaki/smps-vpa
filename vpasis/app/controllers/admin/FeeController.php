
<?php

class FeeController extends \BaseController {

    public function getIndex() {
        $pagesat = Pagesat::where('deleted', '=', Enum::notdeleted)->orderBy('created_at', 'DESC')->paginate(25);
        return View::make('admin/pagesat/index', ['pagesat' => $pagesat]);
    }

    public function postRegister() {

        $rules = array('paguesi' => "required",
            "emri_bankes" => "required",
            "pershkrimi" => "required",
            "shuma" => "required",
            'data' => 'required');


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

    /**
     * Edit data of fee
     * @param type $id
     * @return type
     */
    public function getEdit($id) {
        $pagesa = Pagesat::find($id);
        return View::make('admin.pagesat.edit', ['pagesa' => $pagesa]);
    }

    /**
     * Update date of fee
     * @param type $id
     * @return type
     */
    public function postEdit() {
        $pagesa = Pagesat::find(Input::get('id'));
        $pagesa->paguesi = Input::get('paguesi');
        $pagesa->emri_bankes = Input::get('emri_bankes');
        $pagesa->pershkrimi = Input::get('pershkrimi');
        $pagesa->tipi = Input::get('tipi');
        $pagesa->shuma = Input::get('shuma');
        $pagesa->data = Input::get('data');
        $pagesa->save();
        
        return Redirect::action('StudentController@getProfile',array($pagesa->paguesi))->with(['message' => Enum::successful, "reason" => Lang::get('warn.success_update')]);
    }

}
