<?php

/**
* The HTML for a field label beginning.
* Used for the checkbox field.
*/

?><label <?php

	if ( ! empty( $this->properties['class-label'] ) ) { echo ' class="' . esc_attr( $this->properties['class-label'] ) . '"'; }

?> for="<?php echo esc_attr( $this->attributes['id'] ); ?>">
<span class="label <?php

	if ( ! empty( $this->properties['class-label-span'] ) ) { echo esc_attr( $this->properties['class-label-span'] ); }

?>">
