<?php
/**
 * WP Customizer panel section to handle badges design options
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_option_name = boombox_get_theme_name();

$design_badges = array(
	'section' => array(
		'id' 	=> 'boombox_design_badges_section',
		'args'  => array(
			'title'    => esc_html__( 'Badges', 'boombox' ),
			'priority' => 10,
			'panel'    => 'boombox_design_panel',
		)
	),
	'fields' => array(
		// Badges position on posts thumbnails
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_position_on_thumbnails]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_position_on_thumbnails'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_position_on_thumbnails',
				'args' 	=> array(
					'label'    => esc_html__( 'Badges Positions On Post Thumbnail', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_position_on_thumbnails]',
					'type'     => 'select',
					'choices'  => array(
						'outside-left'  => esc_html__( 'Outside Left', 'boombox' ),
						'outside-right'	=> esc_html__( 'Outside Right', 'boombox' ),
						'inside-left'  	=> esc_html__( 'Inside Left', 'boombox' ),
						'inside-right' 	=> esc_html__( 'Inside Right', 'boombox' ),
					)
				)
			)
		),
		// Reactions Badges Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_reactions_badges_heading]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_reactions_badges_heading',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_design_badges_section',
					'content' => '<h2>' . esc_html__('Reactions Badges', 'boombox') . '</h2><hr />',
					'settings' => $boombox_option_name . '[design_badges_reactions_badges_heading]',
				)
			)
		),
		// Hide Reactions Badges
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_hide_reactions]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_hide_reactions'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_hide_reactions',
				'args' 	=> array(
					'label'    => esc_html__( 'Hide Reactions Badges', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_hide_reactions]',
					'type'     => 'checkbox',
				)
			)
		),
		// Reactions Background Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_reactions_background_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_reactions_background_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_reactions_background_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Reactions Background Color', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_reactions_background_color]',
				)
			)
		),
		// Reactions Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_reactions_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_reactions_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_reactions_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Reactions Text Color', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_reactions_text_color]',
				)
			)
		),
		// Reactions Type
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_reactions_type]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_reactions_type'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_reactions_type',
				'args' 	=> array(
					'label'    => esc_html__( 'Reactions Type', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_reactions_type]',
					'type'     => 'select',
					'choices'  => array(
						'face'       => esc_html__( 'Face', 'boombox' ),
						'text'       => esc_html__( 'Text', 'boombox' ),
						'face-text'  => esc_html__( 'Face-Text', 'boombox' ),
						'text-angle' => esc_html__( 'Text Angle', 'boombox' ),
					)
				)
			)
		),
		// Trending Badges Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_trending_badges_heading]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_trending_badges_heading',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_design_badges_section',
					'content' => '<h2>' . esc_html__('Trending Badges', 'boombox') . '</h2><hr />',
					'settings' => $boombox_option_name . '[design_badges_trending_badges_heading]',
				)
			)
		),
		// Hide Trending Badges
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_hide_trending]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_hide_trending'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_hide_trending',
				'args' 	=> array(
					'label'    => esc_html__( 'Hide Trending Badges', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_hide_trending]',
					'type'     => 'checkbox',
				)
			)
		),
		// Trending Icon
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_trending_icon]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_trending_icon'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_trending_icon',
				'args' 	=> array(
					'label'    => esc_html__( 'Trending Icon', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_trending_icon]',
					'type'     => 'select',
					'choices'  => array(
						'trending'  	=> esc_html__( 'Trending 1', 'boombox' ),
						'trending2'		=> esc_html__( 'Trending 2', 'boombox' ),
						'trending3'  	=> esc_html__( 'Trending 3', 'boombox' ),
					)
				)
			)
		),
		// Trending Background Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_trending_background_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_trending_background_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_trending_background_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Trending Background Color', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_trending_background_color]',
				)
			)
		),
		// Trending Icon Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_trending_icon_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_trending_icon_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_trending_icon_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Trending Icon Color', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_trending_icon_color]',
				)
			)
		),
		// Trending Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_trending_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_trending_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_trending_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Trending Text Color', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_trending_text_color]',
				)
			)
		),
		// Category & Tag Badges Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_category_badges_heading]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_category_badges_heading',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_design_badges_section',
					'content' => '<h2>' . esc_html__('Category & Tag Badges', 'boombox') . '</h2><hr />',
					'settings' => $boombox_option_name . '[design_badges_category_badges_heading]',
				)
			)
		),
		// Hide Category & Tag Badges
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_hide_category]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_hide_category'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_hide_category',
				'args' 	=> array(
					'label'    => esc_html__( 'Hide Category & Tag Badges', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_hide_category]',
					'type'     => 'checkbox',
				)
			)
		),
		// Show Badges for Categories
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_show_for_categories]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_show_for_categories'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_show_for_categories',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section' => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_show_for_categories]',
					'label'   => esc_html__( 'Show Badges for Categories', 'boombox' ),
					'choices' => boombox_get_category_choices()
				)
			)
		),
		// Show Badges for Tags
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_show_for_post_tags]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_show_for_post_tags'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_show_for_post_tags',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section' => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_show_for_post_tags]',
					'label'   => esc_html__( 'Show Badges for Tags', 'boombox' ),
					'choices' => boombox_get_tag_choices()
				)
			)
		),
		// Category & Tag Background Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_category_background_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_category_background_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_category_background_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Category & Tag Badges Background Color', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_category_background_color]',
				)
			)
		),
		// Category & Tag Icon Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_category_icon_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_category_icon_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_category_icon_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Category & Tag Icon Color', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_category_icon_color]',
				)
			)
		),
		// Category & Tag Text Color
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_category_text_color]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_category_text_color'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_category_text_color',
				'type'  => 'color',
				'args' 	=> array(
					'label'    => esc_html__( 'Category & Tag Text Color', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_category_text_color]',
				)
			)
		),
		// Post Formats Badges Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_post_type_format_heading]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_post_type_format_heading',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_design_badges_section',
					'content' => '<h2>' . esc_html__('Post Formats', 'boombox') . '</h2><hr />',
					'settings' => $boombox_option_name . '[design_badges_post_type_format_heading]',
				)
			)
		),
		// Hide Post Formats Badges
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_hide_post_type_badges]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_hide_post_type_badges'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_hide_post_type_badges',
				'args' 	=> array(
					'label'    => esc_html__( 'Hide Post Format Icons', 'boombox' ),
					'section'  => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_hide_post_type_badges]',
					'type'     => 'checkbox',
				)
			)
		),
		// Show Post Formats Icons For Categories
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_categories_for_post_type_badges]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_categories_for_post_type_badges'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'design_badges_categories_for_post_type_badges',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section' => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_categories_for_post_type_badges]',
					'label'   => esc_html__( 'Show Icons For Categories', 'boombox' ),
					'choices' => boombox_get_category_choices()
				)
			)
		),
		// Show Post Formats Icons For Tags
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[design_badges_post_tags_for_post_type_badges]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['design_badges_post_tags_for_post_type_badges'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'boombox_sanitize_multiple_select_field'
				)
			),
			'control' => array(
				'id' 	=> 'boombox_design_badges_post_tags_for_post_type_badges',
				'type'  => 'multiple_select',
				'args' 	=> array(
					'section' => 'boombox_design_badges_section',
					'settings' => $boombox_option_name . '[design_badges_post_tags_for_post_type_badges]',
					'label'   => esc_html__( 'Show Icons For Tags', 'boombox' ),
					'choices' => boombox_get_tag_choices()
				)
			)
		),
		// Other fields need to go here
	)
);

return $design_badges;