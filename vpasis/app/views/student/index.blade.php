@section('search')
{{ Form::open(array(null,'method'=>'GET','files' =>true, 'class'=>'navbar-form navbar-left','id'=>'form1search','role'=>'search','name'=>'form1search')) }}

<div class="input-group">
    <span class="input-group-addon">
        <input type="checkbox" name='admin' value='admin'>
    </span>
    <input id="search" type="text" class="form-control " autocomplete="off" placeholder="{{ Lang::get('general.search_person') }}" name="search">
</div>
<div id="listpeople"></div>
{{ Form::close() }}
@stop
@section('header')
<head>
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ HTML::style('style/css/bootstrap.min.css') }}
    {{ HTML::style('style/fonts/awesome/css/font-awesome.min.css') }}
    {{ HTML::style('style/css/bootstrapValidator.min.css') }}
    {{ HTML::style('style/awesome/font-awesome.min.css') }}
    {{ HTML::style('style/css/style.css') }}
    {{ HTML::script('style/js/jquery-1.11.1.min.js') }}
    {{ HTML::script('style/js/bootstrap.min.js') }}
    {{ HTML::script('style/js/bootstrapValidator.min.js') }}
    {{ HTML::script('style/js/jquery.cycle.all.js') }}
    {{ HTML::script('style/js/holder.js') }}
    <style>

        .pics {  
            height:  232px;  
            width:   232px;  
            padding: 0;  
            margin:  0;  
        } 

        .pics img {  
            padding: 15px;  
            border:  1px solid #ccc;  
            background-color: #eee;  
            width:  200px; 
            height: 200px; 
            top:  0; 
            left: 0 
        } 
    </style>

    <script>
        $("#search").keyup(function() {
            var dataString = $('#form1search').serialize();
            $.ajax({
                type: "POST",
                url: "{{ action('StudentController@postSearch') }}",
                data: dataString,
                error: function() {
                    alert('Something went go wrong');
                },
                success: function(data) {
                    console.log(data);
                    $('#listpeople').empty().append(data);

                }},
            "json");
        });
    </script>
</head>
@stop

@section('footer')

<footer class="col-sm-12" id="footer">{{ Lang::get('footer.author') }} 

    {{ link_to('http://www.vpa-uni.com', Lang::get('footer.copyright'), $attributes = array(), $secure = null); }}
    {{ link_to('http://www.objprog.com', Lang::get('footer.copyright1'), $attributes = array(), $secure = null); }}
</footer>
@stop

@section('nav')
<nav class="navbar navbar-inverse " role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header ">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Nav</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ action('StudentController@getIndex')}}">VPA ( <span class="badge btn-info btn">BETA </span>)</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">



            <ul class="nav navbar-nav navbar-right"> 
                <li><a href='{{ action('StudentController@getNotat') }}' > {{ Lang::get('general.grade') }} </a></li>
                
                <li><a href='{{ action('StudentController@getLigjeratat') }}' > {{ Lang::get('general.ligjeratat') }} </a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Lang::get('profile.user_cp',array('num'=> $news['total'])) }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <!-- <li><a href="#">{{ Lang::get('profile.view_myprofile') }} </a></li> -->
                        <li><a href='{{ action('StudentController@getInbox')}}' > {{ Lang::get('profile.inbox',array('num'=>$news['inbox'])) }} </a></li>
                        <li><a href="#" data-toggle="modal" data-target="#rstpass">{{ Lang::get('profile.change_password') }} </a></li>
                        <li class="divider"></li>
                        <li>{{ link_to(action('AuthController@getLogout'), Lang::get('profile.logout'), $attributes = array(), $secure = null); }}</li>
                    </ul>
                </li>
            </ul>
            {{ Form::open(array(null,'method'=>'POST','id'=>'resetpass','role'=>'form','name'=>'resetpass')) }}

            <div class="modal fade" id="rstpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.reset_pass') }}</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">{{ Lang::get('general.old_password') }}</div>
                                    <input id='oldp' class="form-control"  type="password"  name="oldp">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">{{ Lang::get('general.new_password') }}</div>
                                    <input id='oldp' class="form-control"  type="password"  name="newp">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">{{ Lang::get('general.confirm_password') }}</div>
                                    <input id='oldp' class="form-control"  type="password"  name="confnewp">
                                </div>
                            </div>
                            <div id="successreset"></div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="subresetpass">{{ Lang::get('general.reset_pass') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            {{ Form::close() }}
        </div>
    </div>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->

</div>
</nav>
<script>
    $('#subresetpass').click(function() {
        var dataString = $('#resetpass').serialize();

        $.ajax({
            type: "POST",
            url: "{{ action('AjaxController@postResetpass')}}",
            data: dataString,
            error: function() {
                alert('Something went go wrong');
            },
            success: function(data) {
                console.log(data);
                $('#successreset').empty().append(data);

            }},
        "json");


    });
</script>


@stop


@section('container')
<body>    

    @yield('nav')
    @yield('content')
    @yield('footer')

</body>
@stop





<!DOCTYPE html>
<html>
    @yield('header')

    @yield('container')
</html>






