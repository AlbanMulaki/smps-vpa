<?php

class AuthController extends BaseController {
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

    private $rangeadmin = 900000;

    public function profile() {
        return "profile";
    }

    // Log out User
    public function getLogout() {
        Session::flush();
        return Redirect::to('/smps');
    }

    // Nese nuk eshte i kyqyr
    public function getIndex() {
        return View::make('login');
    }

    public function getChangePassword() {
        return View::make('admin.changePassword');
    }

    public function postChangePassword() {
        $validator = Validator::make(Input::all(), array(
                    'currentPassword' => "required",
                    'newPassword' => "required",
                    'confirmPassword' => "required"
        ));
        if ($validator->passes() && Input::get('newPassword') == Input::get('confirmPassword')) {
            if (Session::get('uid') < 900000) {
                $user = Studenti::query();
                $user = $user->where('uid', Session::get('uid'))
                        ->first();
                if (Hash::check(Input::get('currentPassword'), $user->psw)) {
                    Studenti::where('uid', Session::get('uid'))
                            ->update(array('psw' => Hash::make(Input::get('newPassword'))));
                    return Redirect::to('AuthController@getLogout');
                } else {
                    return Redirect::back()->withErrors(Lang::get('warn.password_incorrect'), 'incorrectNewPassword');
                }
            } else {
                $user = Admin::query();
                $user = $user->where('uid', Session::get('uid'))
                        ->first();
                if (Hash::check(Input::get('currentPassword'), $user->password)) {
                    Admin::where('uid', Session::get('uid'))
                            ->update(array('password' => Hash::make(Input::get('newPassword'))));
                    return Redirect::action('AuthController@getLogout');
                } else {
                    return Redirect::back()->withErrors(Lang::get('warn.password_incorrect'), 'incorrectNewPassword');
                }
            }
        }
        return Redirect::back()->withErrors($validator, 'validator');
    }

    /**
     * Change self password
     * @return type
     */
    public function postValidateSelfPassword() {
        if (Session::get('uid') < 900000) {
            $user = Studenti::query();
            $user = $user->where('uid', Session::get('uid'))
                    ->first();
            if (Hash::check(Input::get('currentPassword'), $user->psw)) {
                return array('success');
            }
        } else {
            $user = Admin::query();
            $user = $user->where('uid', Session::get('uid'))
                    ->first();
            if (Hash::check(Input::get('currentPassword'), $user->password)) {
                return array('success');
            }
        }
        return array('failed');
    }

    // Krijimi Session dhe processimi kyqjes
    public function postLogin() {
        $rules = array(
            'id' => 'required',
            'passwd' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        // Is Valid
        if ($validator->passes()) {

            // try creating session Student Or Admin
            $userdata = array(
                'uid' => Input::get('id'),
                'password' => Input::get('passwd')
            );
            if ($userdata['uid'] >= $this->rangeadmin) {// Admin
                $login = Admin::where('uid', '=', $userdata['uid'])->get();

                if (count($login) > 0) {
                    //login
                    if (Hash::check($userdata['password'], $login[0]['password'])) {
                        self::create_session($userdata);
                        if ($login[0]['grp'] == Enum::admin)
                            return Redirect::to('/smps/admin');
                        else if ($login[0]['grp'] == Enum::prof)
                            return Redirect::to('/smps/prof');
                    } else {
                        return Redirect::to('/smps');
                    }
                    echo "test";
                } else {
                    return Redirect::back()->withErrors(['us' => 'Username Gabim']);
                }
            } else if ($userdata['uid'] < $this->rangeadmin) {  // Studenti
                $login = Studenti::where('uid', '=', $userdata['uid'])->get();
                if (count($login) > 0) {
                    if (Hash::check($userdata['password'], $login[0]['psw'])) {
                        self::create_session($userdata);
                        if ($login[0]['grp'] == Enum::student)
                            return Redirect::to('/smps/student');
                    } else {
                        return Redirect::to('/smps');
                    }
                } else {
                    return 'this user doesnt exist';
                }
            } else {
                return Redirect::back()->withErrors($validator->messages());
            }
        } else {

            return Redirect::back()->withErrors($validator->messages());
        }
    }

    public function create_session($userdata) {
        Session::put('sid_token', Input::get('_token'));
        Session::put('uid', Input::get('id'));
        Session::put('pid', Input::get('passwd'));
        $secure_session = new Secure;
        $secure_session->token = Session::get('sid_token');
        $secure_session->ip_adress = Request::getClientIp();
        $secure_session->user_agent = Request::server('HTTP_USER_AGENT');
        $secure_session->time = date('H-i', time() + (180 * 60));
        $secure_session->uid = $userdata['uid'];
        $secure_session->save();
        // Generate New Session for next process
        Session::forget('_token');
        Session::put('_token', str_random(40));
    }

}
