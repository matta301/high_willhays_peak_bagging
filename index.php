<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              N/A
 * @since             1.0.0
 * @package           Peak_Dashboard
 *
 * @wordpress-plugin
 * Plugin Name:       Peak Bagging Dashboard
 * Plugin URI:        N/A
 * Description:       Historic County Tops of the United Kingdom
 * Version:           1.0.0
 * Author:            Matt
 * Author URI:        N/A
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       peak-dashboard
 * Domain Path:       /languages
 */

 /**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-peak-dashboard-activator.php
 */

global $dahboard_dir;
$dahboard_dir = '/high_willhays_peak_bagging/';

require_once WP_PLUGIN_DIR . '/high_willhays_peak_bagging/includes/class-historic-county-tops.php';
$historic_County_Tops = new Historic_County_Tops();

require_once WP_PLUGIN_DIR . '/high_willhays_peak_bagging/includes/class-historic-county-tops-profile.php';
$historic_County_Tops_profile = new Historic_County_Tops_Profile();

require_once WP_PLUGIN_DIR . '/high_willhays_peak_bagging/includes/class-historic-county-tops-dashboard.php';
$Historic_County_Tops_Dashboard = new Historic_County_Tops_Dashboard();

require_once WP_PLUGIN_DIR . '/high_willhays_peak_bagging/includes/class-historic-county-tops-maps.php';
$historic_County_Tops_Maps = new Historic_County_Tops_Maps();

require_once WP_PLUGIN_DIR . '/high_willhays_peak_bagging/includes/class-historic-county-tops-badges.php';
$historic_County_Tops_Badges = new Historic_County_Tops_Badges();

require_once WP_PLUGIN_DIR . '/high_willhays_peak_bagging/includes/class-historic-county-tops-honour-roll.php';
$historic_County_Tops_Honour_Roll = new Historic_County_Tops_Honour_Roll();

function activate_peak_dashboard() {
	require_once WP_PLUGIN_DIR . '/high_willhays_peak_bagging/includes/class-peak-dashboard-activator.php';
	Peak_Dashboard_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_peak_dashboard' );

function add_plugin_scripts() {

    if ( is_page( array( 1557, 1548, 1560, 1554, 1567, 1563 ) ) ) {
        // Date picker
        wp_enqueue_style( 'datepicker-styles', plugins_url() . '/high_willhays_peak_bagging/assets/plugins/datepicker/datepicker.min.css' );    
        wp_enqueue_script( 'datepicker-scripts', plugins_url() . '/high_willhays_peak_bagging/assets/plugins/datepicker/datepicker.js', array(), null, true );
        wp_enqueue_script( 'datepicker-init', plugins_url() . '/high_willhays_peak_bagging/assets/js/init-datepicker.js', array(), null, true );

        wp_enqueue_style( 'bootstrap-css', plugins_url( 'high_willhays_peak_bagging/assets/bootstrap/bootstrap.min.css' ) );
        wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true );

        // Main
        wp_enqueue_style( 'peak-bagging-styles', plugins_url() . '/high_willhays_peak_bagging/assets/css/main.css' );    
        wp_enqueue_script( 'peak-bagging-scripts', plugins_url() . '/high_willhays_peak_bagging/assets/js/bundle.js', array(), null, true );
    }
}
add_action( 'wp_enqueue_scripts', 'add_plugin_scripts' );


function redirect_to_landing_page() {

    //  peak-bagging-profile               - 1557
    //  peak-bagging-dashboard             - 1548
    //  peak-bagging-historic-county-tops  - 1560    
    //  peak-bagging-maps                  - 1554
    //  peak-bagging-trophy-cabinet        - 1567
    //  peak-bagging-roll-of-honour        - 1563

    if ( ! is_user_logged_in() && is_page( array( 1557, 1548, 1560, 1554, 1567, 1563 ) ) ) {

        wp_redirect( bloginfo( 'url' ) . '/my-account/' ); 
        exit;
    }
}
add_action( 'template_redirect', 'redirect_to_landing_page' );

?>