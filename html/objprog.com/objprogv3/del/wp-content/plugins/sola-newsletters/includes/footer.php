<br /><br />
<hr />
<div class="footer" style="padding:15px 7px;">
    <div id=foot-contents>
        <div class="support">
            <em><?php _e("Sola Newsletters. If you find any errors or if you have any suggestions","sola");?>, <a href="http://solaplugins.com/support-desk" target="_BLANK"><?php _e("please get in touch with us","sola"); ?></a>.</em>
            
            <br />
            <br />
            <?php
                $support = '<a href="http://solaplugins.com/support-desk/" target="_BLANK">'.__('Support Desk', 'sola').'</a>';
                $contact = '<a href="http://solaplugins.com/contact-us/" target="_BLANK">'.__('Contact', 'sola').'</a>';
            ?>
            <em><?php _e('Automatic Post Notifications are still in Beta. If you experience any issues or have any feedback for us, please get in contact with us via our '.$support.' or our '.$contact.' page', 'sola'); ?></em>
            
            <?php if (function_exists("sola_nl_register_pro_version")) { global $sola_nl_pro_version; global $sola_nl_pro_version_string; ?>
            
            <br />
            <br />
            
            <?php _e('Sola Newsletter Premium Version: ', 'sola'); ?><a target='_BLANK' href="http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=version_premium"><?php echo $sola_nl_pro_version.$sola_nl_pro_version_string; ?></a> |
            
            <a target="_blank" href="http://solaplugins.com/support-desk/"><?php _e('Support', 'sola'); ?></a>
            
            <?php } else { global $sola_nl_version; global $sola_nl_version_string; ?>
            
            <br />
            <br />
                
            <?php _e('Sola Newsletter Version: ', 'sola'); ?><a target='_BLANK' href="http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=version_free"><?php echo $sola_nl_version.$sola_nl_version_string; ?></a> |
            
            <a target="_blank" href="http://solaplugins.com/support-desk/"><?php _e('Support', 'sola'); ?></a> | 
            
            <a target="_blank" id="uppgrade" href="http://solaplugins.com/plugins/sola-newsletters/?utm_source=plugin&utm_medium=link&utm_campaign=footer" title="Premium Upgrade"><?php _e('Go Premium', 'sola'); ?></a>
            
            <?php } ?>
            
        </div>
    </div>
</div>
