<aside class="main-sidebar ">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style='height:auto;'>
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" id='searchPerson' class="form-control" placeholder="@lang('general.search_person')">
                <span class="input-group-btn">
                    <button name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu intelli-person">
            
        </ul>
        <ul class="sidebar-menu">
            
            <li class="treeview @if(Request::is('smps/admin/departments/*')||Request::is('smps/admin/options*')) active @endif"  >
                <a href="#"><i class="fa fa-university" aria-hidden="true"></i>
                    <span>{{ Lang::get('general.settings') }}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class='@if(Request::is('smps/admin/departments/*')) active @endif'><a href="{{ action('DepartmentsController@getIndex') }}">{{ Lang::get('general.departments') }}</a></li>
                    <li class='@if(Request::is('smps/admin/options/*')) active @endif'><a href="{{ action('OptionsController@getIndex') }}">{{ Lang::get('general.options') }}</a></li>
                </ul>
            </li>
            <li class="treeview @if(Request::is('smps/admin/student*')||Request::is('smps/admin/vijushmeria*')) active @endif">
                <a href="#"><i class="fa fa-street-view" aria-hidden="true"></i>
                    <span>{{ Lang::get('general.student') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class='@if(Request::is('smps/admin/student/register*')) active @endif'><a href="{{ action('StudentController@getRegister') }}">{{ Lang::get('general.register_student') }}</a></li>
                    <li class='@if(Request::is('smps/admin/student/list*')) active @endif'><a href="{{ action('StudentController@getList') }}">{{ Lang::get('general.student_list') }}</a></li>
                    <!--<li class='@if(Request::is('smps/admin/vijushmeria/*')) active @endif'><a href="{{ action('VijushmeriaController@getVijushmeria') }}">{{ Lang::get('general.attendance') }}</a></li>-->
                </ul>
            </li>
            <li class="treeview @if(Request::is('smps/admin/provimet/*')) active @endif" >
                <a href="#"><i class="fa fa-clipboard" aria-hidden="true"></i>
                    <span>{{ Lang::get('general.exams') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class='@if(Request::is('smps/admin/provimet/add-rap*')) active @endif'><a href="{{ action('ProvimetController@getAddRaportiNotave') }}">{{ Lang::get('general.add_new_report_grade') }}</a></li>
                    <li class='@if(Request::is('smps/admin/provimet/raport*')) active @endif'><a href="{{ action('ProvimetController@getRaportiNotave') }}">{{ Lang::get('general.report_grade') }}</a></li>
                </ul>
            </li>
            <li class="treeview @if(Request::is('smps/admin/fee*')) active @endif">
                <a href="#">
                    <i class="fa fa-eur" aria-hidden="true"></i>

                    <span>{{ Lang::get('general.fee') }}</span> 
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class='@if(Request::is('smps/admin/fee/index*')) active @endif'><a href="{{ action('FeeController@getIndex') }}">{{ Lang::get('general.fee') }}</a></li>
                </ul>
            </li>
            <li class="treeview @if(Request::is('smps/admin/staff/*')) active @endif">
                <a href="#"><i class="fa fa-users" aria-hidden="true"></i>
                    <span>{{ Lang::get('general.employe') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class='@if(Request::is('smps/admin/staff/register*')) active @endif'><a href="{{ action('StaffController@getRegister') }}">{{ Lang::get('general.add_employe') }}</a></li>
                    <li class='@if(Request::is('smps/admin/staff/display-staff*')) active @endif'><a href="{{ action('StaffController@getDisplayStaff') }}">{{ Lang::get('general.staff_list') }}</a></li>
                    <li class='@if(Request::is('smps/admin/staff/display-academic-staff*')) active @endif'><a href="{{ action('StaffController@getDisplayAcademicStaff') }}">{{ Lang::get('general.academic_list') }}</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>