    <?php

class ProfessorController extends BaseController {

    public function getIndex() {
        $profile = Admin::where('uid', '=', Session::get('uid'))->get();
        $destination = public_path() . '/smps/avatar';
        $news = Njoftimet::join('administrata', 'administrata.uid', '=', 'njoftimet.uid')
                ->where('to_grp', 'LIKE', '%' . $profile[0]['grp'] . '%')
                ->select('titulli', 'msg', DB::raw("DATE_FORMAT(njoftimet.`created_at`,'%d/%m/%Y %H:%i') as data"), 'idnjoftimet'
                        , DB::raw("CONCAT(administrata.`emri`,' ',administrata.`mbiemri`) as Autori")
                        , 'avatar')
                ->get();
        $active = AssignProf::where('uid', '=', Session::get('uid'))
                ->where('active', '=', Enum::active)
                ->get();
        // Krijimi orarit
        $orari = Orari::join('lendet', 'lendet.idl', '=', 'orari.idl', DB::raw("inner join assign_prof on assign_prof.uid = " . Session::get('uid') . " inner"))
                ->where('assign_prof.active', '=', Enum::active)
                ->select('lendet.Emri as Lendet', DB::raw("date_format(`ora`,'%H:%i') as ora "), 'dita')
                ->orderby('dita', 'ASC')
                ->orderby('ora', 'ASC')
                ->get();
        $oraristats = array();
        foreach ($orari as $value) {
            $oraristats[$value['dita']][] = $value;
        }
        $template = null;
        $template = "<table class=\"table\">";
        foreach ($oraristats as $value) {
            for ($i = 0; $i < count($value); $i++) {
                if ($i == 0) {
                    if ($value[$i]['dita'] + 1 == date('N')) {
                        $template .= "<tr class='bg-info'>";
                    } else {
                        $template .= "<tr>";
                    }
                    $template .= "<th rowspan=\"" . count($value) . "\" >" . Enum::convertday($value[$i]['dita']) . "</th>";
                    $template .= "<td>" . $value[$i]['ora'] . "</td>";
                    $template .= "<td>" . $value[$i]['Lendet'] . "</td>";
                    $template .= "</tr>";
                } else {
                    if ($value[$i]['dita'] + 1 == date('N')) {
                        $template .= "<tr class='bg-info'>";
                    } else {
                        $template .= "<tr>";
                    }
                    $template .= "<td>" . $value[$i]['ora'] . "</td>";
                    $template .= "<td>" . $value[$i]['Lendet'] . "</td>";
                    $template .= "</tr>";
                }
            }
        }
        $template .= "</table>";

        $lactive_pre = AssignProf::join('lendet', 'lendet.idl', '=', 'assign_prof.idl')
                        ->where('uid', '=', Session::get('uid'))->get();
        $lactive = array('' => Lang::get('general.vijushmeria_student'));
        foreach ($lactive_pre as $value) {
            $lactive[$value['idl']] = $value['Emri'];
        }
        $latestpost = Webpost::getLatestpost();
        $post = Webpost::getSlide();
        //SELECT * FROM `notimet` where idl=77 and paraqitja=2 and locked = 0

        $vijushmeria = Vijushmeria::getStudentVijushmeriaProf();
        $genrap = array('' => Lang::get('general.print_list_grade')); 
        foreach ($lactive_pre as $value) {
            $genrap[$value['idl']] = $value['Emri'];
        }
        return View::make('prof/index2', ['title' => Lang::get('general.register_prof'),
                    'news' => self::getNews(),
                    'njoftimet' => $news,
                    'i' => 1,
                    'destination' => "http://www.vpa-uni.com/smpsfile/avatar",
                    'orari' => $orari,
                    'template' => $template,
                    'lastvar' => null,
                    'lactive' => $lactive,
                    'post' => $post,
                    'genrap'=>$genrap,
                    'latest_post' => $latestpost,
                    'vijushmeria' => $vijushmeria
        ]);
    }

    public function getPrst() {
        
        return View::make('prof.vijushmeria', ['vijushmeria' => Vijushmeria::getStudentVijushmeriaProf()]);
    }

    public function getMyprofile() {

        $prof = Admin::getMyprofile();
        return View::make('prof.myprofile', ['title' => Lang::get('general.register_prof'),
                    'news' => self::getNews(),
                    'prof' => $prof[0],
                    'lendet' => AssignProf::getLendetProf()
        ]);
    }

