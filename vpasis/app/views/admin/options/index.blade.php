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
@section('settings')  

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{{ Lang::get('general.college_options') }}</h3>
    </div>
    <div class="panel-body">

        {{ Form::open(array('url'=>action('OptionsController@postUpdateOptions'),'method'=>'POST','files'=>true,'class'=>"form-horizontal")) }}

        <div class="row">
            <div class='col-sm-8'>
                <div class="form-group">
                    <label for="{{ Lang::get('general.college_name') }}" class="col-sm-3 control-label">{{ Lang::get('general.college_name') }}</label>
                    <div class="col-sm-9">
                        <input name="name_company" type="text" class="form-control" id="{{ Lang::get('general.college_name') }}" placeholder="{{ Lang::get('general.college_name') }}" value="{{ $settings['name_company'] }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="{{ Lang::get('general.adress') }}" class="col-sm-3 control-label">{{ Lang::get('general.adress') }}</label>
                    <div class="col-sm-9">
                        <textarea name="adressa"  class="form-control" id="{{ Lang::get('general.adress') }}" placeholder="{{ Lang::get('general.adress') }}" >{{ $settings['adressa'] }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="{{ Lang::get('general.phone') }}" class="col-sm-3 control-label">{{ Lang::get('general.phone') }}</label>
                    <div class="col-sm-9">
                        <input name="phone" type="text" class="form-control" id="{{ Lang::get('general.phone') }}" placeholder="{{ Lang::get('general.phone') }}" value="{{ $settings['phone'] }}" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="{{ Lang::get('general.website') }}" class="col-sm-3 control-label" >{{ Lang::get('general.website') }}</label>

                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">http://www.</div>

                            <input name="website" type="text" class="form-control" id="{{ Lang::get('general.website') }}" placeholder="{{ Lang::get('general.website') }}" value="{{ $settings['website'] }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="{{ Lang::get('general.email_official') }}" class="col-sm-3 control-label">{{ Lang::get('general.email_official') }}</label>
                    <div class="col-sm-9">
                        <input name="info_email" type="email" class="form-control" id="{{ Lang::get('general.email_official') }}" placeholder="{{ Lang::get('general.email_official') }}" value="{{ $settings['info_email'] }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="{{ Lang::get('general.email_support') }}" class="col-sm-3 control-label">{{ Lang::get('general.email_support') }}</label>
                    <div class="col-sm-9">
                        <input name="support_email" type="email" class="form-control" id="{{ Lang::get('general.email_support') }}" placeholder="{{ Lang::get('general.email_support') }}" value="{{ $settings['support_email'] }}">
                    </div>
                </div>
            </div>
            <div class='col-sm-4'>
                <img src='{{ asset("img/".$settings['logo']) }}' alt="{{ Lang::get('general.logo') }}" class="well img-responsive img-rounded">
                <input type="file" name="logo" accept="image/*">
            </div>
        </div>
        <div class="row">
            <div class='col-sm-12'>
                <hr>
                <h2>{{ Lang::get('general.managed_event') }}</h2>
            </div>
        </div>
        <div class="row">
            <div class='col-sm-12'>
                <div class='col-sm-4'>
                    <div class="form-group">
                        <div class="input-group col-lg-10">
                            <span class="input-group-addon">{{ Lang::get('general.deadline_exams') }}</span>
                            {{ Form::select('provim_active', Enum::getGjendjetProvimeve(),$settings['provim_active'],array('class'=>'form-control')) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">{{ Lang::get('general.update') }}</button>
                </div> 
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

@stop
@section('title')
<section class="content-header">
    <h1>
        {{ Lang::get('general.options') }}<small>{{ Lang::get('general.options') }}</small>
    </h1>
</section>
@stop
@section('content')

@yield('title')
<section class="content">
@yield('notification')
@yield('settings')
</section>
@stop