<?php
/**
 * The template part for displaying the site header more box
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>

<div class="more-menu-item">
	<a id="more-menu-toggle" class="toggle" href="#">
		<i class="toggle-icon icon-bars"></i>
	</a>
	<?php get_template_part( 'template-parts/header/navigation', 'more' ); ?>
</div>