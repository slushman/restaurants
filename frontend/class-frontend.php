<?php

namespace Restaurants\Frontend;

/**
 * Returns the requested SVG
 *
 * @param 	string 		$svg 		The name of the icon to return
 * @param 	string 		$link 		URL to link from the SVG
 *
 * @return 	mixed 					The SVG code
 */
function restaurants_get_svg( $svg ) {

	if ( empty( $svg ) ) { return; }

	$list = \Restaurants\Frontend\Frontend::get_svg_list();

	return $list[$svg];

} // restaurants_get_svg()

/**
 * Returns the path to a template file
 *
 * Looks for the file in these directories, in this order:
 * 		Current theme
 * 		Parent theme
 * 		Current theme plugin-name folder
 * 		Parent theme plugin-name folder
 * 		Current theme templates folder
 * 		Parent theme templates folder
 * 		Current theme partials folder
 * 		Parent theme partials folder
 * 		This plugin, frontend partials folder
 *
 * To use a custom list template in a theme, copy the
 * file from classes/views into a folder in your theme. The
 * folder can be named "plugin-name", "templates", or "views".
 * Customize the files as needed, but keep the file name as-is. The
 * plugin will automatically use your custom template file instead
 * of the ones included in the plugin.
 *
 * @param 	string 		$name 			The name of a template file
 * @param 	string 		$location 		The subfolder containing the view
 *
 * @return 	string 						The path to the template
 */
function restaurants_get_template( $name, $location = '' ) {

	$template = '';

	$locations[] = "{$name}.php";
	$locations[] = "/plugin-name/{$name}.php";
	$locations[] = "/templates/{$name}.php";
	$locations[] = "/partials/{$name}.php";

	/**
	 * Filter the locations to search for a template file
	 *
	 * @param 	array 		$locations 			File names and/or paths to check
	 */
	$locations 	= apply_filters( 'restaurants_template_paths', $locations );
	$template 	= locate_template( $locations, TRUE );

	if ( empty( $template ) ) {

		if ( empty( $location ) ) {

			$template = plugin_dir_path( dirname( __FILE__ ) ) . 'frontend/partials/' . $name . '.php';

		} else {

			$template = plugin_dir_path( dirname( __FILE__ ) ) . 'frontend/partials/' . $location . '/' . $name . '.php';

		}

	}

	return $template;

} // restaurants_get_template()

/**
 * The frontend functionality of the plugin.
 *
 * @link 			https://www.slushman.com
 * @since 			1.0.0
 * @package 		Restaurants\Frontend
 * @author 			Slushman <chris@slushman.com>
 */

class Frontend {

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;

