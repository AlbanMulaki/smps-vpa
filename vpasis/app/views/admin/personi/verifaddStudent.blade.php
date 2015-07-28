@extends('printa4v')
@section('content')
<p>{{ Lang::get('printable.con_reg_p1')}}</p>


<table style="width:100%;">
    <tr>
        <th colspan="4"  style="border-bottom:#e1e1e1 1px solid;">
            {{ Lang::get('general.personale') }}<br>
        </th>
    </tr>
    <tr>
        <th>{{ Lang::get('general.name') }}</th>
        <th>{{ Lang::get('general.surname') }}</th>
        <th>{{ Lang::get('general.dad_name') }}</th>
        <th>{{ Lang::get('general.dad_surname') }}</th>
    </tr>
    <tr>
        <td>&nbsp; - {{ $person['emri'] }}</td>
        <td>&nbsp; - {{ $person['mbiemri'] }}</td>
        <td>&nbsp; - {{ $person['emri_prindit'] }}</td>
        <td>&nbsp; - {{ $person['mbiemri_prindit'] }}</td>
    </tr>
    <tr>
        <th>{{ Lang::get('general.birthplace') }}</th>
        <th>{{ Lang::get('general.birthdate') }}</th>
        <th>{{ Lang::get('general.gender') }}</th>
        <th>{{ Lang::get('general.idpersonal') }}</th>
    </tr>
    <tr>
        <td>&nbsp; - {{ $person['vendilindjes'] }}</td>
        <td>&nbsp; - {{ $person['datalindjes'] }}</td>
        <td>&nbsp; - @if($person['gjinia'] == Enum::femer)
            {{ Lang::get('general.female') }}
            @else
            {{ Lang::get('general.male') }}
            @endif

        </td>
        <td>&nbsp;  {{ $person['idpersonal'] }}</td>
    </tr>
</table><br>
<table  style="width:100%;">
    <tr>
        <th colspan="5"   style="border-bottom:#e1e1e1 1px solid;">
            {{ Lang::get('general.info_adress') }}<br>
        </th>
    </tr>
    <tr>
        <th colspan="3">{{ Lang::get('general.phone') }}</th>
        <th colspan="2">{{ Lang::get('general.email') }}</th>

    </tr>    

    <tr>
        <td colspan="3">&nbsp;  {{ $person['phone'] }}</td>
        <td colspan="2">&nbsp;  {{ $person['email'] }}</td>
    </tr>
    <tr>
        <th>{{ Lang::get('general.state') }}</th>
        <th>{{ Lang::get('general.nationality') }}</th>
        <th>{{ Lang::get('general.location') }}</th>
        <th>{{ Lang::get('general.adress') }}</th>
    </tr>
    <tr>
        <td>&nbsp;  {{ $person['shtetas'] }}</td>
        <td>&nbsp;  {{ $person['nacionaliteti'] }}</td>
        <td>&nbsp;  {{ $person['vendbanimi'] }}</td>
        <td>&nbsp;  {{ $person['adress'] }}</td>
    </tr>
</table>
<br>
<table  style="width:100%;">
    <tr>
        <th colspan="5"   style="border-bottom:#e1e1e1 1px solid;">
            {{ Lang::get('general.education') }}<br>
        </th>
    </tr>
    <tr>
        <th>{{ Lang::get('general.profile') }}</th>
        <th>{{ Lang::get('general.level') }}</th>
        <th>{{ Lang::get('general.status') }}</th>
        <th>{{ Lang::get('general.transfer') }}</th>

    </tr>    

    <tr>
        <td>&nbsp;  {{ $drejtimi }}</td>
        <td>&nbsp;  {{ $level }}</td>
        <td>&nbsp;  {{ $statusi }}</td>
        @if(isset($person['transfer']))
        <td>&nbsp;  PO</td>
        @else
        <td>&nbsp;  JO</td>
        @endif
    </tr>
    <tr>
        <th>Edukimi</th>
    </tr>    
    <tr>
        <td>{{ $person['qualification'] }}</td>
    </tr>
    <tr>
        <th colspan="1">{{ Lang::get('general.semester') }}</th>
        <th colspan="1">{{ Lang::get('general.sum') }}</th>
        <th colspan="3">{{ Lang::get('general.description_contrat') }}</th>

    </tr>    

    <tr>
        <td colspan="1">&nbsp;  {{ $person['semester'] }}</td>
        <td colspan="1">&nbsp;  {{ $person['shuma'] }}</td>
        <td colspan="3">&nbsp;  {{ $person['desccont'] }}</td>
    </tr>

