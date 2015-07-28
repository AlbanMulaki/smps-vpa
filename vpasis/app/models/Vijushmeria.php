<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Vijushmeria extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vijushmeria';

    /*     * a
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public static function getStudentVijushmeriaProf() {
        $studentet = self::join('studenti', 'studenti.uid', '=', 'vijushmeria.studenti')
                ->where('professor', '=', Session::get('uid'))
                ->where('locksem', '=', Enum::notlocksem)
                ->where('deleted', '=', Enum::notdeleted)
                ->where('idl', '=', Input::get('vijushmeriaidl'))
                ->select(DB::raw('DISTINCT studenti as Studenti'), DB::raw("CONCAT(studenti.emri,' ',studenti.mbiemri) as Emri"))
                ->orderby('studenti.emri', 'ASC')
                ->orderby('studenti.mbiemri', 'ASC')
                ->get();
        $vijushmeria_pre = $studentet->toArray();
        for ($i = 0; $i < count($studentet); $i++) {
            $temp = self::where('studenti', '=', $studentet[$i]['Studenti'])
                    ->where('professor', '=', Session::get('uid'))
                    ->where('locksem', '=', Enum::notlocksem)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->where('idl', '=', Input::get('vijushmeriaidl'))
                    ->get();
            $vijushmeria_pre[$i]['present'] = count($temp);
        }
        return $vijushmeria_pre;
    }

    public static function getStudentVijushmeriaProfinp() {
        $studentet = self::join('studenti', 'studenti.uid', '=', 'vijushmeria.studenti')
                ->where('professor', '=', Session::get('uid'))
                ->where('locksem', '=', Enum::notlocksem)
                ->where('deleted', '=', Enum::notdeleted)
                ->where('idl', '=', Input::get('genrap'))
                ->select(DB::raw('DISTINCT studenti as Studenti'), DB::raw("CONCAT(studenti.emri,' ',studenti.mbiemri) as Emri"))
                ->orderby('studenti.emri', 'ASC')
                ->orderby('studenti.mbiemri', 'ASC')
                ->get();
        $vijushmeria_pre = $studentet->toArray();
        for ($i = 0; $i < count($studentet); $i++) {
            $temp = self::where('studenti', '=', $studentet[$i]['Studenti'])
                    ->where('professor', '=', Session::get('uid'))
                    ->where('locksem', '=', Enum::notlocksem)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->where('idl', '=', Input::get('genrap'))
                    ->get();
            $vijushmeria_pre[$i]['present'] = count($temp);
        }
        return $vijushmeria_pre;
    }

    public static function countVijushmeria($idl,$student=1) {
        if($student == 1){
        $studenti = self::join('studenti', 'studenti.uid', '=', 'vijushmeria.studenti')
                ->where('studenti', '=', Session::get('uid'))
                ->where('deleted', '=', Enum::notdeleted)
                ->where('idl', '=', $idl)
                ->select(DB::raw('COUNT(vijushmeria.studenti) as vijushmeria'))
                ->get();
        } else {
        $studenti = self::join('studenti', 'studenti.uid', '=', 'vijushmeria.studenti')
                ->where('studenti', '=', $student)
                ->where('deleted', '=', Enum::notdeleted)
                ->where('idl', '=', $idl)
                ->select(DB::raw('COUNT(vijushmeria.studenti) as vijushmeria'))
                ->get();
            
        }
        
        return $studenti[0];
    }

}
