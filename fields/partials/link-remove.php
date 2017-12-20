<?php

/**
* The HTML for a remove link.
*/

?><a href="#" class="<?php echo esc_attr( $this->set_class_by_value( 'remove' ) ); ?>" id="remove-file"><?php

	echo wp_kses( $this->properties['label-remove'], array( 'code' => array() ) );

?></a>
