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
        <td>&nbsp; - {{ $person['vendlindja'] }}</td>
        <td>&nbsp; - {{ $person['datalindjes'] }}</td>
        <td>&nbsp; - @if($person['gjinia'] == Enum::femer)
            {{ Lang::get('general.female') }}
            @else
            {{ Lang::get('general.male') }}
            @endif

        </td>
        <td>&nbsp;  {{ $person['nrpersonal'] }}</td>
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
        <td colspan="3">&nbsp;  {{ $person['telefoni'] }}</td>
        <td colspan="2">&nbsp;  {{ $person['email'] }}</td>
    </tr>
    <tr>
        <th>{{ Lang::get('general.state') }}</th>
        <th>{{ Lang::get('general.nationality') }}</th>
        <th>{{ Lang::get('general.location') }}</th>
        <th>{{ Lang::get('general.adress') }}</th>
    </tr>
    <tr>
        <td>&nbsp;  {{ $person['shteti'] }}</td>
        <td>&nbsp;  {{ $person['kombesia'] }}</td>
        <td>&nbsp;  {{ $person['vendbanimi'] }}</td>
        <td>&nbsp;  {{ $person['adressa'] }}</td>
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
        <td colspan="1">&nbsp;  {{ $person['kualifikimi'] }}</td>
        <td colspan="1">&nbsp;  {{ $kontrata['shuma']}}</td>
        <td colspan="3">&nbsp;  {{ $kontrata['pershkrimi'] }}</td>
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
        <td>&nbsp;  {{ $person['uid']}}</td>
        <td>&nbsp;  Default eshte nga leternjoftimi</td>
        <td>&nbsp;  http://www.vpa-uni.com/smps/</td>
    </tr>

</table>
<br>
<hr>
<br><br>
<div style='font-size:9px;'>
    <center><h5><b>Neni 1</b></h5></center>
    <p>
        {{ Lang::get('printable.l1') }}
    </p>
    <br>
    <center><h5><b>Neni 2</b></h5></center>
    <p>
        {{ Lang::get('printable.l2') }}
    </p><br>
    <center><h5><b>Neni 3</b></h5></center>
    <p>
        {{ Lang::get('printable.l3') }}
    </p><br>
    <center><h5><b>Neni 4</b></h5></center>
    <p>
        {{ Lang::get('printable.l4',array('shuma'=>$kontrata['shuma'] )) }}
    </p>
    <center><h5><b>Neni 5</b></h5></center>
    <p>
        {{ Lang::get('printable.l5') }}
    </p><br>

    <center><h5><b>Neni 6</b></h5></center>
    <p>
        {{ Lang::get('printable.l6') }}
    </p><br>
</div>
<div style='font-size:9px;'>
    <center><h5><b>Neni 7</b></h5></center>
    <p>
        {{ Lang::get('printable.l7') }}
    </p><br>

    <center><h5><b>Neni 8</b></h5></center>
    <p>
        {{ Lang::get('printable.l8') }}
    </p><br>
    <center><h5><b>Neni 9</b></h5></center>
    <p>
        {{ Lang::get('printable.l9') }}
    </p><br>
    <center><h5><b>Neni 10</b></h5></center>
    <p>
        {{ Lang::get('printable.l10') }}
    </p><br>
    <center><h5><b>Neni 11</b></b></h5></center>
    <p>
        {{ Lang::get('printable.l11') }}
    </p><br>
    <center><h5><b>Neni 12</b></h5></center>
    <p>
        {{ Lang::get('printable.l12') }}
    </p><br>
    <center><h5><b>Neni 13</b></h5></center>
    <p>
        {{ Lang::get('printable.l13') }}
    </p><br>
    <center><h5><b>Neni 14</b></h5></center>
    <p>
        {{ Lang::get('printable.l14') }}
    </p><br>
    <center><h5><b>Neni 15</b></h5></center>
    <p>
        {{ Lang::get('printable.l15') }}
    </p><br>

    <center><h5><b>Neni 16</b></h5></center>
    <p>
        {{ Lang::get('printable.l16') }}
    </p><br>
</div>


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

