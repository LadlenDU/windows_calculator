<?php
/**
 * The template part for displaying the site more navigation
 *
 * @package BoomBox_Them
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

?>
<div id="more-menu" class="more-menu">
	<div class="more-menu-header">
		<?php get_template_part( 'template-parts/header/navigation', 'burger-badges' ); ?>
		<?php get_template_part( 'template-parts/header/navigation', 'burger-top' ); ?>
	</div>
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