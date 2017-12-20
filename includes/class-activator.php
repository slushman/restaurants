<?php

/**
 * Fired during plugin activation
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link 		https://www.allergenmen.us
 * @since 		1.0.0
 * @package 	Restaurants\Includes
 * @author 		Slushman <chris@slushman.com>
 */

namespace Restaurants\Includes;

class Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cpt-restaurant.php';

		\Restaurants\Admin\CPT_Restaurant::new_cpt_restaurant();

		flush_rewrite_rules();

	} // activate()

} // class
