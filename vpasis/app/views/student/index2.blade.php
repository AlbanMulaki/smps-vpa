@extends('student.index')


@section('basicpagesat')

<table class="table">
    <tr>
        <th>
            {{ Lang::get('general.sum') }}
        </th>
        <th>
            {{ Lang::get('general.description_bill') }}
        </th>
        <th>
            {{ Lang::get('general.paguarme') }}
        </th>   

    </tr>
    @foreach($pagesat as $value)
    <tr>
        <td>
            {{ $value['shuma'] }}&nbsp; <span class="fa fa-eur "></span>
        </td>
        <td>
            {{ $value['pershkrimi'] }}
        </td>
        <td>
            {{ $value['cr'] }}
        </td>
        </td>
    </tr>         
    @endforeach
</table>
@stop

@section('pagesat')
<div class="panel panel-default">
    <div class="panel-body">
        <a href="{{action('StudentController@getPrintNotat')}}" target="_blank" id="print_pagesa">
            <span class="fa fa-print fa-2x"></span>
        </a>
        <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$totali['perqindja']}}%;">
                {{"";printf('%.0f',$totali['perqindja']) }}% <b>( {{ $totali['paguara'] }} <span class="fa fa-eur"></span> / {{ $kontrata }} <span class="fa fa-eur "></span> )</b>
            </div>
            <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: {{ 100-$totali['perqindja']}}%">
                <b>{{ $kontrata - $totali['paguara'] }} <span class="fa fa-eur"></span></b> 
            </div>
        </div>
        @yield('basicpagesat')


    </div>
</div>
@stop


@section('slider')

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">



    <!-- Indicators -->
    <ol class="carousel-indicators">
        @for($i=0; $i < count($post); $i++)
        <li data-target="#carousel-example-generic" data-slide-to="{{ $i }}" class="active"></li>
        @endfor
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        {{ "";$i=1;}}
        @foreach($post as $value)

        @if($i == 1)
        <div class="item active">
            <center>
                <a href="{{ action('WebsiteController@getPost')}}/{{ $value['id'] }}">
                    <img class="img-responsive" data-src="holder.js/100x180" src="http://www.vpa-uni.com/img{{ $value['img'] }}" alt="...">
                </a>
            </center>
        </div>
        {{ "";$i=null;}}

        @else 
        <div class="item">
            <center>
                <a href="{{ action('WebsiteController@getPost')}}/{{ $value['id'] }}">
                    <img class="img-responsive" data-src="holder.js/100%x180"  src="http://www.vpa-uni.com/img{{ $value['img'] }}" alt="...">
                </a>
            </center>
        </div>
        @endif
        @endforeach
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
@stop

@section('content')
{{ $zgjedhore }} 
<div class='col-md-12 container'>
    {{ Session::get('notification')}}
    <div class='col-md-8'>
        <div class='col-md-offset-1 col-md-10'>
            @yield('slider')
        </div>
        <div class='col-md-2'><br></div>
        <div class='col-md-12'>
            <div class="panel-group" id="accordion">

                @foreach($njoftimet as $value)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse"  href="#news{{ $value['idnjoftimet'] }}">
                                {{ $value['titulli']}}
                            </a> 
                            <span class="badge" >{{ $value['data'] }}</span>
                        </h4>
                    </div>

                    <div id="news{{ $value['idnjoftimet'] }}" class="panel-collapse collapse
                         @if($i <= 2)
                         in
                         {{ "";$i++ }}
                         @endif

                         ">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4 col-md-2">

                                    <a href="#" class="thumbnail">
                                        <img data-src="holder.js/60%x60" src="{{ $destination }}{{$value['avatar']}}" alt="...">
                                    </a>

                                    <span class='badge bg-info' >{{ $value['Autori'] }}</span>
                                </div>
                                {{ $value['msg'] }}
                            </div>
                        </div>
                    </div>
                </div> 
                @endforeach
            </div>
        </div>
    </div>

    <div class='col-md-4'>
        <div class="table-responsive">
            {{ $orari }}
        </div>
        <div class='table-responsive'>
            @yield('pagesat')
        </div>

    </div>

</div>

@stop