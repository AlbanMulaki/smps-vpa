<?php
class es_cls_registerhook
{
	public static function es_activation()
	{
		global $wpdb;
		
		add_option('email-subscribers', "1.0");

		// Plugin tables
		$array_tables_to_plugin = array('es_emaillist','es_sentdetails','es_deliverreport','es_pluginconfig');
		$errors = array();
		
		// loading the sql file, load it and separate the queries
		$sql_file = ES_DIR.'sql'.DS.'es-createdb.sql';
		$prefix = $wpdb->prefix;
        $handle = fopen($sql_file, 'r');
        $query = fread($handle, filesize($sql_file));
        fclose($handle);
        $query=str_replace('CREATE TABLE IF NOT EXISTS `','CREATE TABLE IF NOT EXISTS `'.$prefix, $query);
        $queries=explode('-- SQLQUERY ---', $query);

        // run the queries one by one
        $has_errors = false;
        foreach($queries as $qry)
		{
            $wpdb->query($qry);
        }
		
		// list the tables that haven't been created
        $missingtables=array();
        foreach($array_tables_to_plugin as $table_name)
		{
			if(strtoupper($wpdb->get_var("SHOW TABLES like  '". $prefix.$table_name . "'")) != strtoupper($prefix.$table_name))  
			{
                $missingtables[]=$prefix.$table_name;
            }
        }
		
		// add error in to array variable
        if($missingtables) 
		{
			$errors[] = __('These tables could not be created on installation ' . implode(', ',$missingtables), ES_TDOMAIN);
            $has_errors=true;
        }
		
		// if error call wp_die()
        if($has_errors) 
		{
			wp_die( __( $errors[0] , ES_TDOMAIN ) );
			return false;
		}
		else
		{
			es_cls_default::es_pluginconfig_default();
			es_cls_default::es_subscriber_default();
			es_cls_default::es_template_default();
			es_cls_default::es_notifications_default();
		}
        return true;
	}
	
	public static function es_deactivation()
	{
		// do not generate any output here
	}
	
	public static function es_admin_option()
	{
		// do not generate any output here
	}
	
	public static function es_adminmenu()
	{
		add_menu_page( __( 'Email Subscriber', ES_TDOMAIN ), 
			__( 'Email Subscriber', ES_TDOMAIN ), 'admin_dashboard', 'email-subscribers', 'es_admin_option', ES_URL.'images/mail.png', 51 );
			
		add_submenu_page('email-subscribers', __( 'Subscribers', ES_TDOMAIN ), 
			__( 'Subscribers', ES_TDOMAIN ), 'administrator', 'es-view-subscribers', array( 'es_cls_intermediate', 'es_subscribers' ));
			
		add_submenu_page('email-subscribers', __( 'Compose', ES_TDOMAIN ), 
			__( 'Compose', ES_TDOMAIN ), 'administrator', 'es-compose', array( 'es_cls_intermediate', 'es_compose' ));
			
		add_submenu_page('email-subscribers', __( 'Notification', ES_TDOMAIN ), 
			__( 'Notification', ES_TDOMAIN ), 'administrator', 'es-notification', array( 'es_cls_intermediate', 'es_notification' ));
			
		add_submenu_page('email-subscribers', __( 'Send Email', ES_TDOMAIN ), 
			__( 'Send Email', ES_TDOMAIN ), 'administrator', 'es-sendemail', array( 'es_cls_intermediate', 'es_sendemail' ));
				
		add_submenu_page('email-subscribers', __( 'Settings', ES_TDOMAIN ), 
			__( 'Settings', ES_TDOMAIN ), 'administrator', 'es-settings', array( 'es_cls_intermediate', 'es_settings' ));	
			
		add_submenu_page('email-subscribers', __( 'Sent Mails', ES_TDOMAIN ), 
			__( 'Sent Mails', ES_TDOMAIN ), 'administrator', 'es-sentmail', array( 'es_cls_intermediate', 'es_sentmail' ));	
					
		add_submenu_page('email-subscribers', __( 'Help & Info', ES_TDOMAIN ), 
			__( 'Help & Info', ES_TDOMAIN ), 'administrator', 'es-general-information', array( 'es_cls_intermediate', 'es_information' ));
			
	}
	
	public static function es_widget_loading()
	{
		register_widget( 'es_widget_register' );
	}
}

class es_widget_register extends WP_Widget 
{
	function __construct() 
	{
		$widget_ops = array('classname' => 'widget_text elp-widget', 'description' => __(ES_PLUGIN_DISPLAY, ES_TDOMAIN), ES_PLUGIN_NAME);
		parent::__construct(ES_PLUGIN_NAME, __(ES_PLUGIN_DISPLAY, ES_TDOMAIN), $widget_ops);
	}
	
