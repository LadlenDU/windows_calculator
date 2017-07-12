<?php
/**
 * The template part for displaying the site logo, community and crate post button
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_header_settings = boombox_get_header_settings();

$boombox_small_logo     = isset( $boombox_header_settings['small_logo'] ) && '' != $boombox_header_settings['small_logo'] ? $boombox_header_settings['small_logo'] : '';
$boombox_community_text = isset( $boombox_header_settings['header_community_text'] ) && '' != $boombox_header_settings['header_community_text'] ? $boombox_header_settings['header_community_text'] : '';
?>
<div class="community">
	<?php
	if ( $boombox_small_logo ): ?>
		<span class="logo">
	        <img src="<?php echo esc_url( $boombox_small_logo ) ?>" alt="">
	    </span>
	<?php endif;

	if ( $boombox_community_text ): ?>
		<span class="text"><?php echo esc_html( $boombox_community_text ); ?></span>
	<?php
	endif;

	// Show create post buttons, if site authentication is enabled
	$boombox_auth_is_disabled = boombox_disabled_site_auth();
	if ( ! $boombox_auth_is_disabled ) :
		echo  boombox_get_create_post_button( array( 'create-post', 'bb-btn', 'bb-btn-default' ), $boombox_header_settings['header_button_text'], $boombox_header_settings['enable_plus_icon_on_button'], $boombox_header_settings['header_button_link'] );
	endif; ?>

</div>