

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
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ HTML::style('style/css/bootstrap.min.css') }}
    {{ HTML::style('style/css/timeline.css') }}
    {{ HTML::style('style/css/sb-admin-2.css') }}
    {{ HTML::style('style/fonts/awesome/css/font-awesome.min.css') }}
    {{ HTML::style('style/css/bootstrapValidator.min.css') }}
    {{ HTML::style('style/awesome/font-awesome.min.css') }}
    {{ HTML::style('style/css/style.css') }}
    {{ HTML::style('style/css/metisMenu.min.css') }}
    {{ HTML::style('style/css/jasny-bootstrap.min.css') }}
    {{ HTML::style('style/css/jquery-ui.min.css') }}

    {{ HTML::script('style/js/jquery-1.11.1.min.js') }}
    {{ HTML::script('style/js/jquery.cycle.all.js') }}
    {{ HTML::script('style/js/bootstrap.min.js') }}
    {{ HTML::script('style/js/sb-admin-2.js') }}
    {{ HTML::script('style/js/metisMenu.min.js') }}
    {{ HTML::script('style/js/morris-data.js') }}
    {{ HTML::script('style/js/flot-data.js') }}
    {{ HTML::script('style/js/holder.js') }}
    {{ HTML::script('style/js/jasny-bootstrap.min.js') }}
</head>
@stop




@section('sidebar')
 
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li>
            <li class="{{Request::path() == 'smps/admin/options'
                        || Request::path() == 'smps/admin/hsub'
                        || Request::path() == 'smps/admin/exams'
                        || Request::path() == 'smps/admin/departments'
                        ? 'active' : ''; }}">
                <a href="#" ><i class="fa fa-bar-chart-o fa-fw"></i> {{ Lang::get('general.settings') }} <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ action('DepartmentsController@getIndex') }}"> {{ Lang::get('general.departments') }} </a>
                    </li>
                    <li>
                        <a href="{{ action('OptionsController@getIndex') }}">{{ Lang::get('general.options') }}</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li class="{{Request::path() == 'smps/admin/student'
                        || Request::path() == 'smps/admin/vijushmeria'
                        ? 'active' : ''; }}">
                <a href="#" class='text-warning'><i class="fa fa-graduation-cap fa-lg"></i> {{ Lang::get('general.student') }} <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ action('StudentController@getRegister') }}"></span>{{ Lang::get('general.register_student') }}</a>
                    </li>
                    <li>
                        <a href="{{ action('StudentController@getList') }}">{{ Lang::get('general.student_list') }}</a>
                    </li>
                    <li>
                        <a href="{{ action('VijushmeriaController@getVijushmeria') }}">{{ Lang::get('general.attendance') }}</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#" class='text-danger'><i class="fa fa-file-text-o fa-lg"></i> {{ Lang::get('general.exams') }} <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ action('ProvimetController@getRaportiNotave') }}">{{ Lang::get('general.report_grade') }}</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-eur fa-lg"></i> {{ Lang::get('general.fee') }} <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ action('FeeController@getIndex') }}">{{ Lang::get('general.fee') }}</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#" class='text-danger'><i class="fa fa-book fa-lg "></i> {{ Lang::get('general.library') }} <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">

                    <li>
                        <a href="#"><span class="label label-sm label-danger"> </span>{{ Lang::get('general.general_details') }}</a>
                    </li>
                    <li>
                        <a href="#"><span class="label label-sm label-danger"> </span>{{ Lang::get('general.issue_return') }}</a>
                    </li>
                    <li>
                        <a href="#"><span class="label label-sm label-danger"> </span>{{ Lang::get('general.lost') }}</a>
                    </li>
                    <li>
                        <a href="#"><span class="label label-sm label-danger"> </span>{{ Lang::get('general.sold') }}</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li>
                <a href="#" class='text-danger'><i class="fa fa-user fa-lg"></i> {{ Lang::get('general.account') }} <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#">Sub menu 1</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li>
                <a href="#"><i class="fa fa-group fa-lg"></i> {{ Lang::get('general.employe') }} <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ action('StaffController@getRegister') }}">{{ Lang::get('general.add_employe') }}</a>
                    </li>
                    <li>
                        <a href="{{ action('StaffController@getDisplayStaff') }}">{{ Lang::get('general.staff_list') }}</a>
                    </li>
                    <li>
                        <a href="#"><span class="label label-sm label-danger"> </span> {{ Lang::get('general.financial_details') }}</a>
                    </li>
                    <li>
                        <a href="#"><span class="label label-sm label-danger"> </span>{{ Lang::get('general.staff_slaray') }}</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#" class='text-danger'><i class="fa fa-envelope-o fa-lg"></i> {{ Lang::get('general.about') }} <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#">Sub menu 1</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
    <div class="well text-center">
        {{ Lang::get('footer.author') }} <br>
        {{ link_to('http://www.vpa-uni.com', Lang::get('footer.copyright'), $attributes = array(), $secure = null); }}<br>
        {{ link_to('http://www.objprog.com', Lang::get('footer.copyright1'), $attributes = array(), $secure = null); }}<br>
        {{ link_to('http://www.trebla-ks.com', Lang::get('footer.copyright2'), $attributes = array(), $secure = null); }}
    </div>
</div>

@stop

@section('navbar')

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ action('AdminController@getIndex') }}">SMPS - {{ $university_name }}</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li>
            <img src='/smpsfl/doc/avatar/{{$user['avatar'] }}' class='img- img-rounded' width="50"></img>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">  <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{ action('AuthController@getLogout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>

        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    @yield('sidebar')
    <!-- /.navbar-static-side -->
</nav>


@stop




@section('container')
<body>    

    <div id="wrapper">
        @yield('navbar')

        <div id="page-wrapper">
            @yield('content')
        </div>
        <!-- /#page-wrapper -->

    </div>

</body>
@stop





<!DOCTYPE html>
<html>
    @yield('header')
    @yield('hidden')
    @yield('container')
</html>






