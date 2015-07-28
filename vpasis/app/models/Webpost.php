<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Webpost extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'web_post';

    public static function getLatestpost() {
        return self::where('web_post.deleted', '=', Enum::notdeleted)
                        ->where('NewsFeed', '=', '1')
                        ->join('web_category', 'web_category.id', '=', 'web_post.cid')
                        ->orderby('web_post.created_at', 'DESC')
                        ->take(6)
                        ->select('web_post.titulli', 'web_post.msg', 'web_post.id', 'web_post.img', 'web_category.emri')
                        ->get();
    }

    public static function getAllpost() {
        return self::where('web_post.deleted', '=', Enum::notdeleted)
                        ->join('administrata', 'administrata.uid', '=', 'web_post.uid')
                        ->join('web_category', 'web_category.id', '=', 'web_post.cid')
                        ->orderby('web_post.created_at', 'DESC')
                        ->select('web_post.titulli as titulli', DB::raw('web_category.emri as kategoria'), DB::raw("CONCAT(administrata.`emri`, ' ' ,administrata.`mbiemri`) as `postuesi`"), 'web_post.slide as slide', 'web_post.id as idpost', 'web_post.msg as post', 'web_post.cid as catid', 'web_post.img as img')
                        ->get();
    }

    public static function readPost($id) {
        return self::where('web_post.id', '=', $id)
                        ->where('web_post.deleted', '=', Enum::notdeleted)
                        ->select('web_post.titulli', 'web_post.msg', 'web_post.id', 'web_post.img', 'web_post.cid', DB::raw("DATE_FORMAT(web_post.`updated_at`,'%d-%m-%Y') as `published`"))
                        ->get();
    }

    public static function listPostCategory($id) {
        $cat = self::readPost($id);
        if (count($cat) > 0)
            return self::where('cid', '=', $cat[0]['cid'])
                            ->where('web_post.deleted', '=', Enum::notdeleted)->take(10)->get();
        else
            return null;
    }

    public static function postInCategory($id) {
        $post = self::where('web_post.cid', '=', $id)
                        ->join('web_category', 'web_category.id', '=', 'web_post.cid')
                        ->select('web_post.id as idp', 'web_post.titulli as titulli', 'web_post.img as img', 'web_category.emri as cat')
                        ->take(10)->get();
        if (count($post) > 0)
            return $post;
        else
            return array();
    }

    public static function getSlide() {
        return self::where('slide', '=', 1)->take(7)->orderby('created_at', 'DESC')->get();
    }

}
