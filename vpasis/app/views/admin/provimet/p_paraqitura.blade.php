
<tr>{
    <th>#</th>
    <th>Studenti</<th>
    <th>Grupi</<th>
    <th>{{ Lang::get('general.present')}}</th>

</tr>
@foreach($paraqitja as $value)
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $value->studenti }}</td>
    <td>Grupi A </td>
    <td>@if($value->paraqitja == Enum::paraqitur)<input type='checkbox' id="vij{{ $value->uid }}" name="vi{{ $value->uid }}"> @endif</td>
</td>
<script>
    $(document).on('change', '#vij{{ $value->uid }}', function() {
        var student = $('#vij{{ $value->uid }}').serialize();
        var lenda = $('#profileins').val();
        $.ajax({
            type: "POST",
            url: "{{ action('AjaxController@postProvimVijushmeri') }}",
            data: {lenda: lenda, studenti: "{{ $value->uid }}"},
            success: function(data) {
                console.log(data);
            }
        },
        "json");
    });
</script>
</tr>
@endforeach
