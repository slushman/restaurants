/**
 * Toggles the visibility of the search and sort options.
 */
(function() {

	'use strict';

	var button, options;

	button = document.querySelector( '.toggle-search-sort' );
	if ( ! button ) { return; }

	options = document.querySelector( '.search-sort-options' );
	if ( ! options ) { return; }

	options.setAttribute( 'aria-hidden', 'true' );

	/**
	 * Toggles the visibility of the search/sort options.
	 *
	 * @param 		obj 		event 		The event object.
	 */
	function toggleOptions( event ) {

		event.preventDefault();

		if ( 'true' === options.getAttribute( 'aria-hidden' ) ) {

			options.setAttribute( 'aria-hidden', 'false' );

		} else {

			options.setAttribute( 'aria-hidden', 'true' );

		}

	} // toggleOptions()

	button.addEventListener( 'click', toggleOptions );

})();
