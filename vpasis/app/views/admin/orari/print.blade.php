@extends('printa4v')

@section('content')

<h4>{{ Lang::get('printable.school_hours') }}</h4>
<style>
    notat,
    notat tr th,
    notat tr td{
        border:1px solid #000;
    }
    .notat tr td,
    .notat tr th{padding:10px;}

</style>
<table class="notat" style="width:100%; border:1px solid #000; border-collapse: collapse;" >
    <tr>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.day')}}</th>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.course')}}</th>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.professor')}}</th>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.hour')}}</th>
    </tr>
    @foreach($orari as $value)
    <tr>

        <td style="border:1px solid #000; padding:10px;">{{ Enum::convertday($value['dita']) }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['Lenda'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['Prof'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['ora'] }}</td>
    </tr>
    @endforeach
</table>
@stop