<?php

/**
 * Defines all the code for a repeater form field.
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 * @package 	Restaurants\Fields
 */

namespace Restaurants\Fields;

class Repeater extends \Restaurants\Fields\Field {

	/**
	 * The quantity of the repeater values.
	 *
	 * @var 		int
	 */
	var $count;

	/**
	 * The fields in the repeater.
	 *
	 * @var 		array
	 */
	var $fields;

	/**
	 * Class constructor.
	 *
	 * @since 		1.0.0
	 * @param 		string 		$context 			The field context. Options:
	 *                               					settings: plugin settings
	 *                               					metabox: in a metabox
	 *                               					widget: in widget form
	 * @param 		array 		$args 				The field arguments.
	 * 													Needs the following subarrays:
	 * 														attributes: attributes for the repeater itself
	 * 														properties: preties for the repeater itself
	 * 														fields: the fields used in this repeater
	 */
	public function __construct( $context, $args ) {

		$this->set_context( $context );
		$this->set_settings( $args );

		$this->set_default_attributes();
		$this->set_default_repeater_attributes();
		$this->set_attributes( $args );
		$this->set_value( $args );
		$this->set_name_attribute();

		$this->set_default_properties();
		$this->set_default_repeater_properties();
		$this->set_properties( $args );

		$this->set_fields( $args );

		$this->set_count();

		$this->output_label();
		$this->output_field();
		$this->output_description();

	} // __construct()

	/**
	 * Includes the repeater field HTML file.
	 *
	 * @since 		1.0.0
	 */
	public function output_field() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/partials/repeater.php' );

	} // output_field()

	/**
	 * Sets the count class variable.
	 *
	 * @since 		1.0.0
	 */
	protected function set_count() {

		$this->count = count( $this->attributes['value'] );

	} // set_count()

	/**
	 * Sets default attributes specifically for repeater fields.
	 *
	 * @since 		1.0.0
	 */
	protected function set_default_repeater_attributes() {

		$this->default_attributes['class'] = 'repeater';

	} // set_default_set_attributes()

	/**
	 * Sets default properties specifically for repeater fields.
	 *
	 * @since 		1.0.0
	 */
	protected function set_default_repeater_properties() {

		$this->default_properties['labels']['add'] 		= __( 'Add', 'restaurants' );
		$this->default_properties['labels']['edit'] 	= __( 'Edit', 'restaurants' );
		$this->default_properties['labels']['header'] 	= __( 'Name', 'restaurants' );
		$this->default_properties['labels']['remove'] 	= __( 'Remove', 'restaurants' );

	} // set_default_set_properties()

	/**
	 * Sets the $fields class variable.
	 *
	 * @since 		1.0.0
	 */
	protected function set_fields( $fields ) {

		$this->fields = $fields['fields'];

	} // set_fields()

} // class
