@extends('admin.index')

@section('notification')


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

@stop

@section('title')
<section class="content-header">
    <h1>
        {{ Lang::get('general.academic_list') }}<small>{{ Lang::get('general.academic_list') }}</small>
    </h1>
</section>
@stop



@section('form')
<div>
    <div class='box box-default'>
        <div class='box-header with-border'>
            <h3 class="box-title">{{ Lang::get('general.assign_staff') }}</h3>
        </div>
        <div class="box-body">
            <div class='row'>
                <div class='col-md-4'>
                

                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('content')
@yield('title')

<section class='content'>
    @yield('notification')
    @yield('form')
</section>
@stop