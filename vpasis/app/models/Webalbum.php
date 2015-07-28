
<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Webalbum extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'web_album';

    public static function getAlbum() {
        $album = self::where('deleted', '=', Enum::notdeleted)
                ->orderby('created_at', 'DESC')
                ->get();
        $album_ready = $album->toArray();
        for ($i = 0; $i < count($album_ready); $i++) {
            $album_ready[$i]['photo'] = Webgaleria::getPhoto($album_ready[$i]['id']);
            $album_ready[$i]['numphoto'] = Webgaleria::getNumPhoto($album_ready[$i]['id']);
        }
        return $album_ready;
    }

    public static function UpdateAlbum() {
        self::where('id', '=', Input::get('aid'))->update(array('titulli' => Input::get('titulli')));
    }

    public static function InsertAlbum($filename) {
        $ins = new Webalbum();
        $ins->titulli = Input::get('titulli');
        $ins->deleted = Enum::notdeleted;
        $ins->uid = Session::get('uid');
        $ins->link = $filename;
        $ins->save();
    }

    public static function DeleteAlbum($id) {
        self::where('id', '=', $id)->update(array('deleted' => Enum::deleted));
    }

}
