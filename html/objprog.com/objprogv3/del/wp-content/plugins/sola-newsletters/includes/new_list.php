<?php 
if(isset($_GET['list_id'])){
    $list = sola_nl_get_list($_GET['list_id']);
} else {
    $list = false;
}
?>
<div class="wrap">        
    
   <h2>
      <?php _e("New List","sola") ?>
   </h2>
   <form action="admin.php?page=sola-nl-menu-lists" method="post">
      <input type="hidden" value="<?php if($list){ echo $list->list_id; }?>" name="list_id" />
      <table>
         <tr>
            <td width="250px">
               <label><?php _e('List Name', 'sola'); ?></label>
               <p class="description"><?php _e('Give Your List a Name. Tech, Cars, Music ect.', 'sola'); ?></p>
            </td>
            <td>
               <input type="text" name="list_name" class='sola-input' value="<?php if($list){ echo $list->list_name; } ?>"/>
            </td>
         </tr>
         <tr>
            <td>
               <label><?php _e('Description', 'sola'); ?></label>
               <p class="description"><?php _e("Give Your list a description. Don't worry, your subscribers won't see this.", "sola"); ?></p>
            </td>
            <td>
               <textarea name='list_description' class='sola-input'><?php if($list){ echo $list->list_description; } ?></textarea>
            </td>
         </tr>
         <tr>
            <td>
               <p class='submit'>
                  <?php if (isset($_GET['list_id'])){?>
                     <input type='submit' name='sola_nl_edit_list' class='button-primary' value='<?php _e("Save List","sola") ?>' />
                     <?php 
                  }else {?>
                     <input type='submit' name='sola_nl_new_list' class='button-primary' value='<?php _e("Add List","sola") ?>' />
                     <?php 
                  }?>
                  
               </p>
            </td>
         </tr>
      </table>
   </form>
</div>
<?php include 'footer.php'; ?>