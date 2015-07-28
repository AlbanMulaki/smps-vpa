<?php

class MsgController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    public function getIndex() {
        $msg = MsgInbox::orwhere(function($query) {
                    $query->where('to', '=', Session::get('uid'));
                })
                ->where('thread', '=', Enum::thread)
                ->where('deleted', '=', Enum::notdeleted)
                ->join('personlist', 'personlist.uid', '=', 'inbox_msg.uid')
                ->orderby('seen', 'ASC')
                ->orderby('updated_at', 'DESC')
                ->get();
        return View::make('admin.msginbox.msgindex', ['title' => 'test', 'msg' => $msg, 'news' => self::getNews()]);
    }

    public function getRead($id) {

        $msg = MsgInbox::getMsgDetail($id,Enum::admin);

        return $msg;
    }

    public function postReply($id) {
        return MsgInbox::reply($id);
    }

    public function postSend() {
        $rules = array('search' => 'required',
            'title' => 'required',
            'msg' => 'required');
        $valid = Validator::make(Input::all(), $rules);

        if ($valid->passes()) {
            return MsgInbox::sendmsg();
        } else {
            return self::getErrormsg(Lang::get('warn.error_undefined'));
        }
    }

}
