<?php
/**
 * The template part for displaying the site mobile navigation
 *
 * @package BoomBox_Them
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

?>
<div id="mobile-navigation" class="mobile-navigation-wrapper">
	<button id="menu-close" class="close">
		<i class="icon icon-close"></i>
	</button>
	<div class="holder">
		<div class="more-menu">
			<div class="more-menu-header">
				<?php get_template_part( 'template-parts/header/navigation', 'badges' ); ?>
			</div>
			<?php get_template_part( 'template-parts/header/navigation', 'header-top' ); ?>
			<?php get_template_part( 'template-parts/header/navigation', 'header-bottom' ); ?>
			<?php get_template_part( 'template-parts/header/navigation', 'burger-bottom' ); ?>
			<div class="more-menu-footer">
				<?php get_template_part( 'template-parts/header/community' ); ?>
				<div class="social circle">
					<?php
					if ( function_exists( 'boombox_social_links' ) ) :
						echo boombox_social_links();
					endif; ?>
				</div>
			</div>
		</div>

	</div>
</div>
