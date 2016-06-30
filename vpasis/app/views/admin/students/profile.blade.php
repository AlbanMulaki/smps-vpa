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

<div class="box box-solid">
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

            <ul class="list-group list-group-unbordered">

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
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class='box-title'>{{ Lang::get('general.student_details') }}</h3>
            </div>
            <div class="box-body">
                <ul class="list-group list-group-unbordered">
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
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class='box-title'>{{ Lang::get('general.education_details') }}</h3>
            </div>
            <div class="box-body">
                <ul class="list-group list-group-unbordered">
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

@stop

@section('pagesat')
<div class="text-right">
    <a class="btn btn-default btn-sm" href="{{ action('StudentController@getPrintListPagesat',array($profile['uid'])) }}">
        <span class="fa fa-print"></span>
    </a>
    <br>
    <br>
</div>
<div class="box box-solid">
    <div class="box-body no-padding">
        <table class='table table-responsive table-bordered'>
            <tr>
                <th>#</th>
                <th>{{ Lang::get('general.bank_name') }}</th>
                <th>{{ Lang::get('general.description_fee') }}</th>
                <th>{{ Lang::get('general.feetype') }}</th>
                <th>{{ Lang::get('general.sum') }}</th>
                <th>{{ Lang::get('general.registred');$numFee=0 }}</th>
                <th> </th>
            </tr>

            @foreach($studenti->getPagesat as $value)
            <tr>
                <td>{{ ++$numFee}}</td>
                <td>{{ Enum::convertTypeBank($value['emri_bankes']) }}</td>
                <td>{{ $value['pershkrimi'] }}</td>
                <td>{{ Enum::convertLlojetPagesave($value['tipi']) }}</td>
                <td><span class="label label-info">{{ $value['shuma'];$shumaPaguar = $shumaPaguar + $value['shuma'] }} <span class="fa fa-euro"></span> </span></td>
                <td>{{ $value->data }}</td>
                <td><a href='{{ action('FeeController@getEdit',[$value->id]) }}' class='btn btn-sm btn-warning'><i class='fa fa-edit'></i></a></td>
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
<div class="box box-solid">
    <div class="box-body">
        <div class="col-md-6">
            <p><i class="fa fa-circle text-red"></i><b> Jo kaluese | Refuzim</b></p>
            <p><i class="fa fa-circle text-green"></i><b> Pranuar</b></p>
            <p><i class="fa fa-circle text-yellow"></i><b> Nuk eshte perfundimtare ende | Raporti eshte i hapur</b></p>
        </div>
        <div class="col-md-6">
            <a class="btn btn-app" href="{{ action('StudentController@getPrintTranskriptaNotave',array($profile['uid'])) }}">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
    </div>
