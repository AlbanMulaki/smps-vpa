<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Notimet extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notimet';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public static function RaportiNotavePrint() {
        $rap_notave = Notimet::join('assign_prof', 'assign_prof.idl', '=', 'notimet.idl')
                ->join('studenti', 'studenti.uid', '=', 'notimet.studenti')
                ->join('lendet', 'lendet.idl', '=', 'notimet.idl')
                ->join('administrata', 'administrata.uid', '=', 'assign_prof.uid')
                ->join('drejtimet', 'drejtimet.idDrejtimet', '=', 'lendet.Drejtimi')
                ->where('assign_prof.uid', '=', Session::get('uid'))
                ->where('paraqitja', '=', Enum::paraqiturprezent)
                ->where('notimet.locked', '=', Enum::nolocked)
                ->where('assign_prof.idl', '=', Input::get('genrap'))
                ->select(DB::raw("CONCAT(studenti.`emri`,' ',studenti.`mbiemri`) as Studenti"), DB::raw('studenti.uid as Studentiuid'), DB::raw("CONCAT(administrata.emri,' ',administrata.mbiemri) as Prof"), DB::raw("DATE_FORMAT(`data_provimit`,'%d/%m/%Y') as Data_Provimit"), 'lendet.emri as Lendet', 'drejtimet.Emri as Drejtimi', 'lendet.semestri as Semestri')
                ->get();
        $maxrap = Notimet::select(DB::raw('MAX(notimet.`idraportit`) as idraportit'))
                ->get();
        $rap_notave_list = $rap_notave->toArray();
        $settings = Settings::all();
        for ($i = 0; $i < count($rap_notave); $i++) {
            $vijushmeria = Vijushmeria::join('studenti', 'studenti.uid', '=', 'vijushmeria.studenti')
                    ->where('studenti', '=', $rap_notave[$i]['Studentiuid'])
                    ->where('deleted', '=', Enum::notdeleted)
                    ->where('idl', '=', Input::get('genrap'))
                    ->where('locksem', '=', 0)
                    ->select(DB::raw('COUNT(vijushmeria.studenti) as vijushmeria'))
                    ->get();
            $perqindja = (int) $vijushmeria[0]['vijushmeria'] / $settings[0]['hour_semester'] * 100;
            $rap_notave_list[$i]['vijushmeria'] = $vijushmeria[0]['vijushmeria'] . " " . (int) $perqindja . "%";
        }



        // return View::make('prof.printrapnotavevlersimi',['rap_notave'=>$rap_notave,'i'=>0,'title'=>'test']);
        $pdf = PDF::loadView('prof.printrapnotavevlersimi', ['title' => Lang::get('printable.report_grades'),
                    'rap_notave' => $rap_notave_list, 'i' => 0, 'maxrap' => $maxrap])->setOrientation('landscape');
        return $pdf->download("raporti_notave" . date('Y') . '.pdf');
    }

}
