<?php

//add_action( 'user_register', 'sola_nl_auto_new_user', 10, 1 );
//
//function sola_nl_auto_new_user( $user_id ) {
//    
//
//}


function sola_nl_build_automatic_content($camp_id,$mark_as_sent = false) {
    global $post;
    $camp = sola_nl_get_camp_details($camp_id);
    
//    var_dump($camp);
    
    
    $auto_options = maybe_unserialize($camp->automatic_data);
//    var_dump($auto_options);
//    ;
    $styles = maybe_unserialize($camp->styles);
    
//    var_dump($styles);
    
//    $ret_msg = " $camp_id";
    
//    foreach ($auto_options as $val) {
//        $ret_msg .= $key. " ".$val."<br />";
//    }
    
    if(isset($auto_options['automatic_layout'])){ $layout = $auto_options['automatic_layout']; } else { $layout = 'layout-1'; } 
    if(isset($auto_options['automatic_options_posts'])){ $num_posts = intval($auto_options['automatic_options_posts']); } else { $num_posts = 1;} 
    if(isset($auto_options['automatic_options_columns'])){ $posts_per_row = intval($auto_options['automatic_options_columns']); } else { $posts_per_row = 1;} 
    if(isset($auto_options['automatic_image'])){ $post_image = $auto_options['automatic_image']; } else { $post_image = 1; } 
    if(isset($auto_options['automatic_author'])){ $post_author = $auto_options['automatic_author']; } else { $post_author = 1; } 
    if(isset($auto_options['automatic_title'])){ $post_title = $auto_options['automatic_title']; } else { $post_title = 1; } 
    if(isset($auto_options['automatic_content'])){ $post_content = $auto_options['automatic_content']; } else { $post_content = 1; } 
    if(isset($auto_options['automatic_readmore'])){ $post_readmore = $auto_options['automatic_readmore']; } else { $post_readmore = 1; } 
    if (isset($auto_options['automatic_post_date'])) { $post_date = intval($auto_options['automatic_post_date']); } else { $post_date = 1; }
    if (isset($auto_options['automatic_post_length'])) { $post_length = intval($auto_options['automatic_post_length']); } else { $post_length = 255; }
    
    
    $automatic_scheduled_date = $auto_options['automatic_scheduled_date'];
//    var_dump($post_length);
//    exit();
    
    
//    $post_date = 1;
//    $post_length = 255;
    
//        var_dump("POSTS: ".$num_posts);
//        $num_posts = 3;
//        var_dump("POSTS: ".$num_posts);
//    $num_posts = 2;
    if($num_posts == 0){
        $num_posts = 1;
    }
    
/*
    $args = array(
        'posts_per_page' => $num_posts,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'post_type' => 'post',

        'meta_query' => array(
            array(
              'key' => 'sola_nl_auto_sent_'.$camp_id,
              'compare' => 'NOT EXISTS'
            )
          ),
        'date_query' => array( 
            array(
                'after' => $automatic_scheduled_date
            )
        ),       
        
        
    );
    
    
    $recent_posts = query_posts($args);
  */  
    
    
    $args = array(
        'posts_per_page' => $num_posts,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'post_type' => 'post'
    );
    
    //$recent_posts = wp_get_recent_posts( $args, ARRAY_A );
     //$recent_posts = wp_get_recent_posts( $args, ARRAY_A );
    $recent_posts = query_posts($args);
    
    if ($mark_as_sent) {
        $cnt = 0;
        foreach ($recent_posts as $post_data) {
            $key_value = get_post_meta( $post_data->ID, 'sola_nl_auto_sent_'.$camp_id );
            if (isset($key_value[0])) {
                unset($recent_posts[$cnt]);
            } else {
                /* leave in */
            }
            unset($key_value);
            $cnt++;
        }
    }
    
    
    
    
    
//    var_dump($recent_posts);
    
    
    $auto_content = "<table width='100%'>";
//    $posts_per_row = 4;
    
    $rows_required = ceil($num_posts / $posts_per_row);
    //echo "rows required".$rows_required;
    


    $td_perc = ((100/$posts_per_row));

    $current_post = 0;

    for ($x = 0;$x < $rows_required;$x++) {
       //var_dump($x);
       if ($x == 0) {
           // first row
       }

       if ($x == $rows_required) {
           // last row
       }

       $auto_content .=  "<tr>";
       for ($y=0;$y < $posts_per_row;$y++) {
           
           
           
           
           
           if ($current_post > $num_posts) {
               //echo "blank ";
               // give blank TD
               $auto_content .= "<td width='$td_perc%'></td>";
           } else {
               //echo "not blank ";
               if (isset($recent_posts[$current_post]->ID) && $recent_posts[$current_post]->ID > 0) {
                   //echo "something ";
                    $auto_content .= "<td valign='top' width='$td_perc%'>".sola_nl_build_specific_post($recent_posts[$current_post]->ID,$layout,$styles,$post_image,$post_title,$post_author,$post_content,$post_readmore, $post_date, $post_length)."</td>";
               }
               $current_post++;
           }
           //echo "<br />";
           
       }
       $auto_content .=  "</tr>";
       

       

    }
        
    
    foreach ($recent_posts as $ppost) {
        if ($ppost->ID > 0) { add_post_meta( $ppost->ID, 'sola_nl_auto_sent_'.$camp_id, '1', true ); }
    }
    $auto_content .= "</table>";

        
//        var_dump($recent_posts);
    return $auto_content;
}

