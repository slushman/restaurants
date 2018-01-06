<?php
/**
 * The template for displaying all single restaurant posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Employees
 */

$meta = get_post_custom( $post->ID );

/**
 * restaurants_before_single hook
 */
do_action( 'restaurants_before_single', $meta );

?><article class="wrap-restaurant"><?php

	/**
	 * restaurants_before_single_content hook
	 */
	do_action( 'restaurants_before_single_content', $meta );

		/**
		 * restaurants_single_content hook
		 *
		 * @hooked 		single_restaurant_thumbnail 		10
		 * @hooked 		single_restaurant_posttitle 		15
		 * @hooked 		single_restaurant_subtitle 			20
		 * @hooked 		single_restaurant_content 			25
		 * @hooked 		single_restaurant_meta_field 		30
		 */
		do_action( 'restaurants_single_content', '', $meta );

	/**
	 * restaurants_after_single_content hook
	 */
	do_action( 'restaurants_after_single_content', $meta );

?></article><!-- .wrap-employee --><?php

/**
 * restaurants_after_single hook
 */
do_action( 'restaurants_after_single', $meta );
