@extends('printa4v')


@section('content')
@if($drejtimi)
<div class='text-left'><b>{{ Lang::get('general.subject') }}:</b> {{ Enum::convertDrejtimi($drejtimi) }}</div> 
<div class='text-left'><b>{{ Lang::get('general.date') }}: </b> {{ date('Y-m-d')}}</div>
@endif
<table class='list'>
    <tbody>
        <tr class='head'>
            <td>#</td>
            <td>{{ Lang::get('general.name')." ".Lang::get('general.surname') }}</td>
            <td>{{ Lang::get('general.email') }}</td>
            <td>{{ Lang::get('general.phone') }}</td>
            <td>{{ Lang::get('general.gender') }}</td>
            <td>{{ Lang::get('general.registred_date') }}</td>
        </tr>
        @foreach($students as $value)
        <tr class='head' style='background:#fff;'>
            <td>{{ $value['uid'] }}</td>
            <td>{{ $value['emri'].' '.$value['mbiemri'] }}</td>
            <td>{{ $value['email'] }}</td>
            <td>{{ $value['telefoni'] }}</td>
            <td>{{ Enum::convertGjinia($value['gjinia']) }}</td>
            <td>{{ substr($value['created_at'],0,10) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop