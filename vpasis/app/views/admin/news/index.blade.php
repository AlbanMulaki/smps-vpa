@extends('admin.index')
@section('sendto')

<div class="checkbox">
    <label>
        <input type="checkbox" name="to[]" id='idstud' value="{{ Enum::student }}">
        {{ Lang::get('general.student') }}
    </label>
</div>
<div class="checkbox">
    <label>
        <input type="checkbox" name="to[]" value="{{ Enum::puntor }}">
        {{ Lang::get('general.workers') }}
    </label>
</div>
<div class="checkbox">
    <label>
        <input type="checkbox"  name="to[]" value="{{ Enum::prof }}">
        {{ Lang::get('general.professor') }}
    </label>
</div>
<div class="checkbox">
    <label>
        <input type="checkbox"  name="to[]" value="{{ Enum::referent }}">
        {{ Lang::get('general.referent') }}
    </label>
</div>

<div class="checkbox">
    <label>
        <input type="checkbox"  name="to[]" value="{{ Enum::dekani }}">
        {{ Lang::get('general.dekani') }}
    </label>
</div>
<div class="checkbox">
    <label>
        <input type="checkbox"  name="to[]" value="{{ Enum::drejtori }}">
        {{ Lang::get('general.director') }}
    </label>
</div>
<div class="checkbox">
    <label>
        <input type="checkbox"  name="to[]" value="{{ Enum::admin }}">
        {{ Lang::get('general.admin_it') }}
    </label>
</div>
@stop
@section('priority')
<h3>{{ Lang::get('general.priority') }}</h3>

<label class="btn btn-primary active">
    <input type="radio" name='priority' value="{{ Enum::normal }}"> {{ Lang::get('general.normal') }}
</label>
<label class="btn btn-warning">
    <input type="radio" name='priority' value="{{ Enum::high }}"> {{ Lang::get('general.high') }}
</label>
<label class="btn btn-danger">
    <input type="radio" name='priority' value="{{ Enum::critical }}"> {{ Lang::get('general.urgent') }}
</label>
@stop


@section('semester')
<h3>{{ Lang::get('general.semester')}}</h3>
<div class='col-sm-4'>
    <div class="checkbox">
        <label>
            <input type="checkbox"  name="sem[]" value="1">
            1
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox"  name="sem[]" value="2">
            2
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox"  name="sem[]" value="3">
            3
        </label>
    </div>
</div>
<div class='col-sm-4'>
    <div class="checkbox">
        <label>
            <input type="checkbox"  name="sem[]" value="4">
            4
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox"  name="sem[]" value="5">
            5
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox"  name="sem[]" value="6">
            6
        </label>
    </div>
</div>
@stop

@section('studentsto')

<h3>{{ Lang::get('general.profile')}}</h3>
@foreach($drejtimet as $valued)
<div class="checkbox">
    <label>
        <input type="checkbox"  name="dre[]" value="{{ $valued->idDrejtimet }}">
        {{ $valued->Emri  }}
    </label>
</div>
@endforeach
@stop
@section('addmsg')

<button class="btn btn-info btn-lg btn-block" data-toggle="modal" data-target="#myModal">
    +
</button>

{{ Form::open(array('action'=>'NewsController@postStore','method'=>'POST','role'=>'form','id'=>'formnews1')) }}

<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class=' well col-sm-12'>

                    <div class="form-group">
                        <input type="text" name='title' class="form-control" id="titlenews" placeholder="{{ Lang::get('general.title')}}">
                    </div>
                    <div class="form-group">
                        <textarea name="msg" class="form-control" id="titlenews"  rows="6">{{ Lang::get('general.msg')}}</textarea>
                    </div>
                    <div class="col-sm-2">
                        @yield('sendto')
                    </div>
                    <div  id='drejtimetadv' style="display:none;" >
                        <div class="col-sm-4" >
                            @yield('studentsto')
                            <hr>
                            @yield('semester')
                        </div>
                    </div>
                    <div class="col-sm-6">
                        @yield('priority')
                    </div>

                </div>

                <script>
                    $(document).ready(function() {
                    if ($('#idstud:checked').is(':checked') == true) {
                    $('#drejtimetadv').fadeIn('slow').css('display', 'block');
                    } else {
                    $('#drejtimetadv').fadeOut('slow', function() {
                    $('#drejtimetadv').css('display', 'none');
                    });
                    }
                    });
                            $('#idstud').click(function() {
                    if ($('#idstud:checked').is(':checked') == true) {
                    $('#drejtimetadv').fadeIn('slow').css('display', 'block');
                    } else {
                    $('#drejtimetadv').fadeOut('slow', function() {
                    $('#drejtimetadv').css('display', 'none');
                    });
                    }

                    });</script>

            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value='{{ Lang::get('general.close') }}'>
                <input type="submit" class="btn btn-primary" value='{{ Lang::get('general.notify_people') }}'>
            </div>
        </div>
    </div>
