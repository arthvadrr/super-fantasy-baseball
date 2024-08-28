<?php
function player_importer_menu() {
	add_menu_page(
		'Player Importer',
		'Player Importer',
		'manage_options',
		'player-importer',
		'player_importer_page'
	);
}

function player_importer_page() {
	?>
    <div class="wrap">
        <h1>Player Importer</h1>
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
    </div>
	<?php
}

function player_import_from_json($json_file) {
	$json_data = file_get_contents( $json_file );
	$players   = json_decode( $json_data, true );

	if (json_last_error() !== JSON_ERROR_NONE) {
		echo '<p>Invalid JSON data.</p>';
		return;
	}

	if ( isset( $players['teams'] ) ) {
		foreach ( $players['teams'] as $team ) {
			$team_id = $team['id'];
            $team_post_id = player_import_get_team_post_id($team_id);

			if ($team_post_id) {
				player_import_update_team_post($team_post_id, $team);
			} else {
				player_import_create_team_post($team);
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

	if (isset($players['freeAgents'])) {
		foreach ($players['freeAgents'] as $player) {
			$post_id = player_import_get_post_id($player['id']);
			if ($post_id) {
				player_import_update_post($post_id, $player);
			} else {
				player_import_create_post($player);
			}
		}
	}
	echo '<p>Players imported successfully.</p>';
}

function player_import_get_post_id($player_id) {
	$query = new WP_Query([
		'post_type' => 'player',
		'meta_key' => 'player_id',
		'meta_value' => $player_id,
		'posts_per_page' => 1,
	]);
	if ($query->have_posts()) {
		return $query->posts[0]->ID;
	}
	return false;
}

function player_import_create_post($player) {
	$post_data = [
		'post_title' => $player['name'],
		'post_type' => 'player',
		'post_status' => 'publish',
	];

	$post_id = wp_insert_post($post_data);

	if ($post_id) {
		update_post_meta($post_id, 'player_id', $player['id']);
		player_import_update_post($post_id, $player);
	}
}

function player_import_create_team_post($team) {
	$post_data = [
		'post_title' => $team['name'],
		'post_type' => 'team',
		'post_status' => 'publish',
	];
	$post_id = wp_insert_post($post_data);

	if ($post_id) {
		update_post_meta($post_id, 'team_id', $team['id']);
		player_import_update_team_post($post_id, $team);
	}

	return $post_id;
}

function player_import_update_post($post_id, $player) {
	update_post_meta($post_id, 'batting_average', sanitize_text_field($player['stats']['battingAverage']));
	update_post_meta($post_id, 'home_runs', intval($player['stats']['homeRuns']));
	update_post_meta($post_id, 'RBIs', intval($player['stats']['RBIs']));
	update_post_meta($post_id, 'stolen_bases', intval($player['stats']['stolenBases'] ?? 0));
	update_post_meta($post_id, 'ERA', sanitize_text_field($player['stats']['ERA'] ?? ''));
	update_post_meta($post_id, 'strikeouts', intval($player['stats']['strikeouts'] ?? 0));
	update_post_meta($post_id, 'walks', intval($player['stats']['walks'] ?? 0));
	update_post_meta($post_id, 'fielding_percentage', sanitize_text_field($player['stats']['fieldingPercentage'] ?? ''));
}

function player_import_update_team_post($post_id, $team) {
	update_post_meta($post_id, 'team_id', $team['id']);
	update_post_meta($post_id, 'team_name', sanitize_text_field($team['name']));
}