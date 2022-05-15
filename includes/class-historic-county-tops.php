<?php

require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/templates/historic-county-tops-page.php';
require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/helpers/upload_user_images.php';
require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/helpers/Display_image_sizes.php';
require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/helpers/validation.php';

class Historic_County_Tops
{
    public function __construct()
    {
        add_shortcode( 'county_tops', [$this, 'get_historic_county_tops'] );
        add_action( 'admin_post_historic_modal_submission', [$this, 'historic_modal_submission'] );
    }


    function historic_modal_submission() 
    {
        if( !empty( $_POST['action'] ) && $_POST['action'] === 'historic_modal_submission'
        && isset( $_POST['_wpnonce']) && wp_verify_nonce( $_POST['_wpnonce'], '_wpnonce') ) {

            if( $_POST["submit"] == 'complete' ) {
                $this->post_completed_peak();
            }

            if( $_POST["submit"] == 'edit' ) {
                $this->update_completed_peak();
            }            
            
            if( $_POST["submit"] == 'delete' ) {
                $this->delete_completed_peak();
            }
            
            if( $_POST["submit"] == 'delete_image' ) {
                $this->delete_summit_image();
            }

        } else {
            wp_redirect( bloginfo( 'url' ) . '/peak-bagging-historic-county-tops/');
            exit();
        }
    }


    /**
     *  PUT Completed Peak
     */
    function update_completed_peak()
    {
        $user_id = get_current_user_id();
        $user_info = get_userdata($user_id);

        $peak_id = esc_html( $_POST['peak_id'] );

        // If file exists
        if ( $_FILES["peak_summit_image"]["size"] > 0 ) {
            $file_data_validation = new Peakbagging_dashboard_helpers();
            $file_results = $file_data_validation->file_validation( $_FILES );
        }

        // If any errors send back to frontend - (File type or file size)
        if ( !empty( $file_results ) ) {
            $str = '?error_id=' .$peak_id;
            foreach ( $file_results as $key => $value ) {
                $str .= '&' . $key . '=' . $value;
            }

            wp_redirect( bloginfo( 'url' ) . '/peak-bagging-historic-county-tops/' . $str );
            exit();
        }

        // POST Data
        $peak_id         = esc_html( $_POST['peak_id'] );
        $summit_date     = esc_html( $_POST["peak_summit_date"] );
        $peak_country    = esc_html( strtolower( $_POST["peak_country"] ) );
        $field_report    = sanitize_textarea_field( $_POST["peak_field_report"] );

        $date_format    = str_replace( '/', '-', $summit_date );
        $date = date('Y-m-d', strtotime($date_format));
       
        // Retreive user's previous county top comment to update
        $retrieve_comment = get_comments( array( 'user_id' => $user_id, 'comment_post_ID' => $peak_id ) );

        $retrieve_comment[0]->comment_content   = $field_report;
        $retrieve_comment[0]->comment_author_IP = $_SERVER['REMOTE_ADDR'];
        $retrieve_comment[0]->comment_agent     = $_SERVER['HTTP_USER_AGENT'];
        $retrieve_comment[0]->comment_date      = date('Y-m-d H:i:s');
        $retrieve_comment[0]->comment_date_gmt  = date('Y-m-d H:i:s');

        wp_update_comment( (array)$retrieve_comment[0] );        

        global $wpdb;
        $wpdb->update( 
            $wpdb->prefix . 'peakbagging_completed',
            array( 'summit_date' => $date ),
            array( 'user_id' => $user_id, 'peak_id' => $peak_id )
        );

        if ( $_FILES["peak_summit_image"]["size"] > 0 ) {

            // Retrieve the post's attachment of user's summit image
            $post_attachment = get_posts(
                array(
                    'post_type'   => 'attachment',
                    'author' => $user_id,
                    'post_parent' => $peak_id
                )
            );

            $upload_info = wp_get_upload_dir();
            $base_dir = $upload_info["basedir"];

            // Delete attachment and file
            if ( !empty( $post_attachment ) ) {
                foreach ($post_attachment as $image) {
                    wp_delete_attachment( $image->ID, true );
                    wp_delete_file( $image->guid );
                    wp_delete_file( $base_dir . '/summit_images/user_'. $user_id . '/' . $image->post_title );
                }
            }

            // Finaly upload file if there is one
            $upload_images = new Upload_user_images();
            $result = $upload_images->upload_summit_images( $user_id, $_FILES, $peak_id );
        }
        
        wp_redirect( bloginfo( 'url' ) . '/peak-bagging-historic-county-tops/?update=success' );
        exit();
    }


