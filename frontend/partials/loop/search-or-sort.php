<?php
/**
 * The view for the search or sort menu.
 */
?><div class="search-or-sort-wrap">
	<p><button class="toggle-search-sort" aria-controls="search-or-sort" aria-expanded="false"><?php

		esc_html_e( 'Sort', 'restaurants' );

	?></button></p>
	<div class="search-sort-options"><?php

		/**
		 * 12/12/2017: Disabling the search form for now.
		 *
		 * The search function here should be automatic and start filtering items
		 * right away, kind of like video searches on Apple TV or Amazon Video. The
		 * default WordPress search being used here is inadequate and
		 * also brings up results from news, etc.
		 *
		 * Consider writing this as a module within React to filter through
		 * the restaurants from the REST API results. Or possibly writing a
		 * custom script to do the same with the printed results on the page.
		 */
		//get_search_form();

		?><ul class="letter-sort-menu">
			<li class="letter-sorter">
				<a class="letter-sorter-link" id="Nums"><?php

					esc_html_e( '0 - 9', 'restaurants' );

				?></a>
			</li><?php

			foreach ( range( 'A', 'Z' ) as $char ) :

				?><li class="letter-sorter">
					<a class="letter-sorter-link" id="<?php echo esc_attr( $char ); ?>"><?php

						echo esc_html( $char );

					?></a>
				</li><?php

			endforeach;

			unset( $char );

		?></ul>
		<p>
			<a class="view-all" id="view-all"><?php

				esc_html_e( 'View All', 'restaurants' );

			?></a>
		</p>
	</div>
</div>
