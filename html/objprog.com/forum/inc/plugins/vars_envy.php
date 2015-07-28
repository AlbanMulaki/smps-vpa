<?php
/**
  * Version:            1.0
  * Compatibillity:     MyBB 1.8.x
  * Website:            http://forosmybb.es
  * Autor:              Dark Neo
*/

if(!defined("IN_MYBB"))
{
    die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

// Enganche para cargar las plantillas a utilizar por el plugin
$plugins->add_hook("global_start", "vars_envy_global");

function vars_envy_info()
{
    global $mybb, $db, $lang;
    
    return array(
        'name'          => 'XSTYLED custom languaje vars',
        'description'   => 'This plugins loads custom languajes variables for XSTYLED themes.',
        'website'       => 'http://www.xstyled.com',
        'author'        => 'Dark Neo',
        'authorsite'    => 'http://forosmybb.es',
        'version'       => '1.0',
        'guid'          => '',  // This value dissapear on 1.8
        'codename'      => '',
        'compatibility' => '18*'
    );
}

function vars_envy_activate()
{

}


function vars_envy_deactivate()
{

}

function vars_envy_global()
{
    global $mybb, $lang;

    if(file_exists($lang->path."/".$lang->language."/vars_envy.lang.php"))
    {
        $lang->load("vars_envy");
    }
    else if(file_exists($lang->path."/english/vars_envy.lang.php"))
    {
        $lang->load("vars_envy");
    }
    else{
        return false;
    }
    
}
?>