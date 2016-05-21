<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Webpost extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait,
        SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'web_post';

    public static function getLatestpost() {
        return self::where('NewsFeed', '=', '1')
                        ->join('web_category', 'web_category.id', '=', 'web_post.cid')
                        ->orderby('web_post.created_at', 'DESC')
                        ->take(6)
                        ->select('web_post.title_en','web_post.title_sq', 'web_post.description_sq','web_post.description_en', 'web_post.id', 'web_post.img', 'web_category.name_sq as category_sq', 'web_category.name_en as category_en')
                        ->get();
    }

    public static function getAllpost() {
        return self::join('administrata', 'administrata.uid', '=', 'web_post.uid')
                        ->join('web_category', 'web_category.id', '=', 'web_post.cid')
                        ->orderby('web_post.created_at', 'DESC')
                        ->get();
    }

    public static function readPost($id) {
        return self::where('web_post.id', '=', $id)
                        ->get();
    }

    public static function listPostCategory($id) {
        $cat = self::readPost($id);
        if (count($cat) > 0)
            return self::where('cid', '=', $cat[0]['cid'])
                            ->take(10)->get();
        else
            return null;
    }

    public static function postInCategory($id) {
        $post = self::where('web_post.cid', '=', $id)
                        ->join('web_category', 'web_category.id', '=', 'web_post.cid')
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
