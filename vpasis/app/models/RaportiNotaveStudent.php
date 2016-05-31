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
    protected $fillable = array('studenti',
        'nota',
        'testi_semestral',
        'testi_gjysem_semestral',
        'seminari',
        'pjesmarrja',
        'puna_praktike',
        'testi_final',
        'refuzim',
        'paraqit',
        'idl',
        'idraportit',
        'paraqit_prezent');

    public static function getRaportNotaveList($id) {
        return self::where('idraportit', '=', $id)
                        ->where('raporti_notave_student.deleted', '=', Enum::notdeleted)
                        ->first();
    }

    public function getStudent() {
        return self::hasOne('Studenti', 'uid', 'studenti');
    }
    

}
