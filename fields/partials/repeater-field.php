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

$counter = ( $i === $this->count ? '%s' : $field_ids[$i] );

?><p class="wrap-field"><?php

	$type 		= '\Restaurants\Fields\\' . $field[3];
	$field_id 	= $field[4]['attributes']['id'];

	if ( isset( $this->attributes['value'][$counter][$field_id] ) ) {

		$field[4]['attributes']['value'] = $this->attributes['value'][$counter][$field_id];

	}

	if ( $i === $this->count ) {

		$field[4]['attributes']['disabled'] = 'disabled';

	}

	$field[4]['attributes']['name'] = $this->attributes['id'] . '[' . $counter . '][' . $field_id . ']';

	new $type( 'metabox', $field[4] );

?></p><?php

unset( $type );
unset( $field_id );
unset( $counter );
