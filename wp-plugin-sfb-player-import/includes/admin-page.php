<?php
/**
 * No direct access
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the menu page to the admin
 * @return void
 */
function player_importer_menu(): void {
	add_menu_page(
		'Player Importer',
		'Player Importer',
		'manage_options',
		'player-importer',
		'player_importer_page',
		'dashicons-upload',
		'6'
	);
}

/**
 * Rendering for the import admin page
 * @return void
 */
function player_importer_page(): void {
	?>
    <div class="wrap">
        <h1>Player Importer</h1>
        <!-- Player Import Form -->
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="players_json" accept=".json"/>
            <input type="submit" name="import_players" value="Import Players" class="button button-primary"/>
        </form>
		<?php
		if ( isset( $_POST['import_players'] ) ) {
			if ( ! empty( $_FILES['players_json']['tmp_name'] ) ) {
				$json_file = $_FILES['players_json']['tmp_name'];
				player_import_from_json( $json_file );
			} else {
				echo '<p>Please upload a JSON file.</p>';
			}
		}
		?>

        <!-- Delete All Players Form -->
        <form method="post">
			<?php
			wp_nonce_field( 'delete_all_players_nonce', 'delete_all_players_nonce_field' );
			?>
            <div class="delete-all-players-container">
                <label for="type-to-delete-players">Type "DELETE" and select "Delete all players" button to delete all
                    players.</label>
                <input id="type-to-delete-players" type="text" name="delete_confirm" value=""/>
                <button class="button button-danger" name="delete_all_players" type="submit">Delete all players</button>
            </div>
        </form>

		<?php
		if ( isset( $_POST['delete_all_players'] ) && check_admin_referer( 'delete_all_players_nonce', 'delete_all_players_nonce_field' ) ) {
			if ( isset( $_POST['delete_confirm'] ) && strtoupper( trim( $_POST['delete_confirm'] ) ) === 'DELETE' ) {
				delete_all_players();
			} else {
				echo '<p>Please type "DELETE" to confirm.</p>';
			}
		}
		?>

        <!-- Delete All Teams Form -->
        <form method="post">
			<?php
			wp_nonce_field( 'delete_all_teams_nonce', 'delete_all_teams_nonce_field' );
			?>
            <div class="delete-all-teams-container">
                <label for="type-to-delete-teams">Type "DELETE" and select "Delete all teams" button to delete all
                    teams.</label>
                <input id="type-to-delete-teams" type="text" name="delete_confirm" value=""/>
                <button class="button button-danger" name="delete_all_teams" type="submit">Delete all teams</button>
            </div>
        </form>

		<?php
		if ( isset( $_POST['delete_all_teams'] ) && check_admin_referer( 'delete_all_teams_nonce', 'delete_all_teams_nonce_field' ) ) {
			if ( isset( $_POST['delete_confirm'] ) && strtoupper( trim( $_POST['delete_confirm'] ) ) === 'DELETE' ) {
				delete_all_teams();
			} else {
				echo '<p>Please type "DELETE" to confirm.</p>';
			}
		}
		?>
    </div>
	<?php
}

/**
 * Parses JSON data and updates or creates the CPT post data
 *
 * @param $json_file string
 *
 * @return void
 */
function player_import_from_json( string $json_file ): void {
	$json_data = file_get_contents( $json_file );
	$players   = json_decode( $json_data, true );

	if ( json_last_error() !== JSON_ERROR_NONE ) {
		echo '<p>Invalid JSON data.</p>';

		return;
	}

	if ( isset( $players['teams'] ) ) {
		foreach ( $players['teams'] as $team ) {
			if ( empty( $team['uid'] ) ) {
				$date_prefix = date( 'Ymd' );
				$hash        = strtoupper( substr( md5( 'team' ), 0, 8 ) );
				$uid         = 'UID-' . $date_prefix . $hash;
				$team_uid    = $uid;
			} else {
				$team_uid = $team['uid'];
			}
			$team_post_id = player_import_get_team_post_id( $team_uid );

			if ( $team_post_id ) {
				player_import_update_team_post( $team_post_id, $team );
			} else {
				player_import_create_team_post( $team );
			}

			if ( isset( $team['players'] ) ) {
				foreach ( $team['players'] as $player ) {
					$post_id = player_import_get_post_id( $player['id'] );
					if ( $post_id ) {
						player_import_update_post( $post_id, $player );
					} else {
						player_import_create_post( $player );
					}
				}
			}
		}
	}

	if ( isset( $players['freeAgents'] ) ) {
		foreach ( $players['freeAgents'] as $player ) {
			$post_id = player_import_get_post_id( $player['id'] );
			if ( $post_id ) {
				player_import_update_post( $post_id, $player );
			} else {
				player_import_create_post( $player );
			}
		}
	}
	echo '<p>Players imported successfully.</p>';
}

