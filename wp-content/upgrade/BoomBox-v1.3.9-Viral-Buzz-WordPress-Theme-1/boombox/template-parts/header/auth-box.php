<?php
/**
 * The template part for displaying the site header authentication box
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
} ?>

<?php // Show login and create post button, if site authentication is enabled
$boombox_auth_is_disabled = boombox_disabled_site_auth();
if ( ! $boombox_auth_is_disabled || is_super_admin() ) :
	$boombox_header_settings = boombox_get_header_settings();
    boombox_user_notifications_box();
	echo boombox_get_profile_button();
	echo boombox_get_create_post_button( array( 'create-post' ), $boombox_header_settings['header_button_text'], $boombox_header_settings['enable_plus_icon_on_button'], $boombox_header_settings['header_button_link'] );
endif; ?>
