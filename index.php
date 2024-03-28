<?php

/*
Plugin Name: Custom Shosrtcodes
Plugin URI: https://test.com/
Description: The plugin with custom shortcodes
Version: 2.0.0
Author: Test.com
Author URI: https://test.com/
License: GNU General Public License v3 or later
License URI: http://test.com
Text Domain: custom-shortcodes
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function enqueue_shortcodes_versioned_style( $handle, $path = '', $deps = array(), $media = 'all' ) {
	$style_url = plugin_dir_url( __FILE__ ) . $path;

	wp_register_style( $handle, $style_url, $deps, @filemtime( $style_url ), $media );
	wp_enqueue_style( $handle );
}

function enqueue_shortcodes_versioned_script( $handle, $path = '', $depth = array() ) {
	$main_path = plugin_dir_url( __FILE__ ) . $path;

	wp_register_script(
		$handle,
		$main_path,
		$depth,
		@filemtime( $main_path ),
		array(
			'in_footer' => true,
			'strategy'  => 'async',
		)
	);
	wp_enqueue_script( $handle );
}

/**  Connecting style files for the plugin - Start  */
function style_shortcodes() {
	if ( ! wp_style_is( 'wp_custom_main_style', 'enqueued' ) ) {
		enqueue_shortcodes_versioned_style( 'wp_custom_shortcodes_style', 'dist/css/main.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'style_shortcodes' );

/**  Connecting style files for the plugin - End  */

/**  Connecting js files for the plugin - Start  */
function script_shortcodes() {
	wp_enqueue_script( 'jquery' );

	enqueue_shortcodes_versioned_script( 'shortcodes-swiper', 'dist/js/swiper.js' );
	enqueue_shortcodes_versioned_script( 'wp_custom_shortcodes_script', 'dist/js/main.js', array( 'jquery', 'shortcodes-swiper' ) );
	wp_localize_script( 'wp_custom_shortcodes_script', 'ajax_data', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'script_shortcodes' );

/**  Connecting js files for the plugin - End  */

require_once plugin_dir_path( __FILE__ ) . '/organizations-shortcode-custom.php';

require_once plugin_dir_path( __FILE__ ) . '/functions/wp-ajax-actions.php';
