@extends('admin.index')

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


@section('profile')

<div class="box box-info">

    <div class="box-header with-border">
        <h3 class='box-title'>{{ Lang::get('general.student_details') }}</h3>
    </div>

    <div class="box-body">

        <div class='col-lg-3'>

            <div class='img-thumbnail '>
                <img src="/smpsfl/doc/avatar/{{  $profile['avatar'] }}" class="img img-rounded  img-responsive">
            </div>

        </div>

        <div class='col-lg-6'>
            <br>
            <strong class='text-uppercase fa-lg' >{{ $profile['emri']." ( ".$profile['emri_prindit']." ".$profile['mbiemri_prindit']." ) " .$profile['mbiemri'] }}</strong>

            <br>
            <strong>{{ Lang::get('general.uid') }}:</strong> {{ $profile['uid'] }} 
            <br><b>{{ Lang::get('general.birthdate') }}:</b>{{ $profile['datalindjes'] }}
            <br><b>{{ Lang::get('general.subject') }}:</b> {{ Enum::convertdrejtimi($profile['drejtimi']) }}
            <br><b>{{ Lang::get('general.semester') }}:</b> {{ $profile['semestri'] }}
        </div>

        <div class="col-lg-3">

            <ul class="list-group">

                <li class="list-group-item"> <strong>{{ Lang::get('general.contract_fee') }}: </strong><span 
                        class="label label-info" >{{ $profile['kontrata_pageses'] }} <span class="fa fa-euro"></span> </span> </li>
                <li class="list-group-item"><strong>{{ Lang::get('general.installments') }}: </strong> {{ $profile['keste'] }}</li>
                <li class="list-group-item "><strong>{{ Lang::get('general.installments_month') }}: </strong> <span class="label label-info" >{{ $profile['kontrata_pageses']/$profile['keste']  }} <span class="fa fa-euro"></span></span>  </li>

            </ul>
            <a class="btn btn-info" href="/smpsfl/doc/kontrata/student/{{ $profile['kontrata_dir'] }}"><span class="fa fa-print fa-lg"></span></a>
        </div>

    </div>
</div>

