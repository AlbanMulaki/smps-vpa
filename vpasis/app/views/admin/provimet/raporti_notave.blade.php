@extends("admin.index")


@section('notification')

@if(null !== Session::get('message') && Session::get('message') == Enum::successful)

<div class="callout callout-success">
    <h4>@lang('general.saved_successful')</h4>
    <p>{{ Session::get('reason') }}</p>
</div>
@elseif(Session::get('message') == Enum::failed)
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Lang::get('warn.error_undefined') }}
</div>

@endif
@stop


@section('report_grade')
<div class="box box-success">
    <div class="box-body">
        {{ Form::open(array('url'=>action('ProvimetController@getRaportiNotave'),'method'=>'GET')) }}
        <div class="row">
            <div class='col-lg-2'>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">{{ Lang::get('general.year') }}</span>
                        @if(isset($year))
                        {{ Form::select('year', Enum::getYear(),$year,array('class'=>'form-control ')) }}
                        @else
                        {{ Form::select('year', Enum::getYear(),null,array('class'=>'form-control ')) }}
                        @endif
                    </div>
                </div>
            </div>
            <div class='col-lg-3'>
                <div class="form-group">
                    <div class="input-group ">
                        <span class="input-group-addon">{{ Lang::get('general.month') }}</span>    
                        @if(isset($month))
                        {{ Form::select('month', Enum::getMonthExams(),$month,array('class'=>'form-control ')) }}
                        @else
                        {{ Form::select('month', Enum::getMonthExams(),null,array('class'=>'form-control ')) }}
                        @endif
                    </div>
                </div>
            </div>
            <div class='col-lg-4'>
                <div class="form-group">
                    <div class="input-group ">
                        <span class="input-group-addon">{{ Lang::get('general.profile') }}</span>
                        @if(isset($drejtimSel))
                        {{ Form::select('drejtimi', $drejtimi,$drejtimSel,array('class'=>'form-control ')) }}
                        @else
                        {{ Form::select('drejtimi', $drejtimi,null,array('class'=>'form-control ')) }}
                        @endif
                    </div>
                </div>
            </div>
            <div class='col-lg-1'>
                <div class="form-group">
                    <div class="col-sm-9">
                        <button name="submit" type="submit" class="btn btn-primary"> {{ Lang::get('general.search') }}</button>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-2'>
                <div class="form-group">
                   <div class="input-group ">
                        <span class="input-group-addon">#</span>
                    @if(isset($reportSearchId))
                    <input autocomplete="off" type='text'  name="reportSearchId" value='{{ $reportSearchId }}' class='form-control'>
                    @else
                    <input autocomplete="off" type='text' name="reportSearchId" class='form-control'>
                    @endif
                </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}

        @if(count($raportet))
        <table class='table table-responsive table-bordered'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ Lang::get('general.course') }}</th>
                    <th>{{ Lang::get('general.lecturer') }}</th>
                    <th>{{ Lang::get('general.profile') }}</th>
                    <th>{{ Lang::get('general.deadline_exams') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($raportet as $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->lendet->Emri }}</td>
                    <td>{{ $value->administrata->emri." ".$value->administrata->mbiemri }}</td>
                    <td>{{ $value->lendet->drejtimi->Emri }}</td>
                    <td>{{ $value['data_provimit'] }}</td>
                    @if($value['locked'] == Enum::nolocked)
                    <td>
                        <div class="btn-group">
                            <a href='{{ action('ProvimetController@getRegisterNotat',array($value->id)) }}' class="btn btn-sm btn-warning">{{ Lang::get('general.register_grade')}}</a>
                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#"  data-toggle="modal" data-target="#deleteReportGradeConfirm{{$value->id}}"><span class="fa fa-trash-o fa-lg"> </span> Fshij</a></li>

                            </ul>
                            <div class="modal fade" id="deleteReportGradeConfirm{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">@lang('general.are_you_sure')</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>@lang('general.are_you_sure_delete_report_grade',array('id'=>$value->id))</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" data-dismiss="modal">@lang('general.no')</button>
                                            <a href='{{ action('ProvimetController@getDeleteReportGrade',[$value->id]) }}' type="button" class="btn btn-danger">@lang('general.yes')</a>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </div>
                    </td>
                    @else
                    <td>
                        <a href="{{ action('ProvimetController@getRegisterNotat',array($value->id)) }}" class="btn btn-sm btn-default">
                            {{ Lang::get('general.view_report')}} &nbsp;  <i class='fa fa-lg fa-arrow-circle-right'></i>
                        </a>
                    </td>
                    @endif
                </tr>
                @endforeach

            </tbody>
        </table>
        {{ $raportet->links(); }}
        @else
        <div class='text-center text-gray'>
            <br><br>
            <i class=" fa fa-5x fa-lg fa-exclamation-triangle"></i>
            <br><br>
            @lang('warn.no_result_found_empty')

            @endif
        </div>




    </div>
    @stop
    @section('title')
    <section class="content-header">
        <h1>
            {{ Lang::get('general.report_grade') }}<small>{{ Lang::get('general.report_grade') }}</small>
        </h1>
    </section>
    @stop



    @section('content')
    @yield('title')
    <section class="content">

        @yield('content')

        <hr>
        @yield('notification')
        @yield('report_grade')
    </section>
    @stop