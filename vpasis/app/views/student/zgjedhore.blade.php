<script>
    $(document).ready(function() {
        $('#zgjedhore').modal({show: true,
            backdrop: 'static', keyboard: false});
    });

</script>

{{ Form::open(array('url'=>action('StudentController@postZgjedhore'),'method'=>'POST','class'=>'form-horizontal','role'=>'form')) }}

<!-- Modal -->
<div class="modal fade" id="zgjedhore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ Lang::get('warn.info_chose_course_nonobligative')}}</h4>
            </div>
            <div class="modal-body">
                @foreach($zgjedhore as $value)
                <div class="radio">
                    <label>
                        <input type="radio" name="zgj" value="{{ $value['idl'] }}" >
                        {{ $value['Lenda'] }}
                    </label>
                </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ Lang::get('general.choose_course')}}</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}