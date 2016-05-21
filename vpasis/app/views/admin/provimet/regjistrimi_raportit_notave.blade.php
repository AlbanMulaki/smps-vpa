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
                    <h4><b>{{ Lang::get('general.course') }}</b>: {{ $details['lenda'] }}<br>
                        <b>{{ Lang::get('general.lecturer')}}:</b> <span data-toggle="tooltip" data-placement="left" title="UID:{{ $details['profuid'] }}" > {{ $details['prof'] }}</span><br>
                        <b>{{ Lang::get('general.date') }}</b>: {{ $details['data_provimit'] }}</h4>
                </div>
                <div class='col-md-2'>
                    <div class="text-right">
                        <a href="#" class="btn btn-sm btn-danger"><span class="fa fa-file-pdf-o" ></span></a>
                        <a href="{{ action('ProvimetController@getPrintReportNotat',array(substr($details["data_provimit"],0,4),substr($details["data_provimit"],5,2),$details["drejtimiId"])) }}" class="btn btn-sm btn-default" ><span class="fa fa-print" ></span></a>
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
        {{ "";$i=1}}
        @foreach($raporti as $value)
        <tr class="provRow">
            <td>
                <input name='id[]' type='hidden' value='{{$value->id}}' />
                <input name='idl' type='hidden' value='{{$raportiNotave->idl}}' />
                <input name='idraportit' type='hidden' value='{{$raportiNotave->id}}' />
                <input name="name_surname[]" class='form-control input-sm' type='text' value='{{ $value->getStudent[0]->emri." ".$value->getStudent[0]->mbiemri }}' />
            </td>
            <td>
                <input name="uid[]" class='form-control input-sm' type='number' min="0" value='{{ $value->getStudent[0]->uid }}' />
            </td>
            <td>
                <input name="testi_semestral[]" class='form-control input-sm' type='number' min="0" value='{{ $value['testi_semestral'] }}' />
            </td>
            <td>
                <input name="testi_gjysemsemestral[]" class='form-control input-sm' type='number' min="0" value='{{ $value['testi_gjysemsemestral'] }}' />
            </td>
            <td>
                <input name="seminari[]" class='form-control input-sm' style='width:60px;' type='number' min="0" value='{{ $value['seminari'] }}' />
            </td>
            <td>
                <input name="pjesmarrja[]" class='form-control input-sm' style='width:60px;' type='number' min="0" value='{{ $value['pjesmarrja'] }}' />
            </td>
            <td>
                <input name="praktike[]" class='form-control input-sm' type='number' value='{{ $value['praktike'] }}' />
            </td>
            <td>
                <input name="testi_final[]" class='form-control input-sm' style='width:60px;' type='number' value='{{ $value['testi_final'] }}' />
            </td>
            <td>
                {{ Form::selectRange('nota[]', 5,10,$value['nota'],array('class'=>'form-control input-sm')) }}
            </td>
            <td>

                {{ Form::select('refuzim[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),$value['refuzim'],array('class'=>'form-control input-sm')) }}
            </td>
            <td>
                {{ Form::select('paraqit[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),$value['paraqit'],array('class'=>'form-control input-sm')) }}
            </td>
            <td>
                {{ Form::select('paraqit_prezent[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),$value['paraqit_prezent'],array('class'=>'form-control input-sm')) }}
            </td>
            <td>
                <a href='#' class='btn btn-sm btn-default'><i class='fa fa-lg fa-times'></i> </a>
            </td>
        </tr>
        {{ "";$i++ }}
        @endforeach
        <tr>
            <td colspan="12">
                <a href="#"  id="addNewRow"><span class="fa fa-plus-circle fa-lg"></span> {{ Lang::get('general.add_new_row') }}</a></td>
        </tr>
    </tbody>
</table>
<div class="text-center">
    <button class="btn btn-primary" name="submit" >{{ Lang::get('general.update') }}</button>
</div>
@stop


@section('content')
<h2 class='text-capitalize '>{{ Lang::get('general.report_grade') }}</h2>
<hr>
@yield('notification')

{{ Form::open(array('url'=>action('ProvimetController@postUpdateReport'),'method'=>'POST','id'=>"submitRaport")) }}
@yield('regjistrmiNotave')
{{ Form::close() }}
@stop