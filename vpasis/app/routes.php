<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

class PremissionCheck {

    private $access = '0';
    private $rangeadmin = 900000;
    private $grp = '';
    protected $lastStudentRegistred;

    public function __construct() {
        if (Session::get('uid') >= $this->rangeadmin) {
            $tokendb = Admin::where('uid', '=', Session::get('uid'))->get()->count();
            if ($tokendb) {
                $this->access = 2;
            } else {
                $this->access = 1;
            }

            //  $this->lastStudentRegistred = Studenti::lastStudent();
            //  View::share('lastStudentRegistred',$this->lastStudentRegistred);
        } else {
            $tokendb = Studenti::where('uid', '=', Session::get('uid'))->get()->count();
            if ($tokendb) {
                $this->access = 2;
            } else {
                $this->access = 1;
            }
        }
    }

    public function isLogin() {
        return $this->access;
    }

}

Route::get('/pr', 'PrintController@index');
$check = new PremissionCheck();


/* ____________________________________________________________________________________________________________________________________________________________
 */
// Language Pack
if (!Session::get('lang')) {
    Session::put('lang', 'sq');
}
App::setLocale(Session::get('lang'));


// Authentication
if ($check->isLogin() == 2) {
    if (Session::get('uid') >= 900000) {
        $user = Admin::where('uid', '=', Session::get('uid'))->select('grp')->get();
// Split accesss
        if ($user[0]['grp'] == Enum::admin) {


            Route::controller('/smps/admin/website', 'AdminwebsiteController');
            Route::controller('/smps/admin/options', 'OptionsController');
            Route::controller('/smps/admin/staff', 'StaffController');
            Route::controller('/smps/admin/student', 'StudentController');
            Route::controller('/smps/admin/vijushmeria', 'VijushmeriaController');
            Route::controller('/smps/admin/fee','FeeController');
            Route::controller('/smps/admin/provimet','ProvimetController');


            Route::put('/smps/admin/setting', 'SettingsController@Update');
            Route::get('/smps/admin/setting', 'SettingsController@Index');

            Route::controller('/smps/admin/misc', 'AdminMiscController');
            //Route::get('/smps/admin/slist', 'AdminController@getSlist');
            //Route::get('/smps/admin/print-slist/{id}/{ids}', 'AdminController@getPrintSlist');
            Route::get('/smps/admin/slist', 'admin\DashboardController@Dashboard');
            Route::post('/smps/admin/sortaca', 'AdminController@postSortaca');
            Route::get('/smps/admin/hsub/print/{id}', 'OrariController@PrintOrari');
            Route::resource('/smps/admin/hsub', 'OrariController'); // Konfigurimi Orarit
            Route::controller('/smps/admin/', 'AdminController');
            Route::controller('/smps/admin/ajax', 'AjaxController');
            Route::controller('/smps/admin/departments', 'DepartmentsController');
            Route::get('/smps/admin/person/{id}/print', 'PersonController@print_transkript');
            Route::get('/smps/admin/person/{id}/pagesa/print', 'PersonController@PrintPagesa');
            Route::post('/smps/admin/person/{id}/pagesa', 'PersonController@storepagesa');
            Route::get('/smps/admin/person/print-kontrata/', 'PersonController@getPrintKontrata');
            Route::resource('/smps/admin/person', 'PersonController');
            Route::controller('/smps/admin/warn', 'WarnController');
            Route::controller('/smps/admin/search', 'SearchPersonController');
            Route::controller('/smps/admin/rnotat', 'NotimetController');
            Route::controller('/smps/admin/news', 'NewsController');
            Route::controller('/smps/admin/prof', 'ProfController');
            Route::controller('/smps/admin/assign', 'AssignController');
            Route::controller('/smps/admin/inbox', 'MsgController');
            Route::controller('/smps/admin/rating', 'RatingController');
            Route::get('/smps/admin/ratingprintprof/', 'RatingController@Printprof');
            //redirect
            Route::get('/smps/', function() {
                return Redirect::to('/smps/admin');
            });
        } else if ($user[0]['grp'] == Enum::prof) {
            Route::controller('/smps/prof', 'ProfessorController');
            Route::controller('/smps/admin/ajax', 'AjaxController');
            Route::post('/smps/prof/search', 'SearchPersonController@postIndex');
        }
    } else {
        Route::get('/smps/', function() {
            return Redirect::to('/smps/student');
        });
        Route::controller('/smps/admin/ajax', 'AjaxController');
    }
} else if ($check->isLogin() != 2) {
    Route::controller('/smps/', 'AuthController');
}
Route::get('/smps/logout', 'AuthController@getLogout');
/*
  // developer Mode Admin
  Route::get('/dev', function() {
  return View::make('website.post', ['title' => 'titulli']);
  });
  Route::get('/dev/post', function() {
  return View::make('website.postread', ['title' => 'titulli']);
  });
  Route::get('/dev/team', function() {
  return View::make('website.team', ['title' => 'titulli']);
  });
 * */
Route::controller('/', 'WebsiteController');
