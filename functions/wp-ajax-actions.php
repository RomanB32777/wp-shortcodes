<?php

function ajax_load_more_posts() {
	$items_number     = 9;
	$post_type        = 'organization';
	$meta_key         = 'organization_overall_rating';
	$paged            = 1;
	$order_by         = '';
	$order            = '';
	$exclude_id_array = '';
	$columns_number   = 1;
	$is_enable_slider = '1';

	$query_params = wp_unslash( $_POST );

	if ( isset( $query_params['itemsNumber'] ) ) {
		$items_number = (int) $query_params['itemsNumber'];
	}
	if ( isset( $query_params['postType'] ) && is_string( $query_params['postType'] ) ) {
		$post_type = trim( $query_params['postType'] );
	}
	if ( isset( $query_params['metaKey'] ) && is_string( $query_params['metaKey'] ) ) {
		$meta_key = trim( $query_params['metaKey'] );
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

	$args = array(
		'posts_per_page' => $items_number,
		'paged'          => $paged,
		'post_type'      => $post_type,
		'post__not_in'   => $exclude_id_array,
		'post_status'    => 'publish',
		'meta_key'       => $meta_key,
		'orderby'        => array(
			$order_by => $order,
			'title'   => $order,
		),
	);

	$query = new WP_Query( $args );

	render_shortcode_post_cards(
		$query,
		array(
			'columns'          => $columns_number,
			'is_enable_slider' => $is_enable_slider,
			'current_page'     => $paged,
		)
	);

	if ( intval( $paged ) === intval( $query->max_num_pages ) ) { ?>
		<div id="is-all-pages"></div>
		<?php
	}

	die;
}

add_action( 'wp_ajax_load_more_posts', 'ajax_load_more_posts' );
add_action( 'wp_ajax_nopriv_load_more_posts', 'ajax_load_more_posts' );
