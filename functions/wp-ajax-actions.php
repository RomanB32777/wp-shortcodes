<?php

function ajax_load_casinos_shortcode_custom_4() {
	$items_number     = 9;
	$paged            = 1;
	$order_by         = '';
	$order            = '';
	$exclude_id_array = '';
	$external_link    = '1';
	$stars_number     = '5';

	$query_params = wp_unslash( $_POST );

	if ( isset( $query_params['itemsNumber'] ) ) {
		$items_number = (int) $query_params['itemsNumber'];
	}
	if ( isset( $query_params['paged'] ) ) {
		$paged = (int) $query_params['paged'];
	}
	if ( isset( $query_params['orderBy'] ) && is_string( $query_params['orderBy'] ) ) {
		$order_by = trim( $query_params['orderBy'] );
	}
	if ( isset( $query_params['order'] ) && is_string( $query_params['order'] ) ) {
		$order = trim( $query_params['order'] );
	}
	if ( isset( $query_params['starsNumber'] ) && is_string( $query_params['starsNumber'] ) ) {
		$stars_number = trim( $query_params['starsNumber'] );
	}
	if ( isset( $query_params['externalLink'] ) ) {
		$external_link = filter_var( $query_params['externalLink'], FILTER_VALIDATE_BOOLEAN );
	}
	if ( isset( $query_params['excludeId'] ) && is_string( $query_params['excludeId'] ) ) {
		$exclude_id_array = explode( ',', trim( $query_params['excludeId'] ) );
	}

	$args = array(
		'posts_per_page' => $items_number,
		'paged'          => $paged,
		'post_type'      => 'casino',
		'post__not_in'   => $exclude_id_array,
		'post_status'    => 'publish',
		'meta_key'       => 'casino_overall_rating',
		'orderby'        => array(
			$order_by => $order,
			'title'   => $order,
		),
	);

	$query = new WP_Query( $args );

	aces_render_casinos_shortcode_custom_4( $query, $external_link, $stars_number );

	if ( $paged == $query->max_num_pages ) { ?>
		<div id="is-all-pages"></div>
		<?php
	}

	die;
}

add_action( 'wp_ajax_load_casinos_shortcode_custom_4', 'ajax_load_casinos_shortcode_custom_4' );
add_action( 'wp_ajax_nopriv_load_casinos_shortcode_custom_4', 'ajax_load_casinos_shortcode_custom_4' );
