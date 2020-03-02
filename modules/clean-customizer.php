<?php

namespace Resource\Config_WP\CleanCustomizer;

use WP_Customize_Manager;

/**
 * Remove Panels & Sections
 */
function remove_sections( $wp_customize ) {
	$wp_customize->remove_section( 'custom_css' );        // Custom CSS Panel
	$wp_customize->remove_section( 'static_front_page' ); // Static Front Page
	$wp_customize->remove_control( 'blogdescription' );   // Tagline (make sure to delete placeholder first)
	$wp_customize->remove_section( 'colors' );            // Colors
}

add_action( 'customize_register', __NAMESPACE__ . '\\remove_sections', 15 );

// remove Menus from Customizer
add_action( 'customize_register', function ( $wp_customize ) {
	/** @var WP_Customize_Manager $wp_customize */
	remove_action( 'customize_controls_enqueue_scripts', array( $wp_customize->nav_menus, 'enqueue_scripts' ) );
	remove_action( 'customize_register', array( $wp_customize->nav_menus, 'customize_register' ), 11 );
	remove_filter( 'customize_dynamic_setting_args', array( $wp_customize->nav_menus, 'filter_dynamic_setting_args' ) );
	remove_filter( 'customize_dynamic_setting_class', array(
		$wp_customize->nav_menus,
		'filter_dynamic_setting_class'
	) );
	remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->nav_menus, 'print_templates' ) );
	remove_action( 'customize_controls_print_footer_scripts', array(
		$wp_customize->nav_menus,
		'available_items_template'
	) );
	remove_action( 'customize_preview_init', array( $wp_customize->nav_menus, 'customize_preview_init' ) );
}, 10 );
