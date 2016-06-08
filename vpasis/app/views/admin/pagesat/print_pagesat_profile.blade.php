@extends('printa4v')


@section('content')


<table class='list'>
    <tr class='head' style="font-size: 13px;">
        <th>#</th>
        <th>{{ Lang::get('general.bank_name') }}</th>
        <th>{{ Lang::get('general.description_fee') }}</th>
        <th>{{ Lang::get('general.feetype') }}</th>
        <th>{{ Lang::get('general.sum') }}</th>
        <th>{{ Lang::get('general.registred');$numFee=0 }}</th>
    </tr>

    @foreach($pagesat as $value)
    <tr class='head' style='background:#fff; font-weight: 100;'>
        <td>{{ ++$numFee}}</td>
        <td>{{ $value['emri_bankes'] }}</td>
        <td>{{ $value['pershkrimi'] }}</td>
        <td>{{ Enum::convertLlojetPagesave($value['tipi']) }}</td>
        <td>{{ $value['shuma'];$shumaPaguar = $shumaPaguar + $value['shuma'] }} €</td>
        <td>{{ $value['created_at'] }}</td>
    </tr>
    @endforeach
    <tr class="foot">
        <td colspan="3"> </td>
        <td>{{ Lang::get('general.total_sum') }}</td>
        <td colspan="2">{{ $shumaPaguar }} €</td>
    </tr>
</table>

@stop