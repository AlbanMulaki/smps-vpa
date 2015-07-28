<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

App::before(function($request) {
    //
});


App::after(function($request, $response) {
    //
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function() {
    if (Auth::guest()) {
        if (Request::ajax()) {
            return Response::make('Unauthorized', 401);
        } else {
            return Redirect::guest('login');
        }
    }
});


Route::filter('auth.basic', function() {
    return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function() {
    if (Auth::check())
        return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

App::before(function($request) {
    if (in_array(Request::segment(1), Config::get('app.languages'))) {
        Session::put('locale', Request::segment(1));
        return Redirect::to(substr(Request::path(), 3));
    }
    if (Session::has('locale')) {
        App::setLocale(Session::get('locale'));
    }
});

App::before(function($request) {
    App::singleton('lastStudentRegistred', function() {
        $lastStudentRegistred = Studenti::lastStudent();
        return $lastStudentRegistred;
    });
    App::singleton('drejtimi', function() {
        $drejtimi = Drejtimet::getComboDrejtimetAll();
        return $drejtimi;
    });
    App::singleton('statusi', function() {
        $statusi = Statusi::getComboStatusiAll();
        return $statusi;
    });

    // If you use this line of code then it'll be available in any view
    // as $site_settings but you may also use app('site_settings') as well
    View::share('lastStudentRegistred', app('lastStudentRegistred'));
    View::share('drejtimi', app('drejtimi'));
    View::share('statusi', app('statusi'));
});

Route::filter('csrf', function() {
    if (Session::token() != Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
