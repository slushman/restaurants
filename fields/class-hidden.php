<?php

/**
 * Defines all the code for a hidden form field.
 *
 * @link 		https://www.allergenmen.us
 * @since 		1.0.0
 * @package 	Restaurants\Fields
 */

namespace Restaurants\Fields;

class Hidden extends \Restaurants\Fields\Field {

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

		$this->set_default_hidden_attributes();
		$this->set_attributes( $args );
		$this->set_value( $args );
		$this->set_name_attribute();

		$this->output_field();

	} // __construct()

	/**
	 * Includes the hidden field HTML file.
	 *
	 * @since 		1.0.0
	 */
	public function output_field() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/partials/hidden.php' );

	} // output_field()

	/**
	 * Sets the default attributes for the hidden field type.
	 *
	 * @since 		1.0.0
	 */
	protected function set_default_hidden_attributes() {

		$this->default_attributes['id'] 	= '';
		$this->default_attributes['name'] 	= '';
		$this->default_attributes['type'] 	= 'hidden';
		$this->default_attributes['value'] 	= '';

	} // set_default_hidden_attributes()

} // class
