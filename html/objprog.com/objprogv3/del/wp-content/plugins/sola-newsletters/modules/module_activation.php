<?php
function sola_nl_activate() {
    sola_nl_handle_db();
    $blogname = get_option("blogname");
    $sig = __("This mail was created using the Sola Newsletters WordPress Plugin and was sent from","sola")." $blogname.\r\n<a href='http://solaplugins.com/plugins/sola-newsletters/' target='_BLANK'>solaplugins.com</a>";
    $admin_email = get_option( 'admin_email' );
    add_option("sola_nl_email_note", $admin_email);
    add_option("sola_nl_notifications", "1");
    add_option("sola_nl_sig","$sig");
    add_option("sola_nl_unsubscribe", __("Unsubscribe", "sola"));
    add_option("sola_nl_browser_text", __("Not Displaying? View In Browser", "sola"));
    add_option("sola_nl_sent_from","$admin_email");
    add_option("sola_nl_sent_from_name","$blogname");
    add_option("sola_nl_reply_to","$admin_email");
    add_option("sola_nl_reply_to_name", $blogname);
    add_option("sola_nl_send_method", "1");
    add_option("sola_nl_host",'');
    add_option("sola_nl_username");
    add_option("sola_nl_password",'');
    add_option("sola_nl_port",'');
    add_option("sola_nl_sign_up_title","Newsletter");
    add_option("sola_nl_sign_up_btn","Subscribe");
    add_option("sola_currently_sending","no");
    $array = serialize(array( 0 => 1));
    add_option("sola_nl_sign_up_lists",$array);
    add_option("sola_nl_encryption", "");
    add_option("sola_nl_utm_source","newsletter");
    add_option("sola_nl_utm_medium","email");
    $content = __("Thank you for signing up to our newsletter.","sola");
    $page_id = sola_nl_create_page('nl-confirm-signup','Newsletter Sign Up Confirmation',$content);
    add_option("sola_nl_confirm_page","$page_id");
    $content = __("We're sad to see you go.","sola");
    $page_id = sola_nl_create_page('nl-unsubscribe-page','Newsletter Unsubscription', $content);
    add_option("sola_nl_unsubscribe_page","$page_id");
    add_option("sola_nl_social_links", array(
        "twitter"=>"",
        "facebook"=>"",
        "pinterest"=>"",
        "linkedin"=>"",
        "google-plus"=>""
    ));
    add_option("sola_nl_hosting_provider", 0);
    add_option("sola_nl_send_limit_qty", 20);
    add_option("sola_nl_send_limit_time", 600);
    $confirmation_subject = __("Thank You For Subscribing","sola");
    add_option("sola_nl_confirm_subject", $confirmation_subject);
    $confirmation_mail = __("Hey [sub_name]!\n\rThank you for signing up to our newsletter.\n\rPlease click on this [confirm_link]link[/confirm_link] to activate your subscription.\n\rKind Regards\n\r","sola");
    add_option("sola_nl_confirm_mail", $confirmation_mail);
    $confirmation_thank_you = __("Thank You for signing up. You will receive a confirmation mail shortly.");
    add_option("sola_nl_confirm_thank_you", $confirmation_thank_you);
    $sola_cron_timestamp = wp_next_scheduled( 'sola_cron_send_hook' );
     if( $sola_cron_timestamp == false ){
        wp_schedule_event( time(), 'every_minute', 'sola_cron_send_hook' );  
    }
    add_option("solag_nl_first_time", true);
    add_option("sola_nl_enable_link_tracking", 1);

  
}

function sola_nl_deactivate() {
    wp_clear_scheduled_hook('sola_cron_send_hook');
}
function sola_cron_add_minutely( $schedules ) {
 	// Adds once weekly to the existing schedules.
 	$schedules['every_minute'] = array(
 		'interval' => 60,
 		'display' => __( 'Every Minute' )
 	);
 	return $schedules;
 }

