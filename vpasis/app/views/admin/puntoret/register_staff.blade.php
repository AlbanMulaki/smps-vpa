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

@section('registerForm')
{{ Form::open(array('url'=>action('StaffController@postRegister'),'method'=>'POST','files'=>true,'class'=>"form-horizontal")) }}

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
            <input class="form-control "  placeholder="{{ Lang::get('reminders.nationality') }}" type="text" value='' name="shtetas">
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.phone') }}</label>
        <div class="col-lg-9">
            <div class='input-group'>
                <span class="input-group-addon"><i class="fa fa-phone"></i> </span>
                <input class="form-control "  placeholder="{{ Lang::get('reminders.phone') }}" type="text" value='' name="telefoni">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.email') }}</label>
        <div class="col-lg-9">  
            <div class='input-group'>
                <span class="input-group-addon"><i class="fa fa-inbox"></i> </span>
                <input class="form-control "  placeholder="{{ Lang::get('reminders.email_example') }}" type="text" value='' name="email">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.idpersonal') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.idpersonal') }}" type="text" value='' name="nrpersonal">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.bank_account_number') }}</label>
        <div class="col-lg-9">
            <div class='input-group'>
                <span class="input-group-addon"><i class="fa fa-credit-card"></i> </span>
                <input class="form-control "  placeholder="{{ Lang::get('reminders.bank_account_number') }}" type="text" value='' name="xhirollogaria">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.bank_name') }}</label>
        <div class="col-lg-9">
            <input class="form-control"  placeholder="{{ Lang::get('reminders.bank_name') }}" type="text" value='' name="bank_name">
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
            <span class="input-group-addon">{{ Lang::get('general.position_office') }}</span>
            {{ Form::select('detyra', Enum::getGrp(),null,array('class'=>'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group col-lg-10">
            <span class="input-group-addon">{{ Lang::get('general.science_grade') }}</span>
            {{ Form::select('grada_shkencore', Enum::getGrade(),Enum::phd,array('class'=>'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class='input-group col-lg-10'>
            <span class="input-group-addon">{{ Lang::get('general.experience') }}</span>
            <textarea class="form-control"  placeholder="{{ Lang::get('reminders.experience') }}" name='eksperienca' > </textarea>
        </div>
    </div>
    <div class="form-group">
        <div class='input-group col-lg-10'>
            <span class="input-group-addon">{{ Lang::get('general.qualification') }}</span>
            <textarea class="form-control"  placeholder="{{ Lang::get('reminders.qualification') }}" name="kualifikimi" > </textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput">
                <i class="fa fa-file-text  fileinput-exists"></i>
                <span class="fileinput-filename"></span></div>
            <span class="input-group-addon btn btn-primary btn-file" style="color:#fff;">
                <span class="fileinput-new">{{ Lang::get('general.select_file') }}</span>
                <span class="fileinput-exists">{{ Lang::get('general.change') }}</span>
                <input type="file" name="cv"></span>
            <a href="#" class="input-group-addon btn btn-warning fileinput-exists"  style="color:#fff;" data-dismiss="fileinput">{{ Lang::get('general.remove') }}</a>
        </div>
    </div>
    <div class="form-group">
        <div class='input-group col-lg-10'>
            <span class="input-group-addon">{{ Lang::get('general.adress') }}</span>
            <textarea class="form-control"  placeholder="{{ Lang::get('general.adress') }}" name='adressa' > </textarea>
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

@section('title')
<section class="content-header">
    <h1>
        {{ Lang::get('general.add_employe') }}<small>{{ Lang::get('general.add_employe') }}</small>
    </h1>
    <br>

</section>
@stop
@section('content')
@yield('title')

<section class="content">
@yield('notification')
<div class="box box-warning">
    <div class="box-header with-borders">
        <h3 class="box-title">{{ Lang::get('general.add_employe') }}</h3>
    </div>
    <div class="box-body">
        @yield('registerForm')
    </div>
</div>
</section>
@stop