<?php

class PersonController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    private $rangeadmin = 900000;

    public function PrintPagesa() {
        $pagesat = Pagesat::where('uid', '=', Input::get('uid'))->get();

        $pdf = PDF::loadView('admin.personi.transaksionet', [ 'title' => Lang::get('printable.title_certificate_bill'),
                    'pagesat' => $pagesat,
                    'i' => 0]);
        file_put_contents(self::printdir('Transaksionet', Input::get('uid')), $pdf->output());
        return $pdf->download(self::printdir('Transaksionet', Input::get('uid')));
    }

    public function storepagesa($id) {
        if (Input::get('pershkrimi') == null) {
            $semestri = Studenti::where('uid', '=', $id)->select('semestri')->get();
            $desc = Lang::get('general.pay_bill_semester') . "   " . $semestri[0]['semestri'];
            $type = Enum::kontrat;
        } else {
            $type = Enum::jokontrat;
            $desc = Input::get('pershkrimi');
        }

        $pagesa = new Pagesat();
        $pagesa->uid = $id;
        $pagesa->shuma = Input::get('pagesa');
        $pagesa->pershkrimi = $desc;
        $pagesa->logs = Session::get('uid');
        $pagesa->type = $type;
        $pagesa->save();
        return View::make('admin.personi.profiles');
    }

    public function printdir($name, $id) {
        return $_SERVER['DOCUMENT_ROOT'] . "/../" . self::getBaseapp() . "/app/print/" . date("Y") . '/' . $name . '_' . $id . "_" . date('Y_m_d_H_i_s') . '_' . str_random(4) . '.pdf';
    }

    public function print_transkript($id) {
        $profile = Studenti::where('uid', '=', $id)
                ->join('drejtimet', 'drejtimet.idDrejtimet', '=', 'studenti.drejtimi')
                ->select('drejtimet.Emri as drejtimi', 'studenti.emri as studenti', 'mbiemri', 'emri_prindit', 'vendlindja', 'semestri', 'statusi', 'datalindjes')
                ->get();
        $notat = Notimet::where('studenti', '=', $id)
                ->where('locked', '=', '2')
                ->join('lendet', 'lendet.idl', '=', 'notimet.idl')
                ->select('lendet.emri as lendet', 'nota', 'lendet.etc as ect')
                ->get();
        $administruesi = Admin::where('uid', '=', Session::get('uid'))->get();
        $pdf = PDF::loadView('admin.personi.transkripta', ['title' => Lang::get('printable.title_certificate_grade'), 'profile' => $profile[0], 'notat' => $notat, 'i' => 0, 'administruesi' => $administruesi[0]]);
        file_put_contents(self::printdir('Transkript', $id), $pdf->output());
        return $pdf->download(self::printdir('Transkript', $id));
    }

    public function Index() {
        $statusi = array(Enum::irregullt => Lang::get('general.regular'),
            Enum::joirregullt => Lang::get('general.notregular'));
        $dtemp = Drejtimet::all();

        $drejtimet = array();
        foreach ($dtemp as $id => $value) {
            $drejtimet[$value['idDrejtimet']] = $value['Emri'];
        }
        unset($dtemp);
        return View::make('admin.personi.addStudent', ['title' => Lang::get('header.title_register_stu'),
                    'statusi' => $statusi,
                    'drejtimi' => $drejtimet,
                    'laststudent' => Studenti::lastStudent()]);
    }

    // Verifikimi i te dhenave
    public function create() {
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

    /*
     * Regjistrimi studentit dhe gjenerimi PDF
     */

    public function store() {
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

    // Permes Ajax paraqit dhe ben refuzimin e notave
    public function show($id) {
        $setting = Settings::first();
        $profile = Studenti::where('uid', '=', $id)->get();
        $pagesat = Pagesat::where('uid', '=', $id)->get();
        $totali = array('paguara' => 0);
        $kontrata = Kontratat::where('uid', '=', $id)
                        ->where('type', '=', 0)->get();
        if (count($kontrata) > 0) {
            // Borxhi dhe pagesa e kontrates per semester
            foreach ($pagesat as $value) {
                $totali['paguara'] += $value['shuma'];
            }
            $viti = (int) $profile[0]['semestri'] / 2;
            $kont = 0;
            for ($i = 0; $viti > $i; $i++) {
                $kont+=$kontrata[0]['shuma'];
            }

            $totali['perqindja'] = $totali['paguara'] / $kont * 100;
        } else {
            $kontrata = null;
            $kont = null;
            $totali = null;
        }
        if ($setting['perqindja_paraqitjes'] <= $totali['perqindja']) {
            if (Input::get('paraqit') != NULL) {
                foreach (Input::get('paraqit') as $value) {
                    $update = array('paraqitja' => Enum::refuzuar);
                    Notimet::where('idl', '=', $value)
                            ->where('studenti', '=', $id)
                            ->where('paraqitja', '=', 0)
                            ->where('locked', '=', 0)
                            ->where('refuzimi', '=', 0)
                            ->update($update);
                }
            }
        }

        if (Input::get('refuzim') != NULL) {
            foreach (Input::get('refuzim') as $value) {
                $update = array('refuzimi' => 1, 'locked' => 3);
                Notimet::where('idl', '=', $value)
                        ->where('studenti', '=', $id)
                        ->where('paraqitja', '=', 2)
                        ->where('locked', '=', 1)
                        ->where('refuzimi', '=', 0)
                        ->update($update);
                $nt = Notimet::where('idl', '=', $value)
                        ->where('studenti', '=', $id)
                        ->where('locked', '=', 3)
                        ->where('refuzimi', '=', 1)
                        ->get();
                $studenti = Studenti::where('uid', '=', $id)->get();
                $add = new Notimet();
                $add->idl = $value;
                $add->studenti = $id;
                $add->drejtimi = $studenti[0]['drejtimi'];
                $add->nota = 0;
                $add->paraqitja = 0;
                $add->refuzimi = 0;
                $add->professori = $nt[0]['professori'];
                $add->locked = 0;
                $add->grp = 0;
                $add->data_provimit = null;
                $add->save();
            }
        }

        return View::make('admin.personi.profiles');
    }
    public function edit($id) {
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
            return View::make('admin.personi.profile', ['title' => Lang::get('general.personal_profile'),
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

    public function avatar() {
        if (Input::hasFile('avatar')) {
            $destination = public_path() . '/smps/avatar';
            $filename = "/" . str_random(20) . '_' . Input::file('avatar')->getClientOriginalName();
            Input::file('avatar')->move($destination, $filename);
            return str_random(20) . '_' . Input::file('avatar')->getClientOriginalName();
        }
        return FALSE;
    }

    public function getPrintKontrata() {
        $profile = Studenti::where('uid', '=', Input::get('uid'))->get();
        $drejtimi = Drejtimet::where('idDrejtimet', '=', $profile[0]['drejtimi'])->get();
        if ($profile[0]['statusi'] == Enum::irregullt) {
            $statusi = Lang::get('general.regular');
        } else {
            $statusi = Lang::get('general.notregular');
        }
        $kontrata = Kontratat::where('uid', '=', $profile[0]['uid'])->get();
        $pdf = PDF::loadView('admin.personi.print_kontrata', ['title' => Lang::get('header.title_register_stu'),
                    'person' => $profile[0],
                    'drejtimi' => $drejtimi[0]['Emri'],
                    'level' => Lang::get('general.bachelor'),
                    'kontrata' => $kontrata[0], 'statusi' => $statusi]);
        return $pdf->download('user_' . $profile[0]['uid'] . "_" . date('Y') . '.pdf');
    }

}
