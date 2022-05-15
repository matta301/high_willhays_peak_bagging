<?php

require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/templates/historic-county-tops-profile-page.php';
require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/helpers/validation.php';
require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/helpers/upload_profile_images.php';

class Historic_County_Tops_Profile
{
    public function __construct()
    {
        add_shortcode( 'county_tops_profile', [$this, 'get_historic_county_tops_profile'] );
        add_action( 'admin_post_historic_tops_update_profile', [$this, 'profile_update_submission'] );
    }


    function get_user_id() 
    {
        $user_id = get_current_user_id();
        return $user_id;
    }


    function image_name()
    {
        if ( $this->get_user_id() != 0 ) {

            $user_info = get_userdata( $this->get_user_id() );
            $name = '';

            if( !empty( $user_info->first_name ) ) {
                $name .= $user_info->first_name;
            }else {
                $name .= $user_info->user_login;
            }

            return $name;
        }else {
            return 'Username';
        }
    }


    function delete_image() 
    {
        $user_ID = $this->get_user_id();

        // Retrieve the post's attachment of user's summit image
        $post_attachment = get_posts(
            array(
                'post_type' => 'attachment',
                'author' => $this->get_user_id(),
                'post_parent' => '0'
            )
        );

        $upload_info = wp_get_upload_dir();
        $base_dir = $upload_info["basedir"];

        // Delete attachment and file
        if ( !empty( $post_attachment ) ) {
            foreach ($post_attachment as $image) {
                wp_delete_attachment( $image->ID, true );
                wp_delete_file( $base_dir . '/user_profile_images/user_'. $this->get_user_id() . '/' . $image->post_title );
            }
        }

        wp_redirect( bloginfo( 'url' ) . '/peak-bagging-profile/');
        exit();
    }


    function update_image() 
    {
        if ( $_FILES["profile_iamge"]["size"] > 0) {

            $user_ID = $this->get_user_id();

            $file_data_validation = new Peakbagging_dashboard_helpers();
            $file_results = $file_data_validation->file_validation( $_FILES );   

            // If any errors send back to frontend - (File type or file size)
            if ( !empty( $file_results ) ) {
                $str = '?error_id=' . $this->get_user_id();
                foreach ( $file_results as $key => $value ) {
                    $str .= '&' . $key . '=' . $value;
                }

                wp_redirect( bloginfo( 'url' ) . '/peak-bagging-profile/' . $str );
                exit();
            }

            // Retrieve the post's attachment of user's summit image
            $post_attachment = get_posts(
                array(
                    'post_type'   => 'attachment',
                    'author' => $user_ID,
                    'post_parent' => 0
                )
            );

            $upload_info = wp_get_upload_dir();
            $base_dir = $upload_info["basedir"];

            // Delete attachment and file
            if ( !empty( $post_attachment ) ) {
                foreach ($post_attachment as $image) {                    
                    wp_delete_attachment( $image->ID, true );
                    wp_delete_file( $base_dir . '/user_profile_images/user_'. $user_ID . '/' . $image->post_title );
                }
            }

            // Finaly upload file
            $upload_images = new Upload_User_Profile_Images();
            $result = $upload_images->upload_user_profile_image( $this->get_user_id(), $_FILES );

            wp_redirect( bloginfo( 'url' ) . '/peak-bagging-profile/' );
            exit();
        }
        
        
        wp_redirect( bloginfo( 'url' ) . '/peak-bagging-profile/' );
        exit();
    }
  

    function upload_image()
    {
        if ( $_FILES["profile_iamge"]["size"] > 0) {
            // File Validation
            if ( $_FILES["profile_iamge"]["size"] > 0 ) {
                $file_data_validation = new Peakbagging_dashboard_helpers();
                $file_results = $file_data_validation->file_validation( $_FILES );
            }

            // If any errors send back to frontend - (File type or file size)
            if ( !empty( $file_results ) ) {
                $str = '?error_id=' . $this->get_user_id();
                foreach ( $file_results as $key => $value ) {
                    $str .= '&' . $key . '=' . $value;
                }

                wp_redirect( bloginfo( 'url' ) . '/peak-bagging-profile/' . $str );
                exit();
            }

            // Upload File
            $upload_images = new Upload_User_Profile_Images();
            $result = $upload_images->upload_user_profile_image( $this->get_user_id(), $_FILES );

            wp_redirect( bloginfo( 'url' ) . '/peak-bagging-profile/?update=success' );
            exit();
        }

        wp_redirect( bloginfo( 'url' ) . '/peak-bagging-profile/' );
        exit();
    }


