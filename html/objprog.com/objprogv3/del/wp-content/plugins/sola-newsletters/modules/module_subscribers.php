<?php

function sola_import_subscribers($data,$list) {
    if (!isset($data) || $data == "") {
        return new WP_Error( 'sola_error', __( 'No data supplied' ), "" );
    }
    if (!isset($list)) {
        return new WP_Error( 'sola_error', __( 'Please select a list' ), "" );
    }
    
    global $sola_nl_subs_tbl;
    global $wpdb;
    
    $new_data = str_getcsv($data, "\n"); //parse the rows 
    
    
    $line_cnt = 1;
    foreach ($new_data as $result) {
        $update_subscriber = false;
        $new_subscriber = false;
        $email = "";
        $firstname = "";
        $lastname = "";
        
        
        $result = sola_santize_csv_data($result);
        $result_array = str_getcsv($result);
        
        $cnt = 0;
        foreach ($result_array as $line) {
            if ($cnt == 0) {
                /* email */
                $email = $line;
                if (!isset($email) || $email == "") { 
                    /* error handling */
                    return new WP_Error( 'sola_error', __( 'Email address not supplied' ), 'Email not supplied on line '.$line_cnt );
                }
                /* check if email exists */
                if (sola_check_if_subscriber_email_exists($line)) {
                    /* email exists, update db with name */
                    $new_subscriber = false;
                    $update_subscriber = true;
                } else {
                    $new_subscriber = true;
                    $update_subscriber = false;
                }
                
            }
            if ($cnt == 1) {
                /* first name */
                if (isset($line)) { $firstname = $line; } else { $firstname = ""; }
            }
            if ($cnt == 2) {
                /* last name */
                if (isset($line)) { $lastname = $line; } else { $lastname = ""; }
            }
            
            
            
           $line = sola_santize_csv_data($line);
            
            $cnt++;
        }
        /* good to go */
        if ($update_subscriber) {
                
                $subscriber_data = sola_get_subscriber_data_by_email($email);
                $sub_id = $subscriber_data->sub_id;
                sola_nl_add_sub_list($list, $sub_id);
                    if ($wpdb->update( 
                       $sola_nl_subs_tbl, 
                       array( 
                          'sub_email' => $email,	
                          'sub_name' => $firstname,
                          'sub_last_name' => $lastname
                       ), 
                       array( 'sub_id' => $sub_id), 
                       array( 
                          '%s',	
                          '%s',
                          '%s'
                       ), 
                       array( '%d' ) 
                    ) === FALSE) {
                       return new WP_Error( 'db_query_error', __( 'Could not execute query' ), $wpdb->last_error );
                    } else {
                       
                }
                
        }
        if ($new_subscriber) {
            if(sola_cts()){
                $sub_key = wp_hash_password( $email );
                $sola_nl_sub_check = $wpdb->insert( $sola_nl_subs_tbl, array( 'sub_id' => '', 'sub_name' => $firstname, 'sub_last_name' => $lastname, 'sub_email' => $email, 'sub_key' => $sub_key , "status" => 1 ) ) ;
                sola_nl_add_sub_list($list, $wpdb->insert_id);
            } else {
                return new WP_Error( 'sola_error', __("Import Error","sola"), sola_se() );
            }
        }
        if (!$new_subscriber && !$update_subscriber) {
            return new WP_Error( 'sola_error', __( 'Something went wrong with the upload. Please contact support' ), $new_data );

        } 


        
        
        
        
        $line_cnt++;

    }
}
function sola_get_subscriber_data_by_email($email) {
   global $wpdb;
   global $sola_nl_subs_tbl;
   $sql = "SELECT * FROM `$sola_nl_subs_tbl` WHERE `sub_email` = '$email' LIMIT 1";
   return $wpdb->get_row($sql);    
}
function sola_check_if_subscriber_email_exists($sub_email) {
    global $wpdb;
    global $sola_nl_subs_tbl;
    
    
    if($wpdb->get_row("SELECT * FROM `$sola_nl_subs_tbl` WHERE `sub_email` = '$sub_email' LIMIT 1")){
        return true;
    } else {
        return false;
    }
    
    
    
}
function sola_santize_csv_data($data) {
    if (!isset($data)) return false;
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = str_replace('"','',$data);
    return $data;
    
    
}
function sola_import_file_subscribers($list) {
    if (!isset($list)) {
        return new WP_Error( 'sola_error', __( 'Please select a list' ), "" );
    }
    
    global $wpdb;
    global $sola_nl_subs_tbl;
    global $sola_nl_subs_list_tbl;
    $insert_array = array();
    ini_set("auto_detect_line_endings", true);
    $handle = fopen($_FILES['sub_import_file']['tmp_name'], "r");
    while(! feof($handle)){
        if (isset($_POST['sub_data_replace_csvreplace']) && $_POST['sub_data_replace_csvreplace'] == "Yes") { 
            $wpdb->query("TRUNCATE TABLE $sola_nl_subs_tbl");
            $wpdb->query("TRUNCATE TABLE $sola_nl_subs_list_tbl");
            
        }
        while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
            set_time_limit(600);

            $email = $data[0];
            if (isset($data[1])) { $firstname = $data[1]; } else { $firstname = ""; }
            if (isset($data[2])) { $lastname = $data[2]; } else { $lastname = ""; }
            $new_subscriber = false;
            $update_subscriber = false;
            /* check if email exists */
            
            
            if (isset($_POST['sub_data_replace_csvreplace']) && $_POST['sub_data_replace_csvreplace'] == "Yes") { 
                /* no need to check for updates. just insert..! */
                $new_subscriber = true;
                $update_subscriber = false;
            } else { 
                if (sola_check_if_subscriber_email_exists($email)) {
                    /* email exists, update db with name */
                    $new_subscriber = false;
                    $update_subscriber = true;
                } else {
                    $new_subscriber = true;
                    $update_subscriber = false;
                }
            }
            /* good to go */
            if ($update_subscriber) {

                    $subscriber_data = sola_get_subscriber_data_by_email($email);
                    $sub_id = $subscriber_data->sub_id;
                    sola_nl_add_sub_list($list, $sub_id);
                        if ($wpdb->update( 
                           $sola_nl_subs_tbl, 
                           array( 
                              'sub_email' => $email,	
                              'sub_name' => $firstname,
                              'sub_last_name' => $lastname
                           ), 
                           array( 'sub_id' => $sub_id), 
                           array( 
                              '%s',	
                              '%s',
                              '%s'
                           ), 
                           array( '%d' ) 
                        ) === FALSE) {
                           return new WP_Error( 'db_query_error', __( 'Could not execute query' ), $wpdb->last_error );
                        } else {

                    }

            }
            if ($new_subscriber) {
                if(sola_cts()){
                    $sub_key = wp_hash_password( $email );
                    $arm_nl_sub_check = $wpdb->insert( $sola_nl_subs_tbl, array( 'sub_id' => '', 'sub_name' => $firstname, 'sub_last_name' => $lastname, 'sub_email' => $email, 'sub_key' => $sub_key , "status" => 1 ) ) ;
                    sola_nl_add_sub_list($list, $wpdb->insert_id);
                } else {
                   return new WP_Error( 'sola_error', __("Import Error","sola"), sola_se() );
                }

            }
            if (!$new_subscriber && !$update_subscriber) {
                return new WP_Error( 'sola_error', __( 'Something went wrong with the upload. Please contact support' ), $new_data );

            } 
            
         }

    }
    fclose($handle);
    
    
}