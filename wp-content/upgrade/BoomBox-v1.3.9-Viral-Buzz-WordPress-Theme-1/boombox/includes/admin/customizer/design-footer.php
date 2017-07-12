<?php
/**
 * WP Customizer panel section to handle footer design options
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_option_name = boombox_get_theme_name();

$design_footer = array(
	'section' => array(
		'id' 	=> 'boombox_design_footer_section',
		'args'	=> array(
			'title'    => esc_html__( 'Footer', 'boombox' ),
			'priority' => 10,
			'panel'    => 'boombox_design_panel',
		)
	),
	'fields' => array(
		// Hide Top Part
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_hide_footer_top]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_hide_footer_top'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_hide_footer_top',
				'args' 	=> array(
					'label'    => esc_html__( 'Hide Top Part', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_hide_footer_top]',
					'type'     => 'checkbox',
				)
			)
		),
		// Hide Bottom Part
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_hide_footer_bottom]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_hide_footer_bottom'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_hide_footer_bottom',
				'args' 	=> array(
					'label'    => esc_html__( 'Hide Bottom Part', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_hide_footer_bottom]',
					'type'     => 'checkbox',
				)
			)
		),
		// Hide Pattern
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_hide_pattern]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_hide_pattern'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_hide_pattern',
				'args' 	=> array(
					'label'    => esc_html__( 'Hide Pattern', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_hide_pattern]',
					'type'     => 'checkbox',
				)
			)
		),
		// Pattern Position
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_pattern_position]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_pattern_position'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_pattern_position',
				'args' 	=> array(
					'label'    => esc_html__( 'Pattern Position', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_pattern_position]',
					'type'     => 'select',
					'choices'  => array(
						'top'    => esc_html__( 'Top Footer', 'boombox' ),
						'bottom' => esc_html__( 'Bottom Footer', 'boombox' ),
					)
				)
			)
		),
		// Pattern Type
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_pattern_type]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_pattern_type'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_pattern_type',
				'args' 	=> array(
					'label'    => esc_html__( 'Pattern Type', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_pattern_type]',
					'type'     => 'select',
					'choices'  => array(
						'rags-footer.svg'    	=> esc_html__( 'Rags', 'boombox' ),
						//'clouds-footer.svg'    	=> esc_html__( 'Clouds', 'boombox' ),
					)
				)
			)
		),
		// Hide Social Icons
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_hide_social_icons]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_hide_social_icons'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_hide_social_icons',
				'args' 	=> array(
					'label'    => esc_html__( 'Hide Social Icons', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_hide_social_icons]',
					'type'     => 'checkbox',
				)
			)
		),
		// Divider
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_divider_1]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_divider_1',
				'type'  => 'color',
				'args' 	=> array(
					'section' => 'boombox_design_footer_section',
					'content' => '<hr>',
					'settings' => $boombox_option_name . '[design_footer_divider_1]',
				)
			)
		),
		// Disable Strip
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_disable_strip]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_disable_strip'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_disable_strip',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable Strip', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_disable_strip]',
					'type'     => 'checkbox',
				)
			)
		),
		// Strip Conditions
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_strip_conditions]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_strip_conditions'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_strip_conditions',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Conditions', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_strip_conditions]',
					'type'     => 'select',
					'choices'  => boombox_get_conditions_choices(),
				)
			)
		),
		// Strip Time Range
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_strip_time_range]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_strip_time_range'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_strip_time_range',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Time Range', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_strip_time_range]',
					'type'     => 'select',
					'choices'  => boombox_get_time_range_choices(),
				)
			)
		),
		// Strip Category
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_strip_category]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_strip_category'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_strip_category',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_strip_category]',
					'label'    => esc_html__( 'Strip Category', 'boombox' ),
					'choices'  => boombox_get_category_choices()
				)
			)
		),
		// Strip Tags
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_strip_tags]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_strip_tags'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_strip_tags',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_strip_tags]',
					'label'    => esc_html__( 'Strip Tags', 'boombox' ),
					'choices'  => boombox_get_tag_choices()
				)
			)
		),
		// Strip Items Count
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_strip_items_count]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_strip_items_count'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_strip_items_count',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Items Count', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_strip_items_count]',
					'type'     => 'number',
					'description' => esc_html__( 'Minimum count: 6. To show all items, please enter -1.', 'boombox' ),
					'input_attrs' => array(
						'min'   => 6
					)
				)
			)
		),
		// Divider
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_divider_2]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_divider_2',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_design_footer_section',
					'content' => '<hr>',
					'settings' => $boombox_option_name . '[design_footer_divider_2]',
				)
			)
		),
		// Top Background Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_top_background_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_top_background_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_top_background_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Background Color', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_top_background_color]',
				)
			)
		),
		// Top Primary Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_top_primary_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_top_primary_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_top_primary_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Primary Color', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_top_primary_color]',
				)
			)
		),
		// Top Primary Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_top_primary_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_top_primary_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_top_primary_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Primary Text Color', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_top_primary_text_color]',
				)
			)
		),
		// Top Heading Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_top_heading_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_top_heading_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_top_heading_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Heading Color', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_top_heading_color]',
				)
			)
		),
		// Top Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_top_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_top_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_top_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Text Color', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_top_text_color]',
				)
			)
		),
		// Top Link Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_top_link_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_top_link_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_top_link_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Top Link Color', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_top_link_color]',
				)
			)
		),
		// Bottom Background Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_bottom_background_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_bottom_background_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_bottom_background_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Bottom Background Color', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_bottom_background_color]',
				)
			)
		),
		// Bottom Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_bottom_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_bottom_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_bottom_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Bottom Text Color', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_bottom_text_color]',
				)
			)
		),
		// Bottom Text Hover Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_footer_bottom_text_hover_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_footer_bottom_text_hover_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_footer_bottom_text_hover_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Bottom Text Hover Color', 'boombox' ),
					'section'  => 'boombox_design_footer_section',
					'settings' => $boombox_option_name . '[design_footer_bottom_text_hover_color]',
				)
			)
		),
		// Other fields need to go here
	)
);

return $design_footer;