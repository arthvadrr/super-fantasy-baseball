<?php
/**
 * CPT for players
 * @return void
 */

/**
 * No direct access
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function register_player_cpt(): void {
	$labels = array(
		'name'          => _x( 'Players', 'Post Type General Name', 'textdomain' ),
		'singular_name' => _x( 'Player', 'Post Type Singular Name', 'textdomain' ),
		'menu_name'     => __( 'Players', 'textdomain' ),
		'all_items'     => __( 'All Players', 'textdomain' ),
		'add_new_item'  => __( 'Add New Player', 'textdomain' ),
		'edit_item'     => __( 'Edit Player', 'textdomain' ),
	);

	$args = array(
		'label'         => __( 'Player', 'textdomain' ),
		'labels'        => $labels,
		'supports'      => array( 'title', 'thumbnail', 'custom-fields' ),
		'public'        => true,
		'has_archive'   => false,
		'show_in_rest'  => true,
		'menu_position' => 5,
		'menu_icon'     => 'dashicons-businessman',
	);

	register_post_type( 'player', $args );
}

/**
 * CPT for games
 * @return void
 */
function register_game_cpt(): void {
	$labels = array(
		'name'          => _x( 'Games', 'Post Type General Name', 'textdomain' ),
		'singular_name' => _x( 'Game', 'Post Type Singular Name', 'textdomain' ),
		'menu_name'     => __( 'Games', 'textdomain' ),
		'all_items'     => __( 'All Games', 'textdomain' ),
		'add_new_item'  => __( 'Add New Game', 'textdomain' ),
		'edit_item'     => __( 'Edit Game', 'textdomain' ),
	);

	$args = array(
		'label'         => __( 'Game', 'textdomain' ),
		'labels'        => $labels,
		'supports'      => array( 'title', 'thumbnail', 'custom-fields' ),
		'public'        => true,
		'has_archive'   => false,
		'show_in_rest'  => true,
		'menu_position' => 6,
		'menu_icon'     => 'dashicons-tickets',
	);

	register_post_type( 'game', $args );
}

/**
 * CPT for Teams
 * @return void
 */
function register_team_cpt(): void {
	$labels = array(
		'name'          => _x( 'Teams', 'Post Type General Name', 'textdomain' ),
		'singular_name' => _x( 'Team', 'Post Type Singular Name', 'textdomain' ),
		'menu_name'     => __( 'Teams', 'textdomain' ),
		'all_items'     => __( 'All Teams', 'textdomain' ),
		'add_new_item'  => __( 'Add New Team', 'textdomain' ),
		'edit_item'     => __( 'Edit Team', 'textdomain' ),
	);

	$args = array(
		'label'         => __( 'Team', 'textdomain' ),
		'labels'        => $labels,
		'supports'      => array( 'title', 'thumbnail', 'custom-fields' ),
		'public'        => true,
		'has_archive'   => false,
		'show_in_rest'  => true,
		'menu_position' => 7,
		'menu_icon'     => 'dashicons-groups',
	);

	register_post_type( 'team', $args );
}

/**
 * Register the custom post types (hook into init)
 * @return void
 */
function register_baseball_cpts(): void {
	register_player_cpt();
	register_game_cpt();
	register_team_cpt();
}

add_action( 'init', 'register_baseball_cpts' );