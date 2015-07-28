<?php
// Creating the widget 
class sola_nl_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            // Base ID of your widget
            'sola_nl_subscribe_widget', 

            // Widget name will appear in UI
            __('Sola Newsletter Subscribe', 'sola'), 

            // Widget description
            array( 'description' => __( 'Add This widget to your site for vistors to sign-up to your newsletter', 'sola' ), ) 
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        sola_nl_sign_up_box();
        echo $args['after_widget'];
    }

    // Widget Backend 
    public function form( $instance ) {
  
        // Widget admin form
        ?>
        <p>Go to Sola Newsletter Settings - Sign Up settings to edit this box</p>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'sola_nl_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

//Add Custom JS to main WP pages for widget
function sola_nl_wp_js(){
    wp_enqueue_script( 'jquery' );
    wp_register_script('sola_nl_subs_widget', PLUGIN_DIR."/js/subscribe_widget.js", false);
    wp_enqueue_script( 'sola_nl_subs_widget' );
}


add_action('wp_head','sola_nl_user_ajaxurl');
function sola_nl_user_ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}

function sola_nl_widget_add_sub(){
    extract($_POST);
    $check = sola_nl_add_single_subscriber();
    if($check == true){
        $body = "<p>Hi There</p>
                <p>Thank you for signing up. Please click on the following link to activate your subscription.</p>
                <a href=''>Click Here</a>";
        $subject = get_option('sola_nl_confirm_subject');
        $body = get_option('sola_nl_confirm_mail');
        sola_mail(0, $sub_email, $subject, $body);
        
        ?>
        <div>
            <?php echo get_option("sola_nl_confirm_thank_you"); ?>
        </div>
        <?php
    } else {
        if ( is_wp_error($check) ) sola_return_error($check);
    }
}
function sola_nl_sign_up_box(){
    $sola_nl_ajax_nonce = wp_create_nonce("sola_nl");
    ?>
<div id="sola_nl_sign_up_box_<?php echo rand() ?>" class="sola_nl_sign_up_box">
    <div id="sola_nl_title">
        <h3><?php _e(get_option("sola_nl_sign_up_title"),"sola")?></h3>
    </div>
    <form  class="sola_nl_sub_form">
        <div class="sola_sign_up_form_row">
            <label>
                <?php _e("Name","sola") ?>:
            </label>
            <input type="text"  name="sub_name"/>
        </div>
        <div class="sola_sign_up_form_row">
            <label>
                <?php _e('E-mail', 'sola'); ?>
            </label>
            <input type="email"  name="sub_email"/>
        </div>
        <div style="display:none">
            <input name="action" value="sola_nl_sign_up_add_sub" type="hidden"/>
            <input name="security" value="<?php echo $sola_nl_ajax_nonce; ?>" type="hidden"/>
            
            <?php $lists = unserialize(get_option("sola_nl_sign_up_lists"));
               foreach($lists as $list){?>
               <input type="checkbox" name="sub_list[]" checked value="<?php echo $list ?>"/>
                  <?php
               }?>
        </div>
        <div>
            <input type="submit"   value="<?php _e(get_option("sola_nl_sign_up_btn"), "sola") ?>">
        </div>
        
    </form>
</div>
    <?php
}
add_shortcode('sola_nl_sign_up', 'sola_nl_sign_up_box');