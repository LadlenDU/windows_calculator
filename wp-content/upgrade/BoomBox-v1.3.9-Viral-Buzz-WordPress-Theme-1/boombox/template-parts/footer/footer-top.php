<?php
/**
 * The template part for displaying the site footer top section
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
 ?>

<div class="footer-top">
	<?php
	// Pattern
	$boombox_footer_settings = boombox_get_footer_settings();
	if ( !$boombox_footer_settings['hide_pattern'] && 'top' === $boombox_footer_settings['pattern_position'] ):
		get_template_part( 'template-parts/footer/pattern' );
	endif; ?>

	<div class="container">

		<?php
		// Featured Strip
		if ( !$boombox_footer_settings['disable_strip'] ):
			get_template_part( 'template-parts/footer/featured', 'strip' );
		endif; ?>

		<?php
		// Widgets
		if ( is_active_sidebar( 'footer-left-widgets' ) || is_active_sidebar( 'footer-middle-widgets' ) || is_active_sidebar( 'footer-right-widgets' ) ) : ?>
			<div class="row">
				<div class="col-md-4">
					<?php
					if ( is_active_sidebar( 'footer-left-widgets' ) ) :
						dynamic_sidebar( 'footer-left-widgets' );
					endif;
					?>
				</div>
				<div class="col-md-4">
					<?php
					if ( is_active_sidebar( 'footer-middle-widgets' ) ) :
						dynamic_sidebar( 'footer-middle-widgets' );
					endif;
					?>
				</div>
				<div class="col-md-4">
					<?php
					if ( is_active_sidebar( 'footer-right-widgets' ) ) :
						dynamic_sidebar( 'footer-right-widgets' );
					endif;
					?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>