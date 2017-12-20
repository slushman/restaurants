<?php

/**
 * Provides the markup for a repeater field
 *
 * Must include an multi-dimensional array with each field in it. The
 * field type should be the key for the field's attribute array.
 *
 * $fields['file-type']['all-the-field-attributes'] = 'Data for the attribute';
 *
 * @link       https://www.mysafemenu.com
 * @since      1.0.0
 *
 * @package    Restaurants
 * @subpackage Restaurants/views/fields
 */

 if ( $i === $this->count ) {

	 $this->attributes['class'] .= ' hidden';

 }

?><li class="<?php echo esc_attr( $this->attributes['class'] ); ?>">
	<div class="handle">
		<span class="title-repeater"><?php echo esc_html( $this->properties['labels']['header'], 'restaurants' ); ?></span>
		<button aria-expanded="true" class="btn-edit" type="button">
			<span class="screen-reader-text"><?php echo esc_html( $this->properties['labels']['edit'], 'restaurants' ); ?></span>
			<span class="toggle-arrow"></span>
		</button>
	</div><!-- .handle -->
	<div class="repeater-content">
		<div class="wrap-fields"><?php

			foreach ( $this->fields as $field ) {

				include( plugin_dir_path( dirname( __FILE__ ) ) . 'partials/repeater-field.php' );

			} // foreach

		?></div>
		<div>
			<a class="link-remove" href="#">
				<span><?php

					echo esc_html( $this->properties['labels']['remove'], 'restaurants' );

				?></span>
			</a>
		</div>
	</div>
</li><!-- .repeater -->
