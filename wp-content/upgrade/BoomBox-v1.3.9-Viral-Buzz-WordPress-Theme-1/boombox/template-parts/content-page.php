<?php
/**
 * The template part for displaying page content
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<div class="section-box">
			<?php the_content(); ?>

			<?php wp_link_pages(); ?>
		</div>
	</div>
</article>