    /**
     *  DELETE Completed Peak
     */
    function delete_completed_peak()
    {
        $peak_ID = $_POST['peak_id'];
        $user_ID = get_current_user_id();

        // Retrieve the ID of the comment related to the county top
        $comments = get_comments( array( 
            'user_id' => get_current_user_id(),
            'post_id' => $peak_ID
        ) );
     

        // Delete comment
        if( !empty($comments) ) {
            $delete_comment = wp_delete_comment( $comments[0]->comment_ID, true );
        }        

         // Retrieve the post's attachment of user's summit image
        $post_attachment = get_posts(
            array(
                'post_type'   => 'attachment',
                'author' => $user_ID,
                'post_parent' => $peak_ID
            )
        );

        $upload_info = wp_get_upload_dir();
        $base_dir = $upload_info["basedir"];

   
        // Delete attachment and file
        if ( !empty( $post_attachment ) ) {
            foreach ($post_attachment as $image) {
                wp_delete_attachment( $image->ID, true );
                wp_delete_file( $image->guid );
                wp_delete_file( $base_dir . '/summit_images/user_'. $user_ID . '/' . $image->post_title );
            }
        }

        global $wpdb;
        $query = $wpdb->query($wpdb->prepare("DELETE FROM tw_peakbagging_completed WHERE user_id = %d AND peak_id = %d;", $user_ID, $peak_ID));

      if ($query) {
        wp_redirect( bloginfo( 'url' ) . '/peak-bagging-historic-county-tops/');
        exit();
      }else {
        wp_redirect( bloginfo( 'url' ) . '/peak-bagging-historic-county-tops/?error=delete');
        exit();
      }
    }


    /**
     *  DELETE Image
     */
    function delete_summit_image()
    {
        $user_ID = get_current_user_id();
        $peak_ID = esc_html( $_POST['peak_id'] );

        // Retrieve the post's attachment of user's summit image
        $post_attachment = get_posts(
            array(
                'post_type' => 'attachment',
                'author' => $user_ID,
                'post_parent' => $peak_ID
            )
        );

        $upload_info = wp_get_upload_dir();
        $base_dir = $upload_info["basedir"];

        // Delete attachment and file
        if ( !empty( $post_attachment ) ) {
            foreach ($post_attachment as $image) {
                wp_delete_attachment( $image->ID, true );
                wp_delete_file( $image->guid );
                wp_delete_file( $base_dir . '/summit_images/user_'. $user_ID . '/' . $image->post_title );
            }
        }

        wp_redirect( bloginfo( 'url' ) . '/peak-bagging-historic-county-tops/');
        exit();
    }

