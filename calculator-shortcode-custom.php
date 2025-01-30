<?php

add_shortcode( 'calculator-shortcode-custom', 'calculator_shortcode_custom' );
function calculator_shortcode_custom() {
	return '<div class="calculator_app"></div>';
}

add_action( 'init', 'calculator_shortcode_custom' );

function enqueue_calculator_shortcode_assets() {
	global $post;

	if ( ! has_shortcode( $post->post_content, 'calculator-shortcode-custom' ) ) {
		return;
	}

	$assets_path = 'parts/calculator/dist/assets/';

	if ( function_exists( 'enqueue_shortcodes_versioned_script' ) ) {
		enqueue_shortcodes_versioned_script( 'shortcodes-calculator-script', $assets_path . 'index.js' );
	}

	if ( function_exists( 'enqueue_shortcodes_versioned_style' ) ) {
		enqueue_shortcodes_versioned_style( 'shortcodes-calculator-style', $assets_path . 'index.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'enqueue_calculator_shortcode_assets' );

function calculator_customizer_settings( $wp_customize ) {
	$calculator_background_color = ! empty( $_ENV['WHITE_COLOR'] ) ? $_ENV['WHITE_COLOR'] : '#fff';

	$label_color                 = ! empty( $_ENV['DARK_GRIZZLY_COLOR'] ) ? $_ENV['DARK_GRIZZLY_COLOR'] : '#2a2a2a';
	$label_icon_background_color = ! empty( $_ENV['GRIZZLY_LIGHT_COLOR'] ) ? $_ENV['GRIZZLY_LIGHT_COLOR'] : '#f9fafb';

	$input_background_color = ! empty( $_ENV['GRIZZLY_LIGHT_COLOR'] ) ? $_ENV['GRIZZLY_LIGHT_COLOR'] : '#f9fafb';
	$input_color            = ! empty( $_ENV['DARK_GRIZZLY_COLOR'] ) ? $_ENV['DARK_GRIZZLY_COLOR'] : '#2a2a2a';
	$placeholder_color      = ! empty( $_ENV['GRIZZLY_COLOR'] ) ? $_ENV['GRIZZLY_COLOR'] : '#7e7e7e';

	$error_background_color = '#fdf2f2';
	$error_color            = '#c81e1e';

	$submit_button_background_color = ! empty( $_ENV['PRIMARY_COLOR'] ) ? $_ENV['PRIMARY_COLOR'] : '#17946d';
	$reset_button_background_color  = ! empty( $_ENV['SECONDARY_COLOR'] ) ? $_ENV['SECONDARY_COLOR'] : '#e14141';
	$button_color                   = ! empty( $_ENV['BUTTONS_CONTENT_COLOR'] ) ? $_ENV['BUTTONS_CONTENT_COLOR'] : '#fff';

	/*  --- Calculator Settings ---  */

	$wp_customize->add_section(
		'calculator_settings',
		array(
			'title'    => esc_html__( 'Calculator settings', 'wp-custom-blocks' ),
			'priority' => 170,
		)
	);

	/*  --- Calculator background color ---  */

	$wp_customize->add_setting(
		'calculator_background_color',
		array(
			'default'           => $calculator_background_color,
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'calculator_background_color',
			array(
				'label'    => esc_html__( 'Calculator background color', 'custom-theme' ),
				'section'  => 'calculator_settings',
				'settings' => 'calculator_background_color',
			)
		)
	);

	/*  --- Label color ---  */

	$wp_customize->add_setting(
		'calculator_label_color',
		array(
			'default'           => $label_color,
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'calculator_label_color',
			array(
				'label'    => esc_html__( 'Label color', 'custom-theme' ),
				'section'  => 'calculator_settings',
				'settings' => 'calculator_label_color',
			)
		)
	);

	/*  --- Label icon background color ---  */

	$wp_customize->add_setting(
		'calculator_label_icon_background_color',
		array(
			'default'           => $label_icon_background_color,
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'calculator_label_icon_background_color',
			array(
				'label'    => esc_html__( 'Label icon background color', 'custom-theme' ),
				'section'  => 'calculator_settings',
				'settings' => 'calculator_label_icon_background_color',
			)
		)
	);

	/*  --- Input background color ---  */

	$wp_customize->add_setting(
		'calculator_input_background_color',
		array(
			'default'           => $input_background_color,
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'calculator_input_background_color',
			array(
				'label'    => esc_html__( 'Input background color', 'custom-theme' ),
				'section'  => 'calculator_settings',
				'settings' => 'calculator_input_background_color',
			)
		)
	);

	/*  --- Input color ---  */

	$wp_customize->add_setting(
		'calculator_input_color',
		array(
			'default'           => $input_color,
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'calculator_input_color',
			array(
				'label'    => esc_html__( 'Input color', 'custom-theme' ),
				'section'  => 'calculator_settings',
				'settings' => 'calculator_input_color',
			)
		)
	);

	/*  --- Placeholder color ---  */

	$wp_customize->add_setting(
		'calculator_placeholder_color',
		array(
			'default'           => $placeholder_color,
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'calculator_placeholder_color',
			array(
				'label'    => esc_html__( 'Placeholder color', 'custom-theme' ),
				'section'  => 'calculator_settings',
				'settings' => 'calculator_placeholder_color',
			)
		)
	);

	/*  --- Error background color ---  */

	$wp_customize->add_setting(
		'calculator_error_background_color',
		array(
			'default'           => $error_background_color,
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'calculator_error_background_color',
			array(
				'label'    => esc_html__( 'Error background color', 'custom-theme' ),
				'section'  => 'calculator_settings',
				'settings' => 'calculator_error_background_color',
			)
		)
	);

	/*  --- Error color ---  */

	$wp_customize->add_setting(
		'calculator_error_color',
		array(
			'default'           => $error_color,
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'calculator_error_color',
			array(
				'label'    => esc_html__( 'Error color', 'custom-theme' ),
				'section'  => 'calculator_settings',
				'settings' => 'calculator_error_color',
			)
		)
	);

	/*  --- Submit button background color ---  */

	$wp_customize->add_setting(
		'calculator_submit_button_background_color',
		array(
			'default'           => $submit_button_background_color,
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'calculator_submit_button_background_color',
			array(
				'label'    => esc_html__( 'Submit button background color', 'custom-theme' ),
				'section'  => 'calculator_settings',
				'settings' => 'calculator_submit_button_background_color',
			)
		)
	);

	/*  --- Reset button background color ---  */

	$wp_customize->add_setting(
		'calculator_reset_button_background_color',
		array(
			'default'           => $reset_button_background_color,
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'calculator_reset_button_background_color',
			array(
				'label'    => esc_html__( 'Reset button background color', 'custom-theme' ),
				'section'  => 'calculator_settings',
				'settings' => 'calculator_reset_button_background_color',
			)
		)
	);

	/*  --- Button color ---  */

	$wp_customize->add_setting(
		'calculator_button_color',
		array(
			'default'           => $button_color,
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'calculator_button_color',
			array(
				'label'    => esc_html__( 'Button color', 'custom-theme' ),
				'section'  => 'calculator_settings',
				'settings' => 'calculator_button_color',
			)
		)
	);
}
add_action( 'customize_register', 'calculator_customizer_settings' );

function calculator_customizer_style_settings() {
	global $post;

	if ( ! has_shortcode( $post->post_content, 'calculator-shortcode-custom' ) ) {
		return;
	}

	if ( ! $calculator_background_color = get_theme_mod( 'calculator_background_color' ) ) {
		$calculator_background_color = '#fff';
	} else {
		$calculator_background_color = get_theme_mod( 'calculator_background_color' );
	}

	if ( ! $label_color = get_theme_mod( 'calculator_label_color' ) ) {
		$label_color = '#2a2a2a';
	} else {
		$label_color = get_theme_mod( 'calculator_label_color' );
	}

	if ( ! $label_icon_background_color = get_theme_mod( 'calculator_label_icon_background_color' ) ) {
		$label_icon_background_color = '#f9fafb';
	} else {
		$label_icon_background_color = get_theme_mod( 'calculator_label_icon_background_color' );
	}

	if ( ! $input_background_color = get_theme_mod( 'calculator_input_background_color' ) ) {
		$input_background_color = '#f9fafb';
	} else {
		$input_background_color = get_theme_mod( 'calculator_input_background_color' );
	}

	if ( ! $input_color = get_theme_mod( 'calculator_input_color' ) ) {
		$input_color = '#2a2a2a';
	} else {
		$input_color = get_theme_mod( 'calculator_input_color' );
	}

	if ( ! $placeholder_color = get_theme_mod( 'calculator_placeholder_color' ) ) {
		$placeholder_color = '#7e7e7e';
	} else {
		$placeholder_color = get_theme_mod( 'calculator_placeholder_color' );
	}

	if ( ! $error_background_color = get_theme_mod( 'calculator_error_background_color' ) ) {
		$error_background_color = '#fdf2f2';
	} else {
		$error_background_color = get_theme_mod( 'calculator_error_background_color' );
	}

	if ( ! $error_color = get_theme_mod( 'calculator_error_color' ) ) {
		$error_color = '#c81e1e';
	} else {
		$error_color = get_theme_mod( 'calculator_error_color' );
	}

	if ( ! $submit_button_background_color = get_theme_mod( 'calculator_submit_button_background_color' ) ) {
		$submit_button_background_color = '#5db24e';
	} else {
		$submit_button_background_color = get_theme_mod( 'calculator_submit_button_background_color' );
	}

	if ( ! $reset_button_background_color = get_theme_mod( 'calculator_reset_button_background_color' ) ) {
		$reset_button_background_color = '#e14141';
	} else {
		$reset_button_background_color = get_theme_mod( 'calculator_reset_button_background_color' );
	}

	if ( ! $button_color = get_theme_mod( 'calculator_button_color' ) ) {
		$button_color = '#fff';
	} else {
		$button_color = get_theme_mod( 'calculator_button_color' );
	}

	$custom_css = '
		.calculator-app .calculator-form {
			background-color: ' . esc_attr( $calculator_background_color ) . ';
		}

		.calculator-app .calculator-form label,
		.calculator-app .calculator-form label .tooltip-icon {
			color: ' . esc_attr( $label_color ) . ';
		}

		.calculator-app .calculator-form label .tooltip-icon {
			background-color: ' . esc_attr( $label_icon_background_color ) . ';
		}

		.calculator-app .calculator-form input {
			color: ' . esc_attr( $input_color ) . ';
			background-color: ' . esc_attr( $input_background_color ) . ';
		}

		.calculator-app .calculator-form input.failure,
		.calculator-app .calculator-form ul.errors-list li.failure {
			color: ' . esc_attr( $error_color ) . ';
			background-color: ' . esc_attr( $error_background_color ) . ';
		}

		.calculator-app .calculator-form label.failure {
			color: ' . esc_attr( $error_color ) . ';
		}

		.calculator-app .calculator-form input::placeholder {
			color: ' . esc_attr( $placeholder_color ) . ';
		}

		.calculator-app .submit-button {
			background-color: ' . esc_attr( $submit_button_background_color ) . ';
		}

		.calculator-app .reset-button {
			background-color: ' . esc_attr( $reset_button_background_color ) . ';
		}

		.calculator-app button {
			color: ' . esc_attr( $button_color ) . ';
		}
	';

	$key = 'calculator-style-custom';

	wp_register_style( $key, false, array(), true, true );
	wp_add_inline_style( $key, $custom_css );
	wp_enqueue_style( $key );
}
add_action( 'wp_enqueue_scripts', 'calculator_customizer_style_settings' );
