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

$current_post_type = $post->post_type;
$external_link     = esc_url( get_post_meta( get_the_ID(), "{$current_post_type}_external_link", true ) );
$bonus_title       = get_post_meta( get_the_ID(), "{$current_post_type}_bonus_title", true );
$button_title      = esc_html( get_post_meta( get_the_ID(), "{$current_post_type}_button_title", true ) );
$overall_rating    = esc_html( get_post_meta( get_the_ID(), "{$current_post_type}_overall_rating", true ) );

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

if ( $external_link ) {
	$external_link_url = $external_link;
} else {
	$external_link_url = get_the_permalink();
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

<div class="h-full border main-border border-primary p-4 sm:!p-7">
	<div class="flex gap-4 h-full">
		<div class="relative">
			<div class="relative aspect-h-1 aspect-w-1 overflow-hidden bg-gray-200 w-28 h-28 lg:!w-20 lg:!h-20 lg:aspect-none">
				<a class="shortcode-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php if ( wp_get_attachment_image( get_post_thumbnail_id() ) ) { ?>
						<img
							class="h-full w-full object-cover object-center"
							src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>"
							alt="<?php echo esc_attr( $post_title_attr ); ?>"
							width="80"
							height="80"
						>
					<?php } ?>

					<?php if ( function_exists( 'custom_star_rating' ) ) { ?>
						<div class="image-content absolute inset-0 flex justify-center items-center text-white pt-3">
							<?php
								custom_star_rating(
									array(
										'rating'          => $overall_rating,
										'rating_stars_number' => $rating_stars_number_value,
										'wrapper_classes' => 'justify-center flex-wrap',
									)
								);
							?>
						</div>
					<?php } ?>
				</a>
			</div>
		</div>

		<div class="flex flex-col w-full gap-y-2">
			<div>
				<a
					href="<?php the_permalink(); ?>"
					title="<?php the_title_attribute(); ?>"
					class="shortcode-link text-base font-bold no-underline duration-200 hover:text-secondary"
				>
					<?php get_the_title() ? the_title() : the_ID(); ?>
				</a>
			</div>

			<?php if ( $bonus_title ) { ?>
				<div class="text-xs">
					<?php echo wp_kses( $bonus_title, $allowed_html ); ?>
				</div>
			<?php } ?>

			<a
				href="<?php echo esc_url( $external_link_url ); ?>"
				title="<?php echo esc_attr( $button_title ); ?>"
				class="main-button shortcode-link text-xs font-bold text-center py-3 px-4 no-underline"

				<?php if ( $external_link ) { ?>
					target="_blank" rel="nofollow"
				<?php } ?>
			>
				<span>
					<?php echo esc_html( $button_title ); ?>
				</span>
			</a>
		</div>
	</div>
</div>