	/**
	 * The plugin settings.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$settings 		The plugin settings.
	 */
	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->set_settings();
		$this->set_meta();

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters related to this class.
	 *
	 * @hooked 		init
	 * @since 		1.0.0
	 */
	public function hooks() {

		/**
		 * Action instead of template tag.
		 *
		 * do_action( 'listrestaurants' );
		 * 		or
		 * echo apply_filters( 'listrestaurants' );
		 *
		 * @link 	http://nacin.com/2010/05/18/rethinking-template-tags-in-plugins/
		 */
		add_action( 'listrestaurants', 		array( $this, 'shortcode' ) );
		add_action( 'wp_enqueue_scripts', 	array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', 	array( $this, 'enqueue_scripts' ) );

		//add_filter( 'single_template', 		array( $this, 'single_cpt_template' ), 11 );
		add_filter( 'posts_fields', 		array( $this, 'create_temp_column' ), 10, 2 );
		add_filter( 'posts_orderby', 		array( $this, 'sort_by_temp_column' ), 10, 2 );
		add_filter( 'the_content', 			array( $this, 'add_restaurant_links' ), 10, 1 );
		add_filter( 'the_content', 			array( $this, 'add_restaurant_menu_instructions' ), 10, 1 );

		add_shortcode( 'listrestaurants', 	array( $this, 'shortcode' ) );



	} // hooks()

	/**
	 * Displays the restaurant links at the bottom of the content.
	 *
	 * @param 		mixed 		$content 		The post content.
	 * @return 		mixed 						The post content plus the links.
	 */
	public function add_restaurant_links( $content ) {

		if ( ! is_singular( 'restaurant' ) ) { return $content; }

		ob_start();

		$meta = get_post_custom( get_the_ID() );

		echo $content;

		include restaurants_get_template( 'restaurant-links-begin', 'single' );

		include restaurants_get_template( 'restaurant-website', 'single' );

		include restaurants_get_template( 'restaurant-allergen-menus', 'single' );

		include restaurants_get_template( 'restaurant-links-end', 'single' );

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // add_restaurant_links()

	/**
	 * Displays the restaurant website link at the bottom of the content.
	 *
	 * @param 		mixed 		$content 		The post content.
	 * @return 		mixed 						The post content plus the website link.
	 */
	public function add_restaurant_website( $content ) {

		if ( ! is_singular( 'restaurant' ) ) { return $content; }

		ob_start();

		$meta = get_post_custom( get_the_ID() );

		echo $content;

		include restaurants_get_template( 'restaurant-website', 'single' );

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // add_restaurant_website()

	/**
	 * Displays the restaurant allergen menu links at the bottom of the content.
	 *
	 * @param 		mixed 		$content 		The post content.
	 * @return 		mixed 						The post content plus the allergen menu links.
	 */
	public function add_restaurant_allergen_menus( $content ) {

		if ( ! is_singular( 'restaurant' ) ) { return $content; }

		ob_start();

		$meta = get_post_custom( get_the_ID() );

		echo $content;

		include restaurants_get_template( 'restaurant-allergen-menus', 'single' );

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // add_restaurant_allergen_menus()

	/**
	 * Displays the restaurant allergen menu instructions at the bottom of the content.
	 *
	 * @param 		mixed 		$content 		The post content.
	 * @return 		mixed 						The post content plus the allergen menu instructions.
	 */
	public function add_restaurant_menu_instructions( $content ) {

		if ( ! is_singular( 'restaurant' ) ) { return $content; }

		ob_start();

		$meta = get_post_custom( get_the_ID() );

		echo $content;

		include restaurants_get_template( 'restaurant-menu-instructions', 'single' );

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // add_restaurant_menu_instructions()

	/**
	 * Creates a new column to sort SQL queries by.
	 *
	 * @hooked 		posts_fields
	 * @since 		1.0.0
	 * @param 		string 		$fields 		The current fields statement.
	 * @return 		string 						The modified fields statement.
	 */
	public function create_temp_column( $fields, $query ) {

		if ( 'restaurant' !== $query->query['post_type'] ) { return $fields; }

		global $wpdb;

		$matches = 'The';
		$has_the = " CASE
			WHEN $wpdb->posts.post_title regexp( '^($matches)[[:space:]]' )
				THEN trim(substr($wpdb->posts.post_title from 4))
			ELSE $wpdb->posts.post_title
				END AS title2";

		if ( $has_the ) {

			$fields .= ( preg_match( '/^(\s+)?,/', $has_the ) ) ? $has_the : ", $has_the";

		}

		return $fields;

	} // create_temp_column()

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @hooked 		wp_enqueue_scripts
	 * @since 		1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( RESTAURANTS_SLUG, plugin_dir_url( __FILE__ ) . 'css/restaurants.css', array(), RESTAURANTS_VERSION, 'all' );

	} // enqueue_styles()

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @hooked 		wp_enqueue_scripts
	 * @since 		1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( RESTAURANTS_SLUG, plugin_dir_url( __FILE__ ) . 'js/restaurants-frontend.min.js', array( 'jquery' ), RESTAURANTS_VERSION, true );

	} // enqueue_scripts()

	/**
	 * Sets the class variable $options
	 *
	 * @since 		1.0.0
	 */
	public function set_meta() {

		global $post;

		if ( empty( $post ) ) { return; }
		if ( 'restaurant' !== $post->post_type ) { return; }

		$this->meta = get_post_custom( $post->ID );

	} // set_meta()

	/**
	 * Sets the class variable $settings.
	 *
	 * @since 		1.0.0
	 */
	private function set_settings() {

		$this->settings = get_option( RESTAURANTS_SLUG . '-settings' );

	} // set_settings()

	/**
	 * Displays the output for the listrestaurants shortcode.
	 *
	 * @hooked 		add_shortcode
	 * @since 		1.0.0
	 * @param 		array 		$atts 			Shortcode attributes
	 * @return 		mixed 		$output 		Output of the buffer
	 */
	public function shortcode( $atts = array() ) {

		ob_start();

		$defaults['loop-template'] 	= RESTAURANTS_SLUG . '-loop';
		$defaults['order'] 			= 'ASC';
		$defaults['orderby'] 		= 'title';
		$defaults['quantity'] 		= 300;
		$defaults['show'] 			= '';
		$args						= shortcode_atts( $defaults, $atts, 'listrestaurants' );
		$shared 					= new \Restaurants\Frontend\Query_Posts();
		$items 						= $shared->query( $args );
		$items 						= apply_filters( 'after_get_restaurants', $items );

		if ( is_array( $items ) || is_object( $items ) ) {

			include restaurants_get_template( 'restaurants-loop', 'loop' );

		} else {

			echo $items;

		}

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // shortcode()

	/**
	 * Adds a default single employee template to the template hierarchy.
	 *
	 * @see 	https://developer.wordpress.org/themes/basics/template-hierarchy/
	 *
	 * @param 	string 		$template 		The name of the template
	 * @return 	mixed 						The single template
	 */
	public function single_cpt_template( $template ) {

		global $post;

		$return = $template;

		if ( 'restaurant' == $post->post_type ) {

			$return = restaurants_get_template( 'single-restaurant', 'single' );

		}

		return $return;

	} // single_cpt_template()

	/**
	 * Sorts the orderby parameter for WP_Query by the temp column.
	 *
	 * @hooked 		posts_orderby
	 * @since 		1.0.0
	 * @param 		string 		$orderby 		The current orderby statement.
	 * @return 		string 						The modified orderby statement.
	 */
	public function sort_by_temp_column( $orderby, $query ) {

		if ( 'restaurant' !== $query->query['post_type'] ) { return $orderby; }

		$custom_orderby = " UPPER(title2) ASC";

		if ( $custom_orderby ) {

			$orderby = $custom_orderby;

		}

		return $orderby;

	} // sort_by_temp_column()

} // class
