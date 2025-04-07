<?php

function render_shortcode_post_cards( $query, $attributes = array() ) {
	$defaults = array(
		'columns'                   => 1,
		'is_enable_slider'          => '1',
		'current_page'              => 1,
		'page_id'                   => 0,
		'first_border_color'        => '#a7e79c',
		'second_border_color'       => '#e5e79c',
		'third_border_color'        => '#e7c09c',
		'first_badge_content'       => '#1',
		'first_badge_bg_color'      => '#5db24e',
		'first_badge_content_color' => '#ffffff',
		'bonus_label'               => '',
		'promo_label'               => '',
		'copy_promo_label'          => '',

	);

	$parsed_args = wp_parse_args( $attributes, $defaults );

	$columns                   = $parsed_args['columns'];
	$is_enable_slider          = $parsed_args['is_enable_slider'];
	$current_page              = $parsed_args['current_page'];
	$page_id                   = $parsed_args['page_id'];
	$first_border_color        = $parsed_args['first_border_color'];
	$second_border_color       = $parsed_args['second_border_color'];
	$third_border_color        = $parsed_args['third_border_color'];
	$first_badge_content       = $parsed_args['first_badge_content'];
	$first_badge_bg_color      = $parsed_args['first_badge_bg_color'];
	$first_badge_content_color = $parsed_args['first_badge_content_color'];
	$bonus_label               = $parsed_args['bonus_label'];
	$promo_label               = $parsed_args['promo_label'];
	$copy_promo_label          = $parsed_args['copy_promo_label'];

	while ( $query->have_posts() ) :
		$query->the_post();

		$current_post_index = $query->current_post;
		$item_classes       = array();

		if ( 1 === $columns ) {
			$item_classes[] = 'w-full';
		} elseif ( 2 === $columns ) {
			$item_classes[] = 'w-[calc(100%/2-1.25rem)]';
		} elseif ( 3 === $columns ) {
			$item_classes[] = 'w-[calc(100%/3-1.25rem)]';
		} else {
			$item_classes[] = 'w-1/4';
		}

		if ( boolval( $is_enable_slider ) ) {
			$item_classes[] = 'swiper-slide !h-auto';
		}

		$item_classnames   = implode( ' ', $item_classes );
		$item_border_color = 'transparent';

		if ( 1 === $current_page ) {
			if ( 0 === $current_post_index ) {
				$item_border_color = $first_border_color;
			} elseif ( 1 === $current_post_index ) {
				$item_border_color = $second_border_color;
			} elseif ( 2 === $current_post_index ) {
				$item_border_color = $third_border_color;
			}
		}

		?>

		<div
			class="post-item relative duration-200 border-4 bg-white rounded-xl md:!rounded-3xl <?php echo esc_attr( $item_classnames ); ?>"
			style="border-color: <?php echo esc_attr( $item_border_color ); ?>;"
		>

			<?php if ( 1 === $current_page && 0 === $current_post_index && $first_badge_content ) { ?>

				<div
					class="absolute -top-3 -left-4 px-4 font-bold rounded-3xl"
					style="
						background-color: <?php echo esc_attr( $first_badge_bg_color ); ?>;
						color: <?php echo esc_attr( $first_badge_content_color ); ?>;
					"
				>
					<?php echo esc_html( $first_badge_content ); ?>
				</div>

			<?php } ?>

			<?php include plugin_dir_path( __FILE__ ) . 'parts/single/style-wide.php'; ?>

		</div>

		<?php

	endwhile;
	wp_reset_postdata();
}

