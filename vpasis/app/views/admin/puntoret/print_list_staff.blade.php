@extends('printa4v')


@section('content')

<table class='list'>
    <tbody>
        <tr class='head'>
            <td>#</td>
            <td>{{ Lang::get('general.name')." ".Lang::get('general.surname') }}</td>
            <td>{{ Lang::get('general.email') }}</td>
            <td>{{ Lang::get('general.phone') }}</td>
            <td>{{ Lang::get('general.science_grade') }}</td>
            <td>{{ Lang::get('general.position_office') }}</td>
        </tr>
        @foreach($listStaff as $value)
        <tr class='head' style='background:#fff;'>
            <td>{{ $value['uid'] }}</td>
            <td>{{ $value['emri'].' '.$value['mbiemri'] }}</td>
            <td>{{ $value['email'] }}</td>
            <td>{{ $value['telefoni'] }}</td>
            <td>{{ Enum::convertgrade($value['grada_shkencore']) }}</td>
            <td>{{ Enum::convertDetyra($value['detyra']) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop