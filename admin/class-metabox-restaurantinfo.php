<?php

/**
 * The metabox-specific functionality of the plugin.
 *
 * @link 		https://www.mysafemenu.com
 * @since 		1.0.0
 * @package 	Restaurants\Admin
 * @author 		Slushman <chris@slushman.com>
 */

namespace Restaurants\Admin;

class Metabox_RestaurantInfo extends \Restaurants\Admin\Metabox {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->set_nonce( 'nonce_restaurants_restaurantinfo' );
		$this->set_post_type( 'restaurant' );

		$args_field1['attributes']['id'] 			= 'restaurant-url';
		$args_field1['attributes']['type'] 			= 'url';
		$args_field1['properties']['label'] 		= esc_html__( 'Restaurant Website', 'restaurants' );
		$fields[] 									= array( 'restaurant-url', 'url', '', 'Text', $args_field1 );

		$args_field2['attributes']['id'] 			= 'menu-instructions';
		$args_field2['properties']['description'] 	= esc_html__( 'What if there is not a published allergen menu. "Ask at restaurant.", "No menu available.", etc', 'restaurants' );
		$args_field2['properties']['label'] 		= esc_html__( 'Menu Instructions', 'restaurants' );
		$fields[] 									= array( 'menu-instructions', 'editor', '', 'Editor', $args_field2 );

		$this->set_fields( $fields );

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters related to this class.
	 *
	 * @hooked 		init
	 * @since 		1.0.0
	 */
	public function hooks() {

		add_action( 'add_meta_boxes', 			array( $this, 'add_metaboxes' ), 10, 1 );
		add_action( 'save_post', 				array( $this, 'validate_meta' ), 10, 2 );
		add_action( 'edit_form_after_title', 	array( $this, 'promote_metaboxes' ), 10, 1 );
		add_action( 'add_meta_boxes', 			array( $this, 'set_meta' ), 1, 1 );
		add_action( 'rest_api_init', 			array( $this, 'restapi_fields' ) );
		add_action( 'rest_api_init', 			array( $this, 'cors_headers' ) );

	} // hooks()

	/**
	 * Registers metaboxes with WordPress
	 *
	 * @hooked 		add_meta_boxes
	 * @since 		1.0.0
	 * @access 		public
	 * @param 		object 			$post 			The post object.
	 */
	public function add_metaboxes( $post ) {

		add_meta_box(
			'restaurants_restaurantinfo',
			esc_html__( 'Restaurant Info', 'restaurants' ),
			array( $this, 'metabox' ),
			'restaurant',
			'normal',
			'default',
			array(
				//
			)
		);

	} // add_metaboxes()

} // class
