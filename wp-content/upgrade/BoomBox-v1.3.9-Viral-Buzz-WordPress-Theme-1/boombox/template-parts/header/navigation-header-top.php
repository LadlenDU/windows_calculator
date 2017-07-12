<?php
/**
 * The template part for displaying the site header top navigation
 *
 * @package BoomBox_Them
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( has_nav_menu( 'top_header_nav' ) ) :  ?>
	<nav class="main-navigation">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'top_header_nav',
			'menu_class'     => '',
			'container'      => false,
			'walker'         => new Boombox_Walker_Nav_Menu_Custom_Fields()
		) );
		?>
	</nav>
<?php endif;