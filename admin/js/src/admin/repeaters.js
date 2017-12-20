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
