<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Restaurants
 * @subpackage Restaurants/classes/loop-views
 */

/**
 * restaurants_before_loop hook
 *
 * @hooked 		loop_wrap_begin 		10
 * @hooked 		search_or_sort 			15
 */
do_action( 'restaurants_before_loop', $args );

$i = 0;

while ( $items->have_posts() ) :

	$item 		= $items->the_post();
	$meta 		= get_post_custom( get_the_ID() );
	$files 		= maybe_unserialize( $meta['menu-files'][0] );

	if ( empty( $meta['menu-files'][0] ) ) { continue; }

	$title 		= get_the_title();
	$letter 	= substr( $title, 0, 1 );

	if ( is_numeric( $letter ) ) {

		$capped = 'Nums';

	} /*elseif ( empty( $meta['menu-files'][0] ) /*&& empty( $meta['menu-files'] ) ) {

		$capped = 'None';

	}*/ else {

		$capped = strtoupper( $letter );

	}

	if ( empty( $char ) ) :

		$char = $capped;

		include plugin_dir_path( dirname( __FILE__ ) ) . 'loop/sorting-begin.php';

	elseif ( $capped != $char ) :

		$char = $capped;

		include plugin_dir_path( dirname( __FILE__ ) ) . 'loop/sorting-middle.php';

	endif;

	/**
	 * restaurants_begin_loop_content action hook
	 *
	 * @hooked 		loop_content_wrap_begin 					15
	 * @hooked 		loop_content_link_single_file_begin 		20
	 */
	do_action( 'restaurants_begin_loop_content', $item, $meta );

	/**
	 * restaurants_loop_content action hook
	 *
	 * @hooked 		loop_content_title 		15
	 */
	do_action( 'restaurants_loop_content', $item, $meta );

	/**
	 * restaurants_end_loop_content action hook
	 *
	 * @hooked 		loop_content_link_single_file_end 		10
	 *
	 * @hooked 		loop_content_wrap_end 					90
	 */
	do_action( 'restaurants_end_loop_content', $item, $meta );

	if ( 9 === $i ) {

		include plugin_dir_path( dirname( __FILE__ ) ) . 'loop/link-to-top.php';

	}

	unset( $capped );
	unset( $letter );
	unset( $meta );
	unset( $title );
	$i++;

endwhile;

/**
 * restaurants_after_loop hook
 *
 * @hooked 		loop_wrap_end 					10
 */
do_action( 'restaurants_after_loop', $args );
