<?php

namespace Resource\Config_WP\CustomLogin;

/**
 * Add custom logo image, instead of WordPress default
 */
function login_logo() {

	$logo_path = get_stylesheet_directory_uri() . '/screenshot.png';

	?>
    <style type="text/css">
        body.login h1 a {
            background-image: url('<?php echo $logo_path ?>');
            background-size: contain;
            width: 100%;
            min-height: 150px;
        }

        .login form .input,
        .login input[type="text"] {
            background: #fff;
        }
    </style>
	<?php
}

add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\login_logo' );

/**
 * Add custom URL the logo will link to
 */
function login_logo_url() {
	return get_bloginfo( 'url' );
}

add_filter( 'login_headerurl', __NAMESPACE__ . '\\login_logo_url' );

/**
 * Add custom TITLE the logo link will have
 */
function login_logo_url_title() {
	return get_bloginfo( 'name' );
}

add_filter( 'login_headertext', __NAMESPACE__ . '\\login_logo_url_title' );
