@extends('admin.index')

@section('notification')


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

@stop

@section('title')
<section class="content-header">
    <h1>
        {{ Lang::get('general.academic_list') }}<small>{{ Lang::get('general.academic_list') }}</small>
    </h1>
</section>
@stop



@section('listStaff')
<div class="box box-info">
    <!-- Default panel contents -->
    <div class="box-header with-border">
        <h3 class="box-title">{{ Lang::get('general.academic_list') }}</h3>
    </div>
    <!-- Table -->
    <table class="table table-responsive table-hover">
        <tr>
            <th>#</th>
            <th>{{ Lang::get('general.name')}} {{ Lang::get('general.surname')}}</th>
            <th>{{ Lang::get('general.email') }}</th>
            <th>{{ Lang::get('general.phone')}}</th>
            <th>{{ Lang::get('general.science_grade') }}</th>
            <th>{{ Lang::get('general.position_office') }}</th>
            <th> 

                <a href="{{ action('StaffController@getPrintPdf') }}" type="button" class="btn btn-sm btn-danger">
                    <span class="fa fa-file-pdf-o fa-lg"></span> 
                </a>
                <a href="{{ action('StaffController@getPrintPdfDirect',array(implode("-",$grp))) }}" id="printPlanProgrammin" class="btn btn-sm btn-default">
                    <span class="fa fa-print fa-lg"></span>  
                </a></th>
        </tr>
        @foreach($staff as $value)
        <tr>
            <td>{{ $value['uid'] }}</td>
            <td class='text-info '> {{ $value['emri']." ".$value['mbiemri'] }}</td>
            <td>{{ $value['email'] }}</td>
            <td>{{ $value['telefoni']}}</td>
            <td><b>{{ Enum::convertgrade($value['grada_shkencore']) }}</b></td>
            <td>{{ Enum::convertDetyra($value['detyra']) }}</td>
            <td><a class='btn btn-sm btn-primary' href='{{ action('StaffController@getProfile',array($value['uid']))}}'> {{ Lang::get('general.view_profile') }} </a></td>
        </tr>
        @endforeach
    </table>
</div>
@stop

@section('content')
@yield('title')

<section class='content'>
    @yield('notification')
    @yield('listStaff')
</section>
@stop