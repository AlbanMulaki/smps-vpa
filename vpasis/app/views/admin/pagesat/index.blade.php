@extends('admin.index')
@section('notification')

<!-- Regjistrimi Departmentit -->
@if(null !== Session::get('message') && Session::get('message') == Enum::successful)
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Session::get('reason') }}
</div>
@elseif(Session::get('message') == Enum::failed)
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Lang::get('warn.error_undefined') }}
</div>

@endif
<!-- End Regjistrimi Departmentit -->
@stop


@section('register_fee')
{{ Form::open(array('url'=>action('FeeController@postRegister'),'method'=>'POST','class'=>"form-horizontal")) }}
<!-- Modal -->
<div class="modal fade" id="fee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ Lang::get('general.register_fee') }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="paguesi" class="col-sm-3 control-label">{{ Lang::get('general.payer') }}</label>
                    <div class="col-sm-9">
                        <input name="paguesi" class="form-control" id="paguesi" placeholder="{{ Lang::get('general.payer') }} ID" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="emri_bankes" class="col-sm-3 control-label">{{ Lang::get('general.bank_name') }}</label>
                    <div class="col-sm-9">
                        <input name="emri_bankes" class="form-control" id="emri_bankes" placeholder="{{ Lang::get('general.bank_name') }}" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="pershkrimi" class="col-sm-3 control-label">{{ Lang::get('general.description_fee') }}</label>
                    <div class="col-sm-9">
                        <textarea name="pershkrimi" class="form-control" id="pershkrimi" placeholder="{{ Lang::get('general.description_fee') }}"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tipi" class="col-sm-3 control-label">{{ Lang::get('general.feetype') }}</label>
                    <div class="col-sm-9">
                        {{ Form::select('tipi', Enum::getLlojetPagesave(),current(Enum::getLlojetPagesave()),array('class'=>'form-control','id'=>"tipi")) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="shuma" class="col-sm-3 control-label">{{ Lang::get('general.sum') }}</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input name="shuma" class="form-control" id="shuma" placeholder="{{ Lang::get('general.sum') }}" type="text">
                            <span class="input-group-addon"><span class='fa fa-euro fa-lg'></span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('general.close') }}</button>
                <button type="submit" class="btn btn-primary">{{ Lang::get('general.register') }}</button>
            </div>
        </div>
    </div>
</div>
</form>
@stop

@section('list_fee')

<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">{{ Lang::get('general.list_fee') }}</div>

    <!-- Table -->
    <table class="table">
        <tr>
            <th>#</th>
            <th>{{ Lang::get('general.payer') }}</th>
            <th>{{ Lang::get('general.bank_name') }}</th>
            <th>{{ Lang::get('general.description_fee') }}</th>
            <th>{{ Lang::get('general.feetype') }}</th>
            <th>{{ Lang::get('general.sum') }}</th>
            <th>{{ Lang::get('general.registred') }}</th>
        </tr>
        @foreach($pagesat as $value)
        <tr>
            <td>{{ $value['paguesi']}}</td>
            <td>{{ " (<b>".Enum::convertUID($value['paguesi'])."</b>) " }}</td>
            <td>{{ $value['emri_bankes'] }}</td>
            <td>{{ $value['pershkrimi'] }}</td>
            <td>{{ $value['tipi'] }}</td>
            <td>{{ $value['shuma'] }}</td>
            <td>{{ $value['created_at'] }}</td>
        </tr>
        @endforeach
    </table>
</div>

@stop


@section('content')
<h2 class='text-capitalize '>{{ Lang::get('general.fee') }}</h2>
<hr>
@yield('notification')
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#fee">
    {{ Lang::get('general.register_fee') }}
</button>


@yield('register_fee')
<br>
@yield('list_fee')

@stop