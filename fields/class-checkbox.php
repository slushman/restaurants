<?php

/**
 * Defines all the code for a checkbox form field.
 *
 * @link 		https://www.allergenmen.us
 * @since 		1.0.0
 * @package 	Restaurants\Fields
 */

namespace Restaurants\Fields;

class Checkbox extends \Restaurants\Fields\Field {

	/**
	 * Class constructor.
	 *
	 * @since 		1.0.0
	 * @param 		string 		$context 		The field context. Options:
	 *                               				settings: plugin settings
	 *                               				metabox: in a metabox
	 *                               				widget: in widget form
	 * @param 		array 		$args 			The field arguments.
	 */
	public function __construct( $context, $args ) {

		$this->set_context( $context );
		$this->set_setting_name( $args );
		$this->set_settings( $args );

		$this->set_default_attributes();
		$this->set_default_checkbox_attributes();
		$this->set_attributes( $args );
		$this->set_value( $args );
		$this->set_name_attribute();

		$this->set_default_properties();
		$this->set_default_checkbox_properties();
		$this->set_properties( $args );

		$this->output_label_begin();
		$this->output_field();
		$this->output_description_span();
		$this->output_alert();
		$this->output_label_end();

	} // __construct()

	/**
	 * Includes the checkbox field HTML file.
	 *
	 * @since 		1.0.0
	 */
	public function output_field() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/partials/checkbox.php' );

	} // output_field()

	/**
	 * Sets default attributes specifically for checkbox fields.
	 *
	 * @since 		1.0.0
	 */
	protected function set_default_checkbox_attributes() {

		$this->default_attributes['type'] 	= 'checkbox';
		$this->default_attributes['value'] 	= 1;

	} // set_default_checkbox_attributes()

	/**
	 * Sets default properties specifically for checkbox fields.
	 *
	 * @since 		1.0.0
	 */
	protected function set_default_checkbox_properties() {

		$this->default_properties['class-label'] 		= 'checkbox-label';
		$this->default_properties['class-label-span'] 	= 'checkbox-label-text';

	} // set_default_checkbox_properties()

} // class
