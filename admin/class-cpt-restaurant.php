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

		$opts['can_export']								= TRUE;
		$opts['capability_type']						= $cap_type;
		$opts['description']							= '';
		$opts['exclude_from_search']					= FALSE;
		$opts['has_archive']							= FALSE;
		$opts['hierarchical']							= FALSE;
		$opts['map_meta_cap']							= TRUE;
		$opts['menu_icon']								= 'dashicons-store';
		$opts['menu_position']							= 25;
		$opts['public']									= TRUE;
		$opts['publicly_querable']						= TRUE;
		$opts['query_var']								= TRUE;
		$opts['register_meta_box_cb']					= '';
		$opts['rewrite']								= FALSE;
		$opts['rest_base']								= 'restaurant';
		$opts['rest_controller_class']					= 'WP_REST_Posts_Controller';
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']							= TRUE;
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['supports']								= array( 'title', 'editor', 'thumbnail', 'revisions' );
		$opts['taxonomies']								= array();

		$opts['capabilities']['delete_others_posts']	= "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']			= "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']			= "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']	= "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts']	= "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']		= "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']				= "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']				= "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']		= "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']	= "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']			= "publish_{$cap_type}s";
		$opts['capabilities']['read_post']				= "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']		= "read_private_{$cap_type}s";

		$opts['labels']['add_new']						= esc_html__( 'Add New Restaurant', 'restaurants' );
		$opts['labels']['add_new_item']					= esc_html__( 'Add New Restaurant', 'restaurants' );
		$opts['labels']['all_items']					= esc_html__( 'Restaurants', 'restaurants' );
		$opts['labels']['edit_item']					= esc_html__( 'Edit Restaurant' , 'restaurants');
		$opts['labels']['menu_name']					= esc_html__( 'Restaurants', 'restaurants' );
		$opts['labels']['name']							= esc_html__( 'Restaurants', 'restaurants' );
		$opts['labels']['name_admin_bar']				= esc_html__( 'Restaurant', 'restaurants' );
		$opts['labels']['new_item']						= esc_html__( 'New Restaurant', 'restaurants' );
		$opts['labels']['not_found']					= esc_html__( 'No Restaurants Found', 'restaurants' );
		$opts['labels']['not_found_in_trash']			= esc_html__( 'No Restaurants Found in Trash', 'restaurants' );
		$opts['labels']['parent_item_colon']			= esc_html__( 'Parent Restaurants :', 'restaurants' );
		$opts['labels']['search_items']					= esc_html__( 'Search Restaurants', 'restaurants' );
		$opts['labels']['singular_name']				= esc_html__( 'Restaurant', 'restaurants' );
		$opts['labels']['view_item']					= esc_html__( 'View Restaurant', 'restaurants' );

		$opts['labels']['add_new']						= esc_html__( 'Add New Restaurant', 'restaurants' );
		$opts['labels']['add_new_item']					= esc_html__( 'Add New Restaurant', 'restaurants' );
		$opts['labels']['all_items']					= esc_html__( 'Restaurants', 'restaurants' );
		$opts['labels']['archives']						= esc_html__( 'Restaurants', 'restaurants' );
		$opts['labels']['edit_item']					= esc_html__( 'Edit Restaurant', 'restaurants');
		$opts['labels']['featured_image']				= esc_html__( 'Restaurant Logo', 'restaurants');
		$opts['labels']['filter_items_list']			= esc_html__( 'Restaurants', 'restaurants');
		$opts['labels']['insert_into_item']				= esc_html__( 'Restaurant', 'restaurants');
		$opts['labels']['items_list']					= esc_html__( 'Restaurants', 'restaurants');
		$opts['labels']['items_list_navigation']		= esc_html__( 'Restaurants', 'restaurants');
		$opts['labels']['menu_name']					= esc_html__( 'Restaurants', 'restaurants' );
		$opts['labels']['name']							= esc_html__( 'Restaurants', 'restaurants' );
		$opts['labels']['name_admin_bar']				= esc_html__( 'Restaurant', 'restaurants' );
		$opts['labels']['new_item']						= esc_html__( 'New Restaurant', 'restaurants' );
		$opts['labels']['not_found']					= esc_html__( 'No Restaurants Found', 'restaurants' );
		$opts['labels']['not_found_in_trash']			= esc_html__( 'No Restaurants Found in Trash', 'restaurants' );
		$opts['labels']['parent_item_colon']			= esc_html__( 'Parent Restaurants :', 'restaurants' );
		$opts['labels']['remove_featured_image']		= esc_html__( 'Remove Restaurant Logo', 'restaurants' );
		$opts['labels']['search_items']					= esc_html__( 'Search Restaurants', 'restaurants' );
		$opts['labels']['set_featured_image']			= esc_html__( 'Set Restaurant Logo', 'restaurants' );
		$opts['labels']['singular_name']				= esc_html__( 'Restaurant', 'restaurants' );
		$opts['labels']['upload_to_this_item']			= esc_html__( 'Restaurant', 'restaurants' );
		$opts['labels']['use_featured_image']			= esc_html__( 'Use as Restaurant Logo', 'restaurants' );
		$opts['labels']['view_item']					= esc_html__( 'View Restaurant', 'restaurants' );

		$opts['rewrite']['ep_mask']						= EP_PERMALINK;
		$opts['rewrite']['feeds']						= FALSE;
		$opts['rewrite']['pages']						= TRUE;
		$opts['rewrite']['slug']						= esc_html__( 'restaurant', 'restaurants' );
		$opts['rewrite']['with_front']					= TRUE;

		/**
		 * The restaurants_cpt_restaurant_options filter.
		 *
		 * @var 		array 		$opts
		 */
		$opts = apply_filters( 'restaurants_cpt_restaurant_options', $opts );

		register_post_type( 'restaurant', $opts );

	} // new_cpt_restaurant()

} // class
