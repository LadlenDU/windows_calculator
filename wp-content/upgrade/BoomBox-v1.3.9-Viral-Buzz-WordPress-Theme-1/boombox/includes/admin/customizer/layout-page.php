<?php
/**
 * WP Customizer panel section to handle page options
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_option_name = boombox_get_theme_name();

$layout_page = array(
	'section' => array(
		'id'   => 'boombox_layout_page_section',
		'args' => array(
			'title'    => esc_html__( 'Page', 'boombox' ),
			'priority' => 10,
			'panel'    => 'boombox_layouts_panel',
		)
	),
	'fields' => array(
		// Strip Conditions
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_strip_conditions]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_strip_conditions'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_strip_conditions',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Conditions', 'boombox' ),
					'section'  => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_strip_conditions]',
					'type'     => 'select',
					'choices'  => boombox_get_conditions_choices(),
				)
			)
		),
		// Strip Size
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_strip_size]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_strip_size'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_strip_size',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Size', 'boombox' ),
					'section'  => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_strip_size]',
					'type'     => 'select',
					'choices'  => boombox_get_strip_size_choices()
				)
			)
		),
		// Strip Titles Position
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_strip_title_position]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_strip_title_position'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_strip_title_position',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Titles Position', 'boombox' ),
					'section'  => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_strip_title_position]',
					'type'     => 'select',
					'choices'  => boombox_get_strip_title_position_choices()
				)
			)
		),
		// Strip Time Range
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_strip_time_range]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_strip_time_range'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_strip_time_range',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Time Range', 'boombox' ),
					'section'  => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_strip_time_range]',
					'type'     => 'select',
					'choices'  => boombox_get_time_range_choices(),
				)
			)
		),
		// Strip Category
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_strip_category]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_strip_category'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_strip_category',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section' => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_strip_category]',
					'label'   => esc_html__( 'Strip Category', 'boombox' ),
					'choices' => boombox_get_category_choices()
				)
			)
		),
		// Strip Tags
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_strip_tags]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_strip_tags'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_strip_tags',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section' => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_strip_tags]',
					'label'   => esc_html__( 'Strip Tags', 'boombox' ),
					'choices' => boombox_get_tag_choices()
				)
			)
		),
		// Strip Items Count
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_strip_items_count]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_strip_items_count'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_strip_items_count',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Items Count', 'boombox' ),
					'section'  => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_strip_items_count]',
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
				'id' 	=> $boombox_option_name . '[layout_page_divider_1]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_divider_1',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_layout_page_section',
					'content' => '<hr>',
					'settings' => $boombox_option_name . '[layout_page_divider_1]',
				)
			)
		),
		// Featured Type
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_featured_type]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_featured_type'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_featured_type',
				'args' 	=> array(
					'label'    => esc_html__( 'Featured Type', 'boombox' ),
					'section'  => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_featured_type]',
					'type'     => 'select',
					'choices'  => boombox_get_featured_type_choices(),
				)
			)
		),
		// Featured Conditions
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_featured_conditions]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_featured_conditions'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_featured_conditions',
				'args' 	=> array(
					'label'    => esc_html__( 'Featured Conditions', 'boombox' ),
					'section'  => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_featured_conditions]',
					'type'     => 'select',
					'choices'  => boombox_get_conditions_choices(),
				)
			)
		),
		// Featured Time Range
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_featured_time_range]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_featured_time_range'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_featured_time_range',
				'args' 	=> array(
					'label'    => esc_html__( 'Featured Time Range', 'boombox' ),
					'section'  => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_featured_time_range]',
					'type'     => 'select',
					'choices'  => boombox_get_time_range_choices(),
				)
			)
		),
		// Featured Category
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_featured_category]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_featured_category'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_featured_category',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section' => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_featured_category]',
					'label'   => esc_html__( 'Featured Category', 'boombox' ),
					'choices' => boombox_get_category_choices()
				)
			)
		),
		// Featured Tags
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_featured_tags]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_featured_tags'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_featured_tags',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section' => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_featured_tags]',
					'label'   => esc_html__( 'Featured Tags', 'boombox' ),
					'choices' => boombox_get_tag_choices()
				)
			)
		),
		// Divider
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_divider_2]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_divider_2',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_layout_page_section',
					'content' => '<hr>',
					'settings' => $boombox_option_name . '[layout_page_divider_2]',
				)
			)
		),
		// Hide Elements
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_page_hide_elements]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_page_hide_elements'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_checkbox_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_page_hide_elements',
				'type'  => 'multiple_checkbox',
				'args' 	=> array(
					'section' => 'boombox_layout_page_section',
					'settings' => $boombox_option_name . '[layout_page_hide_elements]',
					'label'   => esc_html__( 'Hide Elements', 'boombox' ),
					'choices' => boombox_get_grid_hide_elements_choices()
				)
			)
		),
		// Other fields need to go here
	)
);

return $layout_page;