<div class="row">
    <div  class='col-lg-6'>
        <br>
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class='box-title'>{{ Lang::get('general.student_details') }}</h3>
            </div>
            <div class="box-body">
                <ul class="list-group">
                    <li class="list-group-item"> <strong>{{ Lang::get('general.location') }}: </strong>{{ $profile['vendbanimi'] }} - {{ $profile['adressa'] }}</li>
                    <li class="list-group-item"><strong>{{ Lang::get('general.birthplace') }}: </strong> {{ $profile['vendlindja'] }}</li>
                    <li class="list-group-item"><strong>{{ Lang::get('general.gender') }}: </strong> {{ Enum::convertGjinia($profile['gjinia']) }}</li>
                    <li class="list-group-item"><strong>{{ Lang::get('general.phone') }}: </strong> {{ $profile['telefoni'] }}</li>
                    <li class="list-group-item"><strong>{{ Lang::get('general.email') }}: </strong> {{ $profile['email'] }}</li>
                    <li class="list-group-item"><strong>{{ Lang::get('general.idpersonal') }}: </strong> {{ $profile['nrpersonal'] }}</li>
                </ul>
            </div>
        </div>
    </div>
    <br>


    <div  class='col-lg-6'>
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class='box-title'>{{ Lang::get('general.education_details') }}</h3>
            </div>
            <div class="box-body">
                <ul class="list-group">
                    <li class="list-group-item"> <strong>{{ Lang::get('general.subject') }}: </strong>{{ Enum::convertdrejtimi($profile['drejtimi'])  }} </li>
                    <li class="list-group-item"><strong>{{ Lang::get('general.level') }}: </strong> {{ Enum::convertLevel($profile['niveli']) }}</li>
                    <li class="list-group-item"><strong>{{ Lang::get('general.status') }}: </strong> {{ Enum::convertStatusi($profile['statusi']) }}</li>
                    <li class="list-group-item"><strong>{{ Lang::get('general.academic_year') }}: </strong> {{ $profile['viti_aka'] }}</li>
                    <li class="list-group-item"><strong>{{ Lang::get('general.transfer') }}: </strong> {{ Enum::convertTransfer($profile['transfer']) }}</li>
                    <li class="list-group-item"><strong>{{ Lang::get('general.qualification') }}: </strong> {{ $profile['kualifikimi'] }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@stop


@section('vijushmeria')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class='box-title'>{{ Lang::get('general.attendance') }}</h3>
    </div>
    <div class="box-body">
        <table class='table table-responsive table-bordered'>
            <tr>
                <th>{{ Lang::get("general.course") }}</th>
                <th>{{ Lang::get("general.professor") }}</th>
                <th>{{ Lang::get("general.num_hour")}}</th>
            </tr>
            @foreach($vijushmeria as $value)
            <tr>
                <td>{{ $value['lenda'] }}</td>
                <td>{{ $value['prof'] }}</td>
                <td>{{ $value['numhour'] }}</td>
            </tr>
            @endforeach
        </table>

    </div>
</div>

@stop

@section('pagesat')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ Lang::get('general.list_fee') }}</h3>
    </div>
    <div class="box-body">
        <div class="col-lg-offset-11 col-lg-1">
            <a class="btn btn-info" href="{{ action('StudentController@getPrintListPagesat',array($profile['uid'])) }}">
                <span class="fa fa-print fa-lg"></span>
            </a>
        </div>
        <table class='table table-responsive table-bordered'>
            <tr>
                <th>#</th>
                <th>{{ Lang::get('general.bank_name') }}</th>
                <th>{{ Lang::get('general.description_fee') }}</th>
                <th>{{ Lang::get('general.feetype') }}</th>
                <th>{{ Lang::get('general.sum') }}</th>
                <th>{{ Lang::get('general.registred');$numFee=0 }}</th>
            </tr>

            @foreach($pagesat as $value)
            <tr>
                <td>{{ ++$numFee}}</td>
                <td>{{ $value['emri_bankes'] }}</td>
                <td>{{ $value['pershkrimi'] }}</td>
                <td>{{ Enum::convertLlojetPagesave($value['tipi']) }}</td>
                <td><span class="label label-info">{{ $value['shuma'];$shumaPaguar = $shumaPaguar + $value['shuma'] }} <span class="fa fa-euro"></span> </span></td>
                <td>{{ $value['created_at'] }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-right bold">{{ Lang::get('general.total_sum') }}</td>
                <td><span class="label label-primary">{{ $shumaPaguar }} <span class="text-center fa fa-lg fa-euro"></span> </span></td>
            </tr>
        </table>

    </div>
</div>
@stop

@section('notimet')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class='box-title'>{{ Lang::get('general.exams') }}</h3>
    </div>
    <div class="box-body">

        <table class='table table-responsive table-bordered'>
            <tr>
                <th>#</th>
                <th>{{ Lang::get('general.course') }}</th>
                <th>{{ Lang::get('general.grade') }}</th>
                <th>{{ Lang::get('general.lecturer') }}</th>
                <th>{{ Lang::get('general.date') }}</th>
                @if($settings['provim_active'] == Enum::yes)
                <th>{{ Lang::get('general.refuse')}}</th>
                <th>{{ Lang::get('general.apply')}}</th>
                @endif
                <th>{{ Lang::get('general.attendance')}}</th>
            </tr>
            @foreach($notimet as $value)
            <tr>
                <td> </td>
                <td>{{ $value['lenda'] }}</td>
                <td>{{ $value['nota'] }}</td>
                <td>{{ $value['prof'] }}</td>
                <td>{{ $value['data'] }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@stop

@section('title')
<section class="content-header">
    <h1>
        {{ $profile['emri']." ".$profile['mbiemri'] }}

    </h1>
</section>
@stop

@section('content')
@yield('title')
<section class="content">
    @yield('notification')

    <!-- Nav tabs -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{ Lang::get('general.student_profile') }}</a></li>
            <li role="presentation"><a href="#vijushmeria" aria-controls="vijushmeria" role="tab" data-toggle="tab">{{ Lang::get('general.attendance') }}</a></li>
            <li role="presentation"><a href="#notimet" aria-controls="notimet" role="tab" data-toggle="tab">{{ Lang::get('general.exams') }}</a></li>
            <li role="presentation"><a href="#pagesat" aria-controls="pagesat" role="tab" data-toggle="tab">{{ Lang::get('general.fee') }}</a></li>
        </ul>
    </div>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="profile">@yield('profile')</div>
        <div role="tabpanel" class="tab-pane" id="vijushmeria">@yield('vijushmeria')</div>
        <div role="tabpanel" class="tab-pane" id="notimet">@yield('notimet')</div>
        <div role="tabpanel" class="tab-pane" id="pagesat">@yield('pagesat')</div>
    </div>
</section>



@stop