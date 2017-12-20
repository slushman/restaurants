<?php

/**
 * Provides the markup for a section in the plugin settings.
 *
 * @since 			1.0.0
 * @package 		Restaurants\Admin
 */

?><p><?php

	if ( ! empty( $params['description'] ) ) {

		echo esc_html( $params['description'] );

	}

?></p>
