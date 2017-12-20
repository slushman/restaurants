/**
 * Makes all restaurants visible.
 */
(function() {

	'use strict';

	var viewAll, letterLists, listsLen;

	viewAll = document.querySelector( '#view-all' );
	if ( ! viewAll ) { return; }

	letterLists = document.querySelectorAll( '.letter-list' );
	if ( ! letterLists ) { return; }

	listsLen = letterLists.length;
	if ( 0 >= listsLen ) { return; }

	function showAll( event ) {

		event.preventDefault();

		for ( let i = 0; i < listsLen; i++ ) {

			letterLists[i].removeAttribute( 'style' );

		}

	} // showAll()

	viewAll.addEventListener( 'click', showAll, false );

})();
