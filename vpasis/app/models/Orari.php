 
<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Orari extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orari';

    public static function getStudentOrari() {
        $semestri = Studenti::where('uid', '=', Session::get('uid'))->get();
        //Lendet e obliguara
        $base = self::join('lendet', 'lendet.idl', '=', 'orari.idl')
                ->where('orari.semestri', '<=', $semestri[0]['semestri'])
                ->where('orari.idd', '=', $semestri[0]['drejtimi'])
                ->where('orari.locked', '=', Enum::nolocked)
                ->where('lendet.zgjedhore', '=', Enum::jozgjedhore)
                ->where('orari.deleted', '=', Enum::notdeleted)
                ->select('lendet.Emri as Lendet', DB::raw("date_format(`ora`,'%H:%i') as ora "), 'dita')
                ->orderby('dita', 'ASC')
                ->orderby('ora', 'ASC')
                ->get();
        // Lendete zgjedhore

        $zgjedhore  = self::join('lendet', 'lendet.idl', '=', 'orari.idl')
                ->join('lendet_zgjedhura','lendet_zgjedhura.idl', '=', 'orari.idl')
                ->where('orari.semestri', '<=', $semestri[0]['semestri'])
                ->where('orari.idd', '=', $semestri[0]['drejtimi'])
                ->where('orari.locked', '=', Enum::nolocked)
                ->where('lendet.zgjedhore', '=', Enum::zgjedhore)
                ->where('orari.deleted', '=', Enum::notdeleted)
                ->select('lendet.Emri as Lendet', DB::raw("date_format(`ora`,'%H:%i') as ora "), 'dita')
                ->orderby('dita', 'ASC')
                ->orderby('ora', 'ASC')
                ->get();

        // Kombinimi i dyjave
        return array_merge($base->toArray(),$zgjedhore->toArray());
    }

}
