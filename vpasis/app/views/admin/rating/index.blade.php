@extends('admin.index')

@section('create')

{{ Form::open(array('action'=>'RatingController@postCreate','method'=>'POST','class'=>'form','id'=>'formcreate')) }}
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#createquest">
                    {{ Lang::get('general.create_question') }}
                </a>
            </h4>
        </div>
        <div id="createquest" class="panel-collapse collapse ">
            <div class="panel-body">

                <div class="form-group">
                    <textarea name="question" rows="3" class="form-control" placeholder="{{ Lang::get('general.question')}}"></textarea>
                </div>
                <div class='form-group'>
                    <div class="radio">
                        <label>
                            <input type="radio" name="type" id="optionsRadios1" value="2">
                            {{ Lang::get('general.professor') }}
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <input type="radio" name="type" id="optionsRadios1" value="1">
                            {{ Lang::get('general.student') }}
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ Lang::get('general.register') }}</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }} 

<script>
    $('#drejtimet').change(function(e) {
        e.preventDefault();
        var dataString = $('#formcreate').serialize();
        $.ajax({
            type: "POST",
            url: "{{ action('RatingController@postLendet')}}",
            data: dataString,
            success: function(data) {
                console.log(data);
                $('#lendet-list').empty().append(data);
            }
        },
        "json");
    });</script>
@stop


@section('top10')
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#top10">
                    {{ Lang::get('general.top_prof') }}
                </a>
            </h4>
        </div>
        <div id="top10" class="panel-collapse collapse in">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>{{ Lang::get('general.professor') }}</th>
                        <th>{{ Lang::get('general.rating') }}</th>
                    </tr>
                    {{-- @foreach($top as $value)
                    <tr>
                        <td>{{ "";$i++ }}</td>
                    <td>{{ $value['Prof'] }}</td>
                    <td>{{ $value[''] }}</td>
                    </tr>
                    @endforeach
                    --}}
                    <tr>
                        <td>1</td>
                        <td>Ercan Canhasi</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Eliot Bytyqi</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Artan Berisha</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Naim Braha</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Naim Braha</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Naim Braha</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Naim Braha</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Naim Braha</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('listrating')
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#listrating">
                    {{ Lang::get('general.question_list') }}
                </a>
            </h4>
        </div>
        <div id="listrating" class="panel-collapse collapse in">
            <div class="panel-body">
                {{Form::select('typepyetjet',array('default'=>'','1'=>Lang::get('general.student'),'2'=>Lang::get('general.professor')),'default',array('class'=>'form-control','id'=>'typepyetjet'))}}
                <div id="pyetjet-list"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#typepyetjet').change(function(e) {
        e.preventDefault();
        var dataString = $('#typepyetjetform').serialize();
        $.ajax({
            type: "POST",
            url: "{{ action('RatingController@postListpyetjet') }}",
            data: dataString,
            success: function(data) {
                console.log(data);
                $('#pyetjet-list').empty().append(data);
            }
        },
        "json");
    });
</script>
@stop

@section('content')
<div class="container">
    
    {{ Session::get('notification') }}
</div>
<div class='col-sm-4'>
    @yield('create')

    @yield('top10')
</div>

{{ Form::open(array('action'=>'RatingController@postCreate','method'=>'POST','class'=>'form','id'=>'typepyetjetform')) }}
<div class='col-sm-8'>
    @yield('listrating')
</div>
{{ Form::close() }}
@stop