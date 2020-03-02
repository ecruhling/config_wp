<?php

namespace Resource\Config_WP\PostsToNews;

/**
 * Modify names of Post menu items
 */
function custom_menu_names() {
	global $menu;
	global $submenu;

	if ( isset( $menu[5][0] ) ) {
		$menu[5][0] = 'News';
	}
	if ( isset( $submenu['edit.php'][5][0] ) ) {
		$submenu['edit.php'][5][0] = 'News';
	}
	if ( isset( $submenu['edit.php'][10][0] ) ) {
		$submenu['edit.php'][10][0] = 'Add News';
	}

	echo '';

}

add_action( 'admin_menu', __NAMESPACE__ . '\\custom_menu_names', 999 );

function change_post_object() {
	global $wp_post_types;
	$labels                     = &$wp_post_types['post']->labels;
	$icon                       = &$wp_post_types['post']->menu_icon;
	$labels->name               = 'News';
	$labels->singular_name      = 'News';
	$labels->add_new            = 'Add News';
	$labels->add_new_item       = 'Add News';
	$labels->edit_item          = 'Edit News';
	$labels->new_item           = 'News';
	$labels->view_item          = 'View News';
	$labels->search_items       = 'Search News';
	$labels->not_found          = 'No News found';
	$labels->not_found_in_trash = 'No News found in Trash';
	$labels->all_items          = 'All News';
	$labels->menu_name          = 'News';
	$labels->name_admin_bar     = 'News';
	$icon                       = 'dashicons-welcome-widgets-menus';

}

add_action( 'init', __NAMESPACE__ . '\\change_post_object' );
