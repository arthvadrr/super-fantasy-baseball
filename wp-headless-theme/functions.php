<?php
/*
Theme Name: Headless Theme for Super Fantasy Baseball
Description: A headless theme for use with a Vue.js sfb-frontend.
Author: arthvadrr@github
Version: 1.0
*/

/**
 * Disable frontend rendering
 */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);


/**
 * REST API support
 */
add_action('init', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');

    /**
     * For theme colors
     */
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Primary', 'sfb-frontend'),
            'slug'  => 'primary',
            'color' => '#0073aa',
        ),
        // Add more colors as needed
    ));
});

/**
 * Redirect to admin
 */
function redirect_frontend_to_admin()
{
    if (
        !is_admin() && !defined('DOING_AJAX' && !is_rest())) {
        wp_redirect(admin_url());
        exit;
    }
}

add_action('template_redirect', 'redirect_frontend_to_admin');