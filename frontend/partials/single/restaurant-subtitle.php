<?php
/**
 * The template for displaying single post subtitle.
 *
 * @package Restaurants
 */

if ( empty( $meta['subtitle'][0] ) ) { return; }

?><h2 class="<?php echo esc_attr( 'subtitle' ); ?>"><?php

	esc_html_e( $meta['subtitle'][0] );

?></h2>
