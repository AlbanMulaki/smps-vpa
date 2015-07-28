<?php
session_start();
// checks if any camps to send via ajax


function sola_nl_preview_mail(){

    global $wpdb;
    global $sola_nl_camp_tbl;
    global $sola_global_campid;
    extract($_POST);
    
    
    if (isset($body) && isset($to)) {
        $sola_global_campid = $camp_id;

        $body =  sola_nl_mail_body($body,0,$camp_id);
        $sql = "SELECT * FROM `$sola_nl_camp_tbl` WHERE `camp_id` = '$camp_id'";
        $result = $wpdb->get_row($sql);
        
        $body = do_shortcode($body);
        $body = sola_nl_replace_links($body,0,$camp_id);

        if($result->type == 2 && $result->action == 3){
//            $letter = sola_nl_get_letter($camp_id);
//            var_dump($camp_id);
            $inserted_data = sola_nl_build_automatic_content($camp_id,false);
//            var_dump($inserted_data);
            $body = preg_replace('/<table id="sola_nl_automatic_container"(.*?)<\/table>/is', $inserted_data, $body);
        }
        
        $test_mail = sola_mail($camp_id ,$to, do_shortcode($result->subject). __(" Preview", "sola"), do_shortcode($body));

        if (empty($test_mail['error'])) {
            _e("Email Sent", "sola");
        } else {
            echo $test_mail['error'];
        }
    } else {
        _e("Error", "sola");
    }

}

function sola_nl_send_mail(){

    global $wpdb;
    global $sola_nl_camp_tbl;
    global $sola_nl_camp_subs_tbl;
    global $sola_nl_subs_tbl;
    extract($_POST);
    extract($_POST['subscriber']);

    $sql = "SELECT * FROM `$sola_nl_camp_tbl` WHERE `camp_id` = '$camp_id'";
    $camp = $wpdb->get_row($sql);
    $body = sola_nl_mail_body($camp->email, $sub_id, $camp->camp_id);
    $body = do_shortcode($body);

    $body = sola_nl_replace_links($body, $sub_id, $camp->camp_id);
    $check = sola_mail($camp_id ,$sub_email, $camp->subject, $body);

    if($check){
        sola_update_camp_limit($camp_id);
        $wpdb->update( 
            $sola_nl_camp_subs_tbl, 
            array( 
                'status' => 1
            ), 
            array( 
                'camp_id' => $camp_id,
                'sub_id' => $sub_id
                ), 
            array( 
                '%d'	
            ), 
            array( '%d', '%d' ) 
        );
        echo true;
    } else {
        echo "<p>Failed to send to ".$sub_email."</p>";
    }
}

function sola_nl_send_mail_via_cron_original($camp_id,$sub_id,$sub_email){

    global $wpdb;
    global $sola_nl_camp_tbl;
    global $sola_nl_camp_subs_tbl;
    global $sola_nl_subs_tbl;
    global $sola_global_subid;
    global $sola_global_campid;

    $sql = "SELECT * FROM `$sola_nl_camp_tbl` WHERE `camp_id` = '$camp_id'";
    $camp = $wpdb->get_row($sql);
    $body = sola_nl_mail_body($camp->email, $sub_id, $camp->camp_id);

    $sola_global_subid = $sub_id;
    $sola_global_campid = $camp->camp_id;

    $body = do_shortcode($body);

    $body = sola_nl_replace_links($body, $sub_id, $camp->camp_id);

    $check = sola_mail($camp_id ,$sub_email, $camp->subject, $body);
    if($check){
        sola_update_camp_limit($camp_id);
        $wpdb->update( 
            $sola_nl_camp_subs_tbl, 
            array( 
                'status' => 1
            ), 
            array( 
                'camp_id' => $camp_id,
                'sub_id' => $sub_id
                ), 
            array( 
                '%d'	
            ), 
            array( '%d', '%d' ) 
        );
        return true;
    } else {
        return new WP_Error( 'sola_error', __( 'Failed to send email to subscriber '.$sub_email ), 'Could not send email to '.$sub_email );
        echo "<p>Failed to send to ".$sub_email."</p>";
    }
}


function sola_nl_send_mail_via_cron($camp_id,$sub_id,$sub_email){

}

