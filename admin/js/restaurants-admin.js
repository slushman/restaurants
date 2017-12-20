/**
 * Enables file uploader field interaction with Media Library.
 */
(function( $ ) {

	'use strict';

	$(function() {

		let field, upload, remove;

		field = $( '[data-id="url-file"]:not(.hidden [data-id="url-file"])' );
		if ( !field ) { return; }

		remove = $( '#remove-file:not(.hidden #remove-file)' );
		if ( !remove ) { return; }

		upload = $( '#upload-file:not(.hidden #upload-file)' );
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

/**
 * Repeaters
 */
(function( $ ) {

	'use strict';

	const addButton = document.querySelector( '#add-repeater' );
	if ( !addButton ) { return; }

	const original = document.querySelector( '.repeater.hidden' );
	if ( !original ) { return; }

	const repeatersWrap = document.querySelector( '.repeaters' );
	if ( !repeatersWrap ) { return; }

	var repeaters = document.querySelectorAll( '.repeater:not(.hidden)' );
	if ( !repeaters ) { return; }

	var quantity = repeaters.length;

	/**
	 * Preps all the fields in a repeater to be used in the form.
	 *
	 * Gets all the fields in the repeater.
	 * Gets a unique ID.
	 * Then for each field in the repeater:
	 * 		removes the disabled attribute,
	 * 		replaces the %s placeholder with a unique ID in the nama attribute,
	 * 		and sets the value attribute to blank.
	 *
	 * @param 		obj 		element 		The cloned repeater element.
	 */
	function cleanFields( element ) {

		let fields = element.querySelectorAll( '[disabled="disabled"]' );
		let guid = repeaterUniqueNumber();

		for( let i = 0; i < fields.length; i++ ) {

			fields[i].removeAttribute( 'disabled' );

			let name = fields[i].getAttribute( 'name' );
			let newName = name.replace( '[%s]', '[' + guid + ']' );

			fields[i].setAttribute( 'name', newName );
			fields[i].setAttribute( 'value', '' );

		}

	} // cleanFields()

	/**
	 * Returns a unique number based on the current date and time.
	 *
	 * @link 		https://gist.github.com/gordonbrander/2230317
	 * @return 		string 		A unique number.
	 */
	function repeaterUniqueNumber() {

		return '_' + Date.now().toString(36).substr(2, 15);

	} // repeaterUniqueNumber()

	/**
	 * Adds an event listener that removes the repeater from the DOM
	 * when the remove link is clicked.
	 *
	 * @param 		object 		element 		The repeater element object.
	 */
	function addRemoverListener( element ) {

		let remover = element.querySelector( '.link-remove' );

		remover.addEventListener( 'click', function( event ){
			 event.preventDefault();
			 if ( ! element.classList.contains( 'first' ) ) {
				 repeatersWrap.removeChild( element );
			 }
		});

	} // addRemoverListener()

	/**
	 * Adds an event listener that changes the repeater
	 * title based on the text entered in the Menu Title field.
	 *
	 * @param 		object 		element 		The repeater element object.
	 */
	function addTitleListener( element ) {

		let title = element.querySelector( '.title-repeater' );
		let field = element.querySelector( '#menu-title' );

		/**
		 * Changes the repeater title.
		 */
		if ( field.value.length > 0 ) {

			title.textContent = field.value;

		} else {

			field.addEventListener( 'keyup', function(){

				if ( field.value.length > 0 ) {

					title.textContent = field.value;

				} else {

					 title.textContent = 'Menu Name';

				}

			});

		}

	} // addTitleListener()

	/**
	 * Adds an event listener to the show/hide toggle on the repeater title bar.
	 *
	 * @param 		object 		element 		The repeater element object.
	 */
	function addToggleListener( element ) {

		let hidebtn = element.querySelector( '.btn-edit' );
		let content = element.querySelector( '.repeater-content' );

		hidebtn.addEventListener( 'click', function( event ){
			element.classList.toggle( 'closed' );
			$(content).slideToggle( '150' );
		});

	} // addToggleListener()

	/**
	 * Creates a clone of the hidden repeater,
	 * removes the hidden class on the clone,
	 * then inserts the clone into the DOM just before the hidden repeater,
	 * increases the repeater quantity,
	 * then refreshes the repeaters variable to include the newly created repeater.
	 *
	 * @param 		object 		event 			The event object.
	 */
	function addRepeater( event ) {

		event.preventDefault();

		let clone = original.cloneNode( true );

		cleanFields( clone );
		addRemoverListener( clone );
		addToggleListener( clone );
		addTitleListener( clone );

		clone.classList.remove( 'hidden' );
		repeatersWrap.insertBefore( clone, original );

		quantity++;

		repeaters = document.querySelectorAll( '.repeater:not(.hidden)' );

		return false;

	} // addRepeater()

	/**
	 * Event listener for the Add Repeater button.
	 */
	addButton.addEventListener( 'click', addRepeater );

	/**
	 * Adds event listeners for each repeater.
	 */
	for( let i = 0; i < quantity; i++ ) {

		addRemoverListener( repeaters[i] );
		addToggleListener( repeaters[i] );
		addTitleListener( repeaters[i] );

	}

	/**
	 * Makes the repeaters sortable.
	 */
	$(function() {
		$(repeatersWrap).sortable({
			cursor: 'move',
			handle: '.handle',
			items: '.repeater',
			opacity: 0.6,
		});
	});

})( jQuery );
