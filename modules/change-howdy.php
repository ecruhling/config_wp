<?php

namespace Resource\Config_WP\ChangeHowdy;

/**
 * Change 'Howdy, $user' to 'Greetings, $user'
 *
 * @since 1.0.0
 * @modified 1.1.0
 */
function change_howdy( $wp_admin_bar ) {
	$user_id      = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url  = get_edit_profile_url( $user_id );

	if ( 0 != $user_id ) {
		/* Add the "My Account" menu */
		$avatar = get_avatar( $user_id, 28 );
		$howdy  = sprintf( __( 'Greetings, %1$s' ), $current_user->display_name );
		$class  = empty( $avatar ) ? '' : 'with-avatar';

		$wp_admin_bar->add_menu( array(
			'id'     => 'my-account',
			'parent' => 'top-secondary',
			'title'  => $howdy . $avatar,
			'href'   => $profile_url,
			'meta'   => array(
				'class' => $class,
			),
		) );

	}
}

add_action( 'admin_bar_menu', __NAMESPACE__ . '\\change_howdy', 11 );
