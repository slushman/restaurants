<?php

/**
 * Methods for querying posts.
 *
 * @link 		https://www.mysafemenu.com
 * @since 		1.0.0
 * @package		Restaurants\Frontend
 * @author 		Slushman <chris@slushman.com>
 */

namespace Restaurants\Frontend;

class Query_Posts {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {} // __construct()

	/**
	 * Returns a cache name based on the attributes.
	 *
	 * @since 		1.0.0
	 * @param 		array 		$args 			The WP_Query args
	 * @param 		string 		$cache 			Optional cache name
	 * @return 		string 						The cache name
	 */
	private function get_cache_name( $args, $cache = '' ) {

		if ( empty( $args ) ) { return ''; }

		$return = RESTAURANTS_SLUG . '_plugin_name';

		if ( ! empty( $cache ) ) {

			$return = RESTAURANTS_SLUG . $cache . '_plugin_name';

		}

		if ( ! empty( $args['taxonomyname'] ) ) {

			$return = RESTAURANTS_SLUG . $cache . $args['taxonomyname'] . '_plugin_name';

		}

		return $return;

	} // get_cache_name()

	/**
	 * Returns a post object of restaurant posts
	 *
	 * Check for cache first, if it exists, returns that
	 * If not, gets the ordered posts, collects their IDS,
	 * sets those as post__not_in for the unordered posts.
	 * Gets the unordered posts. Merges both into one array
	 *
	 * @since 		1.0.0
	 * @param 		array 			$params 		An array of optional parameters
	 * @param 		string|int 		$cache 			String to create a new cache of
	 *                                 					posts | int = 0 means no cache
	 * @param 		string 			$type 			The name of the post type.
	 * @return 		object 						A post object
	 */
	public function query( $params = array(), $cache = '', $type = 'restaurant' ) {

		$return 	= '';

		if ( 0 !== $cache ) {

			$cache_name = $this->get_cache_name( $params, $cache );
			$return 	= wp_cache_get( $cache_name, RESTAURANTS_SLUG . '_posts' );

		}

		if ( false === $return ) {

			$args 	= apply_filters( 'restaurants_query_args', $this->set_args( $type, $params ) );
			$query 	= new \WP_Query( $args );

			if ( is_wp_error( $query ) && empty( $query ) ) {

				$options 	= get_option( RESTAURANTS_SETTINGS );
				$return 	= $options['none-found-message'];

			} else {

				wp_cache_set( $cache_name, $query, RESTAURANTS_SLUG . '_posts', 5 * MINUTE_IN_SECONDS );

				$return = $query;

			}

		}

		return $return;

	} // query()

	/**
	 * Sets the args array for a WP_Query call
	 *
	 * @since 		1.0.0
	 * @param 		string 		$type 			The name of the post type.
	 * @param 		array 		$params 		Array of shortcode parameters
	 * @return 		array 						An array of parameters for WP_Query
	 */
	private function set_args( $type, $params ) {

		if ( empty( $params ) ) { return; }

		$args = array();

		$args['no_found_rows']				= true;
		$args['order'] 						= $params['order'];
		$args['post_type'] 					= $type;
		$args['post_status'] 				= 'publish';
		$args['posts_per_page'] 			= absint( $params['quantity'] );
		$args['update_post_term_cache'] 	= false;

		unset( $params['order'] );
		unset( $params['quantity'] );
		unset( $params['listview'] );
		unset( $params['singleview'] );

		if ( empty( $params ) ) { return $args; }

		if ( ! empty( $params['taxonomyname'] ) ) {

			$args['tax_query'][0]['field'] 		= 'slug';
			$args['tax_query'][0]['taxonomy'] 	= 'taxonomyname';
			$args['tax_query'][0]['terms'] 		= $params['taxonomyname'];

			unset( $args['taxonomyname'] );

		}

		$args = wp_parse_args( $params, $args );

		return $args;

	} // set_args()

} // class
