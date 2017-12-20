<?php

/**
* The HTML for a field alert in a paragraph tag.
*/

?><p class="field-alert"><?php echo wp_kses( $this->properties['alert'], array( 'code' => array() ) ); ?></p>
