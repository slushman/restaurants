/**
 * Toggles the visibility of restaurants that do not have a linked menu.
 *
 * This is disabled for now. Restaurants with no menu are just not shown.
 */
(function() {

	'use strict';

	var toggleNone, noneList;

	toggleNone = document.querySelector( '.toggle-none' );
	if ( ! toggleNone ) { return; }

	noneList = document.querySelectorAll( '[data-menu="none"]' );
	if ( ! noneList ) { return; }

	/**
	 * Event Handler. Hides restaurant listings with no linked menu.
	 *
	 * @param 		obj 		event 		The event object
	 */
	function hideEmpty( event ) {

		event.preventDefault();

		let target = event.currentTarget;
		let status = target.getAttribute( 'data-status' );

		if ( ! status || NULL === status ) {

			for ( let i = 0; i < noneList.length; i++ ) {

				noneList[i].style.display = 'none';

			}

			target.setAttribute( 'data-status', 'toggled' );

		} else {

			for ( let i = 0; i < noneList.length; i++ ) {

				noneList[i].removeAttribute( 'style' );

			}

			target.removeAttribute( 'data-status' );

		}

	} // hideEmpty()

	toggleNone.addEventListener( 'click', hideEmpty, false );

})();
