<?php

class ProvieeemetController extends BaseController {

    public function print_provimet($id) {

        if ($id == 'none') {

            $provimet = Provimet::where('provimet.deleted', '=', Enum::notdeleted)
                    ->where('locked', '=', Enum::nolocked)
                    ->join('lendet', 'lendet.idl', '=', 'provimet.idl')
                    ->join('administrata', 'administrata.uid', '=', 'provimet.profid')
                    ->select(DB::raw("date_format(`data`,'%Y-%m-%e %H:%i') as data"), 'lendet.Emri as Lenda', 'provimet.semestri as Sem', DB::raw("CONCAT(administrata.`Emri`,' ',administrata.`Mbiemri`) as Prof"))
                    ->get();
        } else {
            $provimet = Provimet::where('provimet.deleted', '=', Enum::notdeleted)
                    ->where('locked', '=', Enum::nolocked)
                    ->where('idd', '=', $id)
                    ->join('lendet', 'lendet.idl', '=', 'provimet.idl')
                    ->join('administrata', 'administrata.uid', '=', 'provimet.profid')
                    ->select(DB::raw("date_format(`data`,'%Y-%m-%e %H:%i') as data"), 'lendet.Emri as Lenda', DB::raw("CONCAT(administrata.`Emri`,' ',administrata.`Mbiemri`) as Prof"))
                    ->get();
        }
        $pdf = PDF::loadView('admin.provimet.print_provimet', [ 'title' => null,
                    'provimet' => $provimet,
                    'i' => 0]);

        file_put_contents(self::printdir('Provimet', Session::get('uid')), $pdf->output());
        return $pdf->download(self::printdir('Provimet', Session::get('uid')));
    }

    public function index() {
        $drejtimet = Drejtimet::all();
        $dre = array();
        foreach ($drejtimet as $val) {
            $dre[$val['idDrejtimet']] = $val['Emri'];
        }
        $dre = array('none' => Lang::get('general.select_profile')) + $dre;
        return View::make('admin.provimet.provimet')->with([
                    'title' => Lang::get('general.exams'),
                    'drejtimet' => $dre
        ]);
    }

    public function destroy($id) {
        $del = Provimet::where('idprovimet', '=', $id);
        $del->delete();
        $del = Provimet::where('idprovimet', '=', $id)->get();
        if (count($del) < 1) {
            return View::make('admin.provimet.delete', ['id' => $id]);
        } else {
            return "Error";
        }
    }

    public function store() {
        $validation = Validator::make(Input::all(), array(
                    'lendet' => 'required',
                    'drejtimi' => 'required',
                    'prof' => 'required',
                    'data' => 'required',
        ));
        $semestri = Lendet::where('idl', '=', Input::get('lendet'))->get();
        $val = Provimet::where('idl', '=', Input::get('lendet'))->where('locked', '=', 0)->get();

        if ($validation->passes() && count($val) == 0) {
            $provimet = new Provimet ();
            $provimet->idl = Input::get('lendet');
            $provimet->profid = Input::get('prof');
            $provimet->drejtimi = Input::get('drejtimi');
            $provimet->semestri = $semestri[0]['Semestri'];
            $provimet->data = Input::get('data');
            $provimet->grp = Enum::grupiA;
            $provimet->locked = 0;
            $provimet->save();
            return View::make('admin.provimet.inserts');
        } else {
            if (count($val) != 0) {
                return View::make('admin.provimet.insertf')->with('message', Lang::get('general.examsapp'));
            } else {
                return View::make('admin.provimet.insertf');
            }
        }
    }

}