function sola_nl_mail_body($body, $sub_id, $camp_id){
    global $wpdb;
    global $sola_nl_style_table;

    return '
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Campaign Monitor Newsletter</title>
        <style>
        @media only screen and (max-device-width: 480px) {
             div[class="header"] {
                  font-size: 16px !important;
             }
             table[class="sola_table"], td[class="cell"] {
                  width: 300px !important;
             }
                table[class="promotable"], td[class="promocell"], td[class="contentblock"] {
                  width: 325px !important;
             }
                td[class="footershow"] {
                  width: 300px !important;
             }
                table[class="hide"], img[class="hide"], td[class="hide"] {
                  display: none !important;
             }
             img[class="divider"] {
                      height: 1px !important;
                 }
                 td[class="logocell"] {
                        padding-top: 15px !important; 
                        padding-left: 15px !important;
                        width: 300px !important;
                 }
             img[id="screenshot"] {
                  width: 325px !important;
                  height: 127px !important;
             }
                img[class="galleryimage"] {
                          width: 53px !important;
                  height: 53px !important;
                }
                p[class="reminder"] {
                        font-size: 11px !important;
                }
                h4[class="secondary"] {
                        line-height: 22px !important;
                        margin-bottom: 15px !important;
                        font-size: 18px !important;
                }
        }
        </style>
</head>
<body bgcolor="#e4e4e4" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="-webkit-font-smoothing: antialiased;width:100% !important;background:#e4e4e4;-webkit-text-size-adjust:none;">
    '.stripslashes($body).'
    <img src="'.SITE_URL.'/?action=sola_nl_tracker&sub_id='.$sub_id.'&camp_id='.$camp_id.'" />

</body>
</html>';


}
function sola_nl_replace_links($body, $sub_id, $camp_id){        
    
    global $wpdb;
    global $sola_nl_link_tracking_table;
    global $sola_nl_camp_tbl;

    $enable_link_tracking = get_option('sola_nl_enable_link_tracking');
    
    @$dom = new DOMDocument;

    @$dom->loadHTML($body);
    $camp = $wpdb->get_row( 
        $wpdb->prepare( 
                "SELECT * FROM `$sola_nl_camp_tbl` WHERE `camp_id` = %d",
                 $camp_id
        )
    );
    if($sub_id){
        if($camp->utm_campaign){
            $utm_camp = $camp->utm_campaign;
        } else {
            $utm_camp = urlencode($camp->subject." ".date("Y-m-d"));
            $wpdb->update( 
            $sola_nl_camp_tbl, 
            array( 
                    'utm_campaign' => $utm_camp
            ), 
            array( 'camp_id' => $camp->camp_id ), 
            array( 
                    '%s'
            ), 
            array( '%d' ) 
            );
        }
    } else {
        $utm_camp = "newsletter_preview";
    }
    foreach ($dom->getElementsByTagName('a') as $item) {

        $link_name = '';
        $old_href = $item->getAttribute('href');
        $link_name = $item->getAttribute('title');
        if(!$link_name){
            $link_name = $item->getAttribute('href');
        }
        if($old_href != "http://www.sola.com/"){
            if(isset($enable_link_tracking) && $enable_link_tracking){
                if (function_exists("sola_nl_premium_activate")) {
                    if(strpos($old_href, '?') == true){
                        $old_href.= "&utm_source=".get_option("sola_nl_utm_source")."&utm_medium=".get_option("sola_nl_utm_medium")."&utm_campaign=".$utm_camp;
                    } else {
                        $old_href.= "?utm_source=".get_option("sola_nl_utm_source")."&utm_medium=".get_option("sola_nl_utm_medium")."&utm_campaign=".$utm_camp;
                    }
                }
            } else {
                $old_href .= "";
            }

            $data = array(
                "sub_id"=>$sub_id,
                "camp_id"=>$camp_id,
                "link_name"=>$link_name,
                "link"=>$old_href,
                "clicked"=>0
            );
            $wpdb->insert($sola_nl_link_tracking_table, $data );
            $link_id = $wpdb->insert_id;
            //echo $old_href;
            if(isset($enable_link_tracking) && $enable_link_tracking){
                $item->setAttribute('href', SITE_URL."?action=sola_nl_redirect&sola_link_id=".$link_id);
            } else {
                $item->setAttribute('href', $old_href);
            }
        }
    }
    return $dom->saveHTML();      
}

