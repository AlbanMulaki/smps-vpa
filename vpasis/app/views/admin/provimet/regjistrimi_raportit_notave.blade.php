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

@section('regjistrmiNotave')
<table class='table table-bordered' id="raportiNotaveTable">

    <thead>
        <tr>
            <td colspan="12">
                <div class='col-md-10'> 
                    <h4><b>{{ Lang::get('general.course') }}</b>: {{ $raporti->lendet->Emri }}<br>
                        <b>{{ Lang::get('general.lecturer')}}:</b> <span data-toggle="tooltip" data-placement="left" title="UID:{{ $raporti->administrata->uid }}" > {{ $raporti->administrata->emri." ".$raporti->administrata->mbiemri }}</span><br>
                        <b>{{ Lang::get('general.date') }}</b>: {{ $raporti->data_provimit }}</h4>
                </div>
                <div class='col-md-2'>
                    <div class="text-right">
                        <a href="#" class="btn btn-sm btn-danger"><span class="fa fa-file-pdf-o" ></span></a>
                        <a href="{{ action('ProvimetController@getPrintReportNotat',array(substr($raporti->data_provimit,0,4),substr($raporti->data_provimit,5,2),$raporti->lendet->Drejtimi)) }}" class="btn btn-sm btn-default" ><span class="fa fa-print" ></span></a>
                    </div>
                </div>

            </td>

        </tr>
        <tr>
            <th>{{ Lang::get('general.student') }}</th>
            <th>{{ Lang::get('general.studentId') }}</th>
            <th>{{ Lang::get('general.test_semester') }}</th>
            <th>{{ Lang::get('general.test_semisemester') }}</th>
            <th>{{ Lang::get('general.seminar') }}</th>
            <th>{{ Lang::get('general.attendance') }}</th>
            <th>{{ Lang::get('general.practice_work') }}</th>
            <th>{{ Lang::get('general.final_test') }}</th>
            <th style='width: 80px;'>{{ Lang::get('general.grade') }}</th>
            <th style='width: 80px;'>{{ Lang::get('general.refuse') }}</th>
            <th style='width: 80px;'>{{ Lang::get('general.apply') }}</th>
            <th  style='width: 80px;'>{{ Lang::get('general.present') }}</th>
        </tr>
    </thead>
    <tbody>
        
        @include('admin.provimet.partial.list_of_student_report',array('$raportiNotave'=>$raporti->raportiNotaveStudent))
    </tbody>
</table>
<div class="text-center">
    <button class="btn btn-primary" name="submit" >{{ Lang::get('general.update') }}</button>
</div>
@stop

@section('title')
<section class="content-header">
    <h1>
        {{ Lang::get('general.report_grade') }}<small>{{ Lang::get('general.report_grade') }}</small>
    </h1>
</section>
@stop

@section('content')
@yield('title')
<section class="content">

    <hr>
    @yield('notification')
    <div class="box box-warning">
        <div class="box-body with-border">
        {{ Form::open(array('url'=>action('ProvimetController@postUpdateReport'),'method'=>'POST','id'=>"submitRaport")) }}
                <input name='idraportit' type='hidden' value='{{ $raporti->id }}' />
            @yield('regjistrmiNotave')
        {{ Form::close() }}
        </div>
    </div>
    </div>
</section>
@stop