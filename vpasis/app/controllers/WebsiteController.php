<?php

class WebsiteController extends BaseController {
    /*
     * |-------------------------------------------------------------------------- | Return Lendet |-------------------------------------------------------------------------- |@ Return @var | input Drejtimin |
     */

    public function getIndex($error=0) {
        $webquickmenu = Webquickmenu::getQuickMenu();
        $category = Webcategory::getCategory();
        $latest_post = Webpost::getLatestpost();
        $slide = Webpost::getSlide();
        
        if($error){
            return View::make('website.errors.404', ['title' => 'Vizioni Per Arsim VPA',
                    'descript' => "Vizioni per arsim mundeson ndertimin e se ardhmes, perparimin ne karrier,Vizioni per arsim offron fakultetin e shkencave kompjuterike, Menaxhment dhe Informatik, Ekonomi.",
                    'quickmenu' => $webquickmenu,
                    'category' => $category,
                    'latest_post' => $latest_post,
                    'slide' => $slide]);
        }
        return View::make('website.post', ['title' => 'Vizioni Per Arsim VPA',
                    'descript' => "Vizioni per arsim mundeson ndertimin e se ardhmes, perparimin ne karrier,Vizioni per arsim offron fakultetin e shkencave kompjuterike, Menaxhment dhe Informatik, Ekonomi.",
                    'quickmenu' => $webquickmenu,
                    'category' => $category,
                    'latest_post' => $latest_post,
                    'slide' => $slide]);
    }

    public function getPost($id) {
        $webquickmenu = Webquickmenu::getQuickMenu();
        $category = Webcategory::getCategory();
        $post = Webpost::where('id', $id)
                        ->first();
        $listpost = Webpost::listPostCategory($id);
        $navig = Webcategory::makeNavigation($post['cid']);
        return View::make('website.postread', ['title' => $post->getCategory['name_'.Session::get('lang')] . " Vizioni Per Arsim VPA",
                    'descript' => substr($post->getCategory['name_'.Session::get('lang')], 0, 230),
                    'category' => $category,
                    'quickmenu' => $webquickmenu,
                    'post' => $post,
                    'listpost' => $listpost,
                    'navigation' => $navig]);
    }

    public function getTeam() {
        $webquickmenu = Webquickmenu::getQuickMenu();
        $category = Webcategory::getCategory();
        return View::make('website.team', ['title' => 'titulli',
                    'category' => $category,
                    'quickmenu' => $webquickmenu]);
    }

    public function getCategory($id) {
        $webquickmenu = Webquickmenu::getQuickMenu();
        $category = Webcategory::getCategory();
        $posts = Webpost::where('cid',$id)->get();
        if(count($posts) == 0){
            return Redirect::action('WebsiteController@getIndex');
        }
        return View::make('website.category', ['title' => $posts[0]->getCategory['name_'.Session::get('lang')] . " Vizioni Per Arsim VPA",
                    'descript' => substr($posts[0]->getCategory['name_'.Session::get('lang')], 0, 230),
                    'category' => $category,
                    'quickmenu' => $webquickmenu,
                    'posts' => $posts]);
    }

    public function getDev() {

        $webquickmenu = Webquickmenu::getQuickMenu();
        $category = Webcategory::getCategory();
        return View::make('website.test', ['title' => 'titulli',
                    'quickmenu' => $webquickmenu,
                    'category' => $category,
                    'category' => null]);
    }

    public function getWebadmin() {

        return View::make('website.webadmin', ['title' => 'titulli']);
    }

    public function getGaleria($id = null) {
        if (is_numeric($id)) {
            $webquickmenu = Webquickmenu::getQuickMenu();
            $category = Webcategory::getCategory();
            $photo = Webgaleria::getPhoto($id);
            return View::make('website.galeri', ['title' => 'Galeria VPA Vizini Per Arsim',
                        'quickmenu' => $webquickmenu,
                        'descript' => "Vizioni per arsim mundeson ndertimin e se ardhmes, perparimin ne karrier,Vizioni per arsim offron fakultetin e shkencave kompjuterike, Menaxhment dhe Informatik, Ekonomi.",
                        'category' => $category,
                        'album' => $photo,
                        'i' => 0]);
        } else {
            $webquickmenu = Webquickmenu::getQuickMenu();
            $category = Webcategory::getCategory();
            $album = Webalbum::getAlbum();
            return View::make('website.album', ['title' => 'Galeria VPA Vizini Per Arsim',
                        'quickmenu' => $webquickmenu,
                        'descript' => "Vizioni per arsim mundeson ndertimin e se ardhmes, perparimin ne karrier,Vizioni per arsim offron fakultetin e shkencave kompjuterike, Menaxhment dhe Informatik, Ekonomi.",
                        'category' => $category,
                        'album' => $album]);
        }
    }

    public function getAplikoOnline() {
        $dtemp = Drejtimet::all();

        $drejtimet = array('' => '');
        foreach ($dtemp as $id => $value) {
            $drejtimet[$value['idDrejtimet']] = $value['Emri'];
        }
        unset($dtemp);
        $statusi = array(Enum::irregullt => Lang::get('general.regular'),
            Enum::joirregullt => Lang::get('general.notregular'));

        $webquickmenu = Webquickmenu::getQuickMenu();
        $category = Webcategory::getCategory();
        return View::make('website.applikoonline', ['title' => 'Apliko onnline tani Vizioni Per Arsim VPA',
                    'descript' => "Vizioni per arsim mundeson ndertimin e se ardhmes, perparimin ne karrier,Vizioni per arsim offron fakultetin e shkencave kompjuterike, Menaxhment dhe Informatik, Ekonomi.",
                    'quickmenu' => $webquickmenu,
                    'category' => $category,
                    'drejtimi' => $drejtimet,
                    'statusi' => $statusi]);
    }

    public function getLanguage($lang) {
        if ($lang) {
            Session::put('lang', $lang);
        }
        App::setLocale(Session::get('lang'));
        return Redirect::to('/');
    }

    public function postAplikoOnlineTani() {
        $rules = array('emri' => 'required',
            'mbiemri' => 'required',
            'pemri' => 'required',
            'pmbiemri' => 'required',
            'datlindja' => 'required',
            'vendlindja' => 'required',
            'idpersonal' => 'required',
            'shteti' => 'required',
            'adressa' => 'required',
            'drejtimet' => 'required|numeric',
            'status' => 'numeric|required',
            'level' => 'required|numeric',
            'qualification' => 'required');
        $valid = Validator::make(Input::all(), $rules);
        $filename = null;
        $vitiaka = null;
        if ($valid->passes()) {
            $rules1 = array('img' => 'image');

            $valid1 = Validator::make(Input::all(), $rules1);
            if (Input::hasFile('img') && $valid1->passes()) {

                $destination = public_path() . '/smpsfile/avatar/';
                $filename = "/" . str_random(20) . '_' . Input::file('img')->getClientOriginalName();
                Input::file('img')->move($destination, $filename);
                $avatar = 1;
            }

            if (Input::get('transfer') != null) {
                $vitiaka = 1;
            }
            Studenti::setApplikoOnline($filename, $vitiaka);
            Session::flash('notification', self::getSucmsg(Lang::get('warn.success_apply_student')));
        } else {
            Session::flash('notification', self::getErrormsg(Lang::get('warn.error_apply_student')));
        }

        return Redirect::to('/apliko-online');
    }

}
