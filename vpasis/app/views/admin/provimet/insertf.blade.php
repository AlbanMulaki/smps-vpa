

<!-- Modal -->
<div class="modal  fade myModalerror" id="myModalerror" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{ Lang::get('validation.error') }}</h4>
            </div>
            <div class="modal-body alert alert-danger">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('general.close') }}</button>
            </div>
        </div>
    </div>
</div>
