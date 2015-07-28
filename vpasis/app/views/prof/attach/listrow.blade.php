
<tr>
    <th colspan="6" class="text-center"> {{ Lang::get('general.ligjeratat')}}</th>
</tr>
@foreach($ligjeratat as $value)
<tr>
    <td>{{$i++}}</td>
    <td>{{ $value['Titulli'] }}</td>
    <td>{{ $value['data'] }}</td>
    <td>{{ sprintf('%.1f',$value['size']/1000) }} MB</td>
    <td><a href="/smpsfile/ligjeratat/{{ $value['Session'] }}/{{ $value['idl'] }}{{$value['Attachname'] }}" target="_blank"> {{ Lang::get('general.download')}} <span class="fa fa-file-pdf-o"></span></a></td>
    <td>      
        <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#li{{$value['id']}}">
            <span class="fa fa-trash-o"></span>
        </button>
        {{ Form::open(array('url' => action('ProfessorController@postDeleteLigjerata'),'method'=>'POST','class'=>'form-horizontal')) }}
        <input type="hidden" name="idlu" value="{{$value['id']}}">
        <input type="hidden" name="idl" value="{{ $value['idl'] }}">
        <div class="modal fade" id="li{{$value['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.are_you_sure') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Titulli</span>
                                <input type="text" class="form-control" value="{{ $value['Titulli'] }}" disabled>
                            </div>
                        </div>
                        {{ Lang::get('warn.warn_delete_ligjeratat') }}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ Lang::get('general.delete') }}</button>
                    </div>
                </div>
            </div>
        </div>

        {{ form::close() }}


    </td>
</tr>


@endforeach
<tr>
    <th colspan="6" class="text-center"> {{ Lang::get('general.ushtrime')}}</th>
</tr>
@foreach($ushtrime as $value)
<tr>
    <td>{{$j++}}</td>
    <td>{{ $value['Titulli'] }}</td>
    <td>{{ $value['data'] }}</td>
    <td>{{ sprintf('%.2f',$value['size']/1000) }} MB</td>
    <td><a href="/smpsfile/ligjeratat/{{ $value['Session'] }}/{{ $value['idl'] }}{{$value['Attachname'] }}" target="_blank"> {{ Lang::get('general.download')}} <span class="fa fa-file-pdf-o"></span> </a></td>
    <td>      
        <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#li{{$value['id']}}">
            <span class="fa fa-trash-o"></span>
        </button>
        {{ Form::open(array('url' => action('ProfessorController@postDeleteLigjerata'),'method'=>'POST','class'=>'form-horizontal')) }}
        <input type="hidden" name="idlu" value="{{$value['id']}}">
        <input type="hidden" name="idl" value="{{ $value['idl'] }}">
        <div class="modal fade" id="li{{$value['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.are_you_sure') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Titulli</span>
                                <input type="text" class="form-control" value="{{ $value['Titulli'] }}" disabled>
                            </div>
                        </div>
                        {{ Lang::get('warn.warn_delete_ligjeratat') }}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ Lang::get('general.delete') }}</button>
                    </div>
                </div>
            </div>
        </div>

        {{ form::close() }}

    </td></tr>
@endforeach
