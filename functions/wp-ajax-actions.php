<?php

function ajax_load_more_organizations() {
	$items_number     = 9;
	$paged            = 1;
	$order_by         = '';
	$order            = '';
	$exclude_id_array = '';
	$columns_number   = 1;
	$is_enable_slider = '1';
	$card_style       = 'thin';

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
	if ( isset( $query_params['excludeId'] ) && is_string( $query_params['excludeId'] ) ) {
		$exclude_id_array = explode( ',', trim( $query_params['excludeId'] ) );
	}
	if ( isset( $query_params['columnsNumber'] ) ) {
		$columns_number = (int) $query_params['columnsNumber'];
	}
	if ( isset( $query_params['isEnableSlider'] ) ) {
		$is_enable_slider = filter_var( $query_params['isEnableSlider'], FILTER_VALIDATE_BOOLEAN );
	}
	if ( isset( $query_params['cardStyle'] ) && is_string( $query_params['cardStyle'] ) ) {
		$card_style = trim( $query_params['cardStyle'] );
	}

	$args = array(
		'posts_per_page' => $items_number,
		'paged'          => $paged,
		'post_type'      => 'organization',
		'post__not_in'   => $exclude_id_array,
		'post_status'    => 'publish',
		'meta_key'       => 'organization_overall_rating',
		'orderby'        => array(
			$order_by => $order,
			'title'   => $order,
		),
	);

	$query = new WP_Query( $args );

	render_shortcode_organization_cards(
		$query,
		$columns_number,
		$is_enable_slider,
		$card_style
	);

	if ( intval( $paged ) === intval( $query->max_num_pages ) ) { ?>
		<div id="is-all-pages"></div>
		<?php
	}

	die;
}

add_action( 'wp_ajax_load_more_organizations', 'ajax_load_more_organizations' );
add_action( 'wp_ajax_nopriv_load_more_organizations', 'ajax_load_more_organizations' );
