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