    /**
     *  POST Completed Peak
     */
    function post_completed_peak()
    {       
        $user_id = get_current_user_id();
        $user_info = get_userdata($user_id);

        // POST Data
        $peak_id      = esc_html( $_POST['peak_id'] );
        $summit_date  = esc_html( $_POST["peak_summit_date"] );
        $peak_county  = esc_html( strtolower( $_POST["peak_county"] ) );
        $peak_country = esc_html( strtolower( $_POST["peak_country"] ) );
        $field_report = sanitize_textarea_field( $_POST["peak_field_report"] );

        $date_format    = str_replace( '/', '-', $summit_date );
        $date = date('Y-m-d', strtotime($date_format));

        if ( empty( $field_report ) ) {
            $field_report = 'No field report submitted';
        }
        
        // Post Validation
        $post_data_validation = new Peakbagging_dashboard_helpers();
        $post_results = $post_data_validation->post_validation( $summit_date );

        // File Validation
        if ( $_FILES["peak_summit_image"]["size"] > 0 ) {
            $file_data_validation = new Peakbagging_dashboard_helpers();
            $file_results = $file_data_validation->file_validation( $_FILES );
        }

        // If any errors send back to frontend - (File type or file size)
        if ( !empty( $file_results ) ) {
            $str = '?error_id=' .$peak_id;
            foreach ( $file_results as $key => $value ) {
                $str .= '&' . $key . '=' . $value;
            }

            wp_redirect( bloginfo( 'url' ) . '/peak-bagging-historic-county-tops/' . $str );
            exit();
        }


        // Submit comment to db
        $comment_data = array(
            'comment_post_ID'      => $peak_id,
            'comment_author'       => $user_info->display_name,
            'comment_author_email' => $user_info->user_email,
            'comment_author_url'   => $_SERVER['HTTP_REFERER'],
            'comment_content'      => $field_report,
            'comment_author_IP'    => $_SERVER['REMOTE_ADDR'],
            'comment_agent'        => $_SERVER['HTTP_USER_AGENT'],
            'comment_type'         => '',
            'comment_date'         => date('Y-m-d H:i:s'),
            'comment_date_gmt'     => date('Y-m-d H:i:s'),
            'comment_approved'     => 1,
            'user_id'              => $user_id
        );

        wp_insert_comment( $comment_data );

        if ($peak_country == 'northern ireland') {
            $peak_country = 'n_ireland';
        }

        // Insert into completed Peaks table
        global $wpdb;
        $result = $wpdb->insert( $wpdb->prefix . 'peakbagging_completed', array(
            'user_id' => $user_id,
            'peak_id' => $peak_id,
            'summit_date' => $date,
            strtolower($peak_country) => '1'
        ) );

        // Finaly upload file if there is one
        if ( $_FILES["peak_summit_image"]["size"] > 0 ) {
            $upload_images = new Upload_user_images();
            $result = $upload_images->upload_summit_images( $user_id, $_FILES, $peak_id );
        }

        wp_redirect( bloginfo( 'url' ) . '/peak-bagging-historic-county-tops/?completed=' . $peak_id . '&county=' . strtolower( $peak_county ) );
        exit();
    }


    /**
     *  GET Historic County Tops
     * 
     *  Return - Array (All historic County Tops)
     */
    function get_historic_county_tops()
    {
        $thumbnail_img = new Display_image_sizes();

        global $wpdb;
        $userID = get_current_user_id();
        $page_id = get_the_ID();

        $england = [];
        $scotland = [];
        $wales = [];
        $n_ireland = [];

        $all_countries = [ 'scotland', 'england', 'wales', 'n_ireland' ];

        // Returns list of all historic county tops along with completed peaks
        $county_tops = $wpdb->get_results("CALL GetHistoricCountyTops({$userID})", ARRAY_A);

        // Loop though entire list an sort each peak, depending on which country they're situated in
        foreach ($county_tops as $country) {

            if (strtolower($country['country']) == 'england') {
                $england[] = $country;
            }

            if (strtolower($country['country']) == 'scotland') {
                $scotland[] = $country;
            }

            if (strtolower($country['country']) == 'wales') {
                $wales[] = $country;
            }

            if (strtolower($country['country']) == 'northern ireland') {
                $n_ireland[] = $country;
            }
        }

        // County tops assigned to their respective country
        $county_tops['all_peaks'] = $county_tops;
        $county_tops['england']   = $england;
        $county_tops['scotland']  = $scotland;
        $county_tops['wales']     = $wales;
        $county_tops['n_ireland'] = $n_ireland;

        ob_start();
        echo display_historic_county_tops($page_id, $all_countries, $county_tops, $thumbnail_img );
        return ob_get_clean();
    }
}
