<?php

namespace Resource\Config_WP\GravityForms;

/**
 * Make Gravity Forms load JS in footer
 */
add_filter( 'gform_init_scripts_footer', '__return_true' );

function wrap_gform_cdata_open( $content = '' ) {
	if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
		return $content;
	}
	$content = 'document.addEventListener( "DOMContentLoaded", function() { ';

	return $content;
}

add_filter( 'gform_cdata_open', __NAMESPACE__ . '\\wrap_gform_cdata_open', 1 );

function wrap_gform_cdata_close( $content = '' ) {
	if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
		return $content;
	}
	$content = ' }, false );';

	return $content;
}

add_filter( 'gform_cdata_close', __NAMESPACE__ . '\\wrap_gform_cdata_close', 99 );

/**
 * Hide Gravityforms Spinner
 */
add_filter( 'gform_ajax_spinner_url', function () {
	return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
} );
