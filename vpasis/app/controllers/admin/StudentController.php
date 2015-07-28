
<?php

class StudentController extends \BaseController {

    public function getPrint() {
        $listStaff = Admin::where('deleted', '=', Enum::notdeleted)->get();
        $pdf = PDF::loadView('admin.students.kontrata_student', [ 'title' => Lang::get('printable.title_contract_studies'),
                    'listStaff' => $listStaff]);
        file_put_contents(self::printdir('ListStaffit', null, Session::get('uid')), $pdf->output());
        return $pdf->stream();
    }

    public function getRegister() {
        $drejtimet = Drejtimet::getComboDrejtimetGroupedAll();
        return View::make('admin.students.register_students', ['drejtimet' => $drejtimet]);
    }

    public function postRegister() {
        $rules = array(
            'emri' => "required",
            "mbiemri" => "required",
            "gjinia" => "required|numeric",
            "nrpersonal" => "required|numeric"
        );

        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            // kontrollimi avatar
            $avatar = "";
            if (Input::file('avatar')) {
                $destination = $_SERVER['DOCUMENT_ROOT'] . "/smpsfl/doc/avatar/";
                $avatar = Input::get('emri') . Input::get('mbiemri') . "_" . date('Y_m_d_(H_i_s)') . '_' . Session::get('uid') . '_' . str_random(4) . '.' . Input::file('avatar')->getClientOriginalExtension();
                Input::file('avatar')->move($destination, $avatar);
            } else {
                $avatar = "default-avatar.png";
            }

            $student = new Studenti();
            $student->emri = ucwords(Input::get('emri'));
            $student->mbiemri = ucwords(Input::get('mbiemri'));
            $student->emri_prindit = ucwords(Input::get('emri_prindit'));
            $student->mbiemri_prindit = ucwords(Input::get('mbiemri_prindit'));
            $student->gjinia = Input::get('gjinia');
            $student->vendlindja = ucwords(Input::get('vendlindja'));
            $student->vendbanimi = ucwords(Input::get('vendbanimi'));
            $student->datalindjes = Input::get('datalindjes');
            $student->shtetas = ucwords(Input::get('shtetas'));
            $student->telefoni = Input::get('telefoni');
            $student->email = Input::get('email');
            $student->nrpersonal = Input::get('nrpersonal');
            $student->psw = Hash::make(Input::get('nrpersonal'));
            $student->kualifikimi = ucwords(Input::get('kualifikimi'));
            $student->semestri = Input::get('semestri');
            $student->drejtimi = Input::get('drejtimi');
            $student->statusi = Input::get('statusi');
            $student->avatar = $avatar;
            $student->niveli = Input::get('niveli');
            $student->viti_aka = Input::get('viti_aka');
            $student->transfer = Input::get('transfer');
            $student->adressa = ucwords(Input::get('adressa'));
            $student->locked = Enum::nolocked;
            $student->grp = Enum::student;
            $student->confirm = Enum::confirmed;
            $student->kontrata_pageses = ucwords(Input::get('kontrata_pageses'));
            $student->keste = ucwords(Input::get('keste'));
            $student->deleted = Enum::notdeleted;
            $student->vpa_registrar = Session::get('uid');
            $pdf = PDF::loadView('admin.students.kontrata_student', [ 'title' => Lang::get('printable.title_contract_studies'),
                        'profile' => Input::all()]);
            $destination = $_SERVER['DOCUMENT_ROOT'] . "/smpsfl/doc/kontrata/student/";
            $filename = Input::get('emri') . Input::get('mbiemri') . "_" . date('Y_m_d_(H_i_s)') . '_' . Session::get('uid') . '_' . str_random(4) . '.pdf';
            $student->kontrata_dir = $filename;
            $student->save();
            file_put_contents($destination . $filename, $pdf->output());
            return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.success_register_administration', array('person' => ucwords(Input::get('emri') . " " . Input::get('mbiemri'))))]);
        }
        return Redirect::back()->with(['message' => Enum::failed, "reason" => Lang::get('warn.error_undefined')]);
    }

    public function getList($id = 0, $drejtimi = 0) {
        $numList = 20;

        if ($drejtimi == 0) {
            $students = Studenti::orderBy('uid', 'DESC')
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->skip($id)
                    ->take($numList)
                    ->get();
            $studentNum = Studenti::select(DB::raw('COUNT(*) as students'))
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->get();
        } else if ($drejtimi > 0) {
            $students = Studenti::orderBy('uid', 'DESC')
                    ->where('drejtimi', '=', $drejtimi)
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->skip($id)
                    ->take($numList)
                    ->get();
            $studentNum = Studenti::select(DB::raw('COUNT(*) as students'))
                    ->where('drejtimi', '=', $drejtimi)
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->get();
        }

        $page = $studentNum[0]['students'] / $numList;
        if ($studentNum[0]['students'] % $numList <= 20) {
            $page = $page + 1;
        }
        $listDrejtimet = Drejtimet::getComboDrejtimetGroupedAll();
        $listDrejtimet[Lang::get('general.choose_subject')][0] = Lang::get('general.choose_subject');
        $selectedPage = $id / $numList;
        return View::make('admin.students.list_students', ["students" => $students,
                    "studentNum" => $studentNum[0]['students'],
                    'page' => $page,
                    'rows' => $id,
                    'limitList' => $numList,
                    'drejtimi' => $drejtimi,
                    'selectedPage' => $selectedPage,
                    'listDrejtimet' => $listDrejtimet
        ]);
    }

    public function getEdit($uid) {
        $profile = Studenti::where('uid', '=', $uid)->get();
        $drejtimet = Drejtimet::getComboDrejtimetGroupedAll();
        return View::make('admin.students.edit', ['profile' => $profile[0],
                    'drejtimet' => $drejtimet]);
    }

    public function postEdit() {
        $rules = array(
            'uid' => "required",
            'emri' => "required",
            "mbiemri" => "required",
            "gjinia" => "required|numeric",
            "nrpersonal" => "required|numeric"
        );

        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            // kontrollimi avatar
            if (Input::file('avatar')) {
                $destination = $_SERVER['DOCUMENT_ROOT'] . "/smpsfl/doc/avatar/";
                $avatar = Input::get('emri') . Input::get('mbiemri') . "_" . date('Y_m_d_(H_i_s)') . '_' . Session::get('uid') . '_' . str_random(4) . '.' . Input::file('avatar')->getClientOriginalExtension();
                Input::file('avatar')->move($destination, $avatar);
            } else {
                $avatar = Input::get('avatarname');
            }
            $update = array(
                "emri" => ucwords(Input::get('emri')),
                "mbiemri" => ucwords(Input::get('mbiemri')),
                "emri_prindit" => ucwords(Input::get('emri_prindit')),
                "mbiemri_prindit" => ucwords(Input::get('mbiemri_prindit')),
                "vendbanimi" => ucwords(Input::get('vendbanimi')),
                "datalindjes" => Input::get('datalindjes'),
                "adressa" => ucwords(Input::get('adressa')),
                "shtetas" => ucwords(Input::get('shtetas')),
                "telefoni" => Input::get('telefoni'),
                "email" => Input::get('email'),
                "nrpersonal" => Input::get('nrpersonal'),
                "avatar" => $avatar,
                "gjinia" => Input::get('gjinia'),
                "niveli" => Input::get('niveli'),
                "statusi" => Input::get('statusi'),
                "drejtimi" => Input::get('drejtimi'),
                "semestri" => Input::get('semestri'),
                "kualifikimi" => ucwords(Input::get('kualifikimi')),
                "vendlindja" => ucwords(Input::get('vendlindja')),
                "transfer" => Input::get('transfer'),
                "viti_aka" => Input::get('viti_aka'),
                "kontrata_pageses" => Input::get('kontrata_pageses'),
                "keste" => Input::get('keste')
            );
            Studenti::where('uid', '=', Input::get('uid'))->update($update);
            return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.success_update')]);
        }
        return Redirect::back()->with(['message' => Enum::failed, "reason" => Lang::get('warn.error_undefined')]);
    }

    public function getDelete($uid) {
        if ($uid) {
            $update = array('deleted' => Enum::deleted);
            Studenti::where('uid', '=', $uid)->update($update);
            return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.delete_student')]);
        }
        return Redirect::back()->with(['message' => Enum::failed, "reason" => Lang::get('warn.error_undefined')]);
    }

    public function getProfile($uid) {


        $profile = Studenti::where('uid', '=', $uid)->get();
        $drejtimet = Drejtimet::getComboDrejtimetGroupedAll();

        $vijushmeria = Vijushmeria::join('administrata', 'administrata.uid', '=', 'vijushmeria.professor')
                ->join('lendet', 'lendet.idl', '=', 'vijushmeria.idl')
                ->select(DB::raw('CONCAT(administrata.emri,\' \',administrata.mbiemri) as prof'), 'lendet.Emri as lenda', 'lendet.idl as idl')
                ->groupBy('vijushmeria.idl')
                ->where('studenti', '=', $uid)
                ->where('vijushmeria.deleted', '=', Enum::notdeleted)
                ->get();
        $vijushmeria_ = $vijushmeria;
        $i=0;
        foreach ($vijushmeria_ as $value) {
            $vijushmeria[$i++]['numhour'] = Vijushmeria::where('idl', '=', $value['idl'])->count();
        }

        return View::make('admin.students.profile', ['profile' => $profile[0],
                    'drejtimet' => $drejtimet,
                    'vijushmeria' => $vijushmeria]);
    }

    public function getListPrintPdfDirect($id = 0, $drejtimi = 0) {
        $numList = 20;

        if ($drejtimi == 0) {
            $students = Studenti::orderBy('uid', 'DESC')
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->skip($id)
                    ->take($numList)
                    ->get();
            $studentNum = Studenti::select(DB::raw('COUNT(*) as students'))
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->get();
        } else if ($drejtimi > 0) {
            $students = Studenti::orderBy('uid', 'DESC')
                    ->where('drejtimi', '=', $drejtimi)
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->skip($id)
                    ->take($numList)
                    ->get();
            $studentNum = Studenti::select(DB::raw('COUNT(*) as students'))
                    ->where('drejtimi', '=', $drejtimi)
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->get();
        }

        $page = $studentNum[0]['students'] / $numList;
        if ($studentNum[0]['students'] % $numList <= 20) {
            $page = $page + 1;
        }
        $listDrejtimet = Drejtimet::getComboDrejtimetGroupedAll();
        $listDrejtimet[Lang::get('general.choose_subject')][0] = Lang::get('general.choose_subject');
        $selectedPage = $id / $numList;


        $pdf = PDF::loadView('admin.students.print_list_students', [ 'title' => Lang::get('printable.title_list_student'),
                    'students' => $students,
                    'drejtimi' => $drejtimi]);
        return $pdf->stream();
    }

    public function getListPrintPdf($id = 0, $drejtimi = 0) {
        $numList = 20;

        if ($drejtimi == 0) {
            $students = Studenti::orderBy('uid', 'DESC')
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->skip($id)
                    ->take($numList)
                    ->get();
            $studentNum = Studenti::select(DB::raw('COUNT(*) as students'))
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->get();
        } else if ($drejtimi > 0) {
            $students = Studenti::orderBy('uid', 'DESC')
                    ->where('drejtimi', '=', $drejtimi)
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->skip($id)
                    ->take($numList)
                    ->get();
            $studentNum = Studenti::select(DB::raw('COUNT(*) as students'))
                    ->where('drejtimi', '=', $drejtimi)
                    ->where('confirm', '=', Enum::confirmed)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->get();
        }

        $page = $studentNum[0]['students'] / $numList;
        if ($studentNum[0]['students'] % $numList <= 20) {
            $page = $page + 1;
        }
        $listDrejtimet = Drejtimet::getComboDrejtimetGroupedAll();
        $listDrejtimet[Lang::get('general.choose_subject')][0] = Lang::get('general.choose_subject');
        $selectedPage = $id / $numList;


        $pdf = PDF::loadView('admin.students.print_list_students', [ 'title' => Lang::get('printable.title_list_student'),
                    'students' => $students,
                    'drejtimi' => $drejtimi]);

        file_put_contents(self::printdir('ListStudentve', null, Session::get('uid')), $pdf->output());
        return $pdf->download(self::printdir('ListStudentve', null, Session::get('uid')));
    }

    public function postSearch() {
        if (is_numeric(Input::get('search'))) {
            if (Input::get('admin') != "admin") {
                $person = self::ById('student');
                return View::make('student.search.searchinbox', ['title' => Lang::get('general.search'), 'person' => $person]);
            } else if (Input::get('admin') == "admin") {
                $person = self::ById('admin');
                return View::make('student.search.searchinbox', ['title' => Lang::get('general.search'), 'person' => $person]);
            }
        } else if (preg_match("/^[a-zA-Z ]+$/ ", Input::get('search'))) {
            if (Input::get('admin') != "admin") {
                $person = self::ByName('student');
                return View::make('student.search.searchinbox', ['title' => Lang::get('general.search'), 'person' => $person]);
            } else if (Input::get('admin') == "admin") {

                $person = self::ByName('admin');
                return View::make('student.search.searchinbox', ['title' => Lang::get('general.search'), 'person' => $person]);
            }
        }
        $student = Studenti::where('uid', 'like', "%" . Input::get('search') . "%")->get();
    }

    private function ById($access) {

        if ($access == "student") {
// Student Search
            return Studenti::where('uid', 'like', "%" . Input::get('search') . "%")->take(7)->get();
        } else {//Staff search
            return Admin::where('uid', 'like', "%" . Input::get('search') . "%")->take(7)->get();
        }
    }

    public function ByName($access) {
        $search = explode(' ', Input::get('search'));
        if ($access == "student") {
            if (count($search) > 1) {
                return Studenti::where('emri', 'like', '%' . $search[0] . '%')->where('mbiemri', 'like', $search[1])->take(5)->get();
            } else if (count($search) == 1) {
                return Studenti::where('emri', 'like', '%' . $search[0] . '%')->orWhere('mbiemri', 'like', '%' . $search[0] . '%')->take(5)->get();
            }
        } else {
            if (count($search) > 1) {
                return Admin::where('emri', 'like', '%' . $search[0] . '%')->where('mbiemri', 'like', $search[1])->take(5)->get();
            } else if (count($search) == 1) {
                return Admin::where('emri', 'like', '%' . $search[0] . '%')->orWhere('mbiemri', 'like', '%' . $search[0] . '%')->take(5)->get();
            }
        }
    }