</div>
<table class='table table-responsive table-bordered'>
    <tr>
        <th>#</th>
        <th>{{ Lang::get('general.course') }}</th>
        <th>{{ Lang::get('general.grade') }}</th>
        <th>{{ Lang::get('general.lecturer') }}</th>
        <th>{{ Lang::get('general.date') }}</th>
        @if($settings['provim_active'] == Enum::yes)
        <th>{{ Lang::get('general.refuse')}}</th>
        @endif
        <th>{{ Lang::get('general.present') }}</th>
    </tr>
    <?php
    $i = -1;
    $currentSem = 1;
    ?>
    @foreach($notimet as $value)
    <?php
    $i++;
    if ($value->refuzim == Enum::YES || $value->nota == 5) {
        $classColor = "bg-danger";
        $bulletColor = ' text-red';
    } else if ($value->refuzim == Enum::NO && $value->raportiNotave->locked == Enum::locked && $value->nota > 5) {
        $classColor = "bg-success";
        $bulletColor = ' text-green';
    } else if ($value->refuzim == Enum::NO && $value->raportiNotave->locked == Enum::nolocked) {
        $classColor = "bg-warning";
        $bulletColor = ' text-yellow';
    } else {
        $classColor = "";
        $bulletColor = ' ';
    }
    $classTree = "";
    if (isset($notimet[$i + 1])) {
        if ($notimet[$i + 1]->raportiNotave->lendet->idl == $value->raportiNotave->lendet->idl) {
            $classTree = "fa fa-plus-square";
        }
    }
    if (isset($notimet[$i - 1])) {
        if ($notimet[$i - 1]->raportiNotave->lendet->idl == $value->raportiNotave->lendet->idl) {
            $classColor .= " hide";
        }
    }
    ?>
    @if($i == 0)
    <?php
    $prevSemester = $value->raportiNotave->lendet->Semestri;
    ?>
    <tr class="bg-gray">
        <th colspan="6" class="text-center"> Semestri {{ $value->raportiNotave->lendet->Semestri }}</th>
    </tr>
    @elseif($prevSemester !=  $value->raportiNotave->lendet->Semestri)
    <tr class="bg-gray">
        <th colspan="6" class="text-center"> Semestri {{  $value->raportiNotave->lendet->Semestri    }}</th>
    </tr>
    @endif
    <?php
    $prevSemester = $value->raportiNotave->lendet->Semestri;
    ?>



    @if(($value->refuzim == Enum::YES || $value->nota == 5) && $value->raportiNotave->locked == Enum::locked)
    <tr class="{{ $classColor }} failedIdl-{{ $value->raportiNotave->lendet->idl }} ">
        <td><span class=" fa fa-circle {{ $bulletColor }}"></span></td>
        <td> -- {{ $value->raportiNotave->lendet->Emri }}</td>
        <td>{{ $value->nota }}</td>
        <td>{{ $value->raportiNotave->administrata->emri. " ".$value->raportiNotave->administrata->mbiemri  }}</td>
        <td>{{ date_format(date_create($value->raportiNotave->data_provimit),'d-m-Y') }}</td>
        <td>@if($value->paraqit_prezent)
            <input type="checkbox" checked="checked" disabled>
            @else
            <input type="checkbox" disabled>
            @endif
        </td>
    </tr>
    @else
    <tr class="{{ $classColor }} ">
        <td> <span class=" fa fa-circle {{ $bulletColor }}"></td>
        <td><span class="{{ $classTree }} trigger-show-detail-course text-default"  data-show-course-failed="{{ $value->raportiNotave->lendet->idl }}"> {{ $value->raportiNotave->lendet->Emri }}</span> </td>

        @if($value->nota == 4)
        <td>E Padefinuar</td>
        @else
        <td>{{ $value->nota }}</td>
        @endif
        <td>{{ $value->raportiNotave->administrata->emri. " ".$value->raportiNotave->administrata->mbiemri  }}</td>
        <td>{{ date_format(date_create($value->raportiNotave->data_provimit),'d-m-Y') }}</td>
        <td>@if($value->paraqit_prezent)
            <input type="checkbox" checked="checked" disabled>
            @else
            <input type="checkbox" disabled>
            @endif
        </td>
    </tr>
    @endif
    @endforeach
</table>

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
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="true">{{ Lang::get('general.student_profile') }}</a></li>
            <li class=""><a href="#vijushmeria" data-toggle="tab" aria-expanded="false">{{ Lang::get('general.attendance') }}</a></li>
            <li class=""><a href="#notimet" data-toggle="tab" aria-expanded="false">{{ Lang::get('general.exams') }}</a></li>
            <li class=""><a href="#pagesat" data-toggle="tab" aria-expanded="false">{{ Lang::get('general.fee') }}</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="profile">
                @yield('profile')
            </div>
            <div class="tab-pane" id="vijushmeria">
                @yield('vijushmeria')
            </div>
            <div class="tab-pane" id="notimet">
                @yield('notimet')
            </div>
            <div class="tab-pane" id="pagesat">
                @yield('pagesat')
            </div>
        </div>
    </div>
</section>



@stop