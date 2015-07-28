@extends('printa4v')

@section('content')
<style>
    .list {
        border-collapse: collapse;
        border: 1px solid #000;

    }
    .list th,
    .list td {
        padding:5px;
        border: 1px solid #000;
    }
</style>
<center>
    <h4>{{ Lang::get('general.faculty')}} {{ $rap_notave[0]['Drejtimi'] }} - {{ Lang::get('general.semester')}} {{$rap_notave[0]['Semestri']}} </h4>
    <h2>{{ Lang::get('general.report_for_result_grade') }}</h2>
    <h5>{{ Lang::get('general.date') }} - {{ $rap_notave[0]['Data_Provimit'] }}</h5>
</center>
<div style="float:left;">
    <b> {{ Lang::get('general.course') }}:</b>{{ $rap_notave[0]['Lendet'] }}<br>
    <b> {{ Lang::get('general.professor' )}}: </b>{{ $rap_notave[0]['Prof'] }}
    
</div>

{{ Lang::get('general.confirmation') }}<br><br>
{{ Lang::get('general.referent') }}: ________________<br><br>
{{ Lang::get('general.professor') }}: ________________<br><br>
{{ Lang::get('general.office_quality')}}: ________________
<br><br>
{{ $maxrap[0]['idraportit']+1 }}
<div>{{ Lang::get('warn.info_report_grade_quality')}}</div>
<table class="list" style='width:100%;  border:solid black 1px;'>
    <tr>
        <th>#</th>
        <th style="width:20%;">{{ Lang::get('general.name') }} {{ Lang::get('general.surname') }}</th>
        <th>{{ Lang::get('general.nrindex')}}</th>
        <th>{{ Lang::get('general.test_semester')}}</th>
        <th>{{ Lang::get('general.test_semisemester')}}</th>
        <th>{{ Lang::get('general.seminar')}}</th>
        <th>{{ Lang::get('general.pjesmarrja')}}</th>
        <th>{{ Lang::get('general.practice_work')}}</th>
        <th>{{ Lang::get('general.final_test')}}</th>
        <th>{{ Lang::get('general.final_grade')}}</th>
    </tr>
    
    @foreach($rap_notave as $value) 
    <tr>
        <td>{{"";$i++}}{{ $i }}</td>
        <td>{{ $value['Studenti'] }}</td>
        <td>{{ $value['Studentiuid'] }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td>{{ $value['vijushmeria']}}</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @endforeach
    
</table>
@stop