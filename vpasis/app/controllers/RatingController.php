<?php

class RatingController extends BaseController {

    public function postListpyetjet() {
        $question = Rating::where('type', '=', Input::get('typepyetjet'))
                ->where('deleted','=',Enum::notdeleted)
                ->get();
        return View::make('admin.rating.listpyetjet', ['question' => $question, 'i' => 0,'type'=>Input::get('typepyetjet')]);
    }

    public function getIndex() {
        $top = Ratingpoll::all();
        foreach ($top as $value) {
            
        }
        $drejtimet_pre = Drejtimet::all();
        $drejtimet = array();
        foreach ($drejtimet_pre as $value) {
            $drejtimet[$value['idDrejtimet']] = $value['Emri'];
        }
        return View::make('admin.rating.index', ['drejtimet' => $drejtimet]);
    }

    public function postLendet() {
        $lendet_pre = Lendet::where('Drejtimi', '=', Input::get('drejtimi'))->get();
        $lendet = array();
        foreach ($lendet_pre as $value) {
            $lendet[$value['idl']] = $value['Emri'];
        }
        return Form::select('lendet', $lendet, null, array('id' => 'lendet', 'class' => 'form-control'));
    }

    public function postCreate() {
        $rules = array('type' => 'required|numeric',
            'question' => 'required');
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            $rating = new Rating();
            $rating->type = Input::get('type');
            $rating->question = Input::get('question');
            $rating->save();
            return Redirect::to('/smps/admin/rating')->with('notification', self::getSucmsg(Lang::get('warn.success_register')));
        } else {
            return Redirect::to('/smps/admin/rating')->with('notification', self::getErrormsg(Lang::get('warn.error_undefined')));
        }
    }

    public function postUpdate() {
        $rules = array('question' => 'required',
            'type' => 'required');
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            $update = array('question' => Input::get('question'), 'type' => Input::get('type'));

            Rating::where('id', '=', Input::get('id'))->update($update);

            return Redirect::back()->with('notification', self::getSucmsg(Lang::get('warn.success_editcourse')));
        } else {
            return Redirect::back()->with('notification', self::getErrormsg(Lang::get('warn.error_undefined')));
        }

        return null;
    }

    public function postDelete() {
        $rules = array(
            'id' => 'required|numeric');
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            $update = array('deleted' =>Enum::deleted, 'type' => Input::get('type'));
            Rating::where('id', '=', Input::get('id'))->update($update);
            return Redirect::back()->with('notification', self::getSucmsg(Lang::get('warn.success_delete_course')));
        } else {
            return Redirect::back()->with('notification', self::getErrormsg(Lang::get('warn.error_undefined')));
        }

        return null;
    }
	// print ratings questions
	public function Printprof(){
		$questions = Rating::where('type','=','2')->where('deleted','=','0')->get();
        $pdf = PDF::loadView('admin.rating.print_prof_questions', [ 'title' => null,'i'=>1,'questions'=>$questions]);

        file_put_contents(self::printdir('Rating_prof', Session::get('uid')), $pdf->output());
        return $pdf->download(self::printdir('Orari', Session::get('uid')));
	}


}
