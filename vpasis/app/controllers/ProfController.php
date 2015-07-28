<?php

class ProfController extends BaseController {

    public function getIndex() {
        $pre_lendet = Lendet::get();
        $lendet = null;
        foreach ($pre_lendet as $value) {
            $lendet[$value['idl']] = $value['Emri'];
        }
        return View::make('admin/prof/index', ['title' => Lang::get('general.register_prof'),
                    'lendet' => $lendet,
                    'lastadministrata' => Admin::lastAdministrata()
        ]);
    }


    public function postObligimetinsert($id) {
        $rules = array('crs' => 'required|numeric',
            'active' => 'required|numeric');
        $valid = Validator::make(Input::get(), $rules);
        if ($valid->passes()) {
            $inset = new AssignProf();
            $inset->uid = $id;
            $inset->idl = Input::get('crs');
            $inset->active = (empty(Input::get('active')) ? Enum::passive : Enum::active);
            $inset->grp = 0;
            $inset->fondi_oreve = Input::get('fondi_oreve');
            $inset->deleted = Enum::notdeleted;
            $inset->save();
        }
        return Redirect::to('/smps/admin/person/' . $id . '/edit');
    }

    // Largona lenden e caktume nga lista
    public function postObligimetdel($id) {
        $rules = array('njftm' => 'required|numeric');
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            $update = array('deleted' => Enum::deleted);
            AssignProf::where('idassign_prof', '=', Input::get('njftm'))->update($update);
        }
        return Redirect::to('/smps/admin/person/' . $id . '/edit');
    }

    public function postObligimet($id) {
        if (Input::get('active') == Enum::passive) {
            $rules = array('fondi_oreve' => 'required|numeric',
                'njftm' => 'required|numeric');
            $valid = Validator::make(Input::all(), $rules);
            if ($valid->passes()) {
                $update = array('active' => Enum::active,
                    'fondi_oreve' => Input::get('fondi_oreve'));
                AssignProf::where('idassign_prof', '=', Input::get('njftm'))
                        ->where('deleted', '=', Enum::notdeleted)
                        ->update($update);
            }
        } else if (Input::get('active') == Enum::active) {
            $rules = array('njftm' => 'required|numeric');
            $valid = Validator::make(Input::all(), $rules);
            if ($valid->passes()) {
                $update = array('active' => Enum::passive);
                AssignProf::where('idassign_prof', '=', Input::get('njftm'))
                        ->where('deleted', '=', Enum::notdeleted)
                        ->update($update);
            }
        }
        return Redirect::to('/smps/admin/person/' . $id . '/edit');
    }

    public function postLendetajax() {
        $pre_lendet = Lendet::where('Drejtimi', '=', Input::get('profileins'))
                ->get();
        $drejtimet = array();
        foreach ($pre_lendet as $value) {
            $drejtimet[$value['idl']] = $value['Emri'];
        }
        return Form::select('crs', $drejtimet, current($drejtimet), array('class' => 'form-control', 'id' => 'profileins'));
    }

    public function postVerify() {

        $person = array('person' => 'test', 'title' => 'null');
        $data = array('title' => Lang::get('printable.contract_work_prof')
        );
        $drejtimi = Drejtimet::where('idDrejtimet', '=', Input::get('drejtimet'))->get();
        if (Input::get('status') == Enum::irregullt) {
            $statusi = Lang::get('general.regular');
        } else {
            $statusi = Lang::get('general.notregular');
        }


        $course = Lendet::where('idl', '=', Input::get('lendet'))->get();
        return View::make('admin.prof.verifAddProf', ['title' => Lang::get('general.contract_work_prof'),
                    'person' => Input::all(),
                    'lastId' => Admin::select(DB::raw('MAX(uid) AS uid'))->first(),
                    'course' => $course[0]['Emri']
        ]);
    }

    public function postStore() {

        $validation = Validator::make(Input::all(), array(
                    'emri' => 'required',
        ));
        /*
                    'mbiemri' => 'required',
                    'gjinia' => 'required|numeric',
                    'vendilindjes' => 'required',
                    'datalindjes' => 'required',
                    'idpersonal' => 'required|numeric',
                    'adress' => 'required',
                    'vendbanimi' => 'required',
                    'shteti' => 'required',
                    'lendet' => 'required|numeric',
                    'fondi_oreve' => 'required|numeric',
                    'status' => 'required|numeric',
                    'pozita' => 'required|numeric',
                    'grade' => 'required|numeric',
                    'qualification' => 'required',
                    'shuma' => 'required',
                    'credit_card' => 'required',
                    'email' => 'required',
                    'phone' => 'required'
                 */
        if ($validation->passes()) {
            echo "hello";

            $course = Lendet::where('idl', '=', Input::get('lendet'))->get();
            $prof = new Admin;
            $prof->emri = Input::get('emri');
            $prof->mbiemri = Input::get('mbiemri');
            $prof->gjinia = Input::get('gjinia');
            $prof->vendlindja = Input::get('vendilindjes');
            $prof->vendbanimi = Input::get('vendbanimi');
            $prof->datalindjes = Input::get('datalindjes');
            $prof->adressa = Input::get('adress');
            $prof->shtetas = Input::get('shteti');
            $prof->telefoni = Input::get('phone');
            $prof->email = Input::get('email');
            $prof->nrpersonal = Input::get('idpersonal');
            $prof->password = Hash::make(Input::get('idpersonal'));
            $prof->xhirollogaria = Input::get('credit_card');
            $prof->avatar = 'avatar.png';
            $prof->pozita = Input::get('pozita');
            $prof->nrpersonal = Enum::prof;
            $prof->grada = Input::get('grade');
            $prof->fondi_oreve = Input::get('fondi_oreve');
            $prof->pagesa_ores = Input::get('shuma');
            $prof->kualifikimi = Input::get('qualification');
            $prof->save();
            $lastid = Admin::select(DB::raw('MAX(uid) AS uid'))->first();

            $assign = new AssignProf();
            $assign->uid = $lastid['uid'];
            $assign->idl = Input::get('lendet');
            $assign->active = Input::get('status');
            $assign->grp = Enum::grupiA;
            $assign->save();
            // Krijimi PDF - Regjistrimit
            $pdf = PDF::loadView('admin.prof.verifAddProf', ['title' => Lang::get('header.title_register_stu'),
                        'person' => Input::all(),
                        'lastId' => Admin::select(DB::raw('MAX(uid) AS uid'))->first(),
                        'course' => $course[0]['Emri']
            ]);
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/../" . self::getBaseapp() . "/app/print/" . date("Y") . '/kontrat_pune_' . $lastid['uid'] . "_" . date('Y') . "_" . str_random(5) . '.pdf', $pdf->output());


            return $pdf->download('kontrat_pune_' . $lastid['uid'] . "_" . date('Y') . '.pdf');
        }
        Session::flash('notification', self::getErrormsg(Lang::get('warn.error_undefined')));
        return Redirect::back();
    }

}
