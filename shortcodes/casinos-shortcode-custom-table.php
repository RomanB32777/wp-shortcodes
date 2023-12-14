<?php

add_shortcode('aces-casinos-custom-table', 'aces_casinos_shortcode_custom_table');

function aces_casinos_shortcode_custom_table($atts)
{

    ob_start();

    // Define attributes and their defaults

    extract(shortcode_atts(array(
        'items_number' => 6,
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

        <div class="space-shortcode-wrap space-shortcode-custom-table relative">
            <div class="space-shortcode-wrap-ins relative">

                <?php if ($title) { ?>
                    <div class="space-block-title relative">
                        <span><?php echo esc_html($title); ?></span>
                    </div>
                <?php } ?>

                <div class="space-organizations-3-archive-items space-shortcode-table-items owl-carousel-items box-100 relative">

                    <?php while ($casino_query->have_posts()) : $casino_query->the_post();
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
                        $casino_external_link = esc_url(get_post_meta(get_the_ID(), 'casino_external_link', true));
                        $casino_button_title = esc_html(get_post_meta(get_the_ID(), 'casino_button_title', true));
                        $organization_popup_hide = esc_attr(get_post_meta(get_the_ID(), 'aces_organization_popup_hide', true));
                        $casino_overall_rating = esc_html(get_post_meta(get_the_ID(), 'casino_overall_rating', true));
                        $organization_popup_title = esc_html(get_post_meta(get_the_ID(), 'aces_organization_popup_title', true));
                        $organization_detailed_tc = wp_kses(get_post_meta(get_the_ID(), 'casino_detailed_tc', true), $casino_allowed_html);
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

                        if (get_option('casinos_read_review_title')) {
                            $permalink_button_title = esc_html(get_option('casinos_read_review_title'));
                        } else {
                            $permalink_button_title = esc_html__('Read Review', 'aces');
                        }

                        if ($organization_popup_title) {
                            $custom_popup_title = $organization_popup_title;
                        } else {
                            $custom_popup_title = esc_html__('T&Cs Apply', 'aces');
                        }

                        $games_count = '';
                    ?>

                        <div class="space-organizations-3-archive-item-ins space-shortcode-table-item space-card-hover relative">
                            <div class="space-organizations-3-archive-item-title box-100 relative">
                                <div class="space-organizations-3-title-box text-start relative">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                </div>
                            </div>


                            <div class="space-organizations-3-archive-item-logo relative">
                                <div class="space-organizations-3-archive-item-logo-ins relative">
                                    <?php
                                    $post_title_attr = the_title_attribute('echo=0');
                                    if (wp_get_attachment_image(get_post_thumbnail_id())) { ?>
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <img class="desktop" width="160" height="160" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo $post_title_attr ?>">
                                            <img class="mobile" width="300" height="200" src="<?php echo $mobile_logo; ?>" alt="<?php echo $post_title_attr ?>">
                                        </a>
                                    <?php }
                                    ?>
                                </div>

                                <div class="space-organizations-3-archive-item-rating">
                                    <div class="space-organizations-3-archive-item-rating-ins box-100 text-center relative">

                                        <?php if ($games_count) { ?>
                                            <div class="space-organizations-3-archive-item-units relative">
                                                <i class="fas fa-dice"></i> <span><?php echo esc_html($games_count); ?></span>
                                                <?php if ($games_count == 1) {
                                                    echo esc_html__('game', 'aces');
                                                } else {
                                                    echo esc_html__('games', 'aces');
                                                } ?>
                                            </div>
                                        <?php } ?>

                                        <?php if (function_exists('aces_star_rating')) { ?>
                                            <div class="space-organizations-3-archive-item-rating-box relative">
                                                <?php aces_star_rating(
                                                    array(
                                                        'rating' => $casino_overall_rating,
                                                        'type' => 'rating',
                                                        'stars_number' => $casino_rating_stars_number_value
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

                            <div class="space-organizations-3-archive-item-button box-50 relative">
                                <div class="space-organizations-3-archive-item-button-ins box-100 text-center relative">
                                    <a href="<?php echo esc_url($external_link_url); ?>" title="<?php echo esc_attr($button_title); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow" <?php } ?> class="primary-btn"><?php echo esc_html($button_title); ?></a>

                                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr($permalink_button_title); ?>"><?php echo esc_html($permalink_button_title); ?></a>
                                </div>
                            </div>

                        </div>
                    <?php endwhile; ?>

                </div>

            </div>

        </div>


<?php
        wp_reset_postdata();
        $casino_items = ob_get_clean();
        return $casino_items;
    }
}

add_action('init', 'aces_casinos_shortcode_custom_table');