function sola_mail($camp_id,$to,$subject,$body,$headers = false,$attachment = false,$textonly = false, $debug = false,$host = null, $port = null, $user = null, $pass = null, $wpmail = false, $test = false, $encryption = false) {
    global $wpdb;
    global $sola_nl_camp_tbl;

    if (!isset($to)) { return array('error'=>'No to address'); }
    if (!isset($subject)) { return array('error'=>'No subject'); }
    if (!isset($body)) { return array('error'=>'No body'); }



    $sql = "SELECT * FROM `$sola_nl_camp_tbl` WHERE `camp_id` = '$camp_id'";
    $result = $wpdb->get_row($sql);
    if (isset($result->reply_to)) { $reply = $result->reply_to; }
    if (isset($result->reply_to_name)) { $reply_name = stripslashes($result->reply_to_name); }
    if (isset($result->sent_from)) { $sent_from = $result->sent_from; }
    if (isset($result->sent_from_name)) { $sent_from_name = stripslashes($result->sent_from_name); }

    if(empty($reply)){ $reply = get_option("sola_nl_reply_to");}
    if(empty($reply_name)){ $reply_name = get_option("sola_nl_reply_to_name");}
    if(empty($sent_from)){ $sent_from = get_option("sola_nl_sent_from");}
    if(empty($sent_from_name)){ $sent_from_name = get_option("sola_nl_sent_from_name");}

    // get option for either SMTP or normal WP MAil
    // split below based on above

    $saved_send_method = get_option("sola_nl_send_method");

    if ($test) {
        if ($wpmail === 'wpmail') { $send_method = "1"; } else { $send_method = "2"; }
    } else {
        $send_method = $saved_send_method;
    }

    if($send_method == "1"){
        $headers[] = 'From: '.$sent_from_name.' <'.$sent_from.'>';
        $headers[] = 'Content-type: text/html';
        $headers[] = 'Reply-To: '.$reply_name.' <'.$reply.'>';
        if(wp_mail($to, $subject, $body, $headers )){
            return true;
        } else {
             if (!$debug) {
                return array('error'=>'Error sending mail');
            } else {
                return array('error'=>"Failed to send... ".$GLOBALS['phpmailer']->ErrorInfo);
            }


        }

    } else if ($send_method >= "2") {

        $file = PLUGIN_URL.'/includes/phpmailer/PHPMailerAutoload.php';
        require_once $file;
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;

        if ($port == false) { $port = get_option("sola_nl_port");}
        if ($encryption == false) { $encryption = get_option("sola_nl_encryption");}
        if($encryption){
            $mail->SMTPSecure = $encryption;
        }

        if (!isset($host)) { $mail->Host = get_option("sola_nl_host"); } else { if ($host == "smtp.gmail.com") { $mail->Host = "smtp.gmail.com"; } else { $mail->Host = $host; } }

        if (!isset($user)) { $mail->Username = get_option("sola_nl_username"); } else { $mail->Username = $user; }
        if (!isset($user)) { $mail->Password = get_option("sola_nl_password"); } else { $mail->Password = $pass; }

        $mail->Port = $port;
        $mail->AddReplyTo ($reply, $reply_name);
        $mail->SetFrom($sent_from, $sent_from_name);
        //$mail->AddReplyToName = $reply_name;

        //echo $encryption;
        if (is_array($to)) {
            foreach ($to as $address) {
                $mail->AddAddress($address);
            }
        } else {
            $mail->AddAddress($to);
        }
        $mail->Subject = $subject;

        $mail->Body = $body;

        if ($textonly) {
            $mail->IsHTML(false);
        } else {
            $mail->IsHTML(true);
        }

        if (!$debug) {
            $mail->SMTPDebug = 0;
        } else {
            $mail->SMTPDebug = 1;
        }

        if(!$mail->Send()){
            return array('error'=>'Error sending mail');
        } else {
            return true;
        }
    }


}
function sola_nl_done_sending_camp($camp_id){
    global $wpdb;
    global $sola_nl_camp_tbl;


    extract($_POST);
    $check = sola_check_unsent_mails($camp_id);
    $now = date("Y-m-d H:i:s");
    if(!$check){
        $wpdb->update( 
            $sola_nl_camp_tbl, 
            array( 
                'status' => 1,
                'date_sent' => $now
            ), 
            array( 
                'camp_id' => $camp_id
                ), 
            array( 
                '%d',
                '%s'
            ), 
            array( '%d' ) 
        );
        $camp = sola_nl_get_camp_details($camp_id);
        if ($camp->type != 2) {
            /* only run if not an automatic campaign or else users will get mail send complete email incorrectly */
            $body = __("Hi Admin\r\nYour mail campaign has finished sending.\n\rSola Newsletter Plugin", 'sola');
            sola_nl_send_notification(__("Mail Send Complete", 'sola'), $body);
        }
    } else {
        $limit = get_option('sola_nl_send_limit_qty');
        $wpdb->update(
            $sola_nl_camp_tbl,
            array(
                'last_sent' => $now,
                'time_frame_qty' => $limit
            ),
            array(
                'camp_id' => $camp_id
            ),
            array(
                '%s',
                '%d'
            ),
            array('%d')
        );
    }
}
// this is to test if mail is working or not from settings page
function sola_nl_test_mail_2(){
    global $wpdb;
    global $sola_nl_camp_tbl;

    extract($_POST);
    //var_dump($_POST);


        $body = "<p>Your email settings are correct.</p>"
                . "<p>This Mail was sent using Sola Newsletters</p>";

        if ($smtp_debug == "on") { $debug = true; } else { $debug = false; }
        if (!isset($mail_type)) { $mail_type = false; }
        $test_mail = sola_mail(0 ,$to, "Test Mail", $body,  false, false, false, $debug, $smtp_host, $smtp_port, $smtp_user, $smtp_pass, $mail_type, true, $smtp_encrypt);

        if (empty($test_mail['error'])) {
            echo "Email Sent";

        } else {
            echo $test_mail['error'];
        }

}
function sola_nl_send_js(){
    wp_enqueue_script( 'jquery' );
    wp_register_script('sola_nl_sender', PLUGIN_DIR."/js/send_campaign.js", false);
    $security = wp_create_nonce('sola_nl');
    $camp_id = $_SESSION['camp_id'];
    $limit = sola_get_camp_limit($camp_id);
    $total_subs = sola_nl_total_camp_subs($camp_id); 
    $total_sent = sola_current_sent_mails($camp_id);

    if(!$_SESSION['no_send']){

        $data = array('camp_id'=>$camp_id,
            'index'=>$total_sent,
            'security'=>$security,
            'total_subs'=>$total_subs,
            'time_out'=>get_option('sola_nl_send_limit_time'),
            'next_send'=>0,
            'limit'=>$limit
            );


    } else if($_SESSION['no_send']){
        $next_send = sola_next_send_time_left($camp_id);
        $data = array('camp_id'=>$camp_id,
            'index'=>$total_sent,
            'security'=>$security,
            'total_subs'=>$total_subs,
            'next_send'=>$next_send,
            'time_out'=>get_option('sola_nl_send_limit_time'),
            'limit'=>$limit
            );
    }
    wp_localize_script( 'sola_nl_sender', 'sola_nl_sub_data', $data );
    wp_enqueue_script( 'sola_nl_sender' );
    $_SESSION['camp_id'] = '';
    $_SESSION['no_send'] = '';
}


