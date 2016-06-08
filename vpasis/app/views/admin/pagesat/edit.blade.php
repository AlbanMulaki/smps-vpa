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
{{ Form::open(array('url'=>action('FeeController@postEdit'),'method'=>'POST','class'=>"form-horizontal")) }}
<input type='hidden' name='id' value='{{ $pagesa->id }}' />
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">{{ Lang::get('general.edit_fee') }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <label for="paguesi" class="col-sm-3 control-label">{{ Lang::get('general.payer') }}</label>
            <div class="col-sm-9">
                <input name="paguesi" class="form-control" id="paguesi" placeholder="{{ Lang::get('general.payer') }} ID" type="text" value="{{ $pagesa->getPaguesi->uid }}">
            </div>
        </div>
        <div class="form-group">
            <label for="emri_bankes" class="col-sm-3 control-label">{{ Lang::get('general.bank_name') }}</label>
            <div class="col-sm-9"> 
                {{ Form::select('emri_bankes',Enum::getTypeBank(),$pagesa->emri_bankes,array('class'=>'form-control')) }}

            </div>
        </div>
        <div class="form-group">
            <label for="pershkrimi" class="col-sm-3 control-label">{{ Lang::get('general.description_fee') }}</label>
            <div class="col-sm-9">
                <textarea name="pershkrimi" class="form-control" id="pershkrimi" placeholder="{{ Lang::get('general.description_fee') }}">{{ $pagesa->pershkrimi }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="tipi" class="col-sm-3 control-label">{{ Lang::get('general.feetype') }}</label>
            <div class="col-sm-9">
                {{ Form::select('tipi', Enum::getLlojetPagesave(),$pagesa->tipi,array('class'=>'form-control','id'=>"tipi")) }}
            </div>
        </div>
        <div class="form-group">
            <label for="shuma" class="col-sm-3 control-label">{{ Lang::get('general.sum') }}</label>
            <div class="col-sm-4">
                <div class="input-group">
                    <input name="shuma" class="form-control" id="shuma" placeholder="{{ Lang::get('general.sum') }}" type="text" value="{{ $pagesa->shuma }}">
                    <span class="input-group-addon"><span class='fa fa-euro fa-lg'></span></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="data" class="col-sm-3 control-label">{{ Lang::get('general.date') }}</label>
            <div class="col-sm-4">
                <input  id="data"  type="text" name="data" id="datepicker" class="datepicker input-sm form-control" value="{{ $pagesa->data }}">
            </div>
        </div>

    </div>
    <div class="box-footer text-center">
        <button type="submit" class="btn btn-warning">@lang('general.update')</button>
    </div>
    <!-- /.box-body -->
</div>
</form>
@stop


@section('title')
<section class="content-header">
    <h1>
        {{ Lang::get('general.edit_fee') }}<small>{{ $pagesa->getPaguesi->emri." ". $pagesa->getPaguesi->mbiemri }}</small>
    </h1>
</section>
@stop

@section('content')
@yield('title')

<section class='content'>
    @yield('notification')
    <div class='col-md-8 col-md-offset-2'>
        @yield('register_fee')
    </div>
</section>
@stop