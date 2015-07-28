<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Kontratat extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kontratat';

    public static function getAllowParaqitjen($id) {
        $shuma = self::where('uid', '=', $id)->get();// Kontrata
        $pagesat = Pagesat::getPagesat($id);    //   Full pagesat
        $setting = Settings::all();
        $perqinjda = $pagesat / $shuma[0]['shuma'] * 100;   // Perqindja e pagesave
        // return $perqinjda;
        if ($setting[0]['perqindja_paraqitjes'] <= $perqinjda) {
            return 1;
        }
        return 0;
    }

}
