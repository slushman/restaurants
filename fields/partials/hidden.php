<?php

/**
* The HTML for a hidden field.
*/

?><input <?php

foreach ( $this->attributes as $key => $value ) :

	if ( 'data' === $key ) :

		foreach ( $this->attributes['data'] as $key => $value ) :

			echo 'data-' . $key . '="' . esc_attr( $value ) . '" ';

		endforeach;

	else :

		echo $key . '="' . esc_attr( $value ) . '" ';

	endif;

endforeach;

?>/>
