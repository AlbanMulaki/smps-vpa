@extends('printa4v')


@section('listStudent')
<table class='list'>
    <tbody>
        <tr class='head'>
            <td>#</td
            <td>{{ Lang::get('general.student') }}</td>
            <td>{{ Lang::get('general.test_semester') }}</td>
            <td>{{ Lang::get('general.test_semisemester') }}</td>
            <td>{{ Lang::get('general.seminar') }}</td>
            <td>{{ Lang::get('general.attendance') }}</td>
            <td>{{ Lang::get('general.practice_work') }}</td>
            <td>{{ Lang::get('general.final_test') }}</td>
            <td>{{ Lang::get('general.grade') }}</td>
            <td>{{ Lang::get('general.refuse') }}</td>
            <td>{{ Lang::get('general.apply') }}</td>
        </tr>
        @foreach($students as $value)
        <tr class='head' style='background:#fff;'>
            <td>{{ $value['uid'] }}</td>
            <td>{{ $value['emri']." ".$value['mbiemri'] }}</td>
            <td>{{ $value['testi_semestral'] }}</td>
            <td>{{ $value['testi_gjysemsemestral'] }}</td>
            <td>{{ $value['seminari'] }}</td>
            <td>{{ $value['pjesmarrja'] }}</td>
            <td>{{ $value['puna praktike'] }}</td>
            <td>{{ $value['testi_final'] }}</td>
            <td>{{ $value['nota'] }}</td>
            <td>{{ Enum::convertRefuzimi($value['refuzim']) }}</td>
            <td>{{ Enum::convertParaqitjen($value['paraqit']) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop


@section('content')
<center>
    <b>{{ Lang::get('printable.report_grades') }}
        {{ Lang::get('printable.deadline') }} {{ Enum::convertMonths(substr($raporti['data_provimit'],5,2)) }} {{ $raporti['viti_aka'] }}
    </b>
</center>
<table style='width: 100%;'>
    <tbody>
        <tr>
            <td><b>{{ Lang::get('printable.department') }}:</b> {{ $raporti['departmenti'] }}</td>
            <td style='text-align: right;'><b>{{ Lang::get('printable.date') }}:</b> {{ $raporti['data_provimit'] }}</td>
        </tr>
        <tr>
            <td><b>{{ Lang::get('printable.profile') }}:</b> {{ $raporti['drejtimi'] }}</td>
            <td style='text-align: right;'><b>{{ Lang::get('printable.status') }}:</b> Te Rregullt</td>
        </tr>
        <tr>
            <td><b>{{ Lang::get('general.course') }}:</b> {{ $raporti['lenda'] }}</td>
            <td style='text-align: right;'><b>{{ Lang::get('general.issued_by') }}:</b> {{ Enum::convertUID(Session::get('uid')) }} ({{ Session::get('uid') }})</td>
        </tr>
        <tr>
            <td><b>{{ Lang::get('general.lecturer') }}:</b> {{ $raporti['prof'] }} - ({{ $raporti['profuid'] }})</td>
            <td style='text-align: right;'></td>
        </tr>
        <tr>
            <td colspan='2'>
                <br>
                <div  style='margin-left: 100px; margin-right: 0'>
                    <table border='1' style='width:80%;'>
                        <tr>
                            <td style='width:10%;'>{{ Lang::get('general.all_applied') }}</td>
                            <td style='width:10%;'>{{ Lang::get('general.abstention') }}</td>
                            <td style='width:70%;'>

                                <table style='width:100%;' border='1'>
                                    <tbody>
                                        <tr style='border-bottom: 1px solid #000000; text-align: center;'>
                                            <td style='border-bottom: 1px solid #000000;text-align: center; height: 30px;' colspan='6'>{{ Lang::get('general.rated_with_grade') }}</td>
                                        </tr>
                                        <tr>
                                            <td style='text-align: center;height: 15px;'>5</td>
                                            <td style='text-align: center;'>6</td>
                                            <td style='text-align: center;'>7</td>
                                            <td style='text-align: center;'>8</td>
                                            <td style='text-align: center;'>9</td>
                                            <td style='text-align: center;'>10</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td> 
                            <td style='width:10%; text-align: center;'>{{ Lang::get('general.ect') }}</td>
                        </tr>
                        <tr>
                            <td style='text-align: center;'>1</td>
                            <td style='text-align: center;'>421</td>
                            <td>
                                <table  style='width:100%;'  border='1'>
                                    <tbody>
                                        <tr style=' text-align: center;'>
                                            <td style='text-align: center; height: 50px;'>5</td>
                                            <td style='text-align: center;'>6</td>
                                            <td style='text-align: center;'>7</td>
                                            <td style='text-align: center;'>8</td>
                                            <td style='text-align: center;'>9</td>
                                            <td style='text-align: center;'>9</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style='text-align: center;'>4214</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td><br><br><b>{{ Lang::get('general.signature_lecturer')}}:</b> _______________________</td>
        </tr>
        <tr>
            <td><br><b>{{ Lang::get('general.dean_profile')}}:</b> _______________________</td>
        </tr>
        <tr>
            <td><br><b>{{ Lang::get('general.administrata_signature')}}:</b> _______________________</td>
        </tr>
    </tbody>
</table>

<div class="page-break"></div>
@yield('listStudent')
@stop