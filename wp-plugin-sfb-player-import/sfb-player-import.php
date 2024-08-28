<?php
/*
Plugin Name: Super Fantasy Baseball Player Import
Description: Imports players from a JSON file and updates or creates CPT "player".
Version: 1.0.0
Author: arthvadrr
*/

/**
 * No direct access
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!is_user_logged_in() || !current_user_can('manage_options')) {
	wp_die('You do not have permission to access this page.');
}

/**
 * Load plugin files
 */
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/import-functions.php';

/**
 * Hook to init
 */
add_action('admin_menu', 'player_importer_menu');