<?php
/**
 * Register custom meta fields for baseball player stats
 */
function register_player_meta() {
    register_meta('post', 'batting_average', [
        'type' => 'string',
        'description' => 'Batting Average',
        'single' => true,
        'show_in_rest' => true,
    ]);

    register_meta('post', 'home_runs', [
        'type' => 'number',
        'description' => 'Home Runs',
        'single' => true,
        'show_in_rest' => true,
    ]);

    register_meta('post', 'RBIs', [
        'type' => 'number',
        'description' => 'Runs Batted In',
        'single' => true,
        'show_in_rest' => true,
    ]);

    register_meta('post', 'stolen_bases', [
        'type' => 'number',
        'description' => 'Stolen Bases',
        'single' => true,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'register_player_meta');

// Add a meta box for player stats
function add_player_meta_boxes() {
    add_meta_box(
        'player_stats_meta_box',
        'Player Stats',
        'display_player_stats_meta_box',
        'player',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_player_meta_boxes');

// Display the meta box fields
function display_player_stats_meta_box($post) {
    $batting_average = get_post_meta($post->ID, 'batting_average', true);
    $home_runs = get_post_meta($post->ID, 'home_runs', true);
    $RBIs = get_post_meta($post->ID, 'RBIs', true);
    $stolen_bases = get_post_meta($post->ID, 'stolen_bases', true);
    ?>
    <label for="batting_average">Batting Average:</label>
    <input type="text" name="batting_average" value="<?= esc_attr($batting_average); ?>" /><br>

    <label for="home_runs">Home Runs:</label>
    <input type="number" name="home_runs" value="<?= esc_attr($home_runs); ?>" /><br>

    <label for="RBIs">RBIs:</label>
    <input type="number" name="RBIs" value="<?= esc_attr($RBIs); ?>" /><br>

    <label for="stolen_bases">Stolen Bases:</label>
    <input type="number" name="stolen_bases" value="<?= esc_attr($stolen_bases); ?>" /><br>
    <?php
}

/**
 * Save the meta fields
 */
function save_player_stats_meta($post_id) {
    update_post_meta($post_id, 'batting_average', sanitize_text_field($_POST['batting_average']));
    update_post_meta($post_id, 'home_runs', intval($_POST['home_runs']));
    update_post_meta($post_id, 'RBIs', intval($_POST['RBIs']));
    update_post_meta($post_id, 'stolen_bases', intval($_POST['stolen_bases']));
}
add_action('save_post', 'save_player_stats_meta');