</div>

{{ Form::close() }}
@stop


@section('editnjoftimet')
@stop

@section('content')

<div class='container '>
    <div class="container">
        @yield('addmsg')
    </div>
    <div class="well container"  id='editlink'>
        <div class="col-sm-12">  
            <strong><div class="col-sm-1 text-left"></div>
                <div class="col-sm-3 text-left">{{ Lang::get('general.title') }}</div>
                <div class="col-sm-3 text-left">{{ Lang::get('general.msg') }}</div>
                <div class="col-sm-3 text-left">{{ Lang::get('general.to') }}</div>
                <div class="col-sm-2 text-left">{{ Lang::get('general.date') }}</div>
            </strong>

        </div>
        @foreach($njoftimet as $value)

        {{ Form::open(array('action'=>'NewsController@postUpdate','method'=>'POST','role'=>'form','id'=>'formupdate'. $value['idNjoftimet'] )) }}
        <input type="hidden" name="idnjft" value="{{$value['idnjoftimet']}}" >
        <div class="col-sm-12   btn  btn-sm btn-block btn-default">
            <a href="#" value='{{ $value['idnjoftimet']}}' id='lin{{ $value['idnjoftimet'] }}'>
                <div class="col-sm-1 text-left"><span class='fa fa-circle ' 
                                                      @if($value["priority"]== Enum::normal)
                                                      style='color:#3276B1;'
                                                      @elseif($value["priority"]== Enum::high)
                                                      style='color:#F0AD4E;'
                                                      @elseif($value["priority"]== Enum::critical)
                                                      style='color:#D9534F;'

                                                      @endif ></span></div>
                <div class="col-sm-2 text-left">@if(strlen($value['titulli'])>15)
                    {{ substr($value['titulli'],0,15) }}...
                    @else
                    {{ $value['titulli'] }}
                    @endif
                </div>
                <div class="col-sm-3 text-left">{{ substr($value['msg'],0,35) }}...</div>
                <div class="col-sm-3 text-left">
                    {{  "";$sendto = null; }}
                    @foreach( explode('@',$value['to_grp']) as $grp)
                    {{ "";$sendto .=" ". Enum::convertaccess($grp); }} 
                    @endforeach
                    {{ substr($sendto,0,25) }}
                </div>
                <div class="col-sm-1 text-left">{{ date("d/M/Y", strtotime($value['created_at'])) }} </div> </a>
            <div class="col-sm-2 text-right"><a href="#" data-toggle="modal" data-target="#deletemodal{{$value['idnjoftimet']}}" class="btn-sm btn-default active"> <span class="fa fa-trash-o"></span></a></div>

        </div>


        <div class="modal fade" id='linmod{{ $value['idnjoftimet'] }}' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">



                    <div class=' well col-sm-12'>

                        <div class="form-group">
                            <input type="text" name='title' class="form-control" id="titlenews" value="{{ $value['titulli'] }}">
                        </div>
                        <div class="form-group">
                            <textarea name="msg" class="form-control" id="titlenews"  rows="6">{{ $value['msg'] }}</textarea>
                        </div>
                        <div class="col-sm-2">

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="to[]"  value="{{ Enum::student }}"
                                           @if(empty($value['to_grp']) == false && preg_match("/".Enum::student."/",$value['to_grp']))
                                           checked="checked"
                                           @endif
                                           >
                                           {{ Lang::get('general.student') }}
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="to[]" value="{{ Enum::puntor }}"
                                           @if(empty($value['to_grp']) == false && preg_match("/".Enum::puntor."/",$value['to_grp']))
                                           checked="checked"
                                           @endif
                                           >
                                           {{ Lang::get('general.workers') }}
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  name="to[]" value="{{ Enum::prof }}"
                                           @if(empty($value['to_grp']) == false && preg_match("/".Enum::prof."/",$value['to_grp']))
                                           checked="checked"
                                           @endif
                                           >
                                           {{ Lang::get('general.professor') }}
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  name="to[]" value="{{ Enum::referent }}"

                                           @if(empty($value['to_grp']) == false && preg_match("/".Enum::referent."/",$value['to_grp']))
                                           checked="checked"
                                           @endif
                                           >
                                           {{ Lang::get('general.referent') }}
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  name="to[]" value="{{ Enum::dekani }}"
                                           @if(empty($value['to_grp']) == false && preg_match("/".Enum::dekani."/",$value['to_grp']))
                                           checked="checked"
                                           @endif
                                           >
                                           {{ Lang::get('general.dekani') }}
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  name="to[]" value="{{ Enum::drejtori }}"

                                           @if(empty($value['to_grp']) == false && preg_match("/".Enum::drejtori."/",$value['to_grp']))
                                           checked="checked"
                                           @endif
                                           >
                                           {{ Lang::get('general.director') }}
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  name="to[]" value="{{ Enum::admin }}"

                                           @if(empty($value['to_grp']) == false && preg_match("/".Enum::admin."/",$value['to_grp']))
                                           checked="checked"
                                           @endif
                                           >
                                           {{ Lang::get('general.admin_it') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4" >

                            <h3>{{ Lang::get('general.profile')}}</h3>
                            @foreach($drejtimi_arr as $valuers)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  name="dre[]" value="{{ $valuers['idDrejtimet'] }}" 
                                           @if(empty($value['idd']) == false)
                                           {{  ""; 
                                               $temp = explode('@',$value['idd']);
                                               foreach($temp as $dd){
                                                 if($dd==$valuers['idDrejtimet'])
                                                 echo "checked=\"checked\"";
                                           } 
                                           }}
                                           @endif
                                           >
                                           {{ $valuers['Emri'] }}

                                </label>
                            </div>
                            @endforeach
                            <hr>
                            <h3>{{ Lang::get('general.semester')}}</h3>

                            <div class='col-sm-4'>
                                @for($i=1;$i<=3;$i++)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"  name="sem[]" value="{{$i}}" 

                                               {{ ""; $mysem = explode('@',$value['semestri']); }}
                                               @if( preg_match("/".$i."/",$value['semestri']) )
                                               checked="checked"
                                               @endif
                                               >
                                               {{$i}}
                                    </label>
                                </div>

                                @endfor

                            </div>
                            <div class='col-sm-4'>
                                @for($i=4;$i<=6;$i++)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"  name="sem[]" value="{{$i}}"  
                                               {{ ""; $mysem = explode('@',$value['semestri']); }}
                                               @if( preg_match("/".$i."/",$value['semestri']) )
                                               checked="checked"
                                               @endif
                                               >
                                               {{$i}}
                                    </label>
                                </div>
                                @endfor
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h3>{{ Lang::get('general.priority') }}</h3>

                            <label class="btn btn-primary active">
                                <input type="radio" name='priority' value="{{ Enum::normal }}"
                                       @if($value['priority'] == Enum::normal)
                                       checked="checked" 
                                       @endif
                                       > {{ Lang::get('general.normal') }}
                            </label>
                            <label class="btn btn-warning">
                                <input type="radio" name='priority' value="{{ Enum::high }}"
                                       @if($value['priority'] == Enum::high)
                                       checked="checked"
                                       @endif
                                       > {{ Lang::get('general.high') }}
                            </label>
                            <label class="btn btn-danger">
                                <input type="radio" name='priority' value="{{ Enum::critical }}"
                                       @if($value['priority'] == Enum::critical)
                                       checked="checked"
                                       @endif
                                       > {{ Lang::get('general.urgent') }}
                            </label>
                        </div>

                    </div>



                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value='{{ Lang::get('general.close') }}'>
                        <input type="submit" class="btn btn-primary" value='{{ Lang::get('general.edit') }}'>
                    </div>
                </div>

            </div>
        </div>

        {{ Form::close() }}


        {{ Form::open(array('url'=>'/admin/news/delete','method'=>'POST','role'=>'form','id'=>'formupdate'. $value['idNjoftimet'] )) }}
        <input type="hidden" name="njftm" value="{{$value['idnjoftimet']}}">
        <!-- Modal -->
        <div class="modal fade" id="deletemodal{{$value['idnjoftimet']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        {{Lang::get('general.are_you_sure')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            {{Lang::get('general.no')}}</button>
                        <button type="submit" class="btn btn-primary">
                            {{Lang::get('general.yes')}}</button>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
        <script>

                    $('#lin{{ $value['idnjoftimet'] }}').click(function(){
            $('#linmod{{ $value['idnjoftimet'] }}').modal('show');
            });
        </script>

        @endforeach
    </div>
</div>
@stop

