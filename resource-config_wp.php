<?php
/*
 * Plugin Name: 		Resource Config_WP
 * Plugin URI:  		https://resourceatlanta.com
 * Description:			A very opinionated, modular plugin for customizing & cleaning up the front- and back-end of WordPress.
 *                      Uses patterns established in Soil plugin by Roots. https://roots.io/plugins/soil/
 * Version:     		1.0.0
 * Author:				Resource Branding and Design
 * Author URI:  		https://resourceatlanta.com
 */

namespace Resource\Config_WP;

class Options {
	protected static $modules = [];
	protected $options = [];

	public static function init( $module, $options = [] ) {
		if ( ! isset( self::$modules[ $module ] ) ) {
			self::$modules[ $module ] = new static( (array) $options );
		}

		return self::$modules[ $module ];
	}

	public static function getByFile( $file ) {
		if ( file_exists( $file ) || file_exists( __DIR__ . '/modules/' . $file ) ) {
			return self::get( 'resource-' . basename( $file, '.php' ) );
		}

		return [];
	}

	public static function get( $module ) {
		if ( isset( self::$modules[ $module ] ) ) {
			return self::$modules[ $module ]->options;
		}
		if ( substr( $module, 0, 9 ) !== 'resource-' ) {
			return self::get( 'resource-' . $module );
		}

		return [];
	}

	protected function __construct( $options ) {
		$this->set( $options );
	}

	public function set( $options ) {
		$this->options = $options;
	}
}

function load_modules() {
	global $_wp_theme_features;

	foreach ( glob( __DIR__ . '/modules/*.php' ) as $file ) {
		$feature = 'resource-' . basename( $file, '.php' );
		if ( isset( $_wp_theme_features[ $feature ] ) ) {
			Options::init( $feature, $_wp_theme_features[ $feature ] );
			require_once $file;
		}
	}
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\\load_modules', 100 );

///**
// * Wrapper function to register a new dashboard widget
// * @return void Dashboard Widget class object
// */
//function init() {
//	//Register the widget...
//	wp_add_dashboard_widget( 'leanwp-dashboard-widget', esc_html__( 'Site information', 'lean-wp'), array( 'LEAN_WP_Dashboard_Widget', 'widget' ) );
//}
//
///**
// * Load admin CSS.
// * @access  public
// * @since   1.0.0
// * @return  void
// */
//function admin_enqueue_styles ( $hook = '' ) {
//	wp_register_style( $this->_token . '-admin', esc_url( $this->assets_url ) . 'css/admin.css', array(), $this->_version );
//	wp_enqueue_style( $this->_token . '-admin' );
//} // End admin_enqueue_styles ()
//
///**
// * Loads the translation file.
// * @access  public
// * @since   1.0.0
// * @return  void
// */
//function i18n() {
//	load_plugin_textdomain( 'lean-wp', false, false );
//} // End i18n ()
