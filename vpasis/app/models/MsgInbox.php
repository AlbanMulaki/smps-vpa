<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class MsgInbox extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'inbox_msg';

    public static function getNews() {

        $msg = self::where('to', '=', Session::get('uid'))
                ->where('seen', '=', Enum::noseen)
                ->where('deleted', '=', Enum::notdeleted)
                ->get();
        return count($msg);
    }

    public static function reply($id) {
        $reply = new MsgInbox();
        $reply->uid = Session::get('uid');
        $reply->to = Input::get('to');
        $reply->msg = Input::get('msg');
        $reply->title = substr(Input::get('msg'), 0, 15);
        $reply->thread = Enum::nothread;
        $reply->seen = Enum::noseen;
        $reply->mid = $id;
        $reply->deleted = Enum::notdeleted;
        $reply->save();

        if (Session::get('uid') >= 900000) {
            $user = Admin::where('uid', '=', Session::get('uid'))->select('grp')->get();
            if ($user[0]['grp'] == Enum::admin) {
                return Redirect::to('/smps/admin/inbox/read/' . $id);
            } else if ($user[0]['grp'] == Enum::prof) {
                return Redirect::to('/smps/prof/inbox/read/' . $id);
            }
        } else if (Session::get('uid') < 900000) {

            $user = Studenti::where('uid', '=', Session::get('uid'))->select('grp')->get();
            return Redirect::to('/smps/student/read/' . $id);
        }
    }

    public static function sendmsg() {
        $send = new MsgInbox();
        $send->uid = Session::get('uid');
        $send->to = Input::get('search');
        $send->msg = Input::get('msg');
        $send->title = Input::get('title');
        $send->thread = Enum::thread;
        $send->seen = Enum::noseen;
        $send->mid = 0;
        $send->deleted = Enum::notdeleted;
        $send->save();
        $mid = $send->id;
        MsgInbox::where('id', '=', $mid)->update(array('mid' => $mid));

        if (Session::get('uid') >= 900000) {
            return Redirect::to('/smps/admin/inbox/');
        } else {
            return Redirect::to('/smps/student/inbox/');
        }
    }

    public static function getMsgDetail($id, $grp = null) {
        // Define title
        View::composer('admin.index', function($view) {
            $view->with('title', 'Inbox');
        });
        self::where('to', '=', Session::get('uid'))
                ->where('mid', '=', $id)
                ->where('deleted', '=', Enum::notdeleted)
                ->update(array('seen' => Enum::seen));
        $msg = self::orwhere(function($query) {
                    $query->where('to', '=', Session::get('uid'))->orwhere('uid', '=', Session::get('uid'));
                })
                ->where('mid', '=', $id)
                ->where('deleted', '=', Enum::notdeleted)
                ->get();

        $count = count($msg);
        // Merr dhenat personale te dy personave
        $isuser = array('to' => null, 'from' => null);
        if ($count > 0) {
            $isuser = array();
            foreach ($msg as $value) {
                if (!in_array($value['to'], $isuser)) {
                    $isuser['to'] = $value['to'];
                }
                if (!in_array($value['uid'], $isuser)) {
                    $isuser['from'] = $value['uid'];
                }
            }
            if (!array_key_exists('from', $isuser)) {
                $isuser['from'] = $isuser['to'];
            }
            if ($grp == Enum::admin) {
                $person[0] = Admin::where('uid', '=', $isuser['to'])->get();
                $person[1] = Admin::where('uid', '=', $isuser['from'])->get();
                if ($isuser['to'] >= 900000) {
                    $person[0] = Admin::where('uid', '=', $isuser['to'])->get();
                } else {
                    $person[0] = Studenti::where('uid', '=', $isuser['to'])->get();
                }
                if ($isuser['from'] >= 900000) {
                    $person[1] = Admin::where('uid', '=', $isuser['from'])->get();
                } else {

                    $person[1] = Studenti::where('uid', '=', $isuser['from'])->get();
                }
                return View::make('admin.msginbox.msgread', [
                            'news' => self::getNews(),
                            'msg' => $msg,
                            'i' => 0,
                            'id' => $id,
                            'count' => $count,
                            'person' => $person,
                            'isuser' => $isuser]);
            } else if ($grp == Enum::prof) {
                if ($isuser['to'] >= 900000) {
                    $person[0] = Admin::where('uid', '=', $isuser['to'])->get();
                } else {
                    $person[0] = Studenti::where('uid', '=', $isuser['to'])->get();
                }
                if ($isuser['from'] >= 900000) {
                    $person[1] = Admin::where('uid', '=', $isuser['from'])->get();
                } else {

                    $person[1] = Studenti::where('uid', '=', $isuser['from'])->get();
                }
                $person[0] = Admin::where('uid', '=', $isuser['to'])->get();
                $person[1] = Admin::where('uid', '=', $isuser['from'])->get();


                return View::make('prof.inboxread', ['title' => $msg[0]['title'],
                            'news' => self::getNews(),
                            'msg' => $msg,
                            'i' => 0,
                            'id' => $id,
                            'count' => $count,
                            'person' => $person,
                            'isuser' => $isuser]);
            } else if ($grp == Enum::student) {
                if ($isuser['to'] >= 900000) {
                    $person[0] = Admin::where('uid', '=', $isuser['to'])->get();
                } else {
                    $person[0] = Studenti::where('uid', '=', $isuser['to'])->get();
                }
                if ($isuser['from'] >= 900000) {
                    $person[1] = Admin::where('uid', '=', $isuser['from'])->get();
                } else {

                    $person[1] = Studenti::where('uid', '=', $isuser['from'])->get();
                }
                return View::make('student.inboxread', ['title' => $msg[0]['title'],
                            'news' => self::getNews(),
                            'msg' => $msg,
                            'i' => 0,
                            'id' => $id,
                            'count' => $count,
                            'person' => $person,
                            'isuser' => $isuser]);
            }
        } else {
            $isuser = null;
            if ($grp == 0) {
                return View::make('admin.msginbox.msgread', ['title' => $msg[0]['title'],
                            'news' => self::getNews(),
                            'msg' => $msg,
                            'i' => 0,
                            'id' => $id,
                            'count' => $count,
                            'person' => null,
                            'isuser' => $isuser]);
            } else if ($grp == Enum::prof) {

                return View::make('prof.inboxread', ['title' => $msg[0]['title'],
                            'news' => self::getNews(),
                            'msg' => $msg,
                            'i' => 0,
                            'id' => $id,
                            'count' => $count,
                            'person' => null,
                            'isuser' => $isuser]);
            } else if ($grp == Enum::student) {

                return View::make('student.inboxread', ['title' => $msg[0]['title'],
                            'news' => self::getNews(),
                            'msg' => $msg,
                            'i' => 0,
                            'id' => $id,
                            'count' => $count,
                            'person' => null,
                            'isuser' => $isuser]);
            }
        }
    }

}