function sola_check_send_mail_time($type){
    global $wpdb;
    global $sola_nl_camp_tbl;
    if (!isset($type)) { $type = 2; }
    
    $current_date = date("Y-m-d H:i:s",current_time('timestamp'));    
    
    
    $sql = "SELECT * FROM `$sola_nl_camp_tbl` WHERE `schedule_date` < '$current_date' AND `status` = '$type' AND `type` != '2' LIMIT 1";
    $campaign = $wpdb->get_row($sql);
       
    if($campaign){
        $time_limit = strtotime("-".get_option('sola_nl_send_limit_time')." seconds");
        $camp_id = false;
         
        $last_sent_date = strtotime($campaign->last_sent);
        if(($last_sent_date < $time_limit) && ($campaign->time_frame_qty > 0)){
            $camp_id = $campaign->camp_id;             
        }
        return $camp_id;
        
    } else {
        return false;
    }
    
}
function sola_get_camp_limit($camp_id){
    global $wpdb;
    global $sola_nl_camp_tbl;
    $sql = "SELECT * FROM `$sola_nl_camp_tbl` WHERE `camp_id` = '$camp_id'";
    $result = $wpdb->get_row($sql);
    if($result->time_frame_qty > 0){
        return $result->time_frame_qty;
    } else {
        return false;
    }
}
function sola_update_camp_limit($camp_id){
    global $wpdb;
    global $sola_nl_camp_tbl;
    $sql = "UPDATE `$sola_nl_camp_tbl` SET `time_frame_qty` = time_frame_qty - 1 WHERE `camp_id` = '$camp_id'";
    $wpdb->Query($sql);
}
function sola_check_unsent_mails($camp_id){
    global $wpdb;
    global $sola_nl_camp_subs_tbl;
    $sql = "SELECT * FROM `$sola_nl_camp_subs_tbl` WHERE `status` = 0 AND `camp_id` = '$camp_id'";
    $wpdb->query($sql);
    return $wpdb->num_rows;
}
function sola_current_sent_mails($camp_id){
    global $wpdb;
    global $sola_nl_camp_subs_tbl;
    $sql = "SELECT * FROM `$sola_nl_camp_subs_tbl` WHERE `status` <> 0 AND `camp_id` = '$camp_id'";
    $wpdb->query($sql);
    return $wpdb->num_rows;
}
function sola_check_if_currently_sending($type){
    global $wpdb;
    global $sola_nl_camp_tbl;

    if (!isset($type)) { $type = 2; }
    $sql = "SELECT * FROM `$sola_nl_camp_tbl` WHERE `status` = $type LIMIT 1";
    $result = $wpdb->get_row($sql);
    if($result){
        return $result->camp_id;   
    } else {
        return false;
    }
}
function sola_next_send_time_left($camp_id){
    global $wpdb;
    global $sola_nl_camp_tbl;
    $sql = "SELECT `last_sent` FROM `$sola_nl_camp_tbl` WHERE `camp_id` = '$camp_id'";
    $result = $wpdb->get_row($sql);
    $time = get_option('sola_nl_send_limit_time');
    $now = date("Y-m-d H:i:s");
    $last_sent = strtotime($result->last_sent);
    $next_send = $last_sent + $time;
    $time_left = $next_send - strtotime($now);
//    if($time_left < 0){
//        $time_left = 0;
//    }
    return $time_left;
}
function sola_cron_send($camp_id = false) {
    
    $debug_start = (float) array_sum(explode(' ',microtime()));

    global $wpdb;
    global $sola_nl_camp_tbl;
    global $sola_nl_camp_subs_tbl;
    global $sola_nl_subs_tbl;
    global $sola_global_subid;
    global $sola_global_campid;
    
    /*
     * Sends mail to new users and subscribers.
     */
    custom_auto_mail_send();
    
    if (!$camp_id) {
        $camp_id = sola_check_send_mail_time(3);
    }

    if ($camp_id) {
        $limit = sola_get_camp_limit($camp_id);
        if($limit){



            if (!get_option("sola_currently_sending")) {
                if (get_option("sola_currently_sending") == "yes") {
                    return __("We are currently sending. Dont do anything", "sola");
                } else {
                    update_option("sola_currently_sending","yes");
                }
            } else {
                add_option("sola_currently_sending","yes");
            }

            update_option("sola_currently_sending","yes");

            $subscribers = sola_nl_camp_subs($camp_id, $limit);
            //var_dump($subscribers);

            $sql = "SELECT * FROM `$sola_nl_camp_tbl` WHERE `camp_id` = '$camp_id'";
            $camp = $wpdb->get_row($sql);
            
            if ($camp->type != 2) { sola_return_error(new WP_Error( 'Notice', __( 'Campaign send initiated' ), 'Started sending '.count($subscribers).' mails for campaign '.$camp_id.' at '.date("Y-m-d H:i:s"))); }

            if (isset($camp->reply_to)) { $reply = $camp->reply_to; }
            if (isset($camp->reply_to_name)) { $reply_name = stripslashes($camp->reply_to_name); }
            if (isset($camp->sent_from)) { $sent_from = $camp->sent_from; }
            if (isset($camp->sent_from_name)) { $sent_from_name = stripslashes($camp->sent_from_name); }

            if(empty($reply)){ $reply = get_option("sola_nl_reply_to");}
            if(empty($reply_name)){ $reply_name = get_option("sola_nl_reply_to_name");}
            if(empty($sent_from)){ $sent_from = get_option("sola_nl_sent_from");}
            if(empty($sent_from_name)){ $sent_from_name = get_option("sola_nl_sent_from_name");}

            // get option for either SMTP or normal WP MAil
            // split below based on above

            $saved_send_method = get_option("sola_nl_send_method");

            if($saved_send_method == "1"){
                $headers = Array();
                $headers[] = 'From: '.$sent_from_name.' <'.$sent_from.'>';
                $headers[] = 'Content-type: text/html';
                $headers[] = 'Reply-To: '.$reply_name.' <'.$reply.'>';

            } else if ($saved_send_method >= "2") {
                $file = PLUGIN_URL.'/includes/phpmailer/PHPMailerAutoload.php';
                require_once $file;
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPKeepAlive = true;

                $port = get_option("sola_nl_port");
                $encryption = get_option("sola_nl_encryption");
                if($encryption){
                    $mail->SMTPSecure = $encryption;
                }
                $host = get_option("sola_nl_host");

                $mail->Host = $host;

                $mail->Username = get_option("sola_nl_username");
                $mail->Password = get_option("sola_nl_password");
                $mail->Port = $port;
                $mail->AddReplyTo ($reply, $reply_name);
                $mail->SetFrom($sent_from, $sent_from_name);
                $mail->Subject = $camp->subject;
                $mail->SMTPDebug = 0;
            }           
            
//            var_dump($subscribers);

            if ($subscribers) {

                foreach($subscribers as $subscriber) {
                    set_time_limit(600);
                    $sub_id = $subscriber->sub_id;
                    $sub_email = $subscriber->sub_email;
                    
                    
//                    echo $sub_email;
                    
                    var_dump('Subscriber ID '.$sub_id);

                    $the_email = $camp->email;
//                    global $sola_global_subid;
                    

                    $sola_global_subid = $sub_id;
//                    var_dump("HERE");
//                    var_dump($sola_global_subid);
                    $sola_global_campid = $camp->camp_id;
                    
                    $original_body = sola_nl_mail_body($the_email, $sub_id, $camp->camp_id);
                    echo "<h1>original</h1>";
                    echo $original_body;
                    
                    
                    $final_body = do_shortcode($original_body);
//                    echo "<h1>final</h1>";
//                    echo $final_body;
//                    
//                    echo 'Sub ID '.$sub_id;
//                    
//                    var_dump($sub_id);
//                    var_dump($sola_global_subid);
//                    
//                    echo 'Camp ID '.$camp_id;
//                    echo 'Body';
                    
//                  echo $body;
//                    $the_sub = sola_nl_get_subscriber('12');
                    
//                    echo sola_nl_unsubscribe_href();
//                    var_dump($the_sub);                            
                            
                            
                    $body = sola_nl_replace_links($final_body, $sub_id, $camp->camp_id);
//                    exit();

                    /* ------ */    


                    //$check = sola_mail($camp_id ,$sub_email, $camp->subject, $body);


                    if($saved_send_method == "1"){
                        if(wp_mail($sub_email, $camp->subject, $body, $headers )){
                            $check = true;
                        } else {
                            $check = array('error'=>"Failed to send email to $sub_email... ".$GLOBALS['phpmailer']->ErrorInfo);
                        }

                    } else if ($saved_send_method >= "2") {

                        if (is_array($sub_email)) {
                            foreach ($sub_email as $address) {
                                $mail->AddAddress($address);
                            }
                        } else {
                            $mail->AddAddress($sub_email);
                        }
                        $mail->Body = $body;

                        $mail->IsHTML(true);

                        echo "sending to $sub_email<br />";

                        if(!$mail->Send()){
                            $check = array('error'=>'Error sending mail to '.$sub_email);
                        } else {
                            $mail->clearAddresses();
                            $mail->clearAttachments();
                            $check = true;
                        }
                    }




                    if($check === true){
                        $status = 1;
                        echo "Email sent to $sub_email successfully <br />";
                    } else {
                        $status = 9;
                        sola_return_error(new WP_Error( 'sola_error', __( 'Failed to send email to subscriber' ), 'Could not send email to '.$mail->ErrorInfo ));
                        echo "<p>Failed to send to ".$sub_email."</p>";
                    }
                    sola_update_camp_limit($camp_id);
                    $wpdb->update( 
                        $sola_nl_camp_subs_tbl, 
                        array( 
                            'status' => $status
                        ), 
                        array( 
                            'camp_id' => $camp_id,
                            'sub_id' => $sub_id
                            ), 
                        array( 
                            '%d'	
                        ), 
                        array( '%d', '%d' ) 
                    );


                    
                    $end = (float) array_sum(explode(' ',microtime()));
                    echo "<br />processing time: ". sprintf("%.4f", ($end-$debug_start))." seconds<br />";



                    //$check = sola_nl_send_mail_via_cron($camp_id,$sub_id,$sub_email);
                    //if ( is_wp_error($check)) sola_return_error($check);
                }
            }
        } else {
            /* do nothing, reached limit */
        }
        if ($saved_send_method >= "2") { $mail->smtpClose(); }
        $end = (float) array_sum(explode(' ',microtime()));
        echo "<br />processing time: ". sprintf("%.4f", ($end-$debug_start))." seconds<br />";

        update_option("sola_currently_sending","no");
        if ($camp->type != 2) {
            sola_return_error(new WP_Error( 'Notice', __( 'Campaign send ended' ), 'Ended sending campaign '.$camp_id.' at '.date("Y-m-d H:i:s") ));
        }
        sola_nl_done_sending_camp($camp_id);

    } else { 
        echo "<br />nothing to send at this time<br />";
    }

}   


