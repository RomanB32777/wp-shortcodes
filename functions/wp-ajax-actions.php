<?php

function ajax_load_casinos_shortcode_custom_4()
{
    $itemsNumber      = 9;
    $paged            = 1;
    $orderBy      	  = '';
    $order     	      = '';
	$exclude_id_array = '';
	$external_link    = '1';
	$stars_number     = '5';

	$queryParams = wp_unslash($_POST);

	if (isset($queryParams['itemsNumber'])) {
        $itemsNumber = (int) $queryParams['itemsNumber'];
    }
	if (isset($queryParams['paged'])) {
        $paged = (int) $queryParams['paged'];
    }
	if (isset($queryParams['orderBy']) && is_string($queryParams['orderBy'])) {
        $orderBy = trim($queryParams['orderBy']);
    }
	if (isset($queryParams['order']) && is_string($queryParams['order'])) {
        $order = trim($queryParams['order']);
    }
	if (isset($queryParams['starsNumber']) && is_string($queryParams['starsNumber'])) {
        $stars_number = trim($queryParams['starsNumber']);
    }
	if (isset($queryParams['externalLink'])) {
		$external_link = filter_var($queryParams['externalLink'], FILTER_VALIDATE_BOOLEAN);
	}
	if (isset($queryParams['excludeId']) && is_string($queryParams['excludeId'])) {
        $exclude_id_array = explode(',', trim($queryParams['excludeId']));
    }

	$args = array(
		'posts_per_page' => $itemsNumber,
		'paged'          => $paged,
		'post_type'      => 'casino',
		'post__not_in'   => $exclude_id_array,
		'post_status'    => 'publish',
		'meta_key' => 'casino_overall_rating',
		'orderby'  => array( $orderBy => $order, 'title' => $order ),
	);

    $query = new WP_Query($args);

	aces_render_casinos_shortcode_custom_4($query, $external_link, $stars_number);

	if ($paged == $query->max_num_pages) { ?>
		<div id="is-all-pages"></div>
	<?php }

	die;
}

add_action('wp_ajax_load_casinos_shortcode_custom_4', 'ajax_load_casinos_shortcode_custom_4');
add_action('wp_ajax_nopriv_load_casinos_shortcode_custom_4', 'ajax_load_casinos_shortcode_custom_4');
