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



@section('listStaff')
<div class="box box-success">
    
   
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading form-inline">{{ Lang::get('general.student_list') }} 

                <div class="form-group ">
                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                    <div class="input-group ">
                        <div class="input-group-addon input-sm">{{ Lang::get('general.subject') }}</div>
                        {{ Form::select('drejtimi', $listDrejtimet,end($listDrejtimet),array('id'=>'drejtimi', 'class'=>'form-control input-sm')) }}
                    </div>
                    <script>
                        $('#drejtimi').change(function () {

                            var drejtimi = $("#drejtimi").val();
                            if (drejtimi >= 1) {

                                window.location.href = "{{ action('StudentController@getList') }}/0/" + drejtimi;

                            }
                        });
                    </script>
                </div>
            </div>
            <!-- Table -->
            <table class="table table-responsive table-hover">
                <tr>
                    <th>#</th>
                    <th>{{ Lang::get('general.name')}} {{ Lang::get('general.surname')}}</th>
                    <th>{{ Lang::get('general.email') }}</th>
                    <th>{{ Lang::get('general.phone')}}</th>
                    <th>{{ Lang::get('general.gender') }}</th>
                    <th>{{ Lang::get('general.registred_date') }}</th>
                    <th> 
                        
                        <a href="{{ action('StudentController@getListPrintPdf',array($rows,$drejtimi)) }}" type="button" class="btn btn-sm btn-danger">
                            <span class="fa fa-file-pdf-o fa-lg"></span> 
                        </a>
                        <a href="{{ action('StudentController@getListPrintPdfDirect',array($rows,$drejtimi)) }}" id="printPlanProgrammin" class="btn btn-sm btn-default">
                            <span class="fa fa-print fa-lg"></span>  
                        </a></th>
                </tr>
                @foreach($students as $value)
                <tr>
                    <td>{{ $value['uid'] }}</td>
                    <td class='text-info '> {{ $value['emri']." ".$value['mbiemri'] }}</td>
                    <td>{{ $value['email'] }}</td>
                    <td>{{ $value['telefoni']}}</td>
                    <td><b>{{ substr(Enum::convertgjinia($value['gjinia']),0,1) }}</b></td>
                    <td>{{ substr($value['created_at'],0,10) }}</td>
                    <td>
                        <!-- Split button -->
                        <div class="btn-group">
                            <a  href='{{ action('StudentController@getProfile',array($value['uid']))}}' class="btn btn-sm btn-primary">{{ Lang::get('general.view_profile') }}</a>
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href='{{ action('StudentController@postEdit',array($value['uid']))}}'> {{ Lang::get('general.change') }} </a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href='{{ action('StudentController@getDelete',array($value['uid']))}}'><span class="fa fa-trash-o fa-lg" ></span> {{ Lang::get('general.delete') }}</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="7">

                        {{ $students->links(); }}
                    </td>
                </tr>
            </table>
        </div>

    
</div>        
@stop

        
@section('title')
<section class="content-header">
    <h1>
        {{ Lang::get('general.student_list') }}<small>{{ Lang::get('general.student_list') }}</small>
    </h1>
</section>
@stop

@section('content')
@yield('title')
<section class="content">
@yield('notification')
@yield('listStaff')
</section>
@stop