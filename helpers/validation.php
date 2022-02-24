<?php

class Peakbagging_dashboard_helpers
{
    private $errors = array();

    function post_validation( $summit_date ) 
    {
        // POST Data
        $post_summit_date  = esc_html( $summit_date );

        // POST Errors
        if ( $post_summit_date == "null" || empty( $post_summit_date ) ) {
            $this->errors['date'] = wp_strip_all_tags('Date is not set');
        }

        if ( !empty( $this->errors ) ) {
            return $this->errors;
        }
    }

    function file_validation( $uploaded_file )
    {
        // File Data
        $file_name = $uploaded_file['peak_summit_image']['name'];
        $file_mime = $uploaded_file['peak_summit_image']['type'];
        $file_tmp  = $uploaded_file['peak_summit_image']['tmp_name'];
        $file_err  = $uploaded_file['peak_summit_image']['error'];
        $file_size = $uploaded_file['peak_summit_image']['size'];

        // FILE errors
        if ( $file_err != NULL || $file_size > 2097152 ) { 
            $this->errors['file_size'] = 'file_size'; //'File size is too big. (2MB Max)';
        }

        $allowed_ext = [ 'image/png', 'image/gif', 'image/jpeg', 'image/jpg' ];
        if ( $file_err != 1 && !in_array( $file_mime, $allowed_ext ) ){
            $this->errors['file_type'] = 'wrong_file'; // 'Acceptable files - png, jpg, gif ';     
        }

        if ( !empty( $this->errors ) ) {
            return $this->errors;
        }    
    }
}