/// Search End


    public function geList() {
        $profile = Studenti::where('uid', '=', Session::get('uid'))->get();
        $news = Njoftimet::join('administrata', 'administrata.uid', '=', 'njoftimet.uid')
                ->where('to_grp', 'LIKE', '%' . $profile[0]['grp'] . '%')
                ->where('idd', 'LIKE', '%' . $profile[0]['drejtimi'] . '%')
                ->where('deleted', '=', Enum::notdeleted)
                ->where('semestri', 'LIKE', '%' . $profile[0]['semestri'] . '%')
                ->where('njoftimet.created_at', 'LIKE', '%' . date('Y') . '%')
                ->select('titulli', 'msg', DB::raw("DATE_FORMAT(njoftimet.`created_at`,'%d/%m/%Y %H:%i') as data"), 'idnjoftimet'
                        , DB::raw("CONCAT(administrata.`emri`,' ',administrata.`mbiemri`) as Autori")
                        , 'avatar')
                ->get();
        $post = Webpost::getSlide();


// Krijimi orarit
        $orari = Orari::getStudentOrari();
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

        $profile = Studenti::where('uid', '=', Session::get('uid'))->get();
        $pagesat = Pagesat::where('uid', '=', $profile[0]['uid'])
                ->select('shuma', 'pershkrimi', DB::raw("DATE_FORMAT(`created_at`,'%d-%m-%Y') as `cr`"))
                ->get();
        $totali = array('paguara' => 1);
        $kontrata = Kontratat::where('uid', '=', $profile[0]['uid'])
                ->where('type', '=', 0)
                ->get();
        if (count($kontrata) > 0) {
// Borxhi dhe pagesa e kontrates per semester
            foreach ($pagesat as $value) {
                $totali['paguara'] += $value['shuma'];
            }
            $viti = (int) $profile[0]['semestri'] / 2;
            $kont = 1;
            for ($i = 0; $viti > $i; $i++) {
                $kont+=$kontrata[0]['shuma'];
            }

            $totali['perqindja'] = $totali['paguara'] / $kont * 100;
        } else {
            $kontrata = null;
            $kont = null;
            $totali = null;
        }
        $setting = Settings::all();
        if ($setting[0]['zgjedhore_active'] == Enum::active) {
            if (Lendetzgjedhore::getStatusZgjedhore()) {

                $zgjedhore = NULL;
            } else {
                $zgjedhore = View::make('student.zgjedhore', ['zgjedhore' => Lendet::getLendetzgjedhore()]);
            }
        } else {
            $zgjedhore = NULL;
        }
        return View::make('student.index2', ['title' => Lang::get('general.departments'),
                    'njoftimet' => $news,
                    'news' => self::getNews(),
                    'post' => $post,
                    'profile' => $profile[0],
                    'totali' => $totali,
                    'pagesat' => $pagesat,
                    'kontrata' => $kont,
                    'orari' => $template,
                    'zgjedhore' => $zgjedhore,
                    'i' => 1,
                    'destination' => "http://www.vpa-uni.com/smpsfile/avatar"]);
    }

    public function getPrintNotat() {

        $pagesat = Pagesat::where('uid', '=', Session::get('uid'))->get();

        $pdf = PDF::loadView('admin.personi.transaksionet', [ 'title' => Lang::get('printable.title_certificate_bill'),
                    'pagesat' => $pagesat,
                    'i' => 0]);
        file_put_contents(self::printdir('Transaksionet', Session::get('uid')), $pdf->output());
        return $pdf->download(self::printdir('Transaksionet', Session::get('uid')));
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
        return View::make('student.inbox', ['title' => 'Inbox', 'msg' => $msg, 'news' => self::getNews()]);
    }

    public function getRead($id) {
        $msg = MsgInbox::getMsgDetail($id, Enum::student);

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

    public function getLigjeratat() {

        return View::make('student.ligjeratat', ['title' => 'Ligjeratat', 'news' => self::getNews(),
                    'lendet' => Lendet::getSlendetCombo()]);
    }

    public function postLigjeratatList() {

        return View::make('student.ligjeratatlist', ['ligjeratat' => Ligjeratat::getLigjeratatStudent(),
                    'ushtrime' => Ligjeratat::getUshtrimeStudent(),
                    'i' => 0,
                    'j' => 0]);
    }

    public function getNotat() {
        $lendet = Notimet::join('lendet', 'lendet.idl', '=', 'notimet.idl')
                ->join('administrata', 'administrata.uid', '=', 'notimet.professori')
                ->orderby('semestri', 'asc')
                ->where('studenti', '=', Session::get('uid'))
                ->where('locked', '<', 3)
                ->where('refuzimi', '<', 2)
                ->select('idnew_table', DB::raw('DATEDIFF(notimet.`updated_at`,NOW()) as Dif'), 'notimet.idl', 'studenti', 'notimet.drejtimi', 'nota', 'paraqitja', 'refuzimi', DB::raw("CONCAT(administrata.emri,' ',administrata.mbiemri) as professori"), 'locked', 'notimet.created_at', 'notimet.updated_at', 'notimet.grp', 'data_provimit', 'lendet.Emri')
                ->orderby('lendet.Semestri', 'ASC')
                ->get();
        $notimet = $lendet->toArray();
        for ($i = 0; $i < count($lendet); $i++) {
            $vijushmeria = Vijushmeria::countVijushmeria($lendet[$i]['idl']);
            $notimet[$i]['vijushmeria'] = $vijushmeria['vijushmeria'];
        }
        $setting = Settings::all();
        return View::make('student.notat', ['title' => 'Ligjeratat',
                    'news' => self::getNews(),
                    'lendet' => $notimet,
                    'i' => 1,
                    'setting' => $setting[0]]);
    }

    public function postZgjedhore() {
        $lendet = Lendet::getLendetzgjedhore();
        $rules = array('zgj' => 'required|max:' . $lendet[1]['idl'] . "|min:", $lendet[0]['idl']);
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            Lendetzgjedhore::setLendetZgjedhore();
            Session::flash('notification', self::getSucmsg(Lang::get('warn.succes_choose')));
        } else {
            Session::flash('notification', self::getErrormsg(Lang::get('warn.error_undefined')));
        }
        return Redirect::to('/smps/student/');
    }

    public function postNotimet() {
        if (Kontratat::getAllowParaqitjen(Session::get('uid')) == 1) {
            if (Input::get('ref') != null) {
                foreach (Input::get('ref') as $value) {
                    Notimet::where('idnew_table', '=', $value)
                            ->update(array('refuzimi' => Enum::refuzuar));
                }
                Session::flash('notification', self::getSucmsg(Lang::get('Me sukses')));
            }

            if (Input::get('par') != null) {
                foreach (Input::get('par') as $value) {
                    Notimet::where('idnew_table', '=', $value)
                            ->update(array('paraqitja' => Enum::paraqitur));
                }
                Session::flash('notification', self::getSucmsg(Lang::get('Me sukses')));
            }
        } else {
            Session::flash('notification', self::getErrormsg(Lang::get('warn.error_kushti_paraqitjes')));
        }
        return Redirect::to(action('StudentController@getNotat'));
    }

}
