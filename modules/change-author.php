<?php

namespace Resource\Config_WP\ChangeAuthor;

/**
 * Changing the author URL
 *
 * handle incoming links with the author first_name instead of the author slug
 *
 * @source: http://wordpress.stackexchange.com/a/6527/2015 (adapted to use first_name instead of nickname)
 */
function author_firstname_request( $query_vars ) {
	if ( array_key_exists( 'author_name', $query_vars ) ) {
		global $wpdb;
		$author_id = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key='first_name' AND meta_value = %s", $query_vars['author_name'] ) );
		if ( $author_id ) {
			$query_vars['author'] = $author_id;
			unset( $query_vars['author_name'] );
		}
	}

	return $query_vars;
}

add_filter( 'request', __NAMESPACE__ . '\\author_firstname_request' );

/**
 * Changing the author URL
 *
 * generate author post urls with the sitename instead of the standard username-slug
 *
 * @source: http://wordpress.stackexchange.com/a/6527/2015 (adapted to use sitename instead of nickname)
 */
function sitename_author_link( $link, $author_id, $author_nicename ) {

	$link = str_replace( $author_nicename, get_bloginfo( 'name' ), $link );

	return $link;
}

add_filter( 'author_link', __NAMESPACE__ . '\\sitename_author_link', 10, 3 );

/**
 * Disable author archives.
 *
 * @source: http://wp-mix.com/wordpress-disable-author-archives/
 *
 * @since 1.0.0
 */
function disable_author_archives() {
	if ( is_author() ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
	} else {
		redirect_canonical();
	}
}

remove_filter( 'template_redirect', 'redirect_canonical' );
add_action( 'template_redirect', __NAMESPACE__ . '\\disable_author_archives' );

/**
 * Block WP enum scans (user-enumeration).
 *
 * @source: http://perishablepress.com/stop-user-enumeration-wordpress/
 *
 * @since 1.0.0
 */
function check_enum( $redirect, $request ) {
	// permalink URL format
	if ( preg_match( '/\?author=([0-9]*)(\/*)/i', $request ) ) {
		die();
	} else {
		return $redirect;
	}
}

// block user-enumeration
if ( ! is_admin() ) {
	// default URL format
	if ( preg_match( '/author=([0-9]*)/i', $_SERVER['QUERY_STRING'] ) ) {
		die();
	}
	add_filter( 'redirect_canonical', __NAMESPACE__ . '\\check_enum', 10, 2 );
}
