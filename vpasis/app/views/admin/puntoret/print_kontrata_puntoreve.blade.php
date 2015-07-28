@extends('printa4v')


@section('content')
<center>
    <p><strong>{{ Lang::get('printable.employer_description') }}</strong> </p>
</center>
<div class='right'>
    <strong>{{ Lang::get('printable.date') }}: {{ date('d-m-Y') }} - Ferizaj</strong> 
</div>
<table class="list" style="width: 99%; margin-top: 1em;">
    <tbody>
        <tr>
            <td style='border:1px solid #000;'> <strong>{{ Lang::get('printable.employer') }}: {{ $options['name_company'] }}</strong></td>
        </tr>
        <tr>
            <td style='border:1px solid #000;'>
                {{ Lang::get('printable.employer_info1',array('university'=>$options['name_company'])) }}
            </td>
        </tr>
        <tr>
            <td style='border:1px solid #000;'> 
                {{ Lang::get('printable.employer_info2') }}
            </td>
        </tr>
        <tr><td style='border:1px solid #000;'><br></td></tr>
        <tr>
            <td style='border:1px solid #000;'> 
                {{ Lang::get('printable.employer_info3') }}
            </td>
        </tr>
        <tr><td style='border:1px solid #000;'><br></td></tr>
        <tr>
            <td style='border:1px solid #000;'> 
                {{ Lang::get('printable.employer_info4') }}
            </td>
        </tr>
        <tr><td style='border:1px solid #000;'><br></td></tr>
        <tr>
            <td style='border:1px solid #000;'> 
                {{ Lang::get('printable.employer_info5') }}
            </td>
        </tr>
        <tr><td style='border:1px solid #000;'><br></td></tr>
        <tr>
            <td style='border:1px solid #000;'> 
                {{ Lang::get('printable.employer_info6') }}
            </td>
        </tr>
        <tr><td style='border:1px solid #000;'><br></td></tr>
        <tr>
            <td style='border:1px solid #000;'> 
                {{ Lang::get('printable.employer_info7') }}
            </td>
        </tr>
        <tr><td style='border:1px solid #000;'><br></td></tr>
        <tr>
            <td style='border:1px solid #000;'> 
                {{ Lang::get('printable.employer_info8') }}
            </td>
        </tr>
        <tr><td style='border:1px solid #000;'><br></td></tr>
        <tr>
            <td style='border:1px solid #000;'> 
                {{ Lang::get('printable.employer_info9') }}
            </td>
        </tr>
        <tr><td style='border:1px solid #000;'><br></td></tr>
        <tr>
            <td style='border:1px solid #000;'> 
                {{ Lang::get('printable.employer_info10') }}
            </td>
        </tr>
    </tbody>
</table>
@stop