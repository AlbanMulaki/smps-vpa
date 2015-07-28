<?php
// General Functions for Plugin

if (!function_exists('is_post')) {

    function is_post() {
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'post')
            return true;
        else
            return false;
    }

}

if (!function_exists('is_in_post')) {

    function is_in_post($key='', $val='') {
        if ($key == '') {
            return false;
        } else {
            if (isset($_POST[$key])) {
                if ($val == '')
                    return true;
                else if ($_POST[$key] == $val)
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
    }

}

if (!function_exists('is_get')) {

    function is_get() {
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'get')
            return true;
        else
            return false;
    }

}


if(!function_exists('uultra_default_socail_links')) {
	
    function uultra_default_socail_links() 
	{
        add_filter('uultra_social_url_user_email', 'uultra_format_email_link');
        add_filter('uultra_social_url_twitter', 'uultra_format_twitter_link');
        add_filter('uultra_social_url_facebook', 'uultra_format_facebook_link');
        add_filter('uultra_social_url_googleplus', 'uultra_format_google_link');		
		add_filter('uultra_social_url_user_url', 'uultra_format_user_url_link');
    }
}

// Hooking default social url
uultra_default_socail_links();


if(!function_exists('uultra_format_email_link')) {
    function uultra_format_email_link($content){
        return 'mailto:'.$content;
    }
}

if(!function_exists('uultra_format_user_url_link')) 
{
    function uultra_format_user_url_link($content){
        return $content;
    }
}

if(!function_exists('uultra_format_twitter_link')) {
    function uultra_format_twitter_link($content){
        return 'http://twitter.com/'.$content;
    }
}

if(!function_exists('uultra_format_facebook_link')) {
    function uultra_format_facebook_link($content){
        return 'http://www.facebook.com/'.$content;
    }
}

if(!function_exists('uultra_format_google_link')) {
    function uultra_format_google_link($content){
        return 'https://plus.google.com/'.$content;
    }
}




if (!function_exists('is_in_get')) {

    function is_in_get($key='', $val='') {
        if ($key == '') {
            return false;
        } else {
            if (isset($_GET[$key])) {
                if ($val == '')
                    return true;
                else if ($_GET[$key] == $val)
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
    }

}

if(!function_exists('not_null'))
{
    function not_null($value)
    {
        if (is_array($value))
        {
            if (sizeof($value) > 0)
                return true;
            else
                return false;
        }
        else
        {
            if ( (is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0))
                return true;
            else
                return false;
        }
    } 
}



if(!function_exists('get_value'))
{
    function get_value($key='')
    {
        if($key!='')
        {
            if(isset($_GET[$key]) && not_null($_GET[$key]))
            {
                if(!is_array($_GET[$key]))
                    return trim($_GET[$key]);
                else
                    return $_GET[$key];
            }
    
            else
                return '';
        }
        else
            return '';
    }
}


if(!function_exists('post_value'))
{
    function post_value($key='')
    {
        if($key!='')
        {
            if(isset($_POST[$key]) && not_null($_POST[$key]))
            {
                if(!is_array($_POST[$key]))
                    return trim($_POST[$key]);
                else
                    return $_POST[$key];
            }
            else
                return '';
        }
        else
            return '';
    }
}


if(!function_exists('is_opera'))
{
    function is_opera()
    {
        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        return preg_match('/opera/i', $user_agent);
    }
}

if(!function_exists('is_safari'))
{
    function is_safari()
    {
        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        return (preg_match('/safari/i', $user_agent) && !preg_match('/chrome/i', $user_agent));
    }
}


// Check with the magic quotes functionality Start
function stripslashess(&$item)
{
    $item = stripslashes($item);
}

if(get_magic_quotes_gpc())
{
    array_walk_recursive($_GET, 'stripslashess' );
    array_walk_recursive($_POST, 'stripslashess');
    array_walk_recursive($_SERVER, 'stripslashess');
}
if(!function_exists('is_active'))
{

/* Check if user is active before login  */
	function is_active($user_id) 
	{
		$checkuser = get_user_meta($user_id, 'usersultra_account_status', true);
		if ($checkuser == 'active')
			return true;
		return false;
	}}