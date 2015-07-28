
@extends('student.index')

@section('basicpagesat')

<div class="container  col-md-12">
    <div class="col-md-8">
        <table class="table">
            <tr>
                <th>

            <div class="col-sm-2">
                {{ Lang::get('general.sum') }}
            </div>
            <div class="col-sm-5">
                {{ Lang::get('general.description_bill') }}
            </div>
            <div class="col-sm-5">
                {{ Lang::get('general.bill_registered') }}
            </div>   
            </th>
            </tr>
            @foreach($pagesat as $value)
            <tr>
                <td>
                    <div class="col-sm-2">
                        {{ $value['shuma'] }}&nbsp; <span class="fa fa-eur "></span>
                    </div>
                    <div class="col-sm-5">
                        {{ $value['pershkrimi'] }}
                    </div>
                    <div class="col-sm-5">
                        {{ $value['created_at'] }}
                    </div>   
                </td>
            </tr>         
            @endforeach
        </table>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="decbill">{{ Lang::get('general.description_bill') }}</label>
            <textarea class="form-control" id="decbill" name="pershkrimi" rows="3"></textarea>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <input id="checkbox-pagesa" type="checkbox" name="pagesa" value="default">
                </div>
                <input id="input-pagesa" class="form-control" type="text" name="pagesa"  style="font-weight: bold;">
                <div class="input-group-addon">
                    <span class="fa fa-eur"></span>
                </div>
            </div>
        </div>
        <div class="pager form-group">
            <input class="btn btn-primary" type="submit" name="pagesatsub" value="{{Lang::get('general.register')}}">
        </div>
    </div>
</div>
@stop

@section('pagesat')
<div class="panel panel-default">
    <div class="panel-body">
        <a href="#" id="print_pagesa">
            <span class="fa fa-print fa-2x"></span>
        </a>
        <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$totali['perqindja']}}%;">
                {{$totali['perqindja']}}% <b>( {{ $totali['paguara'] }} <span class="fa fa-eur"></span> / {{ $kontrata }} <span class="fa fa-eur "></span> )</b>
            </div>
            <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: {{ 100-$totali['perqindja']}}%">
                <b>{{ $kontrata - $totali['paguara'] }} <span class="fa fa-eur"></span></b> 
            </div>
        </div>

        {{ Form::open(array('url'=>'/smps/admin/person/'.$profile->uid.'/pagesa','method'=>'POST', 'class'=>'form-horizontal','id'=>'form3pagesa','role'=>'form','name'=>'form3pagesa')) }}

        @yield('basicpagesat')

        {{ Form::close() }}

    </div>
</div>

@stop
