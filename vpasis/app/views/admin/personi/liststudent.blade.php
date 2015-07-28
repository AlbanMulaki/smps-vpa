@extends('admin.index')

@section('toolbox')
<div class='row'>
    <div class='col-md-8'>
        <form class='form-inline' role="form">
            <div class='form-group'>
                {{ Form::select('sortaca',array('','2014/2015'=>"2014/2015"),null,array('class'=>'form-control','id'=>'sortaca')) }}
            </div> 
        </form>
    </div>    
</div>    
<script>
    $('#sortaca').change(function() {

        var dataString = $('#sortaca').serialize();
        $.ajax({
            type: "POST",
            url: "{{ action('AdminController@postSortaca')}}",
            data: dataString,
            error: function() {
                alert('Something went go wrong');
            },
            success: function(data) {
                console.log(data);
                $('#sorting').empty().append(data);

            }},
        "json");
    });
</script>
@stop

@section('list')
<div id='sorting'>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Studenti</th>
                <th>Semestri</th>
                <th>Drejtimi</th>
            </tr>
        </table>
    </div>
    <div class="text-center" style="color:#cccccc;">
        <span class="fa fa-cloud fa-5x"></span>
    </div>
</div>
@stop



@section('content')
<div class='container'>
    @yield('toolbox')<br><br>
    @yield('list')
</div>
@stop