    function update_profile() 
    {
        // 'first_name', 'user_firstname', 'last_name', 'user_lastname', 'description', 'user_description', 'county'
        $first_name  = sanitize_text_field( $_POST['first_name'] );
        $last_name   = sanitize_text_field( $_POST['last_name'] );
        $county      = sanitize_text_field( $_POST['county'] );
        $description = sanitize_textarea_field( $_POST['description'] );

        if (!empty( $first_name )) {
            update_user_meta( $this->get_user_id(), 'first_name', $first_name );    
            update_user_meta( $this->get_user_id(), 'user_firstname', $first_name );    
        }

        if (!empty( $last_name )) {
            update_user_meta( $this->get_user_id(), 'last_name', $last_name );    
            update_user_meta( $this->get_user_id(), 'user_lastname', $last_name );    
        }

        if (!empty( $county )) {
            update_user_meta( $this->get_user_id(), 'peak_bagging_county', $county );    
        }

        if (!empty( $description )) {
            update_user_meta( $this->get_user_id(), 'description', $description );    
            update_user_meta( $this->get_user_id(), 'user_description', $description );    
        }

        wp_redirect( bloginfo( 'url' ) . '/peak-bagging-profile/?update=successful');
        exit();
    }


    function registration_date()
    {
        $membership_date = get_the_author_meta( 'user_registered', $this->get_user_id() );
        $formate_date = date( 'j F, Y', strtotime( $membership_date ) );
        
        return $formate_date;
    }


    function delete_entire_account()
    {
        $delete_input_text = sanitize_text_field( $_POST["delete_peakbagging_account"] );

        if ( $delete_input_text != 'DELETE PEAKBAGGING' ) {
            wp_redirect( bloginfo( 'url' ) . '/peak-bagging-profile/?delete=error');
            exit();
        }

        $user_ID = $this->get_user_id();

        // Delete any Comments  ============
        // Get and delete any user comments
        $user_comments = get_comments( array( 'user_id' => $user_ID ) );
        if( !empty( $user_comments ) ) {
            foreach ( $user_comments as $comment ) {
                wp_delete_comment( $comment->comment_ID, true );
            }
        }        

        // Delete any user profile images ============
        $user_image_attachment = get_posts(
            array( 'post_type' => 'attachment', 'author' => $user_ID, 'post_parent' => 0 )
        );

        $upload_info = wp_get_upload_dir();
        $base_dir = $upload_info["basedir"];

        // Delete attachment and file
        if ( !empty( $user_image_attachment ) ) {
            foreach ($user_image_attachment as $image) {
                wp_delete_attachment( $image->ID, true );
                wp_delete_file( $base_dir . '/user_profile_images/user_'. $user_ID . '/' . $image->post_title );
            }
        }

        // Delete any user summit images ============
        $post_attachment = get_posts(
            array( 'post_type' => 'attachment', 'author' => $user_ID )
        );

        if ( !empty( $post_attachment ) ) { 
            foreach ( $post_attachment as $attachment ) {
                wp_delete_attachment( $attachment->ID, true );
                wp_delete_file( $base_dir . '/summit_images/user_'. $user_ID . '/' . $attachment->post_title );
            }
        }
        
        // Delete completed peaks ============
        global $wpdb;
        $table = $wpdb->prefix . 'peakbagging_completed';
        $query = $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE user_id = %d", $user_ID));
        
        // Finaly, delete account
        require_once( ABSPATH.'wp-admin/includes/user.php' );
        wp_delete_user( $user_ID );


        wp_redirect( home_url() );
        exit();
    }


    function profile_update_submission() 
    {
        if( !empty( $_POST['action'] ) && $_POST['action'] === 'historic_tops_update_profile'
        && isset( $_POST['_wpnonce']) && wp_verify_nonce( $_POST['_wpnonce'], '_wpnonce') ) {

            if ( $_POST["submit_profile"] == 'delete_image' ) {
                $this->delete_image( $_FILES );
            }

            if( $_POST["submit_profile"] == 'upload_image' ) {
                $this->upload_image( $_FILES );
            }

            if( $_POST["submit_profile"] == 'update_image' ) {
                $this->update_image( $_FILES );
            }
            
            if ( $_POST["submit_profile"] == 'update_profile' ) {
                $this->update_profile( $_POST );
            }
            
            if ( $_POST["submit_profile"] == 'delete_account' ) {
                $this->delete_entire_account();
            }
        }
    }


    function get_user_profile_image()
    {
        $id = $this->get_user_id();
        global $wpdb;

        $posts_table = $wpdb->prefix . 'posts';
        $get_user_image = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $posts_table WHERE `post_type` = %s AND `post_author` = %d AND `post_parent` = %d", array( 'attachment', $id, 0 ) ), ARRAY_A );
        $counter = 0;
        $has_image = false;
        $profile_image = null;

        foreach( $get_user_image as $image) {
            $counter++;
            if ( strpos( $image['guid'], '300x' ) !== false || strpos( $image['guid'], 'x300' ) !== false ) {
                $has_image = true;
                $profile_image =  $image['guid'];
            }
        }

        if ( $has_image ) {
            
            return $profile_image;
        }
        
        return null;
    }


    function get_historic_county_tops_profile() {
        ob_start();
        echo display_historic_county_profile( $this->get_user_profile_image(), $this->get_user_id(), $this->registration_date(), $this->image_name() );
        return ob_get_clean();
    }
}

?>