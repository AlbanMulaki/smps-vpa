


jQuery(document).ready( function() {
    
    var sola_is_editing = false;
    
    var window_height = jQuery(window).height();
    jQuery("#editor_options").css("height", window_height-151);
    
    jQuery( window ).resize(function(){
        window_height = jQuery(window).height();
        jQuery("#editor_options").css("height", window_height-151);
    });
    
    //switch between Styels and Content
    jQuery(".editor_options_header").click(function(){
        if(jQuery(this).hasClass("active") === false ){
               jQuery("#editor_options").children().hide();
               jQuery("#"+jQuery(this).attr("did")).toggle();
               jQuery(".editor_options_header").removeClass("active");
               jQuery(this).addClass("active");
        }
     });
     //show extra content when block clicked
     jQuery(".sola_show_editior_div").click(function(e){ 
       if(jQuery(this).hasClass("open") === false){
            jQuery(".sola_show_editior_div").removeClass("open expandable-div");
            jQuery(".sola-extra-content").hide();
            jQuery(this).addClass("open");
            jQuery(this).addClass("expandable-div");
            jQuery(this).children(".sola-extra-content").show();
        } else {
            if(!jQuery(e.target).parents('.sola-extra-content').length > 0){
                jQuery(".sola_show_editior_div").removeClass("open expandable-div");
                jQuery(".sola-extra-content").hide();
            }
        }
     });
     //Show elements option
     var style_open = false;
     jQuery(".style").click(function(e){
         if(style_open === false && jQuery(this).hasClass("style-open") === false){
             jQuery(this).children(".style-options").show();
             jQuery(this).addClass("style-open");
             style_open = true;
         } else if(style_open === true && jQuery(this).hasClass("style-open") === false) {
             jQuery(".style-options").hide();
             jQuery(".style").removeClass("style-open");
             jQuery(this).children(".style-options").show();
             jQuery(this).addClass("style-open");
             style_open = true;
         } else if(style_open === true && jQuery(this).hasClass("style-open") === true){
                
             if(jQuery(e.target).parents(".style-name").length > 0){
                jQuery(".style-options").hide();
                jQuery(this).removeClass("style-open");
                style_open = false;
             }
         } else {
             if(!jQuery(e.target).parents('.style-options').length > 0){
                jQuery(".style-options").hide();
                jQuery(this).removeClass("style-open");
                style_open = false;
            }
         }
     });
     jQuery('#editor-content').mouseup(function (e){
        var container = jQuery(".sola_show_editior_div");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0){ // ... nor a descendant of the container
                jQuery(".sola_show_editior_div").removeClass("open expandable-div");
                jQuery(".sola-extra-content").hide();
        }
    });
    jQuery('#sola_newsletter_preview').on('click','a', function(ui) { 
        if (jQuery(this).attr('class') === 'canclick') { } else {
            return false; 
        }
    });
     
     

    sola_nl_make_sortable();
    
    
    
    jQuery(".editable").hover(function(){ 
        if (sola_is_editing === true) { return; }
        jQuery(this).addClass("editHover"); },
        function(){ jQuery(this).removeClass("editHover"); }
    );
    //jQuery(".editable").bind("dblclick", replaceHTML); 
    
        
    jQuery("body").on("dblclick", ".editable", replaceHTML);  
    
    
    //esc pressed, exits tiny mce without saving. Also in setup of tine mce
    jQuery(document).keydown(function(e) {
        if (e.keyCode === 27 && sola_is_editing === true) { 
            sola_discard_changes();
        }   // esc
      });
    //off click of tiny mce, contents are saved
    jQuery(document).mouseup(function (e){
        var container = jQuery(".editable");
//        console.log(e.target);
        
        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0){ // ... nor a descendant of the container
            if(sola_is_editing === true && 
                    (
                    jQuery(e.target).hasClass("mce-text") === false &&
                    jQuery(e.target).hasClass("mce-container") === false &&
                    jQuery(e.target).hasClass("mce-container-body") === false &&
                    jQuery(e.target).hasClass("mce-menu-item") === false &&
                    typeof jQuery(e.target).attr("data-mce-color") === typeof undefined &&
                    jQuery(e.target).hasClass("mce-window") === false &&
                    jQuery(".mce-window").has(e.target).length === 0
                    )){
                
                newText = jQuery(".editBox").val().replace(/"/g, '"'); 
                var content = tinyMCE.get(mid).getContent();
                jQuery("#"+did).html(content).removeClass("noPad").bind("dblclick", replaceHTML);
                //jQuery("#"+did).parent().addClass('sortable-item');
                jQuery("#"+did).parent().removeClass('notdrag');
                jQuery('#sola_toolbar').remove();
                sola_is_editing = false;
                sola_save_letter();
            }
        }
    });

        
    function replaceHTML() {
        
        
        if (sola_is_editing === true) { 
            newText = jQuery(".editBox").val().replace(/"/g, '"'); 
            var content = tinyMCE.get(mid).getContent();
            jQuery("#"+did).html(content).removeClass("noPad").bind("dblclick", replaceHTML);
            jQuery("#"+did).parent().addClass('sortable-item');
            jQuery("#"+did).parent().removeClass('notdrag');
            jQuery('#sola_toolbar').remove();
            sola_is_editing = false;
            
            //alert('Please save changes first');
            sola_save_letter();
            
            //jQuery( "#sola_nl_save_box" ).effect( 'shake' );
            //return;
        } 
        
        //jQuery("#sola_nl_save_text").html('<strong style="color:red;">Changes Not Saved</strong>');
        sola_is_editing = true;
        sola_is_editing_id = jQuery(this).attr("id");
        jQuery('#sola_toolbar').remove();

        oldText = jQuery(this).html().replace(/"/g, '"');  
        //alert(oldText);
        thisid = jQuery(this).attr("id");
        did = thisid;
        jQuery(this).parent().removeClass('sortable-item');
        jQuery(this).parent().addClass('notdrag');

        //jQuery("#sola_nl_save_temp_btn").attr('mid',"check_"+thisid);
        //jQuery("#sola_nl_save_temp_btn").attr('did', thisid);

        jQuery(this).addClass("noPad")

                .html("")
            //save button and discard - changed functionality completly
            //<div id='sola_nl_save_box' style='display:block; height:40px; background-color:#fff; '><a href=\"#\" class=\"btnSave sola_nl_save_temp_btn button-primary \" mid=\"check_"+thisid+"\" did=\""+thisid+"\">Save changes</a><a href=\"#\" did=\""+thisid+"\" class=\"btnDiscard button-primary\">Discard changes</a></div>
                .html("<form><textarea class=\"editBox\" id=\"check_"+thisid+"\">" + oldText + "</textarea></form>")
                .unbind('dblclick', replaceHTML); 


        thisnewid = 'check_'+thisid; 
        mid = thisnewid;

        tinyMCE.init({
            mode : "exact",
            height: "300px",
            resize: false,
            elements : 'check_'+thisid,
            setup : function(ed) {
              ed.on("keyup", function(e) {
                  if (e.keyCode === 27 && sola_is_editing === true) { 
                    sola_discard_changes();
                }   
              });
          },
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste",
                "textcolor"
            ],
            menubar: false,
            relative_urls: false,
            remove_script_host: false,
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | fontsizeselect | bullist numlist outdent indent | link image | forecolor backcolor",

        });
        
    }
    
    
//    jQuery("body").on("click", ".btnSave", function(){ 
//        newText = jQuery(".editBox").val().replace(/"/g, '"'); 
//        var content = tinyMCE.get(mid).getContent();
//        jQuery("#"+did).html(content).removeClass("noPad").bind("dblclick", replaceHTML);
//        jQuery("#"+did).parent().addClass('sortable-item');
//        jQuery("#"+did).parent().removeClass('notdrag');
//        jQuery('#sola_toolbar').remove();
//        sola_is_editing = false; 
        
//        newText = jQuery(this).parent().siblings("form").children(".editBox").val().replace(/"/g, '"');  
//        mid = jQuery(this).attr("mid");
//        did = jQuery(this).attr("did"); // used to add the sortable-item class back
//        var content = tinyMCE.get(mid).getContent();
//        
//        jQuery(this).parent().parent().html(content).removeClass("noPad").bind("dblclick", replaceHTML); 
//        jQuery("#"+did).parent().addClass('sortable-item');
//        jQuery("#"+did).parent().removeClass('notdrag');
//        jQuery('#sola_toolbar').remove();
//        sola_is_editing = false;
//    });   
//    
//    
//    jQuery("body").on("click", ".btnDiscard", function(){  
//        jQuery(this).parent().parent().html(oldText).removeClass("noPad").bind("dblclick", replaceHTML);  
//        did = jQuery(this).attr("did"); // used to add the sortable-item class back
//        jQuery("#"+did).parent().addClass('sortable-item');
//        jQuery("#"+did).parent().removeClass('notdrag');
//        jQuery('#sola_toolbar').remove();
//        sola_is_editing = false;
//    });   
    
    
    
    jQuery('.sola_addable_item').draggable({
        helper: function(e) {
            jQuery("#sola_nl_save_text").empty();
            jQuery(".header-right").css("background", "url('../wp-content/plugins/sola-newsletters/images/editor-header.jpg') center no-repeat");
            return jQuery('<div>').addClass('editable').text('Drag to the newsletter');
        },
        connectToSortable: ".sortable-list",
        
    });
//
//    Moved this to function that imports image
//            
//    jQuery('.sola_addable_image').draggable({
//        helper: function(e) {
//            return jQuery('<div>').addClass('editable').text('Drag to the newsletter');
//        },
//        connectToSortable: ".sortable-list"
//    });
    jQuery('.sola_addable_hr').draggable({
                helper: function(e) {
                    //console.log(jQuery(this).attr("truesrc"));
                    return jQuery('<div>').addClass('editable').append("<img src='"+jQuery(this).attr("thumbnail")+"' width='300px'/>");
                },
                connectToSortable: ".sortable-list"
            });
    
    jQuery("body").on({
        mouseenter: function () {
            if (sola_is_editing === true) { return; }
            jQuery(this).prepend("<div id='sola_toolbar'><i class='sola_tool_icon fa fa-trash-o' id='sola_tool_delete'></i></div>"); 
        },
        mouseleave: function () {
            if (sola_is_editing === true) { return; }
             jQuery('#sola_toolbar').remove();
        }
    }, ".sortable-item"); //pass the element as an argument to .on
    
/*  
    jQuery("body").on("mouseenter", ".sortable-item", function(){      
        if (document.getElementById('sola_toolbar') === null) {
            jQuery(this).append("<div id='sola_toolbar'><span id='sola_tool_delete'>X</span></div>"); 
        }
    });
    jQuery("body").on("mouseleave", ".sortable-item", function(){      
        if (document.getElementById('sola_toolbar') !== null) {
         jQuery('#sola_toolbar').remove();
        }
    });
*/    
    
    jQuery("body").on("click", "#sola_tool_delete", function(){      
      jQuery(this).parent().parent().remove();
      sola_save_letter();
    });

    
//    jQuery("body").on("click", ".sola_nl_save_temp_btn", function(){      
//        jQuery(this).prop( "disabled", true );
//        sola_add_style_to_letter();
//        var sola_nl_html = jQuery("#sola_newsletter_wrapper").html();
//        jQuery("#sola_nl_save_text").html('Saving...');
//        var styles = [];
//        jQuery(".colorpicker").each(function(){
//            styles.push({
//                id:jQuery(this).attr("id"),
//                color:jQuery(this).attr("color"),
//                css:jQuery(this).attr("css")
//            });
//        });
//        jQuery(".font-select").each(function(){
//            styles.push({
//                id:jQuery(this).attr("id"),
//                font_family:jQuery(this).val()
//            });
//        });
//        jQuery(".font-size").each(function(){
//            styles.push({
//                id:jQuery(this).attr("id"),
//                font_size:jQuery(this).val()
//            });
//        });
//        //console.log(styles);
//        var data = {
//            action: 'save_template',
//            security: sola_nl_nonce,
//            sola_html: sola_nl_html,
//            camp_id: jQuery("#sola_newsletter_wrapper").attr("camp_id"),
//            styles:styles
//        };
//        jQuery.post(ajaxurl, data, function(response) {
//            var temp_html = response.replace(/\\(.)/mg, "$1");
//            jQuery("#sola_newsletter_wrapper").html(temp_html);
//            sola_nl_make_sortable();
//            var now = new Date();
//            now.toString();
//            jQuery("#sola_nl_save_text").html('Last saved at '+now);
//            jQuery("#sola_nl_save_temp_btn").prop( "disabled", false );
//            
//        });
//
//    });
//    
    // Jarryd    
    // Next button  - saves then redirect to preview
    jQuery("body").on("click", ".sola_nl_preview_btn", function(){ 
        jQuery(this).prop( "disabled", true );
        var url = "admin.php?page=sola-nl-menu&action=preview&camp_id="+camp_id;
        sola_save_letter(url);
//      window.location.href = url;
        
    });

    // Next button  - saves then redirect
    jQuery("body").on("click", ".sola_nl_next_btn", function(){         
        var url = "admin.php?page=sola-nl-menu&action=confirm_camp&camp_id="+camp_id;
        window.location.href = url;
        
//        var sola_nl_html = jQuery("#sola_newsletter_wrapper").html();
//        var camp_id = jQuery("#sola_newsletter_wrapper").attr("camp_id");
//        jQuery("#sola_nl_save_text").html('Saving...');
//        
//        var data = {
//            action: 'save_template',
//            security: sola_nl_nonce,
//            sola_html: sola_nl_html,
//            camp_id: camp_id
//        };
//        
//        //alert(camp_id);
//        //save the newsletter
//        jQuery.post(ajaxurl, data, function(response) {
//            
//            var temp_html = response.replace(/\\(.)/mg, "$1");
//            jQuery("#sola_newsletter_wrapper").html(temp_html);
//            sola_nl_make_sortable();
//            var now = new Date();
//            now.toString();
//            jQuery("#sola_nl_save_text").html('Last saved at '+now);
//            jQuery(".sola_nl_next_btn").prop( "disabled", false );
//            var url = "admin.php?page=sola-nl-menu&action=confirm_camp&camp_id="+camp_id;
//            window.location.href = url;
//        });

    });
    // SEND TEST MAIL
    jQuery("body").on("click", ".sola_send_test_mail", function(){      
        jQuery(this).prop( "disabled", true );
        var sola_nl_body = jQuery("#sola_newsletter_wrapper").html();
        var sola_nl_to = jQuery("#sola_nl_to_mail_test").val();
        var camp_id = jQuery("#sola_newsletter_wrapper").attr("camp_id");
        var data = {
            action: 'test_mail',
            body: sola_nl_body,
            to: sola_nl_to,
            security: sola_nl_nonce,
            camp_id: camp_id
        };
        
        //alert(data);
        jQuery.post(ajaxurl, data, function(response) {
            
            alert(response);
            
            jQuery(".sola_send_test_mail").prop( "disabled", false );
            
        });
    });
    
    jQuery("#sola_nl_editor_tabs").tabs();
    
    
    
    
    
    
 
    

    
    //Custom uploader to add images
    var custom_uploader;
    jQuery('#upload_image_button').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Upload New Image',
            button: {
                text: 'Choose Image',
                class: 'test'
            },
            multiple: true
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            var selection = custom_uploader.state().get('selection');
            
 
            selection.map( function( attachment ) {

              attachment = attachment.toJSON();
              //console.log(attachment);
              //alert(attachment.sizes.thumbnail.url);
              // Do something with attachment.id and/or attachment.url here
              
              
              if(attachment.sizes.thumbnail){
                var thumbnail = attachment.sizes.thumbnail.url;
            } else {
                thumbnail = attachment.url;
            }
              jQuery('#images').append('<div type="image" truesrc="'+attachment.url+'" thumbnail="'+thumbnail+'" class="sola_addable_image" style="float:left; padding:3px; margin:3px;"><img src="'+thumbnail+'" /></div>');
              
            });
            jQuery('.sola_addable_image').draggable({
                helper: function(e) {
                    //console.log(jQuery(this).attr("truesrc"));
                    return jQuery('<div>').addClass('editable').append("<img src='"+jQuery(this).attr("thumbnail")+"' />");
                },
                connectToSortable: ".sortable-list"
            });
            
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
    jQuery('.colorpicker').colpick({
	layout:'hex',
	submit:0,
	colorScheme:'dark',
        
        
	onChange:function(hsb,hex,rgb,el,bySetColor) {
		jQuery(el).css('backgroundColor','#'+hex);
                jQuery(el).attr("value", '#'+hex);
                
                jQuery(jQuery(el).attr("element")).css(jQuery(el).attr("css"),'#'+hex);
                
		// Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
		if(!bySetColor) jQuery(el).val(hex);
                // Was saving letter on color change but this was too intense as too many calls are made
                //sola_save_letter();
	},
        onHide:function(){
            sola_save_letter();
        }
    }).keyup(function(){
	jQuery(this).colpickSetColor(this.value);
    }).click(function (){
        jQuery(this).colpickSetColor(jQuery(this).attr("color"));
    });
    
    
    
    
    //add default colors on load
    sola_add_style_to_letter();
    
    
    
    jQuery(".style-editor-input").change(function(){
        jQuery(jQuery(this).attr("element")).css(jQuery(this).attr("css"),jQuery(this).attr("value"));
        sola_save_letter();
    });
    
    // new function to save letter
    
    function sola_discard_changes(){
        jQuery("#"+did).html(oldText).removeClass("noPad").bind("dblclick", replaceHTML);  
        //jQuery("#"+did).parent().addClass('sortable-item');
        jQuery("#"+did).parent().removeClass('notdrag');
        jQuery('#sola_toolbar').remove();
        sola_is_editing = false;
    }
    
    
    /* ----------- Btn Options -------------*/
    
    jQuery("#sola_nl_btn_text").keyup(function(){
        jQuery("#sola_nl_btn").text(jQuery(this).val());
    });
    jQuery("#sola_nl_btn_link").keyup(function(){
        jQuery("#sola_nl_btn").attr("href",jQuery(this).val());
    });
    
  });
  
  
  
  function sola_nl_make_sortable() {    
       
        jQuery('#sola_newsletter_wrapper .sortable-list').sortable({
            connectWith: '#sola_newsletter_wrapper .sortable-list',
            cancel: ".notdrag",
            placeholder: 'placeholder',
            
            update: function (event, ui) {
                
                var td_data = "";
                var solaid = new Date().getTime();
                var table = jQuery('<table border="0" cellpadding="0" cellspacing="0" class="sola_table sortable-item" width="100%"></table>');
                var tr = jQuery("<tr></tr>");
                var td = jQuery('<td class="editable" id="'+solaid+'"></td>');
                //this adds new items to the editor
                if(ui.item.attr('type')){
                    if(ui.item.attr('type') === "text"){
                        td_data = jQuery("<p>Double Click to edit</p>");
                    } else if (ui.item.attr('type') === 'image'){
                        orig_html = ui.item.attr('truesrc');
                        td_data = jQuery("<img class='nl_img' src='"+orig_html+"' style=\'width:100%;\'/>");
                    } else if (ui.item.attr('type') === 'image_divider'){
                        orig_html = ui.item.attr('truesrc');
                        td_data = jQuery("<img src='"+orig_html+"' style=\'width:100%;\'/>");
                    } else if (ui.item.attr('type') === 'divider'){
                        orig_html = ui.item.attr('truesrc');
                        td_data = jQuery("<p style='display:block; height:15px;'>&nbsp;</p>");
                    } else if (ui.item.attr('type') === "automatic_content"){
                        
                        var feat_image = "[sola_nl_automatic_featured_image]";
                        var title = "[sola_nl_automatic_title]";
                        var post_url = "[sola_nl_automatic_url]";
                        var post_content = "[sola_nl_automatic_content]";
                        
                        jQuery("#editor-content").hide();
                        jQuery("#editor-styles").hide();
                        jQuery("#content-options").removeClass('active');
                        jQuery("#style-options").removeClass('active');
                        jQuery("#automatic-options").addClass('active');
                        jQuery("#editor-automatic").show();
                        
                        
                        td_data = jQuery("<table id='sola_nl_automatic_container' style='width:96%; border:1px solid #CCC; margin-left:auto; margin-right:auto; margin-top: 5px; margin-bottom: 5px; -webkit-box-shadow: 2px 2px 11px 0px rgba(50, 50, 50, 0.7); -moz-box-shadow: 2px 2px 11px 0px rgba(50, 50, 50, 0.7); box-shadow: 2px 2px 11px 0px rgba(50, 50, 50, 0.7);' height='125' align='center' valign='middle'><tr><td align='center' valign='middle'><i class=\"fa fa-5x fa-file-text-o\"></i><br />AUTOMATIC CONTENT</td></tr></table>");
                    }  else if (ui.item.attr('type') === "blog_post"){
                        var post = ui.item.attr('value');
                        var feat_image = ui.item.attr('feat_image');
                        var title = ui.item.attr("title");
                        var post_url = ui.item.attr("post_url");
                        td_data = jQuery("<img src='"+feat_image+"' height='150px' style='margin:0 10px 0 0; float:left;'/><h3>"+title+"</h3><p>"+post+" <a title='Read More' href='"+post_url+"'>Read More</a></p>");
                    } else if(ui.item.attr('type') === "social_icons"){
                        td_data = ui.item.html();
                        td.addClass("social-icons-div");
                    } else if(ui.item.attr('type') === "btn"){
                        
                        td = jQuery('<td class="" id="'+solaid+'"></td>');
                        td_data = ui.item.html();
                    } 
                    //add data to td element
                    td.append(td_data);
                    tr.append(td);
                    table.append(tr);
                    ui.item.replaceWith(table);
//                     console.log('dropped');
                   
                    //td.bind("dblclick", replaceHTML);
                    
                } else {
                    // this is to move an exsiting item in the editor
                    jQuery('#sola_toolbar').remove();
                }

                // add td to table
                   
                sola_save_letter();
            }
        });
    }
  
  function sola_add_style_to_letter(){
        jQuery(".style-editor-input").each(function(){
            
            jQuery(jQuery(this).attr("element")).css(jQuery(this).attr("css"),jQuery(this).attr("value"));
        });
    }
  
  function sola_save_letter(redirect){
        
        
        
        jQuery(".header-right").css("background", "");
        //jQuery(this).prop( "disabled", true );
        sola_add_style_to_letter();
        var sola_nl_html = jQuery("#sola_newsletter_preview").html();
        jQuery("#sola_nl_save_text").html('Saving...');
        var styles = [];
        var auto_options = [];
        //jQuery('#auto_options_form :input').serialize();
        
        
        jQuery("#auto_options_form input").each(function() {
            if (jQuery(this).attr("name") === "automatic_layout") {
                if (jQuery(this).is(':checked')) {
                    var attributes = {};
                    attributes[jQuery(this).attr("name")] = jQuery(this).attr("value");
                    auto_options.push(attributes);
                }
            } else if (jQuery(this).attr("name") === "automatic_options_checkboxes[]") {
                if (jQuery(this).is(':checked')) {
                    var attributes = {};
                    attributes[jQuery(this).attr("value")] = 1;
                    auto_options.push(attributes);
                } else {
                    var attributes = {};
                    attributes[jQuery(this).attr("value")] = 0;
                    auto_options.push(attributes);
                }
            } else {
                var attributes = {};
                attributes[jQuery(this).attr("name")] = jQuery(this).attr("value")
                auto_options.push(attributes);
            }
            
        });
        jQuery(".style-editor-input").each(function() {
            
            var attributes = {};
            jQuery.each(this.attributes, function() {
              // this.attributes is not a plain object, but an array
              // of attribute nodes, which contain both the name and value
              
              if(this) {
                attributes[this.name] = this.value;
              }
            });
            
            attributes["the_value"] = jQuery(this).attr("value");
            attributes["array_name"] = jQuery(this).closest('.style_element_wrapper').attr('array_name');
            styles.push(attributes);
        });
        
        var data = {
            action: 'save_template',
            security: sola_nl_nonce,
            styles: styles,
            camp_id: camp_id,
            sola_html: sola_nl_html,
            auto_options: auto_options
        };
       
        
        jQuery.ajax({
            data: data,
            url: ajaxurl,
            method: 'POST',
            success: function(response) {
                var temp_html = response.replace(/\\(.)/mg, "$1");
                //jQuery("#sola_newsletter_wrapper").html(temp_html);
                sola_nl_make_sortable();
                var now = new Date();
                now.toString();
                jQuery("#sola_nl_save_text").html('Last saved at '+now);
                //jQuery("#sola_nl_save_temp_btn").prop( "disabled", false );
                //console.log(response);
                if(redirect){
                    var the_data = data.auto_options; 
//                    console.log(the_data);
                    window.location.href = redirect;
                }
                return true;
            }
            
            
        });
        
        
        
    }