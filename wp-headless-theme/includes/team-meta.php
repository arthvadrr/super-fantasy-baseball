<?php
/**
 * Register custom meta fields for team cpt
 */
function register_team_meta() {
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

// Add a meta box for team information
function add_team_meta_boxes() {
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

// Display the meta box fields
function display_team_information_meta_box( $post ) {
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

// Save the meta fields when a post is created or updated
function save_team_meta( $post_id ) {
	// Check if this is an auto-save routine. If it is, our form has not been submitted,
	// so we don’t want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Verify this came from the our screen and with proper authorization
	if ( ! isset( $_POST['post_type'] ) || $_POST['post_type'] !== 'team' ) {
		return;
	}

	// If this is a new post, set the owner and uid
	if ( get_post_meta( $post_id, 'uid', true ) === '' ) {
		$current_user = wp_get_current_user();
		$owner        = $current_user->user_login;

		// Set owner meta
		update_post_meta( $post_id, 'owner', $owner );

		// Generate unique UID based on the owner's username
		$uid = 'UID-' . strtoupper( substr( md5( $owner ), 0, 8 ) );
		update_post_meta( $post_id, 'uid', $uid );
	}
}

add_action( 'save_post', 'save_team_meta' );