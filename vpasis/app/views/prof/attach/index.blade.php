@extends('prof.index')

@section('addattach')

<div class='form-group'>
    <div class="input-group">
        <span class="input-group-addon">{{ Lang::get('general.course') }}</span>
        {{ Form::select('actvlnd',$attach,current($attach), array('class'=>'form-control') ) }}
    </div>
</div>
<div class='form-group'>
    <div class="input-group">
        <span class="input-group-addon">{{ Lang::get('general.title') }}</span>
        <input type="text" class="form-control" name="title" placeholder="Titulli">
    </div>
</div>
<div class='form-group'>
    <div class="input-group">
        <span class="input-group-addon"><span class="fa fa-file-pdf-o"></span></span>

        {{ Form::file('uploadl',array('class'=>' btn btn-default')) }}
    </div> 
</div> 
<div class='form-group'>
    <label class="radio-inline">
        {{ Lang::get('profile.exercise') }}
    </label>
    <label class="radio-inline">
        <input type="radio" name="ushtrime" id='idushtrimep' value="{{ Enum::po }}" >
        {{ Lang::get('general.yes') }}
    </label>
    <label class="radio-inline">
        <input type="radio" name="ushtrime" id='idushtrimej' value="{{ Enum::jo }}" checked>
        {{ Lang::get('general.no') }}
    </label>
</div>
<div  id='ushtrime' style="display:none;" class="col-md-offset-1">
    <div class='form-group'>
        <div class="input-group">
            <span class="input-group-addon">{{ Lang::get('general.title') }}</span>
            <input type="text" class="form-control " name="titleu" placeholder="{{ Lang::get('general.title') }}">
        </div>
        <br> 


        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-file-archive-o"></span></span>

            {{ Form::file('uploadu',array('class'=>' btn btn-default')) }}
        </div> 
    </div>
</div>
<script>
    $(document).ready(function() {
        if ($('#idushtrimep:checked').is(':checked') == true) {
            $('#ushtrime').fadeIn('slow').css('display', 'block');
        }
    });
    $('#idushtrimep').click(function() {
        $('#ushtrime').fadeIn('slow');
    });
    $('#idushtrimej').click(function() {
        $('#ushtrime').fadeOut('slow');
    });
</script>
@stop


@section('listattach')
{{ Form::open(array('url'=>'','method'=>'POST','class'=>' form-horizontal','id'=>"list",'role'=>'upload', 'name'=>'list','files'=>true)) }}

<div class='form-group'>
    {{ Form::select('actvlnd',$attach,current($attach), array('class'=>'form-control','id'=>'actvlnd') ) }}
</div>
{{ Form::close() }}
<div class='table-responsive'>
    <table class="table">
        <tr>
            <th>#</th>
            <th>{{ Lang::get('general.title') }}</th>
            <th>{{ Lang::get('general.date') }}</th>
            <th>{{ Lang::get('general.size') }}</th>
            <th>{{ Lang::get('general.download') }}</th>
        </tr>
        <tbody id='listrow'>

        </tbody>
    </table>
</div>

<script>
    $("#actvlnd").change(function() {
        var dataString = $('#list').serialize();
        $.ajax({
            type: "POST",
            url: "{{ action('ProfessorController@postLigjeratatList')  }}",
            data: dataString,
            error: function() {
                alert('Something went go wrong');
            },
            success: function(data) {
                console.log(data);
                $('#listrow').empty().append(data);
            }},
        "json");
    });
</script>
@stop

@section('content')
<div class='container'>

    <div class='col-md-4 '>
        {{ Session::get('notification')}}
        {{ Form::open(array('url'=>action('ProfessorController@postUploadLigj'),'method'=>'POST','class'=>' form-horizontal','role'=>'upload', 'name'=>'list','files'=>true)) }}

        <div class="panel panel-default ">
            <div class="panel-heading">{{ Lang::get('general.upload_ligjerat')}}</div>
            <div class="panel-body">
                @yield('addattach')
            </div>
            <div class="panel-footer">
                <button class="btn btn-primary center-block" type="submit">{{ Lang::get('general.upload') }}</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <div class='col-md-8'>

        {{ Session::get('deleted')}}
        @yield('listattach')
    </div>
</div>
@stop