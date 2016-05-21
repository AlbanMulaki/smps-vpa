

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




@section('sidebar')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">


        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#"><span>{{ Lang::get('general.settings') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ action('DepartmentsController@getIndex') }}">{{ Lang::get('general.departments') }}</a></li>
                    <li><a href="{{ action('OptionsController@getIndex') }}">{{ Lang::get('general.options') }}</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><span>{{ Lang::get('general.student') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ action('StudentController@getRegister') }}">{{ Lang::get('general.register_student') }}</a></li>
                    <li><a href="{{ action('StudentController@getList') }}">{{ Lang::get('general.student_list') }}</a></li>
                    <li><a href="{{ action('VijushmeriaController@getVijushmeria') }}">{{ Lang::get('general.attendance') }}</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><span>{{ Lang::get('general.exams') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ action('ProvimetController@getAddRaportiNotave') }}">{{ Lang::get('general.add_new_report_grade') }}</a></li>
                    <li><a href="{{ action('ProvimetController@getRaportiNotave') }}">{{ Lang::get('general.report_grade') }}</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><span>{{ Lang::get('general.fee') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ action('FeeController@getIndex') }}">{{ Lang::get('general.fee') }}</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><span>{{ Lang::get('general.employe') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ action('StaffController@getRegister') }}">{{ Lang::get('general.add_employe') }}</a></li>
                    <li><a href="{{ action('StaffController@getDisplayStaff') }}">{{ Lang::get('general.staff_list') }}</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

<!--
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
                 /.nav-second-level 
            </li>

            <li>
                <a href="#" class='text-danger'><i class="fa fa-user fa-lg"></i> {{ Lang::get('general.account') }} <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#">Sub menu 1</a>
                    </li>
                </ul>
                 /.nav-second-level 
            </li>
            <li>
                <a href="#" class='text-danger'><i class="fa fa-envelope-o fa-lg"></i> {{ Lang::get('general.about') }} <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#">Sub menu 1</a>
                    </li>
                </ul>
                 /.nav-second-level 
            </li>

        </ul>
    </div>
     /.sidebar-collapse 
    <div class="well text-center">
        {{ Lang::get('footer.author') }} <br>
        {{ link_to('http://www.vpa-uni.com', Lang::get('footer.copyright'), $attributes = array(), $secure = null); }}<br>
        {{ link_to('http://www.objprog.com', Lang::get('footer.copyright1'), $attributes = array(), $secure = null); }}<br>
        {{ link_to('http://www.trebla-ks.com', Lang::get('footer.copyright2'), $attributes = array(), $secure = null); }}
    </div>
</div>-->

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
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the messages -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <!-- User Image -->
                                            <img src="{{ asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image"/>
                                        </div>
                                        <!-- Message title and timestamp -->
                                        <h4>                            
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <!-- The message -->
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li><!-- end message -->                      
                            </ul><!-- /.menu -->
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li><!-- /.messages-menu -->

                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu">
                                <li><!-- start notification -->
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li><!-- end notification -->                      
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks Menu -->
                <li class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- Inner menu: contains the tasks -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <!-- Task title and progress text -->
                                        <h3>
                                            Design some buttons
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <!-- The progress bar -->
                                        <div class="progress xs">
                                            <!-- Change the css width attribute to simulate progress -->
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->                      
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ asset('smpsfl/doc/avatar/'.$user['avatar']) }}" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">Alexander Pierce</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ asset('smpsfl/doc/avatar/'.$user['avatar']) }}" class="img-circle" alt="User Image" />
                            <p>
                                Alexander Pierce - Web Developer
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
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

        @yield('sidebar')
        <div class="content-wrapper">
            @yield('content')
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.0.1
            </div>
            <strong>Copyright © 2014-2016 <a href="http://trebla-ks.net">Trebla KS LLC</a>.</strong> All rights
            reserved. Alban Mulaki
        </footer>

    </div>

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






