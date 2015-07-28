<?php

class SettingsController extends BaseController {
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

    public function Index() {
        $settings = Settings::get();
        return View::make('admin.settings', ['title' => Lang::get('header.title_index'), 'settings' => $settings[0]]);
    }

    public function Update() {
        if(Input::get('afp') == Enum::closed) {
            Provimet::where('locked', '=', Enum::nolocked)->update(array('locked' => Enum::locked));
        }
        $setting = Settings::find(1);
        $setting->provim_active = Input::get('afp');
        $setting->zgjedhore_active = Input::get('lzg');
        $setting->refuzimi_active = Input::get('rf');
        $setting->perqindja_paraqitjes = Input::get('pax');
        $setting->koha_refuzimit = Input::get('day');
        $setting->orari_lendeve = Input::get('orl');
        $setting->vlersimi = Input::get('vlrs');
        $setting->save();
    }

}
