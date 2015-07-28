

<!-- Modal -->

<div class="modal fade errorssuc{{ $id }}" id="errorssuc{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">{{ Lang::get('general.delete_msg') }}</h4>
      </div>
      <div class="modal-body">
          {{ Lang::get('general.delete_msg') }} 
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" >{{ Lang::get('general.close') }}</button>
 </div>
    </div>
  </div>
</div>
