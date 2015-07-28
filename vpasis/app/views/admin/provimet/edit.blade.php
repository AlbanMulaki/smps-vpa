@foreach($provimet as $value)
{{ Form::open(array('url'=>'/admin/exams/'.$value['idprovimet'],'method'=>'DELETE','class'=>'form-horizontal','id'=>'form'.$value['idprovimet'],)) }}


<div class="col-sm-12  btn  btn-sm btn-block btn-default">  
    <a href="#">
        <div class="col-sm-3" style='white-space: normal;'>{{ $value['Emri'] }}</div>
        <div class="col-sm-3" style='white-space: normal;'>{{ $value['Prof'] }}</div>
        <div class="col-sm-4" style='white-space: normal;'>{{ $value['data'] }}</div>
        <div class="col-sm-1" style='white-space: normal;'>{{ $value['Semestri'] }}</div>
        <div class="col-sm-1" style='white-space: normal;'> <a href="#"   data-toggle="modal" data-target="#myModal{{ $value['idprovimet'] }}" > <span class="text-danger glyphicon glyphicon-remove "></span></a></div>
    </a>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal{{ $value['idprovimet'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.are_you_sure') }}</h4>
            </div>
            <div class="modal-body">





                <div class="form-group">
                    <div id="lendetedit{{ $value['idprovimet'] }}">
                        {{ Form::label('Lenda',Lang::get('general.course'),array('class'=>'control-label col-sm-2')) }}
                        <div class=" col-sm-10">
                            {{ Form::label('Lenda',$value['Emri'],array('class'=>'form-control','idprovimet'=>'lendeteditinput'.$value['idprovimet']))  }}
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <div id="profedit{{ $value['idprovimet'] }}">
                        {{ Form::label('prof',Lang::get('general.professor'),array('class'=>'control-label col-sm-2')) }}
                        <div class=" col-sm-10">
                            {{ Form::label('prof',$value['Prof'],array('class'=>'form-control','idprovimet'=>'profinput'.$value['idprovimet']))  }}
                        </div>
                    </div>
                </div>




                <div class="form-group">
                    <div id="day">
                        {{ Form::label('Data',Lang::get('general.date'),array('class'=>'control-label col-sm-2')) }}
                        <div class=" col-sm-10">
                            {{ Form::label('Data',Enum::convertday($value['Data']),array('class'=>'form-control','idprovimet'=>'day'.$value['idprovimet'])) }}

                        </div>


                    </div>
                </div>


                <div class="form-group">

                    {{ Form::label('Semestri',Lang::get('general.semester'),array('class'=>'control-label col-sm-2')) }}
                    <div class=" col-sm-10">
                        {{ Form::label('Semestri',$value['Semestri'],array('class'=>'form-control')) }}
                    </div>
                </div>















            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('general.close') }}</button>
                <input type="submit" class="btn btn-primary"  value="{{ Lang::get('general.delete') }}" >
            </div>
        </div>
    </div>
</div>

<div id="errorssuc"></div>
{{ Form::close() }}

<script>
    $(document).ready(function(){
    $('#form{{ $value['idprovimet'] }}').submit(function(e) {
    e.preventDefault();
            var dataString = $('#form{{ $value['idprovimet'] }}').serialize();
            $.ajax({
            type: "DELETE",
                    url: "/admin/exams/{{ $value['idprovimet'] }}",
                    data: dataString,
                    error:function(){alert('Something went go wrong'); },
                    success: function(data) {
                    console.log(data);
                            $('#errorssuc').empty().append(data);
                            $('#errorssuc{{ $value['idprovimet'] }}').modal('show');
                            $('button').click(function(){
                    location.reload(true);
                    });
                    }},
                    "json");
    });
    });

</script>
@endforeach