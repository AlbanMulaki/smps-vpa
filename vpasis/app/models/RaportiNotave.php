<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class RaportiNotave extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'raporti_notave';
    

    public function raportiNotaveStudent() {
        return self::hasMany('RaportiNotaveStudent', 'idraportit', 'id');
    }

    public function lendet() {
        return self::hasOne('Lendet', 'idl', 'idl');
    }
    public function administrata() {
        return self::hasOne('Admin', 'uid', 'prof');
    }

    public static function findOrCreate($id) {
        $obj = static::find($id);
        return $obj ? : new static;
    }
    

}
