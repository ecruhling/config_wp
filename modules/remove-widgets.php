<?php

namespace Resource\Config_WP\RemoveWidgets;

/**
 * Remove default widgets.
 *
 * @since 1.0.0
 */
function remove_wp_default_widgets() {

	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Archives' );
	if ( get_option( 'link_manager_enabled' ) ) {
		unregister_widget( 'WP_Widget_Links' );
	}
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );

}

add_action( 'widgets_init', __NAMESPACE__ . '\\remove_wp_default_widgets' );
