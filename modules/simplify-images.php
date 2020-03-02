<?php

namespace Resource\Config_WP\SimplifyImages;

/**
 * Don't default to adding a link to the image when user adds images in the WYSIWYG editor
 */
function default_media_links() {
	$image_set = get_option( 'image_default_link_type' );
	if ( $image_set !== 'none' ) {
		update_option( 'image_default_link_type', 'none' );
	}
}

add_action( 'admin_init', __NAMESPACE__ . '\\default_media_links', 10 );

/**
 * Plugin Name: Disable Attachment Pages
 * Plugin URI: https://gschoppe.com/wordpress/disable-attachment-pages
 * Description: Completely disable attachment pages the right way. No forced redirects or 404s, no reserved slugs.
 * Author: Greg Schoppe
 * Author URI: https://gschoppe.com/
 * Version: 1.0.0
 **/

if ( ! class_exists( 'GJSDisableAttachmentPages' ) ) {
	class GJSDisableAttachmentPages {
		public static function Instance() {
			static $instance = null;
			if ( $instance === null ) {
				$instance = new self();
			}

			return $instance;
		}

		private function __construct() {
			$this->init();
			register_activation_hook( __FILE__, 'flush_rewrite_rules' );
			register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
		}

		public function init() {
			add_filter( 'rewrite_rules_array', array( $this, 'remove_attachment_rewrites' ) );
			add_filter( 'wp_unique_post_slug', array( $this, 'wp_unique_post_slug' ), 10, 6 );
			add_filter( 'request', array( $this, 'remove_attachment_query_var' ) );
			add_filter( 'attachment_link', array( $this, 'change_attachment_link_to_file' ), 10, 2 );
			// just in case everything else fails, and somehow an attachment page is requested
			add_action( 'template_redirect', array( $this, 'redirect_attachment_pages_to_file' ) );
		}

		public function remove_attachment_rewrites( $rules ) {
			foreach ( $rules as $pattern => $rewrite ) {
				if ( preg_match( '/([\?&]attachment=\$matches\[)/', $rewrite ) ) {
					unset( $rules[ $pattern ] );
				}
			}

			return $rules;
		}

		// this function is a trimmed down version of `wp_unique_post_slug` from WordPress 4.8.3
		public function wp_unique_post_slug( $slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug ) {
			global $wpdb, $wp_rewrite;

			if ( $post_type == 'nav_menu_item' ) {
				return $slug;
			}

			if ( $post_type == "attachment" ) {
				$prefix = apply_filters( 'gjs_attachment_slug_prefix', 'wp-attachment-', $original_slug, $post_ID, $post_status, $post_type, $post_parent );
				if ( ! $prefix ) {
					return $slug;
				}
				// remove this filter and rerun with the prefix
				remove_filter( 'wp_unique_post_slug', array( $this, 'wp_unique_post_slug' ), 10 );
				$slug = wp_unique_post_slug( $prefix . $original_slug, $post_ID, $post_status, $post_type, $post_parent );
				add_filter( 'wp_unique_post_slug', array( $this, 'wp_unique_post_slug' ), 10, 6 );

				return $slug;
			}

			if ( ! is_post_type_hierarchical( $post_type ) ) {
				return $slug;
			}

			$feeds = $wp_rewrite->feeds;
			if ( ! is_array( $feeds ) ) {
				$feeds = array();
			}

			/*
			 * NOTE: This is the big change. We are NOT checking attachments along with our post type
			 */
			$slug            = $original_slug;
			$check_sql       = "SELECT post_name FROM $wpdb->posts WHERE post_name = %s AND post_type IN ( %s ) AND ID != %d AND post_parent = %d LIMIT 1";
			$post_name_check = $wpdb->get_var( $wpdb->prepare( $check_sql, $slug, $post_type, $post_ID, $post_parent ) );

			/**
			 * Filters whether the post slug would make a bad hierarchical post slug.
			 *
			 * @param bool $bad_slug Whether the post slug would be bad in a hierarchical post context.
			 * @param string $slug The post slug.
			 * @param string $post_type Post type.
			 * @param int $post_parent Post parent ID.
			 *
			 * @since 3.1.0
			 *
			 */
			if ( $post_name_check || in_array( $slug, $feeds ) || 'embed' === $slug || preg_match( "@^($wp_rewrite->pagination_base)?\d+$@", $slug ) || apply_filters( 'wp_unique_post_slug_is_bad_hierarchical_slug', false, $slug, $post_type, $post_parent ) ) {
				$suffix = 2;
				do {
					$alt_post_name   = _truncate_post_slug( $slug, 200 - ( strlen( $suffix ) + 1 ) ) . "-$suffix";
					$post_name_check = $wpdb->get_var( $wpdb->prepare( $check_sql, $alt_post_name, $post_type, $post_ID, $post_parent ) );
					$suffix ++;
				} while ( $post_name_check );
				$slug = $alt_post_name;
			}

			return $slug;
		}

		public function remove_attachment_query_var( $vars ) {
			if ( ! empty( $vars['attachment'] ) ) {
				$vars['page'] = '';
				$vars['name'] = $vars['attachment'];
				unset( $vars['attachment'] );
			}

			return $vars;
		}

		public function make_attachments_private( $args, $slug ) {
			if ( $slug == 'attachment' ) {
				$args['public']             = false;
				$args['publicly_queryable'] = false;
			}

			return $args;
		}

		public function change_attachment_link_to_file( $url, $id ) {
			$attachment_url = wp_get_attachment_url( $id );
			if ( $attachment_url ) {
				return $attachment_url;
			}

			return $url;
		}

		public function redirect_attachment_pages_to_file() {
			if ( is_attachment() ) {
				$id  = get_the_ID();
				$url = wp_get_attachment_url( $id );
				if ( $url ) {
					wp_redirect( $url, 301 );
					die;
				}
			}
		}
	}

	GJSDisableAttachmentPages::Instance();
}
