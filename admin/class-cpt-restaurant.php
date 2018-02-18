<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines a custom post type and other related functionality.
 *
 * @link 		https://www.allergenmen.us
 * @since 		1.0.0
 * @package 	Restaurants\Admin
 * @author 		Slushman <chris@slushman.com>
 */

namespace Restaurants\Admin;

class CPT_Restaurant {

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

		add_action( 'wp_loaded', 								array( $this, 'new_cpt_restaurant' ) );
		add_filter( 'manage_restaurant_posts_columns', 			array( $this, 'restaurant_register_columns' ) );
		add_action( 'manage_restaurant_posts_custom_column', 	array( $this, 'restaurant_column_content' ), 10, 2 );
		add_action( 'request', 									array( $this, 'restaurant_order_sorting' ), 10, 2 );
		add_action( 'wp_loaded', 								array( $this, 'add_image_sizes' ) );
		add_action( 'after_switch_theme', 						array( $this, 'flush_rewrites' ) );

	} // hooks()

	/**
	 * Registers additional image sizes
	 *
	 * @hooked 		wp_loaded
	 * @since 		1.0.0
	 */
	public function add_image_sizes() {

		add_image_size( 'col-thumb', 75, 75, true );

	} // add_image_sizes()

	/**
	 * Flushes the rewrite rules.
	 *
	 * @hooked 		after_switch_theme
	 * @since 		1.0.5
	 */
	public function flush_rewrites() {

		$this->new_cpt_restaurant();

		flush_rewrite_rules();

	} // flush_rewrites()

	/**
	 * Populates the custom columns with content.
	 *
	 * @hooked 		manage_restaurant_posts_custom_column
	 * @since 		1.0.0
	 * @param 		string 		$column_name 		The name of the column
	 * @param 		int 		$post_id 			The post ID
	 * @return 		string 							The column content
	 */
	public function restaurant_column_content( $column_name, $post_id  ) {

		if ( empty( $post_id ) ) { return; }

		if ( 'thumbnail' === $column_name ) {

			$thumb = get_the_post_thumbnail( $post_id, 'col-thumb' );

			echo $thumb;

		}

		if ( 'menu' === $column_name ) {

			$meta 		= get_post_meta( $post_id, 'menu-files' );
			$files 		= maybe_unserialize( $meta[0] );

			echo count( $files );

		}

	} // restaurant_column_content()

	/**
	 * Sorts the restaurant admin list by the display order
	 *
	 * @hooked 		request
	 * @since 		1.0.0
	 * @param 		array 		$vars 			The current query vars array
	 * @return 		array 						The modified query vars array
	 */
	public function restaurant_order_sorting( $vars ) {

		if ( empty( $vars ) ) { return $vars; }
		if ( ! is_admin() ) { return $vars; }
		if ( ! isset( $vars['post_type'] ) || 'restaurant' !== $vars['post_type'] ) { return $vars; }

		if ( isset( $vars['orderby'] ) && 'sortable-column' === $vars['orderby'] ) {

			$vars = array_merge( $vars, array(
				'meta_key' => 'sortable-column',
				'orderby' => 'meta_value'
			) );

		}

		return $vars;

	} // restaurant_order_sorting()

	/**
	 * Registers additional columns for the admin listing
	 * and reorders the columns.
	 *
	 * @hooked 		manage_restaurant_posts_columns
	 * @since 		1.0.0
	 * @param 		array 		$columns 		The current columns
	 * @return 		array 						The modified columns
	 */
	public function restaurant_register_columns( $columns ) {

		$new['cb'] 			= '<input type="checkbox" />';
		$new['thumbnail'] 	= __( 'Thumbnail', 'restaurants' );
		$new['title'] 		= __( 'Title', 'restaurants' );
		$new['menu'] 		= __( 'Menu', 'restaurants' );
		$new['date'] 		= __( 'Date' );

		return $new;

	} // restaurant_register_columns()

	/**
	 * Creates a new custom post type
	 *
	 * @hooked 		wp_loaded
	 * @since 		1.0.0
	 */
	public static function new_cpt_restaurant() {

		$cap_type = 'post';

		$opts['label']									= __( 'Restaurants', 'restaurants' );
		$opts['menu_icon']								= 'dashicons-store';
		$opts['menu_position']							= 25;
		$opts['public']									= TRUE;
		$opts['show_admin_column']						= TRUE;
		$opts['show_in_rest'] 							= TRUE;
		$opts['supports']								= array( 'title', 'editor', 'thumbnail', 'revisions' );

		/**
		 * The restaurants_cpt_restaurant_options filter.
		 *
		 * @var 		array 		$opts
		 */
		$opts = apply_filters( 'restaurants_cpt_restaurant_options', $opts );

		register_post_type( 'restaurant', $opts );

	} // new_cpt_restaurant()

} // class
