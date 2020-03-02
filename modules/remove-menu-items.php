<?php

namespace Resource\Config_WP\RemoveMenuItems;
/**
 * Remove items from adminbar.
 *
 * @since 1.0.0
 */
function remove_redundant_items_adminbar( $wp_admin_bar ) {

	global $wp_admin_bar;

	/*** BACKEND ***/
	// remove WP logo and subsequent drop-down menu
	$wp_admin_bar->remove_node( 'wp-logo' );

	// remove View Site text
	$wp_admin_bar->remove_node( 'view-site' );

	// remove "+ New" drop-down menu
	$wp_admin_bar->remove_node( 'new-content' );

	// remove Comments
	$wp_admin_bar->remove_node( 'comments' );

	/*** FRONTEND ***/
	// remove Dashboard link
	$wp_admin_bar->remove_node( 'dashboard' );

	// remove Themes, Widgets, Menus, Header links
	$wp_admin_bar->remove_node( 'appearance' );
}

// removes redundant items from adminbar
add_action( 'admin_bar_menu', __NAMESPACE__ . '\\remove_redundant_items_adminbar', 99 );
