<?php

require_once WP_PLUGIN_DIR .'/high_willhays_peak_bagging/templates/historic-county-tops-honour-roll-page.php';

class Historic_County_Tops_Honour_Roll
{
    public function __construct()
    {
        add_shortcode( 'county_tops_honour_roll', [$this, 'display_honour_roll'] );
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
        
        return $this->initials();
    }


    function initials()
    {
        $user_ID = get_current_user_id();
        $user_info = get_userdata( $user_ID );
        $name = '';

        if( !empty( $user_info->first_name ) ) {
            $name .= substr($user_info->first_name, 0, 2);
        }else {
            $name .= substr($user_info->user_login, 0, 2);
        }    

        return $name;
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