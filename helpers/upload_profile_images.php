<?php

class Upload_User_Profile_Images
{
    private $custom_dir = '/user_profile_images/';
    private $id;

     /**
     *  Upload users summit images
     *  @param int    $uploaded_file - Logged in user's Id
     *  @param int    $peak_id - Historic county top Id
     * 
     *  @return boolean
     */
    function upload_user_profile_image( $user_id, $uploaded_file )
    {
        $this->id = $user_id;

        // File Data
        $file      = array_values($uploaded_file)[0];
        $file_name = sanitize_file_name( $file['name'] );
        $file_mime = sanitize_mime_type( $file['type'] );

        $upload_dir = wp_upload_dir();

        require_once( ABSPATH . 'wp-admin/includes/admin.php' );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        // Check to see if there is a file with the same name
        $new_file_name = wp_unique_filename( $upload_dir['basedir'] . $this->$custom_dir . 'user_' . $this->id . '/', $file_name );
        $file_name = $new_file_name;

        // Move file to custom directory 
        add_filter( 'upload_dir', array( $this, 'summit_upload_dir' ) );
        $move_file = wp_handle_upload( $file, array( 'test_form' => false ) );
        remove_filter( 'upload_dir', array( $this, 'summit_upload_dir' ) );

        if ( is_wp_error( $move_file ) ) {
            return json_encode( $move_file->get_error_message() );
        }

        $file_img_path = $upload_dir["baseurl"] . $this->custom_dir . 'user_' . $this->id . '/' . basename( $new_file_name );

        $attachment = array(
            'guid' => $file_img_path,
            'post_mime_type' => $file_mime,
            'post_title' => $file_name,
            'post_name' => 'profile-image-' . preg_replace( '/\\.[^.\\s]{3,4}$/', '', $file_name ),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        // Insert record in db with url of image along with author ID and parent_post ID
        $attachment_id = wp_insert_attachment( $attachment, $file_name, $peak_id );

        add_filter('intermediate_image_sizes_advanced', array( $this, 'PREFIX_remove_default_image_sizes' ) );
        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_dir["basedir"] . $this->custom_dir . 'user_' . $this->id . '/' . basename( $new_file_name ) );
        remove_filter('intermediate_image_sizes_advanced', array( $this, 'PREFIX_remove_default_image_sizes' ) );

        foreach ($attachment_data['sizes'] as $value) {
            $attachment = array(
                'guid' => $upload_dir["baseurl"] . $this->custom_dir . 'user_' . $this->id . '/' . $value["file"],
                'post_mime_type' => $value["mime-type"],
                'post_title' => $value["file"],
                'post_name' => preg_replace( '/\\.[^.\\s]{3,4}$/', '', $value["file"] ),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            wp_insert_attachment( $attachment, $value["file"], null );
        }

        $insert_attachment = wp_update_attachment_metadata( $attachment_id, $attachment_data );

        if ( is_wp_error( $insert_attachment ) ) {
            return json_encode( $insert_attachment->get_error_message() );
        }

        return true;
    }


    /**
     *  Remove image generation sizes
     *  @param $sizes - theme ad plugin image sizes
     * 
     * @return array
     */
    function PREFIX_remove_default_image_sizes($sizes){
        // unset( $sizes[ 'post-thumbnail' ] );
        unset( $sizes[ 'thumbnail' ] );
        unset( $sizes[ '2048x2048' ] );
        unset( $sizes[ 'large' ] );
        unset( $sizes[ '1536x1536' ] );
        unset( $sizes[ 'medium_large' ] );
        unset( $sizes[ 'mailpoet_newsletter_max' ] );
        unset( $sizes[ 'shop_thumbnail' ] );
        unset( $sizes[ 'shop_catalog' ] );
        unset( $sizes[ 'shop_single' ] );
        unset( $sizes[ 'woocommerce_thumbnail' ] );
        unset( $sizes[ 'woocommerce_single' ] );
        unset( $sizes[ 'woocommerce_gallery_thumbnail' ] );

        return $sizes;
    }

    /**
     *  Summit Image Custom Direcotry
     *  @param $dir_data - Direcotry where images are written to
     * 
     *  @return bool
     */
    function summit_upload_dir( $dir_data ) {
        return array(
            'path' => $dir_data[ 'basedir' ] . $this->custom_dir . 'user_' . $this->id,
            'url' => $dir_data[ 'baseurl' ] . $this->custom_dir . 'user_' . $this->id,
            'subdir' => '/' . $this->custom_dir,
            'basedir' => $dir_data[ 'basedir' ],
            'error' => $dir_data[ 'error' ],
        );
    }
}

?>