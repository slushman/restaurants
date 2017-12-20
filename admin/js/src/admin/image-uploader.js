/**
 * Enables image uploader field interaction with Media Library.
 */
(function( $ ) {

	'use strict';

	$(function() {

		let field, upload, remove;

		field = $( '[data-id="image-file"]' );
		if ( !field ) { return; }

		remove = $( '#remove-file' );
		if ( !remove ) { return; }

		upload = $( '#upload-file' );
		if ( !upload ) { return; }

		//Opens the Media Library, assigns chosen file URL to input field, switches links
		upload.on( 'click', function( e ) {

			// Stop the anchor's default behavior
			e.preventDefault();

			let file_frame, json;

			if ( undefined !== file_frame ) {

				file_frame.open();
				return;

			}

			file_frame = wp.media.frames.file_frame = wp.media({
				button: {
					text: 'Choose File',
				},
				frame: 'select',
				multiple: false,
				title: 'Choose File'
			});

			file_frame.on( 'select', function() {

				json = file_frame.state().get( 'selection' ).first().toJSON();

				if ( 0 > $.trim( json.url.length ) ) {
					return;
				}

				/*
				View all the properties in the console available from the returned JSON object

				for ( var property in json ) {

					console.log( property + ': ' + json[ property ] );

				}*/

				field.val( json.url );
				upload.toggleClass( 'hide' );
				remove.toggleClass( 'hide' );

			});

			file_frame.open();

		});

		//Remove value from input, switch links
		remove.on( 'click', function( e ) {

			// Stop the anchor's default behavior
			e.preventDefault();

			// clear the value from the input
			field.val('');

			// change the link message
			upload.toggleClass( 'hide' );
			remove.toggleClass( 'hide' );

		});

	});

})( jQuery );


jQuery(document).ready(function($){

	/**
	 * The following code deals with the custom media modal frame.  It is a modified version
	 * of Thomas Griffin's New Media Image Uploader example plugin.
	 *
	 * @link        https://github.com/thomasgriffin/New-Media-Image-Uploader
	 * @license     http://www.opensource.org/licenses/gpl-license.php
	 * @author      Thomas Griffin <thomas@thomasgriffinmedia.com>
	 * @copyright   Copyright 2013 Thomas Griffin
	 */
	let sbgs_uploader;
	let $slides_ids = $( '#_sbgs_uploader_slides' );
	let $slides_images = $( '#sbgs_uploader_container ul.sbgs_mini_slides' );

	$( '.add_slides' ).click(

		function( event ){

			event.preventDefault();

			let image_ids = $slides_ids.val();

			if ( sbgs_uploader ) {
				sbgs_uploader.open();
				return;
			}

			sbgs_uploader = wp.media.frames.sbgs_uploader = wp.media({
				button: {
					text: 'Choose Images',
				},
				className: 'media-frame sbgs-uploader-frame',
				frame: 'select',
				library: {
					type: 'image'
				},
				multiple: true,
				title: 'Choose Images'
			});

			sbgs_uploader.on( 'select', function() {

				let selection = sbgs_uploader.state().get( 'selection' );

				selection.map( function( image ) {

					image = image.toJSON();

					console.log(image);

					if ( image.id ) {

						image_ids = image_ids ? image_ids + "," + image.id : image.id;

						$slides_images.append( '' +
							'<li class="sbgs_slide" data-attachment_id="' + image.id + '">' +
								'<img src="' + image.sizes.thumbnail.url + '" class="sbgs_mini_slide" />' +
								'<a href="#" class="delete" title="Delete Image">&times;</a>' +
							'</li>'
						);

					} // End of image ID check

				}); // End of selection.map()

				$slides_ids.val( image_ids );

			}); // End of sbgs_uploader.on()

			sbgs_uploader.open();

		} // End of event()

	);





	// Image ordering
	$slides_images.sortable({
		items: 'li.sbgs_slide',
		cursor: 'move',
		scrollSensitivity:40,
		forcePlaceholderSize: true,
		forceHelperSize: false,
		helper: 'clone',
		opacity: 0.65,
		placeholder: 'sbgs-metabox-sortable-placeholder',
		start:function(event,ui){
			ui.item.css( 'background-color','#f6f6f6' );
		},
		stop:function(event,ui){
			ui.item.removeAttr( 'style' );
		},
		update: function(event, ui) {
			let image_ids = '';
			$( '.sbgs_mini_slides li.sbgs_slide' ).css( 'cursor','default' ).each(
				function() {
					let image_id = jQuery(this).attr( 'data-attachment_id' );
					image_ids = image_ids ? image_ids + "," + image_id : image_id;
				}
			);

			$slides_ids.val( image_ids );
		}
	});

	// Remove images
	$( '.sbgs_mini_slides' ).on( 'click', 'a.delete', function() {

		$(this).closest( 'li.sbgs_slide' ).remove();

		let image_ids = '';

		$( '.sbgs_mini_slides li.sbgs_slide' ).css( 'cursor','default' ).each(
			function() {
				var image_id = jQuery(this).attr( 'data-attachment_id' );
				image_ids = image_ids ? image_ids + "," + image_id : image_id;
			}
		);

		$slides_ids.val( image_ids );

		return false;
	});

	/* === End image uploader JS. === */

});
