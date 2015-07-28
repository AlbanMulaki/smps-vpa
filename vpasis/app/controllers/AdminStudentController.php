<?php

class AdminStudentController extends BaseController {

    public function getList() {

        $student = Studenti::sortaca();
// return Route::get('/admin/setting/cs','SettingsController@Index');
        return View::make('admin.students.list.list', ['title' => Lang::get('header.title_index'),
                    'student' => $student
        ]);
    }

    public function postSortaca() {
        $student = Studenti::sortaca();
        $num = count($student);
        $page = (int) $num / 20;
        return View::make('admin.students.list.list_sort', ['title' => Lang::get('header.title_index'),
                    'student' => $student, 'num' => $num, 'page' => $page, 'vitiaka' => Input::get('sortaca')
        ]);
    }

    public function getDeleteStudent() {
        
    }

    public function getStudent($id) {
        if ($id < self::getRange()) {
            // Gjenerimi i statusit
            $statusi = array(Enum::irregullt => Lang::get('general.regular'),
                Enum::joirregullt => Lang::get('general.notregular'));
            $profile = Studenti::where('uid', '=', $id)->get();
            $dtemp = Drejtimet::all();


            $drejtimet = array();
            foreach ($dtemp as $id => $value) {
                $drejtimet[$value['idDrejtimet']] = $value['Emri'];
            }
            $pagesat = Pagesat::where('uid', '=', $profile[0]['uid'])->get();
            $totali = array('paguara' => 1);
            $kontrata = Kontratat::where('uid', '=', $profile[0]['uid'])
                            ->where('type', '=', 0)->get();
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
            $lendet_pre = Notimet::join('lendet', 'lendet.idl', '=', 'notimet.idl')
                    ->join('administrata', 'administrata.uid', '=', 'notimet.professori')
                    ->where('studenti', '=', $profile[0]['uid'])
                    ->where('locked', '<', 3)
                    ->where('refuzimi', '<', 2)
                    ->select('idnew_table', DB::raw('DATEDIFF(notimet.`updated_at`,NOW()) as Dif'), 'notimet.idl', 'studenti', 'notimet.drejtimi', 'nota', 'paraqitja', 'refuzimi', DB::raw("CONCAT(administrata.emri,' ',administrata.mbiemri) as professori"), 'locked', 'notimet.created_at', 'notimet.updated_at', 'notimet.grp', 'data_provimit', 'lendet.Emri', 'lendet.Semestri as Semestri')->orderby('lendet.Semestri', 'ASC')
                    ->get();

            $lendet = $lendet_pre->toArray();
// Vijushmeria 
            $lended_vijushmeria = Notimet::join('lendet', 'lendet.idl', '=', 'notimet.idl')
                    ->join('administrata', 'administrata.uid', '=', 'notimet.professori')
                    ->orderby('semestri', 'asc')
                    ->where('studenti', '=', Session::get('uid'))
                    ->where('locked', '<', 3)
                    ->where('refuzimi', '<', 2)
                    ->select('idnew_table', DB::raw('DATEDIFF(notimet.`updated_at`,NOW()) as Dif'), 'notimet.idl', 'studenti', 'notimet.drejtimi', 'nota', 'paraqitja', 'refuzimi', DB::raw("CONCAT(administrata.emri,' ',administrata.mbiemri) as professori"), 'locked', 'notimet.created_at', 'notimet.updated_at', 'notimet.grp', 'data_provimit', 'lendet.Emri')->orderby('lendet.Semestri', 'ASC')
                    ->get();
            /*
              $lendet = Notimet::join('lendet', 'lendet.idl', '=', 'notimet.idl')
              ->join('administrata', 'administrata.uid', '=', 'notimet.professori')
              ->orderby('semestri', 'asc')
              ->where('studenti', '=', Session::get('uid'))
              ->where('locked', '<', 3)
              ->where('refuzimi', '<', 2)
              ->select('idnew_table', DB::raw('DATEDIFF(notimet.`updated_at`,NOW()) as Dif'), 'notimet.idl', 'studenti', 'notimet.drejtimi', 'nota', 'paraqitja', 'refuzimi', DB::raw("CONCAT(administrata.emri,' ',administrata.mbiemri) as professori"), 'locked', 'notimet.created_at', 'notimet.updated_at', 'notimet.grp', 'data_provimit', 'lendet.Emri')
              ->orderby('lendet.Semestri', 'ASC')
              ->get(); */
            for ($i = 0; $i < count($lendet_pre); $i++) {
                $vijushmeria = Vijushmeria::countVijushmeria($lendet[$i]['idl'], $profile[0]['uid']);
                $lendet[$i]['vijushmeria'] = $vijushmeria['vijushmeria'];
            }
            $setting = Settings::all();
            return View::make('admin.students.profile', ['title' => Lang::get('general.personal_profile'),
                        'profile' => $profile[0],
                        'drejtimet' => $drejtimet,
                        'statusi' => $statusi,
                        'lendet' => $lendet,
                        'pagesat' => $pagesat,
                        'totali' => $totali,
                        'kontrata' => $kont,
                        'setting' => $setting[0]]);
        } else if ($id >= self::getrange()) {
            $profile = Admin::where('uid', '=', $id)->get(); // gjenerimi profilit te personit
            //Klasifikimi i prof aktiv dhe jo aktiv
            $active = AssignProf::where('uid', '=', $id)
                    ->where('active', '=', Enum::active)
                    ->where('deleted', '=', Enum::notdeleted)
                    ->get();
            if (count($active) > 0) {
                $status = Enum::active;
            } else {
                $status = Enum::passive;
            }
            // End

            $grade = Enum::getGrade(); // Gjeneron gradat shkencore
            $pos = Enum::getPos(); // Gjenerone poztitat
            $assign = AssignProf::join('lendet', 'lendet.idl', '=', 'assign_prof.idl')
                    ->select('uid as uid', 'assign_prof.idl as idl', 'lendet.Emri as emri', 'fondi_oreve as oret', 'active', 'idassign_prof', 'lendet.Semestri', 'lendet.Zgjedhore')
                    ->where('uid', '=', $profile[0]['uid'])
                    ->where('assign_prof.deleted', '=', Enum::notdeleted)
                    ->get();
            $dtemp = Drejtimet::all();
            $drejtimet = array(Lang::get('general.chose_profile'));
            foreach ($dtemp as $id => $value) {
                $drejtimet[$value['idDrejtimet']] = $value['Emri'];
            }
            unset($dtemp);
            return View::make('admin.prof.profile', ['title' => Lang::get('general.profile'),
                        'profile' => $profile[0],
                        'status' => $status,
                        'grade' => $grade,
                        'pos' => $pos,
                        'assign' => $assign,
                        'i' => 0,
                        'drejtimet' => $drejtimet]);
        }
    }

