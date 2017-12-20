<?php

/**
 * Defines all the code for a select form field.
 *
 * @link 		https://www.allergenmen.us
 * @since 		1.0.0
 * @package 	Restaurants\Fields
 */

namespace Restaurants\Fields;

class Select extends \Restaurants\Fields\Field {

	/**
	 * The options for the select menu.
	 *
	 * @var 		array 		The selection options.
	 */
	var $options;

	/**
	 * Class constructor.
	 *
	 * @since 		1.0.0
	 * @param 		string 		$context		The field context.
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
		$this->set_default_select_attributes();
		$this->set_attributes( $args );
		$this->set_name_attribute();
		$this->set_value( $args );

		$this->set_default_properties();
		$this->set_default_select_properties();
		$this->set_properties( $args );

		$this->set_options( $args );

		$this->output_label();
		$this->output_field();
		$this->output_description();
		$this->output_alert();

	} // __construct()

	/**
	 * Includes the select field HTML file.
	 *
	 * @since 		1.0.0
	 */
	public function output_field() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/partials/select.php' );

	} // output_field()

	/**
	 * Sets default attributes specific to select fields.
	 *
	 * @since 		1.0.0
	 */
	protected function set_default_select_attributes() {

		$this->default_attributes['aria-label'] = __( 'Select an option.', 'restaurants' );
		$this->default_attributes['type'] 		= '';

	} // set_default_select_attributes()

	/**
	 * Sets default properties specific to select fields.
	 *
	 * @since 		1.0.0
	 */
	protected function set_default_select_properties() {

		$this->default_properties['blank'] = __( '- Select -', 'restaurants' );
		$this->default_properties['error'] = __( 'There was an error with the options for this field.', 'restaurants' );

	} // set_default_select_properties()

	/**
	 * Sets the options for the select field.
	 *
	 * Options can be structured two ways:
	 * 		array( ''one,' two', 'three' );
	 * 		array( array( 'label => 'one', 'value' => 'ONE' ) );
	 *
	 * The first way creates both the labels and values with the individual array items.
	 * The second way creates separate labels and values from the subarray items.
	 *
	 * @param 		array 		$args 		The field arguments.
	 */
	protected function set_options( $args ) {

		$this->options = $args['options'];

	} // set_options()

} // class
