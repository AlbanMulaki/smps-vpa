@extends('admin.index')




@section('basicprofile')

<div class="col-md-3">
    {{ Form::file('avatar') }}
    {{ HTML::image("smpsfile/avatar".$profile['avatar'],null,['width'=>'200','class'=>'img-thumbnail']) }}



</div>
<div class="col-md-5">

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">{{ Lang::get('general.name') }}</div>
            <input class="form-control" type="text" name="emri" value="{{$profile['emri']}}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">{{ Lang::get('general.surname') }}</div>
            <input class="form-control" type="text" name="mbiemri" value="{{$profile['mbiemri']}}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">{{ Lang::get('general.location') }}</div>
            <input class="form-control" type="text" name="vendbanimi" value="{{$profile['vendbanimi']}}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">{{ Lang::get('general.credit_card') }}</div>
            <input class="form-control" type="text" name="cc" value="{{$profile['xhirollogaria']}}">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">

            <div class="input-group-addon">{{ Lang::get('general.scienc_grade') }}</div>

            {{ Form::select('grade',$grade,$profile['grada'],array('class'=>'form-control')) }}
        </div>
    </div>
</div>
<div class=" col-md-2 col-md-offset-1">       
    <div class="form-group ">
        <div class="btn-group" data-toggle="buttons">

            <label class="btn btn-default
                   @if($profile['gjinia'] == Enum::femer)
                   active
                   @endif
                   ">
                <input type="radio" name="gjinia" id="gjinia1" value="{{ Enum::femer }}" 
                       @if($profile['gjinia'] == Enum::femer)
                       checked="checked"
                       @endif
                       >{{ Lang::get('general.female') }}
            </label>
            <label class="btn btn-default
                   @if($profile['gjinia'] == Enum::mashkull)
                   active
                   @endif
                   ">
                <input type="radio" name="gjinia" id="gjinia2"  value="{{ Enum::mashkull }}" 
                       @if($profile['gjinia'] == Enum::mashkull)
                       checked="checked"
                       @endif
                       > {{ Lang::get('general.male') }}
            </label>
        </div>
        <div class="form-group"><br>
            <div class="btn-group">
                @if($status == Enum::active)
                <label class="btn btn-success ">
                    {{ Lang::get('general.active') }}
                </label>
                @else
                <label class="btn btn-danger ">
                    {{ Lang::get('general.passive') }}
                </label>

                @endif
            </div>
        </div>

        <div class="form-group">

            <input  name="uid" value="{{$profile['uid'] }}" type="hidden">
            <input class="form-control" id="disabledInput" type="text" placeholder="{{$profile['uid'] }}" disabled>
        </div>        
        <div class="form-group">
            <div class="input-group">

                <div class="input-group-addon">{{ Lang::get('general.position') }}</div>

                {{ Form::select('pozita',$pos,$profile['pozita'],array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group  has-warning">
            <div class="input-group">
                <input class="form-control" type="password" name="psw" placeholder="{{Lang::get('general.change_password')}}">
            </div>
        </div>
    </div>

</div>


@stop


@section('advancedprofile')
<!-- first row -->
<div class="container col-md-12">

    <div class="col-md-3">
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon">{{ Lang::get('general.birthplace') }}</div>
                <input class="form-control" type="text" name="vendlindja" value="{{$profile['vendlindja']}}">
            </div>
        </div>
    </div>    


    <div class="col-md-3 col-md-offset-1">
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon">{{ Lang::get('general.state') }}</div>
                <input class="form-control" type="text" name="state" value="{{$profile['shtetas']}}">
            </div>
        </div>
    </div>

    <div class="col-md-3 col-md-offset-1">
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon">{{ Lang::get('general.idpersonal') }}</div>
                <input class="form-control" type="text" name="idpersonal" value="{{$profile['nrpersonal']}}">
            </div>
        </div>
    </div>
</div>
<!-- 2 row -->
<div class="container col-md-12">
    <div class="col-md-3 ">
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon">{{ Lang::get('general.birthdate') }}</div>
                <input class="form-control" type="text" name="birthdate" value="{{$profile['datalindjes']}}">

            </div>
        </div>
    </div>


    <div class="col-md-2 col-md-offset-1">
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon">{{ Lang::get('general.hour') }}</div>
                <input class="form-control" type="text" name="hour" value="{{$profile['pagesa_ores']}}">

                <div class="input-group-addon"><span class='fa fa-eur'></span></div>
            </div>
        </div>
    </div>
    <div class="col-md-5 col-md-offset-1">
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon">{{ Lang::get('general.qualification') }}</div>
                <textarea class="form-control" rows="3" name="kualifikimi" >{{$profile['kualifikimi'] }}</textarea>
            </div>
        </div>
    </div>

</div>
<!-- 4 Row -->
<div class="container col-md-12">
    <h3 class="col-md-12">{{ Lang::get('general.info_adress') }}<hr></h3>
    <div class="col-md-2">
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon">{{ Lang::get('general.location') }}</div>
                <input class="form-control" type="text" name="vendbanimi" value="{{$profile['vendbanimi']}}">
            </div>
        </div>
    </div>

    <div class="col-md-4 col-md-offset-1">
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon">{{ Lang::get('general.email') }}</div>
                <input class="form-control" type="text" name="email" value="{{$profile['email']}}">
            </div>
        </div>
    </div>
    <div class="col-md-3 col-md-offset-1">
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon">{{ Lang::get('general.phone') }}</div>
                <input class="form-control" type="text" name="telefoni" value="{{$profile['telefoni']}}">
            </div>
        </div>
    </div>   
</div>

<!-- 5 Row -->
<div class="container col-md-12">

    <div class="col-md-5">
        <div class="form-group ">
            <div class="input-group">
                <div class="input-group-addon">{{ Lang::get('general.adress') }}</div>
                <textarea class="form-control" rows="4" name="adress" >{{ $profile['adressa']}}</textarea>

            </div>
        </div>
    </div>  
</div>
@stop


@section('obligations')
<table class="table">
    <tbody>
        <tr>
            <th>
    <div class='col-sm-3  list-group-item-text'>
        {{ Lang::get('general.course') }}
    </div>
    <div class='col-sm-1  list-group-item-text'>
        {{ Lang::get('general.fondi_oreve') }}
    </div>
    <div class='col-sm-1  list-group-item-text'>
        {{ Lang::get('general.status') }}
    </div>
    <div class='col-sm-3  list-group-item-text'>
        {{ Lang::get('general.zgjedhore') }}
    </div> 
    <div class='col-sm-3  list-group-item-text'>
    </div> 
</th>
</tr>


@foreach($assign as $value)

<tr>
    <td>
        {{-- deaktivizon personin e ccaktuar nga lenda --}}
        @if($value['active'] == Enum::active)
        <div class='col-sm-3 list-group-item-text'>
            {{ $value->emri }}
        </div>
        <div class='col-sm-1 list-group-item-text'>
            {{ $value->oret }}
        </div>
        <div class='col-sm-1 list-group-item-text' style='color:#5CB85C;'> 
            <span class='fa fa-circle '></span>
        </div>
        <div class='col-sm-3 list-group-item-text'>
            {{ $value->Zgjedhore }}
        </div>
        <div class='col-sm-1 list-group-item-text'>
            <a href="#" data-toggle="modal" data-target="#statusobligimet{{ $value->idassign_prof }}" class="btn-sm btn-default active" style='color:#F0AD4E;'> <span class="fa fa-minus-circle"></span></a>
        </div>
        <!-- Status update form -->
        {{ Form::open(array('url'=>'/smps/admin/prof/obligimet/'.$profile['uid'],'method'=>'POST','class'=>'form-horizontal','id'=>'formobligimet'.$i++,'role'=>'form','name'=>'formobligimet'.$i++)) }}

        <input type="hidden" name="njftm" value="{{ $value->idassign_prof }}">
        <input type="hidden" name="active" value="{{ $value->active }}">
        <!-- Modal -->
        <div class="modal fade" id="statusobligimet{{ $value->idassign_prof }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">            
                            {{Lang::get('general.are_you_sure')}}
                        </h4>
                    </div>
                    <div class="modal-body">
                        {{ Lang::get('warn.warning_obligation_assign_edit_deactive',array('landa'=>$value->emri )) }}
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
        {{-- regjistron personin e caktuar ne lendet te cilat i ka te regjistruara --}}

        @else
        <div class='col-sm-3 list-group-item-text'>
            {{ $value->emri }}
        </div>
        <div class='col-sm-1 list-group-item-text'>
            {{ $value->oret }}
        </div>
        <div class='col-sm-1 ' style='color:#A94442;'>
            <span class='fa fa-circle '></span>
        </div>
        <div class='col-sm-3 list-group-item-text'>
            {{ $value->Zgjedhore }}
        </div>
        <div class='col-sm-1 list-group-item-text'>
            <a href="#" data-toggle="modal" data-target="#statusobligimet{{ $value->idassign_prof }}" class="btn-sm btn-default active"> <span class="fa fa-plus-circle"></span></a>
        </div>
        <!-- Status update form -->
        {{ Form::open(array('url'=>'/smps/admin/prof/obligimet/'.$profile['uid'],'method'=>'POST','class'=>'form-horizontal','id'=>'formobligimet'.$i++,'role'=>'form','name'=>'formobligimet'.$i++)) }}

        <input type="hidden" name="njftm" value="{{ $value->idassign_prof }}">
        <input type="hidden" name="active" value="{{ $value->active }}">
        <!-- Modal -->
        <div class="modal fade" id="statusobligimet{{ $value->idassign_prof }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">            
                            {{Lang::get('general.are_you_sure')}}
                        </h4>
                    </div>
                    <div class="modal-body">

                        {{ Lang::get('warn.warning_obligation_assign_edit_active',array('landa'=>$value->emri,'person'=>$profile['emri']." ".$profile['mbiemri'] )) }}
                        <div class="input-group col-sm-3">

                            <div class="input-group-addon">{{ Lang::get('general.fondi_oreve') }}</div>

                            {{ Form::selectRange('fondi_oreve',1,10,array(1),array('class'=>'form-control')) }}
                        </div>
                        <br>
                        <div class="alert alert-info" role="alert">{{ Lang::get('warn.info_obligation_assign_fondi_oreve') }}</div>
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
        @endif

        {{-- Fshirja e mundesis se ligjerit ne lenden e cila i eshte caktuar --}}
        <div class='col-sm-1 list-group-item-text'>
            <a href="#" data-toggle="modal" data-target="#obligimetdel{{ $value->idassign_prof }}" class="btn-sm btn-default active" > <span class="fa fa-trash-o"></span></a>
        </div>

        {{ Form::open(array('url'=>'/smps/admin/prof/obligimetdel/'.$profile['uid'],'method'=>'POST','class'=>'form-horizontal','id'=>'formobligimet'.$i++,'role'=>'form','name'=>'formobligimet'.$i++)) }}

        <input type="hidden" name="njftm" value="{{ $value->idassign_prof }}">
        <input type="hidden" name="active" value="{{ $value->active }}">
        <!-- Modal -->
        <div class="modal fade" id="obligimetdel{{ $value->idassign_prof }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">            
                            {{Lang::get('general.are_you_sure')}}
                        </h4>
                    </div>
                    <div class="modal-body">

                        {{ Lang::get('warn.info_obligation_assign_delete',array('landa'=>$value->emri,'person'=>$profile['emri']." ".$profile['mbiemri'] )) }}

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


    </td>
</tr>  

@endforeach



</tbody>
</table>

@stop



@section('profile')
<div class="panel panel-default">
    <div class="panel-body">
        {{ Form::open(array('url'=>'/smps/admin/person/'.$profile['uid'],'method'=>'PUT','files' =>true, 'class'=>'form-horizontal','id'=>'form1','role'=>'form','name'=>'form1')) }}

        @yield('basicprofile')
        <div class="container col-md-12">
            <hr>
            @yield('advancedprofile')
            <input class="btn btn-primary" type="submit" name="submit" value="{{ Lang::get('general.edit') }}" >
        </div>

        {{ Form::close() }}

    </div>
</div>
@stop



@section('content') 

<div class='container'>

    <ul class="nav nav-tabs" role="tablist" id="tabmenu">
        <li class="active"><a href="#profile" role="tab" data-toggle="tab">{{ Lang::get('general.personal_profile') }}</a></li>
        <li><a href="#obligations" role="tab" data-toggle="tab">{{ Lang::get('general.obligations') }}</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade in  active" id="profile">
            @yield('profile') 
        </div>
        <div class="tab-pane fade in " id="obligations">
            <div class='col-md-11'>
                @yield('obligations') 
            </div>
            {{ Form::open(array('url'=>'/smps/admin/prof/obligimetinsert/'.$profile['uid'],'method'=>'POST','class'=>'form-horizontal','id'=>'forminsert','role'=>'form','name'=>'forminsert')) }}

            <div class='col-md-1'>
                <br>
                <!-- Create new obligation -->
                <div class="modal fade" id="createobl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">            
                                    {{Lang::get('general.are_you_sure')}}
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group ">
                                    <div class="input-group ">
                                        <label for='profileins' class="input-group-addon">{{ Lang::get('general.profile') }}</label>
                                        {{ Form::select('profileins',$drejtimet,current($drejtimet),array('class'=>'form-control','id'=>'profileins')) }}
                                        <div id='crsajx'> {{ Form::select('crs',array(''),null,array('class'=>'form-control','id'=>'crs','disabled')) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="input-group ">
                                        <label for='active' class="input-group-addon">{{ Lang::get('general.status') }}</label>
                                        {{ Form::select('active',Enum::getActive(),current(Enum::getActive()),array('class'=>'form-control','id'=>'active')) }}

                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="input-group ">
                                        <label for='fondi_oreve' class="input-group-addon">{{ Lang::get('general.fondi_oreve') }}</label>
                                        {{ Form::selectRange('fondi_oreve',1,10,array(1),array('class'=>'form-control','id'=>'fondi_oreve')) }}
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    {{Lang::get('general.register')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success btn-lg" data-toggle="modal"  data-target='#createobl'><span class='fa fa-plus-square'></span></button>
            </div>
        </div>
    </div>
    <div id="msg"></div>

    <script>
        $('#profileins').change(function(e) {
            e.preventDefault();
            var dataString = $('#profileins').serialize();
            $.ajax({
                type: "POST",
                url: "{{ action('ProfController@postLendetajax') }}",
                data: dataString,
                success: function(data) {
                    console.log(data);
                    $('#crsajx').empty().append(data);
                }},
            "json");

        });

        $(function() {
            $('#tabmenu a:last').tab('show')
        });
    </script>            

</div>       

@stop