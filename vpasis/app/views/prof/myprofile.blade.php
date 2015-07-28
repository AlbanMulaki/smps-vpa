@extends('prof.index')

@section('content')
<div class='container'>
    <div class='col-md-2'>


        {{ HTML::image("smpsfile/avatar".$prof['avatar'],null,['width'=>'200','class'=>'img-thumbnail']) }}

    </div>
    <div class='col-md-4' >
        <div class='row'>
            <label>{{ Lang::get('general.id')}}:</label> {{ $prof['uid'] }}
        </div>
        <div class='row'>
            <label>{{ Lang::get('general.name')}}:</label> {{ $prof['emri'] }}
        </div>
        <div class='row'>
            <label>{{ Lang::get('general.surname')}}:</label> {{ $prof['mbiemri'] }}
        </div>
        <div class='row'>
            <label>{{ Lang::get('general.birthplace')}}:</label> {{ $prof['vendlindja']}}
        </div>
        <div class='row'>
            <label>{{ Lang::get('general.location')}}:</label> {{ $prof['vendbanimi'] }}
        </div>
        <div class='row'>
            <label>{{ Lang::get('general.phone')}}:</label> {{ $prof['telefoni'] }}
        </div>
        <div class='row'>
            <label>{{ Lang::get('general.email')}}:</label> {{ $prof['email'] }}
        </div>
    </div>
    <div class='col-md-4'><label>{{ Lang::get('general.list_course')}}</label>
        <blockquote>
            @foreach($lendet as $val)
            <div class='row'>
                {{ $val['Emri'] }}
                @if($val['active'] == Enum::active)
                <span class='fa fa-circle' style='color:#00cc00;'></span>
                @else 
                <span class='fa fa-circle'></span>
                @endif
            </div>
            @endforeach
        </blockquote>
    </div>
</div>
@stop