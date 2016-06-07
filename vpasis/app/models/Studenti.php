<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Studenti extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *                  
     * @var string
     */
    protected $table = 'studenti';

    public static function lastStudent() {
        $student = self::select('uid', 'emri', 'mbiemri')->orderby('uid', 'DESC')->get();
        $st = " <strong> " . $student[0]['emri'] . ' ' . $student[0]['mbiemri'] . " </strong> ( " . $student[0]['uid'] . " )";
        return $st;
    }

    public static function sortaca($vitiaka = null, $sort = null) {

        if ($vitiaka != null) {
            $student = self::join('drejtimet', 'drejtimet.idDrejtimet', '=', 'studenti.drejtimi')
                            ->orderby('studenti.emri', 'ASC')
                            ->where('viti_aka', '=', $vitiaka)->get();
        } else {
            $student = self::join('drejtimet', 'drejtimet.idDrejtimet', '=', 'studenti.drejtimi')->where('viti_aka', '=', Input::get('sortaca'))->get();
        }
        return $student;
    }

    /*
     * Return new students registered
     */

    public static function getCountStudents() {
        return self::select(DB::raw('COUNT(*) as students'))
                        ->where('confirm', '=', Enum::confirmed)
                        ->where('deleted', '=', Enum::notdeleted)
                        ->get();
    }

    public static function getStudentNotConfirmed() {
        return self::select(DB::raw('COUNT(*) as notconfirmed'))->where('confirm', '=', Enum::notconfirmed)->get();
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public static function setApplikoOnline($filename = null, $vitiaka = null) {


        $student = new Studenti();
        $student->emri = Input::get('emri');
        $student->mbiemri = Input::get('mbiemri');
        $student->emri_prindit = Input::get('pemri');
        $student->mbiemri_prindit = Input::get('pmbiemri');
        $student->gjinia = Input::get('gjinia');
        $student->vendlindja = Input::get('vendlindja');
        $student->datalindjes = Input::get('datlindja');
        $student->nrpersonal = Input::get('idpersonal');
        $student->telefoni = Input::get('mobile');
        $student->email = Input::get('email');
        $student->shteti = Input::get('shteti');
        $student->kombesia = Input::get('nationality');
        $student->adressa = Input::get('adressa');
        $student->vendbanimi = Input::get('vendbanimi');
        $student->drejtimi = Input::get('drejtimet');
        $student->statusi = Input::get('status');
        $student->niveli = Input::get('level');
        $student->transfer = Input::get('transfer');
        $student->psw = Hash::make(Input::get('idpersonal'));
        if ($vitiaka == 1) {
            $student->viti_aka = Input::get('vitiaka');
            $student->semestri = 0;
        } else {
            $date = date('Y');
            $date = $date - 1;
            $student->viti_aka = $date . "/" . date('Y');
            $student->semestri = 1;
        }
        if ($filename != null) {
            $student->avatar = $filename;
        } else {
            $student->avatar = "/avatar.png";
        }
        $student->confirm = 0;
        $student->kualifikimi = Input::get('qualification');
        $student->save();
    }

    public function getPagesat() {
        return self::hasMany('Pagesat', 'paguesi', 'uid');
    }
}
