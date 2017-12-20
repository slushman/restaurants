<?php

/**
* The HTML for a select field.
*/

?><select <?php

	foreach ( $this->attributes as $key => $value ) :

		if ( 'value' === $key ) :

			continue;

		elseif ( 'data' === $key ) :

			foreach ( $this->attributes['data'] as $key => $value ) :

				echo 'data-' . $key . '="' . esc_attr( $value ) . '" ';

			endforeach;

		elseif ( 'aria-label' === $key ) :

			echo 'aria-label="' . wp_kses( $value, array( 'code' => array() ) ) . '" ';

		else :

			echo $key . '="' . esc_attr( $value ) . '" ';

		endif;

	endforeach;

	?>><?php

if ( ! empty( $this->properties['blank'] ) ) {

	?><option value=""><?php echo wp_kses( $this->properties['blank'], array( 'code' => array() ) ); ?></option><?php

}

if ( ! empty( $this->options ) ) :

	foreach ( $this->options as $option ) :

		$label = ( is_array( $option ) ? $option['label'] : $option );
		$value = ( is_array( $option ) ? $option['value'] : sanitize_title( $option ) );

		?><option
			value="<?php echo esc_attr( $value ); ?>" <?php

			selected( $this->attributes['value'], $value ); ?>><?php

			echo wp_kses( $label, array( 'code' => array() ) );

		?></option><?php

	endforeach;

endif;

?></select>
