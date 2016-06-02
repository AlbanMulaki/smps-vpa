

@section('search')
{{ Form::open(array(null,'method'=>'GET','files' =>true, 'class'=>'navbar-form navbar-left','id'=>'form1search','role'=>'search','name'=>'form1search')) }}

<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon" style="width:0;">
            <input type="checkbox" name='admin' value='admin'>
        </span>
        <input id="search" type="text" class="form-control " autocomplete="off" placeholder="{{ Lang::get('general.search_person') }}" name="search">
    </div>
</div>
<div id="listpeople"></div>
{{ Form::close() }}
<script>
    $("#search").keyup(function () {
        var dataString = $('#form1search').serialize();
        $.ajax({
            type: "POST",
            url: "/smps/admin/search",
            data: dataString,
            error: function () {
                alert('Something went go wrong');
            },
            success: function (data) {
                console.log(data);
                $('#listpeople').empty().append(data);

            }},
            "json");
    });
</script>
@stop
@section('header')
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    {{ HTML::style('/style/css/bootstrap.min.css') }}
    {{ HTML::style('style/css/timeline.css') }}
    {{ HTML::style('style/css/AdminLTE.min.css') }}
    {{ HTML::style('style/css/skins/skin-blue.min.css') }}
    {{ HTML::style('style/fonts/awesome/css/font-awesome.min.css') }}
    {{ HTML::style('style/css/bootstrapValidator.min.css') }}
    {{ HTML::style('style/css/style.css') }}
    {{ HTML::style('style/css/jasny-bootstrap.min.css') }}
    {{ HTML::style('style/css/jquery-ui-1.10.0.custom.css') }}
    {{ HTML::style('style/css/icheck/skins/square/blue.css') }}
    {{ HTML::style('style/css/bootstrap-datetimepicker.min.css') }}
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    @stop
    
@section('navbar')
<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="{{ action('AdminController@getIndex') }}" class="logo"><b>SMPS </b> - {{ $university_name }}</a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ asset('smpsfl/doc/avatar/'.$user['avatar']) }}" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ $user->emri." ".$user->mbiemri }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ asset('smpsfl/doc/avatar/'.$user['avatar']) }}" class="img-circle" alt="User Image" />
                            <p>
                                {{ $user->emri." ".$user->mbiemri }} - {{ Enum::convertaccess($user->grp) }}
                                <small>Regjistruar me {{ $user->created_at}}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ action('StaffController@getProfile',[$user->uid]) }}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ action('AuthController@getLogout') }}" class="btn btn-default btn-flat">Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>


@stop




@section('container')
<body  class="hold-transition skin-blue sidebar-mini">    

    <div id="wrapper">
        @yield('navbar')
        @include('admin.sidebar')
        <div class="content-wrapper">
            @yield('content')
        </div>

        

    </div>
    <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.0.3
            </div>
            <strong>Copyright © 2014-2016 <a href="http://trebla-ks.net">Trebla KS LLC</a>.</strong> All rights
            reserved. Alban Mulaki & Albert Mulaki
        </footer>

    {{ HTML::script('style/js/jquery-1.11.1.min.js') }}
    {{ HTML::script('style/js/raphael-min.js') }}
    {{ HTML::script('style/js/morris.min.js') }}
    {{ HTML::script('style/js/moment.min.js') }}
    {{ HTML::script('style/js/bootstrap.min.js') }}
    {{ HTML::script('style/js/icheck.min.js') }}
    {{ HTML::script('style/js/bootstrap-datepicker.min.js') }}
    {{ HTML::script('style/js/chart.min.js') }}
    {{ HTML::script('style/js/pace.min.js') }}
    {{ HTML::script('style/js/jasny-bootstrap.min.js') }}
    {{ HTML::script('style/js/app.min.js') }}
    {{ HTML::script('style/js/adminapp.js') }}
    <script>
        //Set datepicker class

        $('.datetimepicker').datetimepicker({
            defaultDate: "2016-12-01 05:40:05 +0000",
            format: 'YYYY-MM-DD HH:mm:ss ZZ',
        });
        $('.datepicker').datetimepicker({
            defaultDate: "2016-12-01",
            format: 'YYYY-MM-DD',
        });
        $(document).ready(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue'
            });
        });
    </script>
</body>
@stop





<!DOCTYPE html>
<html>
@yield('header')
@yield('hidden')
@yield('container')
@yield('scripts')
</html>






