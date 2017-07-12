<?php
/**
 * The template part for displaying the site header share
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( boombox_is_plugin_active( 'boombox-theme-extensions/boombox-theme-extensions.php' ) ) : ?>
	<div class="share-menu-item">
		<a class="share-icon icon-share2 js-inline-popup" href="#social-box"></a>
		<?php get_template_part( 'template-parts/popups/header', 'share' ); ?>
	</div>
<?php endif; ?>