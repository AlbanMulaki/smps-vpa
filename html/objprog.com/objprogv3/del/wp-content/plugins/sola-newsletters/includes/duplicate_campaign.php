<?php 
if(isset($_GET['camp_id'])){
    $camp = sola_nl_get_camp_details($_GET['camp_id']);
    $letter = sola_nl_get_letter($_GET['camp_id']);
    global $wpdb;
    global $sola_nl_camp_tbl;
    $wpdb->insert($sola_nl_camp_tbl, array('camp_id'=>'', 'subject'=> $camp->subject, 'theme_id' => $camp->theme_id, 'email' => $letter ));
    $camp_id = $wpdb->insert_id;
} else {
    exit();
}
?>
<div class="wrap">    
   <div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
   <h2><?php _e("Create a New Campaign","sola") ?></h2>
   <div>
      <form action="" method="POST">
          <input type="hidden" value="<?php if($camp_id){ echo $camp_id; }?>" name="camp_id" />
         <table>
            <tr>
               <td width="250px">
                  <label><h3>Subject</h3></label>
                  <p class="description"><?php _e("Give your campaign a subject line to make your subscribers take the bait!","sola"); ?></p>
               </td>
               <td>
                  <input type="text" class="sola-input-subject" name="subject" value="<?php if($camp){ echo $camp->subject; } ?>"/>
               </td>
            </tr>
            <tr>
               <td class="sola-td-vert">
                  <label>
                      <h3>
                        <?php _e("Select List","sola"); ?>
                      </h3>
                  </label>
                  <p class="description"><?php _e("Select a list you want to send this campaign to.","sola"); ?></p>
               </td>
               <td>
                  <?php $lists = sola_nl_get_lists();
                     foreach($lists as $list){?>
                     <input type="checkbox" name="sub_list[]" <?php if($camp && sola_nl_check_if_selected_list_camp($list->list_id, $camp->camp_id)) echo "checked=checked";?> value="<?php echo $list->list_id ?>"/>
                        <label><?php echo $list->list_name ?> (<?php echo sola_nl_total_list_subscribers($list->list_id) ?>)</label>
                        <p class="description"><?php echo $list->list_description ?></p>
                        <?php
                     }?>
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