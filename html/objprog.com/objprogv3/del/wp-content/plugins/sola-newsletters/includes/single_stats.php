<?php 

global $sola_nl_camp_subs_tbl;
global $sola_nl_link_tracking_table;
global $sola_nl_subs_list_tbl;
global $sola_nl_subs_tbl;
global $wpdb;

$camp_id = $_GET['camp_id'];
?>
<div id="wpbody-content"> 
        <div class="wrap">
        <a href="admin.php?page=sola-nl-menu&action=camp_stats&camp_id=<?php echo $camp_id; ?>" class="button button-primary">Return To Stats</a>
<?php
if (isset($_GET['sent'])) {
    $subs = sola_nl_get_camp_subs($camp_id, true);
?>
<h3><?php _e("Your campaign was sent to the following subscribers:","sola"); ?></h3>
<table class="wp-list-table widefat">
    <thead>
        <tr>
            <th>
            </th>
            <th class="manage-column column-title">
                <span><?php _e("Subscriber Name","sola"); ?></span>
            </th>
            <th class="manage-column column-title">
                <span><?php _e("Subscriber Email Address","sola"); ?></span>
            </th>
            <th>
                <span><?php _e("Open Date", "sola"); ?></span>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 1;
            foreach($subs as $sub){
            $result = sola_nl_get_subscriber($sub->sub_id);
        ?>
        <tr>
            <td>
                <?php echo $i; ?>
            </td>
            <td>
                <a href="admin.php?page=sola-nl-menu&action=new_subscriber&sub_id=<?php echo $sub->sub_id; ?>" title="Edit This Subscriber For Future Use"><?php echo $result->sub_name; ?></a>
            </td>
            <td>
                <?php echo $result->sub_email; ?>
            </td>
            <td>
                <?php 
                    if($sub->date_open != '0000-00-00 00:00:00'){
                        echo $sub->date_open;
                    } else {
                        echo 'Unopened';
                    }
                ?>
            </td>
        </tr>
        <?php $i++; } ?>
    </tbody>                
</table>
    
<?php } else if (isset($_GET['n_sent'])) { ?>
<?php $subs = sola_nl_get_camp_subs_errors($camp_id); ?>

<h3><?php _e("There were errors when trying to send to the following addresses:","sola"); ?></h3>
<table class="wp-list-table widefat">
    <thead>
        <tr>
            <th>
            </th>
            <th class="manage-column column-title">
                <span><?php _e("Subscriber Name","sola"); ?></span>
            </th>
            <th class="manage-column column-title">
                <span><?php _e("Subscriber Email Address","sola"); ?></span>
            </th>
            <th>
                <span><?php _e("Open Date", "sola"); ?></span>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 1;
            foreach($subs as $sub){
            $result = sola_nl_get_subscriber($sub->sub_id);
        ?>
        <tr>
            <td>
                <?php echo $i; ?>
            </td>
            <td>
                <a href="admin.php?page=sola-nl-menu&action=new_subscriber&sub_id=<?php echo $sub->sub_id; ?>" title="Edit This Subscriber For Future Use"><?php echo $result->sub_name; ?></a>
            </td>
            <td>
                <?php echo $result->sub_email; ?>
            </td>
            <td>
                <?php 
                    if($sub->date_open != '0000-00-00 00:00:00'){
                        echo $sub->date_open;
                    } else {
                        echo 'Unopened';
                    }
                ?>
            </td>
        </tr>
        <?php $i++; } ?>
    </tbody>                
</table>

<?php } ?>
    </div>
</div>