<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Pagesat extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pagesat';
    
    public static function getAllPagesat(){
        return self::where('deleted','=',Enum::notdeleted)->orderBy('created_at','DESC')->get();
    }
    
    
    
    public function getPaguesi() {
        return self::hasOne('Studenti', 'uid', 'paguesi');
    }
    

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    
    // Get Pagesat per vit
    public static function getPagesat($id) {
        $profile = Studenti::where('uid', '=', $id)->get();
        if ($profile[0]['semestri'] % 2 == 1) {
            $kontrata = self::where('type', '=', Enum::kontrat)
                    ->where('uid', '=', $id)->where('pershkrimi', 'LIKE', '% ' . $profile[0]['semestri'] . '%')
                    ->select(DB::raw('SUM(shuma) as shuma'))
                    ->get();
        } else {
            $kontrata = self::where('type', '=', Enum::kontrat)->where('uid', '=', $id)
                    ->where('pershkrimi', 'LIKE', '% ' . $profile[0]['semestri'] . '%')
                    ->orwhere('pershkrimi', 'LIKE', '% ' . ($profile[0]['semestri'] - 1) . '%')
                    ->select(DB::raw('SUM(shuma) as shuma'))
                    ->get();
        }
        return $kontrata[0]['shuma'];
    }

}
