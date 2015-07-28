<?php
/*
 Plugin Name: DX Template Manager
Plugin URI: http://devrix.com/template-manager
Description: Define specific unique templates for your pages from within the admin panel
Author: nofearinc
Author URI: http://devwp.eu
Version: 1.1
*/

include 'dx-template-protector.class.php';

class DX_Template_Manager {
	public function DX_Template_Manager() {
		// register custom post type for DX template
		add_action('init', array( &$this, 'post_type_callback' ) );
		
		// create a metabox with a dropdown for a template
		// load a template with the ID if found
		add_filter('template_include', array($this, 'apply_remote_template') );
		
		// add meta box for listing templates
		add_action( 'add_meta_boxes', array($this, 'meta_boxes_callback') );
		
		add_action( 'save_post', array($this, 'update_dynamic_template') );
		
	}
	
	/**
	 * Registers the dxtemplate custom post type
	 */
	public function post_type_callback() {
		register_post_type('dxtemplate', array(
			'labels' => array(
			'name' => __('DX Templates', 'dxdt'),
			'singular_name' => __('DX Template', 'dxdt'),
			'add_new' => _x('Add New', 'pluginbase', 'dxdt' ),
			'add_new_item' => __('Add New DX Template', 'dxdt' ),
			'edit_item' => __('Edit DX Template', 'dxdt' ),
			'new_item' => __('New DX Template', 'dxdt' ),
			'view_item' => __('View DX Template', 'dxdt' ),
			'search_items' => __('Search DX Templates', 'dxdt' ),
			'not_found' =>  __('No DX Templates found', 'dxdt' ),
			'not_found_in_trash' => __('No DX Templates found in Trash', 'dxdt' ),
		),
		'description' => __('DX Templates for the demo', 'dxdt'),
		'public' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'exclude_from_search' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 40, 
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields',
			'page-attributes',
		),
		'taxonomies' => array('post_tag')
		));
	}
	
	/**
	 * Assigns the template to the post entity
	 * @param template $template the default template provided by WordPress
	 * @return the default template if no 'dxtemplate' is set or a custom content added as a DX Template entry
	 */
	public function apply_remote_template($template) {
		global $post;

		$post_id = $post->ID;
		
		// check if a dxtemplate is been set
		$meta_template_id = get_post_meta($post_id, 'dxtemplate', true);
		
		// get default template if not set
		if(empty($meta_template_id)) {
			return $template;
		}

		// otherwise, proceed with reading the content from a DX template
		global $wpdb;
		
		$content = $wpdb->get_var($wpdb->prepare( "SELECT post_content FROM $wpdb->posts WHERE id=%d", $meta_template_id ));

		if(is_null($content)) {
			return $template;
		}
		
		// replace PHP tags
		$content = str_replace("<!--?php", "<?php", $content);
		$content = str_replace("?-->", "?>", $content);
		
		$content = $this->prepare_content($content);
		
		echo $content;		
	}
	
	/**
	 * Registering the meta box for templates
	 */
	public function meta_boxes_callback() {
		add_meta_box(
			'dx_template_lister',
			__( 'DX Templates', 'dxdt' ),
			array(&$this, 'dx_template_listing_meta_box'),
			'',
			'side',
			'high'
		);
	}
	
	/**
	 * Adding the listing meta_box
	 * @param post $post the $post global variable
	 * @param $meta_box $metabox some options for the meta_box itself
	 */
	public function dx_template_listing_meta_box($post, $metabox) {
		global $wpdb;
		
		// check if template has been set already
		$post_id = $post->ID;
		$dxtemplate = get_post_meta($post_id, 'dxtemplate', true);

		// get a list with all templates
		$dx_templates_list = $wpdb->get_results("SELECT id, post_title FROM $wpdb->posts WHERE post_type = 'dxtemplate' ");

		echo '<p>Choose a dynamic template:</p>';
		echo '<select name="dxtemplate">';
		echo '<option value="0">None</option>';
		
		// display all templates and highlight the selected
		foreach($dx_templates_list as $template) {
			if($template->id === $dxtemplate) {
				echo '<option value="' . $template->id . '" SELECTED>' . $template->post_title . '</option>';
			} else {
				echo '<option value="' . $template->id . '">' . $template->post_title . '</option>';
			}
		}
		
		echo '</select>';
	}
	
	/**
	 * Update dynamic template when a post is saved
	 */
	public function update_dynamic_template($post_id) {
		if( isset($_POST['dxtemplate']) && ! empty( $_POST['dxtemplate'] ) ) {
			$dxtemplate_id = intval($_POST['dxtemplate']);
			
			update_post_meta($post_id, 'dxtemplate', $dxtemplate_id);
		} else {
			update_post_meta($post_id, 'dxtemplate', 0);
		}
	}
	
	/**
	 * Do the help work for stripping a template and evaluating what needs to be evaluated
	 * @param string $content the evaluated content
	 */
	public function prepare_content($content) {
		$commstart = strpos($content, "<?php");
		while($commstart !== false) {
			$commend = strpos($content, "?>");
			if( !$commend ) {
				$commend = strlen($content);
			}
			// substring with the PHP code
			$substr = substr($content, $commstart + 5, ($commend - $commstart) - 5);
				
			// get eval() content in a buffer
			$evaled = '';
			ob_start();
				
			// evaluate the super dangerous PHP code inside
			eval($substr);
			$evaled = ob_get_contents();
				
			ob_end_clean();
				
			// get the string positions to be replaced
			$replacable = substr($content, $commstart, ($commend + 2 - $commstart));
				
			// replace the content
			$content = str_replace($replacable, $evaled, $content);
		
			$commstart = strpos($content, "<?php");
		}
		
		return $content;
	}
}

$dx_template_protector = new DX_Template_Protector();

// if we're good - instantiate and run
if($dx_template_protector->is_enabled()) {
	$dx_template_manager = new DX_Template_Manager();
}

