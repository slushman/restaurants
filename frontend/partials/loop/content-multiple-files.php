<?php
/**
 * The view for the multiple menu files.
 */

?><ul class="menu-files"><?php

	foreach ( $files as $file ) :

		?><li class="menu-file">
			<a class="menu-file-link" href="<?php echo esc_url( $file['menu-url'] ); ?>"><?php

				echo esc_html( $file['menu-title'] );

			?></a>
		</li><?php

	endforeach;

?></ul><!-- .multiple-files -->
