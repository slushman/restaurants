<?php

/**
 * Defines all the code for a textarea form field.
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 * @package 	Restaurants\Fields
 */

namespace Restaurants\Fields;

class Textarea extends \Restaurants\Fields\Field {

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
		$this->set_settings( $args );

		$this->set_default_attributes();
		$this->set_default_textarea_attributes();
		$this->set_attributes( $args );
		$this->set_value( $args );
		$this->set_name_attribute();

		$this->set_default_properties();
		$this->set_properties( $args );

		$this->output_label();
		$this->output_field();
		$this->output_description();

	} // __construct()

	/**
	 * Includes the textarea field HTML file.
	 *
	 * @since 		1.0.0
	 */
	public function output_field() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/partials/textarea.php' );

	} // output_field()

	/**
	 * Sets default attributes specific to textarea fields.
	 *
	 * @since 		1.0.0
	 */
	protected function set_default_textarea_attributes() {

		$this->default_attributes['cols'] = 50;
		$this->default_attributes['rows'] = 10;

	} // set_default_textarea_attributes()

} // class
