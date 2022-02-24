<?php 

class Display_image_sizes 
{

    function thumbnail_image( $image_url ) {

        $guid = substr($image_url, strrpos($image_url, '/') + 1);        
        return $guid;
    }
}

?>