function sola_cron_send_original() {
    $debug_start = (float) array_sum(explode(' ',microtime()));

    $camp_id = sola_check_send_mail_time(3);
    //var_dump($camp_id);

    if ($camp_id) {
        $limit = sola_get_camp_limit($camp_id);
        if($limit){
            $subscribers = sola_nl_camp_subs($camp_id, $limit);
            //var_dump($subscribers);

            if ($subscribers) {

                foreach($subscribers as $subscriber) {
                    set_time_limit(600);
                    $sub_id = $subscriber->sub_id;
                    $sub_email = $subscriber->sub_email;
                    echo $sub_email;
                    $check = sola_nl_send_mail_via_cron_original($camp_id,$sub_id,$sub_email);
                    $end = (float) array_sum(explode(' ',microtime()));
                    echo "<br />processing time: ". sprintf("%.4f", ($end-$debug_start))." seconds<br />";

                    if ( is_wp_error($check)) sola_return_error($check);
                }
            }
        } else {
            /* do nothing, reached limit */
        }
        $end = (float) array_sum(explode(' ',microtime()));
        echo "<br />processing time: ". sprintf("%.4f", ($end-$debug_start))." seconds<br />";

        sola_nl_done_sending_camp($camp_id);
    } else { 
        echo "<br />nothing to send at this time<br />";
    }

}   





