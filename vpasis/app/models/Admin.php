<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Admin extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'administrata';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public static function lastAdministrata() {
        $student = self::select('uid', 'emri', 'mbiemri')->orderby('uid', 'DESC')->get();
        $st = " <strong> " . $student[0]['emri'] . ' ' . $student[0]['mbiemri'] . " </strong> ( " . $student[0]['uid'] . " )";
        return $st;
    }

    public static function getMyprofile() {
        return self::where('uid', '=', Session::get('uid'))->get();
    }

    /*
     * Return listene  staffit
     */
    
    public static function getListStaff($groups = null) {
        if($groups!=null && count($groups)>0){
            $admin =  Admin::query();
            foreach($groups as $group){
                $admin->orWhere('grp',$group);
            }
            $admin->orderBy('created_at','DESC');
            return $admin->get(['uid','emri','mbiemri','email','telefoni','grada_shkencore','detyra']);
        }else{
            return self::where('deleted', '=', Enum::notdeleted)->orderBy('created_at','DESC')->get(['uid','emri','mbiemri','email','telefoni','grada_shkencore','detyra']);
        }
        
    }
    

    private $range = "900000";

    public static function postIndex() {
        if (is_numeric(Input::get('search'))) {
            if (Input::get('admin') != "admin") {
                $person = self::ById('student');
                return View::make('admin.search.listpeople', ['title' => Lang::get('general.search'), 'person' => $person]);
            } else if (Input::get('admin') == "admin") {
                $person = self::ById('admin');
                return View::make('admin.search.listpeople', ['title' => Lang::get('general.search'), 'person' => $person]);
            }
        } else if (preg_match("/^[a-zA-Z ]+$/ ", Input::get('search'))) {
            if (Input::get('admin') != "admin") {
                $person = self::ByName('student');
                return View::make('admin.search.listpeople', ['title' => Lang::get('general.search'), 'person' => $person]);
            } else if (Input::get('admin') == "admin") {

                $person = self::ByName('admin');
                return View::make('admin.search.listpeople', ['title' => Lang::get('general.search'), 'person' => $person]);
            }
        }
        $student = Studenti::where('uid', 'like', "%" . Input::get('search') . "%")->get();
    }

    private static function ById($access) {

        if ($access == "student") {
            // Student Search
            return Studenti::where('uid', 'like', "%" . Input::get('search') . "%")->take(7)->get();
        } else {//Staff search
            return Admin::where('uid', 'like', "%" . Input::get('search') . "%")->take(7)->get();
        }
    }

    public static function ByName($access) {
        $search = explode(' ', Input::get('search'));
        if ($access == "student") {
            if (count($search) > 1) {
                return Studenti::where('emri', 'like', '%' . $search[0] . '%')->where('mbiemri', 'like', $search[1])->take(5)->get();
            } else if (count($search) == 1) {
                return Studenti::where('emri', 'like', '%' . $search[0] . '%')->orWhere('mbiemri', 'like', '%' . $search[0] . '%')->take(5)->get();
            }
        } else {
            if (count($search) > 1) {
                return Admin::where('emri', 'like', '%' . $search[0] . '%')->where('mbiemri', 'like', $search[1])->take(5)->get();
            } else if (count($search) == 1) {
                return Admin::where('emri', 'like', '%' . $search[0] . '%')->orWhere('mbiemri', 'like', '%' . $search[0] . '%')->take(5)->get();
            }
        }
    }

}
