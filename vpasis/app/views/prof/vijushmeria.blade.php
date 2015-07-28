<table class="table">
    <tr>
        <th>{{ Lang::get('general.student') }}</th>
        <th>{{ Lang::get('general.present')}}</th>
    </tr>
    <tbody id="vijushmeriaresult">


        @foreach($vijushmeria as $value)
        <tr data-toggle="popover" title="ID:{{ $value['Studenti'] }}">
            <td>{{ $value['Emri'] }}
            </td>
            <td><span class='label label-info'> {{ $value['present'] }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>