function sola_nl_handle_db() {
   global $wpdb;
   global $sola_nl_subs_tbl;
   global $sola_nl_list_tbl;
   global $sola_nl_subs_list_tbl;
   global $sola_nl_camp_tbl;
   global $sola_nl_camp_list_tbl;
   global $sola_nl_camp_subs_tbl;
   global $sola_nl_style_table;
   global $sola_nl_style_elements_table;
   global $sola_nl_css_options_table;
   global $sola_nl_link_tracking_table;
   global $sola_nl_themes_table;
   global $sola_nl_advanced_link_tracking_table;
   
   
   $sql = "
        CREATE TABLE `$sola_nl_subs_tbl` (
         sub_id int(11) NOT NULL AUTO_INCREMENT,
         sub_email varchar(255) NOT NULL,
         sub_name varchar(255) NOT NULL,
         sub_last_name varchar(255) NOT NULL,
         sub_key mediumtext NOT NULL,
         created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
         status tinyint(1) NOT NULL DEFAULT '1', 
         sola_nl_mail_sent tinyint(1) NOT NULL DEFAULT '0',
         sola_nl_mail_sending_time datetime NOT NULL,
         PRIMARY KEY  (sub_id),
         UNIQUE KEY sub_email (sub_email)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;
    ";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);
   

   $sql = "
      CREATE TABLE `$sola_nl_list_tbl` (
         list_id int(11) NOT NULL AUTO_INCREMENT,
         list_name varchar(255) NOT NULL,
         list_description mediumtext NOT NULL,
         PRIMARY KEY  (list_id),
         UNIQUE KEY list_name (list_name)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;
       ";
   dbDelta($sql);
   
   $sql = "
      CREATE TABLE `$sola_nl_subs_list_tbl` (
         id int(11) NOT NULL AUTO_INCREMENT,
         sub_id int(11) NOT NULL,
         list_id int(11) NOT NULL,
         PRIMARY KEY  (id),
         KEY sub_id (sub_id),
         KEY list_id (list_id)
       ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;
    ";
   dbDelta($sql);
   
   $sql ="
     CREATE TABLE `$sola_nl_camp_tbl` (
        camp_id int(11) NOT NULL AUTO_INCREMENT,
        subject varchar(255) NOT NULL,
        email longtext NOT NULL,
        status int(1) NOT NULL DEFAULT '0',
        date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        date_sent datetime NOT NULL,
        last_save datetime NOT NULL,
        sent_from varchar(255) NOT NULL,
        sent_from_name varchar(255) NOT NULL,
        reply_to varchar(255) NOT NULL,
        reply_to_name varchar(255) NOT NULL,
        utm_campaign varchar(255) NOT NULL,
        last_sent datetime NOT NULL,
        time_frame_qty int(11) NOT NULL,
        theme_id int(11) NOT NULL,
        schedule_date datetime NOT NULL,
        styles longtext NOT NULL,
        type tinyint(1) NOT NULL,
        action tinyint(1) NOT NULL,
        automatic_data LONGTEXT NOT NULL,
      PRIMARY KEY  (camp_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ; 
   ";
   dbDelta($sql);
   
   $sql = "
      CREATE TABLE `$sola_nl_camp_list_tbl` (
         id int(11) NOT NULL AUTO_INCREMENT,
         camp_id int(11) NOT NULL,
         list_id int(11) NOT NULL,
         PRIMARY KEY  (id),
         KEY camp_id (camp_id,list_id)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;
      ";
   dbDelta($sql);
   
   $sql = "
       CREATE TABLE `$sola_nl_camp_subs_tbl` (
            id int(11) NOT NULL AUTO_INCREMENT,
            camp_id int(11) NOT NULL,
            sub_id int(11) NOT NULL,
            status tinyint(2) NOT NULL DEFAULT '0',
            date_open datetime NOT NULL,
            opens int(11) NOT NULL DEFAULT '0',
            PRIMARY KEY  (id),
            KEY camp_id (camp_id,sub_id)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;
       ";
   dbDelta($sql);
   
   $sql = "CREATE TABLE `$sola_nl_css_options_table` (
        id int(11) NOT NULL AUTO_INCREMENT,
        css_name varchar(255) NOT NULL,
        name varchar(255) NOT NULL,
        value varchar(255) NOT NULL,
        PRIMARY KEY  (id)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;";
   dbDelta($sql);
   
   $sql = "CREATE TABLE `$sola_nl_link_tracking_table` (
        id int(11) NOT NULL AUTO_INCREMENT,
        sub_id int(11) NOT NULL,
        camp_id int(11) NOT NULL,
        link_name text NOT NULL,
        link text NOT NULL,
        clicked int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;";
   dbDelta($sql);
    
    $sql = "CREATE TABLE `$sola_nl_advanced_link_tracking_table` (
        id int(11) NOT NULL AUTO_INCREMENT,
        sub_id int(11) NOT NULL,
        camp_id int(11) NOT NULL,
        link_name text NOT NULL,
        user_agent VARCHAR(255) NOT NULL,
        ip_address VARCHAR(255) NOT NULL,
        country VARCHAR(255) NOT NULL,
        region_name VARCHAR(255) NOT NULL,
        timezone VARCHAR(255) NOT NULL,
        isp VARCHAR(255) NOT NULL,
        lat VARCHAR(255) NOT NULL,
        lon VARCHAR(255) NOT NULL,
        date_clicked DATETIME NOT NULL,
        PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;";
   dbDelta($sql);
   
   
   $sql = "CREATE TABLE `$sola_nl_themes_table` (
        theme_id int(11) NOT NULL AUTO_INCREMENT,
        theme_name varchar(255) NOT NULL,
        theme_html longtext NOT NULL,
        styles longtext NOT NULL,
        version int(11) NOT NULL,
        PRIMARY KEY  (theme_id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1 ;";
   dbDelta($sql);
   
   sola_nl_add_wp_user_to_sub();
   sola_nl_add_default_editor_style();
}
function sola_nl_add_wp_user_to_sub(){
   global $wpdb;
   global $sola_nl_subs_tbl;
   global $sola_nl_list_tbl;
   global $sola_nl_subs_list_tbl;
   global $sola_nl_camp_tbl;
   global $sola_nl_camp_list_tbl;
   $sql = "SELECT * FROM `$sola_nl_camp_tbl`";
   if(!$wpdb->get_results($sql)){
        $wp_users = get_users('role=Administrator');
        $wpdb->insert($sola_nl_list_tbl, array('list_id' => '', 'list_name' => 'My First List', 'list_description' => 'This is your first list.'));
        $list_id = $wpdb->insert_id;
        $styles = sola_nl_default_styles_array();
        $wpdb->insert($sola_nl_camp_tbl, array('camp_id'=>'', 'subject'=> "My First Campaign", 'theme_id' => '1', 'styles' => $styles));
        $camp_id = $wpdb->insert_id;
        $wpdb->insert($sola_nl_camp_list_tbl, array('id' => '', 'camp_id'=>$camp_id,'list_id'=>$list_id));
        foreach($wp_users as $wp_user){
           $email = $wp_user->user_email;
           $key = wp_hash_password( $email );
           $wpdb->insert( $sola_nl_subs_tbl, array( 'sub_id' => '', 'sub_email' => $email , 'sub_key' => $key ));
           $sub_id = $wpdb->insert_id;
           if($sub_id > 0){
             $wpdb->insert($sola_nl_subs_list_tbl, array('id'=> '', 'sub_id'=>$sub_id, 'list_id'=>$list_id));
           }
        }
   }
}
function sola_nl_add_default_editor_style(){
    global $wpdb;
    global $sola_nl_style_table;
    global $sola_nl_css_options_table;
    global $sola_nl_style_elements_table;
    global $sola_nl_themes_table;
    $letter_1 = sola_nl_default_letter();
    $styles = sola_nl_default_styles_array();
    $style_version = 1.1;
    $wpdb->query( 
	$wpdb->prepare( 
		"
                INSERT IGNORE INTO `$sola_nl_themes_table` (`theme_id`, `theme_name`, `theme_html`, `styles`, `version`) VALUES
                (%d, %s, %s, %s, %d)
		",
	        1, 'single column', $letter_1 , $styles, $style_version
            )
    );
    $results = $wpdb->get_row("SELECT * FROM `$sola_nl_themes_table` WHERE `theme_id` = 1");
    
    if($results->version != $style_version){
        $wpdb->query("UPDATE `$sola_nl_themes_table` SET `styles` = '$styles', `theme_html` = '$letter_1', `version` = '$style_version' WHERE `theme_id` = 1");
    }
    
    $sql = "INSERT IGNORE INTO `$sola_nl_css_options_table` (`id`, `css_name`, `name`, `value`) VALUES
        ('1', 'font-family', 'Georgia', 'Georgia, serif'),
        ('2', 'font-family', 'Palatino Linotype', '\"Palatino Linotype\", \"Book Antiqua\", Palatino, serif'),
        ('3', 'font-family', 'Times New Roman', '\"Times New Roman\", Times, serif'),
        ('4', 'font-family', 'Arial', 'Arial, Helvetica, sans-serif'),
        ('5', 'font-family', 'Arial Black', '\"Arial Black\", Gadget, sans-serif'),
        ('6', 'font-family', 'Comic Sans MS', '\"Comic Sans MS\", cursive, sans-serif'),
        ('7', 'font-family', 'Impact', 'Impact, Charcoal, sans-serif'),
        ('8', 'font-family', 'Lucida Sans Unicode', '\"Lucida Sans Unicode\", \"Lucida Grande\", sans-serif'),
        ('9', 'font-family', 'Tahoma', 'Tahoma, Geneva, sans-serif'),
        ('10', 'font-family', 'Trebuchet MS', '\"Trebuchet MS\", Helvetica, sans-serif'),
        ('11', 'font-family', 'Verdana', 'Verdana, Geneva, sans-serif'),
        ('12', 'font-family', 'Courier New', '\"Courier New\", Courier, monospace'),
        ('13', 'font-family', 'Lucida Console', '\"Lucida Console\" Monaco, monospace'),
        ('14', 'font-family', 'Inherit', 'inherit'),
        ('15', 'border-style', 'Dashed', 'dashed'),
        ('16', 'border-style', 'Dotted', 'dotted'),
        ('17', 'border-style', 'Double', 'double'),
        ('18', 'border-style', 'Groove', 'groove'),
        ('19', 'border-style', 'Hidden', 'hidden'),
        ('20', 'border-style', 'Inset', 'inset'),
        ('21', 'border-style', 'None', 'none'),
        ('22', 'border-style', 'Outset', 'outset'),
        ('23', 'border-style', 'Ridge', 'ridge'),
        ('24', 'border-style', 'Solid', 'solid'),
        ('25', 'font-style', 'Inherit', 'inherit'),
        ('26', 'font-style', 'Initial', 'initial'),
        ('27', 'font-style', 'Italic', 'italic'),
        ('28', 'font-style', 'Normal', 'normal'),
        ('29', 'font-weight', 'Bold', 'bold'),
        ('30', 'font-weight', 'Bolder', 'bolder'),
        ('31', 'font-weight', 'Inherit', 'inherit'),
        ('32', 'font-weight', 'Initial', 'initial'),
        ('33', 'font-weight', 'Lighter', 'lighter'),
        ('34', 'font-weight', 'Normal', 'normal'),
        ('35', 'text-align', 'Center', 'center'),
        ('36', 'text-align', 'Inherit', 'inherit'),
        ('37', 'text-align', 'Justify', 'justify'),
        ('38', 'text-align', 'Left', 'left'),
        ('39', 'text-align', 'Right', 'right'),
        ('40', 'text-decoration', 'Inherit', 'inherit'),
        ('41', 'text-decoration', 'Initial', 'initial'),
        ('42', 'text-decoration', 'Line-Through', 'line-through'),
        ('43', 'text-decoration', 'None', 'none'),
        ('44', 'text-decoration', 'Overline', 'overline'),
        ('45', 'text-decoration', 'Underline', 'underline'),
        ('46', 'border-right-style', 'Dashed', 'dashed'),
        ('47', 'border-right-style', 'Dotted', 'dotted'),
        ('48', 'border-right-style', 'Double', 'double'),
        ('49', 'border-right-style', 'Groove', 'groove'),
        ('50', 'border-right-style', 'Hidden', 'hidden'),
        ('51', 'border-right-style', 'Inset', 'inset'),
        ('52', 'border-right-style', 'None', 'none'),
        ('53', 'border-right-style', 'Outset', 'outset'),
        ('54', 'border-right-style', 'Ridge', 'ridge'),
        ('55', 'border-right-style', 'Solid', 'solid');
    ";
    $wpdb->query($sql);
    
}
function sola_nl_default_letter() {

    global $plugin_url;
    $letter = '<table id="sola_newsletter_wrapper" border="0" cellpadding="0" cellspacing="0" width="100%">';
    $letter.= '<tr>';
    $letter.= '<td width="100%" style=" padding: 30px 20px 100px 20px;" >';
    $letter.= '<table align="center"  cellpadding="0" cellspacing="0" class="sola_table" width="100%" style="border-collapse: separate; max-width:600px;">';
    $letter.= '<tr>';
    $letter.= '<td style="text-align: center; padding-bottom: 20px;">';
    $letter.= '<p><a title="'.__('View In Browser').'" href="[browser_view]">[browser_view_text]</a></p>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '<table id="sola_nl_newsletter_background"  align="center"  cellpadding="0" cellspacing="0" class="sola_table" width="100%" style="border-collapse: separate; max-width: 600px">';
    $letter.= '<tr>';
    $letter.= '<td class="sortable-list " style="padding:20px;">';
    $letter.= '<table border="0" cellpadding="0" cellspacing="0" class="sola_table sortable-item" width="100%">';
    $letter.= '<tr>';
    $letter.= '<td class="editable" id="sola_10">';
    $letter.= '<h1 style="text-align:center;">'.get_bloginfo('name').'</h1>';
    $letter.= '<p style="text-align:center;">';
    $letter.= '<i>Insert your logo here or type your company name</i>';
    $letter.= '</p>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '<table border="0" cellpadding="0" cellspacing="0" class="sola_table sortable-item" width="100%">';
    $letter.= '<tr>';
    $letter.= '<td class="editable" id="sola_20">';
    $letter.= '<img src="'.PLUGIN_DIR.'/images/hr/hr-11.png" style="display:block; margin-left:auto; margin-right:auto; "width="100%"/>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '<table border="0" cellpadding="0" cellspacing="0" class="sola_table sortable-item" width="100%">';
    $letter.= '<tr>';
    $letter.= '<td class="editable" id="sola_30">';
    $letter.= '<h1 style="text-align:center;">Double Click to edit this text</h1>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '<table border="0" cellpadding="0" cellspacing="0" class="sola_table sortable-item" width="100%">';
    $letter.= '<tr>';
    $letter.= '<td class="editable" id="sola_40">';
    $letter.= '<img src="'.PLUGIN_DIR.'/images/hr/hr-11.png" style="display:block; margin-left:auto; margin-right:auto; "width="100%"/>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '<table border="0" cellpadding="0" cellspacing="0" class="sola_table sortable-item" width="100%">';
    $letter.= '<tr>';
    $letter.= '<td class="editable" id="sola_50">';
    $letter.= '<h1 style="text-align:center;">Drag this image</h1>';
    $letter.= '<img src="'.PLUGIN_DIR.'/images/sola_logo.jpg" style="display:block; margin-left:auto; margin-right:auto;" class="nl_img" width="540px"/>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '<table border="0" cellpadding="0" cellspacing="0" class="sola_table sortable-item" width="100%">';
    $letter.= '<tr>';
    $letter.= '<td class="editable" id="sola_60">';
    $letter.= '<img src="'.PLUGIN_DIR.'/images/hr/hr-11.png" style="display:block; margin-left:auto; margin-right:auto;" width="100%"/>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '<table border="0" cellpadding="0" cellspacing="0" class="sola_table sortable-item" width="100%">';
    $letter.= '<tr>';
    $letter.= '<td class="editable" id="sola_70">';
    $letter.= '<img style="float:left; padding-right:10px; padding-bottom:10px;" width="45px" src="'.PLUGIN_DIR.'/images/sola_logo_2.jpg" class="nl_img"/>';
    $letter.= '<h2>Text And Images Working together</h2>';
    $letter.= '<p>You can float an image to the left or right and resize it in the editor.</p>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '<table border="0" cellpadding="0" cellspacing="0" class="sola_table sortable-item" width="100%">';
    $letter.= '<tr>';
    $letter.= '<td class="editable" id="sola_80">';
    $letter.= '<img src="'.PLUGIN_DIR.'/images/hr/hr-11.png" style="display:block; margin-left:auto; margin-right:auto; "width="100%"/>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '<table border="0" cellpadding="0" cellspacing="0" class="sola_table sortable-item" width="100%">';
    $letter.= '<tr>';
    $letter.= '<td class="editable" id="sola_90">';
    $letter.= '<h2>Features</h2>';
    $letter.= '<ul>';
    $letter.= "<li>Super easy to use drag and drop newsletter editor</li>";
    $letter.= "<li>Send to 2500 subscribers</li>";
    $letter.= "<li>Easy subscriber management</li>";
    $letter.= "<li>Newsletter signup widget included</li>";
    $letter.= "<li>Add your latest posts in your newsletter by simply dragging them in</li>";
    $letter.= "<li>Our newsletters show up perfectly on desktops, notebooks, tablets and phones</li>";
    $letter.= "<li>Beautiful newsletter theme included</li>";
    $letter.= "<li>Add subscribers by either copying and pasting from Excel, or uploading a CSV file</li>";
    $letter.= "<li>Export your subscribers to a CSV file</li>";
    $letter.= "<li>Send via Wordpress Mail, SMTP or Gmail </li>";   
    $letter.= '</ul>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '<table border="0" cellpadding="0" cellspacing="0" class="sola_table sortable-item" width="100%">';
    $letter.= '<tr>';
    $letter.= '<td class="editable" id="sola_100">';
    $letter.= '<img src="'.PLUGIN_DIR.'/images/hr/hr-11.png" style="display:block; margin-left:auto; margin-right:auto;" width="100%"/>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '<table  align="center"  cellpadding="0" cellspacing="0" class="sola_table" width="100%" style="border-collapse: separate; max-width:100%;">';
    $letter.= '<tr>';
    $letter.= '<td  style="padding:20px;">';
    $letter.= '<table border="0" cellpadding="0"  cellspacing="0" class="sola_table " width="100%">';
    $letter.= '<tr>';
    $letter.= '<td  id="sola_14" align="center">';
    $letter.= '<p>';
    $letter.= '<a href="[unsubscribe_href]"  title="[unsubscribe_text]">';
    $letter.= '[unsubscribe_text]';
    $letter.= '</a> ';
    $letter.= '</p>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    $letter.= '</td>';
    $letter.= '</tr>';
    $letter.= '</table>';
    return $letter;
}

function sola_nl_default_styles_array(){
$styles = array(
    "background" => array(
        "backgroundColor"   => "#333e48"
    ),
    "newsletter" => array(
        "font-family"       => "Arial, Helvetica, sans-serif",
        "backgroundColor"   => "#ffffff",
        "border-style"      => "solid",
        "border-width"      => "0",
        "border-radius"     => "10px",
        "border-color"      => "#ffffff",
        "font-size"         => "12px",
        "color"             => "#333e48"
    ),
    "heading_3" => array(
        "font-size"         => "20px",
        "font-family"       => "Arial, Helvetica, sans-serif",
        "font-weight"       => "bold",
        "font-style"        => "inherit",
        "color"             => "#333e48"
    ),
    "heading_2" => array(
        "font-size"         => "25px",
        "font-family"       => "Arial, Helvetica, sans-serif",
        "font-weight"       => "bold",
        "font-style"        => "inherit",
        "color"             => "#333e48"
    ),
    "heading_1" => array(
        "font-size"         => "30px",
        "font-family"       => "Arial, Helvetica, sans-serif",
        "font-weight"       => "bold",
        "font-style"        => "inherit",
        "color"             => "#333e48"
    ),
    "links" => array(
        "font-size"         => "13px",
        "font-family"       => "Arial, Helvetica, sans-serif",
        "font-weight"       => "bold",
        "font-style"        => "inherit",
        "color"             => "#eb6852",
        "text-decoration"   => "underline"
    ),
    "social_icon" => array(
        "width"             => "20px",
        "text-align"        => "center"
    ),
    "images" => array(
        "padding-top"       => "5px",
        "padding-bottom"    => "5px",
        "border-color"      => "#c73232",
        "border-width"      => "0px",
        "border-style"      => "solid",
        "border-color"      => "#000"
    ),
    "button" =>array(
        "backgroundColor"   =>"#b50707",
        "border-radius"     =>"5px",
        "color"             =>"#ffffff",
        "font-family"       =>"inherit",
        "font-size"         =>"20px",
        "font-weight"       =>"bold",
        "font-style"        =>"inherit",
        "line-height"       =>"40px",
        "width"             =>"100%",
        "text-align"        =>"center",
        "border-color"      =>"#c73232",
        "border-width"      =>"1px",
        "border-style"      =>"solid",
        "text-decoration"   => "none"
    )
);
return serialize($styles);
}