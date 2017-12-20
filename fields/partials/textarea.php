<?php

/**
* The HTML for a textarea field.
*/

?><textarea <?php

foreach ( $this->attributes as $key => $value ) :

	if ( 'data' === $key ) :

		foreach ( $this->attributes['data'] as $key => $value ) :

			echo 'data-' . $key . '="' . esc_attr( $value ) . '" ';

		endforeach;

	else :

		echo $key . '="' . esc_attr( $value ) . '" ';

	endif;

endforeach;

?>/><?php

echo esc_textarea( $atts['value'] );

?></textarea>
