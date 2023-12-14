<?php

/*
Plugin Name: Custom Mercury Shosrtcodes
Plugin URI: https://test.com/
Description: The plugin fot MercuryTheme with custom shortcodes
Version: 1.1.0
Author: Test.com
Author URI: https://test.com/
License: GNU General Public License v3 or later
License URI: http://test.com
Text Domain: custom-shortcodes
*/


global $base_dir;

$base_dir = untrailingslashit(plugin_dir_path(__FILE__));
$base_url = untrailingslashit(plugin_dir_url( __FILE__ ));

include_once $base_dir . '/functions/enqueue-assets.php';

/*  Connecting style files for the plugin - Start  */

function shortcode_stylesheets() {
    enqueue_time_versioned_plugin_style('casinos-shortcode-custom-3-css', '/css/casinos-shortcode-custom-3.css');
    enqueue_time_versioned_plugin_style('casinos-shortcode-custom-4-css', '/css/casinos-shortcode-custom-4.css');
    enqueue_time_versioned_plugin_style('casinos-shortcode-custom-table-css', '/css/casinos-shortcode-custom-table.css');
}
add_action( 'wp_enqueue_scripts', 'shortcode_stylesheets' );

/*  Connecting style files for the plugin - End  */


/*  Connecting js files for the plugin - Start  */

function shortcode_scripts() {
    enqueue_time_versioned_plugin_js('casinos-shortcode-custom-4-js', '/js/casinos-shortcode-custom-4.js');
}
add_action( 'wp_enqueue_scripts', 'shortcode_scripts' );

/*  Connecting js files for the plugin - End  */


include_once $base_dir . '/shortcodes/casinos-shortcode-custom-3.php';
include_once $base_dir . '/shortcodes/casinos-shortcode-custom-4.php';
include_once $base_dir . '/shortcodes/casinos-shortcode-custom-table.php';

include_once $base_dir . '/functions/wp-ajax-actions.php';
