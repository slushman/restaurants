<?php

/**
 * The HTML for an image preview div.
 */

?><div class="<?php echo esc_attr( $preview_class ); ?>" id="<?php echo esc_attr( $this->attributes['id'] . '-img' ); ?>" style="background-image:url(<?php echo esc_url( $thumbnail ); ?>);"></div>