function sola_nl_build_specific_post($post_id,$layout,$styles,$show_image = 1,$show_title = 1,$show_author = 1,$show_content = 1,$show_readmore = 1, $show_post_date = 1, $post_excerpt = 255) {
    $post_data = get_post($post_id);
    $post_meta = get_post_meta($post_id, 'sola_nl_post_included');
    $ret_msg = "";
    
//    var_dump($post_meta);
    if ($post_data) {     
        
//        if($post_meta[0] == 0){
//        var_dump($post_meta);
        
        //$show_image = 2;
            if($show_image == 1){
                if ( has_post_thumbnail($post_id)) {

                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id), 'full' );
                    $max_image_height = $image[2];

                    $auto_content_image_attr = array(
                        'src' => $image[0],
                        'style' => 'max-width:100%;',
                        'alt' => $post_data->post_title,
                        'title' => $post_data->post_title,
                        'border' => '0'
                    );

                    $auto_content_image_attr_esc = str_replace ('"', '',$auto_content_image_attr);

                    $auto_content_image = '<a href="' . $post_data->guid . '" target="_BLANK" title="' . $post_data->post_title . '" >';
                    $auto_content_image .= sola_nl_make_element('img',$styles,$auto_content_image_attr_esc);
                    $auto_content_image .= '</a>';

               } else {
                   $auto_content_image = '';
               }
            } else {
                $auto_content_image = '';
            }

            if($show_author == 1){
                $author_id = get_userdata(intval($post_data->post_author));
                $author_id = intval($author_id->data->ID);

                $author_name = get_the_author_meta('user_nicename', $author_id);
                $author_url = get_author_posts_url($author_id);

                $attributes = array(
                    'href' => $author_url
                );

                $the_author = sola_nl_make_element("a",$styles, $attributes).$author_name."</a>";
            } else {
                $the_author = '';            
            }

            if($show_title == 1){
                $title = $post_data->post_title;
            } else {
                $title = '';
            }

            if($post_excerpt > 255 || $post_excerpt == 0){
                $post_excerpt_length = 255;
            } else {
                $post_excerpt_length = $post_excerpt;
            }

            if($show_readmore == 1){
                $attributes = array(
                    'href' => $post_data->guid
                );
                $readmore = sola_nl_make_element("a",$styles, $attributes).__('Read More', 'sola')."</a>";
            } else {
                $readmore = '';
            }

            if($show_content == 1){
                $content = $post_data->post_content;
                $content = substr($content, 0, $post_excerpt_length);
                $content = $content." ".$readmore;
                $content = strip_tags($content, '<p><a><b><ul><li><ol><u><em><i><strong><br>');
            } else {
                $content = '';
                $readmore = '';
            }
