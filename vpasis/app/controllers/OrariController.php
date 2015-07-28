<?php

class OrariController extends BaseController {

    public function PrintOrari($id) {
        if ($id == 'none') {

            $orari = Orari::where('orari.deleted', '=', Enum::notdeleted)
                    ->where('locked', '=', Enum::nolocked)
                    ->join('lendet', 'lendet.idl', '=', 'orari.idl')
                    ->join('administrata', 'administrata.uid', '=', 'orari.uid')
                    ->select('dita', 'lendet.Emri as Lenda', 'ora', DB::raw("CONCAT(administrata.`Emri`,' ',administrata.`Mbiemri`) as Prof"))
                    ->get();
        } else {
            $orari = Orari::where('orari.deleted', '=', Enum::notdeleted)
                    ->where('locked', '=', Enum::nolocked)
                    ->where('idd', '=', $id)
                    ->join('lendet', 'lendet.idl', '=', 'orari.idl')
                    ->join('administrata', 'administrata.uid', '=', 'orari.uid')
                    ->select('dita', 'lendet.Emri as Lenda', 'ora', DB::raw("CONCAT(administrata.`Emri`,' ',administrata.`Mbiemri`) as Prof"))
                    ->get();
        }
        $pdf = PDF::loadView('admin.orari.print', [ 'title' => null,
                    'orari' => $orari]);

        file_put_contents(self::printdir('Orari', Session::get('uid')), $pdf->output());
        return $pdf->download(self::printdir('Orari', Session::get('uid')));
    }

    public function index() {
        $drejtimet = Drejtimet::all();
        $dre = array();
        foreach ($drejtimet as $val) {
            $dre [$val ['idDrejtimet']] = $val ['Emri'];
        }
        $dre = array('none' => Lang::get('general.select_profile')) + $dre;
        return View::make('admin.orari.orari')->with([
                    'title' => Lang::get('general.school_hours'),
                    'drejtimet' => $dre
        ]);
    }

    public function update($id) {
        return 'echo this' . $id;
    }

    public function destroy($id) {
        $del = Orari::where('idOrari', '=', $id);
        $del->delete();
        $del = Orari::where('idOrari', '=', $id)->get();
        if (count($del) < 1) {
            return View::make('admin.orari.delete', ['id' => $id]);
        } else {
            return "Error";
        }
    }

    public function store() {
        $validation = Validator::make(Input::all(), array(
                    'ora' => 'required|max:5',
                    'drejtimi' => 'required',
                    'lendet' => 'required',
                    'prof' => 'required',
                    'day' => 'required|max:6'
        ));
        if ($validation->passes()) {
        $lendet = Lendet::where('idl','=',Input::get('lendet'))->get();
            $orari = new Orari ();
            $orari->idl = Input::get('lendet');
            $orari->uid = Input::get('prof');
            $orari->semestri = $lendet[0]['Emri'];
            $orari->idd = Input::get('drejtimi');
            $orari->dita = Input::get('day');
            $orari->ora = Input::get('ora');
            $orari->grp = Enum::grupiA;
            $orari->locked = 0;
            $orari->save();
            return View::make('admin.orari.success');
        } else {
            return View::make('admin.orari.errors', ['errors' => $validation->messages()]);
        }
    }

}
