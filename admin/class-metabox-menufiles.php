<?php
/**
 * The metabox-specific functionality of the plugin.
 *
 * @link 		https://www.mysafemenu.com
 * @since 		1.0.0
 * @package 	Restaurants\Admin
 * @author 		Slushman <chris@slushman.com>
 */

namespace Restaurants\Admin;

class Metabox_Menufiles extends \Restaurants\Admin\Metabox {

	/**
	 * Initialize the class and set its properties.
	 *
	 * Fields used within repeaters get saved individually with arrays as values.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->set_nonce( 'nonce_restaurants_menufiles' );
		$this->set_post_type( 'restaurant' );

		$repeater['attributes']['id'] 					= 'menu-files';
		$repeater['properties']['labels']['add'] 		= __( 'Add Menu', 'restaurants' );
		$repeater['properties']['labels']['edit'] 		= __( 'Edit Menu', 'restaurants' );
		$repeater['properties']['labels']['header'] 	= __( 'Menu Title', 'restaurants' );
		$repeater['properties']['labels']['remove'] 	= __( 'Remove Menu', 'restaurants' );

		$field0['attributes']['id'] 			= 'menu-title';
		$field0['attributes']['data']['title'] 	= '';
		$field0['properties']['description'] 	= __( '', 'restaurants' );
		$field0['properties']['label'] 			= __( 'Menu Title', 'restaurants' );

		$field1['attributes']['id'] 			= 'menu-url';
		$field1['attributes']['type'] 			= 'url';
		$field1['properties']['label'] 			= __( 'Menu File', 'restaurants' );
		$field1['properties']['label-remove'] 	= __( 'Remove Menu', 'restaurants' );
		$field1['properties']['label-upload'] 	= __( 'Upload/Choose Menu', 'restaurants' );

		$repeater['fields'][0] = array( 'menu-title', 'text', '', 'Text', $field0 );
		$repeater['fields'][1] = array( 'menu-url', 'url', '', 'File_Uploader', $field1 );

		$fields[] = array( 'menu-files', 'repeater', '', 'Repeater', $repeater );

		$this->set_fields( $fields );

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters related to this class.
	 *
	 * @hooked 		init
	 * @since 		1.0.0
	 */
	public function hooks() {

		add_action( 'add_meta_boxes', 			array( $this, 'add_metaboxes' ), 10, 1 );
		add_action( 'save_post', 				array( $this, 'validate_meta' ), 10, 2 );
		add_action( 'edit_form_after_title', 	array( $this, 'promote_metaboxes' ), 10, 1 );
		add_action( 'add_meta_boxes', 			array( $this, 'set_meta' ), 10, 1 );

	} // hooks()

	/**
	 * Registers metaboxes with WordPress
	 *
	 * @hooked 		add_meta_boxes
	 * @since 		1.0.0
	 * @access 		public
	 * @param 		object 			$post 			The post object.
	 */
	public function add_metaboxes( $post ) {

		add_meta_box(
			'restaurants_menufiles',
			esc_html__( 'Menu Files', 'restaurants' ),
			array( $this, 'metabox' ),
			'restaurant',
			'side',
			'default',
			array(
				//'file' => 'menufiles'
			)
		);

	} // add_metaboxes()

} // class
