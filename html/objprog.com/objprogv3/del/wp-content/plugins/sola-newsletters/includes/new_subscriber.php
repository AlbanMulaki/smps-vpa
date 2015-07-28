<?php if(isset($_GET['sub_id'])){
    $subscriber = sola_nl_get_subscriber($_GET['sub_id']); 
} else {
    $subscriber = false;
}
?>
<div class='wrap'>
        
    
   <div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
   
   <h2>
      <?php _e("Add Subscriber","sola") ?>
   </h2>
   
   
   <form action='?page=sola-nl-menu-subscribers' method='post'>
      <input type='hidden' name='sub_id' class='sola-input' value="<?php if($subscriber){ echo $subscriber->sub_id; } ?>"/>
      <table  >
         <tr>
            <td width='250px'>
               <label>Subscriber Email</label>
               <p class='description'>Put you subscribers E-mail Address here</p>
            </td>
            <td width="300px"><input type='email' name='sub_email' class='sola-input' value="<?php if($subscriber){ echo $subscriber->sub_email; }?>"/></td>
         </tr>
         <tr>
            <td>
               <label>Subscriber Name</label>
               <p class='description'>If your subscriber has name, put it here</p>
            </td>
            <td><input type='text' name="sub_name" class='sola-input' value="<?php if($subscriber){ echo $subscriber->sub_name; } ?>"/></td>         
         </tr>
         <tr>
            <td class="sola-td-vert" >
               <label>
                  List
               </label>
               <p class="description">Select a list to associate this subscriber with. Subscribers can be on multiple lists.</p>
            </td>
            <td >
               <?php $lists = sola_nl_get_lists();
               foreach($lists as $list){?>
               <input type="checkbox" name="sub_list[]" <?php if($subscriber && sola_nl_check_if_selected_list_sub($list->list_id, $subscriber->sub_id)) echo "checked=checked";?> value="<?php echo $list->list_id ?>"/>
                  <label><?php echo $list->list_name ?> (<?php echo sola_nl_total_list_subscribers($list->list_id) ?>)</label>
                  <p class="description"><?php echo $list->list_description ?></p>
                  <?php
               }?>
               
               
            </td>
         </tr>
         <tr>
            <td>
               <p class='submit'>
                  <?php if (isset($_GET['sub_id'])){?>
                     <input type='submit' name='sola_nl_edit_subscriber' class='button-primary' value='<?php _e("Save Subscriber","sola") ?>' />
                     <?php 
                  }else {?>
                     <input type='submit' name='sola_nl_new_subscriber' class='button-primary' value='<?php _e("Add Subscriber","sola") ?>' />
                     <?php 
                  }?>
               </p>
            </td>
         </tr>
      </table>
   </form>
</div>
<?php include 'footer.php'; ?>