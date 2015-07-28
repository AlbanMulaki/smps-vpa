@extends('printa4v')
@section('content')
<p>{{ Lang::get('printable.prof_contrat_p1')}}</p>


<table style="width:100%;">
    <tr>
        <th colspan="3"  style="border-bottom:#e1e1e1 1px solid;">
            {{ Lang::get('general.personale') }}<br>
        </th>
    </tr>
    <tr>
        <th>{{ Lang::get('general.name') }}</th>
        <th>{{ Lang::get('general.surname') }}</th>
        <th>{{ Lang::get('general.gender') }}</th>
    </tr>
    <tr>
        <td>&nbsp; - {{ $person['emri'] }}</td>
        <td>&nbsp; - {{ $person['mbiemri'] }}</td>
        <td>&nbsp; - @if($person['gjinia'] == Enum::femer)
            {{ Lang::get('general.female') }}
            @else
            {{ Lang::get('general.male') }}
            @endif

        </td>
    </tr>
    <tr>
        <th>{{ Lang::get('general.birthplace') }}</th>
        <th>{{ Lang::get('general.birthdate') }}</th>
        <th>{{ Lang::get('general.idpersonal') }}</th>
    </tr>
    <tr>
        <td>&nbsp; - {{ $person['vendilindjes'] }}</td>
        <td>&nbsp; - {{ $person['datalindjes'] }}</td>
        <td>&nbsp;  {{ $person['idpersonal'] }}</td>
    </tr>
</table>
<br>

<table style="width:100%;">
    <tr>
        <th colspan="3"  style="border-bottom:#e1e1e1 1px solid;">
            {{ Lang::get('general.info_adress') }}<br>
        </th>
    </tr>
    <tr>
        <th>{{ Lang::get('general.phone') }}</th>
        <th>{{ Lang::get('general.email') }}</th>
        <th>{{ Lang::get('general.state') }}</th>
    </tr>
    <tr>
        <td>&nbsp; - {{ $person['phone'] }}</td>
        <td>&nbsp; - {{ $person['email'] }}</td>
        <td>&nbsp; - {{ $person['shteti'] }}</td>
    </tr>
    <tr>
        <th>{{ Lang::get('general.location') }}</th>
        <th colspan='2'>{{ Lang::get('general.adress') }}</th>
    </tr>
    <tr>
        <td>&nbsp; - {{ $person['vendbanimi'] }}</td>
        <td colspan='2'>&nbsp; - {{ $person['adress'] }}</td>
    </tr>
</table>
<br>
<table style="width:100%;">
    <tr>
        <th colspan="3"  style="border-bottom:#e1e1e1 1px solid;">
            {{ Lang::get('general.education') }}<br>
        </th>
    </tr>
    <tr>
        <th>{{ Lang::get('general.course') }}</th>
        <th>{{ Lang::get('general.fondi_oreve') }}</th>
        <th>{{ Lang::get('general.status') }}</th>
    </tr>
    <tr>
        <td>&nbsp; - {{ $course }}</td>
        <td>&nbsp; - {{ $person['fondi_oreve'] }}</td>
        @if($person['status'] == Enum::active)
        <td>&nbsp; - {{ Lang::get('general.active') }}</td>
        @else
        <td>&nbsp; - {{ Lang::get('general.passive') }}</td>
        @endif
    </tr>
    <tr>
        <th>{{ Lang::get('general.position') }}</th>
        <th>{{ Lang::get('general.scienc_grade') }}</th>
        <th>{{ Lang::get('general.qualification') }}</th>
    </tr>
    <tr>
        <td>&nbsp; - {{ Enum::convertpozita($person['pozita']) }}</td>
        <td>&nbsp; - {{ Enum::convertgrade($person['grade']) }}</td>
        <td>&nbsp; - {{ $person['qualification'] }}</td>
    </tr>    
    <tr>
        <th>{{ Lang::get('general.sum') }}</th>
        <th>{{ Lang::get('general.credit_card') }}</th>
    </tr>      
    <tr>
        <td>&nbsp; {{ $person['shuma'] }}<span class='fa fa-eur '></span></td>
        <td>&nbsp; - {{ $person['credit_card'] }}</td>
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
        <td>&nbsp;  {{ $lastId['uid'] +1 }}</td>
        <td>&nbsp;  Default eshte nga leternjoftimi</td>
        <td>&nbsp;  http://www.vpa-uni.com/smps/</td>
    </tr>

</table>
<br>
<hr>
<br>
<br>
<center><h5>Neni 1</h5></center>
<p>
    {{ Lang::get('printable.l1') }}
</p>
<br>
<center><h5>Neni 1</h5></center>
<p>
    {{ Lang::get('printable.l1') }}
</p><br>
<center><h5>Neni 1</h5></center>
<p>
    {{ Lang::get('printable.l1') }}
</p><br>
<center><h5>Neni 1</h5></center>
<p>
    {{ Lang::get('printable.l1') }}
</p>

<table style="width:100%;">
    <tr>
        <td style="text-align:left;">
            Mesimdhenesi<br>
            _____________________
        </td>
        <td style="text-align:right; ">
            VPA<br>
            _____________________
        </td>
    </tr>
</table>
@stop

