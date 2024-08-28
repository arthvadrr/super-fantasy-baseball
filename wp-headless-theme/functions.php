<?php
/*
Theme Name: Headless Theme for Super Fantasy Baseball
Description: A headless theme for use with a Vue.js sfb-frontend.
Author: arthvadrr@github
Version: 1.0
*/

/**
 * No direct access
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Disable frontend rendering
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

/**
 * Import scripts from /includes
 */
$includes_path = get_template_directory() . '/includes/';

// Include the custom post types
if ( file_exists( $includes_path . 'custom-post-types.php' ) ) {
	require_once $includes_path . 'custom-post-types.php';
}

// Include the player meta
if ( file_exists( $includes_path . 'player-meta.php' ) ) {
	require_once $includes_path . 'player-meta.php';
}

// Include the team meta
if ( file_exists( $includes_path . 'team-meta.php' ) ) {
	require_once $includes_path . 'team-meta.php';
}

/**
 * REST API support
 */
add_action( 'init', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'editor-styles' );
} );

/**
 * Redirect users based on login status.
 */
function redirect_users_based_on_login_status() {
	if ( ! is_user_logged_in() ) {
		wp_redirect( wp_login_url() );
		exit;
	}

	if ( is_user_logged_in() && ! is_admin() && ! defined( 'DOING_AJAX' ) ) {
		wp_redirect( admin_url() );
		exit;
	}
}


register_rest_field( 'player', 'meta', array(
	'get_callback' => function ( $data ) {
		return get_post_meta( $data['id'], '', '' );
	},
) );

// Hook the function to 'template_redirect' action
add_action( 'template_redirect', 'redirect_users_based_on_login_status' );