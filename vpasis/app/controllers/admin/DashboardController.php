<?php

class DashboardController extends \BaseController {
    public function getDashboard(){
        
        $students = Studenti::select(DB::raw('count(*) as student'))->get();
        $newstudent = Studenti::newstudent();
        $numprof = AssignProf::getactiveprof();

        return View::make('admin.index2', ['title' => Lang::get('header.title_index'),
                    'students' => $students[0]['student'],
                    'newstudent' => $newstudent[0]['newstudent'],
                    'numprof' => $numprof[0]['numprof'],
                    'workflow' => Workflow::getAll()]);
    }
    
    
}

?>