//            $show_post_date = 1;
            if($show_post_date == 1){
                $post_date = $post_data->post_date;
            } else {
                $post_date = '';
            }

            //$ret_msg .= "Title: ".$title."<br />";
            $layout = 'layout-2';
            
             $attributes = array(
                    'href' => $post_data->guid
                );
             
            if($layout == 'layout-1') {
                $ret_msg .= "<table border='0' width='100%'>";
                $ret_msg .= "   <tr valign='middle'>";
                if($show_image == 1){
                    $ret_msg .= "       <td width='40%' style='padding:12px 6px;'>";
                    $ret_msg .= "           $auto_content_image";
                    $ret_msg .= "       </td>";
                }
                $ret_msg .= "           <td>";
                
                $ret_msg .=                 sola_nl_make_element("h3",$styles,$attributes,true).$title."</h3></a>";
                $ret_msg .=                 sola_nl_make_element("p",$styles).$content."</p>";
                if($show_post_date == 1 || $show_author == 1){
                    $ret_msg .=             sola_nl_make_element("p",$styles);            
                    if($show_post_date == 1){
                        $ret_msg .=             __('Written on: ', 'sola').$post_date.' ' ;
                    }
                    if($show_author == 1){
                        $ret_msg .=             __('By: ', 'sola').$the_author.' '; 
                    }
                    $ret_msg .=             "</p>";
                }
                $ret_msg .= "       </td>";
                $ret_msg .= "   </tr>";            
                $ret_msg .= "</table>";

            } else if($layout == 'layout-2') {         
                $ret_msg .= "<table border='0' width='100%'>";
                $ret_msg .= "   <tr>";
                $ret_msg .= "       <td valign='top'>";
                $ret_msg .= "           <div style='text-align: center;'>".sola_nl_make_element("h3",$styles,$attributes,true).$title."</h3></a></div><br />";
                if($show_image == 1){
                    $ret_msg .= "           <div style='text-align: center;'>".$auto_content_image."</div>";            
                }
                $ret_msg .= sola_nl_make_element("p",$styles).$content."</p>";
                if($show_post_date == 1 || $show_author == 1){
                    $ret_msg .= sola_nl_make_element("p",$styles);            
                    if($show_post_date == 1){
                        $ret_msg .=             __('Written on: ', 'sola').$post_date.' ' ;
                    }
                    if($show_author == 1){
                        $ret_msg .=             __('By: ', 'sola').$the_author.' '; 
                    }
                    $ret_msg .=             "</p>";
                }
                $ret_msg .= "       </td>";
                $ret_msg .= "   </tr>";
                $ret_msg .= "</table>";

            } else if($layout == 'layout-3') {
                $ret_msg .= "<table border='0' width='100%'>";
                $ret_msg .= "   <tr style='padding: 5px 0;'>";
                $ret_msg .= "       <td>";
                $ret_msg .=             sola_nl_make_element("h3",$styles,$attributes,true).$title."</h3></a>";
                $ret_msg .=             sola_nl_make_element("p",$styles).$content."</p>";
                if($show_post_date == 1 || $show_author == 1){
                    $ret_msg .=         sola_nl_make_element("p",$styles);            
                    if($show_post_date == 1){
                        $ret_msg .=             __('Written on: ', 'sola').$post_date.' ' ;
                    }
                    if($show_author == 1){
                        $ret_msg .=             __('By: ', 'sola').$the_author.' '; 
                    }
                    $ret_msg .=             "</p>";
                }
                $ret_msg .= "       </td>";
                if($show_image == 1){
                    $ret_msg .= "       <td valign='top' width='40%' style='padding:12px 6px;'>";
                    $ret_msg .=            $auto_content_image;
                    $ret_msg .= "       </td>";
                }
                $ret_msg .= "   </tr>";
                $ret_msg .= "</table>";
            } else if($layout == 'layout-4') {
                $ret_msg .= "<table border='0' width='100%'>";
                $ret_msg .= "   <tr style='padding: 5px 0; text-align: center;'>";
                $ret_msg .= "       <td colspan='2'>";
                $ret_msg .=             sola_nl_make_element("h3",$styles,$attributes,true).$title."</h3></a>";
                $ret_msg .= "       </td>";
                $ret_msg .= "   </tr>";            
                $ret_msg .= "   <tr style='padding: 5px 0;'>";
                if($show_image == 1){
                    $ret_msg .= "       <td valign='middle' width='40%' style='padding:12px 6px;'>";
                    $ret_msg .=            $auto_content_image;
                    $ret_msg .= "       </td>";
                }
                $ret_msg .= "       <td valign='middle'>";
                $ret_msg .= sola_nl_make_element("p",$styles).$content."</p>";
                if($show_post_date == 1 || $show_author == 1){
                    $ret_msg .= sola_nl_make_element("p",$styles);            
                    if($show_post_date == 1){
                        $ret_msg .=             __('Written on: ', 'sola').$post_date.' ' ;
                    }
                    if($show_author == 1){
                        $ret_msg .=             __('By: ', 'sola').$the_author.' '; 
                    }
                    $ret_msg .=             "</p>";
                }
                $ret_msg .= "       </td>";
                $ret_msg .= "   </tr>";
                $ret_msg .= "</table>";
            }