    public function getRapnotave() {
        return Notimet::RaportiNotavePrint();
    }

    public function getInbox() {

        $msg = MsgInbox::orwhere(function($query) {
                    $query->where('to', '=', Session::get('uid'));
                })
                ->where('thread', '=', Enum::thread)
                ->where('deleted', '=', Enum::notdeleted)
                ->join('personlist', 'personlist.uid', '=', 'inbox_msg.uid')
                ->orderby('updated_at', 'DESC')
                ->get();
        return View::make('prof.inbox', ['title' => 'Inbox', 'msg' => $msg, 'news' => self::getNews()]);
    }

    public function getRead($id) {

        $msg = MsgInbox::getMsgDetail($id, Enum::prof);

        return $msg;
    }

    public function postSend() {
        $rules = array('search' => 'required',
            'title' => 'required',
            'msg' => 'required');
        $valid = Validator::make(Input::all(), $rules);

        if ($valid->passes()) {
            MsgInbox::sendmsg();

            Session::flash('notification', self::getSucmsg(Lang::get('warn.succes_send')));
            return Redirect::back();
        } else {
            return self::getErrormsg(Lang::get('warn.error_undefined'));
        }
    }

    public function postReply($id) {
        return MsgInbox::reply($id);
    }

    public function postSearch() {
        return Admin::postIndex();
    }

    public function getLigjeratat() {

        return View::make('prof.attach.index', ['title' => 'Ligjeratat',
                    'news' => self::getNews(),
                    'attach' => AssignProf::getActiveProfCrCombo()
        ]);
    }

    public function postLigjeratatList() {
        return View::make('prof.attach.listrow', ['ligjeratat' => Ligjeratat::getLigjeratatProf(), 'ushtrime' => Ligjeratat::getUshtrimerProf(), 'i' => 0, 'j' => 0]);
    }

    public function postUploadLigj() {
        $rules = array('actvlnd' => 'required|numeric',
            "title" => 'required'
        );
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            // Uploadimi Ligjeratave
            if (Input::hasFile('uploadl') && Input::get('ushtrime') == 0 && Input::file('uploadl')->getClientOriginalExtension() != 'php' && Input::file('uploadl')->getClientOriginalExtension() != 'PHP') {
                $size = Input::file('uploadl')->getSize();
                $destination = public_path() . '/smpsfile/ligjeratat/' . date('Y') . '/' . Input::get('actvlnd');
                $filename = "/" . str_random(20) . '_' . Input::file('uploadl')->getClientOriginalName();
                Input::file('uploadl')->move($destination, $filename);
                if (Ligjeratat::InsertLigjeratat($size, $filename)) {
                    Session::flash('notification', self::getSucmsg(Lang::get('warn.success_upload_attachment')));
                }
            }
        }
        if (Input::get('ushtrime') == 1) {
            // Uploadimi Ushtrimeve
            if (Input::hasFile('uploadu') && Input::get('titleu') != null && Input::file('uploadu')->getClientOriginalExtension() != 'php' && Input::file('uploadu')->getClientOriginalExtension() != 'PHP') {
                $size = Input::file('uploadu')->getSize();
                $destination = public_path() . '/smpsfile/ligjeratat/' . date('Y') . '/' . Input::get('actvlnd');
                $filename = "/" . str_random(20) . '_' . Input::file('uploadu')->getClientOriginalName();
                Input::file('uploadu')->move($destination, $filename);
                if (Ligjeratat::InsertUshtrime($size, $filename)) {
                    Session::flash('notification', self::getSucmsg(Lang::get('warn.success_upload_attachment')));
                }
            }
        }
        return Redirect::back();
    }

    public function postDeleteLigjerata() {
        $valid = Validator::make(Input::all(), array('idlu' => 'required'));
        if ($valid->passes()) {
            $deleted = Ligjeratat::DeleteLigjerata();
            if ($deleted == TRUE) {
                Session::flash('deleted', self::getSucmsg(Lang::get('warn.success_deleted_upload_attachment')));
            } else {

                Session::flash('deleted', self::getErrormsg(Lang::get('warn.error_undefined')));
            }
        } else {
            Session::flash('deleted', self::getErrormsg(Lang::get('warn.error_undefined')));
        }
        return Redirect::back();
    }

    public function getLigjeratatOnline() {
        return "/smpsfile/ligjeratat/" . date('Y') . '/77/eu.pdf';
    }

}
