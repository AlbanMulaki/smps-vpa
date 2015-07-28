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


@section('registerStudent')
{{ Form::open(array('url'=>action('StudentController@postRegister'),'method'=>'POST','files'=>true,'class'=>"form-horizontal")) }}
<div class='col-lg-6'>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.name') }}</label>
        <div class="col-lg-9">
            <input class="form-control text-capitalize"  placeholder="{{ Lang::get('reminders.name') }}" type="text"  name="emri">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.surname') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.surname') }}" type="text" name="mbiemri">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.name_dad') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.name_dad') }}" type="text" name="emri_prindit">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.surname_dad') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.surname_dad') }}" type="text" name="mbiemri_prindit">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.birthplace') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.birthplace') }}" type="text" name="vendlindja">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.birthdate') }}</label>
        <div class="col-lg-9">
            <input class="form-control " id="birthdate"  placeholder="VVVV/MM/DD" data-mask="" type="text" name="datalindjes">
        </div>
        <script>
            $('#birthdate').inputmask({
                mask: '9999-99-99'
            })
        </script>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.location') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.location') }}" type="text" name="vendbanimi">
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.nationality') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.nationality') }}" type="text" name="shtetas">
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.phone') }}</label>
        <div class="col-lg-9">
            <div class='input-group'>
                <span class="input-group-addon"><i class="fa fa-phone"></i> </span>
                <input class="form-control "  placeholder="{{ Lang::get('reminders.phone') }}" type="text"  name="telefoni">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.email') }}</label>
        <div class="col-lg-9">  
            <div class='input-group'>
                <span class="input-group-addon"><i class="fa fa-inbox"></i> </span>
                <input class="form-control "  placeholder="{{ Lang::get('reminders.email_example') }}" type="text"  name="email">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.idpersonal') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.idpersonal') }}" type="text" value='' name="nrpersonal">
        </div>
    </div>
</div>
<div class='col-lg-4'>

    <div class="form-group">
        <div class="input-group col-lg-10">
            {{ Form::select('gjinia', Enum::getGjinia(),null,array('class'=>'form-control')) }}
        </div>
    </div>



    <div class="form-group">
        <div class="input-group col-lg-10">
            <span class="input-group-addon">{{ Lang::get('general.level') }}</span>
            {{ Form::select('niveli', Enum::getLevel(),current(Enum::getLevel()),array('class'=>'form-control')) }}
        </div>
    </div>



    <div class="form-group">
        <div class='input-group col-lg-10'>
            <span class="input-group-addon">{{ Lang::get('general.academic_year') }}</span>
            <input class="form-control "  placeholder="VVVV-VVVV" id='vitiaka' type="text"  name="viti_aka">

            <script>
                $('#vitiaka').inputmask({
                    mask: '9999-9999'
                })
            </script>
        </div>
    </div>


    <div class="form-group">
        <div class="input-group col-lg-10">
            <span class="input-group-addon">{{ Lang::get('general.subject') }}</span>
            {{ Form::select('drejtimi', $drejtimet,current($drejtimet),array('class'=>'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group col-lg-10">
            <span class="input-group-addon">{{ Lang::get('general.semester') }}</span>
            {{ Form::select('semestri', Enum::getSemester(),current(Enum::getSemester()),array('class'=>'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group col-lg-10">
            <span class="input-group-addon">{{ Lang::get('general.status') }}</span>
            {{ Form::select('statusi', Enum::getStatus(),current(Enum::getStatus()),array('class'=>'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group col-lg-10">
            <span class="input-group-addon">{{ Lang::get('general.transfer') }}</span>
            {{ Form::select('transfer', array(Enum::yes => Lang::get('general.yes'),Enum::no => Lang::get('general.no')),Enum::yes,array('class'=>'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class='input-group col-lg-10'>
            <span class="input-group-addon">{{ Lang::get('general.adress') }}</span>
            <textarea class="form-control"  placeholder="{{ Lang::get('reminders.adress') }}" name='adressa' > </textarea>
        </div>
    </div>
    <div class="form-group">
        <div class='input-group col-lg-10'>
            <span class="input-group-addon">{{ Lang::get('general.qualification') }}</span>
            <textarea class="form-control"  placeholder="{{ Lang::get('reminders.qualification') }}" name="kualifikimi" > </textarea>
        </div>
    </div>
</div>

<div class='col-lg-2'>
    <div class="form-group">
        <div class="file-input file-input-new ">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 150px; height: 150px;">
                    <img src="/img/avatar.png">
                </div>
                <div>
                    <span class="btn btn-default btn-sm btn-file"><span class="fileinput-new">{{ Lang::get('general.chose_image') }}</span>
                        <span class="fileinput-exists">{{ Lang::get('general.change') }}</span>
                        <input type="file" name="avatar" accept="image/*">
                    </span>
                    <a href="#" class="btn btn-sm btn-warning fileinput-exists" data-dismiss="fileinput">{{ Lang::get('general.remove') }}</a>
                </div>
            </div>
        </div>  
    </div>  

    <div class="form-group">
        <div class='input-group col-lg-10'>
            <input class="form-control "   type="text"  name="kontrata_pageses" id="kontrata_pages">
            <span class="input-group-addon"><span class='fa fa-euro'></span></span>
        </div>
    </div>

    <div class="form-group">
        <div class="input-group col-lg-10">
            <span class="input-group-addon  input-sm">{{ Lang::get('general.installments') }}</span>
            {{ Form::selectRange('keste', 1,12,1,array('class'=>'form-control input-sm','id'=>'kesti_mujor')) }}
        </div>
    </div>
    <div class='form-group'>
        {{ Lang::get('general.installments_month')}}: <div>
            <span  id="kesti_mujorbar"  class='fa fa-lg'></span>
            <span class='fa fa-euro fa-lg'></span>
        </div>
    </div>
    <script>
        $('#kesti_mujor').change(function () {
            var kesti = $('#kontrata_pages').val() / $('#kesti_mujor').val();
            $('#kesti_mujorbar').empty().append(kesti);
        });

    </script>
</div>
<div class='col-lg-12'>
    <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
            <button type="reset" class="btn btn-default">{{ Lang::get("general.cancel") }}</button>
            <button type="submit" class="btn btn-primary">{{ Lang::get("general.add") }}</button>
        </div>
    </div>
</div>
{{ Form::close() }}
@stop


@section('content')
<h2 class='text-capitalize '>{{ Lang::get('general.add_student') }}</h2>
<hr>
@yield('notification')
@yield('registerStudent')
@stop