add_shortcode( 'posts-shortcode-custom', 'posts_shortcode_custom' );
function posts_shortcode_custom( $atts ) {

	ob_start();

	$attributes = shortcode_atts(
		array(
			'items_number'                  => 9,
			'post_type'                     => 'organization',
			'meta_key'                      => 'organization_overall_rating',
			'exclude_id'                    => '',
			'extract_id'                    => '',
			'pick_id'                       => '',
			'columns'                       => 1,
			'order'                         => '',
			'order_by'                      => '',
			'title'                         => '',
			'is_with_pagination'            => '0',
			'is_enable_slider'              => '1',
			'is_loop_slider'                => '1',
			'is_disable_autoplay'           => '0',
			'slider_autoplay_delay'         => 5000,
			'slider_mobile_slides_per_view' => 1,
			'slider_tablet_slides_per_view' => 1,
			'slider_laptop_slides_per_view' => 2,
			'slider_mobile_space_between'   => 24,
			'slider_tablet_space_between'   => 24,
			'slider_laptop_space_between'   => 24,
			'first_border_color'            => '#a7e79c',
			'second_border_color'           => '#e5e79c',
			'third_border_color'            => '#e7c09c',
			'first_badge_content'           => '#1',
			'first_badge_bg_color'          => '#5db24e',
			'first_badge_content_color'     => '#ffffff',
			'bonus_label'                   => esc_html__( 'Bonus up to', 'custom-theme' ),
			'promo_label'                   => esc_html__( 'Promo Code', 'custom-theme' ),
			'copy_promo_label'              => esc_html__( 'visit site', 'custom-theme' ),
			'show_more_label'               => esc_html__( 'Show more', 'custom-theme' ),
			'show_less_label'               => esc_html__( 'Show less', 'custom-theme' ),
		),
		$atts,
	);

	$block_id                      = uniqid();
	$items_number                  = intval( $attributes['items_number'] );
	$post_type                     = $attributes['post_type'];
	$meta_key                      = $attributes['meta_key'];
	$exclude_id                    = $attributes['exclude_id'];
	$extract_id                    = $attributes['extract_id'];
	$columns                       = intval( $attributes['columns'] );
	$order                         = $attributes['order'];
	$order_by                      = $attributes['order_by'];
	$title                         = $attributes['title'];
	$page_id                       = get_queried_object_id();
	$is_with_pagination            = $attributes['is_with_pagination'];
	$is_enable_slider              = boolval( $attributes['is_enable_slider'] );
	$is_loop_slider                = $attributes['is_loop_slider'];
	$is_disable_autoplay           = $attributes['is_disable_autoplay'];
	$slider_autoplay_delay         = intval( $attributes['slider_autoplay_delay'] );
	$slider_mobile_slides_per_view = intval( $attributes['slider_mobile_slides_per_view'] );
	$slider_tablet_slides_per_view = intval( $attributes['slider_tablet_slides_per_view'] );
	$slider_laptop_slides_per_view = intval( $attributes['slider_laptop_slides_per_view'] );
	$slider_mobile_space_between   = intval( $attributes['slider_mobile_space_between'] );
	$slider_tablet_space_between   = intval( $attributes['slider_tablet_space_between'] );
	$slider_laptop_space_between   = intval( $attributes['slider_laptop_space_between'] );
	$first_border_color            = $attributes['first_border_color'];
	$second_border_color           = $attributes['second_border_color'];
	$third_border_color            = $attributes['third_border_color'];
	$first_badge_content           = $attributes['first_badge_content'];
	$first_badge_bg_color          = $attributes['first_badge_bg_color'];
	$first_badge_content_color     = $attributes['first_badge_content_color'];
	$bonus_label                   = $attributes['bonus_label'];
	$promo_label                   = $attributes['promo_label'];
	$copy_promo_label              = $attributes['copy_promo_label'];
	$show_more_label               = $attributes['show_more_label'];
	$show_less_label               = $attributes['show_less_label'];

	if ( 'rating' === $order_by ) {
		$order_by = 'meta_value_num';
	}

	if ( $items_number < 3 ) {
		$items_number = 3;
	}

	$exclude_id_array = '';
	$extract_id_array = '';

	if ( $exclude_id ) {
		$exclude_id_array = explode( ',', $exclude_id );
	}

	if ( $extract_id ) {
		$extract_id_array = explode( ',', $extract_id );
	}

	$args = array(
		'posts_per_page'      => $items_number,
		'post_type'           => $post_type,
		'post__not_in'        => $exclude_id_array,
		'post__in'            => $extract_id_array,
		'post_status'         => 'publish',
		'meta_key'            => $meta_key,
		'ignore_sticky_posts' => 1,
	);

	if ( empty( $order_by ) && ! empty( $extract_id ) ) {
		$order_by = 'post__in';

		$args['orderby'] = $order_by;
	} else {
		$args['orderby'] = array( $order_by => $order );
	}

	$posts_query = new WP_Query( $args );

	if ( $posts_query->have_posts() ) {
		?>

		<div class="shortcode-post-wrapper relative font-inter" id="shortcode-posts-<?php echo esc_attr( $block_id ); ?>">
			<?php if ( $title ) { ?>
				<h5 class="block-title mb-6 md:text-2xl">
					<span><?php echo esc_html( $title ); ?></span>
				</h5>
			<?php } ?>

			<?php

			$shortcode_wrap_classes = array(
				$is_enable_slider ? 'overflow-hidden pb-14' : '',
			);

			$shortcode_wrap_classes_names = esc_attr( implode( ' ', $shortcode_wrap_classes ) );

			?>

			<div class="<?php echo esc_attr( $shortcode_wrap_classes_names ); ?>">
				<div
					<?php if ( $is_enable_slider ) { ?>
						class='swiper-slider'
						id='swiper-shortcode-<?php echo esc_attr( $block_id ); ?>'
						data-slider-loop="<?php echo esc_attr( boolval( $is_loop_slider ) ? 'true' : 'false' ); ?>"
						data-slider-disable-autoplay="<?php echo esc_attr( boolval( $is_disable_autoplay ) ? 'true' : 'false' ); ?>"
						data-slider-autoplay-delay="<?php echo esc_attr( $slider_autoplay_delay ); ?>"
						data-slides-per-view-xs="<?php echo esc_attr( $slider_mobile_slides_per_view ); ?>"
						data-slides-per-view-sm="<?php echo esc_attr( $slider_tablet_slides_per_view ); ?>"
						data-slides-per-view-md="<?php echo esc_attr( $slider_laptop_slides_per_view ); ?>"
						data-slides-space-between-xs="<?php echo esc_attr( $slider_mobile_space_between ); ?>"
						data-slides-space-between-sm="<?php echo esc_attr( $slider_tablet_space_between ); ?>"
						data-slides-space-between-md="<?php echo esc_attr( $slider_laptop_space_between ); ?>"
						data-slider-destroy-breakpoint="lg"
					<?php } ?>
				>
					<?php

					$is_visible_more_btn = boolval( $is_with_pagination ) && $posts_query->post_count < $posts_query->found_posts;

					$cards_wrap_classes = array(
						'shortcode-cards',
						$is_enable_slider ? 'swiper-wrapper lg:!flex lg:!gap-5 lg:flex-wrap' : 'flex gap-5 flex-wrap',
						$is_visible_more_btn ? 'mb-6 md:!mb-11' : '',
					);

					$cards_wrap_classes_names = esc_attr( implode( ' ', $cards_wrap_classes ) );

					?>

					<div class="<?php echo esc_attr( $cards_wrap_classes_names ); ?>">

						<?php
						render_shortcode_post_cards(
							$posts_query,
							array(
								'columns'              => $columns,
								'page_id'              => $page_id,
								'is_enable_slider'     => $is_enable_slider,
								'first_border_color'   => $first_border_color,
								'second_border_color'  => $second_border_color,
								'third_border_color'   => $third_border_color,
								'first_badge_content'  => $first_badge_content,
								'first_badge_bg_color' => $first_badge_bg_color,
								'first_badge_content_color' => $first_badge_content_color,
								'bonus_label'          => $bonus_label,
								'promo_label'          => $promo_label,
								'copy_promo_label'     => $copy_promo_label,

							)
						);
						?>

					</div>

					<?php if ( $is_enable_slider ) { ?>

						<div class="swiper-pagination [&>*]:mr-3 [&>*:last-child]:mr-0 lg:hidden"></div>

					<?php } elseif ( $is_visible_more_btn ) { ?>

						<div class="flex justify-center">
							<button
								class="more-btn w-80 py-5 bg-grizzly-light text-dark font-bold text-xl rounded-xl"
								data-items-number="<?php echo esc_attr( $items_number ); ?>"
								data-post-type="<?php echo esc_attr( $post_type ); ?>"
								data-meta-key="<?php echo esc_attr( $meta_key ); ?>"
								data-columns-number="<?php echo esc_attr( $columns ); ?>"
								data-order-by="<?php echo esc_attr( $order_by ); ?>"
								data-order="<?php echo esc_attr( $order ); ?>"
								data-exclude-id="<?php echo esc_attr( $exclude_id ); ?>"
								data-extract-id="<?php echo esc_attr( $extract_id ); ?>"
								data-enable-slider="<?php echo esc_attr( $is_enable_slider ); ?>"
								data-block-id="<?php echo esc_attr( $block_id ); ?>"
								data-page-id="<?php echo esc_attr( $page_id ); ?>"
								data-more-text="<?php echo esc_attr( $show_more_label ); ?>"
								data-less-text="<?php echo esc_attr( $show_less_label ); ?>"
							>
								<span>
									<?php echo esc_html( $show_more_label ); ?>
								</span>
							</button>
						</div>

					<?php } ?>
				</div>
			</div>
		</div>

		<?php
		$items = ob_get_clean();
		return $items;
	}
}

add_action( 'init', 'posts_shortcode_custom' );
