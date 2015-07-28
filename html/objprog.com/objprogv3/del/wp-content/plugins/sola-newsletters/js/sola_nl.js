jQuery(document).ready(function() {
    
    jQuery("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
    
    var orig_smtp_host = jQuery("#sola_nl_host").val();
    var orig_smtp_port = jQuery("#sola_nl_port").val();
    
    
    sola_nl_show_div();
    jQuery('#radio_button_1').click(function (){
        sola_nl_show_div();
    });
    jQuery('#radio_button_2').click(function (){
        sola_nl_show_div();
    });
    jQuery('#radio_button_3').click(function (){
        sola_nl_show_div();
    });
    
    jQuery("body").on("change", "#sola_nl_hosting_provider", function(){      
        
        var sola_nl_host_select = jQuery('option:selected', this).attr('send_limit');
        var sola_nl_host_limiting = jQuery('option:selected', this).attr('mtype');
        
        jQuery("#sola_nl_send_limit_qty").val(sola_nl_host_select);
        jQuery("#sola_nl_send_limit_type").val(sola_nl_host_limiting);
        
    });

    jQuery(".schedule_send_block").hide();
    jQuery("#sola_nl_schedule_send_btn").click(function() {
        jQuery(".schedule_send_block").toggle();
    });
    
    
//    jQuery("#standard_newsletter").attr('checked', 'checked');
    jQuery("#custom-newsletter-block").hide();
    jQuery("#shortcodes-desc").hide();
    
    jQuery('#custom_newsletter').click(function() {
        if(jQuery('#custom_newsletter').is(':checked')) { 
            jQuery("#custom-newsletter-block").show();
            jQuery("#shortcodes-desc").show();
        }
    });
    jQuery('#standard_newsletter').click(function() {
        if(jQuery('#standard_newsletter').is(':checked')) { 
            jQuery("#custom-newsletter-block").hide();
            jQuery("#shortcodes-desc").hide();
            jQuery("#sola-nl-list-row").show();
        }
    });


    jQuery('#sola-nl-action').change(function () {
        var selectedId = jQuery('option:selected', this).attr('id');
        if (selectedId === 'new-post') {            
            jQuery('#sola-nl-role').hide();
            jQuery('#sola-nl-time-after').hide();
            jQuery('#sola-nl-custom-time').hide();
            jQuery('#sola-nl-role').hide();
            jQuery('#sola-nl-days').hide();
            jQuery('#sola-nl-time').hide();
            jQuery('#sola-nl-monthly-every').hide();
            jQuery('#sola-nl-list-row').show();
            jQuery('#sola-nl-time-slot').show();
        } 
        if (selectedId === 'new-sub') {
            
            jQuery('#sola-nl-role').hide();
            jQuery('#sola-nl-time-slot').hide();
            jQuery('#sola-nl-role').hide();
            jQuery('#sola-nl-days').hide();
            jQuery('#sola-nl-time').hide();
            jQuery('#sola-nl-monthly-every').hide();
            jQuery('#sola-nl-monthly-day').hide();
            jQuery('#sola-nl-list-row').hide();
            jQuery('#sola-nl-custom-time').hide();
            jQuery('#sola-nl-time-after').show();
        }
        if(selectedId === 'new-user') {
            
            jQuery('#sola-nl-custom-time').hide();
            jQuery('#sola-nl-time-slot').hide();
            jQuery('#sola-nl-role').hide();
            jQuery('#sola-nl-days').hide();
            jQuery('#sola-nl-time').hide();
            jQuery('#sola-nl-monthly-every').hide();
            jQuery('#sola-nl-list-row').hide();
            jQuery('#sola-nl-role').show();
            jQuery('#sola-nl-custom-time').hide();
            jQuery('#sola-nl-time-after').show();
        }
    });
    
    jQuery('#sola-nl-time-after').change(function () {
        var selectedId = jQuery('option:selected', this).attr('id');
        if (selectedId === 'sola-nl-after-immediate') {
            jQuery('#sola-nl-custom-time').hide();
        } 
        if(selectedId === 'sola-nl-after-weeks' || selectedId === 'sola-nl-after-days' || selectedId === 'sola-nl-after-hours' || selectedId === 'sola-nl-after-minutes')
            jQuery('#sola-nl-custom-time').show();
    });
    
    
    jQuery('#sola-nl-time-slot').change(function () {
        var selectedId = jQuery('option:selected', this).attr('id');
        if(selectedId === 'time-slot-immediately'){
            jQuery('#sola-nl-time').hide();
            jQuery('#sola-nl-days').hide();
            jQuery('#sola-nl-monthly-every').hide();
            jQuery('#sola-nl-monthly-day').hide();
        }
        if (selectedId === 'time-slot-daily') {
            jQuery('#sola-nl-time').show();
            jQuery('#sola-nl-days').hide();
        }
        if(selectedId === 'time-slot-weekly'){
            jQuery('#sola-nl-monthly-day').hide();
            jQuery('#sola-nl-monthly-every').hide();
            jQuery('#sola-nl-days').show();
            jQuery('#sola-nl-time').show();
        }
        if(selectedId === 'time-slot-monthly-on'){
            jQuery('#sola-nl-days').hide();
            jQuery('#sola-nl-monthly-every').hide();
            jQuery('#sola-nl-monthly-day').show();
            jQuery('#sola-nl-time').show();
        }
        if(selectedId === 'time-slot-monthly-every'){
            jQuery('#sola-nl-monthly-day').hide();
            jQuery('#sola-nl-days').show();
            jQuery('#sola-nl-time').show();
            jQuery('#sola-nl-monthly-every').show();
        }
    });

//    jQuery('#sola-nl-time-after').change(function () {
//        var selectedId = jQuery('option:selected', this).attr('id');
//        if (selectedId == '') {
//            jQuery('#sola-nl-time').hide();
//            jQuery('#sola-nl-days').hide();
//            jQuery('#sola-nl-time-slot').hide();
//            jQuery('#sola-nl-monthly-every').hide();
//            jQuery('#sola-nl-monthly-day').hide();
//        }
//    });

    
    //Send A Test Emial -test if mail is working
    jQuery("body").on("click", ".sola_send_test_mail", function(){      
        jQuery(this).prop( "disabled", true );
        var sola_nl_to = jQuery("#sola_nl_to_mail_test").val();
        
        var smtp_host = jQuery("#sola_nl_host").val();
        var smtp_port = jQuery("#sola_nl_port").val();
        var smtp_user = jQuery("#sola_nl_username").val();
        var smtp_pass = jQuery("#sola_nl_password").val();
        var smtp_encrypt = jQuery("input[name=encryption]:radio:checked").val();


        
        
        if (jQuery('#sola_nl_to_mail_test_debug').is(':checked')) { var smtp_debug = "on"; } else { var smtp_debug = false; }
        if (jQuery('#radio_button_1').is(':checked')) { var wpmail = 'wpmail'; } else { var wpmail = false; }
        
        var data = {
            action: 'test_mail_2',
            smtp_host: smtp_host,
            smtp_port: smtp_port,
            smtp_user: smtp_user,
            smtp_pass: smtp_pass,
            smtp_debug: smtp_debug,
            smtp_encrypt:smtp_encrypt,
            mail_type: wpmail,
            to: sola_nl_to,
            security: sola_nl_nonce
        };
        
        //alert(data);
        jQuery.post(ajaxurl, data, function(response) {
            alert(response);
            jQuery(".sola_send_test_mail").prop( "disabled", false );
            
        });
    });
    //send preview mail
    jQuery("body").on("click", ".sola_send_preview", function(){
        jQuery(this).prop("disabled", true);
        sola_save_letter();
        setTimeout(function() {
            var data = {
                action: "preview_mail",
                to: jQuery("#sola_nl_to_mail_test").val(),
                security:sola_nl_nonce,
                body:jQuery("#sola_newsletter_preview").html(),
                camp_id:camp_id,
                cache: false
            };
            jQuery.post(ajaxurl, data, function(response){
               alert(response);
               jQuery(".sola_send_preview").prop("disabled", false);
            });
          }, 2000);
        
    });
    
    
    jQuery( "#sendform" ).submit(function( event ) {
//        console.log(event);
        if(jQuery('.schedule_send_block').css('display') == 'table-row'){
            if(!confirm("Are you sure you want to schedule your campaign?")){
                event.preventDefault();
            }
        } else {
            if(!confirm("Are you sure you want to send your campaign?")){
                event.preventDefault();
            }
        }                 
      });
      jQuery( "#saveform" ).submit(function( event ) {
        if(!confirm("Are you sure you want to save your campaign?")){
            event.preventDefault();
        }         
      });
    
    
    function sola_nl_show_div(){
        if(jQuery('#radio_button_2').is(':checked')) { 
            jQuery("#sola_nl_smtp").show();
            jQuery("#sola_nl_host").val(orig_smtp_host).attr("readonly", false);
            jQuery("#sola_nl_port").attr("readonly", false);
            jQuery("#sola_nl_hosting_provider").val("2");
            
            //jQuery("#sola_nl_port").val(orig_smtp_port).attr("disabled", false);
        } 
        else if (jQuery('#radio_button_1').is(':checked')){
            jQuery("#sola_nl_smtp").hide();
            jQuery("#sola_nl_port").attr("readonly", false);
            jQuery("#sola_nl_hosting_provider").val("0");
        }
        else if (jQuery('#radio_button_3').is(':checked')){
            jQuery("#sola_nl_smtp").show();
            jQuery("#sola_nl_host").val("smtp.gmail.com").attr("readonly", "readonly");
            jQuery("#sola_nl_port").val("465").attr("readonly", "readonly");
            jQuery("#sola_nl_hosting_provider").val("1");
            jQuery("#enc_ssl").prop('checked', true);


        }
    };
    
    jQuery("#sola_check_all").click(function(){
        if(jQuery(this).attr('checked')){
            jQuery(".sola-check-box").prop('checked', true);
        } else {
            jQuery(".sola-check-box").prop('checked', false);
        }
    });
    jQuery(".sola-check-box").click(function(){
        if(!jQuery(this).attr('checked')){
            jQuery("#sola_check_all").prop('checked', false);
        }
    });
    
    //Jarryd
//    jQuery(".preview_container table").attr('id', 'sola_newsletter_wrapper');
    jQuery(".preview_button_button").click(function (){	
        
        var width = jQuery(this).attr('window_width');
        var add_class = jQuery(this).attr('add_class');

        jQuery('#sola_newsletter_preview').fadeOut(500, function(){
            jQuery("#preview_container").removeClass();                    
            jQuery("#preview_container").addClass(add_class);                        
            jQuery('#sola_newsletter_preview').css("width", width);
            jQuery("#sola_newsletter_preview").fadeIn();
        }); 
        
    });
    
//    jQuery("#preview_desktop").removeClass("active");
//    jQuery("#preview_desktop").click(function(){
//        jQuery("#preview_desktop").removeClass();
//        jQuery("#preview_mobile").removeClass();
//        jQuery("#preview_tablet").removeClass();
//        jQuery("#preview_tablet_landscape").removeClass();
//        jQuery("#preview_desktop").addClass("active");   
//    });
//    jQuery("#preview_mobile").click(function(){
//        jQuery("#preview_desktop").removeClass();
//        jQuery("#preview_mobile").removeClass();
//        jQuery("#preview_tablet").removeClass();
//        jQuery("#preview_tablet_landscape").removeClass();
//        jQuery("#preview_mobile").addClass("active");   
//    });
//    jQuery("#preview_tablet").click(function(){
//jQuery("#preview_desktop").removeClass();
//        jQuery("#preview_mobile").removeClass();
//        jQuery("#preview_tablet").removeClass();
//        jQuery("#preview_tablet_landscape").removeClass();
//        jQuery("#preview_tablet").addClass("active");   
//    });
//    jQuery("#preview_tablet_landscape").click(function(){
//        jQuery("#preview_desktop").removeClass();
//        jQuery("#preview_mobile").removeClass();
//        jQuery("#preview_tablet").removeClass();
//        jQuery("#preview_tablet_landscape").removeClass();
//        jQuery("#preview_tablet_landscape").addClass("active");   
//    });
    

    jQuery("#sola_newsletter_wrapper img").each(function(){
        
        var attribute_width = jQuery(this).attr('width'); 
        
        if(!attribute_width){
            attribute_width = jQuery(this).css('width');
        }
            if (attribute_width.indexOf("%", 0) === -1) {
                var stripped_width = attribute_width.replace("px", "");
                var attribute_width_new = parseInt(stripped_width);    
                var real_attr_width = ((attribute_width_new / 600) * 100);
                var real_real_attr_width = real_attr_width+"%";
                jQuery(this).attr('width',real_real_attr_width);            
            } 
        
    });

    jQuery("#layout-1").attr('checked', true);
    jQuery("#automatic-layout-1").click(function(){
        jQuery("#automatic-layout-2").removeClass('active');
        jQuery("#automatic-layout-3").removeClass('active');
        jQuery("#automatic-layout-4").removeClass('active');
        jQuery(this).addClass('active');
        jQuery("#layout-1").attr('checked', true);
        jQuery("#layout-2").attr('checked', false);
        jQuery("#layout-3").attr('checked', false);
        jQuery("#layout-4").attr('checked', false);
//        console.log(this);
    });
    jQuery("#automatic-layout-2").click(function(){
        jQuery("#automatic-layout-1").removeClass('active');
        jQuery("#automatic-layout-3").removeClass('active');
        jQuery("#automatic-layout-4").removeClass('active');
        jQuery(this).addClass('active');
        jQuery("#layout-2").attr('checked', true);
        jQuery("#layout-1").attr('checked', false);
        jQuery("#layout-3").attr('checked', false);
        jQuery("#layout-4").attr('checked', false);
//        console.log(this);
    });
    jQuery("#automatic-layout-3").click(function(){
        jQuery("#automatic-layout-2").removeClass('active');
        jQuery("#automatic-layout-1").removeClass('active');
        jQuery("#automatic-layout-4").removeClass('active');
        jQuery(this).addClass('active');
        jQuery("#layout-3").attr('checked', true);
        jQuery("#layout-2").attr('checked', false);
        jQuery("#layout-1").attr('checked', false);
        jQuery("#layout-4").attr('checked', false);
//        console.log(this);
    });
    jQuery("#automatic-layout-4").click(function(){
        jQuery("#automatic-layout-2").removeClass('active');
        jQuery("#automatic-layout-3").removeClass('active');
        jQuery("#automatic-layout-1").removeClass('active');
        jQuery(this).addClass('active');
        jQuery("#layout-4").attr('checked', true);
        jQuery("#layout-2").attr('checked', false);
        jQuery("#layout-3").attr('checked', false);
        jQuery("#layout-1").attr('checked', false);
//        console.log(this);
    });
    
    jQuery('#sola_n_html').ace({ theme: 'twilight', lang: 'html' });

    /* Custom HTML Template */
    jQuery("#html_container").hide();
    jQuery("#sola_nl_preview_custom_html").click(function(){
        jQuery("#html_container").empty();
        var encoded = jQuery("#sola_n_html").val();
        var html = jQuery.parseHTML(encoded);
        
        jQuery("#html_container").append(html);
    
        jQuery("#html_container").fadeIn(200);
       
    });

});

