<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Workflow extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workflow';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public static function getAll() {
        $all = self::all();
        return $all;
    }
    public static function setWorkflow($id,$status){
        $update = array('value'=>$status);
        self::where('id','=',$id)->update($update);
        return true;
    }

}
