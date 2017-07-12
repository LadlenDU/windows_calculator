<?php
/**
 * Register the required plugins for BoomBox theme.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

add_action( 'tgmpa_register', 'boombox_register_required_plugins' );
function boombox_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'               => esc_html__( 'BoomBox Theme Extensions', 'boombox' ),       // The plugin name.
			'slug'               => 'boombox-theme-extensions',       // The plugin slug (typically the folder name).
			'source'             => BOOMBOX_ADMIN_PATH . 'activation/plugins/boombox-theme-extensions.zip',   // The plugin source.
			'required'           => true,   // If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.1.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '' // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => esc_html__( 'Envato WordPress Toolkit', 'boombox' ),       // The plugin name.
			'slug'               => 'envato-wordpress-toolkit',     // The plugin slug (typically the folder name).
			'source'             => BOOMBOX_ADMIN_PATH . 'activation/plugins/envato-wordpress-toolkit-master.zip',       // The plugin source.
			'required'           => false,      // If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.7.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented.
			'force_activation'   => false,  // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false,  // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'plugin_file'        => 'index.php'
		),
		array(
			'name'     => esc_html__( 'MailChimp for WordPress', 'boombox' ),
			'slug'     => 'mailchimp-for-wp',
			'required' => false
		),
		array(
			'name'     => esc_html__( 'Mashshare Share Buttons', 'boombox' ),
			'slug'     => 'mashsharer',
			'required' => false
		),
		array(
			'name'     => esc_html__( 'AdSense Integration WP QUADS', 'boombox' ),
			'slug'     => 'quick-adsense-reloaded',
			'required' => false
		)/*,
		array(
			'name'     => esc_html__( 'One Click Demo Import', 'boombox' ),
			'slug'     => 'one-click-demo-import',
			'required' => false
		)*/
	);

	/*
	 * Array of configuration settings.
	 */
	$config = array(
		'id'           => 'boombox',                    // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                           // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins',      // Menu slug.
		'has_notices'  => true,                         // Show admin notices or not.
		'dismissable'  => true,                         // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                           // If 'dismissible' is false, this message will be output at top of nag.
		'is_automatic' => false,                        // Automatically activate plugins after installation or not.
		'message'      => '',                           // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
