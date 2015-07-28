<?php 
$current_page = 1;
$order = "DESC";
if (isset($_SESSION['sola_nl_success'])) {
    echo "<div id=\"message\" class=\"updated\"><p>".$_SESSION['sola_nl_success']."</p></div>";
    unset($_SESSION['sola_nl_success']);
}
$orderBy = "created";
$limit = 10;
if(isset($_GET["p"])){
    $current_page = $_GET["p"];
}
if(isset($_GET["order"])){
    $order = $_GET["order"];
}
if(isset($_GET["orderBy"])){
    $orderBy = $_GET["orderBy"];
}
if($order == "DESC"){
    $orderswop = "ASC";
} else {
    $orderswop = "DESC";
}
$lc_order = strtolower($order);

$order_url = "&order=".$order."&orderBy=".$orderBy;
if(isset($_GET['subscriber'])){
    $subscriber_search = $_GET['subscriber'];
    $subscribers = sola_nl_get_subscribers('', $limit, $current_page, $order, $orderBy, $subscriber_search);
} else if(isset($_GET['list_id'])){
    $subscribers = sola_nl_get_subscribers($_GET['list_id'], $limit, $current_page, $order, $orderBy);
} else if (isset($_GET['list_id']) && isset($_GET['subscriber'])){
    $subscribers = sola_nl_get_subscribers($_GET['list_id'], $limit, $current_page, $order, $orderBy, $subscriber_search);
}else {
    $subscribers = sola_nl_get_subscribers('', $limit, $current_page, $order, $orderBy);
}
$total_rows = sola_nl_get_total_subs();
$total_pages = ceil($total_rows/$limit);

