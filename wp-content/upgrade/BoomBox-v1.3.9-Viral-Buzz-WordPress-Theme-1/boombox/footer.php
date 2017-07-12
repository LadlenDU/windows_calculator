<?php
/**
 * The template part for displaying the footer.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

?>
			<!--Div for sticky elements -->
			<div id="sticky-border"></div>
			</div>

			<?php
			/* Footer */
			$boombox_footer_settings = boombox_get_footer_settings();
			if( !$boombox_footer_settings[ 'hide_footer_top' ] || !$boombox_footer_settings[ 'hide_footer_bottom' ] ): ?>
				<footer id="footer" class="footer <?php echo esc_attr( $boombox_footer_settings['classes'] ); ?>">
					<?php
					if( !$boombox_footer_settings[ 'hide_footer_top' ] ):
						get_template_part( 'template-parts/footer/footer', 'top' );
					endif;
					if( !$boombox_footer_settings[ 'hide_footer_bottom' ] ):
						get_template_part( 'template-parts/footer/footer', 'bottom' );
					endif; ?>
				</footer>
			<?php endif; ?>

		</div>

		<?php
		/* Popups for logged out users */
		if( ! is_user_logged_in() ) :
			get_template_part('template-parts/popups/login', 'form');
			get_template_part('template-parts/popups/reset-password', 'form');

			if(boombox_user_can_register()):
				get_template_part('template-parts/popups/registration', 'form');
			endif;
		endif;

		if ( boombox_is_plugin_active( 'viralpress/viralpress.php' ) ) :
			get_template_part('template-parts/popups/viralpress', 'create-post');
		endif;

		wp_footer(); ?>
	</body>
</html>