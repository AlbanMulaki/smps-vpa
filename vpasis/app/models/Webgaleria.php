
<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Webgaleria extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'web_galeria';

    public static function getAlbum() {
        return self::where('album', '=', Enum::album)
                        ->where('deleted', '=', Enum::notdeleted)
                        ->get();
    }

    public static function getPhoto($id) {
        return self::where('album', '=', $id)
                        ->where('deleted', '=', Enum::notdeleted)
                        ->get();
    }

    public static function getNumPhoto($album) {

        $num = self::where('album', '=', $album)
                ->where('deleted','=',Enum::notdeleted)
                ->select(DB::raw('COUNT(`album`) as `numphoto`'))
                ->first();
        return $num['numphoto'];
    }

    public static function DeletePhoto($id) {
        self::where('id', '=', $id)->update(array('deleted' => Enum::deleted));
      
    }

    public static function AddPhoto($filename) {
        $ins = new Webgaleria();
        $ins->desc = Input::get('desc');
        $ins->link = $filename;
        $ins->album = Input::get('album');
        $ins->uid = Session::get('uid');
        $ins->deleted = Enum::notdeleted;
        $ins->save();
    }

}
