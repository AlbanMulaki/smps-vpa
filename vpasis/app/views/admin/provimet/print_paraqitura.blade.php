@extends('printa4v')

@section('content')
<table style='width:100%;'>
    <tr>
        <th>#</th>
        <th>Studenti</th>
        <th>ID</th>
        <th>Grupi</th>
        <th>{{ Lang::get('general.present')}}</th>
    </tr>
    <tr>
        <td colspan='5'><hr></td>
    </tr>
    @foreach($paraqitja as $value)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $value->studenti }}</td>
        <td>{{ $value->uid }}</td>
        <td>Grupi A</td>
        <td><input type='checkbox'></td>
    </tr>
    @endforeach
</table>
@stop