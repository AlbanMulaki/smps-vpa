@extends('admin.index')

@section('title')
<section class='content-header'>
    <h1>
        {{ Lang::get('general.stats') }}<small>{{ Lang::get('general.stats') }}</small>
    </h1>
</section>
@stop

@section('content')
@yield('title')
<br>


<div class="page-wrapper">
    
    <div class='col-lg-6'>
        <div class="col-lg-6 ">
            <div class="box box-info">
                <div class="box-header with-border bg-aqua ">
                    <div class="row">
                        <div class="col-sm-3">
                            <i class="fa fa-graduation-cap fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $countStudents }}</div>
                            <div>{{ Lang::get('general.num_students')}}</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="box-footer clearfix">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-6 ">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">

                            <div class="huge">{{ $student_notconfirmed }}</div>
                            <div>{{ Lang::get('general.students_notconfirmed') }}</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="box-footer clearfix">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Start Calendar Events -->
        <div class='col-lg-12 container'>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-calendar fa-fw"></i> {{ Lang::get('general.calendar_events')}}
                </div>
                <div class="box-body">
                    <span class="text-center">
                        <span class="fa fa-codepen fa-5x">

                        </span>
                    </span>
                </div>
            </div>
        </div>
        <!-- end Calendar Events -->
    </div>



    <div class='col-lg-6'>



        <!-- Start Workflow -->
        <div class='col-lg-12 container'>
            <div class="box box-warning ">
                <div class="box-header with-border no ">
                    <h3 class='box-title'><i class="fa fa-bell fa-fw"></i> {{ Lang::get('general.flow')}}</h3>
                </div>
                <div class="box-body">
                    <div class="list-group">
                        @foreach($workflow as $value)
                        @if($value['value'] == Enum::active)
                        <a href="#" data-toggle="modal" data-target=".workflow{{ $value['id']}}" id="workflow{{ $value['id']}}" class="list-group-item list-group-item-success"><span class="fa fa-times" > {{ $value['emri']}}</span></a>
                        @else
                        <a href="#" data-toggle="modal" data-target=".workflow{{ $value['id']}}" id="workflow{{ $value['id']}}" class="list-group-item list-group-item-danger"><span class="fa fa-times " > {{ $value['emri']}}</span></a>
                        <!-- Active/Deactive Workflow -->
                        @endif 

                        <div class="modal fade workflow{{ $value['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content container-fluid" >
                                    <div class="modal-body">
                                        <div class="row">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa-lg">&times;</span></button>
                                        </div>
                                        {{ Lang::get("general.did_you_finish_job",array('action'=>$value['emri']))}}
                                    </div>
                                    <div class="modal-footer">    


                                        <a type="submit" class="btn btn-success" id="activeworkflow{{$value['id']}}"><span class="fa fa-check fa-lg"></span></a>
                                        <a type="submit" class="btn btn-danger" name="passive"  value="0" id="deactiveworkflow{{$value['id']}}"><span class="fa fa-times fa-lg"></span></a>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            $('#activeworkflow{{$value['id']}}').click(function(e) {
                            e.preventDefault();
                            $.ajax({
                            type: "POST",
                                    url: "{{ action('AdminController@postWorkflow')}}",
                                    data: {"status": {{ Enum::active }}, "id":{{$value['id'] }}},
                                    error: function(xhr, ajaxOptions, thrownError) {
                                    alert(xhr.status + thrownError);
                                    },
                                    success: function(data) {
                                    console.log(data);
                                    $('.workflow{{$value['id']}}').modal('hide');
                                    $('#workflow{{ $value['id']}}').removeClass('list-group-item-danger').addClass('list-group-item-success');
                                    }},
                                    "json");
                            });
                            $('#deactiveworkflow{{$value['id']}}').click(function(e) {
                            e.preventDefault();
                            $.ajax({
                            type: "POST",
                                    url: "{{ action('AdminController@postWorkflow')}}",
                                    data: {"status": 0, "id":{{$value['id'] }}},
                                    error: function(xhr, ajaxOptions, thrownError) {
                                    alert(xhr.status + thrownError);
                                    },
                                    success: function(data) {
                                    console.log(data);
                                    $('.workflow{{$value['id']}}').modal('hide');
                                    $('#workflow{{ $value['id']}}').removeClass('list-group-item-success').addClass('list-group-item-danger');
                                    }},
                                    "json");
                            });
                        </script>
                        @endforeach


                    </div>
                </div>

            </div>
        </div>
        <!-- End Workflow -->
    </div>
    <div class='row'></div>
    


</div>
@stop