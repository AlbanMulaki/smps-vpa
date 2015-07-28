<?php 

class AdminController extends BaseController {

    public function getIndex() {
        
        $newstudent = Studenti::getCountStudents();
        $student_notconfirmed = Studenti::getStudentNotConfirmed();
	//        $numprof = AssignProf::getactiveprof();
       // $lastStudentRegistred = Studenti::lastStudent();
       // $drejtimi = Drejtimet::getComboDrejtimetAll();
        $statusi = Statusi::getComboStatusiAll();
        return View::make('admin.index2', ['title' => Lang::get('header.title_index'),
                    'countStudents' => $newstudent[0]['students'],
                    'numprof' => 0,
                    'workflow' => Workflow::getAll(),
                    'student_notconfirmed'=>$student_notconfirmed[0]['notconfirmed']]);
    }

    public function getSetting() {
        $settings = Settings::get();

        // return Route::get('/admin/setting/cs','SettingsController@Index');

        Route::resource('/admin/setting', 'SettingsController');
        return View::make('admin.settings', ['title' => Lang::get('header.title_index'),
                    'settings' => $settings[0]
        ]);
    }

    public function getSlist() {
    }

    public function getPrintSlist($id, $ids) {

        $student = Studenti::sortaca($id . '/' . $ids);
        $pdf = PDF::loadView('admin.personi.liststudent_print', [ 'title' => null,
                    'student' => $student]);
        file_put_contents(self::printdir('Liststudent', Session::get('uid')), $pdf->output());
        return $pdf->download(self::printdir('Liststudent', Session::get('uid')));
    }

    public function postSortaca() {
        $student = Studenti::sortaca();
        $num = count($student);
        $page = (int) $num / 20;
        return View::make('admin.personi.listudent_sort', ['title' => Lang::get('header.title_index'),
                    'student' => $student, 'num' => $num, 'page' => $page, 'vitiaka' => Input::get('sortaca')
        ]);
    }

    public function postWorkflow() {
        $rules = array('id' => 'required|numeric', 'status' => 'required|numeric');
       
        $valid = Validator::make(Input::all(), $rules);
        if ($valid->passes()) {
            Workflow::setWorkflow(Input::get('id'),Input::get('status') );
        }else {
            // no validation
        }
    }

}
