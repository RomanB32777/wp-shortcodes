<?php

function render_shortcode_organization_cards(
	$query,
	$columns = 1,
	$is_enable_slider = '1',
	$card_style = 'thin'
) {
	while ( $query->have_posts() ) :
		$query->the_post();

		$item_classes = 'w-1/4';

		if ( 1 === $columns ) {
			$item_classes = 'w-full';
		} elseif ( 2 === $columns ) {
			$item_classes = 'w-[calc(100%/2-1.25rem)]';
		} elseif ( 3 === $columns ) {
			$item_classes = 'w-[calc(100%/3-1.25rem)]';
		}

		if ( boolval( $is_enable_slider ) ) {
			$item_classes .= ' swiper-slide !h-auto';
		}

		?>

		<div class="organization-item duration-200 <?php echo esc_attr( $item_classes ); ?>">

			<?php
			if ( 'thin' === $card_style ) {
				include plugin_dir_path( __FILE__ ) . 'parts/single/style-thin.php';
			} elseif ( 'wide' === $card_style ) {
				include plugin_dir_path( __FILE__ ) . 'parts/single/style-wide.php';
			} elseif ( 'compact' === $card_style ) {
				include plugin_dir_path( __FILE__ ) . 'parts/single/style-compact.php';
			}
			?>

		</div>

		<?php

	endwhile;
	wp_reset_postdata();
}

add_shortcode( 'organizations-shortcode-custom', 'organizations_shortcode_custom' );
function organizations_shortcode_custom( $atts ) {

	ob_start();

	$attributes = shortcode_atts(
		array(
			'items_number'                  => 9,
			'exclude_id'                    => '',
			'extract_id'                    => '',
			'pick_id'                       => '',
			'columns'                       => 1,
			'card_style'                    => 'thin',
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
		),
		$atts,
	);

	$block_id                      = uniqid();
	$items_number                  = intval( $attributes['items_number'] );
	$exclude_id                    = $attributes['exclude_id'];
	$extract_id                    = $attributes['extract_id'];
	$columns                       = intval( $attributes['columns'] );
	$card_style                    = $attributes['card_style'];
	$order                         = $attributes['order'];
	$order_by                      = $attributes['order_by'];
	$title                         = $attributes['title'];
	$is_with_pagination            = $attributes['is_with_pagination'];
	$is_enable_slider              = $attributes['is_enable_slider'];
	$is_loop_slider                = $attributes['is_loop_slider'];
	$is_disable_autoplay           = $attributes['is_disable_autoplay'];
	$slider_autoplay_delay         = intval( $attributes['slider_autoplay_delay'] );
	$slider_mobile_slides_per_view = intval( $attributes['slider_mobile_slides_per_view'] );
	$slider_tablet_slides_per_view = intval( $attributes['slider_tablet_slides_per_view'] );
	$slider_laptop_slides_per_view = intval( $attributes['slider_laptop_slides_per_view'] );
	$slider_mobile_space_between   = intval( $attributes['slider_mobile_space_between'] );
	$slider_tablet_space_between   = intval( $attributes['slider_tablet_space_between'] );
	$slider_laptop_space_between   = intval( $attributes['slider_laptop_space_between'] );

	if ( 'rating' === $order_by ) {
		$order_by = 'meta_value_num';
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
		'post_type'           => 'organization',
		'post__not_in'        => $exclude_id_array,
		'post__in'            => $extract_id_array,
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'meta_key'            => 'organization_overall_rating',
		'orderby'             => array( $order_by => $order ),
		'ignore_sticky_posts' => 1,
	);

	$organizations_query = new WP_Query( $args );

	if ( $organizations_query->have_posts() ) {
		?>

		<div class="shortcode-organizations-wrapper relative" id="shortcode-organizations-<?php echo esc_attr( $block_id ); ?>">
			<?php if ( $title ) { ?>
				<h5 class="block-title font-lineSeedJp mb-6 md:text-2xl">
					<span><?php echo esc_html( $title ); ?></span>
				</h5>
			<?php } ?>

			<div class="overflow-hidden pb-14">
				<div
					<?php if ( boolval( $is_enable_slider ) ) { ?>
						class='swiper-shortcode-slider'
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
					<?php } ?>
				>
					<?php

					$wrap_classes       = array(
						'shortcode-cards',
						boolval( $is_enable_slider ) ? 'swiper-wrapper lg:!flex lg:!gap-5 lg:flex-wrap' : 'flex gap-5 flex-wrap',
					);
					$wrap_classes_names = esc_attr( implode( ' ', $wrap_classes ) );

					?>

					<div class="<?php echo esc_attr( $wrap_classes_names ); ?>">

						<?php
						render_shortcode_organization_cards(
							$organizations_query,
							$columns,
							$is_enable_slider,
							$card_style
						);
						?>

					</div>

					<?php if ( boolval( $is_enable_slider ) ) { ?>
						<div class="swiper-pagination [&>*]:mr-3 [&>*:last-child]:mr-0 lg:hidden"></div>
					<?php } ?>

					<?php if ( boolval( $is_with_pagination ) && $organizations_query->post_count >= $items_number ) { ?>

						<?php

							$more_text = __( 'Show more', 'custom-shortcodes-plugin' );
							$less_text = __( 'Show less', 'custom-shortcodes-plugin' );

						?>
						<div class="more-btn font-lineSeedJp my-7 text-primary text-base text-center">
							<span>
								<?php echo esc_html( $more_text ); ?>
							</span>
							<img
								src="<?php echo esc_url( plugins_url( '/src/assets/icons/arrow.svg', __FILE__ ) ); ?>"
								class="load-more mx-auto cursor-pointer duration-200"
								data-items-number="<?php echo esc_attr( $items_number ); ?>"
								data-columns-number="<?php echo esc_attr( $columns ); ?>"
								data-order-by="<?php echo esc_attr( $order_by ); ?>"
								data-order="<?php echo esc_attr( $order ); ?>"
								data-exclude-id="<?php echo esc_attr( $exclude_id ); ?>"
								data-enable-slider="<?php echo esc_attr( $is_enable_slider ); ?>"
								data-card-style="<?php echo esc_attr( $card_style ); ?>"
								data-block-id="<?php echo esc_attr( $block_id ); ?>"
								data-more-text="<?php echo esc_attr( $more_text ); ?>"
								data-less-text="<?php echo esc_attr( $less_text ); ?>"
								alt='<?php echo esc_attr( $more_text ); ?>'
							/>
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

add_action( 'init', 'organizations_shortcode_custom' );
