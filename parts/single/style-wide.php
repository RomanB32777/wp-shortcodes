<?php

global $post;

$allowed_html = array(
	'a'      => array(
		'href'   => true,
		'title'  => true,
		'target' => true,
		'rel'    => true,
	),
	'br'     => array(),
	'em'     => array(),
	'strong' => array(),
	'span'   => array(
		'class' => true,
	),
	'div'    => array(
		'class' => true,
	),
	'p'      => array(),
);

$current_post_type      = $post->post_type;
$shortcode_content      = get_post_meta( get_the_ID(), "{$current_post_type}_shortcode_content", true );
$promotional_code       = esc_html( get_post_meta( get_the_ID(), "{$current_post_type}_promotional_code", true ) );
$bonus_currency_value   = esc_html( get_post_meta( get_the_ID(), "{$current_post_type}_bonus_currency_value", true ) );
$external_link          = esc_url( get_post_meta( get_the_ID(), "{$current_post_type}_external_link", true ) );
$button_title           = esc_html( get_post_meta( get_the_ID(), "{$current_post_type}_button_title", true ) );
$overall_rating         = esc_html( get_post_meta( get_the_ID(), "{$current_post_type}_overall_rating", true ) );
$permalink_button_title = esc_html( get_post_meta( get_the_ID(), "{$current_post_type}_permalink_button_title", true ) );
$bonus_title            = get_post_meta( get_the_ID(), "{$current_post_type}_bonus_title", true );
$post_thumbnail_url     = get_the_post_thumbnail_url();
$mobile_image_id        = esc_html( get_post_meta( get_the_ID(), "{$current_post_type}_mobile_image", true ) );
$referral_links         = array();

if ( function_exists( 'get_field' ) ) {
	$referral_links = get_field( 'referral_links' );
}

if ( 'organization' === $current_post_type ) {
	$apps = get_posts(
		array(
			'post_type'      => 'app',
			'posts_per_page' => -1,
			'orderby'        => 'post_title',
			'order'          => 'ASC',
			'post_parent'    => get_the_ID(),

		)
	);

	$payment_methods = get_posts(
		array(
			'post_type'      => 'payment',
			'posts_per_page' => -1,
			'orderby'        => 'post_title',
			'order'          => 'ASC',
			'post_parent'    => get_the_ID(),

		)
	);
}

$mobile_image_size = 44;
$src_mobile_image  = wp_get_attachment_image_src(
	$mobile_image_id,
	array(
		$mobile_image_size,
		$mobile_image_size,
	)
);

if ( empty( $button_title ) ) {
	if ( 'organization' === $current_post_type ) {
		if ( get_option( 'organizations_play_now_title' ) ) {
			$button_title = esc_html( get_option( 'organizations_play_now_title' ) );
		} else {
			$button_title = esc_html__( 'Play Now', 'custom-shortcodes-plugin' );
		}
	} elseif ( get_option( "{$current_post_type}_button_title" ) ) {
			$button_title = esc_html( get_option( "{$current_post_type}_button_title" ) );
	} else {
		$button_title = esc_html__( 'Follow', 'custom-shortcodes-plugin' );
	}
}

if ( empty( $permalink_button_title ) ) {
	if ( 'organization' === $current_post_type ) {
		if ( get_option( 'organizations_read_review_title' ) ) {
			$permalink_button_title = esc_html( get_option( 'organizations_read_review_title' ) );
		} else {
			$permalink_button_title = esc_html__( 'Read Review', 'custom-shortcodes-plugin' );
		}
	} elseif ( get_option( "{$current_post_type}_permalink_button_title" ) ) {
		$permalink_button_title = esc_html( get_option( "{$current_post_type}_permalink_button_title" ) );
	} else {
		$permalink_button_title = esc_html__( 'Read', 'custom-shortcodes-plugin' );
	}
}

$external_link_url     = get_the_permalink();
$current_referral_link = array();

if ( $referral_links ) {
	foreach ( $referral_links as $referral_link ) {
		$curr_custom_page = $referral_link['custom_page'];

		if ( is_array( $curr_custom_page ) ) {
			$founded_id = array_filter( $curr_custom_page, fn( $item ) => $page_id === $item );

			if ( $founded_id ) {
				$current_referral_link = $referral_link;
			}
		} elseif ( $page_id === $curr_custom_page ) {
			$current_referral_link = $referral_link;
		}
	}

	if ( $current_referral_link ) {
		$external_link_url = $current_referral_link['referral_link'];
	}
}

