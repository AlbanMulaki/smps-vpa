<div class="input-group">
    <div class="input-group-addon">
        {{ Form::label('lendet', Lang::get('general.course'), array('class' => 'has-success')) }}
    </div>
    <div class=" has-success">
        {{ Form::select('lendet', array('null' => Lang::get('validation.select_course')) + $lendethtml, null, array('id' => 'lendetin','class' => ' form-control ')) }}
    </div>
</div>
<br>
<div id="prof">
    <div class="input-group">
        <div class="input-group-addon">
            {{ Form::label('lendet', Lang::get('general.professor')) }}
        </div>
        {{ Form::select('prof', array('0' => Lang::get('general.null')), null, array('class' => 'form-control', 'disabled')) }}
    </div>
</div>
{{ $script }}