function sola_nl_ajax_send($subscribers, $camp_id){

    $debug_start = (float) array_sum(explode(' ',microtime()));

    global $wpdb;
    global $sola_nl_camp_tbl;
    global $sola_nl_camp_subs_tbl;
    global $sola_nl_subs_tbl;
    global $sola_global_subid;
    global $sola_global_campid;





    if ($camp_id) {

        echo get_option("sola_currently_sending");

        if (!get_option("sola_currently_sending")) {
            if (get_option("sola_currently_sending") == "yes") {
                return "We are currently sending. Dont do anything";
            } else {
                update_option("sola_currently_sending","yes");
            }
        } else {
            add_option("sola_currently_sending","yes");
        }

        update_option("sola_currently_sending","yes");

        $camp = sola_nl_get_camp_details($camp_id);

        if (isset($camp->reply_to)) { $reply = $camp->reply_to; }
        if (isset($camp->reply_to_name)) { $reply_name = stripslashes($camp->reply_to_name); }
        if (isset($camp->sent_from)) { $sent_from = $camp->sent_from; }
        if (isset($camp->sent_from_name)) { $sent_from_name = stripslashes($camp->sent_from_name); }

        if(empty($reply)){ $reply = get_option("sola_nl_reply_to");}
        if(empty($reply_name)){ $reply_name = get_option("sola_nl_reply_to_name");}
        if(empty($sent_from)){ $sent_from = get_option("sola_nl_sent_from");}
        if(empty($sent_from_name)){ $sent_from_name = get_option("sola_nl_sent_from_name");}

        // get option for either SMTP or normal WP MAil
        // split below based on above

        $saved_send_method = get_option("sola_nl_send_method");

        if($saved_send_method == "1"){
            $headers[] = 'From: '.$sent_from_name.'<'.$sent_from.'>';
            $headers[] = 'Content-type: text/html';
            $headers[] = 'Reply-To: '.$reply_name.'<'.$reply.'>';

        } else if ($saved_send_method >= "2") {
            $file = PLUGIN_URL.'/includes/phpmailer/PHPMailerAutoload.php';
            require_once $file;
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPKeepAlive = true;

            $port = get_option("sola_nl_port");
            $encryption = get_option("sola_nl_encryption");
            if($encryption){
                $mail->SMTPSecure = $encryption;
            }
            $host = get_option("sola_nl_host");

            $mail->Host = $host;

            $mail->Username = get_option("sola_nl_username");
            $mail->Password = get_option("sola_nl_password");
            $mail->Port = $port;
            $mail->AddReplyTo ($reply, $reply_name);
            $mail->SetFrom($sent_from, $sent_from_name);
            $mail->Subject = $camp->subject;
            $mail->SMTPDebug = 0;
        }           


        if ($subscribers) {

            foreach($subscribers as $subscriber) {
                set_time_limit(600);
                $sub_id = $subscriber['sub_id'];
                $sub_email = $subscriber['sub_email'];
                echo $sub_email;


                $body = sola_nl_mail_body($camp->email, $sub_id, $camp->camp_id);

                $sola_global_subid = $sub_id;
                $sola_global_campid = $camp->camp_id;

                $body = do_shortcode($body);



                $body = sola_nl_replace_links($body, $sub_id, $camp->camp_id);







                /* ------ */    


                //$check = sola_mail($camp_id ,$sub_email, $camp->subject, $body);


                if($saved_send_method == "1"){
                    if(wp_mail($sub_email, $camp->subject, $body, $headers )){
                        $check = true;
                    } else {
                         if (!$debug) {
                            $check = array('error'=>'Error sending mail to'.$sub_email);
                        } else {
                            $check = array('error'=>"Failed to send email to $sub_email... ".$GLOBALS['phpmailer']->ErrorInfo);
                        }


                    }

                } else if ($saved_send_method >= "2") {

                    if (is_array($sub_email)) {
                        foreach ($sub_email as $address) {
                            $mail->AddAddress($address);
                        }
                    } else {
                        $mail->AddAddress($sub_email);
                    }
                    $mail->Body = $body;

                    $mail->IsHTML(true);

                    //echo "sending to $sub_email<br />";

                    if(!$mail->Send()){
                        $check = array('error'=>'Error sending mail to '.$sub_email);
                    } else {
                        $check = true;
                    }
                }




                if($check === true){
                    sola_update_camp_limit($camp_id);
                    $wpdb->update( 
                        $sola_nl_camp_subs_tbl, 
                        array( 
                            'status' => 1
                        ), 
                        array( 
                            'camp_id' => $camp_id,
                            'sub_id' => $sub_id
                            ), 
                        array( 
                            '%d'	
                        ), 
                        array( '%d', '%d' ) 
                    );
                    //echo "Email sent to $sub_email successfully <br />";
                } else {
                    sola_return_error(new WP_Error( 'sola_error', __( 'Failed to send email to subscriber' ), 'Could not send email to '.$sub_email ));
                    //echo "<p>Failed to send to ".$sub_email."</p>";
                }


                $mail->clearAddresses();
                $mail->clearAttachments();
                $end = (float) array_sum(explode(' ',microtime()));
                echo "<br />processing time: ". sprintf("%.4f", ($end-$debug_start))." seconds<br />";



                //$check = sola_nl_send_mail_via_cron($camp_id,$sub_id,$sub_email);
                //if ( is_wp_error($check)) sola_return_error($check);
            }

        } else {
            /* do nothing, reached limit */
        }
        if ($saved_send_method >= "2") { $mail->smtpClose(); }
        $end = (float) array_sum(explode(' ',microtime()));
        echo "<br />processing time: ". sprintf("%.4f", ($end-$debug_start))." seconds<br />";


        update_option("sola_currently_sending","no");

        sola_nl_done_sending_camp($camp_id);
    } else { 
        echo "<br />nothing to send at this time<br />";
    }

}