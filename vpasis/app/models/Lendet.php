<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Lendet extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lendet';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public static function getLendetzgjedhore() {
        $studenti = Studenti::where('uid', '=', Session::get('uid'))->get();
        $zgjedhore = self::join('lendet_zgjedhura', 'lendet_zgjedhura.idl', '!=', 'lendet.idl')
                ->where('lendet.semestri', '=', $studenti[0]['semestri'])
                ->where('lendet.Drejtimi', '=', $studenti[0]['drejtimi'])
                ->where('lendet.zgjedhore', '=', Enum::zgjedhore)
                ->select(DB::raw('DISTINCT lendet.Emri as Lenda'), 'lendet.idl as idl')
                ->get();
        $zgjedhore_pre = array('');
        foreach ($zgjedhore as $value) {
            $zgjedhore_pre[$value['idl']] = $value['Lenda'];
        }
        return $zgjedhore;
    }

    // Return te lendet
    public static function getComboLendetAll($idd = 0) {
        if ($idd == 0) {
            $lendet = self::where('deleted', '=', Enum::notdeleted)->get();
        } else {
            $lendet = self::where('deleted', '=', Enum::notdeleted)
                    ->where('Drejtimi', '=', $idd)
                    ->get();
        }

        $cmb = array('');
        foreach ($lendet as $value) {
            $cmb[$value['idl']] = $value['Emri'];
        }
        return $cmb;
    }

    //Kthen lendet e studentit
    public static function getSlendetCombo() {
        $personi = Studenti::where('uid', '=', Session::get('uid'))->get();
        $obligative = self::where('Semestri', '<=', $personi[0]['semestri'])
                ->where('Zgjedhore', '=', Enum::jozgjedhore)
                ->where('deleted', '=', Enum::notdeleted)
                ->where('Drejtimi', '=', $personi[0]['drejtimi'])
                ->get();
        $zgjedhore = Lendet::join('lendet_zgjedhura', 'lendet_zgjedhura.idl', '=', 'lendet.idl')
                ->where('lendet_zgjedhura.uid', '=', Session::get('uid'))
                ->where('Drejtimi', '=', $personi[0]['drejtimi'])
                ->get();
        $lendet = array();
        foreach ($obligative as $value) {
            $lendet[$value['idl']] = $value['Emri'];
        }
        foreach ($zgjedhore as $value) {
            $lendet[$value['idl']] = $value['Emri'];
        }
        return $lendet;
    }

    
}