?>
<div class='wrap'>        
    
    <div id="icon-users" class="icon32 icon32-posts-post"><br></div>
    <h2>
        <?php _e("Subscribers","sola") ?>
      <a href="?page=sola-nl-menu&action=new_subscriber" class="add-new-h2"><?php _e("Add Subscriber","sola") ?></a>
      <a href="?page=sola-nl-menu&action=import" class="add-new-h2"><?php _e("Import Subscribers","sola") ?></a>
      <a href="?page=sola-nl-menu&action=sola_csv_export" target="_BLANK" class="add-new-h2"><?php _e("Export Subscribers","sola") ?></a>
    </h2>
    <form method="get" action="">
        <p class="search-box">   
            <input type="hidden" id="sola_nl_search_input" name="page" value="sola-nl-menu-subscribers">
            <input type="search" id="sola_nl_search_input" name="subscriber" value="">
            <input type="submit" name="" id="search-submit" class="button" value="Search Subscribers">
        </p>        
    </form>

    <form action="admin.php?page=sola-nl-menu-subscribers" method="post">
        <div class="tablenav top">
            <div class="alignleft">
                <button class="button-primary" name="action" value="sola-delete-subs" >Delete</button>
            </div>
            <div class="tablenav-pages">
                <span class="displaying-num"><?php echo $total_rows ?><?php _e("items", "sola") ?></span>
                <span class="pagination-links">
                    
                    <a class="first-page <?php if($current_page == 1){echo "disabled";} ?>" title="Go to the first page" <?php if($current_page != 1) { ?>href="<?php echo $_SERVER['PHP_SELF'];?>?page=sola-nl-menu-subscribers&p=<?php echo "1"; echo $order_url; ?>" <?php } ?>>«</a>
                    <a class="prev-page <?php if($current_page == 1){echo "disabled";} ?>" title="Go to the previous page" <?php if($current_page != 1) { ?> href="<?php echo $_SERVER['PHP_SELF'];?>?page=sola-nl-menu-subscribers&p=<?php echo $current_page-1; echo $order_url; ?>"<?php } ?>>‹</a>
                    <span class="paging-input"><?php echo $current_page ?> of <span class="total-pages"><?php echo $total_pages ?></span></span>
                    <a class="next-page <?php if($current_page >= $total_pages){echo "disabled";} ?>" title="Go to the next page" <?php if($current_page < $total_pages) { ?>href="<?php echo $_SERVER['PHP_SELF'];?>?page=sola-nl-menu-subscribers&p=<?php echo $current_page+1; echo $order_url; ?>" <?php } ?>>›</a>
                    <a class="last-page <?php if($current_page >= $total_pages){echo "disabled";} ?>" title="Go to the last page" <?php if($current_page < $total_pages) { ?>href="<?php echo $_SERVER['PHP_SELF'];?>?page=sola-nl-menu-subscribers&p=<?php echo $total_pages; echo $order_url; ?>" <?php } ?>>»</a>
                </span>
            </div>
        </div>
        <table class="wp-list-table widefat fixed">
            <thead>
                <tr>
                    <th class="manage-column column-cb check-column">
                        <input id="sola_check_all" type="checkbox" >
                    </th>
                    <th class="manage-column column-title sorted <?php if($orderBy == "sub_name"){ echo $lc_order; } ?>">
                        <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=sola-nl-menu-subscribers&p=<?php echo $current_page; ?>&order=<?php echo $orderswop ?>&orderBy=sub_name">
                            <span><?php _e("Name","sola") ?></span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </th>
                    <th class="manage-column column-title sorted <?php if($orderBy == "sub_email"){ echo $lc_order; } ?>">
                        <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=sola-nl-menu-subscribers&p=<?php echo $current_page; ?>&order=<?php echo $orderswop ?>&orderBy=sub_email">
                            <span><?php _e("E-mail","sola") ?></span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </th>
                    <th class="manage-column column-title sorted <?php if($orderBy == "status"){ echo $lc_order; } ?>">
                        <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=sola-nl-menu-subscribers&p=<?php echo $current_page; ?>&order=<?php echo $orderswop ?>&orderBy=status">
                            <span><?php _e("Status","sola") ?></span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </th>
                    <th class="manage-column column-title">
                        <span><?php _e("List","sola") ?></span>
                    </th>
                    <th class="manage-column column-title sorted <?php if($orderBy == "created"){ echo $lc_order; } ?>">
                        <a href="<?php echo $_SERVER['PHP_SELF'];?>?page=sola-nl-menu-subscribers&p=<?php echo $current_page; ?>&order=<?php echo $orderswop ?>&orderBy=created">
                            <span><?php _e("Date","sola") ?></span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($subscribers as $subscriber){?>
                    <tr>
                        <td>
                            <input type="checkbox" name="sola_check_subs[]" value="<?php echo  $subscriber->sub_id ?>" class="sola-check-box">
                        </td>
                        <td>
                        <strong>
                            <a href="?page=sola-nl-menu&action=new_subscriber&sub_id=<?php echo $subscriber->sub_id ?>">
                                <?php if($subscriber->sub_name){
                                    echo $subscriber->sub_name; 
                                } else {
                                    _e("(No Name)","sola");
                                } ?>
                            </a>
                        </strong>
                        <div class="row-actions">
                            <span>
                                <a href="?page=sola-nl-menu&action=new_subscriber&sub_id=<?php echo $subscriber->sub_id ?>">Edit</a>
                            </span> |
                            <span class="trash">
                                <a href="?page=sola-nl-menu-subscribers&action=delete_subscriber&sub_id=<?php echo $subscriber->sub_id ?>" >Delete</a>
                            </span>
                        </div>
                        </td>
                        <td>
                            <?php echo $subscriber->sub_email ?>
                        </td>
                        <td>
                            <?php sola_nl_subscriber_status($subscriber->status) ?>
                        </td>
                        <td>
                            <?php $lists = sola_nl_get_subscriber_list($subscriber->sub_id);
                            $i = 0;
                            foreach($lists as $list){
                                if($i > 0) echo ", ";?>
                                <a href="?page=sola-nl-menu-subscribers&list_id=<?php echo $list->list_id ?>"><?php echo $list->list_name; ?></a><?php
                                $i++;
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo date('Y-m-d',  strtotime($subscriber->created))?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="manage-column column-cb check-column">
                        <input id="sola_check_all" type="checkbox" >
                    </th>
                    <th><?php _e("Name","sola") ?></th>
                    <th><?php _e("E-mail","sola") ?></th>
                    <th><?php _e("Status","sola") ?></th>
                    <th><?php _e("List","sola") ?></th>
                    <th><?php _e("Date","sola") ?></th>
                </tr>
            </tfoot>
        </table>       
    </form>
</div>
<?php include 'footer.php'; ?>