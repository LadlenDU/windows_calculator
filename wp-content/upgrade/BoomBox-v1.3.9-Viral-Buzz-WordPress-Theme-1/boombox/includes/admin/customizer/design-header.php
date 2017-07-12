<?php
/**
 * WP Customizer panel section to handle header design options
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_option_name = boombox_get_theme_name();

$design_header = array(
	'section' => array(
		'id' 	=> 'boombox_design_header_section',
		'args'	=> array(
			'title'    => esc_html__( 'Header', 'boombox' ),
			'priority' => 10,
			'panel'    => 'boombox_design_panel',
		)
	),
	'fields' => array(
		// Disable Top Header
		array(
			'setting' 	=> array(
				'id' 	=> $boombox_option_name . '[design_disable_top_header]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_disable_top_header'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control'	=> array(
				'id'	=> 'boombox_design_disable_top_header',
				'args'	=> array(
					'label'    => esc_html__( 'Disable Top Header', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_disable_top_header]',
					'type'     => 'checkbox',
				)
			)
		),
		// Disable Bottom Header
		array(
			'setting' 	=> array(
				'id' 	=> $boombox_option_name . '[design_disable_bottom_header]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_disable_bottom_header'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control'	=> array(
				'id'	=> 'boombox_design_disable_bottom_header',
				'args'	=> array(
					'label'    => esc_html__( 'Disable Bottom Header', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_disable_bottom_header]',
					'type'     => 'checkbox',
				)
			)
		),
		// Logo Position
		array(
			'setting' 	=> array(
				'id' 	=> $boombox_option_name . '[design_logo_position]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_logo_position'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control'	=> array(
				'id'	=> 'boombox_design_logo_position',
				'args'	=> array(
					'label'    => esc_html__( 'Logo Position', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_logo_position]',
					'type'     => 'select',
					'choices'  => array(
						'top'    => esc_html__( 'Top Header', 'boombox' ),
						'bottom' => esc_html__( 'Bottom Header', 'boombox' )
					)
				)
			)
		),
		// Pattern Position
		array(
			'setting' 	=> array(
				'id' 	=> $boombox_option_name . '[design_pattern_position]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_pattern_position'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control'	=> array(
				'id'	=> 'boombox_design_pattern_position',
				'args'	=> array(
					'label'    => esc_html__( 'Pattern Position', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_pattern_position]',
					'type'     => 'select',
					'choices'  => array(
						'top'    => esc_html__( 'Top Header', 'boombox' ),
						'bottom' => esc_html__( 'Bottom Header', 'boombox' ),
						'none'   => esc_html__( 'None', 'boombox' )
					)
				)
			)
		),
		// Pattern Type
		array(
			'setting' 	=> array(
				'id' 	=> $boombox_option_name . '[design_pattern_type]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_pattern_type'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control'	=> array(
				'id'	=> 'boombox_design_pattern_type',
				'args'	=> array(
					'label'    => esc_html__( 'Pattern Type', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_pattern_type]',
					'type'     => 'select',
					'choices'  => array(
						'rags-header.svg'    	=> esc_html__( 'Rags', 'boombox' ),
						'clouds-header.svg'    	=> esc_html__( 'Clouds', 'boombox' ),
					)
				)
			)
		),
		// Shadow Position
		array(
			'setting' 	=> array(
				'id' 	=> $boombox_option_name . '[design_shadow_position]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_shadow_position'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control'	=> array(
				'id'	=> 'boombox_design_shadow_position',
				'args'	=> array(
					'label'    => esc_html__( 'Shadow Position', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_shadow_position]',
					'type'     => 'select',
					'choices'  => array(
						'top'    => esc_html__( 'Top Header', 'boombox' ),
						'bottom' => esc_html__( 'Bottom Header', 'boombox' ),
						'none'   => esc_html__( 'None', 'boombox' )
					)
				)
			)
		),
		// Badges Position
		array(
			'setting' 	=> array(
				'id' 	=> $boombox_option_name . '[design_badges_position]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_position'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control'	=> array(
				'id'	=> 'boombox_design_badges_position',
				'args'	=> array(
					'label'    => esc_html__( 'Badges Position', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_badges_position]',
					'type'     => 'select',
					'choices'  => array(
						'top'     => esc_html__( 'Top Header', 'boombox' ),
						'bottom'  => esc_html__( 'Bottom Header', 'boombox' ),
						'outside' => esc_html__( 'Outside Header', 'boombox' ),
						'none'    => esc_html__( 'None', 'boombox' )
					)
				)
			)
		),
		// Authentication Position
		array(
			'setting' 	=> array(
				'id' 	=> $boombox_option_name . '[design_auth_position]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_auth_position'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control'	=> array(
				'id'	=> 'boombox_design_auth_position',
				'args'	=> array(
					'label'    => esc_html__( 'Authentication Position', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_auth_position]',
					'type'     => 'select',
					'choices'  => array(
						'top'    => esc_html__( 'Top Header', 'boombox' ),
						'bottom' => esc_html__( 'Bottom Header', 'boombox' ),
						'none'   => esc_html__( 'None', 'boombox' )
					)
				)
			)
		),
		// Search Position
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_search_position]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_search_position'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_search_position',
				'args' 	=> array(
					'label'    => esc_html__( 'Search Position', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_search_position]',
					'type'     => 'select',
					'choices'  => array(
						'top'    => esc_html__( 'Top Header', 'boombox' ),
						'bottom' => esc_html__( 'Bottom Header', 'boombox' ),
						'none'   => esc_html__( 'None', 'boombox' )
					)
				)
			)
		),
		// Top Menu Alignment
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_top_menu_alignment]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_top_menu_alignment'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_top_menu_alignment',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Menu Alignment', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_top_menu_alignment]',
					'type'     => 'select',
					'choices'  => array(
						'left'   => esc_html__( 'Left', 'boombox' ),
						'middle' => esc_html__( 'Middle', 'boombox' ),
						'right'  => esc_html__( 'Right', 'boombox' )
					)
				)
			)
		),
		// Bottom Menu Alignment
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_bottom_menu_alignment]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_bottom_menu_alignment'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_bottom_menu_alignment',
				'args' 	=> array(
					'label'    => esc_html__( 'Bottom Menu Alignment', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_bottom_menu_alignment]',
					'type'     => 'select',
					'choices'  => array(
						'left'   => esc_html__( 'Left', 'boombox' ),
						'middle' => esc_html__( 'Middle', 'boombox' ),
						'right'  => esc_html__( 'Right', 'boombox' )
					)
				)
			)
		),
		// Social Position
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_social_position]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_social_position'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_social_position',
				'args' 	=> array(
					'label'    => esc_html__( 'Social Position', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_social_position]',
					'type'     => 'select',
					'choices'  => array(
						'top'    => esc_html__( 'Top Header', 'boombox' ),
						'bottom' => esc_html__( 'Bottom Header', 'boombox' ),
						'none'   => esc_html__( 'None', 'boombox' )
					)
				)
			)
		),
		// Burger Navigation Position
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_burger_navigation_position]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_burger_navigation_position'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_burger_navigation_position',
				'args' 	=> array(
					'label'    => esc_html__( 'Burger Navigation Position', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_burger_navigation_position]',
					'type'     => 'select',
					'choices'  => array(
						'top'    => esc_html__( 'Top Header', 'boombox' ),
						'bottom' => esc_html__( 'Bottom Header', 'boombox' ),
						'none'   => esc_html__( 'None', 'boombox' )
					)
				)
			)
		),
		// Community Text
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_community_text]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_community_text'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_community_text',
				'args' 	=> array(
					'label'    => esc_html__( 'Community Text', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_community_text]',
					'type'     => 'text'
				)
			)
		),
		// Sticky Header
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_sticky_header]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_sticky_header'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_sticky_header',
				'args' 	=> array(
					'label'    => esc_html__( 'Sticky Header', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_sticky_header]',
					'type'     => 'select',
					'choices'  => array(
						'top'    => esc_html__( 'Top Header', 'boombox' ),
						'bottom' => esc_html__( 'Bottom Header', 'boombox' ),
						'both'   => esc_html__( 'Both Headers', 'boombox' ),
						'none'   => esc_html__( 'None', 'boombox' )
					)
				)
			)
		),
		// Top Header Height
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_top_header_height]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_top_header_height'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_top_header_height',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Header Height', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_top_header_height]',
					'type'     => 'select',
					'choices'  => array(
						'narrow' => esc_html__( 'Small', 'boombox' ),
						'large'  => esc_html__( 'Big', 'boombox' )
					)
				)
			)
		),
		// Bottom Header Height
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_bottom_header_height]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_bottom_header_height'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_bottom_header_height',
				'args' 	=> array(
					'label'    => esc_html__( 'Bottom Header Height', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_bottom_header_height]',
					'type'     => 'select',
					'choices'  => array(
						'narrow' => esc_html__( 'Small', 'boombox' ),
						'large'  => esc_html__( 'Big', 'boombox' )
					)
				)
			)
		),
		// Top Header Width
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_top_header_width]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_top_header_width'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_top_header_width',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Header Width', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_top_header_width]',
					'type'     => 'select',
					'choices'  => array(
						'full-width' => esc_html__( 'Full width', 'boombox' ),
						'boxed'      => esc_html__( 'Boxed', 'boombox' )
					)
				)
			)
		),
		// Bottom Header Width
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_bottom_header_width]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_bottom_header_width'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_bottom_header_width',
				'args' 	=> array(
					'label'    => esc_html__( 'Bottom Header Width', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_bottom_header_width]',
					'type'     => 'select',
					'choices'  => array(
						'full-width' => esc_html__( 'Full width', 'boombox' ),
						'boxed'      => esc_html__( 'Boxed', 'boombox' )
					)
				)
			)
		),
		// Button Text
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_button_text]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_button_text'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_button_text',
				'args' 	=> array(
					'label'    => esc_html__( 'Button Text', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_button_text]',
					'type'     => 'text'
				)
			)
		),
		// Button Link
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_button_link]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_button_link'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_button_link',
				'args' 	=> array(
					'label'    => esc_html__( 'Button Link', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_button_link]',
					'type'     => 'text'
				)
			)
		),
		// Enable Plus Icon On Button
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_button_enable_plus_icon]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_button_enable_plus_icon'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_button_enable_plus_icon',
				'args' 	=> array(
					'label'    => esc_html__( 'Enable Plus Icon On Button', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_button_enable_plus_icon]',
					'type'     => 'checkbox',
				)
			)
		),
		// Site Title Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_site_title_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_site_title_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_site_title_color',
				'type' => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Site Title Color', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_site_title_color]',
				)
			)
		),
		// Top Background Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_top_background_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_top_background_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_top_background_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Background Color', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_top_background_color]',
				)
			)
		),
		// Top Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_top_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_top_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_top_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Text Color', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_top_text_color]',
				)
			)
		),
		// Top Text Hover Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_top_text_hover_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_top_text_hover_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_top_text_hover_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Text Hover Color', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_top_text_hover_color]',
				)
			)
		),
		// Bottom Background Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_bottom_background_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_bottom_background_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_bottom_background_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Bottom Background Color', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_bottom_background_color]',
				)
			)
		),
		// Bottom Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_bottom_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_bottom_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_bottom_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Bottom Text Color', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_bottom_text_color]',
				)
			)
		),
		// Bottom Text Hover Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_bottom_text_hover_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_bottom_text_hover_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_bottom_text_hover_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Bottom Text Hover Color', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_bottom_text_hover_color]',
				)
			)
		),
		// Button Background Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_button_background_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_button_background_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_button_background_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Button Background Color', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_button_background_color]',
				)
			)
		),
		// Button Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_header_button_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_header_button_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_header_button_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Button Text Color', 'boombox' ),
					'section'  => 'boombox_design_header_section',
					'settings' => $boombox_option_name . '[design_header_button_text_color]',
				)
			)
		)
		// Other fields need to go here
	)
);

return $design_header;