<?php

namespace Restaurants\Frontend;

/**
 * Public API for adding and removing templates.
 *
 * @return 		object 			Instance of the templates class
 */
function restaurants_templates() {

	return \Restaurants\Frontend\Templates::this();

} // restaurants_templates()

/**
 * Template-related functions
 *
 * Defines the methods for creating the templates.
 *
 * @link 		https://www.mysafemenu.com
 * @since 		1.0.0
 * @package 	Restaurants\Frontend
 * @author 		Slushman <chris@slushman.com>
 */

class Templates {

	/**
	 * Private static reference to this class
	 * Useful for removing actions declared here.
	 *
	 * @var 	object 		$_this
	  */
	private static $_this;

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$settings    The plugin options.
	 */
	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		self::$_this = $this;

		$this->set_settings();

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters related to this class.
	 *
	 * @hooked 		init
	 * @since 		1.0.0
	 */
	public function hooks() {

		// Loop
		add_action( 'restaurants_before_loop', 			array( $this, 'loop_wrap_begin' ), 10, 1 );
		add_action( 'restaurants_before_loop', 			array( $this, 'loop_search_or_sort' ), 15, 1 );

		add_action( 'restaurants_begin_loop_content', 	array( $this, 'loop_content_wrap_begin' ), 15, 2 );
		add_action( 'restaurants_begin_loop_content', 	array( $this, 'loop_content_link_begin' ), 20, 2 );

		add_action( 'restaurants_loop_content', 		array( $this, 'loop_content_title' ), 15, 2 );

		add_action( 'restaurants_end_loop_content', 	array( $this, 'loop_content_link_end' ), 10, 2 );

		// Setup new UL with each menu file linked with the Menu Title as the text.
		add_action( 'restaurants_end_loop_content', 	array( $this, 'loop_content_multiple_files' ), 20, 2 );


		add_action( 'restaurants_end_loop_content', 	array( $this, 'loop_content_wrap_end' ), 90, 2 );

		add_action( 'restaurants_after_loop', 			array( $this, 'loop_wrap_end' ), 10, 1 );

		// Single
		add_action( 'restaurants_single_content', 		array( $this, 'single_restaurant_website' ), 30, 1 );
		add_action( 'restaurants_single_content', 		array( $this, 'single_restaurant_meta_field' ), 30, 1 );

	} // hooks()

	/**
	 * Returns an array of the featured image details
	 *
	 * @exits 		If $postID is empty.
	 * @exits 		If $imageID is empty.
	 * @since 		1.0.0
	 * @param 		int 		$postID 		Post ID
	 * @return 		array 						Array of info about the featured image
	 */
	public function get_featured_images( $postID ) {

		if ( empty( $postID ) ) { return FALSE; }

		$imageID = get_post_thumbnail_id( $postID );

		if ( empty( $imageID ) ) { return FALSE; }

		return wp_prepare_attachment_for_js( $imageID );

	} // get_featured_images()

	/**
	 * Includes the link start template file
	 *
	 * @exits 		If there are no menu files.
	 * @exits 		If there is more than one menu file.
	 * @hooked 		restaurants_begin_loop_content 		20
	 * @since 		1.0.0
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_link_begin( $item, $meta = array() ) {

		if ( empty( $meta['menu-files'][0] ) ) { return; }

		$files = maybe_unserialize( $meta['menu-files'][0] );

		include restaurants_get_template( 'content-link-begin', 'loop' );

	} // loop_content_link_begin()

	/**
	 * Includes the link end template file
	 *
	 * @exits 		If there are no menu files.
	 * @exits 		If there is more than one menu file.
	 * @hooked 		restaurants_end_loop_content
	 * @since 		1.0.0
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_link_end( $item, $meta = array() ) {

		if ( empty( $meta['menu-files'][0] ) ) { return; }

		include restaurants_get_template( 'content-link-end', 'loop' );

	} // loop_content_link_end()

	/**
	 * Includes the featured image template
	 *
	 * @exits 		If there aren't images.
	 * @hooked 		restaurants_loop_content 		10
	 * @since 		1.0.0
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_image( $item, $meta = array() ) {

		$images = $this->get_featured_images( $item->ID );

		if ( empty( $images ) ) { return; }

		if ( array_key_exists( 'medium', $images['sizes'] ) ) {

			$source = $images['sizes']['medium']['url'];

		} else {


			$source = $images['sizes']['full']['url'];

		}

		/**
		 * The restaurants_loop_image filter.
		 *
		 * Allows for changing the image source.
		 *
		 * @var 		array 		$images 		The images array.
		 */
		$source = apply_filters( 'restaurants_loop_image', $source, $images );

