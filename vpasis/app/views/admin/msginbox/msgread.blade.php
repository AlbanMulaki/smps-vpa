@extends('admin.index')

@section('compose')
{{ Form::open(array('url'=>action('MsgController@postSend'),'method'=>'POST','class'=>' form-horizontal','id'=>'form1searchcompose','role'=>'search','name'=>'form1searchcompose')) }}


<!-- Create Message -->
<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ Lang::get('profile.compose_msg') }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input type="checkbox" name='admin' value='admin'>
                        </span>
                        <input id="searchcompose" type="text" class="form-control " autocomplete="off" placeholder="{{ Lang::get('general.search_person') }}" name="search">
                    </div>
                    <div id="listpeoplecompose"></div>

                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name='title' placeholder="{{ Lang::get('general.title') }}">
                </div>

                <div class="form-group">
                    <textarea class="form-control" type="text" rows='3' name='msg' placeholder="{{ Lang::get('general.msg') }}"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('general.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ Lang::get('general.send') }}</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}


<script>
    });
            $("#searchcompose").keyup(function() {
    var dataString = $('#form1searchcompose').serialize();
            $.ajax({
            type: "POST",
                    url: "/smps/admin/search",
                    data: dataString,
                    error: function() {
                    alert('Something went go wrong');
                    },
                    success: function(data) {
                    console.log(data);
                            $('#listpeoplecompose').empty().append(data);
                    }},
                    "json");
    });
</script>
@stop

@section('readinbox')
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        @foreach($msg as $value)
        {{ "";$i++ }}
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse"  href="#reply{{ $value['id'] }}" >

                    <span class='badge'>
                        @if(in_array($value['uid'],$person[0][0]->toArray()) )
                        {{ $person[0][0]['emri'] }} {{$person[0][0]['mbiemri'] }}
                        @elseif(in_array($value['uid'],$person[1][0]->toArray()) )
                        {{ $person[1][0]['emri'] }} {{$person[1][0]['mbiemri'] }}
                        @endif
                    </span>
                    {{ $value['title'] }} 
                </a>
            </h4>
        </div>
        @if($count == $i)
        <div id="reply{{ $value['id'] }}" class="panel-collapse collapse in">
            <div class="panel-body">
                {{ $value['msg'] }}
            </div>
        </div>
        @else

        <div id="reply{{ $value['id'] }}" class="panel-collapse collapse inbox-msg">
            <div class="panel-body">
                {{ $value['msg'] }}
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@stop
@section('content')
<div class='container well'>
    <div class=' container row'>

        <a href="{{ action('MsgController@getIndex') }}" class="btn btn-info">{{ Lang::get('profile.inbox',array('num'=>$news['inbox'])) }}</a>

        <button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#compose">{{ Lang::get('profile.compose_msg') }}</button>
        @yield('compose')
    </div><br>
    @yield('readinbox')

    {{ Form::open(array('url'=>action('MsgController@postReply')."/".$id,'method'=>'POST','class'=>'form-horizontal','id'=>'form1')) }}
    <div class='col-sm-10'>
        <textarea name='msg' class="form-control" rows="3" placeholder='{{ Lang::get('profile.msg_text')}}'></textarea>
    </div>
    <div class='col-sm-2'>
        <button type="submit" class="btn btn-primary btn-block">{{ Lang::get('profile.send') }} </button>
    </div>
    <input type='hidden' name='to' value='{{ $isuser['from'] }}' >
    {{ Form::close() }}
</div>
@stop