	function widget( $args, $instance ) 
	{
		extract( $args, EXTR_SKIP );
		
		$es_title 	= apply_filters( 'widget_title', empty( $instance['es_title'] ) ? '' : $instance['es_title'], $instance, $this->id_base );
		$es_desc	= $instance['es_desc'];
		$es_name	= $instance['es_name'];
		$es_group	= $instance['es_group'];

		echo $args['before_widget'];
		if ( ! empty( $es_title ) )
		{
			echo $args['before_title'] . $es_title . $args['after_title'];
		}
		// display widget method
		$url = home_url();
		
		global $es_includes;
		if (!isset($es_includes) || $es_includes !== true) 
		{ 
			$es_includes = true;
			?>
			<link rel="stylesheet" media="screen" type="text/css" href="<?php echo ES_URL; ?>widget/es-widget.css" />
			<?php 
		} 
		?>
		<script language="javascript" type="text/javascript" src="<?php echo ES_URL; ?>widget/es-widget.js"></script>
		<div>
			<?php if( $es_desc <> "" ) { ?>
			<div class="es_caption"><?php echo $es_desc; ?></div>
			<?php } ?>
			<div class="es_msg"><span id="es_msg"></span></div>
			<?php if( $es_name == "YES" ) { ?>
			<div class="es_lablebox"><?php _e('Name', ES_TDOMAIN); ?></div>
			<div class="es_textbox">
				<input class="es_textbox_class" name="es_txt_name" id="es_txt_name" value="" maxlength="225" type="text">
			</div>
			<?php } ?>
			<div class="es_lablebox"><?php _e('Email *', ES_TDOMAIN); ?></div>
			<div class="es_textbox">
				<input class="es_textbox_class" name="es_txt_email" id="es_txt_email" onkeypress="if(event.keyCode==13) es_submit_page('<?php echo $url; ?>')" value="" maxlength="225" type="text">
			</div>
			<div class="es_button">
				<input class="es_textbox_button" name="es_txt_button" id="es_txt_button" onClick="return es_submit_page('<?php echo $url; ?>')" value="<?php _e('Subscribe', ES_TDOMAIN); ?>" type="button">
			</div>
			<?php if( $es_name != "YES" ) { ?>
				<input name="es_txt_name" id="es_txt_name" value="" type="hidden">
			<?php } ?>
			<input name="es_txt_group" id="es_txt_group" value="<?php echo $es_group; ?>" type="hidden">
		</div>
		<?php
		echo $args['after_widget'];
	}
	
	function update( $new_instance, $old_instance ) 
	{
		$instance 				= $old_instance;
		$instance['es_title'] 	= ( ! empty( $new_instance['es_title'] ) ) ? strip_tags( $new_instance['es_title'] ) : '';
		$instance['es_desc'] 	= ( ! empty( $new_instance['es_desc'] ) ) ? strip_tags( $new_instance['es_desc'] ) : '';
		$instance['es_name'] 	= ( ! empty( $new_instance['es_name'] ) ) ? strip_tags( $new_instance['es_name'] ) : '';
		$instance['es_group'] 	= ( ! empty( $new_instance['es_group'] ) ) ? strip_tags( $new_instance['es_group'] ) : '';
		return $instance;
	}
	
	function form( $instance ) 
	{
		$defaults = array(
			'es_title' => '',
            'es_desc' 	=> '',
            'es_name' 	=> '',
			'es_group' 	=> ''
        );
		$instance 		= wp_parse_args( (array) $instance, $defaults);
		$es_title 		= $instance['es_title'];
        $es_desc 		= $instance['es_desc'];
        $es_name 		= $instance['es_name'];
		$es_group 		= $instance['es_group'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('es_title'); ?>"><?php _e('Widget Title', ES_TDOMAIN); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('es_title'); ?>" name="<?php echo $this->get_field_name('es_title'); ?>" type="text" value="<?php echo $es_title; ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('es_name'); ?>"><?php _e('Display Name Field', ES_TDOMAIN); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('es_name'); ?>" name="<?php echo $this->get_field_name('es_name'); ?>">
				<option value="YES" <?php $this->es_selected($es_name == 'YES'); ?>>YES</option>
				<option value="NO" <?php $this->es_selected($es_name == 'NO'); ?>>NO</option>
			</select>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('es_desc'); ?>"><?php _e('Short Description', ES_TDOMAIN); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('es_desc'); ?>" name="<?php echo $this->get_field_name('es_desc'); ?>" type="text" value="<?php echo $es_desc; ?>" />
			<?php _e('Short description about your subscription form.', ES_TDOMAIN); ?>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('es_group'); ?>"><?php _e('Subscriber Group', ES_TDOMAIN); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('es_group'); ?>" name="<?php echo $this->get_field_name('es_group'); ?>" type="text" value="<?php echo $es_group; ?>" />
        </p>
		<?php
	}
	
	function es_selected($var) 
	{
		if ($var==1 || $var==true) 
		{
			echo 'selected="selected"';
		}
	}
}
?>