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

function remove_comment_menu() {
	remove_menu_page( 'edit-comments.php' );          //Comments
}

add_action( 'admin_menu', __NAMESPACE__ . '\\remove_comment_menu', 999 );
