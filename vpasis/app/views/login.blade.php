<!DOCTYPE html>
<html>
    <head>
        <title> VPA - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        
    {{ HTML::style('style/css/bootstrap.min.css') }}
    </head>
    <body>


        <div class="container well well-lg" >
            <br>
            {{ Form::open(array('url' => action('AuthController@postLogin'),'method'=>'POST','class'=>'form-horizontal')) }}
            <fieldset >
                <div class="col-sm-5"></div>
                <div class="col-sm-4">
                    <div class="col-sm-8" ><img src="{{asset("img/login_logo.png")}}" alt="VPA - Login" class="img-responsive"> </img>
                    </div>
                </div> 
                <div class="col-sm-5"></div>

            </fieldset>
            {{ $errors->first('id') }}
            {{ $errors->first('us') }}
            {{ $errors->first('password') }}
            <!-- if there are login errors, show them here -->
            <br>
            <br>



            <div class="form-group ">
                <div class="col-sm-5"></div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">{{ Lang::get('general.id') }}</span>
                        {{ Form::text('id', Input::old('id'), array('placeholder' => Lang::get('general.id'),'class'=>'form-control input-lg  ')) }}
                    </div>
                </div>
            </div>


            <div class="form-group ">
                <div class="col-sm-5"></div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">{{ Lang::get('general.password') }}</span>
                        {{ Form::password('passwd',array('placeholder' => Lang::get('general.password'),'class'=>'form-control input-lg ')) }}
                    </div>  </div>
            </div>
            <div class="form-group " >
                <div class="col-sm-offset-7">
                    {{ Form::submit(Lang::get('general.login') ,array('class'=>'btn  btn-primary  btn-lg ')) }}
                </div>  
            </div>

            {{ Form::close() }}
        </div>     


    {{ HTML::script('style/js/jquery-1.11.1.min.js') }}
    {{ HTML::script('style/js/bootstrap.min.js') }}
    </body>

</html>