<?php

class SearchPersonController extends BaseController {
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

    private $range = "900000";

    public function postIndex() {
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

    private function ById($access) {

        if ($access == "student") {
            // Student Search
            return Studenti::where('uid', 'like', "%" . Input::get('search') . "%")->take(7)->get();
        } else {//Staff search
            return Admin::where('uid', 'like', "%" . Input::get('search') . "%")->take(7)->get();
        }
    }

    public function ByName($access) {
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
