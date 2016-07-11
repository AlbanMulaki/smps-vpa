<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Webcategory extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'web_category';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public static function getCategory() {
        $ready = "<ul class=\"category\">";
        $all_cat = self::where('tree', '=', 0)
                ->where('cid', '=', 0)
                ->orderby('prioid', 'ASC')
                ->get();
        foreach ($all_cat as $value) {
            if ($value['id'] == 2 || $value['id'] == 3) {
                $ready .= "<li><a href='/#' >" . $value['name_'.Session::get('lang')] . "</a>";
            } else if ($value['link'] == 1) {
                $ready .= "<li><a href='" . action('WebsiteController@getCategory') . "/" . $value['id'] . "' >" . $value['name_'.Session::get('lang')] . "</a>";
            } else {
                $ready .= "<li><a href='" . $value['link'] . "' >" . $value['name_'.Session::get('lang')] . "</a></li>";
            }
            $nested = self::where('cid', '=', $value['id'])->get();
            if (count($nested) > 0) {
                $ready .= "<ul>";
                foreach ($nested as $val) {
                    if ($val['link'] == 1) {
                        $ready .= "<li><a href='" . action('WebsiteController@getCategory') . "/" . $val['id'] . "' >" . $val['name_'.Session::get('lang')] . "</a></li>";
                    } else {
                        $ready .= "<li><a href='" . $val['link'] . "' >" . $val['name_'.Session::get('lang')] . "</a></li>";
                    }
                }
                $ready .= "</ul>";
            }
            $ready .= "</li>";
        }
        $ready .= "</ul>";
        return $ready;
    }

    public static function makeNavigation($id) {
        $basicnav = self::where('id', '=', $id)->get();
        $ready = null;
        if (count($basicnav) > 0) {
            foreach ($basicnav as $value) {
                $basicnav1 = self::where('id', '=', $value['cid'])->get();
                $ready[] = "<li>" . $value['name_'.Session::get('lang')] . "</li>";
                if (count($basicnav1) > 0) {
                    foreach ($basicnav1 as $value1) {
                        $basicnav2 = self::where('id', '=', $value1['cid'])->get();
                        $ready[] = "<li>" . $value1['name_'.Session::get('lang')] . "</li>";

                        if (count($basicnav2) > 0) {
                            foreach ($basicnav2 as $value2) {
                                $basicnav3 = self::where('id', '=', $value2['cid'])->get();
                                $ready[] = "<li>" . $value2['name_'.Session::get('lang')] . "</li>";
                                if (count($basicnav3) > 0) {
                                    foreach ($basicnav3 as $value3) {
                                        $basicnav4 = self::where('id', '=', $value3['cid'])->get();
                                        $ready[] = "<li>" . $value3['name_'.Session::get('lang')] . "</li>";
                                        if (count($basicnav4) > 0) {
                                            foreach ($basicnav4 as $value4) {
                                                $ready[] = "<li>" . $value4['name_'.Session::get('lang')] . "</li>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $ready = array_reverse($ready);

        $ready[count($ready) - 1] = str_replace("<li>", "<li class=\"navbreadactive\">", last($ready));
        $ready = implode("", $ready);
        return $ready;
    }

    public static function getAllCategorySelect() {
        $cat = self::all();
        $select_prepare = array();
        foreach ($cat as $value) {
            $select_prepare[$value['id']] = $value['emri'];
        }
        return $select_prepare;
    }

}

/*
        <ul class="category">

            @foreach($category as $value)
            @if($value['tree'] == 0)
            <li><a href='{{ $value['emri'] }}'>{{ $value['emri'] }}</a></li>

            @endif
            @endforeach
        </ul>
 * 
 */
