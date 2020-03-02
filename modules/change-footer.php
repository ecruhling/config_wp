<?php

namespace Resource\Config_WP\ChangeFooter;

/**
 * Change footer text
 */
function change_footer_text() {
	printf(
		'<span id="footer-thankyou">%s <a href="%s" target="_blank">%s</a>.</span>',
		__( 'Website designed and developed by', 'sage' ),
		'http://resourceatlanta.com/',
		__( 'Resource Branding and Design', 'sage' )
	);
}

add_filter( 'admin_footer_text', __NAMESPACE__ . '\\change_footer_text' );
