<?php

/**
 * Defines all the code for an editor form field.
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 * @package 	Restaurants\Fields
 */

namespace Restaurants\Fields;

class Editor extends \Restaurants\Fields\Field {

	/**
	 * Class constructor.
	 *
	 * @since 		1.0.0
	 * @param 		string 		$context 			The field context. Options:
	 *                               					settings: plugin settings
	 *                               					metabox: in a metabox
	 *                               					widget: in widget form
	 * @param 		array 		$attributes 		The field attributes.
	 * @param 		array 		$properties 		The field properties.
	 */
	public function __construct( $context, $args ) {

		$this->set_context( $context );
		$this->set_setting_name( $args );
		$this->set_settings( $args );

		$this->set_default_attributes();
		$this->set_attributes( $args );
		$this->set_value( $args );
		$this->set_name_attribute();

		$this->set_default_properties();
		$this->set_default_editor_properties();
		$this->set_properties( $args );

		$this->output_label();
		$this->output_field();
		$this->output_description();

	} // __construct()

	/**
	 * Displays the WP Editor field.
	 *
	 * @since 		1.0.0
	 */
	public function output_field() {

		wp_editor( $this->attributes['value'], $this->attributes['id'], $this->properties['settings'] );

	} // output_field()

	/**
	 * Sets the default properties class variable.
	 *
	 * @since 		1.0.0
	 */
	protected function set_default_editor_properties() {

		$this->default_properties['settings'] = '';

	} // set_default_editor_properties()

} // class
