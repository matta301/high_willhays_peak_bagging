<?php 

class Display_image_sizes 
{
    function thumbnail_image( $image_url ) {
        $file_type = wp_check_filetype( $image_url );
        return  implode('-', explode('-', $image_url, -1)) . '-150x150.' . $file_type["ext"];
    }
}

?>