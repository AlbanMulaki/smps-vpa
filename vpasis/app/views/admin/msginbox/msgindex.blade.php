@extends('admin.index')
@section('listinbox')

@foreach($msg as $value)
<div class="col-sm-12 btn btn-sm btn-block btn-default ">
    <a href="{{ action('MsgController@getRead') }}/{{ $value['id'] }}" value="44" id="lin44">
        <div class='col-sm-1 text-left'>

            @if($value['seen'] == Enum::seen)

            @else
            <span class='fa fa-weixin' style='color:#D9534F;'></span>
            @endif</div>

        <div class="col-sm-2 text-left">{{ $value['emri'] }} {{ $value['mbiemri'] }}</div>
        <div class="col-sm-2 text-left">{{ $value['title'] }}</div>
        <div class="col-sm-4 text-left">{{ substr($value['msg'], 0, 15) }}</div>
        <div class="col-sm-1 col-sm-offset-1 text-left">{{ date_format($value['updated_at'],'M-j') }}</div>

</div>
</a>
@endforeach
@stop

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
    $('#searchcompose').mouseout(function() {
        $('#listpeoplecompose').empty();
    });
    $('#searchcompose').click(function() {
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
@section('content')
<div class='container well'>
    <div class=' container row'>

        <button type="button" class="btn btn-info">{{ Lang::get('profile.inbox',array('num'=>$news['inbox'])) }}</button>

        <button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#compose">{{ Lang::get('profile.compose_msg') }}</button>
        @yield('compose')
    </div><br>
    @yield('listinbox')
</div>
@stop

