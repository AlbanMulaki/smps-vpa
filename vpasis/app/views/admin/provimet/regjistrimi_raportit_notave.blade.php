@extends("admin.index")


@section('notification')

@if($errors->userDoesntExistError->any())
<div class="callout callout-danger">
    <h4>Student ID nuk egzizton</h4>
    <ul>
        @foreach($errors->userDoesntExistError->getMessages() as $userStudent)
        <li>Student ID: <b>{{ $userStudent[0] }}</b></li>
        @endforeach
    </ul>
</div>
@endif

<!-- Regjistrimi Departmentit -->
@if(null !== Session::get('message') && Session::get('message') == Enum::successful)

<div class="callout callout-success">
    <h4>@lang('general.saved_successful')</h4>
    <p>{{ Session::get('reason') }}</p>
</div>

@elseif(Session::get('message') == Enum::failed)
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Lang::get('warn.error_undefined') }}
</div>

@endif
<!-- End Regjistrimi Departmentit -->
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
    {{ Form::open(array('url'=>action('ProvimetController@postUpdateReport'),'method'=>'POST','id'=>"submitRaport")) }}

    <div class="box box-warning">

        @if($raporti->locked == Enum::nolocked)
        <div class="box-header with-border">
            <a href="{{ action('ProvimetController@getLockReportGrade',[$raporti->id]) }}" class="btn btn-warning btn-sm "><i class="fa fa-lock"></i> Mbyll raportin</a>
        </div>
        @endif
        <div class="box-body with-border no-padding">
            <input name='idraportit' type='hidden' value='{{ $raporti->id }}' />
            @if($raporti->locked == Enum::nolocked)
            @include('admin.provimet.partial.list_of_student_report',array('$raportiNotave'=>$raporti->raportiNotaveStudent))
            @else 
            @include('admin.provimet.partial.list_of_student_report_locked',array('$raportiNotave'=>$raporti->raportiNotaveStudent))
            @endif
        </div>

        @if($raporti->locked == Enum::nolocked)
        <div class="box-footer with-border">
            <div class="text-center">
                <button class="btn btn-primary" name="submit" >{{ Lang::get('general.update') }}</button>
            </div>

        </div>
        @endif
    </div>
    {{ Form::close() }}
</div>
</section>
@stop