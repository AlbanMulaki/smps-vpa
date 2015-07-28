<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Lendetzgjedhore extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lendet_zgjedhura';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    /*
     * Return lendet zgjedhore per perdorim ne ccombobox
     */
    public static function getStatusZgjedhore() {
        $studenti = Studenti::where('uid', '=', Session::get('uid'))->get();
        $zgjedhore = self::join('lendet', 'lendet.idl', '!=', 'lendet_zgjedhura.idl')
                ->where('lendet.semestri', '=', $studenti[0]['semestri'])
                ->where('lendet.Drejtimi', '=', $studenti[0]['drejtimi'])
                ->where('lendet_zgjedhura.uid', '=', $studenti[0]['uid'])
                ->where('lendet.zgjedhore', '=', Enum::zgjedhore)
                ->select(DB::raw('DISTINCT lendet.Emri as Lenda'), 'lendet.idl as idl')
                ->get();
        if (count($zgjedhore) > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public static function setLendetZgjedhore() {
        $profile = Studenti::where('uid', '=', Session::get('uid'))->get();
        for ($i = 1; $i <= $profile[0]['semestri']; $i++) {
            $lendet = Lendet::where('Semestri', '=', $i)
                    ->where('Drejtimi', '=', $profile[0]['drejtimi'])
                    ->where('Zgjedhore', '=', Enum::jozgjedhore)
                    ->get();
            foreach ($lendet as $val) {
                $notimet = Notimet::where('studenti', '=', $profile[0]['uid'])
                        ->where('idl', '=', $val['idl'])
                        ->where('drejtimi', '=', $profile[0]['drejtimi'])
                        ->get();
                if (count($notimet) < 1) {
                    $not = new Notimet();
                    $not->idl = $val['idl'];
                    $not->studenti = $profile[0]['uid'];
                    $not->drejtimi = $profile[0]['drejtimi'];
                    $prof = Orari::where('idl', '=', $val['idl'])
                            ->where('locked', '=', Enum::nolocked)
                            ->where('deleted', '=', Enum::notdeleted)
                            ->get();
                    if (count($prof) > 0) {
                        $not->professori = $prof[0]['uid'];
                    } else {
                        $not->professori = 0;
                    }
                    $not->locked = Enum::nolocked;
                    $not->grp = 0;
                    $not->save();
                }
            }
        }
        $prof = Orari::where('idl', '=', Input::get('zgj'))
                ->where('locked', '=', Enum::nolocked)
                ->where('deleted', '=', Enum::notdeleted)
                ->get();
        if(count($prof)<1){
            $prof=0;
        }
        $notimet = new Notimet();
        $notimet->idl = Input::get('zgj');
        $notimet->studenti = Session::get('uid');
        $notimet->drejtimi = $profile[0]['drejtimi'];
        $notimet->nota = 0;
        $notimet->grp = 0;
        $notimet->professori = $prof[0]['uid'];
        $notimet->save();

        $new = new Lendetzgjedhore();
        $new->uid = Session::get('uid');
        $new->idl = Input::get('zgj');
        $new->save();
        return true;
    }

}
