<div id="toolbox">
  <h3>{L('pmtoolbox')} :: {$proj->prefs['project_title']} : {L('taskstatuses')}</h3>

  <fieldset class="box">
    <legend>{L('taskstatuses')}</legend>
    <?php
    $this->assign('list_type', 'status');
    $this->assign('rows', $proj->listTaskStatuses(true));
    $this->display('common.list.tpl');
    ?>
  </fieldset>
</div>
