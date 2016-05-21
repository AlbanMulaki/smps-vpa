@extends("admin.index")


@section('regjistrmiNotave')
<table class='table table-bordered' id="raportiNotaveTable">

    <thead
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
        <tr class="provRow">
            <td>
                <input name='id[]' type='hidden' value='' />
                <input name='idl' type='hidden' value='' />
                <input name='idraportit' type='hidden' value='' />
                <input name="name_surname[]" class='form-control input-sm' type='text' value='' />
            </td>
            <td>
                <input name="uid[]" class='form-control input-sm' type='number' min="0" value='' />
            </td>
            <td>
                <input name="test_semestral[]" class='form-control input-sm' type='number' min="0" value='' />
            </td>
            <td>
                <input name="testi_gjysemsemestral[]" class='form-control input-sm' type='number' min="0" value='' />
            </td>
            <td>
                <input name="seminari[]" class='form-control input-sm' style='width:60px;' type='number' min="0" value='' />
            </td>
            <td>
                <input name="pjesmarrja[]" class='form-control input-sm' style='width:60px;' type='number' min="0" value='' />
            </td>
            <td>
                <input name="praktike[]" class='form-control input-sm' type='number' value='' />
            </td>
            <td>
                <input name="testi_final[]" class='form-control input-sm' style='width:60px;' type='number' value='' />
            </td>
            <td>
                {{ Form::selectRange('nota[]', 5,10,5,array('class'=>'form-control input-sm')) }}
            </td>
            <td>

                {{ Form::select('refuzim[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),Enum::YES,array('class'=>'form-control input-sm')) }}
            </td>
            <td>
                {{ Form::select('paraqit[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),Enum::YES,array('class'=>'form-control input-sm')) }}
            </td>
            <td>
                {{ Form::select('paraqit_prezent[]', array(Enum::YES=>Lang::get('general.yes'),Enum::NO=>Lang::get('general.no')),Enum::YES,array('class'=>'form-control input-sm')) }}
            </td>
        </tr>
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
@section('createReport')

<div class="box box-success">
    <div class="box-body">
        <div class='col-md-6'>
            <div class="form-group">
                <label>{{ Lang::get('general.course') }}</label>
                {{ Form::select('idl', $raportiNotave,current($raportiNotave),array('class'=>'form-control input-sm')) }}
            </div>
            <div class="form-group">
                <label>{{ Lang::get('general.professor') }}</label>
                <select name='prof' class='form-control input-sm'>
                    <option>{{ Lang::get('general.select_prof') }}</option>
                    @foreach($prof as $professori)
                    <option value='{{ $professori->uid }}'>{{ $professori->emri." ".$professori->mbiemri }}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class='col-md-6'>
            <div class="form-group">
                <label>Data provimit:   </label>
                <div class='input-group date' id='datetimepicker1'>
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"> </span>
                    </span>
                    <input type='text' name='data_provimit' id='datepicker' class='datetimepicker input-sm form-control' /> 
                </div>
            </div>
            <div class="form-group">
                <div class="radio">
                    <label>
                        <input type="radio" name="statusi_studentve" id="optionsRadios1" value="{{ Enum::I_RREGULLT }}">
                        {{ Lang::get('general.regular') }}
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="statusi_studentve" id="optionsRadios2" value="{{ Enum::JO_RREGULLT }}">
                        {{ Lang::get('general.not_regular') }}
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box box-default">
    <div class="box-body">
        <div class='col-md-12'>
            @yield('regjistrmiNotave')
        </div>
    </div>
</div>


@stop

@section('title')
<section class="content-header">
    <h1>
        {{ Lang::get('general.add_new_report_grade') }}<small>{{ Lang::get('general.add_new_report_grade') }}</small>
    </h1>
</section>
@stop


@section('content')
@yield('title')
<section class='content'>
    @yield('notification')
    {{ Form::open(array('url'=>action('ProvimetController@postAddRaportiNotave'),'method'=>'POST','id'=>"submitRaport")) }}
    @yield('createReport')
    {{ Form::close() }}
</section>
@stop