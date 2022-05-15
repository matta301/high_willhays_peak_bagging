<?php 

/**
 * Fired during plugin activation
 *
 * @link       N/A
 * @since      1.0.0
 *
 * @package    Peak_Dashboard
 * @subpackage Peak_Dashboard/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Peak_Dashboard
 * @subpackage Peak_Dashboard/includes
 * @author     Matt <matt_a70@hotmail.com>
 */
class Peak_Dashboard_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        
        global $wpdb;
        $database_name = $wpdb->dbname;
        $prefix = $wpdb->prefix;


        $table_name = $prefix . 'peakbagging_completed';

        $main_sql_table = "CREATE TABLE `$table_name` (
            `id` int NOT NULL AUTO_INCREMENT,
            `user_id` int NOT NULL,
            `peak_id` int NOT NULL,
            `summit_date` datetime DEFAULT NULL,
            `scotland` int DEFAULT NULL,
            `england` int DEFAULT NULL,
            `wales` int DEFAULT NULL,
            `n_ireland` int DEFAULT NULL,
            PRIMARY KEY (`id`)
          );";

        maybe_create_table( $table_name, $main_sql_table );
	}
}
