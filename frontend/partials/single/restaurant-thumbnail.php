<?php
/**
 * The view for the featured image used in the single-postttypename template
 */

if ( ! has_post_thumbnail() ) { return; }

$thumb_atts['class'] 	= 'alignleft img-restaurant photo';
$thumb_atts['itemtype'] = 'image';

/**
 * The restaurants_single_post_featured_image_attributes filter.
 *
 * Allows for changing the featured image attributes.
 *
 * @var 		array 		$thumb_atts 		The featured image attributes.
 */
$thumb_atts = apply_filters( 'restaurants_single_post_featured_image_attributes', $thumb_atts );

the_post_thumbnail( 'medium', $thumb_atts );
