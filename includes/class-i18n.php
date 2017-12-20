<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.slushman.com
 * @since      1.0.0
 * @package    Restaurants\Includes
 * @author     Slushman <chris@slushman.com>
 */

namespace Restaurants\Includes;

class i18n {

	/**
	 * Registers all the WordPress hooks and filters related to this class.
	 *
	 * @hooked 		init
	 * @since 		1.0.0
	 */
	public function hooks() {

		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

	} // hooks()

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @hooked 		plugins_loaded
	 * @since 		1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'restaurants',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	} // load_plugin_textdomain()

} // class
