@extends('admin.index')

@section('notification')

<!-- Regjistrimi Departmentit -->
@if(null !== Session::get('message') && Session::get('message') == Enum::successful)
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Session::get('reason') }}
</div>
@elseif(Session::get('message') == Enum::failed)
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Lang::get('warn.error_undefined') }}
</div>

@endif
<!-- End Regjistrimi Departmentit -->
@stop


@section('registerStudent')
{{ Form::open(array('url'=>action('StudentController@postEdit'),'method'=>'POST','files'=>true,'class'=>"form-horizontal")) }}

<section class='content'>
<div class='box box-warning'>
    <div class='box-header with-border'>
        <h3 class='box-title'>Informacione mbi studentin</h3>
    </div>
    <div class='box-body'>
        <div class='col-lg-6'>

            <input type="hidden" name="uid" value="{{ $profile['uid'] }}" >

            <div class="form-group">
                <label class="col-lg-3 control-label">{{ Lang::get('general.name') }}</label>
                <div class="col-lg-9">
                    <input class="form-control text-capitalize"  placeholder="{{ Lang::get('reminders.name') }}" type="text"  name="emri" value="{{ $profile['emri'] }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">{{ Lang::get('general.surname') }}</label>
                <div class="col-lg-9">
                    <input class="form-control "  placeholder="{{ Lang::get('reminders.surname') }}" type="text" name="mbiemri" value="{{ $profile['mbiemri'] }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">{{ Lang::get('general.name_dad') }}</label>
                <div class="col-lg-9">
                    <input class="form-control "  placeholder="{{ Lang::get('reminders.name_dad') }}" type="text" name="emri_prindit"  value="{{ $profile['emri_prindit'] }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">{{ Lang::get('general.surname_dad') }}</label>
                <div class="col-lg-9">
                    <input class="form-control "  placeholder="{{ Lang::get('reminders.surname_dad') }}" type="text" name="mbiemri_prindit"  value="{{ $profile['mbiemri_prindit'] }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">{{ Lang::get('general.birthplace') }}</label>
                <div class="col-lg-9">
                    <input class="form-control "  placeholder="{{ Lang::get('reminders.birthplace') }}" type="text" name="vendlindja"  value="{{ $profile['vendlindja'] }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">{{ Lang::get('general.birthdate') }}</label>
                <div class="col-lg-9">
                    <input class="form-control " id="birthdate"  placeholder="VVVV/MM/DD" data-mask="" type="text" name="datalindjes"  value="{{ $profile['datalindjes'] }}"> 
                </div>
                <script>
                    $('#birthdate').inputmask({
                        mask: '9999-99-99'
                    })
                </script>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">{{ Lang::get('general.location') }}</label>
                <div class="col-lg-9">
                    <input class="form-control "  placeholder="{{ Lang::get('reminders.location') }}" type="text" name="vendbanimi"  value="{{ $profile['vendbanimi'] }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">{{ Lang::get('general.nationality') }}</label>
                <div class="col-lg-9">
                    <input class="form-control "  placeholder="{{ Lang::get('reminders.nationality') }}" type="text" name="shtetas"  value="{{ $profile['shtetas'] }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">{{ Lang::get('general.phone') }}</label>
                <div class="col-lg-9">
                    <div class='input-group'>
                        <span class="input-group-addon"><i class="fa fa-phone"></i> </span>
                        <input class="form-control "  placeholder="{{ Lang::get('reminders.phone') }}" type="text"  name="telefoni"  value="{{ $profile['telefoni'] }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">{{ Lang::get('general.email') }}</label>
                <div class="col-lg-9">  
                    <div class='input-group'>
                        <span class="input-group-addon"><i class="fa fa-inbox"></i> </span>
                        <input class="form-control "  placeholder="{{ Lang::get('reminders.email_example') }}" type="text"  name="email"  value="{{ $profile['email'] }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">{{ Lang::get('general.idpersonal') }}</label>
                <div class="col-lg-9">
                    <input class="form-control "  placeholder="{{ Lang::get('reminders.idpersonal') }}" type="text"  name="nrpersonal"  value="{{ $profile['nrpersonal'] }}">
                </div>
            </div>



        </div>

        <div class='col-lg-4'>

            <div class="form-group">
                <div class="input-group col-lg-10">
                    {{ Form::select('gjinia', Enum::getGjinia(),$profile['gjinia'],array('class'=>'form-control')) }}
                </div>
            </div>



            <div class="form-group">
                <div class="input-group col-lg-10">
                    <span class="input-group-addon">{{ Lang::get('general.level') }}</span>
                    {{ Form::select('niveli', Enum::getLevel(),$profile['niveli'],array('class'=>'form-control')) }}
                </div>
            </div>



            <div class="form-group">
                <div class='input-group col-lg-10'>
                    <span class="input-group-addon">{{ Lang::get('general.academic_year') }}</span>
                    <input class="form-control "  placeholder="VVVV/VVVV" id='vitiaka' type="text"  name="viti_aka" value="{{ $profile['viti_aka'] }}">

                    <script>
                        $('#vitiaka').inputmask({
                            mask: '9999/9999'
                        })
                    </script>
                </div>
            </div>


            <div class="form-group">
                <div class="input-group col-lg-10">
                    <span class="input-group-addon">{{ Lang::get('general.subject') }}</span>
                    {{ Form::select('drejtimi', $drejtimet,$profile['drejtimi'],array('class'=>'form-control')) }}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group col-lg-10">
                    <span class="input-group-addon">{{ Lang::get('general.semester') }}</span>
                    {{ Form::select('semestri', Enum::getSemester(),$profile['semestri'],array('class'=>'form-control')) }}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group col-lg-10">
                    <span class="input-group-addon">{{ Lang::get('general.status') }}</span>
                    {{ Form::select('statusi', Enum::getStatus(),$profile['statusi'],array('class'=>'form-control')) }}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group col-lg-10">
                    <span class="input-group-addon">{{ Lang::get('general.transfer') }}</span>
                    {{ Form::select('transfer', array(Enum::yes => Lang::get('general.yes'),Enum::no => Lang::get('general.no')),$profile['transfer'],array('class'=>'form-control')) }}
                </div>
            </div>

            <div class="form-group">
                <div class='input-group col-lg-10'>
                    <span class="input-group-addon">{{ Lang::get('general.adress') }}</span>
                    <textarea class="form-control"  placeholder="{{ Lang::get('reminders.adress') }}" name='adressa' >{{ $profile['adressa'] }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class='input-group col-lg-10'>
                    <span class="input-group-addon">{{ Lang::get('general.qualification') }}</span>
                    <textarea class="form-control"  placeholder="{{ Lang::get('reminders.qualification') }}" name="kualifikimi" >{{ $profile['kualifikimi'] }} </textarea>
                </div>
            </div>
        </div>



        <div class='col-lg-2'>
            <div class="form-group">
                <div class="file-input file-input-new ">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 150px; height: 150px;">
                            <img src="/smpsfl/doc/avatar/{{  $profile['avatar'] }}">
                            <input name="avatarname" type="hidden" value="{{  $profile['avatar'] }}" >
                        </div>
                        <div>
                            <span class="btn btn-default btn-sm btn-file"><span class="fileinput-new">{{ Lang::get('general.chose_image') }}</span>
                                <span class="fileinput-exists">{{ Lang::get('general.change') }}</span>
                                <input type="file" name="avatar" accept="image/*">
                            </span>
                            <a href="#" class="btn btn-sm btn-warning fileinput-exists" data-dismiss="fileinput">{{ Lang::get('general.remove') }}</a>
                        </div>
                    </div>
                </div>   
            </div>  

            <div class="form-group">
                <div class='input-group col-lg-10'>
                    <input class="form-control "   type="text"  name="kontrata_pageses" id="kontrata_pages" value="{{  $profile['kontrata_pageses'] }}" >
                    <span class="input-group-addon"><span class='fa fa-euro'></span></span>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group col-lg-10">
                    <span class="input-group-addon  input-sm">{{ Lang::get('general.installments') }}</span>
                    {{ Form::selectRange('keste', 1,12,$profile['keste'],array('class'=>'form-control input-sm','id'=>'kesti_mujor')) }}
                </div>
            </div>
            <div class='form-group'>
                {{ Lang::get('general.installments_month')}}: <div> 
                    <span  id="kesti_mujorbar"  class='fa fa-lg'></span>
                    <span class='fa fa-euro fa-lg'>
                        @if($profile['kontrata_pageses'] > 0  && $profile['keste'] > 0)
                        {{ $profile['kontrata_pageses']/$profile['keste'] }}
                        @endif

                    </span>
                </div>
            </div>
            <script>
                $('#kesti_mujor').change(function () {
                    var kesti = $('#kontrata_pages').val() / $('#kesti_mujor').val();
                    $('#kesti_mujorbar').empty().append(kesti);
                });

            </script>
        </div>

        <div class='col-lg-12'>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">{{ Lang::get("general.update") }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

{{ Form::close() }}
@stop


@section('content')
<section class='content-header'>
    <h1>{{ $profile['emri']." ".$profile['mbiemri'] }}</h1>
</section>

@yield('notification')
@yield('registerStudent')

@stop


