@extends('admin.index')

@section('notification')
@if($errors->incorrectNewPassword->any())
<div class="callout callout-danger">
    <ul>
        @foreach($errors->incorrectNewPassword->getMessages() as $incorrectNewPassword)
        <li>{{ $incorrectNewPassword[0] }}</li>
        @endforeach
    </ul>
</div>
@endif
@if($errors->validator->any())
<div class="callout callout-danger">
    <h4>Gabim!</h4>
    <ul>
        @foreach($errors->validator->getMessages() as $errorValid)
        <li>{{ $errorValid[0] }}</li>
        @endforeach
    </ul>
</div>
@endif
@stop
@section('title')
<section class="content-header">
    <h1>
        {{ Lang::get('general.change_password') }}<small>{{ Lang::get('general.change_password') }}</small>
    </h1>
</section>
@stop

@section('content')
@yield('title')
<section class="content">
    @yield('notification')
    <div class='col-md-offset-4 col-md-4'>
        <div class='box box-solid'>
            <div class='box-body'>

                {{ Form::open(array('url'=>action('AuthController@postChangePassword'),'method'=>'POST','files'=>true)) }}
                <div class="form-group has-feedback old-password">
                    <input type="password" class="form-control old" autocomplete="off" name='currentPassword' placeholder="Shkruaj fjalkalimin e vjeter">
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control new" autocomplete="off" name='newPassword'  placeholder="Fjalkalimi i ri">
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control new" autocomplete="off" name='confirmPassword'  placeholder="Perseritni fjalkalimin e ri">
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-flat">@lang('general.update')</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</section>
@stop

@section('scripts')
$(document).on('click', '.new', function (element) {
var currentPassword = $('.old').val();
$.ajax({
method: "POST",
url: "{{ action('AuthController@postValidateSelfPassword') }}",
data: {"currentPassword": currentPassword, "_token": "{{ csrf_token() }}"}
}).success(function (msg) {
if(msg[0] == "failed"){
$('.old-password').removeClass('has-success').addClass('has-error');
}else {
$('.old-password').removeClass('has-error').addClass('has-success');
}
});
});

@stop