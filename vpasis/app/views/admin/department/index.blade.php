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
@section('addDepartment')
{{ Form::open(array('url'=>action('DepartmentsController@postRegisterDepartment'),'method'=>'POST')) }}
<div class="box box-success">
    
    
    

        <!-- Modal -->
        <div class="modal fade" id="addDempartment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.register_department') }}</h4>
                    </div>         
                    <div class="modal-body">
                        <div class="input-group input-group">
                            <span class="input-group-addon" id="sizing-addon1">{{ Lang::get('general.name') }}</span>
                            {{ Form::text('departmenti',null,array('class'=>'form-control')) }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('general.close') }}</button>
                        <button type="submit" name="submit" class="btn btn-primary">{{ Lang::get('general.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
       
{{ Form::close() }}
@stop 


@section('addCourse')

@stop 


@section('listLendet')


@stop

@section('listDepartments') 
<!-- Small button group -->
{{ Form::open(array('url'=>'','method'=>'POST','class'=>'form-inline col-lg-5')) }}
<div class="box box-success">
    
    <div class="box-body">

        <div class="form-group">
            <div class="input-group"> 
                <span class="input-group-addon" id="basic-addon1">{{ Lang::get('general.departments') }}</span>
                <select class="form-control" id='comboDepartmentet'>
                    <option >{{ Lang::get('general.choose_departments') }}</option>
                    @foreach($departmentet as $value )
                    @if(isset($selectedDepId) && $selectedDepId == $value['idDepartmentet'])
                    <option value='{{ $value['idDepartmentet'] }}' selected>{{ $value['Emri'] }}</option>
                    @else 
                    <option value='{{ $value['idDepartmentet'] }}'>{{ $value['Emri'] }}</option>
                    @endif
                    @endforeach
                    <option value="-1" class="alert-success"  data-toggle="modal" data-target="#addDempartment">{{ Lang::get('general.add_new_department') }}</option>
                </select>
                <!-- Button trigger modal -->

            </div>
        </div>
    </div>
</div>        
{{  Form::close() }}


@yield("addDepartment")

@if(isset($selectedDep))
{{ Form::open(array('url'=>action('DepartmentsController@postCreatedrejtimet'),'method'=>'POST')) }}
<input type="hidden" name="idd" value="{{ $selectedDepId }}">
<!-- Modal -->
<div class="modal fade" id="addDrejtim{{ $selectedDepId }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.register_profile') }}</h4>
            </div>         
            <div class="modal-body">
                <div class="input-group input-group">
                    <span class="input-group-addon" id="sizing-addon1">{{ Lang::get('general.profile_name') }}</span>
                    {{ Form::text('Emri',null,array('class'=>'form-control')) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('general.close') }}</button>
                <button type="submit" name="submit" class="btn btn-primary">{{ Lang::get('general.save') }}</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addDrejtim{{ $selectedDepId }}">
    <span class='fa fa-plus fa-lg' ></span>  {{ Lang::get('general.add_profile') }}
</button>
<br><br><br>


<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    @foreach($drejtimet as $value )
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <div class="row">
                    <div class="col-lg-8">
                        <a class="collapsed text-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#listdrejtimet{{ $value['idDrejtimet']}}" aria-expanded="false" aria-controls="collapseTwo">
                            {{ $value['Emri'] }}
                        </a>
                    </div>
                    <div class="col-lg-4">
                        
                        <a href="{{ action('DepartmentsController@getPrintLendet')."/".$value['idDrejtimet'] }}"type="button" class="btn btn-sm btn-danger">
                            <span class='fa fa-file-pdf-o fa-lg' ></span> 
                        </a>
                        <a href="{{ action('DepartmentsController@getPrintLendetDirect')."/".$value['idDrejtimet']}}" id="printPlanProgrammin" class="btn btn-sm btn-default">
                            <span class='fa fa-print fa-lg' ></span>  
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addCourse{{ $value['idDrejtimet'] }}">
                            <span class='fa fa-plus fa-lg' ></span>  {{ Lang::get('general.add_course') }}
                        </button>
                    </div>
                    {{ Form::open(array('url'=>action('DepartmentsController@postCreatelendet'),'method'=>'POST','class'=>'form-horizontal')) }}

                    <!-- Modal -->
                    <div class="modal fade" id="addCourse{{ $value['idDrejtimet'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.add_course') }}</h4>
                                </div>         
                                <div class="modal-body">

                                    <input name="Drejtimi" value="{{ $value['idDrejtimet'] }}" type="hidden">
                                    <input name="idp" value="{{ $value['idd'] }}" type="hidden">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">{{ Lang::get('general.course_name') }}</label>
                                        <div class="col-lg-10">
                                            <input class="form-control" name="Emri" placeholder="{{ Lang::get('reminders.course_name') }}" type="text">
                                        </div>
                                    </div>                           
                                    <div class="form-group">
                                        <label for="select" class="col-lg-2 control-label">{{ Lang::get('general.profile') }}</label>
                                        <div class="col-lg-10">
                                            <select class="form-control" disabled="">
                                                <option value="17">{{ $value['Emri'] }}</option>
                                            </select>
                                        </div>
                                    </div>                     
                                    <div class="form-group">
                                        <label for="select" class="col-lg-2 control-label">Semestri</label>
                                        <div class="col-lg-10">
                                            <select class="form-control" name="Semestri">
                                                <option value="1" selected="selected">1 </option>
                                                <option value="2">2 </option>
                                                <option value="3">3 </option>
                                                <option value="4">4 </option>
                                                <option value="5">5 </option>
                                                <option value="6">6 </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label"></label>
                                        <div class="col-lg-10">
                                            <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-primary

                                                       active 
                                                       ">
                                                    <input name="zgjedhore" autocomplete="off" value="0" checked="checked" type="radio"> {{ Lang::get('general.mandatory') }}
                                                </label>
                                                <label class="btn btn-primary 
                                                       ">
                                                    <input name="zgjedhore" autocomplete="off" value="1" type="radio"> {{ Lang::get('general.zgjedhore') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">ECT</label>
                                        <div class="col-lg-10">
                                            <input class="form-control" placeholder="Ect number" name="ect" value="6" type="text">

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('general.close') }}</button>
                                    <button type="submit" name="submit" class="btn btn-primary">{{ Lang::get('general.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </h4>
        </div>
        <div id="listdrejtimet{{ $value['idDrejtimet']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                <div class="table-responsive">

                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>{{ Lang::get('general.course') }}</th>
                            <th>{{ Lang::get('general.zgjedhore') }}</th>
                            <th>{{ Lang::get('general.ect') }}</th>
                            <th>{{ Lang::get('general.options') }}</th>
                        </tr>

                        {{ "";$ect=0;$crs=0;$z=0;$o=0 }} <!-- Start val for calculaction -->
                        @foreach($lendet as $lendetVal)

                        @if($lendetVal['Drejtimi'] == $value['idDrejtimet'])

                        @if($lendetVal['Zgjedhore'] == Enum::zgjedhore)
                        {{ "";$z++ }}
                        @else
                        {{ "";$o++ }}
                        @endif

                        {{ "";$ect = $ect+ (int)$lendetVal['Ect'];$crs++ }}
                        @if($lendetVal['Semestri'] != $semestriCount)

                        <tr class='info'>
                            <td colspan="6" class='text-center'><strong>{{ Lang::get('general.semester')." - ".$lendetVal['Semestri'] }}</strong></td>
                        </tr>
                        {{ "";$semestriCount = $lendetVal['Semestri'];$countcourse=0 }}
                        @endif
                        {{ "";$countcourse++ }}
                        <tr>
                            <td>{{ $countcourse }}</td>
                            <td>{{ $lendetVal['Emri'] }}</td>
                            <td>@if($lendetVal['Zgjedhore'] == Enum::zgjedhore) Z @else O @endif</td>
                            <td>{{ $lendetVal['Ect'] }}</td>
                            <td> <!-- Split button -->
                                <div class="btn-group">
                                    <button type="button"  data-toggle="modal" data-target="#editLendet{{$lendetVal['idl']}}" class="btn btn-sm btn-primary">{{ Lang::get('general.edit') }}</button>
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" data-toggle="modal" data-target="#deleteCourse{{$lendetVal['idl']}}"><span class='fa fa-trash-o fa-lg'> </span> {{ Lang::get('general.delete')}}</a></li>
                                    </ul>
                                </div>
                                <!-- Modal Delete Course -->
                                <div class="modal fade" id="deleteCourse{{ $lendetVal['idl'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content ">
                                            <div class="modal-header alert-danger">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.are_you_sure') }}</h4>
                                            </div>         
                                            <div class="modal-body alert-danger">
                                                <p>
                                                    {{ Lang::get('warn.warning_course_delete',array('course'=>$lendetVal['Emri']))}}
                                                </p>
                                            </div>
                                            <div class="modal-footer alert-danger">
                                                <button type="button" class="btn btn-success" data-dismiss="modal">{{ Lang::get('general.close') }}</button>
                                                <a href="{{action('DepartmentsController@getDeletelendet').'/'.$lendetVal['idl']}}" type="submit" name="submit" class="btn btn-danger">{{ Lang::get('general.delete') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="editLendet{{$lendetVal['idl']}}" tabindex="-1" role="dialog" aria-labelledby="editLendet{{$lendetVal['idl']}}">
                                    <div class="modal-dialog" role="document">
                                        {{ Form::open(array('url'=>action('DepartmentsController@postEditlendet'),'method'=>'POST','class'=>'form-horizontal')) }}

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">{{ $lendetVal['Emri']}}</h4>
                                            </div>
                                            <div class="modal-body">

                                                <input name='idl' value="{{ $lendetVal['idl'] }}" type="hidden">
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">{{ Lang::get('general.course') }}</label>
                                                    <div class="col-lg-10">
                                                        <input class="form-control" name="Emri" placeholder="{{ Lang::get('reminders.course_name') }}" type="text" value="{{ $lendetVal['Emri']}}">
                                                    </div>
                                                </div>                           
                                                <div class="form-group">
                                                    <label for="select" class="col-lg-2 control-label">{{ Lang::get('general.profile')}}</label>
                                                    <div class="col-lg-10">
                                                        <select class="form-control" name="Drejtimi">
                                                            @foreach($drejtimet as $vald)
                                                            <option value="{{ $vald['idDrejtimet'] }}">{{ $vald['Emri'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>                     
                                                <div class="form-group">
                                                    <label for="select" class="col-lg-2 control-label">{{ Lang::get('general.semester')}}</label>
                                                    <div class="col-lg-10">
                                                        <select class="form-control" name="Semestri">
                                                            @for($i=1;$i<=6;$i++)
                                                            <option value="{{ $i }}" @if($lendetVal['Semestri'] == $i)
                                                                    selected="selected"
                                                                    @endif >{{ $i }} </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label"></label>
                                                    <div class="col-lg-10">
                                                        <div class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-primary
                                                                   @if($lendetVal['Zgjedhore'] == Enum::jozgjedhore) 
                                                                   active 
                                                                   @endif">
                                                                <input type="radio" name="zgjedhore" autocomplete="off" value='{{ Enum::jozgjedhore }}' @if($lendetVal['Zgjedhore'] == Enum::jozgjedhore) 
                                                                       checked="checked" 
                                                                       @endif> {{ Lang::get('general.mandatory') }}
                                                            </label>
                                                            <label class="btn btn-primary 
                                                                   @if($lendetVal['Zgjedhore'] == Enum::zgjedhore)
                                                                   active
                                                                   @endif">
                                                                <input type="radio" name="zgjedhore" autocomplete="off" value='{{ Enum::zgjedhore }}'  @if($lendetVal['Zgjedhore'] == Enum::zgjedhore)
                                                                       checked="checked" 
                                                                       @endif> {{ Lang::get('general.zgjedhore') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">{{ Lang::get('general.ect')}}</label>
                                                    <div class="col-lg-10">
                                                        <input class="form-control"  placeholder="{{ Lang::get('reminders.ect_number') }}" type="text" name="ect" value="{{ $lendetVal['Ect'] }}">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('general.close') }}</button>
                                                <button type="submit" class="btn btn-primary" >{{ Lang::get('general.update')}}</button>
                                            </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach

                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <table class="table table-responsive">
                    <tr>
                        <td width="50%"><span class="label label-info"> {{ Lang::get('general.course_num') }} = {{ $crs }}</span></td>

                        <td><span class="label label-primary"> O = {{ $o }}</span><br><br>
                            <span class="label label-info"> Z = {{ $z }}</span></td>
                        <td><span class="label label-info"> {{ Lang::get('general.all_ect') }} = {{ $ect }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>


@endif
@stop

@section('title')
<section class="content-header">
    <h1>
        {{ Lang::get('general.departments') }}<small>{{ Lang::get('general.departments') }}</small>
    </h1>
</section>
@stop

@section('content') 
@yield('title')

<section class="content">
@yield('notification')
@yield('listDepartments')
</section>
@stop


@section('scripts')
<script type='text/javascript'>
    $('#comboDepartmentet').change(function () {
        var department = $("#comboDepartmentet").val();
        if (department >= 1) {
            window.location.href = "{{ action('DepartmentsController@getDep') }}/" + department;
        }
    });
</script>

@stop