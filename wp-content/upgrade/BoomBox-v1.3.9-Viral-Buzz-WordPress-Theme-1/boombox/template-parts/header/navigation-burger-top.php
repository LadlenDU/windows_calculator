<?php
/**
 * The template part for displaying the site burger top navigation
 *
 * @package BoomBox_Them
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( has_nav_menu( 'burger_top_nav' ) ) : ?>
	<nav class="trending-navigation">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'burger_top_nav',
			'menu_class'     => '',
			'depth'          => 1,
			'container'      => false,
			'walker'         => new Boombox_Walker_Nav_Menu_Custom_Fields()
		) ); ?>
	</nav>
<?php endif; ?>