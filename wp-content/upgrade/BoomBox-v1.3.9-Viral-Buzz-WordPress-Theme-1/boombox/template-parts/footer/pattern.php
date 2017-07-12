<?php
/**
* The template part for displaying the site footer pattern
*
* @package BoomBox_Theme
*/

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

?>
<div class="pattern">
	<?php
		$footer_pattern_type = boombox_get_theme_option( 'design_footer_pattern_type' );
		$footer_pattern_path = BOOMBOX_THEME_PATH . '/images/svg/footer/' . $footer_pattern_type;
		if( $footer_pattern_path ) {
			echo @file_get_contents( $footer_pattern_path );
		}
	?>
</div>