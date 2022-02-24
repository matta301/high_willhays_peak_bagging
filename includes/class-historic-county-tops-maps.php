<?php

require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/templates/historic-county-tops-maps-page.php';

class Historic_County_Tops_Maps 
{
    public function __construct()
    {
        add_shortcode( 'county_tops_maps', [$this, 'get_maps'] );
    }


    function get_maps() {        
        ob_start();
        echo display_historic_county_tops_maps();
        return ob_get_clean();
    }
}

?>