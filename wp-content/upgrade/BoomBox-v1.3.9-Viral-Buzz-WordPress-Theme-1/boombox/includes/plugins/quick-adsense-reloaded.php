<?php
/**
 * WP QUADS plugin functions
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( boombox_is_plugin_active( 'quick-adsense-reloaded/quick-adsense-reloaded.php' ) && function_exists( 'quads_register_ad' ) ) {

	$boombox_ads_locations = array(
		array(
			'location' 		=> 'boombox-archive-before-header',
			'description' 	=> esc_html( 'Archive: Before Header' )
		),
		array(
			'location' 	  	=> 'boombox-archive-before-content',
			'description' 	=> esc_html( 'Archive: Before content theme area' )
		),
		array(
			'location'    	=> 'boombox-archive-after-content',
			'description' 	=> esc_html( 'Archive: After content theme area' )
		),
		array(
			'location' 		=> 'boombox-page-before-header',
			'description' 	=> esc_html( 'Page: Before Header' )
		),
		array(
			'location'    	=> 'boombox-page-before-content',
			'description' 	=> esc_html( 'Page: Before content theme area' )
		),
		array(
			'location'    	=> 'boombox-page-after-content',
			'description' 	=> esc_html( 'Page: After content theme area' )
		),
		array(
			'location' 		=> 'boombox-single-before-header',
			'description' 	=> esc_html( 'Single: Before Header' )
		),
		array(
			'location'    	=> 'boombox-single-before-content',
			'description' 	=> esc_html( 'Single: Before content theme area' )
		),
		array(
			'location'    	=> 'boombox-single-before-navigation',
			'description' 	=> esc_html( 'Single: Before navigation area' )
		),
		array(
			'location'    	=> 'boombox-single-after-also-like-section',
			'description' 	=> esc_html( 'Single: After "Also Like" section' )
		),
		array(
			'location'    	=> 'boombox-single-after-more-from-section',
			'description' 	=> esc_html( 'Single: After "More From" section' )
		),
		array(
			'location'    	=> 'boombox-single-after-comments-section',
			'description' 	=> esc_html( 'Single: After Comments section' )
		),
		array(
			'location'    	=> 'boombox-single-after-dont-miss-section',
			'description' 	=> esc_html( 'Single: After "Don\'t miss" section' )
		),
		array(
			'location'    	=> 'boombox-listing-type-grid-instead-post',
			'description' 	=> esc_html( 'Instead of "grid" or "three column" listing post' )
		),
		array(
			'location'    	=> 'boombox-listing-type-non-grid-instead-post',
			'description' 	=> esc_html( 'Instead of none grid listing post' )
		)
	);

	foreach( $boombox_ads_locations as $ad_location ) {
		quads_register_ad( $ad_location );
	}
}