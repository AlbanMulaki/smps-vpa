<br><br>
@foreach($orari as $value)
{{ Form::open(array('url'=>'/admin/hsub/'.$value['idOrari'],'method'=>'DELETE','class'=>'form-horizontal','id'=>'form'.$value['idOrari'],)) }}


<div class="col-sm-12  btn btn-block btn-default">  
    <a href="#">
        <div class="col-sm-3">{{ Enum::convertday($value['dita']) }}</div>
        <div class="col-sm-3">{{ $value['Landa'] }}</div>
        <div class="col-sm-3">{{ $value['Prof'] }}</div>
        <div class="col-sm-3">{{ $value['ora'] }} <a href="#"   data-toggle="modal" data-target="#myModal{{ $value['idOrari'] }}" > <span class="text-danger glyphicon glyphicon-remove "></span></a></div>
    </a>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal{{ $value['idOrari'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.are_you_sure') }}</h4>
            </div>
            <div class="modal-body">




                <div class="form-group">
                    {{ Form::label('drejtimiedit','Drejtimi',array('class'=>'control-label col-sm-2')) }}
                    <div class=" col-sm-10">
                        {{ Form::label('drejtimiedit',$value['DrejtimiEmri'],array('idOrari'=>'drejtimiedit'.$value['idOrari'],'class'=>'form-control')) }}
                    </div>
                </div>




                <div class="form-group">
                    <div id="lendetedit{{ $value['idOrari'] }}">
                        {{ Form::label('lendet',Lang::get('general.course'),array('class'=>'control-label col-sm-2')) }}
                        <div class=" col-sm-10">
                            {{ Form::label('lendet',$value['Landa'],array('class'=>'form-control','idOrari'=>'lendeteditinput'.$value['idOrari']))  }}
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <div id="profedit{{ $value['idOrari'] }}">
                        {{ Form::label('prof',Lang::get('general.professor'),array('class'=>'control-label col-sm-2')) }}
                        <div class=" col-sm-10">
                            {{ Form::label('prof',$value['Prof'],array('class'=>'form-control','idOrari'=>'profinput'.$value['idOrari']))  }}
                        </div>
                    </div>
                </div>




                <div class="form-group">
                    <div id="day">
                        {{ Form::label('day',Lang::get('general.day'),array('class'=>'control-label col-sm-2')) }}
                        <div class=" col-sm-10">
                            {{ Form::label('day',Enum::convertday($value['dita']),array('class'=>'form-control','idOrari'=>'day'.$value['idOrari'])) }}

                        </div>


                    </div>
                </div>


                <div class="form-group">

                    {{ Form::label('ora',Lang::get('general.time'),array('class'=>'control-label col-sm-2')) }}
                    <div class=" col-sm-10">
                        {{ Form::label('ora',$value['ora'],array('class'=>'form-control')) }}
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
    $('#drejtimiedit{{ $value['idOrari'] }}').change(function(e){

    e.preventDefault();
            var dataString = $('#lendeteditinput{{ $value['idOrari'] }}').serialize();
            $.ajax({
            type: "POST",
                    url:"/smps/admin/ajax/lopac",
                    data: dataString,
                    success: function(data){console.log(data);
                            $('.succesupd').modal('show');
                            $('#profedit{{ $value['idOrari'] }}').empty().append(data);
                    }
            },
                    "json");
    });
            $('#form{{ $value['idOrari'] }}').submit(function(e) {
    e.preventDefault();
            var dataString = $('#form{{ $value['idOrari'] }}').serialize();
            $.ajax({
            type: "DELETE",
                    url: "/smps/admin/hsub/{{ $value['idOrari'] }}",
                    data: dataString,
                    error:function(){alert('Something went go wrong'); },
                    success: function(data) {
                    console.log(data);
                            $('#errorssuc').empty().append(data);
                            $('#errorssuc{{ $value['idOrari'] }}').modal('show');
                            $('button').click(function(){
                    location.reload(true);
                    });
                    }},
                    "json");
    });
    });

</script>
@endforeach