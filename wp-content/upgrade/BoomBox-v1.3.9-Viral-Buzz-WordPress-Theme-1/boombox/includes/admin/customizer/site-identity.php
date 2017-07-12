<?php
/**
 * WP Customizer panel section to handle general side options (like logo, footer text)
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_option_name = boombox_get_theme_name();

$site_identity = array(
	'fields' => array(
		// Show Tagline.
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[branding_show_tagline]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['branding_show_tagline'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_branding_show_tagline',
				'args' 	=> array(
					'label'    => esc_html__( 'Show Tagline', 'boombox' ),
					'section'  => 'title_tagline',
					'settings' => $boombox_option_name . '[branding_show_tagline]',
					'priority' => 55,
					'type'     => 'checkbox',
				)
			)
		),
		// Logo
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[branding_logo]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['branding_logo'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_branding_logo',
				'type'  => 'image',
				'args' 	=> array(
					'label'    => esc_html__( 'Logo', 'boombox' ),
					'section'  => 'title_tagline',
					'settings' => $boombox_option_name . '[branding_logo]',
					'priority' => 70,
					'description' => esc_html__( 'After attaching logo, please also set it width and height below.', 'boombox' ),
				)
			)
		),
		// Logo width
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[branding_logo_width]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['branding_logo_width'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_branding_logo_width',
				'args' 	=> array(
					'label'    => esc_html__( 'Logo Width', 'boombox' ),
					'section'  => 'title_tagline',
					'settings' => $boombox_option_name . '[branding_logo_width]',
					'priority' => 71,
					'type'     => 'number',
				)
			)
		),
		// Logo height
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[branding_logo_height]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['branding_logo_height'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_branding_logo_height',
				'args' 	=> array(
					'label'    => esc_html__( 'Logo Height', 'boombox' ),
					'section'  => 'title_tagline',
					'settings' => $boombox_option_name . '[branding_logo_height]',
					'priority' => 72,
					'type'     => 'number',
				)
			)
		),
		// Logo HDPI
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[branding_logo_hdpi]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['branding_logo_hdpi'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_branding_logo_hdpi',
				'type'  => 'image',
				'args' 	=> array(
					'label'       => esc_html__( 'Logo HDPI', 'boombox' ),
					'description' => esc_html__( 'An image for High DPI screen (like Retina) should be twice as big.', 'boombox' ),
					'section'     => 'title_tagline',
					'settings'    => $boombox_option_name . '[branding_logo_hdpi]',
					'priority'    => 80,
				)
			)
		),
		// Logo Small
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[branding_logo_small]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['branding_logo_small'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_branding_logo_small',
				'type'  => 'image',
				'args' 	=> array(
					'label'       => esc_html__( 'Small Logo', 'boombox' ),
					'section'     => 'title_tagline',
					'settings'    => $boombox_option_name . '[branding_logo_small]',
					'priority'    => 80,
				)
			)
		),
		// Footer Text
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[footer_text]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['footer_text'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_footer_text',
				'args' 	=> array(
					'label'    => esc_html__( 'Footer Text', 'boombox' ),
					'section'  => 'title_tagline',
					'settings' => $boombox_option_name . '[footer_text]',
					'priority' => 90,
					'type'     => 'text',
				)
			)
		),
		// 404 Page Image
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[branding_404_image]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['branding_404_image'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_branding_404_image',
				'type'  => 'image',
				'args' 	=> array(
					'label'       => esc_html__( '404 Page Image', 'boombox' ),
					'section'     => 'title_tagline',
					'settings'    => $boombox_option_name . '[branding_404_image]',
					'priority'    => 80,
				)
			)
		),
		// Other fields need to go here
	)
);

return $site_identity;