<?php

/**
* The HTML for a checkbox field.
*
* Do not reuse the Hidden field class. The value of this hidden field needs to be 0, but
* the hidden field class sets the hidden field to saved value from the database.
*/

?><input type="hidden" value="0" name="<?php echo esc_attr( $this->attributes['name'] ); ?>" />
<input <?php

foreach ( $this->attributes as $key => $value ) :

	if ( 'data' === $key ) :

		foreach ( $this->attributes['data'] as $key => $value ) :

			echo 'data-' . $key . '="' . esc_attr( $value ) . '" ';

		endforeach;

	else :

		echo $key . '="' . esc_attr( $value ) . '" ';

	endif;

endforeach;

	if ( isset( $this->settings[$this->attributes['id']] ) ) {

		$setting = $this->settings[$this->attributes['id']];

	} else {

		$setting = '';

	}

	checked( $this->attributes['value'], $setting, true );

?>/>
