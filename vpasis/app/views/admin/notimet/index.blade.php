@extends('admin.index')


@section('addnota')

<div class='col-sm-4 form-group'>
    <input id='uid' type="text" class="form-control" name="uid[]">
</div>
<div class='col-sm-2 form-group'>
   <!-- <input id='uid' type="text" class="form-control" ame="nota[]"> -->
    {{ Form::selectRange('nota[]',5,10,null,array('class'=>'form-control')) }}
</div>
@stop



@section('content') 
<div class='col-sm-5 col-sm-offset-1 well '>

    {{ Form::open(array('action'=>'NotimetController@getRaport','method'=>'GET','role'=>'form','id'=>'formidraport')) }}
    <div class='form-group'>

        <div class="input-group">
            <input type='text' name="notimetidrpt"  class="form-control" id="notimetidrpt" placeholder="{{ Lang::get('general.id_raportit')}}">

            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">{{Lang::get('general.watch') }}</button>
            </span>
        </div>
    </div>
    {{ Form::close() }}
    <div class="panel-heading">
        <h3 class="panel-title">{{ Lang::get('header.title_register_grade') }}</h3>
    </div>
    {{ Form::open(array('action'=>'NotimetController@getStore','method'=>'GET','role'=>'form','id'=>'formrnotat')) }}
    <div class="col-sm-12">
        <div class='col-sm-12'>   
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">{{ Lang::get('general.profile')}}</label>

                {{ Form::select('drejtimi',$drejtimet,null,array('class'=>'form-control','id'=>'drejtimi')) }}
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">{{ Lang::get('general.course')}}</label>
                <span id="lendet">
                    {{ Form::select('lendet',$lendet,null,array('class'=>'form-control','disabled'=>'disabled')) }}
                </span>
            </div>
            <div class="form-group col-md-1 ">
                <div class='form-group'>
                    <input id='addnota' type="button" class="btn btn-success control" value='+'></input>
                </div>
            </div>           
            <div class="form-group col-md-1 ">
                <div class='form-group'>
                    <input id='removenota' type="button" class="btn btn-danger control" value='-'></input>
                </div>
            </div>
        </div>
        <div class="col-sm-12 ">
            <div class='col-sm-4'>
                <label>{{ Lang::get('general.id_student') }}</label>
            </div>
            <div class='col-sm-2'>
                <label for="uid">{{ Lang::get('general.grade') }}</label>
            </div>
        </div>
        <div id='addnotajs' class='col-sm-12'>
            @yield('addnota')
        </div>
        <div id='addnotat-here'></div>
        <div class="pager">
            <input class='btn btn-primary' type="submit" name="submit" value="{{ Lang::get('general.register')}}" >
        </div>
    </div>

    {{ Form::close() }}
</div>
<div class='col-sm-5 col-sm-offset-1 well '><span class=" pager fa fa-linux fa-5x"></span><h1>Kollofiumet</h1><span class=" pager fa fa-linux fa-5x"></span></div>

<!-- MSG -->

<div id="msgerrsc"></div>

<!-- Successful MSG -->
<div class="modal  fade myModalsuc" id="myModalsuc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{ Lang::get('validation.success') }}</h4>
            </div>
            <div class="modal-body alert alert-success">
                {{ Lang::get('general.successful') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('general.close') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Failed MSG -->
<div class="modal  fade myModalsuc" id="myModalerror" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{ Lang::get('validation.failed') }}</h4>
            </div>
            <div class="modal-body alert alert-success">
                {{ Lang::get('general.successful') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('general.close') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#addnota').click(function() {
    var master = $('#addnotajs').clone();
            $('#addnotat-here').append(master);
    });
            $('#removenota').click(function() {
    $('#addnotat-here div:last-child').remove();
    });
            $('#drejtimi').change(function() {
    var urlstr = '{{ action('NotimetController@postLendet') }}';
            $.ajax({
            type: "POST",
                    url: urlstr,
                    data: ({drejtimi: $('#drejtimi').val()}),
                    error: function() {
                    alert('Something went go wrong');
                    },
                    success: function(data) {
                    console.log(data);
                            $('#lendet').empty().append(data);
                    }},
                    "json");
    });
</script>
@stop