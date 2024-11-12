<?php

add_shortcode( 'current-date', 'current_date_shortcode_custom' );
function current_date_shortcode_custom( $atts ) {

	ob_start();

	$attributes = shortcode_atts(
		array(
			'format' => 'Y',
		),
		$atts,
	);

	$format = $attributes['format'];

	return gmdate( $format );
}

add_action( 'init', 'current_date_shortcode_custom' );
