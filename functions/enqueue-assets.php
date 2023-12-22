<?php

function enqueue_time_versioned_plugin_style( $handle, $src = '', $deps = array(), $media = 'all' ) {
	global $base_dir;
	global $base_url;

	$host_path      = $base_url . $src;
	$directory_path = $base_dir . $src;

	wp_enqueue_style( $handle, $host_path, $deps, filemtime( $directory_path ), $media );
}

function enqueue_time_versioned_plugin_js( $handle, $src = '' ) {
	global $base_dir;
	global $base_url;

	$host_path      = $base_url . $src;
	$directory_path = $base_dir . $src;

	wp_register_script( $handle, $host_path, array( 'jquery' ), filemtime( $directory_path ) );
	wp_localize_script( $handle, 'ajaxData', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( $handle );
}
