<?php

/**
 * Creates a draft post when a new restaurant is saved.
 *
 * @link 		https://www.mysafemenu.com
 * @since 		1.0.0
 * @package 	Restaurants\Admin
 * @author 		Slushman <chris@slushman.com>
 */

namespace Restaurants\Admin;

class Posts {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct(){}

	/**
	 * Registers all the WordPress hooks and filters related to this class.
	 *
	 * @hooked 		init
	 * @since 		1.0.0
	 */
	public function hooks() {

		add_action( 'save_post', array( $this, 'insert_post_for_new_restaurant' ), 99, 2 );

	} // hooks()

	/**
	 * Inserts a new pot when a restaurant is published or scheduled.
	 *
	 * This function is hooked very late (99) so the metadata is already saved
	 * and its able to fetch it without errors.
	 *
	 * @exits 		If $postID is empty or not an int.
	 * @exits 		If $post is empty or not an object.
	 * @exits 		If an autosave, a revision, or the post already exists.
	 * @hooked 		save_post_restaurant
	 * @param 		int 		$postID 	The restaurant post ID
	 * @param 		object 		$post 		The restaurant post object
	 * @return 		int 					The new post ID.
	 */
	public function insert_post_for_new_restaurant( $postID, $post ) {

		if ( empty( $postID ) || ! is_int( $postID ) ) { return FALSE; }
		if ( empty( $post ) || ! is_object( $post ) ) { return FALSE; }
		if ( wp_is_post_autosave( $postID ) ) { return FALSE; }
		if ( wp_is_post_revision( $postID ) ) { return FALSE; }
		if ( 'restaurant' !== $post->post_type ) { return FALSE; }
		if ( $this->does_post_already_exist( $post ) ) { return FALSE; }

		$status = get_post_status( $postID );

		if ( in_array( $status, array( 'draft', 'pending', 'auto-draft', 'future' ) ) ) { return FALSE; }

		$content 	= '';
		$meta 		= get_post_custom( $postID );

		$post_args['post_date'] = $post->post_date;

		if ( empty( $meta['menu-files'][0] ) ) {

			$post_args['post_content'] = $post->post_title . ' has been added to the menu list, but there is no menu available online.';

		} else {

			$post_args['post_content'] = 'The allergen menu for ' . $post->post_title . ' has been added to the menu list.';

		}

		if ( ! empty( $post->post_content ) ) {

			$post_args['post_content'] .= '<p>' . $post->post_content . '</p>';

		}

		$post_args['post_author'] 	= 'slushman';
		$post_args['post_status'] 	= 'publish';
		$post_args['post_title'] 	= $post->post_title . ' added to the menus!';
		$newPostID 					= wp_insert_post( $post_args );

		return $newPostID;

	} // insert_post_for_new_restaurant()

	/**
	 * Checks for the existence of a post.
	 *
	 * @since 		1.0.0
	 * @param 		obj 		$rest 		The post object.
	 * @return 		bool 					FALSE if this post doesn't exist, otherwise TRUE.
	 */
	private function does_post_already_exist( $rest ) {

		if ( empty( $rest ) ) { return; }

		$posts = get_posts( array( 'numberposts' => -1 ) );

		if ( empty( $posts ) ) { return FALSE; }

		foreach ( $posts as $post ) {

			$check = strpos( $post->post_title, $rest->post_title );

			if ( FALSE !== $check ) {

				return TRUE; // post exists

			}

		}

		return FALSE; // post does not exist

	} // does_post_already_exist()

} // class
