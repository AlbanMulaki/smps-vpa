<?php

class AdminwebsiteController extends BaseController {

    public function getIndex() {
        return View::make('admin.website.setting');
    }

    public function getPost() {
        $post = Webpost::getAllpost();
        $cat = Webcategory::getAllCategorySelect();
        return View::make('admin.website.post', ['post' => $post, 'cat' => $cat]);
    }

    public function getQuickcat() {
        return View::make('admin.website.quickcat');
    }

    public function postPedit() {
        $msg = Input::get('msg');
        //  $msg = str_replace("\n", "<br>", $msg);
        $rules = array('idp' => 'numeric|required',
            'titulli' => 'required',
            'msg' => 'required',
            'cat' => 'numeric|required',
            'slide' => 'numeric|required');
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {

            $avatar = null;
            if (Input::hasFile('img')) {
                $destination = public_path() . '/img';
                $filename = "/" . str_random(20) . '_.' . Input::file('img')->getClientOriginalExtension();
                Input::file('img')->move($destination, $filename);
                $avatar = $filename;
                $update = array('titulli' => Input::get('titulli'),
                    'msg' => $msg,
                    'cid' => Input::get('cat'),
                    'slide' => Input::get('slide'),
                    'img' => $avatar);
            } else {

                $update = array('titulli' => Input::get('titulli'),
                    'msg' => $msg,
                    'cid' => Input::get('cat'),
                    'slide' => Input::get('slide'));
            }
            Webpost::where('id', '=', Input::get('idp'))->update($update);
            return Redirect::to('/smps/admin/website/post')->with('notification', self::getSucmsg(Lang::get('website.update_success')));
        } else {
            return Redirect::to('/smps/admin/website/post')->with('notification', self::getErrormsg(Lang::get('website.undefied_error')));
        }
    }

    public function postAddpost() {
        $rules = array('titulli' => 'required',
            'msg' => 'required',
            'cat' => 'required|numeric',
            'slide' => 'required|numeric');
        $valid = Validator::make(Input::all(), $rules);

        if ($valid->passes()) {
            $avatar = "null";
            if (Input::hasFile('img')) {
                $destination = public_path() . '/img';
                $filename = "/" . str_random(20) . '_.' . Input::file('img')->getClientOriginalExtension();
                Input::file('img')->move($destination, $filename);
                $avatar = $filename;
            }
            $post = new Webpost();
            $post->titulli = Input::get('titulli');
            $post->msg = Input::get('msg');
            $post->cid = Input::get('cat');
            $post->slide = Input::get('slide');
            $post->img = $avatar;
            $post->uid = Session::get('uid');
            $post->deleted = Enum::notdeleted;
            $post->save();
            return Redirect::to('/smps/admin/website/post')->with('notification', self::getSucmsg(Lang::get('website.update_success')));
        } else {
            return Redirect::to('/smps/admin/website/post')->with('notification', self::getErrormsg(Lang::get('website.undefied_error')));
        }
    }

    // Delete POST
    public function postDelete() {
        $rules = array('idp' => 'required');
        $valid = Validator::make(Input::all(), $rules);

        if ($valid->passes()) {
            Webpost::where('id', '=', Input::get('idp'))->update(array('deleted' => Enum::deleted));
            return Redirect::to('/smps/admin/website/post')->with('notification', self::getSucmsg(Lang::get('website.update_success')));
        } else {
            return Redirect::to('/smps/admin/website/post')->with('notification', self::getErrormsg(Lang::get('website.undefied_error')));
        }
    }

    public function getGaleri() {
        $album = Webalbum::getAlbum();
        return View::make('admin.website.galeria', ['album' => $album]);
    }

    // Delete Photo
    public function getGaleritDelete($id) {

        if ($id != null) {
            Webgaleria::DeletePhoto($id);
            Session::flash('notification', self::getSucmsg(Lang::get('warn.success_delete_course')));
            return Redirect::to(action('AdminwebsiteController@getGaleri'));
        } else {
            Session::flash('notification', self::getErrormsg(Lang::get('warn.undefied_error')));
            return Redirect::to(action('AdminwebsiteController@getGaleri'));
        }
    }

    public function postGaleriAdd() {
        $rules = array('img' => 'required|mimes:png,gif,jpeg');
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {

            $size = Input::file('img')->getSize();
            $destination = public_path() . '/img/';
            $filename = "/" . str_random(20) . '_' . Input::file('img')->getClientOriginalName();
            Input::file('img')->move($destination, $filename);
            Webgaleria::AddPhoto($filename);
            Session::flash('notification', self::getSucmsg(Lang::get('warn.success_delete_course')));
            return Redirect::to(action('AdminwebsiteController@getGaleri'));
        }
        Session::flash('notification', self::getErrormsg(Lang::get('warn.undefied_error')));
        return Redirect::to(action('AdminwebsiteController@getGaleri'));
    }

    public function postAlbumUpdate() {
        $valid = Validator::make(Input::all(), array('titulli' => 'required', 'aid' => 'required|numeric'));
        if ($valid->passes()) {
            Webalbum::UpdateAlbum();
            Session::flash('notification', self::getSucmsg(Lang::get('warn.success_update')));
            return Redirect::to(action('AdminwebsiteController@getGaleri'));
        } else {
            Session::flash('notification', self::getErrormsg(Lang::get('warn.undefied_error')));
            return Redirect::to(action('AdminwebsiteController@getGaleri'));
        }
    }

    public function postAlbumAdd() {
        $rules = array('titulli' => 'required');
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            $size = Input::file('img')->getSize();
            $destination = public_path() . '/img/';
            $filename = "/" . str_random(20) . '_' . Input::file('img')->getClientOriginalName();
            Input::file('img')->move($destination, $filename);
            Webalbum::InsertAlbum($filename);
            Session::flash('notification', self::getSucmsg(Lang::get('warn.success_album_created')));
            return Redirect::to(action('AdminwebsiteController@getGaleri'));
        } else {
            Session::flash('notification', self::getErrormsg(Lang::get('warn.undefied_error')));
            return Redirect::to(action('AdminwebsiteController@getGaleri'));
        }
    }
    public function getAlbumDelete($id){
        
        if ($id != null) {
            Webalbum::DeleteAlbum($id);
            Session::flash('notification', self::getSucmsg(Lang::get('warn.success_delete_course')));
            return Redirect::to(action('AdminwebsiteController@getGaleri'));
        } else {
            Session::flash('notification', self::getErrormsg(Lang::get('warn.undefied_error')));
            return Redirect::to(action('AdminwebsiteController@getGaleri'));
        }
    }

}
