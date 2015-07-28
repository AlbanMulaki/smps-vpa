@extends('printa4v')

@section('content')
<table style='width:100%;'>
    <tr>
        <th>#</th>
        <th>{{ Lang::get('general.course')}}</th>
        <th>{{ Lang::get('general.professor')}}</th>
        <th>{{ Lang::get('general.date')}}</th>
    </tr>
    <tr>
        <td colspan='5'><hr></td>
    </tr>
    {{ "";$last = null}}
    @foreach($provimet as $value) 
    @if($value['Sem'] == $last)

    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $value->Lenda }}</td>
        <td>{{ $value->Prof }}</td>
        <td>{{ $value->data }}</td>
    </tr>

    @else
    <tr>
        <td>----</td>
        <td>-------</td>
        <td>----</td>
        <td>-----</td>
    </tr>

    @endif

    {{ "";$last=$value['Sem'] }}
    @endforeach
</table>
@stop