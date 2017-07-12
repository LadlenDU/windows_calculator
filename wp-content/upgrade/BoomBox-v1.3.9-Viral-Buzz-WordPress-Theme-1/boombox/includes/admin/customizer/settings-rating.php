<?php
/**
 * WP Customizer panel section to handle post ranking system
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_option_name = boombox_get_theme_name();

$settings_rating = array(
	'section' => array(
		'id'   => 'boombox_settings_rating_panel',
		'args' => array(
			'title'    => esc_html__( 'Post Ranking System', 'boombox' ),
			'priority' => 200
		)
	),
	'fields' => array(
		// Login require for points voting?
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_rating_points_login_require]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_rating_points_login_require'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_rating_points_login_require',
				'args' 	=> array(
					'label'    => esc_html__( 'Login required for points voting', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_rating_points_login_require]',
					'type'     => 'checkbox',
				)
			)
		),
		// Trending Conditions
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_trending_conditions]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_trending_conditions'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_trending_conditions',
				'args' 	=> array(
					'label'    => esc_html__( 'Trending Conditions', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_trending_conditions]',
					'type'     => 'select',
					'choices'  => boombox_get_trending_conditions_choices(),
				)
			)
		),
		// Trending Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_trending_heading]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_trending_heading',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_settings_rating_panel',
					'content' => '<h2>' . esc_html__('Trending', 'boombox') . '</h2>',
					'description' => esc_html__('Time Range: Last 24 hours', 'boombox') . '<hr />',
					'settings' => $boombox_option_name . '[settings_trending_heading]',
				)
			)
		),
		// Disable Trending
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_trending_disable]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_trending_disable'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_trending_disable',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_trending_disable]',
					'type'     => 'checkbox',
				)
			)
		),
		// Trending Page
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_trending_page]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_trending_page'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_trending_page',
				'args' 	=> array(
					'label'    => esc_html__( 'Trending page', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_trending_page]',
					'type'     => 'dropdown-pages',
				)
			)
		),
		// Trending Posts Count
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_trending_posts_count]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_trending_posts_count'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_trending_posts_count',
				'args' 	=> array(
					'label'    => esc_html__( 'Posts Count', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_trending_posts_count]',
					'type'     => 'number',
				)
			)
		),
		// Minimal Trending Score
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_trending_minimal_score]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_trending_minimal_score'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_trending_minimal_score',
				'args' 	=> array(
					'label'    => esc_html__( 'Minimal Trending Score', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_trending_minimal_score]',
					'type'     => 'number',
					'input_attrs' => array(
						'min'   => 1
					)
				)
			)
		),
		// Hide Trending Badge
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_trending_hide_badge]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_trending_hide_badge'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_trending_hide_badge',
				'args' 	=> array(
					'label'    => esc_html__( 'Hide Badge', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_trending_hide_badge]',
					'type'     => 'checkbox',
				)
			)
		),
		// Hot Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_hot_heading]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_hot_heading',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_settings_rating_panel',
					'content' => '<h2>' . esc_html__('Hot', 'boombox') . '</h2>',
					'description' => esc_html__('Time Range: Last 7 days', 'boombox') . '<hr />',
					'settings' => $boombox_option_name . '[settings_hot_heading]',
				)
			)
		),
		// Disable Hot
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_hot_disable]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_hot_disable'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_hot_disable',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_hot_disable]',
					'type'     => 'checkbox',
				)
			)
		),
		// Hot Page
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_hot_page]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_hot_page'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_hot_page',
				'args' 	=> array(
					'label'    => esc_html__( 'Hot page', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_hot_page]',
					'type'     => 'dropdown-pages',
				)
			)
		),
		// Hot Posts Count
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_hot_posts_count]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_hot_posts_count'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_hot_posts_count',
				'args' 	=> array(
					'label'    => esc_html__( 'Posts Count', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_hot_posts_count]',
					'type'     => 'number',
				)
			)
		),
		// Minimal Hot Score
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_hot_minimal_score]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_hot_minimal_score'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_hot_minimal_score',
				'args' 	=> array(
					'label'    => esc_html__( 'Minimal Hot Score', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_hot_minimal_score]',
					'type'     => 'number',
					'input_attrs' => array(
						'min'   => 1
					)
				)
			)
		),
		// Hide Hot Badge
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_hot_hide_badge]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_hot_hide_badge'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_hot_hide_badge',
				'args' 	=> array(
					'label'    => esc_html__( 'Hide Badge', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_hot_hide_badge]',
					'type'     => 'checkbox',
				)
			)
		),
		// Popular Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_popular_heading]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_popular_heading',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_settings_rating_panel',
					'content' => '<h2>' . esc_html__('Popular', 'boombox') . '</h2>',
					'description' => esc_html__('Time Range: Last 30 days', 'boombox') . '<hr />',
					'settings' => $boombox_option_name . '[settings_popular_heading]',
				)
			)
		),
		// Disable Popular
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_popular_disable]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_popular_disable'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_popular_disable',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_popular_disable]',
					'type'     => 'checkbox',
				)
			)
		),
		// Popular Page
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_popular_page]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_popular_page'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_popular_page',
				'args' 	=> array(
					'label'    => esc_html__( 'Popular page', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_popular_page]',
					'type'     => 'dropdown-pages',
				)
			)
		),
		// Popular Posts Count
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_popular_posts_count]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_popular_posts_count'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_popular_posts_count',
				'args' 	=> array(
					'label'    => esc_html__( 'Posts Count', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_popular_posts_count]',
					'type'     => 'number',
				)
			)
		),
		// Minimal Popular Score
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_popular_minimal_score]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_popular_minimal_score'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_popular_minimal_score',
				'args' 	=> array(
					'label'    => esc_html__( 'Minimal Popular Score', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_popular_minimal_score]',
					'type'     => 'number',
					'input_attrs' => array(
						'min'   => 1
					)
				)
			)
		),
		// Hide Popular Badge
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_popular_hide_badge]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_popular_hide_badge'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_popular_hide_badge',
				'args' 	=> array(
					'label'    => esc_html__( 'Hide Badge', 'boombox' ),
					'section'  => 'boombox_settings_rating_panel',
					'settings' => $boombox_option_name . '[settings_popular_hide_badge]',
					'type'     => 'checkbox',
				)
			)
		),
		// Other fields need to go here
	)
);

return $settings_rating;