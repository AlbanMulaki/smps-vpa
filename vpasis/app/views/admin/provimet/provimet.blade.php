@extends('admin.index') 

@section('listparaqitura')

<button type='button' class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#listparaqitura">
    <span class='fa fa-list-alt fa-2x'></span>
</button>
{{ Form::open(array('action'=>'AjaxController@postProvimVijushmeri','method'=>'POST','class'=>'form-horizontal','id'=>'form2')) }}
<div class="modal fade" id="listparaqitura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.exams_list_apply')}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">{{ Lang::get('general.course') }}</div>
                        {{ Form::select('profileins',$drejtimet,current($drejtimet),array('class'=>'form-control','id'=>'dre')) }}

                        <div id='crsajx'> {{ Form::select('crs',array(''),null,array('class'=>'form-control','id'=>'crs','disabled')) }}
                        </div>
                    </div>
                </div>
                <!--    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">{{ Lang::get('general.semester') }}</div>
                            {{ Form::selectRange('semestri',1,6,array(1),array('class'=>'form-control')) }}
                        </div>
                    </div>
                -->

                <table class='table' id='studata'>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id='submitf2' class="btn btn-primary"><span class='fa fa-print'></span> {{ Lang::get('general.print') }}</button>
            </div>
        </div>
    </div>
</div>

{{ Form::close() }}
@stop
@section('addProvimet')

<div class="col-sm-4  panel-primary ">
    <div class="panel-heading"  data-toggle="collapse" data-target="#createprovim">
        <h3 class="panel-title">
            <div class="text-center"> <span class="fa fa-plus-square-o fa-2x"></span>
            </div>
        </h3>
    </div>
    <div class="panel panel-primary collapse out" id="createprovim" style="padding: 5px;">






        {{ Form::open(array('url'=>'/admin/exams/','method'=>'POST','class'=>'form','id'=>'form1')) }}
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    {{ Form::label('drejtimet','Drejtimi') }}
                </div>{{ Form::select('drejtimi',$drejtimet,null,array('id'=>'drejtimet','class'=>'form-control')) }}
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

            {{
			Form::label('lendet',Lang::get('general.date'),array('class'=>'control-label
			col-sm-2')) }}
            <div class=" col-sm-10">{{
				Form::text('data',null,array('class'=>'form-control','placeholder'=>Lang::get('general.datetime_format')))
                }}</div>
        </div>
        <div class=" pager">{{
			Form::submit(Lang::get('general.save'),['class'=>'btn btn-primary
			btn-lg','name'=>'submit']) }}</div>

        {{ Form::close() }}
    </div>

    <div class='col-md-12'><br></div>
    @yield('listparaqitura')
</div>
</div>
<script>
    $('#drejtimet').change(function(e) {
        e.preventDefault();
        var dataString = $('#drejtimet').serialize();
        $.ajax({
            type: "POST",
            url: "/smps/admin/ajax/drejtimet",
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
@section('listProvimet')
<div class="col-sm-8  panel-primary ">
    <div class="panel-heading">
        <h3 class="panel-title">{{ Lang::get('general.exams') }}</h3>
    </div>
    <div class="panel panel-primary " style="padding: 5px;">
        <div class="panel-body">
            <div class="col-sm-6">

                <div class="col-sm-2" >
                    {{ Form::open(array('url'=>'/admin/exams/print/','method'=>'GET','class'=>'form-horizontal')) }}

                    <a href="#" id="print_provimet">
                        <span class="fa fa-print fa-2x"></span>
                    </a>

                    {{ Form::close() }}
                    <script>
                        $('#print_provimet').click(function(e) {

                            e.preventDefault();
                            var dataString = $('#print_provimet').serialize();
                            $.ajax({
                                type: "GET",
                                url: "/smps/admin/exams/print/" + $('#drejtimetlist').val(),
                                data: dataString,
                                success: function(data) {
                                    console.log(data);
                                    window.location = "/smps/admin/exams/print/" + $('#drejtimetlist').val();
                                }
                            },
                            "json");
                        });
                    </script>
                </div>
                <div class="col-sm-10" >
                    {{ Lang::get('warn.info_provimet_select_print') }}
                </div>
            </div>
            <div class="col-sm-6">
                {{ Form::select('drejtimetlist',$drejtimet,null,array('id'=>'drejtimetlist','class'=>'form-control')) }}
            </div>

            <div id="listprovimet"></div>
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
                url: "/smps/admin/ajax/listprovimet",
                data: dataString,
                success: function(data) {
                    $('.succesupd').modal('show');
                    $('#listprovimet').empty().append(data);
                }
            },
            "json");
        });
        $('#form1').submit(function(e) {
            e.preventDefault();
            var dataString = $('#form1').serialize();
            $.ajax({
                type: "POST",
                url: "/smps/admin/exams",
                data: dataString,
                success: function(data) {
                    console.log(data);
                    $('#errors').empty().append(data);
                    $('.myModalerror').modal('show');
                }},
            "json");

        });

    });
    $('#dre').change(function(e) {
        e.preventDefault();
        var dataString = $('#dre').serialize();
        $.ajax({
            type: "POST",
            url: "{{ action('ProfController@postLendetajax') }}",
            data: dataString,
            success: function(data) {
                console.log(data);
                $('.succesupd').modal('show');
                $('#crsajx').empty().append(data);
            }
        },
        "json");
    });
    $(document).on('change', '#profileins', function() {
        var datastring = $('#profileins').serialize();
        $.ajax({
            type: "POST",
            url: "{{ action('AjaxController@postLendetprov') }}",
            data: datastring,
            success: function(data) {
                console.log(data);
                $('#studata').empty().append(data);
            }
        },
        "json");
    });
    $(document).on('click', '#submitf2', function(e) {
        e.preventDefault();

        var dataString = $('#form2').serialize();
        var urlsite = "{{ action('AjaxController@getPrintParaqitur') }}" + "?crs=" + $('#profileins').val();
        $.ajax({
            type: "GET",
            url: urlsite,
            success: function() {
                window.location = urlsite;
            }
        },
        "json");
    });
</script>


@stop 


@section('content') 
@yield('addProvimet') 
@yield('listProvimet') 
@stop
