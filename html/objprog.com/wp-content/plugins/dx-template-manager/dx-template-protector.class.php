<?php


class DX_Template_Protector {
	
	private $dxdt_setting;
	/**
	 * Construct me
	 */
	public function DX_Template_Protector() {
		
		$this->dxdt_setting = get_option('dxdt_setting', '');
		// add an admin page for agreement before activating the plugin
		add_action( 'admin_menu', array(&$this, 'add_options_page_callback') );
		
		// register the checkbox
		add_action('admin_init', array($this, 'register_settings'));
	}
		
	/**
	 * Adds an options page checkbox to be activated so the plugin could work
	 */
	public function add_options_page_callback() {
		add_options_page('DX Template Options', 'DX Template Options', 'manage_options', 'dx-template-options', array($this, 'dx_template_options_page') );
	}
	
	/**
	 * And the content page itself for setting up the DX Template
	 */
	public function dx_template_options_page() {
		include 'dx-template-admin-view.php';
	}	
	
	/**
	 * Setup the settings
	 */
	public function register_settings() {
		register_setting('dxdt_setting', 'dxdt_setting');
	
		add_settings_section(
			'dxdt_settings_section',         // ID used to identify this section and with which to register options
			__('Enable DX Templates', 'dxdt'),                  // Title to be displayed on the administration page
			array($this, 'dxdt_settings_callback'), // Callback used to render the description of the section
			'dx-template-options'                           // Page on which to add this section of options
		);
	
		add_settings_field(
			'dxdt_opt_in',                      // ID used to identify the field throughout the theme
			__('Active: ', 'dxdt'),                           // The label to the left of the option interface element
			array($this, 'dxdt_opt_in_callback'),   // The name of the function responsible for rendering the option interface
			'dx-template-options',                          // The page on which this option will be displayed
			'dxdt_settings_section'         // The name of the section to which this field belongs
		);
	}
	
	public function dxdt_settings_callback() {
		echo 'Enable me';
	}
	
	public function dxdt_opt_in_callback() {
		$enabled = false;
		$out = ''; 
		
		// check if checkbox is checked
		if(! empty( $this->dxdt_setting ) && isset ( $this->dxdt_setting['dxdt_opt_in'] ) ) {
			$val = true;
		}
		
		if($val) {
			$out = '<input type="checkbox" id="dxdt_opt_in" name="dxdt_setting[dxdt_opt_in]" CHECKED  />';
		} else {
			$out = '<input type="checkbox" id="dxdt_opt_in" name="dxdt_setting[dxdt_opt_in]" />';
		}
		
		echo $out;
	}
	
	/**
	 * verify is the plugin enabled from Settings
	 * @return boolean is enabled
	 */
	public function is_enabled() {
		if(! empty( $this->dxdt_setting ) && isset ( $this->dxdt_setting['dxdt_opt_in'] ) ) {
			return true;
		}
		return false;
	}
}