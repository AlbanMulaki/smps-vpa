<?php $camp_id = $_GET['camp_id'];
 
$result = sola_nl_get_camp_details($camp_id);
$links_array = sola_nl_camp_links($camp_id);
$lists = sola_nl_get_camp_lists($camp_id);

global $sola_nl_camp_subs_tbl;
global $wpdb;
        
$sql = "SELECT COUNT(`id`) as `total` FROM `$sola_nl_camp_subs_tbl` WHERE `camp_id` = '$camp_id'";
$sdf = $wpdb->get_row($sql);
$total_subscribers = $sdf->total;
$sql = "SELECT COUNT(`id`) as `total` FROM `$sola_nl_camp_subs_tbl` WHERE `camp_id` = '$camp_id' AND `status` >= 1";
$sdf = $wpdb->get_row($sql);
$total_sent = $sdf->total;
$sent_perc = round((($total_sent / $total_subscribers)*100),1);

if(function_exists('sola_nl_register_pro_return_stats')){
    //Return stats for current campaign
    $stats = sola_nl_register_pro_return_stats($camp_id);

    $total_opens = $stats['opens'];
    $total_sent = $stats['sent'];
    
    if(($total_opens != 0) && ($total_sent != 0)){
        $open_rate = round((($total_opens / $total_sent)*100),2)."%";
    } else {
        $open_rate = 0;
    }
    
} else {
    $stats = '';
}

?>

<style>
    
