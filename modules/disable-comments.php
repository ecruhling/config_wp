<?php

namespace Resource\Config_WP\DisableComments;

/**
 * Completely disable comments
 */
function disable_comments() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}

add_action( 'init', __NAMESPACE__ . '\\disable_comments' );

/**
 * Remove various comments feeds
 */

add_filter( 'feed_links_show_comments_feed', '__return_false' );

function remove_single_comments_feed() {
	return;
}

add_filter( 'post_comments_feed_link', __NAMESPACE__ . '\\remove_single_comments_feed' );

function comments_feed_404( $object ) {
	if ( $object->is_comment_feed ) {
		wp_die( 'Not Found', '', array(
			'response'  => 404,
			'back_link' => true,
		) );
	}
}

add_action( 'parse_query', __NAMESPACE__ . '\\comments_feed_404' );

/**
 * Hide Comments menu
 */

function remove_comment_menu() {
	remove_menu_page( 'edit-comments.php' );          //Comments
}

add_action( 'admin_menu', __NAMESPACE__ . '\\remove_comment_menu', 999 );
