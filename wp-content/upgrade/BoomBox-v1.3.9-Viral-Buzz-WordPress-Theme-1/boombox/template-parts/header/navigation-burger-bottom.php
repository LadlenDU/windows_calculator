<?php
/**
 * The template part for displaying the site burger bottom navigation
 *
 * @package BoomBox_Them
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( has_nav_menu( 'burger_bottom_nav' ) ) : ?>
	<div class="more-menu-body">
		<span class="sections-header"><?php esc_html_e( 'sections', 'boombox' ) ?></span>
		<nav class="section-navigation">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'burger_bottom_nav',
				'menu_class'     => '',
				'depth'          => 1,
				'container'      => false
			) ); ?>
		</nav>
	</div>
<?php endif; ?>