<?php

/**
 * Displays the menu files metabox
 *
 * @link       https://www.mysafemenu.com
 * @since      1.0.0
 *
 * @package    Restaurants
 * @subpackage Restaurants/classes/views
 */

//print_r( $this->meta );

$args['attributes']['id'] 					= 'menu-files';

$args['properties']['labels']['add'] 		= __( 'Add Menu', 'restaurants' );
$args['properties']['labels']['edit'] 		= __( 'Edit Menu', 'restaurants' );
$args['properties']['labels']['header'] 	= __( 'Menu Title', 'restaurants' );
$args['properties']['labels']['remove'] 	= __( 'Remove Menu', 'restaurants' );

$fields[0]['fieldtype'] 							= 'Text';
$fields[0]['args']['attributes']['id'] 				= 'menu-title';
$fields[0]['args']['attributes']['data']['title'] 	= '';
$fields[0]['args']['properties']['description'] 	= __( '', 'restaurants' );
$fields[0]['args']['properties']['label'] 			= __( 'Menu Title', 'restaurants' );

$fields[1]['fieldtype'] 							= 'File_Uploader';
$fields[1]['args']['attributes']['id'] 				= 'menu-url';
$fields[1]['args']['attributes']['type'] 			= 'url';
$fields[1]['args']['properties']['label'] 			= __( 'Menu File', 'restaurants' );
$fields[1]['args']['properties']['label-remove'] 	= __( 'Remove Menu', 'restaurants' );
$fields[1]['args']['properties']['label-upload'] 	= __( 'Upload/Choose Menu', 'restaurants' );

?><p><?php

new \Restaurants\Fields\Repeater( 'metabox', $args, $fields );

unset( $args );
unset( $fields );

?></p><?php




/*

$setatts['id'] 					= 'menu-files';
$setatts['labels']['add'] 		= __( 'Add Menu', 'restaurants' );
$setatts['labels']['edit'] 		= __( 'Edit Menu', 'restaurants' );
$setatts['labels']['header'] 	= __( 'Menu Name', 'restaurants' );
$setatts['labels']['remove'] 	= __( 'Remove Menu', 'restaurants' );

$field2['description'] 			= __( '', 'restaurants' );
$field2['fieldtype'] 			= 'text';
$field2['id'] 					= 'menu-name-field';
$field2['label'] 				= __( 'Menu Name', 'restaurants' );
$field2['name'] 				= 'menu-name-field';

$field1['data']['title'] 		= '';
$field1['fieldtype'] 			= 'text';
$field1['id'] 					= 'menu-url-field';
$field1['label'] 				= __( 'Menu File', 'restaurants' );
$field1['label-remove'] 		= __( 'Remove Menu', 'restaurants' );
$field1['label-upload'] 		= __( 'Upload/Choose Menu', 'restaurants' );
$field1['name'] 				= 'menu-url-field';
$field1['type'] 				= 'url';

$setatts['fields'] 				= array( $field1, $field2 );

$setatts 						= apply_filters( PLUGIN_NAME_SLUG . '-field-' . $setatts['id'], $setatts );

$count 							= 1;
$repeater 						= array();

if ( ! empty( $this->meta[$setatts['id']] ) ) {

	$repeater = maybe_unserialize( $this->meta[$setatts['id']][0] );

}

if ( ! empty( $repeater ) ) {

	$count = count( $repeater );

}

?><p><?php

include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/repeater.php' );
unset( $setatts );
unset( $field1 );
unset( $field2 );

?></p>
