<?php
/**
 * The view for the content link start used in the loop
 */

?><a class="restaurant-list-link<?php

	if ( 1 < count( $files ) ) {

		echo esc_attr( ' restaurant-title-multiple-menus' );

	}

?>"<?php

	if ( 1 === count( $files ) ) {

		foreach ( $files as $file ) :

			?> href="<?php echo esc_url( $file['menu-url'] ); ?>"<?php

		endforeach;

	}

?>>
