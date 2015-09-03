@extends("admin.index")


@section('notification')

<!-- Regjistrimi Departmentit -->
@if(null !== Session::get('message') && Session::get('message') == Enum::successful)
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Session::get('reason') }}
</div>
@elseif(Session::get('message') == Enum::failed)
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Lang::get('warn.error_undefined') }}
</div>

@endif
<!-- End Regjistrimi Departmentit -->
@stop


@section('view_report')

@stop

@section('register_grade')


{{ Form::open(array('url'=>action('ProvimetController@postRegisterNotat'),'method'=>'POST')) }}
{{ Form::close() }}

@stop


@section('report_grade')
{{ Form::open(array('url'=>action('ProvimetController@getRaportiNotave'),'method'=>'GET')) }}

<div class="row">
    <div class='col-lg-2'>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">{{ Lang::get('general.year') }}</span>
                @if(isset($year))
                {{ Form::select('year', Enum::getYear(),$year,array('class'=>'form-control ')) }}
                @else
                {{ Form::select('year', Enum::getYear(),null,array('class'=>'form-control ')) }}
                @endif
            </div>
        </div>
    </div>
    <div class='col-lg-3'>
        <div class="form-group">
            <div class="input-group ">
                <span class="input-group-addon">{{ Lang::get('general.month') }}</span>    
                @if(isset($month))
                {{ Form::select('month', Enum::getMonthExams(),$month,array('class'=>'form-control ')) }}
                @else
                {{ Form::select('month', Enum::getMonthExams(),null,array('class'=>'form-control ')) }}
                @endif
            </div>
        </div>
    </div>
    <div class='col-lg-4'>
        <div class="form-group">
            <div class="input-group ">
                <span class="input-group-addon">{{ Lang::get('general.profile') }}</span>
                @if(isset($drejtimSel))
                {{ Form::select('drejtimi', $drejtimi,$drejtimSel,array('class'=>'form-control ')) }}
                @else
                {{ Form::select('drejtimi', $drejtimi,null,array('class'=>'form-control ')) }}
                @endif
            </div>
        </div>
    </div>
    <div class='col-lg-2'>
        <div class="form-group">
            <div class="col-sm-9">
                <button name="submit" type="submit" class="btn btn-primary"> {{ Lang::get('general.search') }}</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
<table class='table table-responsive table-bordered'>
    <thead>
        <tr>
            <th>#</th>
            <th>{{ Lang::get('general.course') }}</th>
            <th>{{ Lang::get('general.lecturer') }}</th>
            <th>{{ Lang::get('general.profile') }}</th>
            <th>{{ Lang::get('general.deadline_exams') }}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if(isset($raportet))
        @foreach($raportet as $value)
        <tr>
            <td>{{ $value['idraportit'] }}</td>
            <td>{{ $value['lenda'] }}</td>
            <td>{{ $value['prof'] }}</td>
            <td>{{ $value['drejtimi'] }}</td>
            <td>{{ $value['data_provimit'] }}</td>
            @if($value['locked'] == Enum::nolocked)
            <td>
                <div class="btn-group">
                    <a href='#' class="btn btn-sm btn-success">{{ Lang::get('general.register_grade')}}</a>
                    <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-toggle="modal" data-target="#deleteCourse26"><span class="fa fa-trash-o fa-lg"> </span> Fshij</a></li>
                    </ul>
                </div>
            </td>
            @else
            <td>
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#viewReport{{ $value['idraportit'] }}">
                    {{ Lang::get('general.view_report')}}
                </button>
                @if(isset($raportet))
                @foreach($raportet as $value)
                <div class="modal fade" id="viewReport{{ $value['idraportit'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.report_grade') }}</h4>
                            </div>
                            <div class="modal-body">
                                <table class='table table-responsive table-bordered'>
                                    <tr>
                                        <td><h4><b>{{ Lang::get('general.course') }}</b>: {{ $value['lenda'] }}<br>
                                                <b>{{ Lang::get('general.lecturer')}}:</b> <span data-toggle="tooltip" data-placement="left" title="UID:{{ $value['profuid'] }}" > {{ $value['prof'] }}</span><br>
                                                <b>{{ Lang::get('general.date') }}</b>: {{ $value['data_provimit'] }}</h4></td>
                                        <td class="text-right">
                                            <a href="#" class="btn btn-sm btn-danger"><span class="fa fa-file-pdf-o" ></span></a>
                                            <a href="{{ action('ProvimetController@getPrintReportNotat',array($year,$month,$drejtimSel)) }}" class="btn btn-sm btn-default" ><span class="fa fa-print" ></span></a>
                                        </td>
                                    </tr>
                                </table>
                                <table class='table table-responsive table-bordered'>
                                    <thead>
                                        <tr>
                                            <th>{{ Lang::get('general.student') }}</th>
                                            <th>{{ Lang::get('general.test_semester') }}</th>
                                            <th>{{ Lang::get('general.test_semisemester') }}</th>
                                            <th>{{ Lang::get('general.seminar') }}</th>
                                            <th>{{ Lang::get('general.attendance') }}</th>
                                            <th>{{ Lang::get('general.practice_work') }}</th>
                                            <th>{{ Lang::get('general.final_test') }}</th>
                                            <th>{{ Lang::get('general.grade') }}</th>
                                            <th>{{ Lang::get('general.refuse') }}</th>
                                            <th>{{ Lang::get('general.apply') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reportList[$value['idraportit']] as $oneStudent)
                                        <tr id="listRStdrow{{ $value['idraportit'].$oneStudent['studenti'] }}">
                                            <td>{{ $oneStudent['emri']." ".$oneStudent['mbiemri'] }}</td>
                                            <td>{{ $oneStudent['testi_semestral'] }}</td>
                                            <td>{{ $oneStudent['testi_gjysemsemestral'] }}</td>
                                            <td>{{ $oneStudent['seminari'] }}</td>
                                            <td>{{ $oneStudent['pjesmarrja'] }}</td>
                                            <td>{{ $oneStudent['puna praktike'] }}</td>
                                            <td>{{ $oneStudent['testi_final'] }}</td>
                                            <td>{{ $oneStudent['nota'] }}</td>
                                            <td>{{ Enum::convertRefuzimi($oneStudent['refuzim']) }}</td>
                                            <td>{{ Enum::convertParaqitjen($oneStudent['paraqit']) }}</td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </td>
            @endif
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
@stop

@section('content')
<h2 class='text-capitalize '>{{ Lang::get('general.report_grade') }}</h2>
<hr>
@yield('notification')
@yield('report_grade')
@stop