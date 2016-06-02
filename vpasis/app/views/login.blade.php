<!DOCTYPE html>
<html>
    <head>
        <title> VPA - Login</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        {{ HTML::style('style/css/bootstrap.min.css') }}
        {{ HTML::style('style/css/AdminLTE.min.css') }}
    </head>
    <body class="hold-transition lockscreen">
        <div class="lockscreen-wrapper">
            <div class="lockscreen-logo">
                <a href="#"><b>SMPS</b> Login</a>
            </div>
            @if($errors->has())
            <div class="callout callout-danger">
                <h4>Gabim!</h4>
                <p>{{ $errors->first('id') }}</p>
                <p>{{ $errors->first('us') }}</p>
                <p>{{ $errors->first('password') }}</p>
            </div>
            @endif
            <div class="lockscreen-item">
                <div class="lockscreen-image">
                    <img src="{{asset("img/login_logo.png")}}" alt="VPA - Login" class="img-responsive">
                </div>
                {{ Form::open(array('url' => action('AuthController@postLogin'),'method'=>'POST','class'=>'lockscreen-credentials')) }}
                <div class="input-group">
                    {{ Form::text('id', Input::old('id'), array('placeholder' => Lang::get('general.id'),'class'=>'form-control input-lg  ')) }}
                    {{ Form::password('passwd',array('placeholder' => Lang::get('general.password'),'class'=>'form-control input-lg ')) }}
                    <div class="input-group-btn ">
                        <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
           
        </div>
        {{ HTML::script('style/js/jquery-1.11.1.min.js') }}
        {{ HTML::script('style/js/bootstrap.min.js') }}
    </body>

</html>