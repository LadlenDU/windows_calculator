<?php
/**
 * The template part for displaying "Prev/Next" pagination.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

global $wp_query;
$boombox_posts_per_page = absint( $wp_query->get( 'posts_per_page' ) );

if( 0 < $boombox_posts_per_page ){
	$boombox_big            = 999999999;
	$boombox_paged          = absint( $wp_query->get( 'paged' ) ) ? absint( $wp_query->get( 'paged' ) ) : 1;
	$boombox_found_posts    = absint( $wp_query->found_posts ) ? absint( $wp_query->found_posts ) : 1;
	$boombox_current_page   = max( 1, $boombox_paged );
	$boombox_total          = absint( $wp_query->max_num_pages );


	$boombox_pages = paginate_links( array(
		'base'      => str_replace( $boombox_big, '%#%', esc_url( get_pagenum_link( $boombox_big ) ) ),
		'format'    => '?paged=%#%',
		'prev_text' => esc_html__( 'Previous', 'boombox' ),
		'next_text' => esc_html__( 'Next', 'boombox' ),
		'total'     => $boombox_total,
		'current'   => $boombox_current_page,
		'type'      => 'plain',
		'end_size'  => 1,
		'mid_size'  => 1,
	) );

	if ( ! empty( $boombox_pages ) ) {
		?>
		<nav class="navigation pagination" role="navigation">
			<div class="nav-links">
				<?php echo $boombox_pages; ?>
			</div>
		</nav>
	<?php
	}
}
