<?php 
if(isset($_GET['camp_id'])){
    $camp = sola_nl_get_camp_details($_GET['camp_id']);
} else {
    $camp = false;
}
//var_dump($camp);


if (isset($camp->automatic_data)) { 
    $serialized_automatic_data = $camp->automatic_data;
    $automatic_data = maybe_unserialize($serialized_automatic_data);
} else {
    $automatic_data = false;
}

?>
<div class="wrap">    
   <div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
   <h2><?php _e("Create a New Campaign","sola") ?></h2>
   <div>
      <form action="" method="POST">
          <input type="hidden" value="<?php if ($camp) { echo $camp->camp_id; }?>" name="camp_id" />
         <table>
            <tr>
               <td width="250px">
                  <label><h3><?php _e('Newsletter Type', 'sola'); ?></h3></label>
                  <p class="description"><?php _e("Select what type of campaign you would like to create.","sola"); ?></p>
               </td>
               <td>
                   <h4>
                        <input type="radio" name="campaign_type" id="standard_newsletter" value="1" <?php if($camp && $camp->type != 2) { echo 'checked=checked'; } ?>/><?php _e('Standard Newsletter', 'sola'); ?>
                        &nbsp; <br />
                        <input type="radio" name="campaign_type" id="custom_newsletter" value="2" <?php if($camp && $camp->type == 2) { echo 'checked=checked'; } ?>/><?php _e('Automatic Newsletter (Beta)', 'sola'); ?>
                        &nbsp; <br />
                        <?php 
                        if(function_exists('sola_nl_register_pro_version')){ 
                            global $sola_nl_pro_version;
                            if (floatval($sola_nl_pro_version) > 2.3) { ?>
                                <input type="radio" name="campaign_type" id="custom_html" value="3" <?php if($camp && $camp->type == 3) { echo 'checked=checked'; } ?>/><?php _e('Custom HTML (Advanced)', 'sola'); ?>

                            <?php } else {
                               $pro_link = "<em><a href=\"http://solaplugins.com/my-account/\" target=\"_BLANK\">".__('Please upgrade your Pro version by logging into your account and downloading the latest version (2.4)', 'sola')."</a></em>"; 
                            ?><input type="radio" disabled/><?php echo __('Custom HTML (Advanced) ', 'sola').$pro_link; 
                            }
                        } else {
                            $pro_link = "<a href=\"http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=sola_nl_custom_html\" target=\"_BLANK\">".__('Premium Version Only', 'sola')."</a>"; 
                            ?><input type="radio" disabled/><?php echo __('Custom HTML (Advanced) ', 'sola').$pro_link; ?>

                            <?php
                        }
                                ?>
                   </h4>                   
               </td>
            </tr>
            
            <!--Custom Newsletter Option-->
            
            <tr id="custom-newsletter-block">
               <td width="250px">
                  <label><h3><?php _e('Automatically Send When: ', 'sola'); ?></h3></label>
                  <p class="description"><strong><?php _e('Please note this functionality is still in beta.', 'sola'); ?></strong><br/><?php _e("You can choose exactly when a newsletter is sent out.","sola"); ?></p>
               </td>
               <td>
                   <select id="sola-nl-action" name="sola_nl_action">
                       <option id="action-default" value="sola_nl_action_default"><?php _e('When I...','sola'); ?></option>
                       <option id="new-post" value="3"><?php _e('When I publish a new post', 'sola'); ?></option>
                       <option id="new-sub" value="4"><?php _e('When someone subscribes to my list', 'sola'); ?></option>
                       <option id="new-user" value="5"><?php _e('When a new user is added to my site', 'sola'); ?></option>
                   </select>
                   
                   <select id="sola-nl-time-slot" style="display: none; " name="sola_nl_time_slot">
                       <option value=""></option>
                       <option id="time-slot-daily" value="1"><?php _e('Daily at:', 'sola'); ?></option>                       
                       <option id="time-slot-weekly" value="2"><?php _e('Weekly on:', 'sola'); ?></option>
                       <!--<option id="time-slot-monthly-on" value="3"><?php // _e('Monthly on the:', 'sola'); ?></option>-->
                       <option id="time-slot-immediately" value="5"><?php _e('Immediately', 'sola'); ?></option>
                   </select>
                   
                   <select id="sola-nl-monthly-day" style="display: none;" name="sola_nl_monthly_day">
                       <option value=""></option>
                       <?php
                        for($i = 1; $i <= 28; $i++){
                            echo '<option value="'.$i.'">'.$i. ordinal($i).'</option>';
                        }
                       ?>
                   </select>
                   
                   <select id="sola-nl-monthly-every" style="display: none;" name="sola_nl_month_every">
                       <option value=""></option>
                       <option value="1"><?php _e('1st', 'sola'); ?></option>
                       <option value="2"><?php _e('2nd', 'sola'); ?></option>
                       <option value="3"><?php _e('3rd', 'sola'); ?></option>
                       <option value="4"><?php _e('Last', 'sola'); ?></option>
                   </select>
                   
                   <select id="sola-nl-days" style="display: none; " name="sola_nl_days">
                       <option value=""></option>
                       <option value="1"><?php _e('Mondays', 'sola'); ?></option>
                       <option value="2"><?php _e('Tuesdays', 'sola'); ?></option>
                       <option value="3"><?php _e('Wednesdays', 'sola'); ?></option>
                       <option value="4"><?php _e('Thursdays', 'sola'); ?></option>
                       <option value="5"><?php _e('Fridays', 'sola'); ?></option>
                       <option value="6"><?php _e('Saturdays', 'sola'); ?></option>
                       <option value="7"><?php _e('Sundays', 'sola'); ?></option>
                   </select>
                 
                   <select id="sola-nl-time" style="display: none; " name="sola_nl_time">
                       <option value=""></option>
                        <?php 
                            for($i=0; $i<=23; $i++){
                                for($ii=0; $ii<60; $ii+=5){
                                    if(strlen($i) == '1' && strlen($ii) == '1'){
                                        echo '<option value="'.'0'.$i .':'.'0'.$ii.'">'.'0'.$i .' : '.'0'.$ii.'</option>';
                                    } else if(strlen($i) == '1' && strlen($ii) == '2'){
                                        echo '<option value="'.'0'.$i .':'.$ii.'">'.'0'.$i .' : '.$ii.'</option>';
                                    } else if(strlen($i) == '2' && strlen($ii) == '1'){
                                        echo '<option value="'.$i .':'.'0'.$ii.'">'.$i .' : '.'0'.$ii.'</option>';
                                    } else if(strlen($i) == '2' && strlen($ii) == '2'){
                                        echo '<option value="'.$i .':'.$ii.'">'.$i .' : '.$ii.'</option>';
                                    }
                                }
                            }
                        ?>
                    </select>                  
                    <select id="sola-nl-role" style="display: none; " name="sola_nl_roles">
                       <option value=""></option>
                       <option value="1"><?php _e('All Roles', 'sola'); ?></option>
                       <option value="2"><?php _e('Administrator', 'sola'); ?></option>
                       <option value="3"><?php _e('Editor', 'sola'); ?></option>
                       <option value="4"><?php _e('Author', 'sola'); ?></option>
                       <option value="5"><?php _e('Contributor', 'sola'); ?></option>
                       <option value="6"><?php _e('Subscriber', 'sola'); ?></option>                       
                    </select>
                   
                   <input type="text" style="width: 50px; display: none;" id="sola-nl-custom-time" name="sola_nl_custom_time" value=""/>
                   
                   <select id="sola-nl-time-after" style="display: none; " name="sola_nl_time_after">
                       <option value=""></option>
                       <option id="sola-nl-after-minutes" value="1"><?php _e('Minute(s) After', 'sola'); ?></option>                       
                       <option id="sola-nl-after-hours" value="2"><?php _e('Hour(s) After', 'sola'); ?></option>
                       <option id="sola-nl-after-days" value="3"><?php _e('Day(s) After', 'sola'); ?></option>
                       <option id="sola-nl-after-weeks" value="4"><?php _e('Week(s) After', 'sola'); ?></option>
                       <option id="sola-nl-after-immediate" value="5"><?php _e('Immediately', 'sola'); ?></option>
                   </select>
               </td>
            </tr>
            <tr>
               <td width="250px">
                  <label><h3><?php _e('Subject', 'sola'); ?></h3></label>
                  <p class="description"><?php _e("Give your campaign a subject line to make your subscribers take the bait!","sola"); ?></p>
                  <p class="description"><?php _e('Use a shortcode to enhance your subject line', 'sola'); ?>
               </td>
               <td>
                  <input type="text" class="sola-input-subject" name="subject" value="<?php if($camp){ echo $camp->subject; } ?>"/>
                  <small id="shortcodes-desc"><?php echo '<br/>[sola_nl_blog_name] [sola_nl_post_author] [sola_nl_post_title] [sola_nl_post_count]'; ?></small>
               </td>
            </tr>
            <tr id="sola-nl-list-row">
               <td class="sola-td-vert">
                  <label>
                      <h3>
                        <?php _e("Select List","sola"); ?>
                      </h3>
                  </label>
                  <p class="description"><?php _e("Select a list you want to send this campaign to.","sola"); ?></p>
               </td>
               <td>
                  <?php 
                  if (isset($camp->status) && $camp->status == 9) {
                   ?><p class="description" style="color:red;"><?php echo __("You cannot edit the list while the campaign is being sent, or the sending has been paused","sola"); ?></p>
                     <?php
                     $lists = sola_nl_get_lists();
                     foreach($lists as $list){?>
                     <input style='display:none;' type="checkbox" name="sub_list[]" <?php if($camp && sola_nl_check_if_selected_list_camp($list->list_id, $camp->camp_id)) echo "checked=checked";?> value="<?php echo $list->list_id ?>"/>
                        <label style='display:none;'><?php echo $list->list_name ?> (<?php echo sola_nl_total_list_subscribers($list->list_id) ?>)</label>
                        <p class="description" style='display:none;'><?php echo $list->list_description ?></p>
                  <?php }
                  }else {                      
                    $lists = sola_nl_get_lists();
                     foreach($lists as $list){?>
                     <input type="checkbox" name="sub_list[]" <?php if($camp && sola_nl_check_if_selected_list_camp($list->list_id, $camp->camp_id)) echo "checked=checked";?> value="<?php echo $list->list_id ?>"/>
                        <label><?php echo $list->list_name ?> (<?php echo sola_nl_total_list_subscribers($list->list_id) ?>)</label>
                        <p class="description"><?php echo $list->list_description ?></p>
                  <?php } }  ?>
               </td>
            </tr>                        
            <tr>
               <td>
                   <?php if(isset($_GET["camp_id"])){ ?>
                        <input type='submit' name='sola_nl_edit_camp' class='button-primary' value='<?php _e("Edit Letter","sola") ?>' />
                        <?php
                   } else { ?>
                        <input type='submit' name='sola_nl_new_camp' class='button-primary' value='<?php _e("Next","sola") ?>' />
                        <?php
                   }?>
               </td>
            </tr>
         </table>
      </form>
   </div>
</div>
<?php include 'footer.php'; 