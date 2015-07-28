@extends('printa4v')
@section('content')
<h4>{{ Lang::get('printable.title_certificate_bill') }}</h4>
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
        <th style="border:1px solid #000; padding:10px;">#</th>

        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.sum')}}</th>

        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.description_bill')}}</th>

        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.date')}}</th>
    </tr>
    @foreach($pagesat as $value)
    <tr>
        <td style="border:1px solid #000; padding:10px;">{{ ++$i }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['shuma'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['pershkrimi'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['created_at'] }}</td>
    </tr>
    @endforeach
</table>
@stop