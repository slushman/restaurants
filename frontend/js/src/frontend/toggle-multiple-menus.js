/**
 * Toggles the visibility of the multiple menus.
 */
(function( $ ) {

	'use strict';

	var multiTitles = document.querySelectorAll( '.restaurant-title-multiple-menus' );
	if ( 1 > multiTitles.length ) { return; }

	/**
	 * Event Handler. Toggles the visibility of
	 * the multiple menus list element.
	 *
	 * @param 		obj 		event 		The event object.
	 */
	function showMenus( event ) {

		event.preventDefault();

		let target = event.currentTarget;
		let parent = getParent( target, 'restaurant' );
		let files = parent.querySelector( '.menu-files' );

		$(files).slideToggle(250);

	} // showMenus()

	for ( let i = 0; i < multiTitles.length; i++ ) {

		multiTitles[i].addEventListener( 'click', showMenus, false );

	}

})( jQuery );
