<?php

namespace Resource\Config_WP\RemovePosts;

function remove_post_menu() {

	remove_menu_page( 'edit.php' );          //Posts
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );

}

add_action( 'admin_menu', __NAMESPACE__ . '\\remove_post_menu', 999 );
