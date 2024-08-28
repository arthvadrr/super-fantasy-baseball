<?php
/**
 * Register custom meta fields for play cpt
 */

/**
 * No direct access
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function register_player_meta(): void {
	register_meta( 'post', 'batting_average', [
		'type'         => 'string',
		'description'  => 'Batting Average',
		'single'       => true,
		'show_in_rest' => true,
	] );

	register_meta( 'post', 'home_runs', [
		'type'         => 'number',
		'description'  => 'Home Runs',
		'single'       => true,
		'show_in_rest' => true,
	] );

	register_meta( 'post', 'RBIs', [
		'type'         => 'number',
		'description'  => 'Runs Batted In',
		'single'       => true,
		'show_in_rest' => true,
	] );

	register_meta( 'post', 'stolen_bases', [
		'type'         => 'number',
		'description'  => 'Stolen Bases',
		'single'       => true,
		'show_in_rest' => true,
	] );

	// Register new fields
	register_meta( 'post', 'ERA', [
		'type'         => 'string',
		'description'  => 'Earned Run Average',
		'single'       => true,
		'show_in_rest' => true,
	] );

	register_meta( 'post', 'strikeouts', [
		'type'         => 'number',
		'description'  => 'Strikeouts',
		'single'       => true,
		'show_in_rest' => true,
	] );

	register_meta( 'post', 'walks', [
		'type'         => 'number',
		'description'  => 'Walks',
		'single'       => true,
		'show_in_rest' => true,
	] );

	register_meta( 'post', 'fielding_percentage', [
		'type'         => 'string',
		'description'  => 'Fielding Percentage',
		'single'       => true,
		'show_in_rest' => true,
	] );
}

add_action( 'init', 'register_player_meta' );

// Add a meta box for player stats
function add_player_meta_boxes(): void {
	add_meta_box(
		'player_stats_meta_box',
		'Player Stats',
		'display_player_stats_meta_box',
		'player',
		'normal',
		'high'
	);
}

add_action( 'add_meta_boxes', 'add_player_meta_boxes' );

// Display the meta box fields
function display_player_stats_meta_box( $post ): void {
	$batting_average     = get_post_meta( $post->ID, 'batting_average', true ) ?? 0;
	$home_runs           = get_post_meta( $post->ID, 'home_runs', true ) ?? 0;
	$RBIs                = get_post_meta( $post->ID, 'RBIs', true ) ?? 0;
	$stolen_bases        = get_post_meta( $post->ID, 'stolen_bases', true ) ?? 0;
	$ERA                 = get_post_meta( $post->ID, 'ERA', true ) ?? 0;
	$strikeouts          = get_post_meta( $post->ID, 'strikeouts', true ) ?? 0;
	$walks               = get_post_meta( $post->ID, 'walks', true ) ?? 0;
	$fielding_percentage = get_post_meta( $post->ID, 'fielding_percentage', true ) ?? 0;

	wp_nonce_field( 'save_player_meta', 'player_meta_nonce' );
	?>
    <div class="wrap">
        <label for="batting_average">Batting Average:</label>
        <input type="text" name="batting_average" value="<?= esc_attr( $batting_average ); ?>"/><br>

        <label for="home_runs">Home Runs:</label>
        <input type="number" name="home_runs" value="<?= esc_attr( $home_runs ); ?>"/><br>

        <label for="RBIs">RBIs:</label>
        <input type="number" name="RBIs" value="<?= esc_attr( $RBIs ); ?>"/><br>

        <label for="stolen_bases">Stolen Bases:</label>
        <input type="number" name="stolen_bases" value="<?= esc_attr( $stolen_bases ); ?>"/><br>

        <label for="ERA">ERA:</label>
        <input type="text" name="ERA" value="<?= esc_attr( $ERA ); ?>"/><br>

        <label for="strikeouts">Strikeouts:</label>
        <input type="number" name="strikeouts" value="<?= esc_attr( $strikeouts ); ?>"/><br>

        <label for="walks">Walks:</label>
        <input type="number" name="walks" value="<?= esc_attr( $walks ); ?>"/><br>

        <label for="fielding_percentage">Fielding Percentage:</label>
        <input type="text" name="fielding_percentage" value="<?= esc_attr( $fielding_percentage ); ?>"/>
    </div>
	<?php
}

/**
 * Save the meta fields
 */
/**
 * Save the meta fields
 */
function save_player_stats_meta( $post_id ): void {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['player_meta_nonce'] ) || ! wp_verify_nonce( $_POST['player_meta_nonce'], 'save_player_meta' ) ) {
		return;
	}
	if ( isset( $_POST['batting_average'] ) ) {
		update_post_meta( $post_id, 'batting_average', sanitize_text_field( $_POST['batting_average'] ) );
	}
	if ( isset( $_POST['home_runs'] ) ) {
		update_post_meta( $post_id, 'home_runs', intval( $_POST['home_runs'] ) );
	}
	if ( isset( $_POST['RBIs'] ) ) {
		update_post_meta( $post_id, 'RBIs', intval( $_POST['RBIs'] ) );
	}
	if ( isset( $_POST['stolen_bases'] ) ) {
		update_post_meta( $post_id, 'stolen_bases', intval( $_POST['stolen_bases'] ) );
	}
	if ( isset( $_POST['ERA'] ) ) {
		update_post_meta( $post_id, 'ERA', sanitize_text_field( $_POST['ERA'] ) );
	}
	if ( isset( $_POST['strikeouts'] ) ) {
		update_post_meta( $post_id, 'strikeouts', intval( $_POST['strikeouts'] ) );
	}
	if ( isset( $_POST['walks'] ) ) {
		update_post_meta( $post_id, 'walks', intval( $_POST['walks'] ) );
	}
	if ( isset( $_POST['fielding_percentage'] ) ) {
		update_post_meta( $post_id, 'fielding_percentage', sanitize_text_field( $_POST['fielding_percentage'] ) );
	}
}

add_action( 'save_post', 'save_player_stats_meta' );


add_action( 'save_post', 'save_player_stats_meta' );