@extends('printa4v')

@section('notimet')
<table class='table list table-responsive table-bordered'>
    <tr class='head'>
        <th>#</th>
        <th>{{ Lang::get('general.course') }}</th>
        <th>{{ Lang::get('general.grade') }}</th>
        <th>{{ Lang::get('general.lecturer') }}</th>
        <th>{{ Lang::get('general.ect') }}</th>
    </tr>
    <?php
    $i = 0;
    ?>
    @foreach($notimet as $value)
    <?php
    $i++;
    ?>
    @if(($value->refuzim == Enum::YES || $value->nota == 5) && $value->raportiNotave->locked == Enum::locked)

    @else
    <tr style='background:#fff;'>
        <td> {{ $i }} </td>
        <td> {{ $value->raportiNotave->lendet->Emri }}</td>
        @if($value->nota == 4)
        <td>E Padefinuar</td>
        @else
        <td>{{ $value->nota }}</td>
        @endif
        <td>{{ $value->raportiNotave->administrata->emri. " ".$value->raportiNotave->administrata->mbiemri  }}</td>
        <td>{{ $value->raportiNotave->lendet->Ect }}</td>
    </tr>
    @endif
    @endforeach
</table>
@stop


@section('content')
@yield('notimet')
@stop