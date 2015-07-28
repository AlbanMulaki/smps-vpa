@extends('admin.index') 
@section('addOrari')
<div class="col-sm-4  panel-primary ">
    <div class="panel-heading">
        <h3 class="panel-title">{{ Lang::get('general.school_hours') }}</h3>
    </div>
    <div class="panel panel-primary " style="padding: 5px;">
        {{ Form::open(array('url'=>'/smps/admin/hsub/','method'=>'POST','class'=>'form','id'=>'form1')) }}
        <div class="form-group">

            <div class="input-group">
                <div class="input-group-addon">
                    {{ Form::label('drejtimet','Drejtimi') }}</div>
                {{ Form::select('drejtimi',$drejtimet,null,array('id'=>'drejtimet','class'=>'form-control')) }}
            </div>
        </div>
        <div class="form-group">
            <div id="lendet">

                <div class="input-group">
                    <div class="input-group-addon">
                        {{Form::label('lendet',Lang::get('general.course')) }}
                    </div>
                    {{Form::select('lendet',array('0'=>Lang::get('general.null')),null,array('class'=>'form-control','disabled'))}}
                </div>
                <br>
                <div id="prof">

                    <div class="input-group">
                        <div class="input-group-addon">
                            {{Form::label('lendet',Lang::get('general.professor')) }}
                        </div>
                        {{Form::select('null',array('0'=>Lang::get('general.null')),null,array('class'=>'form-control','disabled'))}}

                    </div>
                </div>
            </div>
        </div>





        <div class="form-group">
            <div id="day">
                {{
				Form::label('null',Lang::get('general.day'),array('class'=>'control-label
				col-sm-2')) }}
                <div class=" col-sm-10">
                    <div class="col-sm-6">
                        <div class="radio">
                            <label>{{ Form::radio('day',Enum::hene) }}{{
								Lang::get('general.monday') }}</label>
                        </div>
                        <div class="radio">
                            <label>{{ Form::radio('day',Enum::marte) }}{{
								Lang::get('general.tuesday') }}</label>
                        </div>
                        <div class="radio">
                            <label>{{ Form::radio('day',Enum::merkure) }}{{
								Lang::get('general.wednesday') }}</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="radio">
                            <label>{{ Form::radio('day',Enum::enjete) }}{{
								Lang::get('general.thursday') }}</label>
                        </div>
                        <div class="radio">
                            <label>{{ Form::radio('day',Enum::premte) }}{{
								Lang::get('general.friday') }}</label>
                        </div>
                        <div class="radio">
                            <label>{{ Form::radio('day',Enum::shtune) }}{{
								Lang::get('general.saturday') }}</label>
                        </div>


                    </div>
                </div>


            </div>
        </div>


        <div class="form-group">

            {{
			Form::label('lendet',Lang::get('general.time'),array('class'=>'control-label
			col-sm-2')) }}
            <div class=" col-sm-10">{{
				Form::text('ora',null,array('class'=>'form-control','placeholder'=>Lang::get('general.hour_format')))
                }}</div>
        </div>
        <div class=" pager">{{
			Form::submit(Lang::get('general.save'),['class'=>'btn btn-primary
			btn-lg','name'=>'submit']) }}</div>

        {{ Form::close() }}
    </div>
</div>
<script>
    $('#drejtimet').change(function(e) {
        e.preventDefault();
        var dataString = $('#drejtimet').serialize();
        $.ajax({
            type: "POST",
            url: "../admin/ajax/drejtimet",
            data: dataString,
            success: function(data) {
                console.log(data);
                $('.succesupd').modal('show');
                $('#lendet').empty().append(data);
            }
        },
        "json");
    });</script>
@stop 
@section('listOrari')
<div class="col-sm-8  panel-primary ">
    <div class="panel-heading">
        <h3 class="panel-title">{{ Lang::get('general.school_hours') }}</h3>
    </div>
    <div class="panel panel-primary " style="padding: 5px;">

        <div class="panel-body">

            {{ Form::open(array('url'=>'/smps//admin/hsub/print/','method'=>'GET','class'=>'form-horizontal')) }}
            <div class="col-sm-6"><a href="#" id="print_orari">
                    <span class="fa fa-print fa-2x"></span>
                </a></div>
            <div class="col-sm-6">{{Form::select('drejtimetlist',$drejtimet,null,array('id'=>'drejtimetlist','class'=>'form-control'))}}</div>

            <div id="listorari"></div>


            {{ Form::close() }}
            <script>
                $('#print_orari').click(function(e) {

                    e.preventDefault();
                    var dataString = $('#print_orari').serialize();
                    $.ajax({
                        type: "GET",
                        url: "{{action('OrariController@index').'/print/' }}" + $('#drejtimetlist').val(),
                        data: dataString,
                        success: function(data) {

                            console.log(data);
                            window.location = "{{action('OrariController@index').'/print/' }}" + $('#drejtimetlist').val();
                        }
                    },
                    "json");
                });
            </script>
        </div>




    </div>
</div>
<div id="errors"></div>
<script>
    $(document).ready(function() {
        $('#drejtimetlist').change(function(e) {
            e.preventDefault();
            var dataString = $('#drejtimetlist').serialize();
            $.ajax({
                type: "POST",
                url: "../admin/ajax/listorari",
                data: dataString,
                success: function(data) {
                    console.log(data);
                    $('.succesupd').modal('show');
                    $('#listorari').empty().append(data);
                }
            },
            "json");
        });
        $('#form1').submit(function(e) {
            e.preventDefault();
            var dataString = $('#form1').serialize();
            $.ajax({
                type: "POST",
                url: "../admin/hsub",
                data: dataString,
                success: function(data) {
                    console.log(data);
                    $('#errors').empty().append(data);
                    $('.myModalerror').modal('show');
                }},
            "json");
        });
    });
</script>


@stop 
@section('content') 
@yield('addOrari') 
@yield('listOrari') 
@stop
