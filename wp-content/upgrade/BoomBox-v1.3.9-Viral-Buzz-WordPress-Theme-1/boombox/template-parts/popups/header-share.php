<?php
/**
 * The template part for displaying social popup
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

?>

<div id="social-box" class="social-box inline-popup">
	<h4 class="title"><?php esc_html_e( 'Connect with us', 'boombox' ); ?></h4>

	<div class="social circle">
		<?php
		if ( function_exists( 'boombox_social_links' ) ) :
			echo boombox_social_links();
		endif; ?>
	</div>
	<div class="popup-footer">
		<?php get_template_part( 'template-parts/header/community' ); ?>
	</div>
</div>