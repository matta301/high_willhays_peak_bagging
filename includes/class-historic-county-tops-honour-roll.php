<?php

require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/templates/historic-county-tops-honour-roll-page.php';

class Historic_County_Tops_Honour_Roll
{
    public function __construct()
    {
        add_shortcode( 'county_tops_honour_roll', [$this, 'display_honour_roll'] );
    }

    function get_honour_roll() {

        global $wpdb;

        $roll_of_honour = $wpdb->get_results("CALL GetRollofHonour()", ARRAY_A);        
        return $roll_of_honour;
    }

    function display_honour_roll() {
        ob_start();
        echo display_historic_county_tops_honour_roll( $this->get_honour_roll() );
        return ob_get_clean();
    }
}

?>