tr.even td.sorting_1 {
    background-color: #ffe1db;
}    
tr.even {
    background-color: #ffe1db;
}    
</style>
<div id="wpbody-content"> 
    <div class="wrap">
        <div class="container-fluid">
            <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert" style="background-color: #FFF; text-align: center;">                            
                            <h3><?php _e("Campaign Details For: ","sola"); ?><?php echo stripslashes($result->subject) ?></h3>
                            <p class="text-muted small" style="text-align: center;"><?php _e("Date Sent","sola"); ?>: <?php echo date('l jS \of F Y h:i:s A',strtotime($result->date_sent)) ?></p>
                            <p>
                                <?php if ($result->status == 3) { ?>
                                    <label class="label label-warning"><?php _e("Send In Progress ","sola"); ?><?php echo $sent_perc."%"; ?></label>
                                <?php } else { ?>
                                    <label class="label label-success"><?php _e("Send Complete ","sola"); ?><?php echo $sent_perc."%"; ?></label>
                                <?php } ?>
                            </p>
                            <div style="height:25px;"></div>                                 
                            <div class="row">
                                <div class="col-sm-4">
                                    <h4><?php _e("Lists Used:","sola"); ?></h4>
                                    <ul>
                                        <?php foreach($lists as $list){
                                            echo "<li><a href='admin.php?page=sola-nl-menu-subscribers&list_id=".$list->list_id."' title='".$list->list_name." - View Subscribers'>".$list->list_name."</a></li>";
                                        }?>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <h4><?php _e("Subscribers:","sola"); ?></h4><p><?php echo number_format($total_subscribers); ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <h4><?php _e("Successfully sent:","sola"); ?></h4><p><?php echo number_format($total_sent); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="alert" style="background-color: #FFF; text-align: center;">   
                            <?php $mails_sent = sola_nl_get_camp_stats($camp_id,'', true); ?>
                            <?php $mails_send_errors = sola_nl_get_camp_stats($camp_id,9, true); ?>
                            <h2><a href="admin.php?page=sola-nl-menu&action=single_sub_stats&camp_id=<?php echo $camp_id; ?>&sent=<?php echo $mails_sent; ?>"><?php echo $mails_sent; ?></a></h2>
                            <p><?php _e("Total Emails Sent","sola"); ?></p>
                            
                            <p><a href="admin.php?page=sola-nl-menu&action=single_sub_stats&camp_id=<?php echo $camp_id; ?>&n_sent=<?php echo $mails_send_errors; ?>"><?php echo $mails_send_errors; ?> <?php _e("error","sola"); ?></a></p>
                        </div>    
                    </div>
                    <div class="col-sm-3">
                        <div class="alert" style="background-color: #FFF; text-align: center;"> 
                            <?php if(function_exists('sola_nl_register_pro_version')){ ?>
                            <?php $get_total_opens = sola_nl_get_total_opens($camp_id, ''); ?>
                            <h2><a href="admin.php?page=sola-nl-menu&action=single_sub_stats&camp_id=<?php echo $camp_id; ?>&opened=<?php echo $get_total_opens; ?>"><?php echo $get_total_opens; ?></a></h2>
                            <?php } else { ?>
                            <h4><?php _e('Go','sola')?> <a target='_BLANK' href='http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=stats_opens' style='color:#EC6851;'><?php _e('Premium','sola')?> </a><?php _e('to get these stats and more!','sola')?></h4>
                            <?php } ?>
                            <p><?php _e("Total Opens","sola"); ?></p>
                        </div>    
                    </div>
                    <div class="col-sm-3">
                        <div class="alert" style="background-color: #FFF; text-align: center;">
                            <?php if(function_exists('sola_nl_register_pro_version')){ ?>
                            <h2><a href="admin.php?page=sola-nl-menu&action=single_sub_stats&camp_id=<?php echo $camp_id; ?>&opened=<?php echo $stats['opens']; ?>"><?php echo $stats['opens']; ?></a></h2>                            
                            <?php } else { ?>
                            <h4><?php _e('Go','sola')?> <a target='_BLANK' href='http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=stats_opens' style='color:#EC6851;'><?php _e('Premium','sola')?> </a><?php _e('to get these stats and more!','sola')?></h4>
                            <?php } ?>
                            <p><?php _e("Total Unique Opens","sola"); ?></p>
                        </div>    
                    </div>
                    <div class="col-sm-3">
                        <div class="alert" style="background-color: #FFF; text-align: center;">                              
                            <?php if(function_exists('sola_nl_register_pro_version')){ ?>
                            <?php $clicks = sola_nl_get_link_clcks('',$camp_id); ?>
                            <h2><a href="admin.php?page=sola-nl-menu&action=single_sub_stats&camp_id=<?php echo $camp_id; ?>&clicks=<?php echo $clicks; ?>"><?php echo $clicks; ?></a></h2>
                            <?php } else { ?>
                            <h4><?php _e('Go','sola')?> <a target='_BLANK' href='http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=stats_opens' style='color:#EC6851;'><?php _e('Premium','sola')?> </a><?php _e('to get these stats and more!','sola')?></h4>
                            <?php } ?>
                            <p><?php _e("Total Clicks","sola"); ?></p>
                        </div>    
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        
                        <div class="alert" style="background-color: #FFF; text-align: center;"> 
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php 
                                    if(function_exists('sola_nl_register_pro_version')) { 
                                    ?>
                                    <div id="open_rate"></div>
                                    <div style="height: 25px;"></div>
                                    <p><strong><?php echo $open_rate; ?></strong> <?php _e('Open Rate',"sola"); ?></p>
                                    <?php } else { ?>
                                        <h4><?php _e('Go','sola')?> <a target='_BLANK' href='http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=stats_opens' style='color:#EC6851;'><?php _e('Premium','sola')?> </a><?php _e('to get these stats and more!','sola')?></h4>
                                    <p><?php _e('Open Rate',"sola"); ?></p>
                                    <?php } ?>
                                    
                                </div>
                                <div class="col-sm-6">
                                    <?php 
                                    if(function_exists('sola_nl_register_pro_version')) { 
                                        $average_open_rate = sola_nl_average_open_rate();
                                    ?>
                                    <div id="average_rate"></div>
                                    <div style="height: 25px;"></div>
                                    <p><strong><?php echo $average_open_rate; ?>%</strong> <?php _e('Average Open Rate',"sola"); ?></p>
                                    <?php } else { ?>
                                        <h4><?php _e('Go','sola')?> <a target='_BLANK' href='http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=stats_opens' style='color:#EC6851;'><?php _e('Premium','sola')?> </a><?php _e('to get these stats and more!','sola')?></h4>
                                    <p><?php _e('Average Open Rate',"sola"); ?></p>
                                    <?php } ?>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(function_exists('sola_nl_register_pro_version')){
    $open_rate = intval($open_rate);
    $open_rate = json_encode(array('open-rate'=>$open_rate, 'avg-open-rate'=>$average_open_rate));
    ?>
    <script type="text/javascript">
        var values_open = <?php echo $open_rate; ?>;
        var avg_open_rate = values_open['open-rate'];
        var difference = 100 - avg_open_rate;
    </script>
<?php } ?>
