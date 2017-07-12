<?php
/**
 * WP Customizer panel section to handle post reactions system
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_option_name = boombox_get_theme_name();

$settings_reactions = array(
	'section' => array(
		'id'   => 'boombox_settings_reactions_panel',
		'args' => array(
			'title'    => esc_html__( 'Post Reactions System', 'boombox' ),
			'priority' => 200
		)
	),
	'fields' => array(
		// Disable Reactions
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_reactions_disable]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_reactions_disable'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_reactions_disable',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable Reactions', 'boombox' ),
					'section'  => 'boombox_settings_reactions_panel',
					'settings' => $boombox_option_name . '[settings_reactions_disable]',
					'type'     => 'checkbox',
				)
			)
		),
		// Login require for reactions voting
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_rating_reactions_login_require]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_rating_reactions_login_require'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_rating_reactions_login_require',
				'args' 	=> array(
					'label'    => esc_html__( 'Login required for reactions voting', 'boombox' ),
					'section'  => 'boombox_settings_reactions_panel',
					'settings' => $boombox_option_name . '[settings_rating_reactions_login_require]',
					'type'     => 'checkbox',
				)
			)
		),
		// Reaction Award Minimal Score
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_reaction_award_minimal_score]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_reaction_award_minimal_score'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_reaction_award_minimal_score',
				'args' 	=> array(
					'label'    => esc_html__( 'Reaction Award Minimal Score', 'boombox' ),
					'section'  => 'boombox_settings_reactions_panel',
					'settings' => $boombox_option_name . '[settings_reaction_award_minimal_score]',
					'type'     => 'number',
					'input_attrs' => array(
						'min'   => 1
					)
				)
			)
		),
		// Reactions Maximal Count Per Vote
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[settings_reactions_maximal_count_per_vote]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['settings_reactions_maximal_count_per_vote'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_settings_reactions_maximal_count_per_vote',
				'args' 	=> array(
					'label'    => esc_html__( 'Reactions Maximal Count Per Vote', 'boombox' ),
					'section'  => 'boombox_settings_reactions_panel',
					'settings' => $boombox_option_name . '[settings_reactions_maximal_count_per_vote]',
					'type'     => 'number',
					'input_attrs' => array(
						'min'   => 1
					)
				)
			)
		),
		// Other fields need to go here
	)
);

return $settings_reactions;