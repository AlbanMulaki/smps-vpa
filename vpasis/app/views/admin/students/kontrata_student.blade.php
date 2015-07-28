@extends('printa4v')


@section('content')

<div class='right'>
    <strong>{{ Lang::get('printable.date') }}: {{ date('d-m-Y') }} - Ferizaj</strong> 
</div>
<p>
<h3>{{ Lang::get('printable.title_contract_studies') }}</h3>
<div>
    {{ Lang::get('printable.con_reg_p2') }}:
</div>
{{ Lang::get('printable.con_reg_p1') }}
</p>
<table class='list'>
    <tbody>
        <tr>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ Lang::get('general.name') }}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ $profile['emri'] }}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ Lang::get('general.surname') }}</td>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ $profile['mbiemri'] }}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ Lang::get('general.birthdate') }}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ $profile['datalindjes']}}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ Lang::get('general.birthplace') }}</td>
            <td style='border: 1px solid #000; padding-left:5px;'>{{  $profile['vendlindja'] }}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ Lang::get('general.adress') }}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ $profile['adressa'] }}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ Lang::get('general.phone') }}</td>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ $profile['telefoni'] }}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ Lang::get('general.status_studies') }}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ Enum::convertstatusi($profile['statusi']) }}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ Lang::get('general.email') }}</td>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ $profile['email'] }}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ Lang::get('general.qualification') }}</td>
            <td colspan='3' style='border: 1px solid #000; padding-left: 5px;'>{{ $profile['kualifikimi'] }}</td>

        </tr>
        <tr>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ Lang::get('general.faculty') }}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ Enum::convertdrejtimi($profile['drejtimi']) }}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ Lang::get('general.subject') }}</td>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ Enum::convertdrejtimi($profile['drejtimi']) }}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ Lang::get('general.name_dad') }}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ $profile['emri_prindit'] }}</td>
            <td style='border: 1px solid #000; padding-left: 5px;'>{{ Lang::get('general.surname_dad') }}</td>
            <td style='border: 1px solid #000; padding-left:5px;'>{{ $profile['mbiemri_prindit'] }}</td>
        </tr>
    </tbody>
</table>
<br><br>
<center><strong>{{ Lang::get('printable.law') }} 1</strong></center>{{ Lang::get('printable.l1') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 2</strong></center>{{ Lang::get('printable.l2') }}<br><br>
<center><strong><br><br>{{ Lang::get('printable.law') }} 3</strong></center>{{ Lang::get('printable.l3') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 4</strong></center>{{ Lang::get('printable.l4',array('shuma'=>$profile['kontrata_pageses'])) }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 5</strong></center>{{ Lang::get('printable.l5') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 6</strong></center>{{ Lang::get('printable.l6') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 7</strong></center>{{ Lang::get('printable.l7') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 8</strong></center>{{ Lang::get('printable.l8') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 9</strong></center>{{ Lang::get('printable.l9') }}<br><br>
<center><strong><br><br><br><br>{{ Lang::get('printable.law') }} 10</strong></center>{{ Lang::get('printable.l10') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 11</strong></center>{{ Lang::get('printable.l11') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 12</strong></center>{{ Lang::get('printable.l12') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 13</strong></center>{{ Lang::get('printable.l13') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 14</strong></center>{{ Lang::get('printable.l14') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 15</strong></center>{{ Lang::get('printable.l15') }}<br><br>
<center><strong>{{ Lang::get('printable.law') }} 16</strong></center>{{ Lang::get('printable.l16') }}<br><br>
<table style="width:100%;">
    <tbody>
        <tr>
            <td style="width:50%;">{{ Lang::get('general.for_vpa') }}</td>
            <td style="width:50%;"><div  class="right">{{ Lang::get('general.student') }}</div></td>
        </tr>
        <tr>
            <td style="width:50%;">____________________________</td>
            <td style="width:50%;"><div  class="right">____________________________</div></td>
        </tr>
    </tbody>
</table>
@stop