<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Statusi extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'statusi';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public static function getComboStatusiAll() {
        $lendet = self::where('deleted', '=', Enum::notdeleted)->get();
        $cmb = array();
        foreach ($lendet as $value) {
            $cmb[$value['id']] = $value['emri'];
        }
        return $cmb;
    }

}
