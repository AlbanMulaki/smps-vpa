<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Drejtimet extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'drejtimet';

    // Return te gjitha drejtimet per perdorim ne combobox
    public static function getComboDrejtimetAll() {
        $lendet = self::where('deleted', '=', Enum::notdeleted)->get();
        $cmb = array();
        foreach ($lendet as $value) {
            $cmb[$value['idDrejtimet']] = $value['Emri'];
        }
        return $cmb;
    }

    // Return te gjitha drejtimet per perdorim ne combobox
    public static function getComboDrejtimetGroupedAll() {
        $combo = array("-1" => Lang::get('general.choose_subject'));
        $department = Departments::where('deleted', '=', Enum::notdeleted)->get();

        foreach ($department as $val) {
            $drejtimet = self::where('idd', '=', $val['idDepartmentet'])->get();
            foreach ($drejtimet as $value) {
                $combo[$val['Emri']][$value['idDrejtimet']] = $value['Emri'];
            }
        }

        return $combo;
    }

}
