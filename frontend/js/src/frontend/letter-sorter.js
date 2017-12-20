/**
 * Toggles the visibility of restaurants starting with the selected letter.
 */
(function() {

	'use strict';

	var sortLetters, letterLists, listsLen;

	sortLetters = document.querySelectorAll( '.letter-sorter-link' );
	if ( ! sortLetters ) { return; }

	letterLists = document.querySelectorAll( '.letter-list' );
	if ( ! letterLists ) { return; }

	listsLen = letterLists.length;
	if ( 0 >= listsLen ) { return; }

	/**
	 * Event handler. Toggles the visibility of restaurants by the first
	 * letter of their name.
	 *
	 * @param 		obj 		event 		Event object.
	 */
	function toggleLetters( event ) {

		event.preventDefault();

		let selected = event.currentTarget.getAttribute( 'id' );

		for ( let i = 0; i < listsLen; i++ ) {

			let checkid = letterLists[i].getAttribute( 'id' );

			if ( checkid === selected ) {

				letterLists[i].removeAttribute( 'style' );
				continue;

			}

			letterLists[i].style.display = 'none';

		}

	} // toggleLetters()

	for ( let i = 0; i < sortLetters.length; i++ ) {

		sortLetters[i].addEventListener( 'click', toggleLetters, false );

	}

})();
