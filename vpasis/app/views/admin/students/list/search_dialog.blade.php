

<div style="z-index:1; position:fixed;">

@foreach($person as $id=>$value)
{{
    link_to(action('AdminStudentController@getStudent').'/'.$value['uid'], $value['emri'].' '.$value['mbiemri'].' ('.$value['uid'].')', array('class'=>'list-group-item'),null);
}}
@endforeach
</div>
