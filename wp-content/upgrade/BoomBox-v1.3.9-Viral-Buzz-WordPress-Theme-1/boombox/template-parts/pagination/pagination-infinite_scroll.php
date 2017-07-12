<?php
/**
 * The template part for displaying "Load More" pagination.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( null !== get_next_posts_link() ) : ?>
	<div class="more-load-button infinite_scroll">
		<button id="load-more-button" data-next_url="<?php echo esc_url( get_next_posts_page_link() ); ?>" data-scroll="infinite_scroll">
			<i class="icon icon-spinner spinner-pulse"></i>
			<span class="text"><?php esc_html_e( 'Load more', 'boombox' ); ?></span>
		</button>
	</div>
<?php endif; ?>