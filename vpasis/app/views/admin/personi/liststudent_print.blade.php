@extends('printa4v')

@section('content')
<center>
    <h2>    Lista studenteve te vitit akademik </h2>
</center>
<table style='width:100%;'>
    <tr>
        <th>#</th>
        <th>Studenti</th>
        <th>Semestri</th>
        <th>Drejtimi</th>
    </tr>
    @foreach($student as $val)
    <tr>
        <td>{{ $val['uid']}} </td>
        <td>{{ $val['emri'] }} {{ $val['mbiemri'] }}</td>
        <td>{{ $val['semestri']}} </td>
        <td>{{ $val['Emri']}} </td>
    </tr>
    @endforeach
</table>
@stop