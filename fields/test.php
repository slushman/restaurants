<?php

// metaboxes should be registered on the add_meta_boxes hook
add_action('add_meta_boxes', 'add_meta_boxes' );
function add_meta_boxes() {
	add_meta_box( 'repeatable_fields', 'Top 10 Movie List', 'repeatable_meta_box_display', 'cpt_top_ten_list', 'normal', 'default');
}


function repeatable_meta_box_display( $post ) {

	$repeatable_fields = get_post_meta($post->ID, 'repeatable_fields', true);

	if ( empty( $repeatable_fields ) ){
		$repeatable_fields['image'] 			= '';
		$repeatable_fields['title'] 			= '';
		$repeatable_fields['playback_format'] 	= 'dvd';
		$repeatable_fields['description'] 		= '';
	}

	wp_nonce_field( 'hhs_repeatable_meta_box_nonce', 'hhs_repeatable_meta_box_nonce' );

	?><table id="repeatable-fieldset-one" class="widefat fixed" cellspacing="0" style="width:100%;">
		<thead>
			<tr>
				<th style="width:25px;" scope="col">Rank</th>
				<th style="width:170px;" scope="col">Image</th>
				<th width="145px" scope="col">Movie Title</th>
				<th width="300px" scope="col">Movie Description</th>
				<th width="8%" scope="col">Re-Order</th>
			</tr>
		</thead>
		<tbody><?php

		// set a variable so we can append it to each row
		$i = 1;

		foreach ( $repeatable_fields as $field ) { ?>

			<tr class="single-movie-row ui-state-default">

				<td>
					<label for="_movies[<?php echo $i;?>][rank]">
					<input name="_movies[<?php echo $i;?>][rank]" id="_movies[<?php echo $i;?>][rank]" class="movie_rank_number" disabled="disabled" type="text" value="# <?php echo $i;?>" />
					</label>
				</td>
				<td>
					<label for="_movies[<?php echo $i;?>][image]">
					<input name="_movies[<?php echo $i;?>][image]" class="upload_image" id="_movies[<?php echo $i;?>][image]" type="text" size="36" value="<?php echo esc_attr( $field['image'] );?>" />
					<input class="upload_image_button" id="_movies[<?php echo $i;?>][upload_image_button]" type="button" value="Upload Image" />
					</label>
				</td>
				<td>
					<!-- title field -->
					<textarea name="_movies[<?php echo $i;?>][title]" id="_movies[<?php echo $i;?>][title]" class="title_tinymce_editor"><?php echo esc_html( $field['title'] );?></textarea>
					<div class="playbackformat-holder">
						<label for="_movies[<?php echo $i;?>][playback_format][dvd]">
						<input type="radio" id="_movies[<?php echo $i;?>][playback_format][dvd]" name="_movies[<?php echo $i;?>][playback_format]" value="dvd" <?php checked( $field['playback_format'], 'dvd' ); ?> />DVD
						</label>
						<label for="_movies[<?php echo $i;?>][playback_format][bluray]">
						<input type="radio" id="_movies[<?php echo $i;?>][playback_format][bluray]" name="_movies[<?php echo $i;?>][playback_format]" value="bluray" <?php checked( $field['playback_format'], 'bluray' ); ?> />Bluray
						</label><br>
						<label for="_movies[<?php echo $i;?>][playback_format][3d]">
						<input type="radio" id="_movies[<?php echo $i;?>][playback_format][3d]" name="_movies[<?php echo $i;?>][playback_format]" value="3d" <?php checked( $field['playback_format'], '3d' ); ?> />3d
						</label><br />
					</div>
				</td>
				<td>
					<textarea id="_movies[<?php echo $i;?>][description]" name="_movies[<?php echo $i;?>][description]" class="movie_description_editor_hidden"><?php echo esc_html( $field['description'] );?></textarea>
				</td>
				<td>
					<a class="button remove-row" href="#">Remove Row</a><img src="<?php echo get_template_directory_uri() ?>/images/draggable-icon.png" alt="sortable icon" class="jQuerySortableIcon">
				</td>
			</tr><?php

			$i++;

		} // foreach

			?><!-- empty hidden one for jQuery -->
			<tr class="empty-row screen-reader-text single-movie-row">

				<td>
				<label for="_movies[%s][rank]">
				<input name="_movies[%s][rank]" id="_movies[%s][rank]" class="movie_rank_number" disabled="disabled" type="text" value="" />
				</label>
				</td>

				<td>
				<label for="_movies[%s][image]">
				<input name="_movies[%s][image]" class="upload_image" id="_movies[%s][image]" type="text" size="36" value="" />
				<input class="upload_image_button" id="_movies[<?php echo $i;?>][upload_image_button]" type="button" value="Upload Image" />
				</label>
				</td>

				<td>
				<!-- title field -->
				<textarea name="_movies[%s][title]" id="_movies[%s][title]" class="title_tinymce_editor"></textarea>

				<div class="playbackformat-holder">

				<label for="_movies[%s][playback_format][dvd]">
				<input type="radio" id="_movies[%s][playback_format][dvd]" name="_movies[%s][playback_format]" value="dvd" <?php checked( 'dvd', 'dvd' ); ?> />DVD
				</label>
				<label for="_movies[%s][playback_format][bluray]">
				<input type="radio" id="_movies[%s][playback_format][bluray]" name="_movies[%s][playback_format]" value="bluray" />Bluray
				</label><br>
				<label for="_movies[%s][playback_format][3d]">
				<input type="radio" id="_movies[%s][playback_format][3d]" name="_movies[%s][playback_format]" value="3d" />3d
				</label><br />

				</div>

				<!-- drop down or checkbox's with release formats -->
				</td>

				<td>
				<textarea id="_movies[%s][description]" name="_movies[%s][description]" class="movie_description_editor_hidden"></textarea>
				</td>


				<td>
				<a class="button remove-row" href="#">Remove Row</a><img src="<?php echo get_template_directory_uri() ?>/images/draggable-icon.png" alt="sortable icon" class="jQuerySortableIcon">
				</td>

			</tr>

		</tbody>
	</table>

	<p id="add-row-p-holder"><a id="add-row" class="btn btn-small btn-success" href="#">Insert Another Row</a></p><?php

}


