<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Ligjeratat extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ligjeratat';

    /* ------------------Return Array ready for SelectRange -------------------- */

    public static function getLigjeratatProf() {
        $semestri = Lendet::where('idl', '=', Input::get('actvlnd'))->get();
        $valid = Validator::make(Input::all(), array('actvlnd' => 'required'));
        if ($valid->passes() && Input::get('actvlnd') > 0) {
            $ligjeratat = self::join('lendet', 'lendet.idl', '=', 'ligjeratat.idl')
                    ->where('uid', '=', Session::get('uid'))
                    ->where('ushtrime', '=', '0')
                    ->where('ligjeratat.idl', '=', Input::get('actvlnd'))
                    ->where('ligjeratat.deleted', '=', Enum::notdeleted)
                    ->where('ligjeratat.semestri', '=', $semestri[0]['Semestri'])
                    ->where(DB::raw("DATE_FORMAT(ligjeratat.`created_at`,'%Y')"), '=', date('Y'))
                    ->select('ligjeratat.emri as Titulli', DB::raw("DATE_FORMAT(ligjeratat.`updated_at`,'%d-%m-%Y"
                                    . "') as data"), 'ligjeratat.size as size', 'ligjeratat.idligjeratat as id', 'ligjeratat.attachname as Attachname', 'ligjeratat.session as Session', 'ligjeratat.idl as idl')
                    ->get();
            return $ligjeratat;
        }
        return array();
    }

    public static function getUshtrimerProf() {

        $semestri = Lendet::where('idl', '=', Input::get('actvlnd'))->get();
        $valid = Validator::make(Input::all(), array('actvlnd' => 'required'));
        if ($valid->passes() && Input::get('actvlnd') > 0) {
            $ligjeratat = self::join('lendet', 'lendet.idl', '=', 'ligjeratat.idl')
                    ->where('uid', '=', Session::get('uid'))
                    ->where('ligjeratat.ushtrime', '=', '1')
                    ->where('ligjeratat.deleted', '=', Enum::notdeleted)
                    ->where('ligjeratat.idl', '=', Input::get('actvlnd'))
                    ->where('ligjeratat.semestri', '=', $semestri[0]['Semestri'])
                    ->where(DB::raw("DATE_FORMAT(ligjeratat.`created_at`,'%Y')"), '=', date('Y'))
                    ->select('ligjeratat.emri as Titulli', DB::raw("DATE_FORMAT(ligjeratat.`updated_at`,'%d-%m-%Y"
                                    . "') as data"), 'ligjeratat.size as size', 'ligjeratat.idligjeratat as id', 'ligjeratat.attachname as Attachname', 'ligjeratat.session as Session', 'ligjeratat.idl as idl')
                    ->get();
            return $ligjeratat;
        }
        return array();
    }

    public static function InsertLigjeratat($size, $filename) {
        $lenda = Lendet::where('idl', '=', Input::get('actvlnd'))->get();
        $data = new Ligjeratat;
        $data->uid = Session::get('uid');
        $data->idd = $lenda[0]['Drejtimi'];
        $data->semestri = $lenda[0]['Semestri'];
        $data->ushtrime = 0;
        $data->attachname = $filename;
        $data->idl = Input::get('actvlnd');
        $data->emri = Input::get('title');
        $data->session = date('Y');
        $data->size = $size;
        $data->deleted = Enum::notdeleted;
        $data->save();
        return TRUE;
    }

    public static function InsertUshtrime($size, $filename) {
        $lenda = Lendet::where('idl', '=', Input::get('actvlnd'))->get();
        $data = new Ligjeratat;
        $data->uid = Session::get('uid');
        $data->idd = $lenda[0]['Drejtimi'];
        $data->semestri = $lenda[0]['Semestri'];
        $data->ushtrime = 1;
        $data->attachname = $filename;
        $data->idl = Input::get('actvlnd');
        $data->emri = Input::get('titleu');
        $data->session = date('Y');
        $data->size = $size;
        $data->deleted = Enum::notdeleted;
        $data->save();
        return TRUE;
    }

    public static function DeleteLigjerata() {
        $delete = self::join('assign_prof', 'assign_prof.uid', '=', 'ligjeratat.uid')
                ->where('idligjeratat', '=', Input::get('idlu'))
                ->where('assign_prof.active', '=', Enum::active)
                ->where('ligjeratat.uid', '=', Session::get('uid'))
                ->where('ligjeratat.deleted', '=', Enum::notdeleted)
                ->where('ligjeratat.idl', '=', Input::get('idl'))
                ->get();
        if (count($delete) > 0) {
            self::where('idligjeratat', '=', Input::get('idlu'))
                    ->update(array('deleted' => Enum::deleted));
            return TRUE;
        }

        return false;
    }

    public static function getLigjeratatStudent() {
        $semestri = Lendet::where('idl', '=', Input::get('actvlnd'))->get();
        $valid = Validator::make(Input::all(), array('actvlnd' => 'required'));

        if ($valid->passes() && Input::get('actvlnd') > 0) {
            $personi = Studenti::where('uid', '=', Session::get('uid'))->get();
            $ligjeratat = self::where('deleted', '=', Enum::notdeleted)
                    ->where('ushtrime', '=', 0)
                    ->where('ligjeratat.idl', '=', Input::get('actvlnd'))
                    ->where('ligjeratat.semestri', '<=', $personi[0]['semestri'])
                    ->where('ligjeratat.idd', '=', $personi[0]['drejtimi'])
                    ->where(DB::raw("DATE_FORMAT(ligjeratat.`created_at`,'%Y')"), '=', date('Y'))
                    ->select('ligjeratat.emri as Titulli', DB::raw("DATE_FORMAT(ligjeratat.`updated_at`,'%d-%m-%Y"
                                    . "') as data"), 'ligjeratat.size as size', 'ligjeratat.idligjeratat as id', 'ligjeratat.attachname as Attachname', 'ligjeratat.session as Session', 'ligjeratat.idl as idl')
                    ->get();
            return $ligjeratat;
        }
        return array('Null');
    }
    public static function getUshtrimeStudent() {
        $semestri = Lendet::where('idl', '=', Input::get('actvlnd'))->get();
        $valid = Validator::make(Input::all(), array('actvlnd' => 'required'));

        if ($valid->passes() && Input::get('actvlnd') > 0) {
            $personi = Studenti::where('uid', '=', Session::get('uid'))->get();
            $ligjeratat = self::where('deleted', '=', Enum::notdeleted)
                    ->where('ushtrime', '=', 0)
                    ->where('ligjeratat.idl', '=', Input::get('actvlnd'))
                    ->where('ligjeratat.semestri', '<=', $personi[0]['semestri'])
                    ->where('ligjeratat.idd', '=', $personi[0]['drejtimi'])
                    ->where(DB::raw("DATE_FORMAT(ligjeratat.`created_at`,'%Y')"), '=', date('Y'))
                    ->select('ligjeratat.emri as Titulli', DB::raw("DATE_FORMAT(ligjeratat.`updated_at`,'%d-%m-%Y"
                                    . "') as data"), 'ligjeratat.size as size', 'ligjeratat.idligjeratat as id', 'ligjeratat.attachname as Attachname', 'ligjeratat.session as Session', 'ligjeratat.idl as idl')
                    ->get();
            return $ligjeratat;
        }
        return array('Null');
    }

}
