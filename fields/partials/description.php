<?php

/**
* The HTML for a field description in a paragraph tag.
*/

?><p class="description"><?php

	echo wp_kses( $this->properties['description'], array( 'code' => array() ) );

?></p>
