<?php
class XooUserCaptchaModule
{
    public $load_captcha = false;
    private $captcha_plugin = '';
    public $default_captcha_plugin = 'recaptcha';
    
    public function __construct()
    {
        // Nothing to do here.    
    }
    
    private function load_captcha_plugin_setting($captcha= '')
    {
        // Getting values from database
        $settings = get_option('userultra_options');
        
        // Shortcode optionis not given or given blank
        if($captcha == '')
        {
            if(isset($settings['captcha_plugin']) && $settings['captcha_plugin'] != '' && $settings['captcha_plugin'] != 'none')
            {
                $this->load_captcha = true;
                $this->captcha_plugin = $settings['captcha_plugin']; 
            }
            else
            {
                $this->load_captcha = false;
            }
            
        }
        else if($captcha == 'no' || $captcha == 'false')
        {
            $this->load_captcha = false;
        }
        else 
        {
            if($captcha == 'yes' || $captcha == 'true')
            {
                if(isset($settings['captcha_plugin']) && $settings['captcha_plugin'] != '' && $settings['captcha_plugin'] != 'none')
                {
                    $this->load_captcha = true;
                    $this->captcha_plugin = $settings['captcha_plugin']; 
                }
                else
                {
                    $this->load_captcha = false;
                }
            }
            else
            {
                $this->load_captcha = true;
                $this->captcha_plugin = $captcha;
            }
                
        }
        
    }
    
    public function load_captcha($captcha= '')
    {
        global $xoouserultra;
        
        // Load captcha plugin settings based on shortcode and database values.
        $this->load_captcha_plugin_setting($captcha);
        
        if($this->load_captcha == true)
        {
            $method_name = 'load_'.$this->captcha_plugin;
            
            if(method_exists($this, $method_name))
            {
                $captcha_html = '';
                $captcha_html = $this->$method_name();
                
                if($captcha_html == '')
                {
                    return $this->load_no_captcha_html();
                }
                else
                {
                    $form_text = '';
                    $form_text = $xoouserultra->get_option('captcha_label');
                    if($form_text == '')
                        $form_text = __('Human Check','xoousers');
						
						
						//heading text					
					$heading_text = '';
                    $heading_text = $xoouserultra->get_option('captcha_heading');
                    
					if($heading_text == ''){
                        $heading_text = __("Prove you're not a robot",'xoousers');}
                    
                    
                    $display = '';    
					$display .= '<div class="xoouserultra-clear">&nbsp;</div>';
					$display .= '<div class="xoouserultra-clear">&nbsp;</div>';	
					
					 $display .= '<div class="xoouserultra-field xoouserultra-seperator xoouserultra-edit xoouserultra-edit-show">'.$heading_text.'</div>';
					
					
					$display .= '<div class="xoouserultra-field xoouserultra-edit xoouserultra-edit-show">';
					$display .= '<div class="xoouserultra-clear"></div>';               					
					$display .= '<label class="xoouserultra-field-type" for="'.$meta.'">';			
					$display .= '<span>'.$form_text.' </span></label>';
					$display .= '<div class="xoouserultra-field-value">';
					$display .= $captcha_html;						
					$display .='<input type="hidden" name="captcha_plugin" value="'.$this->captcha_plugin.'" />';					
					$display .= '</div>';	
					
					$display .= '<div class="xoouserultra-clear"></div>';					
					
                    
                    return $display;
                }
            }
            else
            {
                return $this->load_no_captcha_html();
            }
        }
        else
        {
            return $this->load_no_captcha_html();
        }
    }
    
    public function load_no_captcha_html()
    {
        return '<input type="hidden" name="no_captcha" value="yes" />';
    }
    
    public function validate_captcha($captcha_plugin = '')
    {
        if($captcha_plugin == '')
        {
            // No plugin set, returning true
            return true; 
        }
        else
        {
            $method_name = 'validate_'.$captcha_plugin;
            
            if(method_exists($this, $method_name))
            {
                return $this->$method_name();
            }
            else
            {
                return true;
            }
            
        }
    }
    
