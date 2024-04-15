<?php

global $post;

$allowed_html           = array(
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
$short_desc             = get_post_meta( get_the_ID(), 'organization_short_desc', true );
$external_link          = esc_url( get_post_meta( get_the_ID(), 'organization_external_link', true ) );
$button_title           = esc_html( get_post_meta( get_the_ID(), 'organization_button_title', true ) );
$overall_rating         = esc_html( get_post_meta( get_the_ID(), 'organization_overall_rating', true ) );
$permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'organization_permalink_button_title', true ) );
$bonus_title            = get_post_meta( get_the_ID(), 'organization_bonus_title', true );
$post_thumbnail_url     = get_the_post_thumbnail_url();
$mobile_image_id        = esc_html( get_post_meta( get_the_ID(), 'organization_mobile_image', true ) );
$devices                = wp_get_post_terms( get_the_ID(), 'device' );
$payment_methods        = wp_get_post_terms( get_the_ID(), 'payment-method' );

$mobile_image_size = 44;
$src_mobile_image  = wp_get_attachment_image_src(
	$mobile_image_id,
	array(
		$mobile_image_size,
		$mobile_image_size,
	)
);

if ( empty( $button_title ) ) {
	if ( get_option( 'organizations_play_now_title' ) ) {
		$button_title = esc_html( get_option( 'organizations_play_now_title' ) );
	} else {
		$button_title = esc_html__( 'Play Now', 'custom-shortcodes-plugin' );
	}
}

if ( empty( $permalink_button_title ) ) {
	if ( get_option( 'organizations_read_review_title' ) ) {
		$permalink_button_title = esc_html( get_option( 'organizations_read_review_title' ) );
	} else {
		$permalink_button_title = esc_html__( 'Read Review', 'custom-shortcodes-plugin' );
	}
}

if ( $external_link ) {
	$external_link_url = $external_link;
} else {
	$external_link_url = get_the_permalink();
}

if ( get_option( 'custom_rating_stars_number' ) ) {
	$rating_stars_number_value = get_option( 'custom_rating_stars_number' );
} else {
	$rating_stars_number_value = '5';
}

$post_title_attr = the_title_attribute( 'echo=0' );

?>

<div class="h-full p-4 md:!p-5">
	<div class="flex flex-col gap-y-4 justify-between md:!flex-row">
		<div class="flex gap-3 md:!gap-6 md:max-w-[75%]">
			<div class="hidden flex-1 md:!block">
				<div class="relative aspect-h-1 aspect-w-1 overflow-hidden h-32 w-32 lg:aspect-none">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
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

			<div class="flex flex-col gap-y-3 gap-6 w-full divide-y divide-white-light md:!divide-x md:!divide-y-0 md:!flex-row">
				<div class="flex flex-col justify-between gap-3">
					<div class="flex gap-3">
						<div class="md:hidden">
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

						<div class="flex flex-col gap-0.5 md:!gap-3">
							<a
								href="<?php the_permalink(); ?>"
								title="<?php the_title_attribute(); ?>"
								class="shortcode-link text-2xl font-bold no-underline duration-200 hover:text-secondary md:!text-3xl"
							>
								<?php get_the_title() ? the_title() : the_ID(); ?>
							</a>

							<?php if ( function_exists( 'custom_star_rating' ) ) { ?>
								<?php
									$rating_wrapper_classes = array(
										'flex items-center gap-x-2',
										( intval( $rating_stars_number_value ) > 5 ? 'w-3/4' : 'w-full' ),
									);

									$rating_wrapper_classnames = implode( ' ', $rating_wrapper_classes );
									?>

								<div class="<?php echo esc_attr( $rating_wrapper_classnames ); ?>">
									<?php
										custom_star_rating(
											array(
												'rating' => $overall_rating,
												'wrapper_classes' => 'justify-center flex-wrap gap-x-1',
												'star_classes' => 'w-5 h-5',
											)
										);
									?>
									<span class="text-xl text-dark font-medium">
										<?php echo esc_html( number_format( round( $overall_rating, 1 ), 1, '.', ',' ) ); ?>
									</span>
								</div>
							<?php } ?>

						</div>
					</div>

					<div class="flex items-center gap-4">
						<?php if ( count( $devices ) ) { ?>
							<div class="flex items-center gap-3 p-2 bg-white-light rounded-2xl">
								<?php
								$device_image_size = 16;

								foreach ( $devices as $device ) {

									$device_image_id = get_term_meta( $device->term_id, 'taxonomy-image-id', true );

									if ( empty( $device_image_id ) ) {
										continue;
									}

									$src_device_image = wp_get_attachment_image_src(
										$device_image_id,
										array(
											$device_image_size,
											$device_image_size,
										)
									);

									?>

									<div class="flex justify-center overflow-hidden h-5 w-5">
										<img
											class="w-auto h-full object-cover object-center"
											src="<?php echo esc_url( $src_device_image[0] ); ?>"
											alt="<?php echo esc_attr( $device->name ); ?>"
											width="<?php echo esc_attr( $device_image_size ); ?>"
											height="<?php echo esc_attr( $device_image_size ); ?>"
										>
									</div>

								<?php } ?>
							</div>
						<?php } ?>

						<?php if ( count( $payment_methods ) ) { ?>
							<div class="flex items-center gap-3">
								<?php
								$payment_method_image_width  = 25;
								$payment_method_image_height = 16;


								foreach ( $payment_methods as $payment_method ) {

									$payment_method_image_id = get_term_meta( $payment_method->term_id, 'taxonomy-image-id', true );

									if ( empty( $payment_method_image_id ) ) {
										continue;
									}

									$src_payment_method_image = wp_get_attachment_image_src(
										$payment_method_image_id,
										array(
											$payment_method_image_width,
											$payment_method_image_height,
										)
									);

									?>

									<div class="flex justify-center overflow-hidden w-8 h-6 bg-white-light py-1 rounded-md">
										<img
											class="w-auto h-full object-cover object-center"
											src="<?php echo esc_url( $src_payment_method_image[0] ); ?>"
											alt="<?php echo esc_attr( $payment_method->name ); ?>"
											width="<?php echo esc_attr( $payment_method_image_width ); ?>"
											height="<?php echo esc_attr( $payment_method_image_height ); ?>"
										>
									</div>

								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>

				<?php if ( $short_desc || $bonus_title ) { ?>
					<div class="flex-1 pt-3 md:pl-6 md:!pt-0">
						<?php if ( $bonus_title ) { ?>
							<div class="text-xl font-bold text-dark">
								<?php echo wp_kses( $bonus_title, $allowed_html ); ?>
							</div>
						<?php } ?>

						<?php if ( $short_desc ) { ?>
							<div class="text-base text-grizzly mt-2">
								<?php echo wp_kses( $short_desc, $allowed_html ); ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>

		<div class="flex gap-3 md:w-[20%] md:flex-col md:justify-center">
			<a
				href="<?php echo esc_url( $external_link_url ); ?>"
				title="<?php echo esc_attr( $button_title ); ?>"
				class="main-button shortcode-link flex-1 text-lg font-medium text-center py-3 px-4 rounded-xl no-underline md:!flex-none"

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
				class="secondary-button shortcode-link flex-1 border text-lg font-medium text-center py-3 px-4 rounded-xl no-underline md:!flex-none"
			>
				<span>
					<?php echo esc_html( $permalink_button_title ); ?>
				</span>
			</a>
		</div>
	</div>
</div>