    public function getPrintContract($uid) {
        $profile = Studenti::where('uid', '=', $uid)->get();
        $drejtimi = Drejtimet::where('idDrejtimet', '=', $profile[0]['drejtimi'])->get();
        if ($profile[0]['statusi'] == Enum::irregullt) {
            $statusi = Lang::get('general.regular');
        } else {
            $statusi = Lang::get('general.notregular');
        }
        $kontrata = Kontratat::where('uid', '=', $profile[0]['uid'])->get();
        if (count($kontrata) < 1) {
            $kontrata[0] = null;
        }
        $pdf = PDF::loadView('admin.personi.print_kontrata', ['title' => Lang::get('header.title_register_stu'),
                    'person' => $profile[0],
                    'drejtimi' => $drejtimi[0]['Emri'],
                    'level' => Lang::get('general.bachelor'),
                    'kontrata' => $kontrata[0], 'statusi' => $statusi]);
        return $pdf->download('user_' . $profile[0]['uid'] . "_" . date('Y') . '.pdf');
    }

    public function postUpdateStudentProfile($id) {
        if ($id < self::getRange()) {
            $profile = Studenti::where('uid', '=', Input::get('uid'))->get();
            // editimi avatarit
            $avatar = array();
            if (Input::hasFile('avatar')) {
                $destination = public_path() . '/smpsfile/avatar';
                $filename = "/" . str_random(20) . '_' . $id . '.' . Input::file('avatar')->getClientOriginalExtension();
                Input::file('avatar')->move($destination, $filename);
                $avatar['avatar'] = $filename;
            }
            //regjsitrimi i te dhenave
            $update = array(
                'emri' => Input::get('emri'),
                'mbiemri' => Input::get('mbiemri'),
                'emri_prindit' => Input::get('emri_prindit'),
                'mbiemri_prindit' => Input::get('mbiemri_prindit'),
                'gjinia' => Input::get('gjinia'),
                'vendlindja' => Input::get('vendlindja'),
                'datalindjes' => Input::get('datalindjes'),
                'nrpersonal' => Input::get('nrpersonal'),
                'telefoni' => Input::get('emri'),
                'email' => Input::get('email'),
                'shteti' => Input::get('shteti'),
                'kombesia' => Input::get('kombesia'),
                'adressa' => Input::get('adress'),
                'vendbanimi' => Input::get('vendbanimi'),
                'drejtimi' => Input::get('drejtimi'),
                'statusi' => Input::get('status'),
                'niveli' => Input::get('niveli'),
                'kualifikimi' => Input::get('kualifikimi'),
                'semestri' => Input::get('semestri')
            );
            if (!Input::get('verif')) {
                $update['confirm'] = Enum::confirmed;
            }
            for ($i = 1; $i <= Input::get('semestri'); $i++) {
                $lendet = Lendet::where('Semestri', '=', $i)
                        ->where('Drejtimi', '=', Input::get('drejtimi'))
                        ->where('Zgjedhore', '=', Enum::jozgjedhore)
                        ->get();
                foreach ($lendet as $val) {
                    $notimet = Notimet::where('studenti', '=', Input::get('uid'))
                            ->where('idl', '=', $val['idl'])
                            ->where('drejtimi', '=', Input::get('drejtimi'))
                            ->get();
                    if (count($notimet) < 1) {
                        $not = new Notimet();
                        $not->idl = $val['idl'];
                        $not->studenti = Input::get('uid');
                        $not->drejtimi = Input::get('drejtimi');
                        $prof = Orari::where('idl', '=', Input::get('idl'))
                                ->where('locked', '=', Enum::nolocked)
                                ->where('deleted', '=', Enum::notdeleted)
                                ->get();
                        if (count($prof) > 0) {
                            $not->professori = $prof[0]['uid'];
                        } else {
                            $not->professori = 0;
                        }
                        $not->locked = Enum::nolocked;
                        $not->grp = 0;
                        $not->save();
                    }
                }
            }
            if (Input::get('psw') != null) {
                $update['password'] = Hash::make(Input::get('psw'));
            }
            if (count($avatar) > 0) {
                $update['avatar'] = $avatar['avatar'];
            }
            Studenti::where('uid', '=', Input::get('uid'))->update($update);
            return Redirect::to(action('AdminStudentController@getStudent') . '/' . $id);
        } else {
            $avatar = array();
            if (Input::hasFile('avatar')) {
                $destination = public_path() . '/smpsfile/avatar';
                $filename = "/" . str_random(20) . '_' . $id . '.' . Input::file('avatar')->getClientOriginalExtension();
                Input::file('avatar')->move($destination, $filename);
                $avatar['avatar'] = $filename;
            }
            //regjsitrimi i te dhenave personale
            $update = array(
                'emri' => Input::get('emri'),
                'mbiemri' => Input::get('mbiemri'),
                'gjinia' => Input::get('gjinia'),
                'vendlindja' => Input::get('vendlindja'),
                'datalindjes' => Input::get('birthdate'),
                'nrpersonal' => Input::get('idpersonal'),
                'telefoni' => Input::get('telefoni'),
                'email' => Input::get('email'),
                'shtetas' => Input::get('state'),
                'adressa' => Input::get('adress'),
                'vendbanimi' => Input::get('vendbanimi'),
                'kualifikimi' => Input::get('kualifikimi'),
                'xhirollogaria' => Input::get('cc'),
                'grada' => Input::get('grade'),
                'pozita' => Input::get('pozita'),
                'xhirollogaria' => Input::get('cc'),
                'pagesa_ores' => Input::get('hour'),
            );
            if (Input::get('psw') != null) {
                $update['password'] = Hash::make(Input::get('psw'));
            }
            if (count($avatar) > 0) {
                $update['avatar'] = $avatar['avatar'];
            }
            Admin::where('uid', '=', Input::get('uid'))->update($update);
            return Redirect::to('/smps/admin/person/' . $id . '/edit');
        }
    }

