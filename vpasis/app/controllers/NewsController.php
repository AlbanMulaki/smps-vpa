<?php

class NewsController extends BaseController {

    //Admin Side
    public function getIndex() {
        $pre_drejtimi = Drejtimet::get();
        $drejtimi = $pre_drejtimi->toArray();   // Konvertimi ne array

        $njoftimet = Njoftimet::where('deleted','=',Enum::notdeleted)->orderby('created_at', 'DESC')->get();
        return View::make('admin.news.index', ['title' => Lang::get('header.title_news'), 'drejtimi_arr' => $drejtimi, 'drejtimet' => $pre_drejtimi, 'njoftimet' => $njoftimet, 'i' => 0]);
    }

    public function postEdit() {
        return 'return';
    }
    public function postDelete(){
        $update = array('deleted' => Enum::deleted
        );
        Njoftimet::where('idnjoftimet', '=', Input::get('njftm'))->update($update);
        return Redirect::action('NewsController@getIndex');
    }

    public function postUpdate() {



        $rule = array('to' => 'required',
            'priority' => 'required',
            'msg' => 'required',
            'title' => 'required');
        if (empty(Input::get('dre')) == false) {
            if (in_array(Enum::student, Input::get('to'))) {

                $drejtimet = '@' . implode('@', Input::get('dre')) . '@';

                $semestri = '@' . implode('@', Input::get('sem')) . '@';
            }

            $rule['dre'] = 'required';
            $rule['sem'] = 'required';
        } else {
            $drejtimet = null;
            $semestri = null;
        }

        $tos = '@' . implode('@', Input::get('to')) . '@';
        $valid = Validator::make(Input::all(), $rule);

        if ($valid->fails())
            return 'Error: Validation';

        $update = array('uid' => Session::get('uid'),
            'idd' => $drejtimet,
            'titulli' => Input::get('title'),
            'msg' => Input::get('msg'),
            'semestri' => $semestri,
            'priority' => Input::get('priority'),
            'to_grp' => $tos
        );
        Njoftimet::where('idnjoftimet', '=', Input::get('idnjft'))->update($update);
        return Redirect::action('NewsController@getIndex');
    }

    public function postStore() {
        $rule = array('to' => 'required',
            'priority' => 'required',
            'msg' => 'required',
            'title' => 'required');
        if (empty(Input::get('dre')) == false) {
            if (in_array(Enum::student, Input::get('to'))) {

                $drejtimet = '@' . implode('@', Input::get('dre')) . '@';

                $semestri = '@' . implode('@', Input::get('sem')) . '@';
            }

            $rule['dre'] = 'required';
            $rule['sem'] = 'required';
        } else {
            $drejtimet = null;
            $semestri = null;
        }

        $tos = '@' . implode('@', Input::get('to')) . '@';
        $valid = Validator::make(Input::all(), $rule);

        if ($valid->fails())
            return 'errrorrr';

        print_r(Input::all());
        $njoftimet = new Njoftimet;
        $njoftimet->uid = Session::get('uid');
        $njoftimet->idd = $drejtimet;
        $njoftimet->titulli = Input::get('title');
        $njoftimet->msg = Input::get('msg');
        $njoftimet->semestri = $semestri;
        $njoftimet->priority = Input::get('priority');
        $njoftimet->to_grp = $tos;
        $njoftimet->save();
        return Redirect::action('NewsController@getIndex');
    }
    

}
