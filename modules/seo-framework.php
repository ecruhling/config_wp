<?php

namespace Resource\Config_WP\SEOFramework;

/**
 * Move SEO framework metabox to a lower position
 */
function seo_metabox_priority() {
	//* Accepts 'high', 'default', 'low'. Default is 'high'.
	return 'low';
}

add_filter( 'the_seo_framework_metabox_priority', __NAMESPACE__ . '\\seo_metabox_priority' );

/**
 * Remove SEO framework comment in head
 */
add_filter( 'the_seo_framework_indicator', '__return_false' );

/**
 * Move Yoast metabox to a lower position
 */
add_filter( 'wpseo_metabox_prio', function () {
	return 'low';
} );
