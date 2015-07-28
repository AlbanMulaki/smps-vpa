<?php

class BaseController extends Controller {
    /* ________________________________
      | Autori: Alban Mulaki           |
      | E-Mail: alban.mulaki@gmail.com |
      ________________________________
     */

    private $base = 'vpasis';
    private $rangeadmin = 900000;
    private $baseapp = 'vpasis';
    private $cvdir = 'cv';

    public function printdir($name, $id, $user) {
        return $_SERVER['DOCUMENT_ROOT'] . "/../" . self::getBaseapp() . "/app/print/" . date("Y") . '/' . $name . '_' . $id . "_" . date('Y_m_d_(H_i_s)') . '_' . $user . '_' . str_random(4) . '.pdf';
    }

    public function img_public($name, $id = null, $user = null) {
        return $_SERVER['DOCUMENT_ROOT'] . "/img/";
    }

    public function getErrormsg($msg) {
        return "<div class=\"alert alert-danger\" role=\"alert\">" . $msg . "</div>";
    }

    public function getSucmsg($msg) {
        return "<div class=\"alert alert-success\" role=\"alert\">" . $msg . "</div>";
    }

    public function getWarnmsg($msg) {
        return "<div class=\"alert alert-warning\" role=\"alert\">" . $msg . "</div>";
    }

    public function getBase() {
        return $this->base;
    }

    public function getRange() {
        return $this->rangeadmin;
    }

    public function getBaseapp() {
        return $this->baseapp;
    }

    private $news = array('inbox' => null, 'total' => null); // Num Notification

    public function getNews() {
        $this->news['inbox'] = MsgInbox::getNews();
        $this->news['total'] = $this->news['inbox'];
        return $this->news;
    }

    private $title = 'SMPS - VPA';

    public function __construct() {

        // Bind Default data on load
        View::composer('admin.index', function($view) {
            $logo = Settings::all();

            if (Session::get('uid') >= $this->rangeadmin) {
                $user = Admin::getMyprofile();
            } else {
                $user = Studenti::where('uid', '=', Session::get('uid'))->get();
            }
            $view->with('news', BaseController::getNews())
                    ->with('title', $this->title)
                    ->with('logo', $logo[0]['logo'])
                    ->with('user', $user[0])
                    ->with('university_name', $logo[0]['name_company']);
        });
        View::composer('printa4v', function($view) {
            $logo = Settings::all();
            $view->with('logo', $logo[0]['logo'])
                    ->with('options', $logo[0]);
        });
        View::composer('admin.puntoret.print_kontrata_puntoreve', function($view) {
            $logo = Settings::all();
            $view->with('logo', $logo[0]['logo'])
                    ->with('options', $logo[0]);
        });
    }

    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

}
