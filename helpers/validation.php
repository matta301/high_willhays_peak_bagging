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
        $values = array_values($uploaded_file)[0];

        // File Data
        $file_name = $values['name'];
        $file_mime = $values['type'];
        $file_tmp  = $values['tmp_name'];
        $file_err  = $values['error'];
        $file_size = $values['size'];

        // FILE errors
        if ( $file_err != NULL || $file_size > 4194304 ) { 
            $this->errors['file_size'] = 'file_size'; //'File size is too big. (4MB Max)';
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