@extends('printa4v')
@section('content')
<h4>{{ Lang::get('printable.institucion_college_name') }}</h4>
{{ Lang::get('printable.fakulteti',array('drejtimi'=>$profile['drejtimi'])) }}
<p>{{ Lang::get('printable.transkripta_p1',array('date'=>date('d-m-Y')))}}</p>
<br>
<p>{{ Lang::get('printable.transkripta_p2',array('prindi'=>$profile['emri_prindit'],
            'studenti'=>$profile['studenti'],
            'mbiemri'=>$profile['mbiemri'],
            'datalindjes'=>$profile['datalindjes'],
            'vendilindjes'=>$profile['vendlindja']
            )) 
    }}</p>
<center>
    <h4>{{ Lang::get('printable.certificate') }}</h4>
</center>
<br>

{{ ''; if($profile['statusi'] == Enum::irregullt){
$statusi = Lang::get('general.regular');
}else {
$statusi = Lang::get('general.notregular');
} 
}}
<p>{{ Lang::get('printable.transkripta_p3',array(
            'studenti'=>$profile['studenti'],
            'prindi'=>$profile['emri_prindit'],
            'mbiemri'=>$profile['mbiemri'],
            'drejtimi'=>$profile['drejtimi'],
            'semestri'=>$profile['semestri'],
            'statusi'=> $statusi
            )) }}</p>
<br>
<p>{{ Lang::get('printable.transkripta_p4') }}</p>
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
        <th style="border:1px solid #000; padding:10px;">#</th>

        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.course')}}</th>

        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.grade')}}</th>

        <th style="border:1px solid #000; padding:10px;">{{ Lang::get('general.ect')}}</th>
    </tr>
    @foreach($notat as $value)
    <tr>
        <td style="border:1px solid #000; padding:10px;">{{ ++$i }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['lendet'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['nota'] }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $value['ect'] }}</td>
    </tr>
    @endforeach
</table><br><br>
{{ Lang::get('general.referent') }} <br>
{{ $administruesi->emri  }}&nbsp;{{ $administruesi->mbiemri }}<br><br><br>
_______________________
@stop