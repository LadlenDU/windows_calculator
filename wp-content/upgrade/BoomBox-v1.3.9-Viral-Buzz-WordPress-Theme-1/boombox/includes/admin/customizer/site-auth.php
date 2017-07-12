<?php
/**
 * WP Customizer panel section to handle authentication
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_option_name = boombox_get_theme_name();

$site_auth = array(
	'section' => array(
		'id'   => 'boombox_auth_section',
		'args' => array(
			'title'    => esc_html__( 'Authentication', 'boombox' ),
			'priority' => 300,
		)
	),
	'fields' => array(
		// Disable Site Authentication
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[disable_site_auth]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['disable_site_auth'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_disable_site_auth',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable Site Authentication', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[disable_site_auth]',
					'type'     => 'checkbox',
				)
			)
		),
		// Login Popup Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_login_popup_heading]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_login_popup_heading'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_login_popup_heading',
				'args' 	=> array(
					'label'    => esc_html__( 'Login Popup Heading', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_login_popup_heading]',
					'type'     => 'text',
				)
			)
		),
		// Login Popup Text
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_login_popup_text]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_login_popup_text'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_login_popup_text',
				'args' 	=> array(
					'label' => esc_html__( 'Login Popup Text', 'boombox' ),
					'section' => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_login_popup_text]',
					'type' => 'textarea'
				)
			)
		),
		// Registration Popup Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_registration_popup_heading]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_registration_popup_heading'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_registration_popup_heading',
				'args' 	=> array(
					'label'    => esc_html__( 'Registration Popup Heading', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_registration_popup_heading]',
					'type'     => 'text',
				)
			)
		),
		// Registration Popup Text
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_registration_popup_text]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_registration_popup_text'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_registration_popup_text',
				'args' 	=> array(
					'label' => esc_html__( 'Registration Popup Text', 'boombox' ),
					'section' => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_registration_popup_text]',
					'type' => 'textarea'
				)
			)
		),
		// Lost Password Popup Heading
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_reset_password_popup_heading]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_reset_password_popup_heading'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_reset_password_popup_heading',
				'args' 	=> array(
					'label'    => esc_html__( 'Reset Password Popup Heading', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_reset_password_popup_heading]',
					'type'     => 'text',
				)
			)
		),
		// Reset Popup Text
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_reset_password_popup_text]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_reset_password_popup_text'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_reset_password_popup_text',
				'args' 	=> array(
					'label' => esc_html__( 'Reset Password Popup Text', 'boombox' ),
					'section' => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_reset_password_popup_text]',
					'type' => 'textarea'
				)
			)
		),
		// "Terms Of Use" Page
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_terms_of_use_page]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_terms_of_use_page'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_terms_of_use_page',
				'args' 	=> array(
					'label'    => esc_html__( '"Terms Of Use" Page', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_terms_of_use_page]',
					'type'     => 'dropdown-pages',
				)
			)
		),
		// "Privacy Policy" Page
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_privacy_policy_page]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_privacy_policy_page'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_privacy_policy_page',
				'args' 	=> array(
					'label'    => esc_html__( '"Privacy Policy" Page', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_privacy_policy_page]',
					'type'     => 'dropdown-pages',
				)
			)
		),
		// Enable captcha for login
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_enable_login_captcha]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_enable_login_captcha'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_enable_login_captcha',
				'args' 	=> array(
					'label'    => esc_html__( 'Enable captcha on login', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_enable_login_captcha]',
					'type'     => 'checkbox',
				)
			)
		),
		// Enable captcha for registration
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_enable_registration_captcha]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_enable_registration_captcha'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_enable_registration_captcha',
				'args' 	=> array(
					'label'    => esc_html__( 'Enable captcha on registration', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_enable_registration_captcha]',
					'type'     => 'checkbox',
				)
			)
		),
		// Captcha Type
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_captcha_type]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_captcha_type'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_captcha_type',
				'args' 	=> array(
					'label'    => esc_html__( 'Captcha Type', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_captcha_type]',
					'type'     => 'select',
					'choices'  => array(
						'image' 	=> esc_html__( 'Image Captcha', 'boombox' ),
						'google'   	=> esc_html__( 'Google Recaptcha', 'boombox' )
					)
				)
			)
		),
		// Google Recaptcha Site Key
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_google_recaptcha_site_key]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_google_recaptcha_site_key'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_google_recaptcha_site_key',
				'args' 	=> array(
					'label'    => esc_html__( 'Google Recaptcha Site Key', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_google_recaptcha_site_key]',
					'type'     => 'text',
				)
			)
		),
		// Google Recaptcha Secret Key
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_google_recaptcha_secret_key]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['auth_google_recaptcha_secret_key'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_google_recaptcha_secret_key',
				'args' 	=> array(
					'label'    => esc_html__( 'Google Recaptcha Secret Key', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[auth_google_recaptcha_secret_key]',
					'type'     => 'text',
				)
			)
		),
		// Social Authentication
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[auth_social_heading]',
				'args'	=> array(
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_auth_social_heading',
				'type'  => 'custom_content',
				'args' 	=> array(
					'section' => 'boombox_auth_section',
					'content' => '<h2>' . esc_html__('Social Authentication', 'boombox') . '</h2><hr />',
					'settings' => $boombox_option_name . '[auth_social_heading]',
				)
			)
		),
		// Disable Social Authentication
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[disable_social_auth]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['disable_social_auth'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_disable_social_auth',
				'args' 	=> array(
					'label'    => esc_html__( 'Disable Social Authentication', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[disable_social_auth]',
					'type'     => 'checkbox',
				)
			)
		),
		// Facebook App ID
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[facebook_app_id]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['facebook_app_id'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_facebook_app_id',
				'args' 	=> array(
					'label'    => esc_html__( 'Facebook App ID', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[facebook_app_id]',
					'type'     => 'text',
				)
			)
		),
		// Google oauth ID
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[google_oauth_id]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['google_oauth_id'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_google_oauth_id',
				'args' 	=> array(
					'label'    => esc_html__( 'Google oauth Client ID', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[google_oauth_id]',
					'type'     => 'text',
				)
			)
		),
		// Google API Key
		array(
			'setting' => array(
				'id' 	=> $boombox_option_name . '[google_api_key]',
				'args'	=> array(
					'default'           => $boombox_customizer_defaults['google_api_key'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			),
			'control' => array(
				'id' 	=> 'boombox_google_api_key',
				'args' 	=> array(
					'label'    => esc_html__( 'Google API Key', 'boombox' ),
					'section'  => 'boombox_auth_section',
					'settings' => $boombox_option_name . '[google_api_key]',
					'type'     => 'text',
				)
			)
		),
		// Other fields need to go here
	)
);

return $site_auth;