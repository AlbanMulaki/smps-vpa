@extends('admin.index') 

@section('content')
{{ Session::get('notification')}}
{{ Form::open(array('action'=>'ProfController@postStore','method'=>'POST','class'=>'form-horizontal','id'=>'form1','role'=>'form','name'=>'form1')) }}

<div class="pager">
    <div class="col-md-8">
        <div class="progress">
            <div class="progress-bar progress-bar-info" id="probar" style="width: 2%">
                <span class="sr-only">35% Kompletuar</span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="alert alert-info fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            {{ $lastadministrata }} 
        </div>
    </div>
    <input type="button" id="but1" name="register" value="{{ Lang::get('general.register_prof') }}" class=" btn btn-primary btn-lg">
</div>
<div id="cl1">
    <div class="col-md-3 " >
        <div class="panel panel-default well">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('general.personale') }}</h3>
            </div>
            <div class="panel-body ">
                <div class="form-group">
                    <div class="input-group">
                        <label for='emri' class="input-group-addon">{{ Lang::get('general.name') }}</label>
                        <input id='emri' class="form-control"  type="text"  name="emri">
                    </div>

                </div>
                <div class="form-group ">
                    <div class="input-group ">
                        <label for='mbiemri' class="input-group-addon">{{ Lang::get('general.surname') }}</label>
                        <input id='mbiemri' class="form-control" type="text" name="mbiemri">
                    </div>
                </div>
                <div class="btn-group" data-toggle="buttons">

                    <label class="btn btn-default">
                        <input type="radio" name="gjinia" id="gjinia1" value="{{ Enum::femer }}">{{ Lang::get('general.female') }}
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="gjinia" id="gjinia2" value="{{ Enum::mashkull }}"> {{ Lang::get('general.male') }}
                    </label>
                </div><br><br>
                <div class="form-group ">
                    <div class="input-group ">
                        <div class="input-group-addon">{{ Lang::get('general.birthplace') }}</div>
                        <input class="form-control" type="text" name="vendilindjes">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group ">
                        <div class="input-group-addon">{{ Lang::get('general.birthdate') }}</div>
                        <input class="form-control" type="date" name="datalindjes" placeholder="{{ Lang::get('general.date_format') }}">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group ">
                        <div class="input-group-addon"><span class="fa fa-credit-card"></spoan></div>
                        <input class="form-control" type="text" name="idpersonal">
                    </div>
                </div>
            </div> 
        </div>
    </div>







    <div class="col-md-3">
        <div class="panel panel-default well">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('general.info_adress') }}</h3>
            </div>
            <div class="panel-body ">
                <div class="form-group ">
                    <div class="input-group ">
                        <div class="input-group-addon "><span class="fa fa-mobile fa-lg"></span></div>
                        <input class="form-control " type="text" name="phone" placeholder="{{Lang::get("general.phone_format")}}">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group ">
                        <div class="input-group-addon">{{ Lang::get('general.email') }}</div>
                        <input class="form-control" type="email" name="email" placeholder="{{ Lang::get("general.email_format") }}">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group ">
                        <div class="input-group-addon">{{ Lang::get('general.adress') }}</div>
                        <input class="form-control" type="text" name="adress">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group ">
                        <div class="input-group-addon">{{ Lang::get('general.location') }}</div>
                        <input class="form-control" type="text" name="vendbanimi">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="input-group ">
                        <div class="input-group-addon">{{ Lang::get('general.state') }}</div>
                        <input class="form-control" type="text" name="shteti">
                    </div>
                </div>


            </div>      
        </div>              
    </div> 



    <div class="col-md-3 ">
        <div class="panel panel-default well">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('general.education') }}</h3>
            </div>
            <div class="panel-body ">

                <div class="form-group ">
                    <div class="input-group ">
                        <div class="input-group-addon">{{ Lang::get('general.course') }}</div>
                        {{ Form::select('lendet',$lendet,null,array('class'=>'form-control')) }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group ">

                        <div class="btn-group" data-toggle="buttons" >

                            <label class="btn btn-default" for="fondi_oreve1">
                                <input type="radio" name="fondi_oreve" id="fondi_oreve1" value="1">1
                            </label>
                            <label class="btn btn-default" for="fondi_oreve2">
                                <input type="radio" name="fondi_oreve" id="fondi_oreve2" value="2">2
                            </label>
                            <label class="btn btn-default" for="fondi_oreve3">
                                <input type="radio" name="fondi_oreve" id="fondi_oreve3" value="3">3
                            </label>
                            <label class="btn btn-default" for="fondi_oreve4">
                                <input type="radio" name="fondi_oreve" id="fondi_oreve4" value="4">4
                            </label>
                            <label class="btn btn-default" for="fondi_oreve5">
                                <input type="radio" name="fondi_oreve" id="fondi_oreve5" value="5">5
                            </label>
                            <label class="btn btn-default" for="fondi_oreve6">
                                <input type="radio" name="fondi_oreve" id="fondi_oreve6" value="6">6
                            </label>


                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-group" data-toggle="buttons">

                <label class="btn btn-default">
                    <input type="radio" name="status" id="status1" value="{{ Enum::active }}">{{ Lang::get('general.active') }}
                </label>
                <label class="btn btn-default">
                    <input type="radio" name="status" id="status2" value="{{ Enum::passive }}"> {{ Lang::get('general.passive') }}
                </label>
            </div><br><br>
            <div class="form-group ">
                <div class="input-group ">
                    <div class="input-group-addon">{{ Lang::get('general.position') }}</div>

                    {{ Form::select('pozita',array(Enum::assistent=>Lang::get('general.assistent'),
                                    Enum::lecturer=>Lang::get('general.lecturer') ),null,array('class'=>'form-control')) }}

                </div>
            </div>

            <div class="form-group ">
                <div class="input-group ">
                    <div class="input-group-addon">{{ Lang::get('general.scienc_grade') }}</div>

                    {{ Form::select('grade',array(Enum::absolvent=>Lang::get('general.student'),
                                    Enum::phd=>Lang::get('general.phd'),
                                    Enum::dr=>Lang::get('general.dr'),
                                    Enum::akademik=>Lang::get('general.academic')),null,array('class'=>'form-control')) }}

                </div>
            </div>
            <div class="form-group ">
                <div class="input-group ">
                    <div class="input-group-addon">{{ Lang::get('general.qualification') }}</div>
                    <textarea class="form-control" type="text" name="qualification"></textarea>
                </div>
            </div>

        </div>      
    </div>      
</div>    




<div class="col-md-3 ">
    <div class="panel panel-default well">
        <div class="panel-heading">
            <h3 class="panel-title">{{ Lang::get('general.contracts') }}</h3>
        </div>
        <div class="panel-body ">


            <div class="form-group ">
                <div class="input-group ">
                    <div class="input-group-addon "><span class='fa fa-eur '></span></div>
                    <input class="form-control" type="text" name="shuma">
                </div>
            </div>
            <div class="form-group ">
                <div class="input-group ">
                    <div class="input-group-addon "><span class='fa fa fa-university '></span></div>
                    <input class="form-control" type="text" name="credit_card">
                </div>
            </div>

        </div>      
    </div>      
</div>    

</div>




<div class="modal fade confirm bs-example-modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> {{ Lang::get('general.success') }}</h4>
            </div>
            <div class="modal-body">
                <div id="preview"></div>
            </div>
            <div class="modal-footer">
                <input type="button" id="but2" class="btn btn-primary" name="send" value="{{ Lang::get('general.confirm')  }}" data-dismiss="modal" />
                <input type="button" class="btn btn-default" value="{{ Lang::get('general.close')  }}" data-dismiss="modal">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{ Form::close() }}








<script>
    // Progressbar sucessful
    $('#but2').click(function() {
        $('#probar').css('width', '100%');
        $('#probar').removeClass('progress-bar-info').addClass('progress-bar-success');
        $('#form1').submit();
        $('#cl1').empty();
        $('#but1').empty();
    });

    // Request data for verification
    $('#but1').click(function(e) {
        e.preventDefault();
        var dataString = $('form').serialize();
        $.ajax({
            type: "POST",
            url: "{{ action('ProfController@postVerify') }}",
            data: dataString,
            success: function(data) {
                console.log(data);
                $('#probar').css('width', '50%');
                $('#preview').empty().append(data);
                $('.confirm').modal('show');
            }},
        "json");

    });


</script>
@stop