<?php
/**
 * WP Customizer panel section to handle global design options
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_option_name = boombox_get_theme_name();

$design_global = array(
	'section' => array(
		'id'   => 'boombox_design_global_section',
		'args' => array(
			'title'    => esc_html__( 'Global', 'boombox' ),
			'priority' => 10,
			'panel'    => 'boombox_design_panel',
		)
	),
	'fields' => array(
		// Google App API KEY
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_google_api_key]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_google_api_key'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_google_api_key',
				'args' 	=> array(
					'label'    => esc_html__( 'Google App API KEY', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_google_api_key]',
					'type'     => 'text',
				)
			)
		),
		// Logo Font Family
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_logo_font_family]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_logo_font_family'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_logo_font_family',
				'type'  => 'select-optgroup',
				'args' 	=> array(
					'label'    => esc_html__( 'Logo Font Family', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_logo_font_family]',
					'choices'  => boombox_get_font_choices(),
				)
			)
		),
		// Primary Font Family
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_primary_font_family]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_primary_font_family'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_primary_font_family',
				'type'  => 'select-optgroup',
				'args' 	=> array(
					'label'    => esc_html__( 'Primary Font Family', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_primary_font_family]',
					'choices'  => boombox_get_font_choices(),
				)
			)
		),
		// Secondary Font Family
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_secondary_font_family]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_secondary_font_family'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_secondary_font_family',
				'type'  => 'select-optgroup',
				'args' 	=> array(
					'label'    => esc_html__( 'Secondary Font Family', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_secondary_font_family]',
					'choices'  => boombox_get_font_choices(),
				)
			)
		),
		// Post Titles Font Family
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_post_titles_font_family]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_post_titles_font_family'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_post_titles_font_family',
				'type'  => 'select-optgroup',
				'args' 	=> array(
					'label'    => esc_html__( 'Post Titles Font Family', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_post_titles_font_family]',
					'choices'  => boombox_get_font_choices(),
				)
			)
		),
		// Google Font Subset
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_google_font_subset]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_google_font_subset'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_google_font_subset',
				'type'  => 'multiple_checkbox',
				'args' 	=> array(
					'label'    => esc_html__( 'Google Font Subset', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_google_font_subset]',
					'choices'  => boombox_get_google_fonts_subset_choices(),
				)
			)
		),
		// Texts Font Size
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_general_text_font_size]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_general_text_font_size'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_general_text_font_size',
				'args' 	=> array(
					'label'    => esc_html__( 'General Text Font Size (px)', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_general_text_font_size]',
					'type'     => 'number'
				)
			)
		),
		// Single Posts Headings Font Size
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_single_post_heading_font_size]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_single_post_heading_font_size'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_single_post_heading_font_size',
				'args' 	=> array(
					'label'    => esc_html__( 'Single Post Heading Font Size (px)', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_single_post_heading_font_size]',
					'type'     => 'number'
				)
			)
		),
		// Widgets Titles Font Size
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_widget_heading_font_size]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_widget_heading_font_size'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_widget_heading_font_size',
				'args' 	=> array(
					'label'    => esc_html__( 'Widget Heading Font Size (px)', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_widget_heading_font_size]',
					'type'     => 'number'
				)
			)
		),
		// Page Wrapper Width
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_page_wrapper_width_type]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_page_wrapper_width_type'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_page_wrapper_width_type',
				'args' 	=> array(
					'label'    => esc_html__( 'Page Wrapper Width', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_page_wrapper_width_type]',
					'type'     => 'select',
					'choices'  => array(
						'boxed'  	 => esc_html__( 'Boxed', 'boombox' ),
						'full_width' => esc_html__( 'Full Width', 'boombox' ),
					)
				)
			)
		),
		// Body Background Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_body_background_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_body_background_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_body_background_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Body Background Color', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_body_background_color]',
				)
			)
		),
		// Body Background Image
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_body_background_image]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_body_background_image'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_body_background_image',
				'type'  => 'image',
				'args' 	=> array(
					'label'       => esc_html__( 'Body Background Image', 'boombox' ),
					'section'     => 'boombox_design_global_section',
					'settings'    => $boombox_option_name . '[design_global_body_background_image]'
				)
			)
		),
		// Body Background Image Type
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_body_background_image_type]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_body_background_image_type'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_body_background_image_type',
				'args' 	=> array(
					'label'    => esc_html__( 'Body Background Image Type', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_badges_body_background_image_type]',
					'type'     => 'select',
					'choices'  => array(
						'cover'  	=> esc_html__( 'Cover', 'boombox' ),
						'repeat'	=> esc_html__( 'Repeat', 'boombox' ),
					)
				)
			)
		),
		// Body Background Link
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_body_background_link]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_body_background_link'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_body_background_link',
				'args' 	=> array(
					'label'    => esc_html__( 'Body Background Link', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_body_background_link]',
					'type'     => 'text',
				)
			)
		),
		// Content Background Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_content_background_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_content_background_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_content_background_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Content Background Color', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_content_background_color]',
				)
			)
		),
		// Primary Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_primary_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_primary_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_primary_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Primary Color', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_primary_color]',
				)
			)
		),
		// Primary Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_primary_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_primary_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_primary_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Primary Text Color', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_primary_text_color]',
				)
			)
		),
		// Base Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_base_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_base_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_base_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Base Text Color', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_base_text_color]',
				)
			)
		),
		// Secondary Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_secondary_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_secondary_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_secondary_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Secondary Text Color', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_secondary_text_color]',
				)
			)
		),
		// Heading Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_heading_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_heading_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_heading_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Heading Text Color', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_heading_text_color]',
				)
			)
		),
		// Link Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_link_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_link_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_link_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Link Text Color', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_link_text_color]',
				)
			)
		),
		// Secondary Components Background Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_secondary_components_background_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_secondary_components_background_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_secondary_components_background_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Secondary Elements Background Color', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_secondary_components_background_color]',
				)
			)
		),
		// Secondary Components Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_secondary_components_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_secondary_components_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_secondary_components_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Secondary Elements Text Color', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_secondary_components_text_color]',
				)
			)
		),
		// Global Border Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_border_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_border_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_border_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Global Border Color', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_border_color]',
				)
			)
		),
		// Global Border Radius
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_border_radius]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_border_radius'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_border_radius',
				'args' 	=> array(
					'label'    => esc_html__( 'Global Border Radius (px)', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_border_radius]',
					'type'     => 'number',
					'description' => esc_html__( '[0-100]', 'boombox' ),
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 100
					)
				)
			)
		),
		// Inputs/Buttons Border Radius
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_inputs_buttons_border_radius]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_inputs_buttons_border_radius'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_inputs_buttons_border_radius',
				'args' 	=> array(
					'label'    => esc_html__( 'Inputs/Buttons Border Radius (px)', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_inputs_buttons_border_radius]',
					'type'     => 'number',
					'description' => esc_html__( '[0-100]', 'boombox' ),
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 100
					)
				)
			)
		),
		// Social Icons Border Radius
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_social_icons_border_radius]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_social_icons_border_radius'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_social_icons_border_radius',
				'args' 	=> array(
					'label'    => esc_html__( 'Social Icons Border Radius (px)', 'boombox' ),
					'section'  => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_social_icons_border_radius]',
					'type'     => 'number',
					'description' => esc_html__( '[0-100]', 'boombox' ),
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 100
					)
				)
			)
		),
		// Custom CSS
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_global_custom_css]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_global_custom_css'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_global_custom_css',
				'args' 	=> array(
					'label' => esc_html__( 'Custom CSS', 'boombox' ),
					'section' => 'boombox_design_global_section',
					'settings' => $boombox_option_name . '[design_global_custom_css]',
					'type' => 'textarea'
				)
			)
		),
		// Other fields need to go here
	)

);

return $design_global;