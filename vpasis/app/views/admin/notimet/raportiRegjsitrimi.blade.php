@extends('printa4v')

@section('content')


<h4>{{ Lang::get('printable.report_grades') }}</h4>
<style>
    notat,
    notat tr th,
    notat tr td{
        border:1px solid #000;
    }
    .notat tr td,
    .notat tr th{padding:10px;}

</style>

{{ Lang::get('general.professor')}} : {{ $raporti[0]['Prof'] }}<br>

{{ Lang::get('general.course')}} : {{ $raporti[0]['Lendet'] }}<br>
{{ $raporti[0]['idraportit'] }}
<table class="notat" style="width:100%; border:1px solid #000; border-collapse: collapse;" >
    <tr>
        <th style="border:1px solid #000; padding:10px;">#</th>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.student')}}</th>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.uid')}}</th>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.grade')}}</th>
    </tr>
    @foreach($raporti as $value)
    <tr>

        <td style="border:1px solid #000; padding:10px;">{{ $i++ }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['Student'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['Suid'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['nota'] }}</td>
    </tr>
    @endforeach
</table>
@stop