</table>
<br>
<table  style="width:100%;">
    <tr>
        <th colspan="3"   style="border-bottom:#e1e1e1 1px solid;">
            {{ Lang::get('general.online_supp') }}<br>
        </th>
    </tr>
    <tr>
        <th>{{ Lang::get('general.id') }}</th>
        <th>{{ Lang::get('general.password') }}</th>
        <th>{{ Lang::get('general.smps') }}</th>

    </tr>    

    <tr>
        <td>&nbsp;  {{ $lastId }}</td>
        <td>&nbsp;  Default eshte nga leternjoftimi</td>
        <td>&nbsp;  http://www.vpa-uni.com/smps/</td>
    </tr>

</table>
<br>
<hr>
<br><br>
<style>
    .nenet th{text-align: center;}
</style><br><br>
<table class='nenet' style='font-size:9px;'>
    <tr>
        <th>Neni 1</th>
        <th>Neni 9</th>
    </tr>
    <tr>
        <td>    
            {{ Lang::get('printable.l1') }}
        </td>
        <td>
            {{ Lang::get('printable.l9') }}
        </td>
    </tr>
    <tr>
        <th>Neni 2</th>
        <th>Neni 10</th>
    </tr>
    <tr>
        <td>{{ Lang::get('printable.l2') }}</td>
        <td>{{ Lang::get('printable.l10') }}</td>
    </tr>
    <tr>
        <th>Neni 3</th>
        <th>Neni 11</th>
    </tr>
    <tr>
        <td>{{ Lang::get('printable.l3') }}</td>
        <td>{{ Lang::get('printable.l11') }}</td>
    </tr>
    <tr>
        <th>Neni 4</th>
        <th>Neni 12</th>
    </tr>
    <tr>
        <td>{{ Lang::get('printable.l4') }}</td>
        <td>{{ Lang::get('printable.l12') }}</td>
    </tr>
    <tr>
        <th>Neni 5</th>
        <th>Neni 13</th>
    </tr>
    <tr>
        <td>{{ Lang::get('printable.l5') }}</td>
        <td>{{ Lang::get('printable.l13') }}</td>
    </tr>
    <tr>
        <th>Neni 6</th>
        <th>Neni 14</th>
    </tr>
    <tr>
        <td>{{ Lang::get('printable.l6') }}</td>
        <td>{{ Lang::get('printable.l14') }}</td>
    </tr>
    <tr>
        <th>Neni 7</th>
        <th>Neni 15</th>
    </tr>
    <tr>
        <td>{{ Lang::get('printable.l7') }}</td>
        <td>{{ Lang::get('printable.l15') }}</td>
    </tr>
    <tr>
        <th>Neni 8</th>
        <th>Neni 16</th>
    </tr>
    <tr>
        <td>{{ Lang::get('printable.l8') }}</td>
        <td>{{ Lang::get('printable.l16') }}</td>
    </tr>
</table>


<table style="width:100%; font-size:11px;">
    <tr>
        <td style="text-align:left;  font-size:11px;">
            {{ Lang::get('general.referent') }}<br>
            _____________________
        </td>
        <td style="text-align:right;  font-size:11px;">
            {{ Lang::get('general.student') }}<br>
            _____________________
        </td>
    </tr>
</table>
@stop

