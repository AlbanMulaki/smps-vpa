<div class='wrap'>
        
    
   <div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
   
   <h2>
      <?php _e("Import Subscribers","sola") ?>
   </h2>
   <p><?php _e("We suggest copying and pasting 200 lines at a time to avoid the script from timing out.","sola"); ?></p>
   
   
   <form action='' method='post' enctype="multipart/form-data">
      <input type='hidden' name='sub_id' class='sola-input' value="<?php if(isset($subscriber->sub_id)) {  echo $subscriber->sub_id; } ?>"/>
      <table style='width:100%;' cellpadding='10'>
         <tr>
            <td width='150px' valign='top'>
               <label><strong><?php _e("Copy/Paste from Excel","sola"); ?></strong></label>
            </td>
            <td>
                <textarea name='sub_import_excel' id='sub_import_excel' style='width:70%; height:300px;' placeholder='Email address, First name, Last name'><?php if(isset($_POST['sub_import_excel'])) { echo $_POST['sub_import_excel']; } ?></textarea>
            </td>
         </tr>
         <tr>
            <td width='150px' valign='top'>
               <hr />
            </td>
            <td>
                <hr />
            </td>
         </tr>
         <tr>
            <td width='150px' valign='top'>
               <label><strong><?php _e("Or upload a CSV file","sola"); ?></strong></label>
            </td>
            <td>
                <input type="file" name="sub_import_file" /><br />
                <input name="sub_data_replace_csvreplace" type="checkbox" value="Yes" /><?php _e("Replace existing data with data in file","sola"); ?>
                <br />
                <p class="description"><?php _e("The file must have comma seperated values in the following format:","sola"); ?>
                    <br />
                    <strong><?php _e("email@address.com,\"First name\",\"Last Name\"","sola"); ?></strong>
                    <br />
                    <?php _e("Ensure that words that contain spaces are encapsulated with double quotes.","sola"); ?>
                    <br />
                    <?php _e("Expected time delays: two to three minutes per every 1000 subscribers","sola"); ?>
                    <br />
                    <?php _e("For more information, please visit ","sola"); ?><a href="http://solaplugins.com/documentation/sola-newsletters-documentation/uploading-subscribers-via-csv/" title="Help with uploading CSV files">http://solaplugins.com/documentation/sola-newsletters-documentation/uploading-subscribers-via-csv/</a>
                </p>
            </td>
         </tr>      
         <tr>
            <td class="sola-td-vert" >
               <label><strong>
                  List
               </strong></label>
               <p class="description"><?php _e("Select a list to add these subscriber to. Subscribers can be on multiple lists.","sola"); ?></p>
            </td>
            <td >
               <?php $lists = sola_nl_get_lists();
               foreach($lists as $list){?>
               <input type="checkbox" name="sub_list[]" value="<?php echo $list->list_id ?>"/>
                  <label><?php echo $list->list_name ?> (<?php echo sola_nl_total_list_subscribers($list->list_id) ?>)</label>
                  <p class="description"><?php echo $list->list_description ?></p>
                  <?php
               }?>
               
               
            </td>
         </tr>
         <tr>
            <td>
               <p class='submit'>
                     <input type='submit' name='sola_nl_import_subscribers' class='button-primary' value='<?php _e("Import","sola") ?>' />
               </p>
            </td>
         </tr>
      </table>
   </form>
</div>
<?php include 'footer.php'; ?>