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


@section('registerVijushmeria')
{{ Form::open(array('url'=>action('VijushmeriaController@postRegisterVijushmeria'),'method'=>'POST','files'=>true,'class'=>"form-horizontal")) }}

<div class='row'>

    <div class='col-lg-3'>
        <div class="form-group">
            <div class="input-group col-lg-10">
                <span class="input-group-addon">{{ Lang::get('general.subject') }}</span>
                {{ Form::select('drejtimi', $drejtimet,$selDrejtimi,array('class'=>'form-control','id'=>"drejtimi")) }}
            </div>
        </div>
    </div>
    <div class='col-lg-3'>
        @if($selDrejtimi > 0)
        <div class="form-group">
            <div class="input-group col-lg-10">
                <span class="input-group-addon">{{ Lang::get('general.course') }}</span>
                {{ Form::select('idl', $lendet,current($lendet),array('class'=>'form-control','id'=>"drejtimi")) }}
            </div>
        </div>
        @else 
        <div class="form-group">
            <div class="input-group col-lg-10">
                <span class="input-group-addon">{{ Lang::get('general.course') }}</span>
                {{ Form::select('idl', $lendet,current($lendet),array('class'=>'form-control','id'=>"drejtimi","disabled"=>"disabled")) }}
            </div>
        </div>

        @endif
    </div>

    <div class='col-lg-2'>
        <div class="form-group">
            <div class="input-group col-lg-10">
                <span class="input-group-addon">{{ Lang::get('general.semester') }}</span>
                {{ Form::select('semestri', Enum::getSemester(),$semestri,array('class'=>'form-control','id'=>"semester")) }}
            </div>
        </div>
    </div>

    <div class='col-lg-1'>
        <div class="form-group">
            <div class="input-group col-lg-11">
                <input class="form-control " id="ora"  placeholder="HH:MM" data-mask="" type="text" name="ora">
            </div>
            <script>
                $('#ora').inputmask({
                mask: '99:99'
                })
            </script>
        </div>
    </div>
    <div class='col-lg-3'>
        <div class="form-group col-lg-12">
            <div class="input-group"> 
                <input class="form-control " id="date"  placeholder="VVVV/MM/DD" data-mask="" type="text" name="data">

            </div>
            <script>
                        $('#date').inputmask({
                mask: '9999-99-99'
                })
            </script>
        </div>
    </div>
        @if($selDrejtimi > 0)
    <div class='col-lg-4'>
        <div class="form-group">
            <div class="input-group col-lg-10">
                <span class="input-group-addon">{{ Lang::get('general.lecturer') }}</span>
                {{ Form::select('professor', $professor,current($professor),array('class'=>'form-control','id'=>"professor")) }}
            </div>
        </div>
    </div>
        @else 
    <div class='col-lg-4'>
        <div class="form-group">
            <div class="input-group col-lg-10">
                <span class="input-group-addon">{{ Lang::get('general.lecturer') }}</span>
                {{ Form::select('professor', $professor,current($professor),array('class'=>'form-control','id'=>"professor","diasbled"=>"diasbled")) }}
            </div>
        </div>
    </div>
    
        
        @endif
</div>


<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{ Lang::get('general.name')}} {{ Lang::get('general.surname')}}</th>
        <th>{{ Lang::get('general.email') }}</th>
        <th style='width:20%;'> 
            </th>
    </tr>
    @foreach($students as $value)
    <tr>
        <td>{{ $value['uid'] }}</td>
        <td>{{ $value['emri'].' '.$value['mbiemri'] }}</td>
        <td><div class="checkbox">
                <label>
                    <input type="checkbox" id="blankCheckbox" name='vijushmeria[]' value="{{ $value['uid'] }}" aria-label="...">
                </label>
            </div></td>
        <td> </td>
    </tr>
    @endforeach
</table>

<script>
            $('#drejtimi').change(function () {

    var drejtimi = $("#drejtimi").val();
            if (drejtimi > 0) {
    @if($semestri)
            window.location.href = "{{ action('VijushmeriaController@getVijushmeria') }}/" + drejtimi + "/{{ $semestri }}";
            @else
            window.location.href = "{{ action('VijushmeriaController@getVijushmeria') }}/" + drejtimi;
            @endif
    }

    });
            $('#semester').change(function () {

    var semester = $("#semester").val();
            if (semester) {
    @if($selDrejtimi > 0)
            window.location.href = "{{ action('VijushmeriaController@getVijushmeria') }}/{{$selDrejtimi}}/" + semester;
            @else
            window.location.href = "{{ action('VijushmeriaController@getVijushmeria') }}/-1/" + semester;
            @endif

    }
    });
</script>
<center>
    <button type='submit' class='btn btn-primary'>{{ Lang::get('general.register') }}</button>
</center>
{{ Form::close() }}


@stop
@section('title')
<section class="content-header">
    <h1>
        {{ Lang::get('general.attendance') }}<small>{{ Lang::get('general.attendance') }}</small>
    </h1>
</section>
@stop
@section('content')
@yield('title')
<section class="content">
@yield('notification')
@yield('registerVijushmeria')
</section>
@stop


