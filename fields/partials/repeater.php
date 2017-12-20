<?php

/**
 * Provides the markup for a repeater field
 *
 * Must include an multi-dimensional array with each field in it. The
 * field type should be the key for the field's attribute array.
 *
 * $fields['file-type']['all-the-field-attributes'] = 'Data for the attribute';
 *
 * @link       https://www.mysafemenu.com
 * @since      1.0.0
 *
 * @package    Restaurants
 * @subpackage Restaurants/views/fields
 */

?><ul class="repeaters"><?php

	if ( 0 !== $this->count ) {

		$field_ids = array_keys( $this->attributes['value'] );

	}

	for ( $i = 0; $i <= $this->count; $i++ ) {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'partials/repeater-set.php' );

	} // for

?></ul><!-- repeater -->
<div class="repeater-more">
	<span id="status"></span>
	<a class="button" href="#" id="add-repeater"><?php

		echo esc_html( $this->properties['labels']['add'], 'restaurants' );

	?></a>
</div><!-- .repeater-more -->