    public function getPrintPDF() {
        
    }

    public function getPrintWORD() {
        
    }

    public function getPrintExcel() {
        
    }

    public function getPrint($yearac1, $yearac2) {

        $student = Studenti::sortaca($yearac1 . '/' . $yearac2);
        $pdf = PDF::loadView('admin.personi.liststudent_print', [ 'title' => null,
                    'student' => $student]);
        file_put_contents(self::printdir('Liststudent', Session::get('uid')), $pdf->output());
        return $pdf->download(self::printdir('Liststudent', Session::get('uid')));
    }

    public function postSearchStudent() {
        if (is_numeric(Input::get('searchstudent'))) {
            if (Input::get('admin') != "admin") {
                $person = self::ById('student');
                return View::make('admin.students.list.search_dialog', ['title' => Lang::get('general.search'), 'person' => $person]);
            }
        } else if (preg_match("/^[a-zA-Z ]+$/ ", Input::get('searchstudent'))) {
            if (Input::get('admin') != "admin") {
                $person = self::ByName();
                return View::make('admin.students.list.search_dialog', ['title' => Lang::get('general.search'), 'person' => $person]);
            }
        }
        $student = Studenti::where('uid', 'like', "%" . Input::get('searchstudent') . "%")->get();
    }

    // search by unique id
    private function ById($access) {

        return Studenti::where('uid', 'like', Input::get('searchStudent') . "%")->take(7)->get();
    }

