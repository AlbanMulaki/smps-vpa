@extends('printa4v')



@section('content')
<table class="list">
    <tbody>
        <tr>
            <td>{{ Lang::get('general.department')}}: <strong>{{ $departmenti[0]['Emri'] }}</strong></td>
        </tr>
        <tr>
            <td>{{ Lang::get('general.profile')}}: <strong>{{ $drejtimi[0]['Emri'] }}</strong></td>
        </tr>
    </tbody>
</table>

<table class="list" style="width: 99%; margin-top: 1em;">
    <tbody>
        <tr class="head">
            <td> #</td>
            <td class="center" style="width: 70%">Lëndët</td>
            <td style="width: 5%">Zgjedhore</td>
            <td class="center" style="width: 25%">ECT</td>
        </tr>
        {{ "";$semestriCount=0 }}
        {{"";$count=1}}
        {{"";$crs=0}}
        @foreach($lendet as $value)
        {{"";$crs++ }}
        @if($value['Semestri'] != $semestriCount)
        <tr class='head'>
            <td colspan="5" class='center'><strong>{{ Lang::get('general.semester')." - ".$value['Semestri'] }}</strong></td>
        </tr>
        {{ "";$semestriCount = $value['Semestri'] }}

        {{"";$count=1}}
        @endif
        <tr>
            <td class="center">{{ $count++  }}</td>
            <td>{{ $value['Emri'] }}</td>
            @if($value['Zgjedhore'] == Enum::zgjedhore)
            <td>Z</td>
            @else
            <td>O</td>
            @endif
            <td class="center">{{ $value['Ect'] }}</td>
        </tr>
        @endforeach

        <tr class='foot'>
            <td  colspan='5' class='center'><strong>{{ Lang::get('general.all_ect')." - 180" }}</strong></td>
        </tr>
    </tbody>
</table>

@stop
