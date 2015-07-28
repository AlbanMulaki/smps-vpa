<?php $notification = get_option("sola_nl_notifications"); ?>
<?php
$sola_nl_ajax_nonce = wp_create_nonce("sola_nl");


?>

<script language="javascript">
    var sola_nl_nonce = '<?php echo $sola_nl_ajax_nonce; ?>';
</script>
<style>
 label { font-weight: bolder; }    
</style>
<div class="wrap">
   
    
    <div id="icon-options-general" class="icon32 icon32-posts-post"><br></div><h2><?php _e("Sola Settings","sola") ?></h2>


    <form action='' name='sola_settings' method='POST' id='sola_nl_settings'>

    <div id="sola_tabs">
      <ul>
          <li><a href="#tabs-1"><?php _e("Main Settings","sola") ?></a></li>
          <li><a href="#tabs-2"><?php _e("E-mail Settings","sola") ?></a></li>
          <li><a href="#tabs-3"><?php _e("Sign Up Widget","sola") ?></a></li>
          <li><a href="#tabs-4"><?php _e("Social Links","sola") ?></a></li>
          <li><a href="#tabs-5"><?php _e("Analytics","sola") ?></a></li>
          <li><a href="#tabs-6"><?php _e("Cron Setup (Advanced)","sola") ?></a></li>
          <li><a href="#tabs-7"><?php _e("CAN-SPAM Act","sola"); ?></a></li>
          <?php if (function_exists("sola_nl_register_pro_version")) { } else { ?><li><a href="#tabs-8"><?php _e("Go Premium", "sola") ?></a></li><?php } ?>
      </ul>
      <div id="tabs-1">
            <table width='100%'>
                <tr>
                    <td width="250px" >
                        <label><?php _e('Sending Address', 'sola'); ?></label>
                            <p class="description" style='padding:10px;'><?php _e('Enter a valid e-mail address here. eg. newsletter@mydomain.com', 'sola'); ?></p>
                    </td>
                    <td>
                        <input type="email" class='sola-input' name="sola_nl_sent_from" value="<?php echo get_option("sola_nl_sent_from");?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e('Name', 'sola'); ?></label>
                        <p class="description" style='padding:10px;'><?php _e('Having a name is so much better than someone@unknown.com', 'sola'); ?></p>
                    </td>
                    <td>
                        <input type='text' class='sola-input' name="sola_nl_sent_from_name" value="<?php echo stripslashes(get_option("sola_nl_sent_from_name")); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e('Reply To', 'sola'); ?></label>
                        <p class='description' style='padding:10px;'><?php _e('Your subscribers may want to talk to you, so let them.', 'sola'); ?></p>
                    </td>
                    <td>
                        <input type='email' class='sola-input' name="sola_nl_reply_to" value="<?php echo get_option("sola_nl_reply_to");?>"/>
                    </td>
                </tr>   
                <tr>
                    <td>
                        <label><?php _e('Reply to Name', 'sola'); ?></label>
                        <p class="description" style='padding:10px;'><?php _e('Give people a name to reply to', 'sola'); ?></p>
                    </td>
                    <td>
                        <input type='text' class='sola-input' name="sola_nl_reply_to_name" value="<?php echo stripslashes(get_option("sola_nl_reply_to_name")); ?>"/>
                    </td>
                </tr>
            </table>
            <hr/>
            <table width='100%'>
                <tr>
                    <td width="250px">
                        <label><?php _e('Email Notifications', 'sola'); ?></label>
                        <p class="description" style='padding:10px;'><?php _e('The email address you would like Sola Newsletter plugin to keep in contact with you.', 'sola'); ?></p>
                    </td>
                    <td>
                        <input type="email" class='sola-input' name="sola_nl_email_note" value="<?php echo get_option( 'sola_nl_email_note' ); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e('Notifications', 'sola'); ?></label>
                        <p class="description" style='padding:10px;'><?php _e('What would you like to be notified about?', 'sola'); ?></p>
                    </td>
                    <td>
                        <input type="radio" name="sola_nl_notifications" value="1" <?php if ($notification == 1) echo "checked=checked"; ?>/> 
                        <label><?php _e('On', 'sola'); ?></label>
                        <p class='description'><?php _e('You will receive notifications about all things important dealing with your campaigns and such', 'sola'); ?></p>
                        <input type="radio" name="sola_nl_notifications" value="0" <?php if ($notification == 0) echo "checked=checked"; ?>/> 
                        <label><?php _e('Off', 'sola'); ?></label>
                        <p class='description'><?php _e('Simple. You won\'t get any notifications. We don\'t recommend this', 'sola'); ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e('View In Browser Text', 'sola'); ?></label>
                        <p class='description' style='padding:10px;'><?php _e('The text that will display at the top of the newsletter allowing users to view your newsletter in their browser.', 'sola'); ?></p>
                    </td>
                    <td>
                        <input type="text" class='sola-input' name="sola_nl_browser_text" value="<?php echo get_option("sola_nl_browser_text"); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e('Un-subscribe Text', 'sola'); ?></label>
                        <p class='description' style='padding:10px;'><?php _e('People sign up and then some un-subscribe. Don\'t worry about them, they were never true believers!', 'sola'); ?></p>
                    </td>
                    <td>
                        <input type="text" class='sola-input' name="sola_nl_unsubscribe" value="<?php echo get_option("sola_nl_unsubscribe"); ?>"/>
                    </td>
                </tr>
            </table>
            <hr/>
            <table width="100%"> 
                <tr>
                    <td width="250px;">
                        <label><?php _e('Enable Link Tracking Globally', 'sola'); ?></label>
                        <p class='description' style='padding:10px;'><?php _e('Enable link tracking for all links in your newsletters. By disabling this, you will not be able to see statistics for any link clicks.', 'sola'); ?></p>
                    </td>
                    <td>
                        <input type="checkbox" class='sola-input' value="1" name="sola_nl_enable_link_tracking" <?php if(get_option("sola_nl_enable_link_tracking") == 1) { echo 'checked'; } ?>/>
                    </td>
                </tr>
            </table>
        </div>
        <div id="tabs-2">
            <h2><?php _e("How To Send Your Mail","sola"); ?></h2>
            <div style="float: left; width:40%">
                <table>
                   <tr>
                      <td width="250px">
                         <h3><?php _e("WordPress Mail","sola"); ?></h3>
                        <p class="description"><?php _e("Good 'ol WordPress mail. Nothing wrong with this method for small lists","sola"); ?></p>
                      </td>
                      <td>
                          <input type="radio" id='radio_button_1' name="sola_nl_send_method" value="1" <?php if(get_option("sola_nl_send_method") == "1") echo "checked";?>/>
                      </td>
                   </tr>
                   <tr>
                      <td width="250px">
                         <h3><?php _e("Gmail","sola"); ?></h3>
                        <p class="description"><?php _e("Send a maximum of 500 mails per day using your Gmail account.","sola"); ?></p>
                      </td>
                      <td>
                          <input type="radio" id='radio_button_3' name="sola_nl_send_method" value="3" <?php if(get_option("sola_nl_send_method") == "3") echo "checked";?>/>
                      </td>
                   </tr>
                   <tr>
                      <td width="250px">
                         <h3><?php _e("SMTP Server","sola"); ?></h3>
                        <p class="description">
                            <?php _e("Got bigger Lists? Want to stay out of spam folders? This is your method","sola"); ?>
                         </p>
                      </td>
                      <td>
                          <input type="radio" id='radio_button_2' name="sola_nl_send_method" value="2" <?php if(get_option("sola_nl_send_method") == "2") echo "checked";?>/>
                      </td>
                   </tr>
                </table>
            </div>
               
            <div id='sola_nl_smtp'>
                <table>
                    <tr>
                        <td width="125px">
                            <label><?php _e("Host","sola"); ?></label>
                        </td>
                        <td>
                            <input type="text" class="sola-input" id="sola_nl_host" name="sola_nl_host" value="<?php echo get_option("sola_nl_host"); ?>"/>
                            <p class='description'><?php _e("Enter your host's URL","sola"); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label><?php _e("Username","sola"); ?></label>
                        </td>
                        <td>
                            <input type="text" class="sola-input" id="sola_nl_username" name="sola_nl_username" placeholder="me@mydomain.com" value="<?php echo get_option("sola_nl_username"); ?>"/> 
                            <p class='description'><?php _e("The username for your SMTP Account","sola"); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label><?php _e("Password","sola"); ?></label>
                        </td>
                        <td>
                            <input type="password" class="sola-input" id="sola_nl_password" name="sola_nl_password" placeholder="Password" value="<?php echo get_option("sola_nl_password"); ?>"/> 
                            <p class='description'><?php _e("Your SMTP Password","sola"); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label><?php _e("Port","sola"); ?></label>
                        </td>
                        <td>
                            <input type="text" class="sola-input" id="sola_nl_port" name="sola_nl_port" placeholder="Port Number" value="<?php echo get_option("sola_nl_port"); ?>"/>
                            <p class='description'><?php _e("And Finally your port number. We recommend 465 or 587 if possible","sola"); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label><?php _e("Encryption","sola"); ?></label>
                        </td>
                        <td>
                            <?php $encryption = get_option("sola_nl_encryption"); ?>
                            <input type="radio" name="encryption" id="enc_none" value="" <?php if(!$encryption){ echo "checked";} ?>><span><?php _e("No Encryption","sola"); ?></span><br/>
                            <input type="radio" name="encryption" id="enc_ssl" value="ssl" <?php if($encryption == "ssl"){ echo "checked";} ?>><span><?php _e("SSL","sola"); ?></span><br/>
                            <input type="radio" name="encryption" id="enc_tls" value="tls" <?php if($encryption == "tls"){ echo "checked";} ?>><span><?php _e("TLS - This is not the same as STARTTLS. For most servers SSL is the recommended option.","sola"); ?></span><br/>
                        </td>
                    </tr>
                </table>
            </div>
            <div style='clear: both;'></div>
            <hr/>

            <h2><?php _e("Mail Throttling","sola"); ?></h2>
            <?php 
            $hosting_provider = get_option('sola_nl_hosting_provider');
            $limit = get_option('sola_nl_send_limit_qty');
            $limit_time = get_option('sola_nl_send_limit_time');
            ?>
            <table>
                <tr>
                    <td width="40%" style='min-width:350px;' valign='top'>
                        <p class="description" style='padding:10px;'>
                           <?php _e("Certain hosts limit the amount of mails you can send per hour or per day. It is very important that the figure used here is correct or you may run the risk of certain mails not being sent.","sola"); ?>
                        </p>
                    </td>
                    <td>
                        <p style='font-weight:bold;'><?php _e("Who do you host with?","sola"); ?></p>
                        <select name='sola_nl_hosting_provider' id='sola_nl_hosting_provider'>
                            <option value='0' mtype='3600' send_limit="20" <?php if($hosting_provider == 0){echo "selected";} ?>><?php _e("My mail is being sent via WPmail","sola"); ?></option>
                            <option value='1' mtype='3600' send_limit="20" <?php if($hosting_provider == 1){echo "selected";} ?>><?php _e("My mail is being sent through Gmail","sola"); ?></option>
                            <option value='2' mtype='1800' send_limit="200" <?php if($hosting_provider == 2){echo "selected";} ?>><?php _e("My mail is being sent through a SMTP Server","sola"); ?></option>
                            <option value='3' mtype='1800' send_limit="90" <?php if($hosting_provider == 3){echo "selected";} ?>>1and1</option>
                            <option value='4' mtype='1800' send_limit="70" <?php if($hosting_provider == 4){echo "selected";} ?>>Bluehost</option>
                            <option value='5' mtype='900' send_limit="115" <?php if($hosting_provider == 5){echo "selected";} ?>>df.eu</option>
                            <option value='6' mtype='3600' send_limit="45" <?php if($hosting_provider == 6){echo "selected";} ?>>Dreamhost</option>
                            <option value='7' mtype='900' send_limit="18" <?php if($hosting_provider == 7){echo "selected";} ?>>Free.fr</option>
                            <option value='8' mtype='1800' send_limit="490" <?php if($hosting_provider == 8){echo "selected";} ?>>Froghost</option>
                            <option value='9' mtype='900' send_limit="95" <?php if($hosting_provider == 9){echo "selected";} ?>>GoDaddy</option>
                            <option value='10' mtype='1800' send_limit="45" <?php if($hosting_provider == 10){echo "selected";} ?>>GreenGeeks</option>
                            <option value='11' mtype='3600' send_limit="2000" <?php if($hosting_provider == 11){echo "selected";} ?>>Hawkhost</option>
                            <option value='31' mtype='3600' send_limit="450" <?php if($hosting_provider == 31){echo "selected";} ?>>Hetzner</option>
                            <option value='12' mtype='900' send_limit="80" <?php if($hosting_provider == 12){echo "selected";} ?>>Hivetec</option>
                            <option value='13' mtype='900' send_limit="115" <?php if($hosting_provider == 13){echo "selected";} ?>>Host Gator</option>
                            <option value='14' mtype='900' send_limit="115" <?php if($hosting_provider == 14){echo "selected";} ?>>Host Monster</option>
                            <option value='15' mtype='3600' send_limit="4" <?php if($hosting_provider == 15){echo "selected";} ?>>Hotmail</option>
                            <option value='16' mtype='1800' send_limit="70" <?php if($hosting_provider == 16){echo "selected";} ?>>Just Host</option>
                            <option value='17' mtype='900' send_limit="15" <?php if($hosting_provider == 17){echo "selected";} ?>>Lunarpages</option>
                            <option value='18' mtype='900' send_limit="115" <?php if($hosting_provider == 18){echo "selected";} ?>>Media Temple</option>
                            <option value='19' mtype='3600' send_limit="180" <?php if($hosting_provider == 19){echo "selected";} ?>>Netfirms</option>
                            <option value='20' mtype='900' send_limit="100" <?php if($hosting_provider == 20){echo "selected";} ?>>Netissime</option>
                            <option value='21' mtype='1800' send_limit="90" <?php if($hosting_provider == 21){echo "selected";} ?>>Planet Hoster</option>
                            <option value='32' mtype='7200' send_limit="15" <?php if($hosting_provider == 32){echo "selected";} ?>>Rackspace</option>
                            <option value='22' mtype='900' send_limit="95" <?php if($hosting_provider == 22){echo "selected";} ?>>Rochen</option>
                            <option value='23' mtype='900' send_limit="95" <?php if($hosting_provider == 23){echo "selected";} ?>>Siteground</option>
                            <option value='24' mtype='900' send_limit="250" <?php if($hosting_provider == 24){echo "selected";} ?>>Synthesis</option>
                            <option value='25' mtype='900' send_limit="60" <?php if($hosting_provider == 25){echo "selected";} ?>>Techark</option>
                            <option value='26' mtype='900' send_limit="45" <?php if($hosting_provider == 26){echo "selected";} ?>>VPS.net</option>
                            <option value='27' mtype='900' send_limit="19" <?php if($hosting_provider == 27){echo "selected";} ?>>Webcity</option>
                            <option value='28' mtype='900' send_limit="225" <?php if($hosting_provider == 28){echo "selected";} ?>>Westhost</option>
                            <option value='29' mtype='900' send_limit="60" <?php if($hosting_provider == 29){echo "selected";} ?>>Vexxhost</option>
                            <option value='30' mtype='3600' send_limit="95" <?php if($hosting_provider == 30){echo "selected";} ?>>Yahoo</option>
                        </select>
                        <p style='font-weight:bold;'><?php _e("Limit mail delivery","sola"); ?></p>
                        <p class='bold'><?php _e("Send","sola"); ?> <input type='text' value='<?php echo $limit ?>' size='6' id='sola_nl_send_limit_qty' name='sola_nl_send_limit_qty' /> <?php _e("emails","sola"); ?> 
                            <select id='sola_nl_send_limit_type' name='sola_nl_send_limit_time'>
                                <option <?php if($limit_time == 60){echo "selected";} ?> value='60'><?php _e("every minute","sola"); ?></option>
                                <option <?php if($limit_time == 120){echo "selected";} ?> value='120'><?php _e("every 2 minutes","sola"); ?></option>
                                <option <?php if($limit_time == 300){echo "selected";} ?> value='300'><?php _e("every 5 minutes","sola"); ?></option>
                                <option <?php if($limit_time == 600){echo "selected";} ?> value='600'><?php _e("every 10 minutes","sola"); ?></option>
                                <option <?php if($limit_time == 900){echo "selected";} ?> value='900'><?php _e("every 15 minutes","sola"); ?></option>
                                <option <?php if($limit_time == 1800){echo "selected";} ?> value='1800'><?php _e("every 30 minutes","sola"); ?></option>
                                <option <?php if($limit_time == 3600){echo "selected";} ?> value='3600'><?php _e("every hour","sola"); ?></option>
                                <option <?php if($limit_time == 7200){echo "selected";} ?> value='7200'><?php _e("every 2 hours","sola"); ?></option>
                            </select>  
                        </p>
                        <p><?php _e("Please note: We suggest that you keep the amount of mails being sent below 50 every 5 minutes. We do not take responsibility for any actions that happen as a result of the above settings.","sola"); ?></p>
                    </td>
                </tr>
            </table>          

            <div style='clear: both;'></div>
            <hr/>

            <h2><?php _e("Test Your Mail Settings","sola"); ?></h2>

            <table>
                <tr>
                    <td width="40%" style='min-width:350px;'>
                        <p class="description" style='padding:10px;'>
                            <?php _e("This is to test your mail settings. If you don't receive a mail, your settings maybe incorrect. Please also check your SPAM folder.","sola"); ?>
                        </p>
                    </td>
                    <td>
                        <input type="email" id='sola_nl_to_mail_test' class='sola-input' name="to"/>
                        <button class='button-primary sola_send_test_mail' ><?php _e("Send Test","sola"); ?></button>
                        <br />
                        <input type="checkbox" id='sola_nl_to_mail_test_debug' class='sola-input' name="sola_nl_to_mail_test_debug" placeholder='youremail@email.com' /> <?php _e("Show me the output (debugging purposes)","sola"); ?>
                    </td>
                </tr>
            </table>
        </div>
        <div id="tabs-3">
            <h3><?php _e("Sign Up Widget",'sola'); ?></h3>
            <p><?php _e("To put the sign up widget on your site, go to your widgets page, and drag the Sola Newsletter Subscribe widget to the sidebar of your choice.","sola"); ?></p>
            <table>
                <tr>
                    <td width="250px">
                        <label><?php _e("Title","sola") ?>:</label>
                        <p class="description" style='padding:10px;' ><?php _e("Set the Title of sign up Box","sola"); ?></p>
                    </td>
                    <td>
                        <input class="sola-input" type="text" name="sola_nl_sign_up_title" value="<?php echo get_option("sola_nl_sign_up_title"); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e("Button","sola") ?>:</label>
                        <p class="description" style='padding:10px;'><?php _e('Set the text of sign up button', 'sola'); ?></p>
                    </td>
                    <td>
                        <input class="sola-input" type="text" name="sola_nl_sign_up_btn" value="<?php echo get_option("sola_nl_sign_up_btn"); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label><?php _e("List","sola") ?>:</label>
                        <p class="description" style='padding:10px;'><?php _e("Select lists that subscribers will be associated with","sola"); ?></p>
                    </td>
                    <td>
                        <?php 
                            $sign_up_list = get_option("sola_nl_sign_up_lists");
                            if($sign_up_list){
                                $sign_up_list = unserialize($sign_up_list);
                            } else {
                                $sign_up_list = false;
                            }
                        ?>
                        <?php 
                            $lists = sola_nl_get_lists();
                            foreach($lists as $list){
                                $list_id = $list->list_id;?>
                                <input type="checkbox" name="sola_nl_sign_up_sub_list[]" <?php if(in_array($list_id, $sign_up_list)) echo "checked" ?> value="<?php echo $list->list_id ?>"/>
                                <label><?php echo $list->list_name ?> (<?php echo sola_nl_total_list_subscribers($list->list_id) ?>)</label>
                                <p class="description" style='padding:10px;'><?php echo $list->list_description ?></p>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">
                        <label><?php _e("Subject Line","sola"); ?></label>
                        <p class="description" style='padding:10px;'>
                            <?php _e("This is the subject text that gets sent to a new subscriber to confirm their subscription.","sola"); ?>
                        </p>
                        <td>
                            <input class="sola-input" type="text" name="sola_nl_confirm_subject" value="<?php echo get_option("sola_nl_confirm_subject"); ?>" />
                        </td>
                    </td>
                </tr>
                <tr>                  
                    <td style="vertical-align: top;">
                        <label><?php _e("Confirmation Email","sola"); ?></label>
                        <p class="description" style='padding:10px;'>
                            <?php _e("This is the confirmation message that gets sent to a new subscriber to confirm their subscription.","sola"); ?>
                            <br/>
                            <br/>
                            <?php _e("Don't forget to add [confirm_link] Link Text here [/confirm_link] for your subscribers to confirm their subscription","sola"); ?>
                            <br/>
                            <br/>
                            <?php _e("Use [sub_name] to show your subscribers name (Optional)","sola"); ?>
                        </p>
                    </td>
                    <td>
                        <textarea cols="80" rows="10" name='sola_nl_confirm_mail'><?php echo get_option("sola_nl_confirm_mail"); ?></textarea>
                    </td>
                </tr>
                <tr>                  
                    <td style="vertical-align: top;">
                        <label><?php _e("Thank You Text","sola"); ?></label>
                        <p class="description" style='padding:10px;'>
                            <?php _e("This is the message the user will see as they signup to your newsletters on your site.","sola"); ?>           
                        </p>
                    </td>
                    <td>
                        <textarea cols="80" rows="10" name='sola_nl_confirm_thank_you'><?php echo get_option("sola_nl_confirm_thank_you"); ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div id="tabs-4">
            <h3><?php _e("Social Links",'sola'); ?></h3>
            <p class="description"><?php _e("Insert Your links to your social platforms that you are associated with",'sola'); ?></p>
            <table>
                <?php $social_links = get_option("sola_nl_social_links");
                    foreach($social_links as $social_name=>$social_link){
                ?>
                    <tr>
                        <td>
                            <label><img type="social_icon" height="25px"  src="<?php echo PLUGIN_DIR ?>/images/social-icons/default/<?php echo $social_name ?>.png" /></label>
                        </td>
                        <td>
                            <input name="social_links[<?php echo $social_name ?>]" type="text" value="<?php echo $social_link?>" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div id="tabs-5">
            <?php 
                if(function_exists('sola_nl_register_pro_version')){
                    sola_nl_analytics_settings_page_pro();
                } else {
            ?>
                    <p><h2 class="text-center" ><?php _e('Upgrade to the','sola')?> <a target='_BLANK' href='http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=analytics' style='color:#EC6851;'><?php _e('Premium version','sola')?> </a><?php _e('to integrate your Sola Newsletters with Google Analytics.','sola')?></h2></p>
            <?php } ?>
        </div>
        <div id="tabs-6">
            <h2><?php _e("Cron job setup (Advanced users only)","sola") ?></h2>
            
            <p><?php _e("Sola Newsletters uses <strong>wp_cron</strong> to send mails. The downside to this is that wp_cron is only activated when someone visits your site or if you are logged in. This means that if your site has a low visit count, your mail will not be sent reliably at the intervals you have specified.","sola"); ?></p>
            
            <p><?php _e("If you need more reliability and if you want to ensure that your mails get sent out at the intervals you have specified in your Email Settings tab, setting up a real cron job would be required.","sola"); ?></p>
            
            <p><?php _e("We'd suggest that you follow these instructions to successfully set up a real cron job:","sola"); ?></p>
            
            <ul>
                <li> - <?php _e("Log in to cPanel","sola"); ?></li>
                <li> - <?php _e("Under Advanced, click on Cron jobs","sola"); ?></li>
                <li> - <?php _e("Under New Cron Job, select the time interval you'd prefer (once per hour, once every 5 minutes, etc.)","sola"); ?></li>
                <li>- <?php _e("Enter this for Command (changing the URL to match your site):","sola"); ?></li>
            </ul>
            <p>
                <strong><em>wget -O /dev/null http://yoursite.com/wp-cron.php?doing_wp_cron</em></strong>
            </p>
            <p>
                <br/>
                <br/>
                <?php _e("If you require technical support with setting up your cron job,","sola"); ?> <a target='_BLANK' href="http://solaplugins.com/technical-support/cron-job" title="Let Sola Plugins set up your cron job"><?php _e("we can assist you for a charge of $10","sola"); ?></a>
            </p>
            <?php
                $timestamp = wp_next_scheduled( 'sola_cron_send_hook' );
                echo "<br /><br /><h3>".__("Next wp_cron event","sola")."</h2>";
                echo "<strong>".__("Scheduled to run at","sola"). ":</strong> " . date("Y-m-d H:i:s",$timestamp);
                echo "<br /><strong>".__("Server time now","sola"). ":</strong> " . date("Y-m-d H:i:s");
            ?>
        </div>
        <div id="tabs-7">
            <?php include("can-spam-act.php"); ?>
        </div>    
            
            
            
        
        
        <?php if (function_exists("sola_nl_register_pro_version")) { } else { ?>
        
            <div id="tabs-8">
                <center>
                    <h1 style="font-size: 50px; font-weight: 300"><?php _e("Why Go","sola")?> <strong style="color: #ec6851;"><?php _e("Premium?","sola")?></strong></h1>
                </center>
                <div style="display: inline-block; width: 49%; border-right: solid 8px #ec6851;">
                    <center>
                        <h1 style=" font-size: 35px; color: #ec6851"><?php _e('+2500 Subscribers', 'sola') ?></h1>
                        <h2><?php _e('There are no limits on how many subscribers you can have or send to', 'sola') ?></h2>
                        <hr style="width: 90%; margin: 30px 0;"/>
                        <h1 style=" font-size: 35px; color:#ec6851"><?php _e('More Themes', 'sola') ?></h1>
                        <h2><?php _e('Get more themes and styles to choose from to make your E-mails so much better', 'sola') ?></h2>
                    </center>
                </div>
                <div style="display: inline-block; width: 49%;">
                    <center>
                        <h1 style=" font-size: 35px; color: #ec6851"><?php _e('Detailed Statistics', 'sola') ?></h1>
                        <h2><?php _e('Get insights on your subscribers - How many opens and what links were clicked', 'sola') ?></h2>
                        <hr style="width: 90%; margin: 30px 0;"/>
                        <h1 style=" font-size: 35px; color:#ec6851"><?php _e('Google Analytics', 'sola') ?></h1>
                        <h2><?php _e('We have intergrated analytics so you can easily track traffic from emails to your site', 'sola') ?></h2>
                    </center>
                </div>
                <a target="_BLANK" href="http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=premium" title="Get Premium Version Now!" style="width: 50%; background-color: #EC6851; display: block; text-align: center; height: 60px; line-height: 60px; font-size: 30px; margin-top: 40px; color:#fff; border-color: #EC6851; margin-left:auto; margin-right:auto;" class="button"><?php _e('Get The Premium Version','sola') ?></a>
            </div>
        <?php } ?>
        
        <p class='submit'><input type='submit' name='sola_nl_save_settings' class='button-primary' value='<?php _e("Save Settings","sola") ?>' /></p>
        
    </form>
</div>
        
<?php include 'footer.php'; ?>