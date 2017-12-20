/**
 * Returns the event target.
 *
 * @since 		1.0.0
 * @param 		object 		event 		The event.
 * @return 		object 		target 		The event target.
 */
function getEventTarget( event ) {

	event.event || window.event;

	return event.target || event.scrElement;

} // getEventTarget()

/**
 * Returns the parent node with the requested class.
 *
 * This is recursive, so it will continue up the DOM tree
 * until the correct parent is found.
 *
 * @since 		1.0.0
 * @param 		object 		el 				The node element.
 * @param 		string 		className 		Name of the class to find.
 * @return 		object 						The parent element.
 */
function getParent( el, className ) {

	let parent = el.parentNode;

	if ( '' !== parent.classList && parent.classList.contains( className ) ) {

		return parent;

	}

	return getParent( parent, className );

} // getParent()

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
