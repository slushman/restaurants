<?php
/**
 * The template for displaying single post meta field data.
 *
 * @package Restaurants
 */

if ( empty( $meta['menu-files'][0] ) ) { return; }

$menus = maybe_unserialize( $meta['menu-files'][0] );

foreach ( $menus as $menu ) :

	?><li class="allergen-menu">
		<a class="allergen-menu-link" href="<?php echo esc_url( $menu['menu-url'] ); ?>"><?php

			echo esc_html( $menu['menu-title'] );

		?></a>
	</li><?php

endforeach;
