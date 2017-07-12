<?php
/**
 * The template part for displaying the site badges navigation
 *
 * @package BoomBox_Them
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( has_nav_menu( 'badges_nav' ) ) :
	wp_nav_menu( array(
		'theme_location' => 'badges_nav',
		'menu_class'     => '',
		'container'      => false,
		'depth'          => 1,
		'items_wrap'     => '<div class="badge-list">%3$s</div>',
		'walker'         => new Boombox_Walker_Badges_Nav_Menu()
	) );
endif;