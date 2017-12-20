<?php

/**
* The HTML for a fieldset beginning.
*/

?><fieldset<?php

	if ( ! empty( $this->properties['class-fieldset'] ) ) { echo ' class="' . esc_attr( $this->properties['class-fieldset'] ) . '"'; }
	if ( ! empty( $this->properties['role-fieldset'] ) ) { echo ' role="' . esc_attr( $this->properties['role-fieldset'] ) . '"'; }

?>>
