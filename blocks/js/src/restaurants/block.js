/**
 * The Vanilla JS version of a Gutenblock.
 *
 * @since 		1.0.0
 * @param  {[type]} blocks  [description]
 * @param  {[type]} element [description]
 * @return {[type]}         [description]
 */
( function( blocks, element ) {

	console.log( 'blocks' );

	var el = element.createElement;

	/**
	 * The output of the block.
	 *
	 * Creates a div element. Passes in the restaurants attribute.
	 *
	 * @param       {[type]} restaurants [description]
	 * @constructor
	 */
	function Restaurants( { restaurants } ) {

		return el( 'div', { key: 'restaurants' }, '★'.repeat( restaurants ), ( ( restaurants * 2 ) % 2 ) ? '½' : '' );

	} // Restaurants()

	blocks.registerBlockType( 'restaurants/restaurants-block', {
		title: 'Restaurants Block',

		icon: 'format-image',

		category: 'common',

		attributes: {
			restaurants: {
				type: 'string',
				meta: 'restaurants', // Store the value in postmeta
			}
		},

		edit: function( props ) {
			var restaurants = props.attributes.restaurants,
				children = [];

			function setRestaurants( event ) {
				props.setAttributes( { restaurants: event.target.value } );
				event.preventDefault();
			}

			if ( restaurants ) {
				children.push( Restaurants( { restaurants: restaurants } ) );
			}

			children.push(
				el( 'input', {
					key: 'stars-input',
					type: 'number',
					min: 0,
					max: 5,
					step: 0.5,
					value: restaurants,
					onChange: setRestaurants } )
			);

			return el( 'form', { onSubmit: setRestaurants }, children );
		},

		save: function() {
			// We don't want to save any HTML in post_content, as the value will be in postmeta
			//return null;
		}
	} );
} )(
	window.wp.blocks,
	window.wp.element
);
