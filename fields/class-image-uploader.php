<?php

/**
 * Defines all the code for an image uploader form field.
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 * @package 	Restaurants\Fields
 */

namespace Restaurants\Fields;

class Image_Uploader extends \Restaurants\Fields\Field {

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
		$this->set_default_image_uploader_attributes();
		$this->set_attributes( $args );
		$this->set_value( $args );
		$this->set_name_attribute();

		$this->set_default_properties();
		$this->set_default_file_uploader_properties();
		$this->set_properties( $args );

		$this->output_field_wrap_begin();
		$this->output_label();
		$this->output_image_preview();
		$this->output_field();
		$this->output_link_upload();
		$this->output_link_remove();
		$this->output_field_wrap_end();
		$this->output_description();

	} // __construct()

	/**
	 * Includes the image uploader field HTML file.
	 *
	 * @since 		1.0.0
	 */
	public function output_field() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/partials/text.php' );

	} // output_field()

	/**
	 * Includes the image preview HTML file.
	 *
	 * @since 		1.0.0
	 */
	protected function output_image_preview() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/partials/image-preview.php' );

	} // output_image_preview()

	/**
	 * Includes the remove link HTML file.
	 *
	 * @since 		1.0.0
	 */
	protected function output_link_remove() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/partials/link-remove.php' );

	} // output_link_remove()

	/**
	 * Includes the upload link HTML file.
	 *
	 * @since 		1.0.0
	 */
	protected function output_link_upload() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/partials/link-upload.php' );

	} // output_link_upload()

	/**
	 * Sets a class based on the field value.
	 *
	 * Hide is returned for these two conditions:
	 * 		If value is empty and the context is remove.
	 *   	If value is not empty and context is upload.
	 *
	 * @since 		1.0.0
	 * @param 		string 		$context 		The context decides if a class is returned or not.
	 *                              				remove: returns the hide class if the value is empty.
	 *                              				upload: return the hide class if the value is not empty.
	 * @return 		string 						"Hide" or blank.
	 */
	protected function set_class_by_value( $context ) {

		if ( ( empty( $this->attributes['value'] ) && 'remove' === $context ) || ! empty( $this->attributes['value'] ) && 'upload' === $context ) {

			return 'hide';

		} else {

			return '';

		}

	} // set_class_by_value()

	protected function set_default_file_uploader_properties() {

		$this->default_attributes['class'] = 'image-upload-preview';

	} // set_default_file_uploader_properties()

	/**
	 * Sets the image preview source based on the value of the field.
	 *
	 * @since 		1.0.0
	 */
	protected function set_image_preview() {

		//

	} // set_image_preview()

} // class