		include restaurants_get_template( 'content-image', 'loop' );

	} // loop_content_image()

	/**
	 * Includes the content-multiple-files template.
	 *
	 * @exits 		If there are no files.
	 * @exits 		If there is only one file.
	 * @hooked 		loop_content_multiple_files 		20
	 * @since 		1.0.0
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_multiple_files( $item, $meta = array() ) {

		if ( empty( $meta['menu-files'][0] ) ) { return; }

		$files = maybe_unserialize( $meta['menu-files'][0] );

		if ( 1 === count( $files ) ) { return; }

		include restaurants_get_template( 'content-multiple-files', 'loop' );

	} // loop_content_multiple_files()

	/**
	 * Includes the restaurants-subtitle template
	 *
	 * @exits 		If subtitle is empty.
	 * @hooked 		restaurants_loop_content 		30
	 * @since 		1.0.0
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_subtitle( $item, $meta = array() ) {

		if ( empty( $meta['subtitle'][0] ) ) { return; }

		include restaurants_get_template( 'content-subtitle', 'loop' );

	} // loop_content_subtitle()

	/**
	 * Includes the restaurants-title template
	 *
	 * @hooked 		restaurants_loop_content 		20
	 * @since 		1.0.0
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_title( $item, $meta = array() ) {

		include restaurants_get_template( 'content-title', 'loop' );

	} // loop_content_title()

	/**
	 * Includes the content wrap start template file
	 *
	 * @hooked 		restaurants_begin_loop_content 		15
	 * @since 		1.0.0
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_wrap_begin( $item, $meta ) {

		$files = maybe_unserialize( $meta['menu-files'][0] );

		include restaurants_get_template( 'content-wrap-begin', 'loop' );

	} // loop_content_wrap_begin()

	/**
	 * Includes the content wrap end template file
	 *
	 * @hooked 		restaurants_end_loop_content 		90
	 * @since 		1.0.0
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_wrap_end( $item, $meta = array() ) {

		include restaurants_get_template( 'content-wrap-end', 'loop' );

	} // loop_content_wrap_end()

	/**
	 * Includes the search or sort template file
	 *
	 * @hooked 		restaurants_before_loop 		15
	 * @since 		1.0.0
	 * @param 		array 		$args 				The shortcode attributes
	 */
	public function loop_search_or_sort( $args ) {

		include restaurants_get_template( 'search-or-sort', 'loop' );

	} // loop_search_or_sort()

	/**
	 * Includes the list wrap start template file and sets the value of $class.
	 *
	 * If the taxonomyname shortcode attribute is used, it sets $class as the
	 * taxonomyname or taxonomynames. Otherwise, $class is blank.
	 *
	 * @hooked 		restaurants_before_loop 		15
	 * @since 		1.0.0
	 * @param 		array 			$args 			The shortcode attributes
	 */
	public function loop_wrap_begin( $args ) {

		if ( empty( $args['taxonomyname'] ) ) {

			$class = '';

		} elseif ( is_array( $args['taxonomyname'] ) ) {

			$class = str_replace( ',', ' ', $args['taxonomyname'] );

		} else {

			$class = $args['taxonomyname'];

		}

		include restaurants_get_template( 'wrap-begin', 'loop' );

	} // list_wrap_begin()

	/**
	 * Includes the list wrap end template file
	 *
	 * @hooked 		restaurants_after_loop 		10
	 * @since 		1.0.0
	 * @param 		array 		$args 		The shortcode attributes
	 */
	public function loop_wrap_end( $args ) {

		include restaurants_get_template( 'wrap-end', 'loop' );

	} // loop_wrap_end()

	/**
	 * Sets the class variable $settings
	 *
	 * @since 		1.0.0
	 */
	private function set_settings() {

		$this->settings = get_option( RESTAURANTS_SLUG . '-settings' );

	} // set_settings()

	/**
	 * Includes the single restaurant meta field
	 *
	 * @hooked 		restaurants_single_content 		30
	 * @since 		1.0.0
	 * @param 		array 		$meta 		The post metadata
	 */
	public function single_restaurant_meta_field( $meta ) {

		include restaurants_get_template( 'restaurant-meta-field', 'single' );

	} // single_restaurant_meta_field()

	/**
	 * Includes the single restaurant content
	 *
	 * @hooked 		restaurants_single_content 		25
	 * @since 		1.0.0
	 */
	public function single_restaurant_content() {

		include restaurants_get_template( 'restaurant-content', 'single' );

	} // single_restaurant_content()

	/**
	 * Includes the single restaurant post title
	 *
	 * @hooked 		restaurants_single_content 		15
	 * @since 		1.0.0
	 */
	public function single_restaurant_posttitle() {

		include restaurants_get_template( 'restaurant-posttitle', 'single' );

	} // single_restaurant_posttitle()

	/**
	 * Includes the single restaurant post title
	 *
	 * @hooked 		restaurants_single_content 		20
	 * @since 		1.0.0
	 */
	public function single_restaurant_subtitle( $meta ) {

		include restaurants_get_template( 'restaurant-subtitle', 'single' );

	} // single_restaurant_subtitle()

	/**
	 * Include the single restaurant thumbnail
	 *
	 * @hooked 		restaurants_single_content 		10
	 * @since 		1.0.0
	 */
	public function single_restaurant_thumbnail() {

		include restaurants_get_template( 'restaurant-thumbnail', 'single' );

	} // single_restaurant_thumbnail()

	/**
	 * Includes the restaurant website.
	 *
	 * @hooked 		restaurants_single_content 		30
	 * @since 		1.0.0
	 * @param 		array 		$meta 		The post metadata
	 */
	public function single_restaurant_website( $meta ) {

		include restaurants_get_template( 'restaurant-website', 'single' );

	} // single_restaurant_website()

	/**
	 * Returns a reference to this class. Used for removing
	 * actions and/or filters declared here.
	 *
	 * @see 		http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 * @since 		1.0.0
	 * @return 		object 		This class
	 */
	static function this() {

		return self::$_this;

	} // this()

} // class
