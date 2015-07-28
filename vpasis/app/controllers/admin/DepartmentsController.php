<?php

class DepartmentsController extends \BaseController {

    public function getIndex() {
        $departmentet = Departments::where('deleted', '=', Enum::notdeleted)->get();
        $drejtimet = Drejtimet::where('deleted', '=', Enum::notdeleted)->get();
        $lendet = Lendet::where('deleted', '=', Enum::notdeleted)->get();

        return View::make('admin.department.index', ['title' => Lang::get('general.departments'),
                    'departmentet' => $departmentet,
                    'drejtimet' => $drejtimet,
                    'lendet' => $lendet,
                    'cbzgjedhore' => Enum::getZgjedhore()]);
    }

    /*
     * Gjenerimi i lendeve dhe listimi
     */

    public function getDep($id) {
        $departmentet = Departments::where('deleted', '=', Enum::notdeleted)->get();
        $drejtimet = Drejtimet::where('deleted', '=', Enum::notdeleted)
                ->where('idd', '=', $id)
                ->get();
        $lendet = Lendet::where('deleted', '=', Enum::notdeleted)
                ->where('idp', '=', $id)
                ->orderBy('Semestri', 'ASC')
                ->orderBy('Zgjedhore', 'ASC')
                ->get();
        $semestriCount = 0; //Gjenerimin e title header
        return View::make('admin.department.index', ['title' => Lang::get('general.departments'),
                    'departmentet' => $departmentet,
                    'drejtimet' => $drejtimet,
                    'lendet' => $lendet,
                    'semestriCount' => $semestriCount,
                    'cbzgjedhore' => Enum::getZgjedhore(),
                    'selectedDep' => Enum::successful,
                    'selectedDepId' => $id]);
    }

    /*
     * Regjistrimi i drejtimit
     */

    public function postCreatedrejtimet() {
        $rules = array('Emri' => 'required');
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            $drejtimet = new Drejtimet;
            $drejtimet->Emri = Input::get('Emri');
            $drejtimet->idd = Input::get('idd');
            $drejtimet->deleted = Enum::notdeleted;
            $drejtimet->save();
            return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.success_insert_profile', array('drejtimi' => Input::get('Emri')))]);
        }
        return Redirect::back()->with(['message' => Enum::failed, "reason" => Lang::get('warn.error_undefined')]);
    }

    /*
     * Regjistrimi i lendeve 
     */

    public function postCreatelendet() {
        $rules = array('Emri' => 'required',
            'Drejtimi' => 'required|numeric',
            'idp' => 'required|numeric',
            'Semestri' => 'required|numeric',
            'zgjedhore' => 'required|numeric',
            'ect' => 'required|numeric');
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            $celendet = new Lendet();
            $celendet->Emri = Input::get('Emri');
            $celendet->Drejtimi = Input::get('Drejtimi');
            $celendet->Semestri = Input::get('Semestri');
            $celendet->Zgjedhore = Input::get('zgjedhore');
            $celendet->Ect = Input::get('ect');
            $celendet->idp = Input::get('idp');
            $celendet->deleted = Enum::notdeleted;
            $celendet->save();

            return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.success_insert_course', array('course' => Input::get('Emri')))]);
        }
        return Redirect::back()->with(['message' => Enum::failed, "reason" => Lang::get('warn.error_undefined')]);
    }

    /*
     * Ndryshon te dhenat e lendees se caktuar duke u bazuar ne id e asaj lende
     */

    public function postEditlendet() {
        $rules = array('Emri' => 'required',
            'zgjedhore' => 'required|numeric',
            'ect' => 'required|numeric',
            'idl' => 'required',
            'Drejtimi' => 'required',
            'Semestri' => 'required');

        $valid = Validator::make(Input::all(), $rules);

        print_r(Input::all());

        if ($valid->passes()) {
            $update = array('Emri' => Input::get('Emri'),
                'Zgjedhore' => Input::get('zgjedhore'),
                'Ect' => Input::get('ect'),
                'Semestri' => Input::get('Semestri'),
                "idl" => Input::get('idl'),
                'Drejtimi' => Input::get('Drejtimi')
            );

            $lendet = Lendet::where('idl', '=', Input::get('idl'))->update($update);
            return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.success_editcourse')]);
        } else {
            return Redirect::action('DepartmentsController@getIndex')->with(['message' => Enum::failed]);
            //      return self::getSucmsg(Lang::get('warn.success_editcourse'));
            //  } else {
            //      return self::getErrormsg(Lang::get('warn.error_undefined'));
        }
    }

    /*
     * Ben fshirjen e lendes duke u bazuar ne id e lendet
     * @param  idl
     */

    public function getDeletelendet($id) {
        Lendet::where('idl', '=', $id)->update(array('deleted' => Enum::deleted));
        return Redirect::back()->with(['message' => Enum::successful, "reason" => Lang::get('warn.delete_msg')]);
    }

    /*
     * Regjistrimi i departmentit
     */

    public function postRegisterDepartment() {
        $rules = array('departmenti' => 'required');
        $validator = Validator::make(Input::all(), array('departmenti' => 'required'));

        if ($validator->passes()) {
            $dep = new Departments();
            $dep->Emri = Input::get('departmenti');
            $dep->save();
            return Redirect::action('DepartmentsController@getIndex')->with(['message' => Enum::successful, 'reason' => Lang::get('warn.success_register_department', array('department' => Input::get('departmenti')))]);
        } else {
            return Redirect::action('DepartmentsController@getIndex')->with(['message' => Enum::failed]);
        }
    }

    /*
     * Prinitimi i lendeve PDF
     */

    public function getPrintLendet($id) {
        $drejtimi = Drejtimet::where('idDrejtimet', '=', $id)->get();
        $departmenti = Departments::where('idDepartmentet', '=', $drejtimi[0]['idd'])->get();
        $lendet = Lendet::where('Drejtimi', '=', $id)->orderBy('Semestri', 'ASC')->orderBy('Zgjedhore', 'ASC')->get();

        $pdf = PDF::loadView('admin.department.print_lendet', [ 'title' => Lang::get('printable.title_list_course'),
                    'lendet' => $lendet,
                    'drejtimi' => $drejtimi,
                    'departmenti' => $departmenti]);
        file_put_contents(self::printdir('ListaLendeve', $id, Session::get('uid')), $pdf->output());
        return $pdf->download(self::printdir('ListaLendeve', $id, Session::get('uid')));
    }

    public function getPrintLendetDirect($id) {
        $drejtimi = Drejtimet::where('idDrejtimet', '=', $id)->get();
        $departmenti = Departments::where('idDepartmentet', '=', $drejtimi[0]['idd'])->get();
        $lendet = Lendet::where('Drejtimi', '=', $id)
                ->orderBy('Semestri', 'ASC')
                ->orderBy('Ect', 'ASC')
                ->orderBy('Zgjedhore', 'ASC')->get();

        $pdf = PDF::loadView('admin.department.print_lendet', [ 'title' => Lang::get('printable.title_list_course'),
                    'lendet' => $lendet,
                    'drejtimi' => $drejtimi,
                    'departmenti' => $departmenti]);
        file_put_contents(self::printdir('ListaLendeve', $id, Session::get('uid')), $pdf->output());
        return $pdf->stream(self::printdir('ListaLendeve', $id, Session::get('uid')));
    }

}
