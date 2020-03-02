<?php

namespace Resource\Config_WP\ChangeMenuOrder;

/**
 * Modify order of admin menu items
 */
function menu_order( $menu_order ) {
	return array(
		'index.php',
		'edit.php',
		'edit.php?post_type=page',
	);
}

add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', __NAMESPACE__ . '\\menu_order' );