    // Search by name and surname
    public function ByName() {
        $search = explode(' ', Input::get('searchStudent'));
        if (count($search) > 1) {
            return Studenti::where('emri', 'like', $search[0] . '%')->where('mbiemri', 'like', $search[1] . '%')->take(5)->get();
        } else if (count($search) == 1) {
            return Studenti::where('emri', 'like', $search[0] . '%')
                            ->take(5)
                            ->get();
        }
    }

    public function getVijushmeria() {
        return View::make('admin.students.vijushmeria.index', [
                    'drejtimet' => Drejtimet::getComboDrejtimetAll()
        ]);
    }

    public function postSearchStudentVijushmeria() {
        if (is_numeric(Input::get('searchStudent'))) {
            $person = self::ById('student');
            return View::make('admin.students.vijushmeria.search_dialog', ['title' => Lang::get('general.search'),
                        'person' => $person,
                        'search' => Input::get('id')]);
        } else if (preg_match("/^[a-zA-Z ]+$/ ", Input::get('searchStudent'))) {

            $person = self::ByName();
            return View::make('admin.students.vijushmeria.search_dialog', ['title' => Lang::get('general.search'),
                        'person' => $person,
                        'search' => Input::get('id')]);
        }
        $student = Studenti::where('uid', 'like', "%" . Input::get('searchStudent') . "%")->get();
    }

    #
    # Verification of data students
    #
    public function getRegisterVerification() {
        $person = array('person' => 'test', 'title' => 'null');
        $data = array('title' => Lang::get('printable.title_contract_reg'));
        $drejtimi = Drejtimet::where('idDrejtimet', '=', Input::get('drejtimet'))->get();
        if (Input::get('status') == Enum::irregullt) {
            $statusi = Lang::get('general.regular');
        } else {
            $statusi = Lang::get('general.notregular');
        }
        $lstid = Studenti::select(DB::raw('MAX(uid) AS uid'))->get();
        return View::make('admin.personi.verifaddStudent', ['title' => Lang::get('header.title_register_stu'),
                    'person' => Input::all(),
                    'drejtimi' => $drejtimi[0]['Emri'],
                    'level' => Lang::get('general.bachelor'),
                    'statusi' => $statusi,
                    'lastId' => ($lstid[0]['uid'] + 1)]);
    }

    #
    # Registerin student to Database

