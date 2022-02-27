<?php

require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/templates/historic-county-tops-badges-page.php';

class Historic_County_Tops_badges
{
    public function __construct()
    {
        add_shortcode( 'county_tops_badges', [$this, 'get_historic_county_tops_badges'] );
    }

    function get_badges() {
        global $wpdb;
        $userID = get_current_user_id();
        $pageID = get_the_ID();

        $county_tops = $wpdb->get_results("CALL GetBadges({$userID})", ARRAY_A);

        return $county_tops;
    }



    function get_historic_county_tops_badges() {
        ob_start();
        echo display_historic_county_tops_trophys($this->get_badges());
        return ob_get_clean();
    }
}

?>