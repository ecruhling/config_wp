<?php

namespace Resource\Config_WP\CleanDashboard;

/**
 * Edit the backend.
 *
 * dashboard widgets
 * sidebar menu items
 * sidebar sub menu items
 *
 * @since 1.0.0
 */
function clean_dashboard() {

	// remove all WordPress default dashboard widgets
	remove_meta_box( 'dashboard_activity', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );

}

add_action( 'admin_menu', __NAMESPACE__ . '\\clean_dashboard', 9999 );

add_action( 'wp_dashboard_setup', array(
	'\Resource\Config_WP\CleanDashboard\Resource_Config_WP_Dashboard_Widget',
	'init'
) );

class Resource_Config_WP_Dashboard_Widget {

	/**
	 * Hook to wp_dashboard_setup to add the widget.
	 */
	public static function init() {
		wp_add_dashboard_widget( 'resource-config_wp-dashboard-widget', esc_html__( 'Site Information', 'resource' ), array(
			'\Resource\Config_WP\CleanDashboard\Resource_Config_WP_Dashboard_Widget',
			'widget'
		) );
	}

	/**
	 * Load the widget code
	 */
	public static function widget() {
		?>
        <p><?php
			printf( __( '<strong>%1$s</strong> has been simplified and optimized by %2$s.', 'resource' ),
				esc_attr( get_bloginfo( 'name' ) ),
				__( 'the <strong>Resource Config_WP</strong> plugin', 'resource' )
			);
			?>
        </p>
        <ul>
            <li><?php echo get_cms_version(); ?></li>
            <li><?php esc_html_e( 'Active theme: ', 'resource' );
				get_theme_info(); ?></li>
            <li><?php esc_html_e( 'Your IP address: ', 'resource' );
				echo '<strong>' . get_user_ip() . '</strong>'; ?></li>
            <li><?php esc_html_e( 'PHP version: ', 'resource' );
				echo '<strong>' . PHP_VERSION . '</strong>'; ?></li>
        </ul>
        <style>
            #resource-config_wp-dashboard-widget.postbox {
                background-color: rgba(62, 94, 111, 0.11);
            }
        </style>
		<?php
	}

}

function get_cms_version() {

	if ( function_exists( 'classicpress_version' ) ) {
		return esc_html_e( 'ClassicPress version: ', 'resource' ) . '<strong>' . classicpress_version() . '</strong>';
	} else {
		return esc_html_e( 'WordPress version: ', 'resource' ) . '<strong>' . get_bloginfo( 'version' ) . '</strong>';
	}

}

function get_theme_info() {

	$theme_data = wp_get_theme();

	$theme_info = '<strong>' . $theme_data->Name . '</strong>' . esc_html__( ', version ', 'resource' ) . '<strong>' . $theme_data->Version . '</strong>';
	$theme_info = printf( __( '%1$s, version %2$s', 'resource' ),
		'<strong>' . $theme_data->Name . '</strong>',
		'<strong>' . $theme_data->Version . '</strong>'
	);

	return $theme_info;

}

function get_user_ip() {

	if ( isset( $_SERVER ) ) {

		if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif ( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

	} else {

		if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
			$ip_address = getenv( 'HTTP_X_FORWARDED_FOR' );
		} elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
			$ip_address = getenv( 'HTTP_CLIENT_IP' );
		} elseif ( getenv( 'REMOTE_ADDR' ) ) {
			$ip_address = getenv( 'REMOTE_ADDR' );
		}

	}

	return sanitize_text_field( $ip_address );

}
