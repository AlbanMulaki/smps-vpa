

<div style="z-index:1; position:fixed;">

    @foreach($person as $id=>$value)
    <div class="list-group-item" >{{ $value['emri'].' '.$value['mbiemri'].' ('.$value['uid'].')' }}
    </div>
    @endforeach
</div>
