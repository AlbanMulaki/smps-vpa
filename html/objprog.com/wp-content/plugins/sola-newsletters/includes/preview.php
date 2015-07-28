<?php $camp = sola_nl_get_camp_details($_GET['camp_id']); ?>

<div id="icon-options-general" class="icon32 icon32-posts-post"><br></div><h2><?php _e("Live Preview","sola") ?></h2>

<div class="preview_actions">
    <?php if($camp->type == '3'){ ?>
        <div class="return_editor">
            <a title="<?php _e('Return To Editor', 'sola'); ?>" class="button-primary" href="admin.php?page=sola-nl-menu&action=custom_template&camp_id=<?php  echo $_GET['camp_id'] ?>"><?php _e('Return To Editor' ,'sola'); ?></a>
        </div>
    <?php } else { ?>
    <div class="return_editor">
        <a title="<?php _e('Return To Editor', 'sola'); ?>" class="button-primary" href="admin.php?page=sola-nl-menu&action=editor&camp_id=<?php  echo $_GET['camp_id'] ?>"><?php _e('Return To Editor' ,'sola'); ?></a>
    </div>
    <?php } ?>
    <div class="confirm_camp">
        <a title="<?php _e('Confirm Campaign', 'sola'); ?>" class="button-primary sola_nl_next_btn" href="admin.php?page=sola-nl-menu&action=confirm_camp&camp_id=<?php  echo $_GET['camp_id'] ?>"><?php _e('Confirm Campaign', 'sola'); ?></a>
    </div>
</div>
<div class="sola_nl_preview_container">    
    <div id="sola_tabs">
          <ul>
              <li><a href="javascript:void(0)" class="preview_button_button" id="preview_desktop" window_width="800px" add_class="preview_desktop" title="<?php _e('Desktop', 'sola'); ?>"><?php _e('Desktop', 'sola'); ?></a></li>
              <li><a href="javascript:void(0)" class="preview_button_button" id="preview_mobile" window_width="300px" add_class="preview_mobile" title="<?php _e('Mobile', 'sola'); ?>"><?php _e('Mobile', 'sola'); ?></a></li>
              <li><a href="javascript:void(0)" class="preview_button_button" id="preview_tablet" window_width="500px" add_class="preview_tablet" title="<?php _e('Tablet (iPad - Portrait)', 'sola'); ?>"><?php _e('Tablet (iPad - Portrait)', 'sola'); ?></a></li>
                <li><a href="javascript:void(0)" class="preview_button_button" id="preview_tablet_landscape" window_width="800px" add_class="preview_tablet_landscape" title="<?php _e('Tablet (Nexus 10 - Landscape)', 'sola'); ?>"><?php _e('Tablet (Nexus 10 - Landscape)', 'sola'); ?></a></li>
          </ul>
    </div>    
    
    <div id="sola_newsletter_preview" style="width: 800px;">            
        <div class="preview_desktop"  id="preview_container">
            <div class="preview_container">
                <?php        
                    if($camp->action == 3){
                        $letter = sola_nl_get_letter($camp->camp_id);

                        //$inserted_data = sola_nl_build_automatic_content($camp->camp_id,false);

                        //$table = preg_replace('/<table id="sola_nl_automatic_container"(.*?)<\/table>/is', $inserted_data, $letter);    
                        $table = '';
                        if($table == ''){
                            echo trim($letter);
                        } else {
                            echo trim($table);
                        }
                    } else {
                        $letter = sola_nl_get_letter($_GET['camp_id']);
                        if ($letter){
                            echo trim($letter);
                        } else {
                            trim(sola_nl_default_letter());
                        }             
                    }
                ?>    
            </div>
        </div>
    </div>
