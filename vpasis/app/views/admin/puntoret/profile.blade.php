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
{{ Form::open(array('url'=>action('StaffController@postUpdate'),'method'=>'POST','files'=>true,'class'=>"form-horizontal")) }}

<input name="uid" value="{{ $profile['uid'] }}"  type="hidden">

<div class='col-lg-6'>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.name') }}</label>
        <div class="col-lg-9">
            <input class="form-control text-capitalize"  placeholder="{{ Lang::get('reminders.name') }}" type="text"  name="emri" value='{{ $profile['emri'] }}'>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.surname') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.surname') }}" type="text" name="mbiemri" value='{{ $profile['mbiemri'] }}'>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.birthplace') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.birthplace') }}" type="text" name="vendlindja"  value='{{ $profile['vendlindja'] }}'>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.birthdate') }}</label>
        <div class="col-lg-9">
            <input class="form-control " id="birthdate"  placeholder="VVVV/MM/DD" data-mask="" type="text" name="datalindjes" value='{{ $profile['datalindjes'] }}'>
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
            <input class="form-control "  placeholder="{{ Lang::get('reminders.location') }}" type="text" name="vendbanimi"  value='{{ $profile['vendbanimi'] }}'>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.nationality') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.nationality') }}" type="text"  name="shtetas"  value='{{ $profile['shtetas'] }}'>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.phone') }}</label>
        <div class="col-lg-9">
            <div class='input-group'>
                <span class="input-group-addon"><i class="fa fa-phone"></i> </span>
                <input class="form-control "  placeholder="{{ Lang::get('reminders.phone') }}" type="text"  value='{{ $profile['telefoni'] }}' name="telefoni" >
            </div>
        </div>
    </div>
    <div class="form-group">




        <label class="col-lg-3 control-label">{{ Lang::get('general.email') }}</label>
        <div class="col-lg-9">  
            <div class='input-group'>
                <span class="input-group-addon"><i class="fa fa-inbox"></i> </span>
                <input class="form-control "  placeholder="{{ Lang::get('reminders.email_example') }}" type="text"  name="email"  value='{{ $profile['email'] }}'>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.idpersonal') }}</label>
        <div class="col-lg-9">
            <input class="form-control "  placeholder="{{ Lang::get('reminders.idpersonal') }}" type="text" name="nrpersonal"  value='{{ $profile['nrpersonal'] }}'>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.bank_account_number') }}</label>
        <div class="col-lg-9">
            <div class='input-group'>
                <span class="input-group-addon"><i class="fa fa-credit-card"></i> </span>
                <input class="form-control "  placeholder="{{ Lang::get('reminders.bank_account_number') }}" type="text"  value='{{ $profile['xhirollogaria'] }}' name="xhirollogaria">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">{{ Lang::get('general.bank_name') }}</label>
        <div class="col-lg-9">
            <input class="form-control"  placeholder="{{ Lang::get('reminders.bank_name') }}" type="text"  value='{{ $profile['bank_name'] }}' name="bank_name">
        </div>
    </div>
</div>
<div class='col-lg-4'>

    <div class="form-group">
        <div class="input-group col-lg-10">
            {{ Form::select('gjinia', Enum::getGjinia(),$profile['gjinia'],array('class'=>'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="input-group col-lg-10">
            <span class="input-group-addon">{{ Lang::get('general.position_office') }}</span>
            {{ Form::select('detyra', Enum::getGrp(),$profile['detyra'],array('class'=>'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group col-lg-10">
            <span class="input-group-addon">{{ Lang::get('general.science_grade') }}</span>
            {{ Form::select('grada_shkencore', Enum::getGrade(),$profile['grada_shkencore'],array('class'=>'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class='input-group col-lg-10'>
            <span class="input-group-addon">{{ Lang::get('general.experience') }}</span>
            <textarea class="form-control"  placeholder="{{ Lang::get('reminders.experience') }}" name='eksperienca' > {{ $profile['eksperienca'] }} </textarea>
        </div>
    </div>
    <div class="form-group">
        <div class='input-group col-lg-10'>
            <span class="input-group-addon">{{ Lang::get('general.qualification') }}</span>
            <textarea class="form-control"  placeholder="{{ Lang::get('reminders.qualification') }}" name="kualifikimi" >{{ $profile['kualifikimi'] }} </textarea>
        </div>
    </div>
    <div class="form-group">
        <div class='col-lg-10'>
            <input type="hidden" name="cvname" value="{{ $profile['cv'] }}" >
            <a href="/smpsfl/doc/cv/{{ $profile['cv'] }}" class="btn btn-warning">
                {{ Lang::get('general.view_cv') }}
            </a>
        </div>
    </div>
    <div class="form-group">
        <div class="fileinput input-group fileinput-exists" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput">
                <i class="fa fa-file-text  fileinput-exists"></i>
                <span class="fileinput-filename">{{ substr($profile['cv'],0,8) }}...</span></div>
            <span class="input-group-addon btn btn-primary btn-file" style="color:#fff;">
                <span class="fileinput-new">Ndrysho</span>
                <span class="fileinput-exists">Ndrysho</span>
                <input name="cv" type="file">
            </span>
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
                    <img src="/smpsfl/doc/avatar/{{ $profile['avatar'] }}">
                </div>
                <div>
                    <span class="btn btn-default btn-sm btn-file"><span class="fileinput-new">{{ Lang::get('general.change_image') }}</span>
                        <span class="fileinput-exists">{{ Lang::get('general.change') }}</span>
                        <input type="hidden" name="avatarname" value="{{ $profile['avatar'] }}" >
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
            <button type="submit" class="btn btn-primary">{{ Lang::get("general.update") }}</button>
        </div>
    </div>
</div>
{{ Form::close() }}
@stop



@section('content')
<h2 class='text-capitalize '>{{ Lang::get('general.add_employe') }}</h2>
<hr>
@yield('notification')
<div class="panel panel-default">
    <div class="panel-heading">{{ Lang::get('general.add_employe') }}</div>
    <div class="panel-body">
        @yield('registerForm')
    </div>
</div>
@stop