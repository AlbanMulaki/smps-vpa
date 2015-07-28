
<tr>
    <th colspan="6" class="text-center"> {{ Lang::get('general.ligjeratat')}}</th>
</tr>
@foreach($ligjeratat as $value)
<tr>
    <td>{{$i++}}</td>
    <td>{{ $value['Titulli'] }}</td>
    <td>{{ $value['data'] }}</td>
    <td>{{ sprintf('%.1f',$value['size']/1000) }} MB</td>
    <td><a href="/smpsfile/ligjeratat/{{ $value['Session'] }}/{{ $value['idl'] }}{{$value['Attachname'] }}" target="_blank"> {{ Lang::get('general.download')}} <span class="fa fa-file-pdf-o"></span></a></td>
   
</tr>


@endforeach
<tr>
    <th colspan="6" class="text-center"> {{ Lang::get('general.ushtrime')}}</th>
</tr>
@foreach($ushtrime as $value)
<tr>
    <td>{{$j++}}</td>
    <td>{{ $value['Titulli'] }}</td>
    <td>{{ $value['data'] }}</td>
    <td>{{ sprintf('%.2f',$value['size']/1000) }} MB</td>
    <td><a href="/smpsfile/ligjeratat/{{ $value['Session'] }}/{{ $value['idl'] }}{{$value['Attachname'] }}" target="_blank"> {{ Lang::get('general.download')}} <span class="fa fa-file-pdf-o"></span> </a></td>
    </tr>
@endforeach
