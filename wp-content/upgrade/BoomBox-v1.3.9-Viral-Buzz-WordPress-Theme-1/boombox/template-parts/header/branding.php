<?php
/**
 * The template part for displaying the site logo and tagline
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_logo             = boombox_get_logo();
$boombox_site_name        = get_bloginfo( 'name' );
$boombox_site_description = get_bloginfo( 'description' ); ?>

<div id="branding" class="branding">
	<h1 class="site-title">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( ! empty( $boombox_logo ) ):
				$width  = absint( $boombox_logo['width'] );
				$width = $width ? sprintf( 'width="%d"', $width ) : '';

				$height = absint( $boombox_logo['height'] );
				$height = $height ? sprintf( 'height="%d"', $height ) : '';

				$src    = esc_url( $boombox_logo['src'] );
				$srcset = isset( $boombox_logo['src_2x'] ) ? sprintf( 'srcset="%s"', esc_attr( $boombox_logo['src_2x'] ) ) : '';
				printf( '<img src="%s" %s %s %s alt="%s" />', $src, $width, $height, $srcset, esc_attr( $boombox_site_name ) );
			else:
				echo esc_html( $boombox_site_name );
			endif; ?>
		</a>
	</h1>
	<?php if ( $boombox_site_description && boombox_get_theme_option( 'branding_show_tagline' ) ) : ?>
		<p class="site-description"><?php echo esc_html( $boombox_site_description ); ?></p>
	<?php endif; ?>
</div>