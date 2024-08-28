<?php
/*
Plugin Name: Super Fantasy Baseball Player Import
Description: Imports players from a JSON file and updates or creates the player or team CPTs.
Version: 1.0.0
Author: arthvadrr
*/

/**
 * No direct access
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load plugin files
 */
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';

/**
 * Hook to init
 */
add_action('admin_menu', 'player_importer_menu', 999);