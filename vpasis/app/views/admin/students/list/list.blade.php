@extends('admin.index')

@section('export')
<a href="print-slist/" class="btn btn-success fa fa-file-excel-o fa-2x" ></a>
<a href="print-slist/" class="btn btn-primary fa fa-file-word-o fa-2x" ></a>
<a href="print-slist/" class="btn btn-danger fa fa-file-pdf-o fa-2x" ></a>
<a href="print-slist/" class="btn btn-default fa fa-print fa-2x" ></a>

@stop

@section('toolbox')
<form class='form-inline' role="form" id="search_sort">
    <div class='form-group'>
        {{ Form::select('sortaca',array(Lang::get('general.select_all'),'2012/2013'=>"2012/2013",'2013/2014'=>"2013/2014",'2014/2015'=>"2014/2015"),null,array('class'=>'form-control','id'=>'sortaca','plcaeholder'=>Lang::get('general.by_academy_year'))) }}
    </div> 




    <div class="form-group">
        {{ Form::text('searchstudent',"",array('autocomplete'=>"off",'id'=>'searchStudent','class'=>'form-control','placeholder'=>Lang::get('general.search_student'))) }}
    
    <div id="liststudent"></div>
    </div>
    <script>
        
        $('#searchStudent').keyup(function(){
            var datastr = $('#search_sort').serialize();
            $.ajax({
                type: "POST",
                url: "{{ action('AdminStudentController@postSearchStudent') }}",
                data: datastr,
                error: function(){alert('Report to developers')},
                success:function(datastr){console.log(datastr);$('#liststudent').empty().append(datastr)}
            });
        });
    </script>
<div id="listpeople"></div>

    <span style="float:right;">
        @yield('export')
    </span><br><br>
</form>
<script>
    $('#sortaca').change(function() {

        var dataString = $('#sortaca').serialize();
        $.ajax({
            type: "POST",
            url: "{{ action('AdminStudentController@postSortaca')}}",
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
    <div class="panel panel-default">
        <div class="panel-heading">

            @yield('toolbox')
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>{{ Lang::get('general.avatar') }}</th>
                        <th>{{ Lang::get('general.student') }}</th>
                        <th>{{ Lang::get('general.adress') }}</th>
                        <th>{{ Lang::get('general.email') }}</th>
                        <th>{{ Lang::get('general.options') }}</th>
                    </tr>
                </table>
            </div>
            <div class="text-center" style="color:#cccccc;">
                <span class="fa fa-cloud fa-5x"></span>
            </div>
        </div>
    </div>
</div>
@stop



@section('content')
<div class='container'>
    <br><br>
    @yield('list')
</div>
@stop