<?php
/**
 * Plugin Name: WP Simple Reviews
 * Plugin URI: https://www.bindig-media.de
 * Description: Simple reviews Google like
 * Version: 0.3.18
 * Author: Bindig Media GmbH
 * Author URI: https://www.bindig-media.de
 *
 */

// If ABSPATH is defined, we assume WP is calling us.
// Otherwise, this could be an illicit direct request.
if (!defined('ABSPATH')) exit();

/**
 * Vendor
 */
require_once('vendor/autoload.php');
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://kernl.us/api/v1/updates/6099271361f0b6df9ce4dd79/',
    __FILE__,
    'wp-simple-reviews'
);


/**
 * Includes
 *
 */
require_once('inc/index.php');


/**
 * Textdomain
 *
 */
function wpsr_load_textdomain() {
    load_plugin_textdomain('wp-simple-reviews', false, basename(dirname(__FILE__)));
}
add_action('plugins_loaded', 'wpsr_load_textdomain');


/**
 * CSS/JS
 *
 */
function wpsr_load_scripts() {
    $version = '0.3.18';
    $version = time();
    
    wp_register_style('wp-simple-reviews', plugin_dir_url(__FILE__) . 'css/wp-simple-reviews.css', false, $version, 'all');
    wp_enqueue_style('wp-simple-reviews');

    wp_enqueue_script('starrr', plugin_dir_url(__FILE__) . 'js/starrr.js', array('jquery'), '0.2.1', true);
    wp_enqueue_script('wp-simple-reviews', plugin_dir_url(__FILE__) . 'js/wp-simple-reviews.js', array('jquery'), $version, true);
}
add_action('wp_enqueue_scripts', 'wpsr_load_scripts');