/**
 * Get post ID from player ID
 *
 * @param string $player_id
 *
 * @return false|int
 */
function player_import_get_post_id( string $player_id ): bool|int {
	$query = new WP_Query( [
		'post_type'      => 'player',
		'meta_key'       => 'player_id',
		'meta_value'     => $player_id,
		'posts_per_page' => 1,
	] );
	if ( $query->have_posts() ) {
		return $query->posts[0]->ID;
	}

	return false;
}

/**
 * Get post ID from team UID
 *
 * @param string $team_uid
 *
 * @return false|int
 */
function player_import_get_team_post_id( string $team_uid ): false|int {
	$query = new WP_Query( [
		'post_type'      => 'team',
		'meta_key'       => 'team_uid',
		'meta_value'     => $team_uid,
		'posts_per_page' => 1,
	] );
	if ( $query->have_posts() ) {
		return $query->posts[0]->ID;
	}

	return false;
}

function player_import_create_post( $player ): void {
	$post_data = [
		'post_title'  => $player['name'],
		'post_type'   => 'player',
		'post_status' => 'publish',
	];

	$post_id = wp_insert_post( $post_data );

	if ( $post_id ) {
		update_post_meta( $post_id, 'player_id', $player['id'] );
		player_import_update_post( $post_id, $player );
	}
}

/**
 * Creates a new post for the CPT Team
 *
 * @param $team array
 *
 * @return int | WP_Error
 */
function player_import_create_team_post( array $team ): int|WP_Error {
	$post_data = [
		'post_title'  => $team['name'],
		'post_type'   => 'team',
		'post_status' => 'publish',
	];
	$post_id   = wp_insert_post( $post_data );

	if ( $post_id ) {
		update_post_meta( $post_id, 'team_uid', $team['id'] );
		player_import_update_team_post( $post_id, $team );
	}

	return $post_id;
}

function player_import_update_post( $post_id, $player ): void {
	update_post_meta( $post_id, 'position', sanitize_text_field( $player['position'] ?? '' ) );
	update_post_meta( $post_id, 'batting_average', sanitize_text_field( $player['stats']['battingAverage'] ?? 0 ) );
	update_post_meta( $post_id, 'home_runs', intval( $player['stats']['homeRuns'] ?? 0 ) );
	update_post_meta( $post_id, 'RBIs', intval( $player['stats']['RBIs'] ?? 0 ) );
	update_post_meta( $post_id, 'stolen_bases', intval( $player['stats']['stolenBases'] ?? 0 ) );
	update_post_meta( $post_id, 'ERA', sanitize_text_field( $player['stats']['ERA'] ?? 0 ) );
	update_post_meta( $post_id, 'strikeouts', intval( $player['stats']['strikeouts'] ?? 0 ) );
	update_post_meta( $post_id, 'walks', intval( $player['stats']['walks'] ?? 0 ) );
	update_post_meta( $post_id, 'fielding_percentage', sanitize_text_field( $player['stats']['fieldingPercentage'] ?? 0 ) );
}

function player_import_update_team_post( $post_id ): void {
	$current_user = wp_get_current_user();
	$owner        = $current_user->user_login;
	$date_prefix  = date( 'Ymd' );
	$hash         = strtoupper( substr( md5( $owner ), 0, 8 ) );
	$uid          = 'UID-' . $date_prefix . $hash;

	update_post_meta( $post_id, 'uid', $uid );
	update_post_meta( $post_id, 'owner', $owner );
}

/**
 * Delete all players from the custom post type.
 */
function delete_all_players(): void {
	$args = [
		'post_type'      => 'player',
		'posts_per_page' => - 1,
		'post_status'    => 'any',
	];

	$players = get_posts( $args );

	if ( ! empty( $players ) ) {
		foreach ( $players as $player ) {
			wp_delete_post( $player->ID, true );
		}
		echo '<div class="updated"><p>All players have been deleted.</p></div>';
	} else {
		echo '<div class="error"><p>No players found to delete.</p></div>';
	}
}

/**
 * Delete all teams from the custom post type.
 */
function delete_all_teams(): void {
	$args = [
		'post_type'      => 'team',
		'posts_per_page' => - 1,
		'post_status'    => 'any',
	];

	$teams = get_posts( $args );

	if ( ! empty( $teams ) ) {
		foreach ( $teams as $team ) {
			wp_delete_post( $team->ID, true );
		}
		echo '<div class="updated"><p>All teams have been deleted.</p></div>';
	} else {
		echo '<div class="error"><p>No teams found to delete.</p></div>';
	}
}