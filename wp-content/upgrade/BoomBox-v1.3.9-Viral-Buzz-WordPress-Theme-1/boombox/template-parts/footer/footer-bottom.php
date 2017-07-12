<?php
/**
 * The template part for displaying the site footer bottom section
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>

<div class="footer-bottom">
	<?php
	$boombox_footer_settings = boombox_get_footer_settings();
	if ( !$boombox_footer_settings['hide_pattern'] && 'bottom' === $boombox_footer_settings['pattern_position'] ):
		get_template_part( 'template-parts/footer/pattern' );
	endif; ?>

	<div class="container">

		<?php
		// Footer Navigation
		if ( has_nav_menu( 'footer_nav' ) ): ?>
			<div class="footer-nav">
				<nav>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer_nav',
						'menu_class'     => '',
						'depth'          => 1,
						'container'      => false
					) );
					?>
				</nav>
			</div>
		<?php endif; ?>

		<?php //Footer Social
		if ( function_exists( 'boombox_social_links' ) && false == $boombox_footer_settings['hide_social_icons'] ): ?>
			<div class="social-footer social">
				<?php echo boombox_social_links(); ?>
			</div>
		<?php endif; ?>

		<?php //Footer Copyright ?>
		<div class="copy-right">&copy;
			<?php printf( __( '%1$s %2$s.', 'boombox' ),
				date( 'Y' ),
				wp_kses_post( $boombox_footer_settings['footer_text'] )
			); ?>
		</div>

	</div>
</div>