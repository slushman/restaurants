<?php
/**
 * The template for displaying single post meta field data.
 *
 * @package Restaurants
 */

if ( empty( $meta['menu-instructions'][0] ) ) { return; }

?><h2><?php esc_html_e( 'Allergen Menu Instructions' ); ?></h2>
<p class="menu-instructions"><?php

	echo esc_html( $meta['menu-instructions'][0] );

?></p>