    #
    public function postRegister() {
         // Permbajtja e PDF
        $person = array('person' => 'test', 'title' => 'null');
        $data = array('title' => Lang::get('printable.title_contract_reg')
        );
        $drejtimi = Drejtimet::where('idDrejtimet', '=', Input::get('drejtimet'))->get();
        if (Input::get('status') == Enum::irregullt) {
            $statusi = Lang::get('general.regular');
        } else {
            $statusi = Lang::get('general.notregular');
        }
        $lastid = Studenti::select(DB::raw("MAX(`uid`) as uid"))->get();
        $newid = $lastid[0]['uid'] + 1;
        // Krijimi PDF - Regjistrimit
        $pdf = PDF::loadView('admin.personi.verifaddStudent', ['title' => Lang::get('header.title_register_stu'),
                    'person' => Input::all(),
                    'drejtimi' => $drejtimi[0]['Emri'],
                    'level' => Lang::get('general.bachelor'),
                    'statusi' => $statusi,
                    'lastId' => $newid]);
        $pdf->save($_SERVER['DOCUMENT_ROOT'] . '/../' . self::getBase() . "/app/print/" . date("Y") . '/user_' . $newid . "_" . date('Y') . '.pdf');
//        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/' . self::getBase() . "/app/print/" . date("Y") . '/user_' . $newid . "_" . date('Y') . '.pdf', $pdf->output());


        $student = new Studenti();
        $student->emri = Input::get('emri');
        $student->mbiemri = Input::get('mbiemri');
        $student->emri_prindit = Input::get('emri_prindit');
        $student->mbiemri_prindit = Input::get('mbiemri_prindit');
        $student->gjinia = Input::get('gjinia');
        $student->vendlindja = Input::get('vendilindjes');
        $student->datalindjes = Input::get('datalindjes');
        $student->nrpersonal = Input::get('idpersonal');
        $student->telefoni = Input::get('phone');
        $student->email = Input::get('email');
        $student->shteti = Input::get('shtetas');
        $student->kombesia = Input::get('nacionaliteti');
        $student->adressa = Input::get('adress');
        $student->vendbanimi = Input::get('vendbanimi');
        $student->drejtimi = Input::get('drejtimet');
        $student->statusi = Input::get('status');
        $student->niveli = Input::get('level');
        $student->transfer = Input::get('transfer');
        $student->psw = Hash::make(Input::get('idpersonal'));
        $student->viti_aka =  "2014/2015";
        $student->avatar = "/default.png";
        $student->confirm = 1;
        $student->kualifikimi = Input::get('qualification');
        $student->semestri = Input::get('semester');
        $student->save();
        $kontrata = new Kontratat();
        $kontrata->uid = $newid;
        $kontrata->shuma = Input::get('shuma');
        $kontrata->pershkrimi = Input::get('desccont');
        $kontrata->logs = Session::get('uid');
        $kontrata->length = 3;
        $kontrata->type = 0;
        $kontrata->save();

        //  Regjistro lendet
        for ($i = 1; $i <= Input::get('semester'); $i++) {
            $lendet = Lendet::where('Semestri', '=', $i)
                    ->where('Drejtimi', '=', Input::get('drejtimet'))
                    ->where('Zgjedhore', '=', Enum::jozgjedhore)
                    ->get();
            foreach ($lendet as $val) {
                $notimet = Notimet::where('studenti', '=', $newid)
                        ->where('idl', '=', $val['idl'])
                        ->where('drejtimi', '=', Input::get('drejtimi'))
                        ->get();
                if (count($notimet) < 1) {
                    $not = new Notimet();
                    $not->idl = $val['idl'];
                    $not->studenti = $newid;
                    $not->drejtimi = Input::get('drejtimet');
                    $prof = Orari::where('idl', '=', Input::get('idl'))
                            ->where('locked', '=', Enum::nolocked)
                            ->where('deleted', '=', Enum::notdeleted)
                            ->get();
                    if (count($prof) > 0) {
                        $not->professori = $prof[0]['uid'];
                    } else {
                        $not->professori = 0;
                    }
                    $not->locked = Enum::nolocked;
                    $not->grp = 0;
                    $not->save();
                }
            }
        }












        return $pdf->download('user_' . $newid . "_" . date('Y') . '.pdf');
    }

    #
    # Register Form for students

    #
    public function getRegisterForm() {
        return View::make('admin.students.addStudentForm');
    }

}

?>