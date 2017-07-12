<?php
/**
 * The template part for displaying the site background image
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
$boombox_body_background_image = boombox_get_theme_option( 'design_global_body_background_image' );
$boombox_body_background_link  = boombox_get_theme_option( 'design_global_body_background_link' );
if( $boombox_body_background_image ):
	$boombox_body_background_link = $boombox_body_background_link ? '<a class="link" href="' . $boombox_body_background_link . '" target="_blank"></a>' : '';
	$boombox_body_background_image = 'style="background-image: url(\'' . esc_url( $boombox_body_background_image ) . '\')"';
	printf( '<div id="background-image" class="background-image" %1$s>%2$s</div>',
		$boombox_body_background_image,
		$boombox_body_background_link
	);
endif;