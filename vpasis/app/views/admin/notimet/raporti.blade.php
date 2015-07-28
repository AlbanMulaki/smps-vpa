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
<table class="notat" style="width:100%; border:1px solid #000; border-collapse: collapse;" >
    <tr>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.course')}}</th>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.student')}}</th>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.professor')}}</th>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.grade')}}</th>
        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.refuse_grade')}}</th>
    </tr>
    @foreach($notimet as $value)
    <tr>

        <td style="border:1px solid #000; padding:10px;">{{ $value['Landa'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['Studenti'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['Prof'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['nota'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ Enum::convertrefuzimin($value['refuzimi']) }}</td>
    </tr>
    @endforeach
</table>
@stop