add_action('save_post', 'hhs_repeatable_meta_box_save', 10, 2);
function hhs_repeatable_meta_box_save($post_id) {

	if ( ! isset( $_POST['hhs_repeatable_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['hhs_repeatable_meta_box_nonce'], 'hhs_repeatable_meta_box_nonce' ) ) { return; }
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
	if (!current_user_can('edit_post', $post_id)) {return;}

	$clean = array();

	if  ( isset ( $_POST['_movies'] ) && is_array( $_POST['_movies'] ) ) :

		foreach ( $_POST['_movies'] as $i => $movie ){

			// skip the hidden "to copy" div
			if( $i == '%s' ){ continue; }

			$playback_formats = array ( 'dvd', 'bluray', '3d' );

			$clean[] = array(
				'image' => isset( $movie['image'] ) ? sanitize_text_field( $movie['image'] ) : null,
				'title' => isset( $movie['title'] ) ? sanitize_text_field( $movie['title'] ) : null,
				'playback_format' => isset( $movie['playback_format'] ) && in_array( $movie['playback_format'], $playback_formats ) ? $movie['playback_format'] : null,
				'description' => isset( $movie['description'] ) ? sanitize_text_field( $movie['description'] ) : null,
			);

		} // foreach

	endif;

	// save movie data
	if ( ! empty( $clean ) ) {
		update_post_meta( $post_id, 'repeatable_fields', $clean );
	} else
		delete_post_meta( $post_id, 'repeatable_fields' );
	}

}
