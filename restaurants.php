<?php

/**
 * A simple Restaurants custom post type plugin.
 *
 * @link 				https://www.allergenmen.us
 * @since             	1.0.0
 * @package 			Restaurants
 *
 * @wordpress-plugin
 * Plugin Name:       	Restaurants
 * Plugin URI: 			https://www.allergenmen.us
 * GitHub Plugin URI:	https://github.com/slushman/restaurants
 * Description: 		A simple Restaurants custom post type plugin.
 * Version: 			1.0.4.8
 * Author: 				Slushman
 * Author URI: 			https://www.slushman.com
 * License: 			GPL-2.0+
 * License URI: 		http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 		restaurants
 * Domain Path: 		/languages
 *
 * @todo 		BUG - the back to top link shoudl show every 10 restaurants,
 * 						not just after the 10th one.
 * @todo 		Add menu publication date
 * @todo 		Figure out adding the sorter via GutenBlock
 * @todo 		Add restaurants list via GutenBlock
 */

use Restaurants\Includes as Inc;
use Restaurants\Admin;
use Restaurants\Frontend;
use Restaurants\Blocks;
use Restaurants\Classes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

// Define constants.
define( 'RESTAURANTS_FILE', plugin_basename( __FILE__ ) );
define( 'RESTAURANTS_SLUG', 'restaurants' );
define( 'RESTAURANTS_SETTINGS', 'restaurants_settings' );
define( 'RESTAURANTS_VERSION', '1.0.1' );
define( 'RESTAURANTS_CUSTOMIZER', 'restaurants' );
define( 'RESTAURANTS_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Include the autoloader.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-autoloader.php';

/**
 * Activation and Deactivation Hooks.
 */
register_activation_hook( __FILE__, array( 'Restaurants\Includes\Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Restaurants\Includes\Deactivator', 'deactivate' ) );

/**
 * Initializes each class and adds the hooks action in each to init.
 */
function restaurants_init() {

	$classes[] = new Inc\i18n();
	$classes[] = new Admin\CPT_Restaurant();
	$classes[] = new Admin\Posts();
	$classes[] = new Admin\Admin();
	$classes[] = new Admin\Metabox_Menufiles();
	$classes[] = new Admin\Metabox_RestaurantInfo();
	$classes[] = new Frontend\Frontend();
	$classes[] = new Frontend\Templates();
	//$classes[] = new Classes\Blocks();

	foreach ( $classes as $class ) {

		add_action( 'init', array( $class, 'hooks' ) );

	}

} // restaurants_init()

add_action( 'plugins_loaded', 'restaurants_init' );
