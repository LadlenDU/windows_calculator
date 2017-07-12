<?php
/**
 * WP Customizer panel section to handle post options
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_option_name = boombox_get_theme_name();

$layout_post = array(
	'section' => array(
		'id'   => 'boombox_layout_post_section',
		'args' => array(
			'title'    => esc_html__( 'Post Single', 'boombox' ),
			'priority' => 10,
			'panel'    => 'boombox_layouts_panel',
		)
	),
	'fields' => array(
		// Template
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_template]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_template'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_template',
				'args' 	=> array(
					'label'    => esc_html__( 'Default Template', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_template]',
					'type'     => 'select',
					'choices'  => boombox_get_post_template_choices(),
				)
			)
		),
		// Navigation Direction
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_navigation_direction]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_navigation_direction'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_navigation_direction',
				'args' 	=> array(
					'label'    => esc_html__( 'Posts Navigation Direction', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_navigation_direction]',
					'type'     => 'select',
					'choices'  => array(
						'to-oldest' => esc_html__( 'From Newest To Oldest', 'boombox' ),
						'to-newest' => esc_html__( 'From Oldest To Newest', 'boombox' ),
					),
				)
			)
		),
		// Divider
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_archive_divider_1]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_archive_divider_1',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_layout_post_section',
					'content' => '<hr>',
					'settings' => $boombox_option_name . '[layout_archive_divider_1]',
				)
			)
		),
		// Disable Strip
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_disable_strip]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_disable_strip'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_disable_strip',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable Strip', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_disable_strip]',
					'type'     => 'checkbox',
				)
			)
		),
		// Strip Size
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_strip_size]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_strip_size'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_strip_size',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Size', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_strip_size]',
					'type'     => 'select',
					'choices'  => boombox_get_strip_size_choices()
				)
			)
		),
		// Strip Titles Position
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_strip_title_position]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_strip_title_position'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_strip_title_position',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Titles Position', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_strip_title_position]',
					'type'     => 'select',
					'choices'  => boombox_get_strip_title_position_choices()
				)
			)
		),
		// Strip Conditions
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_strip_conditions]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_strip_conditions'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_strip_conditions',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Conditions', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_strip_conditions]',
					'type'     => 'select',
					'choices'  => boombox_get_conditions_choices(),
				)
			)
		),
		// Strip Time Range
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_strip_time_range]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_strip_time_range'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_strip_time_range',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Time Range', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_strip_time_range]',
					'type'     => 'select',
					'choices'  => boombox_get_time_range_choices(),
				)
			)
		),
		// Strip Category
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_strip_category]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_strip_category'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_strip_category',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_strip_category]',
					'label'    => esc_html__( 'Strip Category', 'boombox' ),
					'choices'  => boombox_get_category_choices()
				)
			)
		),
		// Strip Tags
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_strip_tags]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_strip_tags'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_strip_tags',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_strip_tags]',
					'label'    => esc_html__( 'Strip Tags', 'boombox' ),
					'choices'  => boombox_get_tag_choices()
				)
			)
		),
		// Strip Items Count
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_strip_items_count]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_strip_items_count'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_strip_items_count',
				'args' 	=> array(
					'label'    => esc_html__( 'Strip Items Count', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_strip_items_count]',
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
				'id' 	=> $boombox_option_name . '[layout_archive_divider_2]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_archive_divider_2',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_layout_post_section',
					'content' => '<hr>',
					'settings' => $boombox_option_name . '[layout_archive_divider_2]',
				)
			)
		),
		// Hide Elements
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_hide_elements]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_hide_elements'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_checkbox_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_hide_elements',
				'type'  => 'multiple_checkbox',
				'args' 	=> array(
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_hide_elements]',
					'label'    => esc_html__( 'Hide Elements', 'boombox' ),
					'choices'  => boombox_get_post_hide_elements_choices()
				)
			)
		),
		// Sharebar Elements
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_share_box_elements]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_share_box_elements'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_checkbox_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_share_box_elements',
				'type'  => 'multiple_checkbox',
				'args' 	=> array(
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_share_box_elements]',
					'label'    => esc_html__( 'Sharebar Elements', 'boombox' ),
					'choices'  => array(
						'share_count' => esc_html__( 'Share Count', 'boombox' ),
						'comments'    => esc_html__( 'Comments', 'boombox' ),
						'points'      => esc_html__( 'Points', 'boombox' )
					)
				)
			)
		),
		// Divider
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_archive_divider_3]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_archive_divider_3',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_layout_post_section',
					'content' => '<h3>' . esc_html__( ' "View Full Post" Button ', 'boombox' ) . '</h3><hr>',
					'settings' => $boombox_option_name . '[layout_archive_divider_3]',
				)
			)
		),
		// Disable Full Text Button
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_disable_full_post_button]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_disable_full_post_button'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_disable_full_post_button',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable ( On Archive / Pages )', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_disable_full_post_button]',
					'type'	   => 'checkbox'
				)
			)
		),
		// Full Text Button Label
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_full_post_button_label]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_full_post_button_label'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_full_post_button_label',
				'args' 	=> array(
					'label'    => esc_html__( 'Button Text', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_full_post_button_label]'
				)
			)
		),
		// Divider
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_archive_divider_4]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_archive_divider_4',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_layout_post_section',
					'content' => '<hr>',
					'settings' => $boombox_option_name . '[layout_archive_divider_4]',
				)
			)
		),

		//////////////////// Related Block /////////////////////
		// Disable Related Posts Section
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_disable_related_block]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_disable_related_block'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_disable_related_block',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable Related Posts Section', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_disable_related_block]',
					'type'     => 'checkbox',
				)
			)
		),
		// Related Entries Per Page
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_related_entries_per_page]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_related_entries_per_page'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_related_entries_per_page',
				'args' 	=> array(
					'label'    => esc_html__( 'Related Entries Per Page', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_related_entries_per_page]',
					'type'     => 'number',
				)
			)
		),
		// Related Entries Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_related_entries_heading]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_related_entries_heading'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_related_entries_heading',
				'args' 	=> array(
					'label'    => esc_html__( 'Related Entries Heading', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_related_entries_heading]',
					'type'     => 'text',
				)
			)
		),

		//////////////////// More Block /////////////////////
		// Disable "More From" Section
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_disable_more_block]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_disable_more_block'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_disable_more_block',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable "More From" Section', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_disable_more_block]',
					'type'     => 'checkbox',
				)
			)
		),
		// "More From" Entries Per Page
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_more_entries_per_page]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_more_entries_per_page'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_more_entries_per_page',
				'args' 	=> array(
					'label'    => esc_html__( '"More From" Entries Per Page', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_more_entries_per_page]',
					'type'     => 'number',
				)
			)
		),
		// "More From" Entries Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_more_entries_heading]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_more_entries_heading'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_more_entries_heading',
				'args' 	=> array(
					'label'    => esc_html__( '"More From" Block Heading', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_more_entries_heading]',
					'type'     => 'text',
				)
			)
		),

		//////////////////// Don't Miss Block /////////////////////
		// Disable "Don't Miss" Section
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_disable_dont_miss_block]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_disable_dont_miss_block'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_disable_dont_miss_block',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable "Don\'t Miss" Section', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_disable_dont_miss_block]',
					'type'     => 'checkbox',
				)
			)
		),
		// Don't Miss Entries Per Page
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_dont_miss_entries_per_page]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_dont_miss_entries_per_page'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_dont_miss_entries_per_page',
				'args' 	=> array(
					'label'    => esc_html__( '"Don\'t Miss" Entries Per Page', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_dont_miss_entries_per_page]',
					'type'     => 'number',
				)
			)
		),
		// Don't Miss Entries Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_dont_miss_entries_heading]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_dont_miss_entries_heading'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_dont_miss_entries_heading',
				'args' 	=> array(
					'label'    => esc_html__( '"Don\'t Miss" Entries Heading', 'boombox' ),
					'section'  => 'boombox_layout_post_section',
					'settings' => $boombox_option_name . '[layout_post_dont_miss_entries_heading]',
					'type'     => 'text'
				)
			)
		),
		// Hide Elements
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[layout_post_grid_sections_hide_elements]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['layout_post_grid_sections_hide_elements'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_checkbox_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_layout_post_grid_sections_hide_elements',
				'type'  => 'multiple_checkbox',
				'args' 	=> array(
					'section'     => 'boombox_layout_post_section',
					'settings'    => $boombox_option_name . '[layout_post_grid_sections_hide_elements]',
					'label'       => esc_html__( 'Hide Elements', 'boombox' ),
					'description' => esc_html__( 'For related posts settings.', 'boombox' ),
					'choices'     => boombox_get_grid_hide_elements_choices()
				)
			)
		),
		// Other fields need to go here
	)
);

return $layout_post;