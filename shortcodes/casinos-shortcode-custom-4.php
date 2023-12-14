<?php

function aces_render_casinos_shortcode_custom_4($query, $external_link = true, $rating_stars_number = '5') {
	$count = 0;

	while ($query->have_posts()) : $query->the_post();
		global $post;
		$casino_allowed_html = array(
			'a' => array(
				'href' => true,
				'title' => true,
				'target' => true,
				'rel' => true
			),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
			'span' => array(
				'class' => true
			),
			'div' => array(
				'class' => true
			),
			'p' => array()
		);

		$casino_terms_desc = wp_kses(get_post_meta(get_the_ID(), 'casino_terms_desc', true), $casino_allowed_html);
		$casino_button_title = esc_html(get_post_meta(get_the_ID(), 'casino_button_title', true));
		$casino_button_notice = wp_kses(get_post_meta(get_the_ID(), 'casino_button_notice', true), $casino_allowed_html);
		$casino_permalink_button_title = esc_html(get_post_meta(get_the_ID(), 'casino_permalink_button_title', true));
		$casino_external_link = esc_url(get_post_meta(get_the_ID(), 'casino_external_link', true));
		$casino_overall_rating = esc_html(get_post_meta(get_the_ID(), 'casino_overall_rating', true));

		$organization_detailed_tc = wp_kses(get_post_meta(get_the_ID(), 'casino_detailed_tc', true), $casino_allowed_html);
		$organization_popup_hide = esc_attr(get_post_meta(get_the_ID(), 'aces_organization_popup_hide', true));
		$organization_popup_title = esc_html(get_post_meta(get_the_ID(), 'aces_organization_popup_title', true));
		$mobile_logo = get_field("mobile_logo", $post->ID);

		if ($casino_button_title) {
			$button_title = $casino_button_title;
		} else {
			if (get_option('casinos_play_now_title')) {
				$button_title = esc_html(get_option('casinos_play_now_title'));
			} else {
				$button_title = esc_html__('Play Now', 'aces');
			}
		}

		if ($external_link) {
			if ($casino_external_link) {
				$external_link_url = $casino_external_link;
			} else {
				$external_link_url = get_the_permalink();
			}
		} else {
			$external_link_url = get_the_permalink();
		}

		if ($organization_popup_title) {
			$custom_popup_title = $organization_popup_title;
		} else {
			$custom_popup_title = esc_html__('T&Cs Apply', 'aces');
		}

		if ($casino_permalink_button_title) {
			$permalink_button_title = $casino_permalink_button_title;
		} else {
			if (get_option('casinos_read_review_title')) {
				$permalink_button_title = esc_html(get_option('casinos_read_review_title'));
			} else {
				$permalink_button_title = esc_html__('Read Review', 'aces');
			}
		}

		$count++;
	?>

		<div class="space-organizations-3-archive-item box-100 relative">
			<div class="space-organizations-3-archive-item-ins space-shortcode-4-item space-card-hover relative">
				<div class="space-organizations-3-archive-item-logo box-15 relative">
					<div class="space-organizations-3-archive-item-logo-ins relative">
						<?php
						$post_title_attr = the_title_attribute('echo=0');
						if (wp_get_attachment_image(get_post_thumbnail_id())) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<img class="desktop" width="200" height="200" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo $post_title_attr ?>">
								<img class="mobile" width="300" height="200" src="<?php echo $mobile_logo; ?>" alt="<?php echo $post_title_attr ?>">
							</a>
						<?php }
						?>
					</div>


					<div class="space-organizations-3-archive-item-rating">
						<div class="space-organizations-3-archive-item-rating-ins box-100 text-center relative">
							<?php if (function_exists('aces_star_rating')) { ?>
								<div class="space-organizations-3-archive-item-rating-box relative">
									<?php aces_star_rating(
										array(
											'rating' => $casino_overall_rating,
											'type' => 'rating',
											'stars_number' => $rating_stars_number
										)
									); ?>
									<span><?php echo esc_html(number_format(round($casino_overall_rating, 1), 1, '.', ',')); ?></span>
								</div>
							<?php } ?>

							<?php if ($organization_popup_hide == true) { ?>
								<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
									<span class="tc-apply"><?php echo esc_html($custom_popup_title); ?></span>
									<div class="tc-desc">
										<?php
										if ($organization_detailed_tc) {
											echo wp_kses($organization_detailed_tc, $casino_allowed_html);
										}
										?>
									</div>
								</div>
							<?php } ?>

							<?php if ($casino_button_notice) { ?>

								<div class="space-organizations-archive-item-button-notice relative" style="margin-top: 5px;">
									<?php echo wp_kses($casino_button_notice, $casino_allowed_html); ?>
								</div>

							<?php } ?>

						</div>
					</div>

					<div class="space-organizations-3-archive-item-logo-btn">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr($permalink_button_title); ?>"><?php echo esc_html($permalink_button_title); ?></a>
					</div>

				</div>
				<div class="space-organizations-3-archive-item-terms">

					<?php
						$post_title_attr = the_title_attribute('echo=0');
					?>
						<div class="space-organizations-3-archive-item-title box-100 relative">
							<div class="space-organizations-3-title-box text-start relative">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</div>
						</div>

					<div class="space-page-wrapper">

						<div class="space-organizations-3-archive-item-terms-ins box-100 text-start relative">
							<?php if ($casino_terms_desc) {
								echo wp_kses($casino_terms_desc, $casino_allowed_html);
							} ?>
						</div>

					</div>
				</div>

				<div class="space-organizations-3-archive-item-button box-25 relative">
					<div class="space-organizations-3-archive-item-button-ins box-100 text-center relative">
						<a href="<?php echo esc_url($external_link_url); ?>" title="<?php echo esc_attr($button_title); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow" <?php } ?> class="primary-btn"><i class="fas fa-check-circle"></i> <?php echo esc_html($button_title); ?></a>

						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr($permalink_button_title); ?>"><i class="fas fa-arrow-alt-circle-right"></i> <?php echo esc_html($permalink_button_title); ?></a>
					</div>
				</div>
			</div>
		</div>

	<?php

	endwhile;

	wp_reset_postdata();
}

