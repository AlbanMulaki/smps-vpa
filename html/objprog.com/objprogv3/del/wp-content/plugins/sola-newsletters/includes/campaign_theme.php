<?php $camp_id = $_GET['camp_id']; 
$themes = sola_get_theme_basic();
?>
<div class="wrap">    
    <div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
    <h2><?php _e('Choose a Theme', "sola") ?></h2>
    
    <form method="post" action="admin.php?page=sola-nl-menu&action=theme&camp_id=<?php echo $camp_id ?>">
        <input type="hidden" value="<?php echo $camp_id ?>" name="camp_id">
        <div class="themes_wrapper">
            <?php 
            foreach($themes as $theme){
                ?>
                <div class="theme_div_wrapper">
                    <label>
                        <h3><?php echo ucfirst($theme->theme_name) ?></h3>
                        <input type="radio" name="theme_id" value="<?php echo $theme->theme_id ?>" <?php if($theme->theme_id == 1){ echo "checked";}?>>
                        <img src="<?php echo PLUGIN_DIR ?>/images/themes/<?php echo $theme->theme_name ?>.png" width="200px">
                    </label>
                </div>
                <?php 
            } ?>
            
        </div> 
        <hr>    
        <input type="submit" value="Next" class="button-primary" name="sola_set_theme">
    </form>  
    <hr/>
    <h2 class="text-center" ><?php _e('Go','sola')?> <a target='_BLANK' href='http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=more_themes' style='color:#EC6851;'><?php _e('Premium','sola')?> </a><?php _e('to get more themes!','sola')?></h2>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</div>
<?php include 'footer.php'; ?>