if ( ! $current_referral_link && $external_link ) {
	$external_link_url = $external_link;
}

if ( 'organization' === $current_post_type ) {
	if ( get_option( 'custom_rating_stars_number' ) ) {
		$rating_stars_number_value = get_option( 'custom_rating_stars_number' );
	}
} elseif ( get_option( "{$current_post_type}_rating_stars_number" ) ) {
	$rating_stars_number_value = get_option( "{$current_post_type}_rating_stars_number" );
} else {
	$rating_stars_number_value = '5';
}

$post_title_attr = the_title_attribute( 'echo=0' );

?>

<div class="h-full p-4 lg:!p-5">
	<div class="flex flex-col gap-y-4 justify-between lg:!flex-row">
		<div class="flex gap-3 lg:!gap-6 lg:max-w-[75%]">
			<div class="hidden flex-1 lg:!block">
				<div class="relative aspect-h-1 aspect-w-1 overflow-hidden h-32 w-32 lg:aspect-none">
					<a
						href="<?php echo esc_url( $external_link_url ); ?>"
						title="<?php the_title_attribute(); ?>"
						rel="nofollow"
						target="_blank"
					>
						<?php if ( wp_get_attachment_image( get_post_thumbnail_id() ) ) { ?>
							<img
								class="h-full w-full rounded-xl object-cover object-center"
								src="<?php echo esc_url( $src_mobile_image ? $src_mobile_image[0] : $post_thumbnail_url ); ?>"
								alt="<?php echo esc_attr( $post_title_attr ); ?>"
								width="128"
								height="128"
							>
						<?php } ?>
					</a>
				</div>
			</div>

			<div class="flex flex-col gap-y-3 gap-6 w-full divide-y divide-white-light lg:!divide-x lg:!divide-y-0 lg:!flex-row">
				<div class="flex flex-col justify-between gap-3">
					<div class="flex gap-3">
						<div class="lg:hidden">
							<div class="relative aspect-h-1 aspect-w-1 overflow-hidden w-11 h-11 lg:aspect-none">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php if ( wp_get_attachment_image( get_post_thumbnail_id() ) ) { ?>
										<img
											class="h-full w-full rounded-xl object-cover object-center"
											src="<?php echo esc_url( $src_mobile_image ? $src_mobile_image[0] : $post_thumbnail_url ); ?>"
											alt="<?php echo esc_attr( $post_title_attr ); ?>"
											width="<?php echo esc_attr( $mobile_image_size ); ?>"
											height="<?php echo esc_attr( $mobile_image_size ); ?>"
										>
									<?php } ?>
								</a>
							</div>


						</div>

						<div class="flex flex-col gap-0.5 lg:w-48 lg:!gap-3">
							<a
								href="<?php the_permalink(); ?>"
								title="<?php the_title_attribute(); ?>"
								class="shortcode-link hyphens-none text-2xl font-bold no-underline duration-200 hover:text-secondary lg:!text-3xl lg:!hyphens-auto"
							>
								<?php get_the_title() ? the_title() : the_ID(); ?>
							</a>

							<?php if ( function_exists( 'custom_star_rating' ) ) { ?>
								<?php
									$rating_wrapper_classes = array(
										'flex relative items-center gap-x-2',
										( intval( $rating_stars_number_value ) > 5 ? 'w-3/4' : 'w-full' ),
									);

									$rating_wrapper_classnames = implode( ' ', $rating_wrapper_classes );
									?>

								<div class="<?php echo esc_attr( $rating_wrapper_classnames ); ?>">
									<?php
										custom_star_rating(
											array(
												'rating' => $overall_rating,
												'rating_stars_number' => $rating_stars_number_value,
												'wrapper_classes' => 'justify-center flex-wrap gap-x-1',
												'star_classes' => 'w-5 h-5',
											)
										);
									?>

									<?php if ( $overall_rating ) { ?>
										<span class="text-xl text-dark font-medium">
											<?php echo esc_html( number_format( round( $overall_rating, 1 ), 1, '.', ',' ) ); ?>
										</span>
									<?php } ?>
								</div>
							<?php } ?>

						</div>
					</div>

					<div class="flex items-center gap-4">
						<?php if ( 'organization' === $current_post_type && count( $apps ) ) { ?>
							<div class="flex items-center gap-3 p-2 bg-white-light rounded-2xl">
								<?php
								$app_platform_image_size = 16;

								foreach ( $apps as $app ) {

									$app_platforms = wp_get_post_terms( $app->ID, 'app-platform' );

									?>

									<?php

									foreach ( $app_platforms as $app_platform ) {
										$app_platform_id       = $app_platform->term_id;
										$app_platform_image_id = get_term_meta( $app_platform_id, 'taxonomy-image-id', true );
										$app_platform_link     = get_post_meta( $app->ID, "app_platform_link_{$app_platform->term_id}", true );

										if ( empty( $app_platform_link ) || empty( $app_platform_image_id ) ) {
											continue;
										}

										$src_app_platform_image = wp_get_attachment_image_src(
											$app_platform_image_id,
											array(
												$app_platform_image_size,
												$app_platform_image_size,
											)
										);

										?>

										<a
											href="<?php echo esc_url( $app_platform_link ); ?>"
											title="<?php echo esc_attr( get_the_title( $app->ID ) ); ?>"
											rel="nofollow"
											target="_blank"
										>
											<div class="flex justify-center overflow-hidden h-5 w-5">
												<img
													class="w-auto h-full object-cover object-center"
													src="<?php echo esc_url( $src_app_platform_image[0] ); ?>"
													alt="<?php echo esc_attr( $app_platform->name ); ?>"
													width="<?php echo esc_attr( $app_platform_image_size ); ?>"
													height="<?php echo esc_attr( $app_platform_image_size ); ?>"
												>
											</div>
										</a>

										<?php } ?>
									</a>
								<?php } ?>
							</div>
						<?php } ?>

						<?php if ( 'organization' === $current_post_type && count( $payment_methods ) ) { ?>
							<div class="flex items-center gap-3">
								<?php
								$payment_system_image_width  = 25;
								$payment_system_image_height = 16;

								$all_payment_systems = array();

								foreach ( $payment_methods as $payment_method ) {

									$payment_systems = wp_get_post_terms( $payment_method->ID, 'payment-system' );

									foreach ( $payment_systems as $payment_system ) {
										$payment_system_image_id = get_term_meta( $payment_system->term_id, 'taxonomy-image-id', true );

										if ( empty( $payment_system_image_id ) ) {
											continue;
										}

										$src_payment_system_image = wp_get_attachment_image_src(
											$payment_system_image_id,
											array(
												$payment_system_image_width,
												$payment_system_image_height,
											)
										);

										$all_payment_systems[ $src_payment_system_image[0] ] = $payment_system->name;
									}
								}

								foreach ( $all_payment_systems as $image_src => $payment_name ) {
									?>
									<div class="flex justify-center overflow-hidden w-8 h-6 bg-white-light py-1 rounded-md">
										<img
											class="w-auto h-full object-cover object-center"
											src="<?php echo esc_url( $image_src ); ?>"
											alt="<?php echo esc_attr( $payment_name ); ?>"
											width="<?php echo esc_attr( $payment_system_image_width ); ?>"
											height="<?php echo esc_attr( $payment_system_image_height ); ?>"
										>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>

				<?php if ( $shortcode_content || $bonus_title || $bonus_currency_value || $promotional_code ) { ?>
					<div class="flex flex-col gap-y-2 pt-3 lg:pl-6 lg:!pt-0">

						<?php $is_exist_bonus_promo_blocks = $bonus_currency_value || $promotional_code; ?>

						<?php if ( $is_exist_bonus_promo_blocks ) { ?>
							<div class="flex flex-col gap-2 lg:!flex-row">
								<?php if ( $bonus_currency_value ) { ?>
									<div class="flex-1 bg-grizzly-light px-4 py-2 rounded-xl text-center">
										<p class="mb-1 font-medium text-xl text-dark">
											<?php echo esc_html( $bonus_label ); ?>
										</p>

										<p class="bonus-currency-value text-3xl font-bold text-yellow">
											<?php echo esc_html( $bonus_currency_value ); ?>
										</p>
									</div>
								<?php } ?>

								<?php if ( $promotional_code ) { ?>
									<div
										class="copy-button flex-1 group duration-200 self-stretch bg-grizzly-light flex items-center justify-between gap-10 px-4 py-2 rounded-xl cursor-pointer"
										data-copy-text="<?php echo esc_attr( $promotional_code ); ?>"
									>
										<div>
											<p>
												<?php echo esc_html( $promo_label ); ?>
											</p>

											<span class="font-semibold text-xl text-dark lg:!text-2xl">
												<?php echo esc_html( $promotional_code ); ?>
											</span>
										</div>

										<div class="main-link flex-none text-lg font-medium uppercase relative">
											<div class="flex items-center gap-2 duration-200 group-[.active]:!hidden">
												<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
													<path
														d="M5.83366 5.83334V2.50001C5.83366 2.27899 5.92146 2.06703 6.07774 1.91075C6.23402 1.75447 6.44598 1.66667 6.66699 1.66667H17.5003C17.7213 1.66667 17.9333 1.75447 18.0896 1.91075C18.2459 2.06703 18.3337 2.27899 18.3337 2.50001V13.3333C18.3337 13.5544 18.2459 13.7663 18.0896 13.9226C17.9333 14.0789 17.7213 14.1667 17.5003 14.1667H14.167V17.4942C14.167 17.9575 13.7928 18.3333 13.3278 18.3333H2.50616C2.39593 18.3334 2.28676 18.3118 2.18489 18.2697C2.08303 18.2276 1.99048 18.1657 1.91253 18.0878C1.83459 18.0099 1.77278 17.9173 1.73065 17.8154C1.68851 17.7136 1.66688 17.6044 1.66699 17.4942L1.66949 6.67251C1.66949 6.20917 2.04366 5.83334 2.50866 5.83334H5.83366ZM7.50033 5.83334H13.3278C13.7912 5.83334 14.167 6.20751 14.167 6.67251V12.5H16.667V3.33334H7.50033V5.83334ZM3.33616 7.50001L3.33366 16.6667H12.5003V7.50001H3.33616Z"
														fill="currentColor"
													/>
												</svg>
											</div>

											<?php if ( $external_link ) { ?>
												<a
													href="<?php echo esc_url( $external_link ); ?>"
													title="<?php echo esc_attr( $button_title ); ?>"
													class="hidden no-underline items-center gap-2 duration-200 group-[.active]:flex"
													rel="nofollow"
													target="_blank"
												>
													<span>
														<?php echo esc_html( $copy_promo_label ); ?>
													</span>

													<svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16" fill="none">
														<path
															d="M10 16L20 8L10 0V5C4.477 5 0 9.477 0 15C0 15.273 0.0100002 15.543 0.0319996 15.81C1.54 12.95 4.542 11 8 11H10V16Z"
															fill="currentColor"
														/>
													</svg>
												</a>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
							</div>
						<?php } ?>


						<?php if ( $bonus_title ) { ?>
							<div class="text-xl font-bold text-dark">
								<?php echo wp_kses( $bonus_title, $allowed_html ); ?>
							</div>
						<?php } ?>

						<?php if ( ! $is_exist_bonus_promo_blocks && $shortcode_content ) { ?>
							<div class="text-base text-grizzly">
								<?php echo wp_kses( $shortcode_content, $allowed_html ); ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>

		<div class="flex gap-3 lg:w-[20%] lg:flex-col">
			<a
				href="<?php echo esc_url( $external_link_url ); ?>"
				title="<?php echo esc_attr( $button_title ); ?>"
				class="main-button shortcode-link flex-1 text-lg font-medium text-center py-3 px-4 rounded-xl no-underline lg:!flex-none"

				<?php if ( $external_link ) { ?>
					target="_blank" rel="nofollow"
				<?php } ?>
			>
				<span>
					<?php echo esc_html( $button_title ); ?>
				</span>
			</a>
			<a
				href="<?php the_permalink(); ?>"
				title="<?php echo esc_attr( $permalink_button_title ); ?>"
				class="secondary-button shortcode-link flex-1 border text-lg font-medium text-center py-3 px-4 rounded-xl no-underline lg:!flex-none"
			>
				<span>
					<?php echo esc_html( $permalink_button_title ); ?>
				</span>
			</a>
		</div>
	</div>
</div>