    /*
     *  Function to Load Fun Captcha 
     */
    private function load_funcaptcha()
    {
        if(class_exists('FUNCAPTCHA')) 
        {
            $funcaptcha = funcaptcha_API();
            $options = funcaptcha_get_settings();
            return $funcaptcha->getFunCaptcha($options['public_key']);
        }   
        else
        {
            return '';
        }    
    }
    
    /*
     *  Function to validate Fun Captcha
     */
    private function validate_funcaptcha()
    {
        if(class_exists('FUNCAPTCHA'))
        {
            $funcaptcha = funcaptcha_API();
            $options = funcaptcha_get_settings();
            return $funcaptcha->checkResult($options['private_key']);
        }
        else
        {
            return true;
        } 
    }
    

   /*
    *  Function to Load ReCaptcha
    */
    
    private function load_recaptcha_class()
    {
        
        require_once xoousers_path . 'xooclasses/xoo.userultra.recaptchalib.php';
    } 
    
    private function load_recaptcha()
    {
        global $xoouserultra;
        $this->load_recaptcha_class();
        
        // Getting the Public Key to load reCaptcha
        $public_key = '';
        $public_key = $xoouserultra->get_option('recaptcha_public_key');
        
        if($public_key != '')
        {
            $captcha_code = '';
            
            $recaptcha_theme = 'xoousers';
            
            if($recaptcha_theme == 'xoousers')
            {
                $theme_code = "<script type=\"text/javascript\"> var RecaptchaOptions = {    theme : 'custom',lang: 'en',    custom_theme_widget: 'recaptcha_widget' };</script>";
                $captcha_code = $this->load_custom_recaptcha($public_key);
            }
            else
            {
                $theme_code = "<script type=\"text/javascript\">var RecaptchaOptions = {theme : '".$recaptcha_theme."', lang:'en'};</script>";
                $captcha_code = recaptcha_get_html($public_key, null);
            }
            
            return $theme_code.$captcha_code;
        }
        else
        {
            // No public key is not set in admin. So loading no captcha HTML. 
            return $this->load_no_captcha_html();
        }
        
    }
    
   /*
    *  Function to Validate ReCaptcha
    */
    
    private function validate_recaptcha()
    {
        global $xoouserultra;
        $this->load_recaptcha_class();
        
        // Getting the Private Key to validate reCaptcha
        $private_key = '';
        $private_key = $xoouserultra->get_option('recaptcha_private_key');
        
        
        if($private_key != '')
        {
            if (is_in_post('recaptcha_response_field'))
            {
                $resp = recaptcha_check_answer ($private_key,
                        $_SERVER["REMOTE_ADDR"],
                        post_value("recaptcha_challenge_field"),
                        post_value("recaptcha_response_field"));
            
                // Captcha is Valid
                if ($resp->is_valid)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return true;
            }    
        }
        else
        {
            // Private key is not set in admin
            return true;
        }
    }
    
    private function load_custom_recaptcha($public_key='')
    {
        return '<div id="recaptcha_widget">
                        <div id="recaptcha_image_holder">
                            <div id="recaptcha_image" class="uultra-captcha-img"></div>
                            <div class="recaptcha_text_box">
                                <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="text" placeholder="Enter Verification Words" />
                            </div>
                        </div>
                        <div id="recaptcha_control_holder">
                            <a href="javascript:Recaptcha.switch_type(\'image\');" title="Load Image"><i class="fa fa-camera"></i></a>
                            <a href="javascript:Recaptcha.switch_type(\'audio\');" title="Load Audio"><i class="fa fa-volume-up"></i></a>
                            <a href="javascript:void(0);" id="recaptcha_reload_btn" onclick="Recaptcha.reload();" title="Refresh Image"><i class="fa fa-refresh"></i></a>
                        </div> 
                </div>

                 <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k='.$public_key.'"></script>
                 <noscript>
                   <iframe src="http://www.google.com/recaptcha/api/noscript?k='.$public_key.'" height="300" width="500" frameborder="0"></iframe>
                   <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
                   <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
                 </noscript>';
    }
    
    
}
$key = "captchamodule";
$this->{$key} = new XooUserCaptchaModule();