add_shortcode('aces-casinos-custom-4', 'aces_casinos_shortcode_custom_4');

function aces_casinos_shortcode_custom_4($atts)
{

    ob_start();

    // Define attributes and their defaults

   	extract(shortcode_atts(array(
        'items_number' => 9,
        'external_link' => '1',
        'exclude_id' => '',
        'order' => '',
        'orderby' => '',
        'title' => ''
    ), $atts));

    if ($orderby == 'rating') {
        $orderby = 'meta_value_num';
    }

    $exclude_id_array = '';

    if ($exclude_id) {
        $exclude_id_array = explode(',', $exclude_id);
    }

	$args = array(
		'posts_per_page' => $items_number,
		'post_type'      => 'casino',
		'post__not_in'   => $exclude_id_array,
		'no_found_rows'  => true,
		'post_status'    => 'publish',
		'meta_key' => 'casino_overall_rating',
		'orderby'  => array( $orderby =>  $order, 'title' => $order )
	);

    $casino_query = new WP_Query($args);

    if ($casino_query->have_posts()) {

        if (get_option('aces_rating_stars_number')) {
            $casino_rating_stars_number_value = get_option('aces_rating_stars_number');
        } else {
            $casino_rating_stars_number_value = '5';
        }

?>

        <div class="space-shortcode-custom-4 relative">
            <div class="space-shortcode-wrap-ins relative">
                <?php if ($title) { ?>
                    <div class="space-block-title relative">
                        <span><?php echo esc_html($title); ?></span>
                    </div>
                <?php } ?>

                <div class="space-organizations-3-archive-items space-shortcode-4-items box-100 relative">
					<?php aces_render_casinos_shortcode_custom_4($casino_query, $external_link, $casino_rating_stars_number_value); ?>
                </div>
				<?php
				if ($casino_query->post_count >= $items_number) { ?>
					<div class="space-shortcode-custom-4-btn">
						<span>もっと見せる</span>
						<img
							src="<?php echo plugin_dir_url( __DIR__ ) . 'assets/arrow.svg' ?>"
							data-items-number="<?php echo $items_number; ?>"
							data-order-by="<?php echo $orderby; ?>"
							data-order="<?php echo $order; ?>"
							data-external-link="<?php echo $external_link; ?>"
							data-exclude-id="<?php echo $exclude_id; ?>"
							data-stars-number="<?php echo $casino_rating_stars_number_value; ?>"
							alt='もっと見せる'
							id="load-more"
						/>
					</div>
				<?php } ?>
            </div>
        </div>

<?php

        $casino_items = ob_get_clean();
        return $casino_items;
    }
}

add_action('init', 'aces_casinos_shortcode_custom_4');
