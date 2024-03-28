<?php
global $post;

$external_link          = esc_url( get_post_meta( get_the_ID(), 'organization_external_link', true ) );
$button_title           = esc_html( get_post_meta( get_the_ID(), 'organization_button_title', true ) );
$overall_rating         = esc_html( get_post_meta( get_the_ID(), 'organization_overall_rating', true ) );
$permalink_button_title = esc_html( get_post_meta( get_the_ID(), 'organization_permalink_button_title', true ) );
$post_thumbnail_url     = get_the_post_thumbnail_url();
$mobile_image_id        = esc_html( get_post_meta( get_the_ID(), 'organization_mobile_image', true ) );
$src_mobile_image       = wp_get_attachment_image_src(
	$mobile_image_id,
	array(
		300,
		200,
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

<div class="h-full border main-border border-primary p-4 md:!p-7">
	<div class="mb-3 text-center md:!text-left">
		<a
			href="<?php the_permalink(); ?>"
			title="<?php the_title_attribute(); ?>"
			class="shortcode-link font-lineSeedJp text-xl font-bold no-underline duration-200 hover:text-secondary"
		>
			<?php get_the_title() ? the_title() : the_ID(); ?>
		</a>
	</div>

	<div class="flex flex-col gap-x-5 gap-y-3 justify-between md:!flex-row">
		<div class="relative">
			<div class="relative aspect-h-1 aspect-w-1 overflow-hidden bg-gray-200 w-full h-40 md:!w-40 lg:aspect-none">
				<a class="shortcode-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php if ( wp_get_attachment_image( get_post_thumbnail_id() ) ) { ?>
						<img
							class="hidden h-full w-full object-cover object-center md:!block"
							src="<?php echo esc_url( $post_thumbnail_url ); ?>"
							alt="<?php echo esc_attr( $post_title_attr ); ?>"
							width="160"
							height="160"
						>
						<img
							class="h-full w-full object-cover object-top md:hidden"
							src="<?php echo esc_url( $src_mobile_image ? $src_mobile_image[0] : $post_thumbnail_url ); ?>"
							alt="<?php echo esc_attr( $post_title_attr ); ?>"
							width="300"
							height="200"
						>
					<?php } ?>

					<div class="image-content absolute inset-0 flex flex-col justify-center items-center text-white pt-10 md:!pt-5">
						<?php if ( function_exists( 'custom_star_rating' ) ) { ?>
							<?php
								$rating_wrapper_classes = array(
									'flex justify-center items-center gap-x-2 mb-2',
									( intval( $rating_stars_number_value ) > 5 ? 'w-3/4 pt-5' : 'w-full' ),
								);

								$rating_wrapper_classnames = implode( ' ', $rating_wrapper_classes );
								?>

							<div class="<?php echo esc_attr( $rating_wrapper_classnames ); ?>">
								<?php
									custom_star_rating(
										array(
											'rating'       => $overall_rating,
											'stars_number' => $rating_stars_number_value,
											'wrapper_classes' => 'justify-center flex-wrap gap-x-1',
											'star_classes' => 'w-4 h-4',
										)
									);
								?>
								<span class="font-lineSeedJp text-sm">
									<?php echo esc_html( number_format( round( $overall_rating, 1 ), 1, '.', ',' ) ); ?>
								</span>
							</div>
						<?php } ?>

						<p class="font-lineSeedJp text-base">
							<?php echo esc_html( $permalink_button_title ); ?>
						</p>
					</div>

				</a>
			</div>
		</div>

		<div class="flex flex-col justify-center gap-y-2 flex-1">
			<a
				href="<?php echo esc_url( $external_link_url ); ?>"
				title="<?php echo esc_attr( $button_title ); ?>"
				class="main-button shortcode-link font-lineSeedJp text-xs font-bold text-center py-3 px-4"

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
				class="shortcode-link font-lineSeedJp border main-border border-primary text-xs text-dark font-bold text-center py-3 px-4"
			>
				<span>
					<?php echo esc_html( $permalink_button_title ); ?>
				</span>
			</a>
		</div>
	</div>
</div>
