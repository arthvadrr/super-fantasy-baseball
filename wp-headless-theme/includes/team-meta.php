<?php
/**
 * Register custom meta fields for team cpt
 */

/**
 * No direct access
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function register_team_meta(): void {
	register_meta( 'post', 'uid', [
		'type'         => 'string',
		'description'  => 'Unique Identifier',
		'single'       => true,
		'show_in_rest' => true,
		'protected'    => true,
	] );

	register_meta( 'post', 'owner', [
		'type'         => 'string',
		'description'  => 'Team Owner',
		'single'       => true,
		'show_in_rest' => true,
		'protected'    => true,
	] );
}

add_action( 'init', 'register_team_meta' );

function add_team_meta_boxes(): void {
	add_meta_box(
		'team_meta_box',
		'Team Information',
		'display_team_information_meta_box',
		'team',
		'normal',
		'high'
	);
}

add_action( 'add_meta_boxes', 'add_team_meta_boxes' );

function display_team_information_meta_box( $post ): void {
	$uid   = get_post_meta( $post->ID, 'uid', true );
	$owner = get_post_meta( $post->ID, 'owner', true );
	?>
    <div class="wrap">
        <h3>UID:</h3>
        <span><?= esc_attr( $uid ); ?></span>

        <h3>Owner:</h3>
        <span><?= esc_attr( $owner ); ?></span>
    </div>
	<?php
}

function save_team_meta( $post_id ): void {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( $_POST['post_type'] !== 'team' ) {
		return;
	}

	/**
	 * Set UID and Owner if this is a new post
	 */
	if ( get_post_meta( $post_id, 'uid', true ) === '' ) {
		$current_user = wp_get_current_user();
		$owner        = $current_user->user_login;
		$date_prefix  = date( 'Ymd' );
		$hash         = strtoupper( substr( md5( $owner ), 0, 8 ) );
		$uid          = 'UID-' . $date_prefix . $hash;

		update_post_meta( $post_id, 'owner', $owner );
		update_post_meta( $post_id, 'uid', $uid );
	}
}

add_action( 'save_post', 'save_team_meta' );