//        }
    } else {
        return $ret_msg;
    }
    return $ret_msg;
    
}
function sola_nl_make_element($element,$styles,$attributes = null,$link = false) {
    switch ($element) {
        
        case 'p':
            return '<p style="font-family:'.$styles['newsletter']['font-family'].'; font-size:'.$styles['newsletter']['font-size'].'; color:'.$styles['newsletter']['color'].';">';
            break;
        
        case 'img':
            return '<img src="'.$attributes['src'].'" style="'.$attributes['style'].'" alt="'.$attributes['alt'].'" title="'.$attributes['title'].'" border="'.$attributes['border'].'" />';
            break;
        
        case 'h1':
            return '<h1 style="font-family:'.$styles['heading_1']['font-family'].'; font-size:'.$styles['heading_1']['font-size'].'; color:'.$styles['heading_1']['color'].'; font-weight:'.$styles['heading_1']['font-weight'].'; ">';
            break;
        
        case 'h2':
            return '<h2 style="font-family:'.$styles['heading_2']['font-family'].'; font-size:'.$styles['heading_2']['font-size'].'; color:'.$styles['heading_2']['color'].'; font-weight:'.$styles['heading_2']['font-weight'].'; ">';
            break;
        
        case 'h3': 
            if ($link) {
                return '
                    <a href="'.$attributes['href'].'" target="_BLANK" style="font-family:'.$styles['links']['font-family'].'; font-size:'.$styles['links']['font-size'].'; color:'.$styles['links']['color'].'; font-weight:'.$styles['links']['font-weight'].'; text-decoration:'.$styles['links']['text-decoration'].'; ">
                        <h3 style="font-family:'.$styles['heading_3']['font-family'].'; font-size:'.$styles['heading_3']['font-size'].'; font-weight:'.$styles['heading_3']['font-weight'].'; margin: 0; ">';
            } else {
                return '<h3 style="font-family:'.$styles['heading_3']['font-family'].'; font-size:'.$styles['heading_3']['font-size'].'; color:'.$styles['heading_3']['color'].'; font-weight:'.$styles['heading_3']['font-weight'].'; margin: 0; ">';
            }
            break;
        
        case 'a':
            return '<a href="'.$attributes['href'].'" target="_BLANK" style="font-family:'.$styles['links']['font-family'].'; font-size:'.$styles['links']['font-size'].'; color:'.$styles['links']['color'].'; font-weight:'.$styles['links']['font-weight'].'; text-decoration:'.$styles['links']['text-decoration'].'; ">';
            break;
        
        default:
            break;
    }
}