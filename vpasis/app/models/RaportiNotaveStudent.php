<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class RaportiNotaveStudent extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'raporti_notave_student';

    public static function getRaportNotaveList($id) {
        return self::join('studenti', 'studenti.uid', '=', 'raporti_notave_student.studenti')
                        ->where('idraportit', '=', $id)
                        ->where('raporti_notave_student.deleted', '=', Enum::notdeleted)
                        ->get();
    }

}
