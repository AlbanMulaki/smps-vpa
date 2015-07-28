@extends('admin.index')
@section('content')

{{ Form::open(array('url'=>'','method'=>'PUT','class'=>'form-horizontal','id'=>'form1',)) }}

<div class="col-sm-12  panel-primary ">

    <div class="panel-heading">
        <h3 class="panel-title">{{ Lang::get('settings.title') }}</h3>
    </div>
    <div class="panel panel-primary " >
        <div class="col-sm-4 panel-body ">
            <h3>{{ Lang::get('settings.exams') }}</h3>

            <span class="well well-sm checkbox-inline" >
                @if($settings['provim_active'] == Enum::jo )
                {{ Form::radio('afp',Enum::jo,true,['id'=>'afjn']) }}
                @else
                {{ Form::radio('afp',Enum::jo,false,['id'=>'afjn']) }}
                @endif
                {{ Form::label('afjn',Lang::get('general.no'))}}
            </span>
            <span class="well well-sm checkbox-inline">
                @if($settings['provim_active'] == Enum::po )
                {{ Form::radio('afp',Enum::po,true,['id'=>'afpn']) }}
                @else
                {{ Form::radio('afp',Enum::po,false,['id'=>'afpn']) }}

                @endif
                {{ Form::label('afpn',Lang::get('general.yes')) }}
            </span>
            <span class="well well-sm checkbox-inline" >
                @if($settings['provim_active'] == Enum::pending )
                {{ Form::radio('afp',Enum::pending,true,['id'=>'afnn']) }}
                @else
                {{ Form::radio('afp',Enum::pending,false,['id'=>'afnn']) }}
                @endif
                {{ Form::label('afnn',Lang::get('settings.prepare_list'))}}
            </span>


        </div>


        <div class="col-sm-4 panel-body ">
            <h3>{{ Lang::get('settings.alternative_profile') }}</h3>

            <span class="well well-sm checkbox-inline" >
                @if($settings['zgjedhore_active'] == Enum::jo)
                {{ Form::radio('lzg',Enum::jo,true,['id'=>'lzgjn']) }}
                @else
                {{ Form::radio('lzg',Enum::jo,false,['id'=>'lzgjn']) }}
                @endif

                {{ Form::label('lzgjn',Lang::get('general.no'))}}
            </span>
            <span class="well well-sm checkbox-inline">
                @if($settings['zgjedhore_active'] == Enum::po)
                {{ Form::radio('lzg',Enum::po,true,['id'=>'lzgpn']) }}
                @else
                {{ Form::radio('lzg',Enum::po,false,['id'=>'lzgpn']) }}
                @endif
                {{ Form::label('lzgpn',Lang::get('general.yes')) }}
            </span>
        </div>


        <div class="col-sm-4 panel-body  ">
            <h3>{{ Lang::get('settings.refuse_grade') }}</h3>

            <span class="well well-sm checkbox-inline" >

                @if($settings['refuzimi_active'] == Enum::jo)
                {{ Form::radio('rf',Enum::jo,true,['id'=>'rfjn']) }}
                @else
                {{ Form::radio('rf',Enum::jo,false,['id'=>'rfjn']) }}

                @endif
                {{ Form::label('rfjn',Lang::get('general.no'))}}
            </span>
            <span class="well well-sm checkbox-inline">
                @if($settings['refuzimi_active'] == Enum::po)
                {{ Form::radio('rf',Enum::po,true,['id'=>'rfpn']) }}
                @else
                {{ Form::radio('rf',Enum::po,false,['id'=>'rfpn']) }}
                @endif
                {{ Form::label('rfpn',Lang::get('general.yes')) }}
            </span>


        </div>



        <div class="col-sm-4 panel-body  ">
            <h3>{{ Lang::get('settings.precent_applyexams') }}</h3>

            <div class="input-group col-sm-3">
                {{ Form::text('pax',$settings['perqindja_paraqitjes'],['id'=>'paxn','class'=>'form-control']) }}
                {{ Form::label('paxn',Lang::get('settings.percent'),['class'=>'input-group-addon']) }}

            </div>

        </div>


        <div class="col-sm-4 panel-body  ">
            <h3>{{ Lang::get('settings.time_refuse_grade') }}</h3>

            <div class="input-group col-sm-3">
                {{ Form::text('day',$settings['koha_refuzimit'],['id'=>'dayn','class'=>'form-control']) }}
                {{ Form::label('dayn',Lang::get('general.day'),['class'=>'input-group-addon']) }}

            </div>

        </div>




        <div class="col-sm-4 panel-body  ">
            <h3>{{ Lang::get('general.hours_subject') }}</h3>

            <span class="well well-sm checkbox-inline" >

                @if($settings['orari_lendeve'] == Enum::jo)
                {{ Form::radio('orl',Enum::jo,true,['id'=>'orl']) }}
                @else
                {{ Form::radio('orl',Enum::jo,false,['id'=>'orl']) }}

                @endif
                {{ Form::label('orl',Lang::get('general.public'))}}
            </span>
            <span class="well well-sm checkbox-inline">
                @if($settings['orari_lendeve'] == Enum::po)
                {{ Form::radio('orl',Enum::po,true,['id'=>'orl']) }}
                @else
                {{ Form::radio('orl',Enum::po,false,['id'=>'orl']) }}
                @endif
                {{ Form::label('orl',Lang::get('general.private')) }}
            </span>


        </div>


        <div class="col-sm-4 panel-body  ">
            <h3>{{ Lang::get('general.rating') }}</h3>

            <span class="well well-sm checkbox-inline" >

                @if($settings['vlersimi'] == Enum::jo)
                {{ Form::radio('vlrs',Enum::jo,true,['id'=>'orl']) }}
                @else
                {{ Form::radio('vlrs',Enum::jo,false,['id'=>'orl']) }}

                @endif
                {{ Form::label('vlrs',Lang::get('general.no'))}}
            </span>
            <span class="well well-sm checkbox-inline">
                @if($settings['vlersimi'] == Enum::po)
                {{ Form::radio('vlrs',Enum::po,true,['id'=>'orl']) }}
                @else
                {{ Form::radio('vlrs',Enum::po,false,['id'=>'orl']) }}
                @endif
                {{ Form::label('vlrs',Lang::get('general.yes')) }}
            </span>


        </div>

    </div>
    <div class="col-sm-12 pager">


        {{ Form::submit(Lang::get('general.save'),['class'=>'btn btn-primary btn-lg','name'=>'submit']) }}
    </div>



</div>







<!-- Small modal -->

<div class="modal fade succesupd">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> {{ Lang::get('general.success') }}</h4>
            </div>
            <div class="modal-body">
                {{ Lang::get('general.save_success') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('general.close')  }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{ Form::close() }} 

<script>
    $(document).ready(function() {
        $('#form1').submit(function(e) {

            e.preventDefault();
            var dataString = $('form').serialize();
            $.ajax({
                type: "PUT",
                url: "",
                data: dataString,
                success: function(data) {
                    console.log(data);
                    $('.succesupd').modal('show');
                }},
            "json");

        });
    });
</script>
@stop

