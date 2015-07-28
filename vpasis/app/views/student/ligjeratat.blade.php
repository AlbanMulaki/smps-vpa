@extends('student.index')


@section('listattach')
{{ Form::open(array('url'=>'','method'=>'POST','class'=>' form-horizontal','id'=>"list",'role'=>'upload', 'name'=>'list','files'=>true)) }}

<div class='form-group'>
    {{ Form::select('actvlnd',$lendet,current($lendet), array('class'=>'form-control','id'=>'actvlnd') ) }}
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
            url: "{{ action('StudentController@postLigjeratatList')  }}",
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

    <div class='col-md-8 col-md-offset-1'>

        {{ Session::get('deleted')}}
        @yield('listattach')
    </div>
</div>
@stop