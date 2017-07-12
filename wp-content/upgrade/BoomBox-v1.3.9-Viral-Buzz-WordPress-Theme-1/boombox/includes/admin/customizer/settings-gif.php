<?php
/**
 * WP Customizer panel section to handle GIF options
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

$boombox_option_name = boombox_get_theme_name();

$gif_settings_section = array(
    'section' => array(
        'id'   => 'boombox_gif_control_section',
        'args' => array(
            'title'    => esc_html__( 'GIF Control', 'boombox' ),
            'priority' => 200,
        )
    ),
    'fields' => array(
        // Gif Animation Event
        array(
            'setting' => array(
                'id' 	=> $boombox_option_name . '[settings_gif_control_animation_event]',
                'args'	=> array(
                    'default'           => $boombox_customizer_defaults['settings_gif_control_animation_event'],
                    'type'              => 'option',
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            ),
            'control' => array(
                'id' 	=> 'boombox_settings_gif_control_animation_event',
                'args' 	=> array(
                    'label'    => esc_html__( 'Animation Event', 'boombox' ),
                    'section'  => 'boombox_gif_control_section',
                    'settings' => $boombox_option_name . '[settings_gif_control_animation_event]',
                    'type'     => 'select',
                    'choices'  => array(
                        'click'         => esc_html__( 'Click', 'boombox' ),
                        'hover'         => esc_html__( 'Hover', 'boombox' ),
                        'scroll'        => esc_html__( 'Scroll', 'boombox' ),
                    ),
                )
            )
        ),
        // CloudConvert API
        array(
            'setting' => array(
                'id' 	=> $boombox_option_name . '[settings_gif_control_cloudconvert_heading]',
                'args'	=> array(
                    'type'              => 'option',
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            ),
            'control' => array(
                'id' 	=> 'boombox_settings_gif_control_cloudconvert_heading',
                'type'  => 'custom_content',
                'args' 	=> array(
                    'section' => 'boombox_gif_control_section',
                    'content' => '<h2>' . esc_html__('CloudConvert', 'boombox') . '</h2><hr />',
                    'settings' => $boombox_option_name . '[settings_gif_control_cloudconvert_heading]',
                )
            )
        ),
        // CloudConvert App Key
        array(
            'setting' => array(
                'id' 	=> $boombox_option_name . '[settings_gif_control_cloudconvert_app_key]',
                'args'	=> array(
                    'default'           => $boombox_customizer_defaults['settings_gif_control_cloudconvert_app_key'],
                    'type'              => 'option',
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            ),
            'control' => array(
                'id' 	=> 'boombox_settings_gif_control_cloudconvert_app_key',
                'args' 	=> array(
                    'label'    => esc_html__( 'CloudConvert App Key', 'boombox' ),
                    'section'  => 'boombox_gif_control_section',
                    'settings' => $boombox_option_name . '[settings_gif_control_cloudconvert_app_key]',
                    'type'     => 'text',
                )
            )
        ),
        // Storage
        array(
            'setting' => array(
                'id' 	=> $boombox_option_name . '[settings_gif_control_storage]',
                'args'	=> array(
                    'default'           => $boombox_customizer_defaults['settings_gif_control_storage'],
                    'type'              => 'option',
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            ),
            'control' => array(
                'id' 	=> 'boombox_settings_gif_control_storage',
                'args' 	=> array(
                    'label'    => esc_html__( 'Storage', 'boombox' ),
                    'section'  => 'boombox_gif_control_section',
                    'settings' => $boombox_option_name . '[settings_gif_control_storage]',
                    'type'     => 'select',
                    'choices'  => array(
                        'local'         => esc_html__( 'Local', 'boombox' ),
                        'aws_s3'        => esc_html__( 'Amazon S3', 'boombox' ),
                    ),
                )
            )
        ),
        // Amazon S3
        array(
            'setting' => array(
                'id' 	=> $boombox_option_name . '[settings_gif_control_aws_s3_heading]',
                'args'	=> array(
                    'type'              => 'option',
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            ),
            'control' => array(
                'id' 	=> 'boombox_settings_gif_control_aws_s3_heading',
                'type'  => 'custom_content',
                'args' 	=> array(
                    'section' => 'boombox_gif_control_section',
                    'content' => '<h3>' . esc_html__('Amazon S3', 'boombox') . '</h3><hr />',
                    'settings' => $boombox_option_name . '[settings_gif_control_aws_s3_heading]',
                )
            )
        ),
        // Access Key Id
        array(
            'setting' => array(
                'id' 	=> $boombox_option_name . '[settings_gif_control_aws_s3_access_key_id]',
                'args'	=> array(
                    'default'           => $boombox_customizer_defaults['settings_gif_control_aws_s3_access_key_id'],
                    'type'              => 'option',
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            ),
            'control' => array(
                'id' 	=> 'boombox_settings_gif_control_aws_s3_access_key_id',
                'args' 	=> array(
                    'label'    => esc_html__( 'Access Key Id', 'boombox' ),
                    'section'  => 'boombox_gif_control_section',
                    'settings' => $boombox_option_name . '[settings_gif_control_aws_s3_access_key_id]',
                    'type'     => 'text',
                )
            )
        ),
        // Secret Access Key
        array(
            'setting' => array(
                'id' 	=> $boombox_option_name . '[settings_gif_control_aws_s3_secret_access_key]',
                'args'	=> array(
                    'default'           => $boombox_customizer_defaults['settings_gif_control_aws_s3_secret_access_key'],
                    'type'              => 'option',
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            ),
            'control' => array(
                'id' 	=> 'boombox_settings_gif_control_aws_s3_secret_access_key',
                'args' 	=> array(
                    'label'    => esc_html__( 'Secret Access Key', 'boombox' ),
                    'section'  => 'boombox_gif_control_section',
                    'settings' => $boombox_option_name . '[settings_gif_control_aws_s3_secret_access_key]',
                    'type'     => 'text',
                )
            )
        ),
        // Bucket Name
        array(
            'setting' => array(
                'id' 	=> $boombox_option_name . '[settings_gif_control_aws_s3_bucket_name]',
                'args'	=> array(
                    'default'           => $boombox_customizer_defaults['settings_gif_control_aws_s3_bucket_name'],
                    'type'              => 'option',
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_text_field',
                )
            ),
            'control' => array(
                'id' 	=> 'boombox_settings_gif_control_aws_s3_bucket_name',
                'args' 	=> array(
                    'label'    => esc_html__( 'Bucket Name', 'boombox' ),
                    'section'  => 'boombox_gif_control_section',
                    'settings' => $boombox_option_name . '[settings_gif_control_aws_s3_bucket_name]',
                    'type'     => 'text',
                )
            )
        ),
    )
);

return $gif_settings_section;

