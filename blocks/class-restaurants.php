<?php

/**
 * Defines all the code for the Restaurants Gutenblock.
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 * @package 	Restaurants\Blocks
 */

namespace Restaurants\Blocks;

class Restaurants {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		//

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters related to this class.
	 *
	 * @hooked 		init
	 * @since 		1.0.0
	 */
	public function hooks() {

		add_action( 'plugins_loaded', array( $this, 'register_meta' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_assets' ) );

	} // hooks()

	/**
	 * Enqueues assets for the block.
	 *
	 * @hooked 		enqueue_block_editor_assets
	 * @since 		1.0.0
	 */
	public function enqueue_assets() {

		wp_enqueue_script( RESTAURANTS_SLUG . '-restaurants-block', plugins_url( 'js/restaurants.min.js', __FILE__ ), array( 'wp-blocks' ) );

	} // enqueue_assets()

	/**
	 * Registers meta fields needed for the block data.
	 *
	 * @hooked 		plugins_loaded
	 * @since 		1.0.0
	 */
	public function register_meta() {

		$restaurants['show_in_rest'] 		= true;
		$restaurants['single'] 				= true;
		$restaurants['type'] 				= 'string';
		$restaurants['sanitize_callback'] 	= 'sanitize_text_field';

		register_meta( 'post', 'restaurants', $restaurants );

	} // register_meta()

} // class
