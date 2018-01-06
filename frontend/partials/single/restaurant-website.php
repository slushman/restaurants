<?php
/**
 * The template for displaying single post meta field data.
 *
 * @package Restaurants
 */

if ( empty( $meta['restaurant-url'][0] ) ) { return; }

?><li class="restaurant-url">
	<a href="<?php echo esc_url( $meta['restaurant-url'][0] ); ?>"><?php

		esc_html_e( 'Website', 'restaurants' );

	?></a>
</li>
