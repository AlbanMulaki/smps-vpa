<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class StudentLendet extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_lendet';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public static function getLendetProfile() {

        $lendet = self::join('lendet', 'lendet.idl', '=', 'student_lendet.idl')
                ->join('raporti_notave_student', 'raporti_notave_student.idl', '=', 'student_lendet.idl')
                ->join('administrata', 'administrata.uid', '=', 'student_lendet.prof')
                ->select(DB::raw('CONCAT(administrata.emri,\' \',administrata.mbiemri) as prof'), 'lendet.emri as lenda', 'lendet.idl as idl', 'raporti_notave_student.nota as nota')
                ->where('student_lendet.deleted', '=', Enum::notdeleted)
                ->where('raporti_notave_student.locked','=',Enum::nolocked)
                ->get();
        return $lendet;
    }

}
