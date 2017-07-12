<?php
/**
 * The template part for single post fixed header
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}
?>
<div class="fixed-next-page">
    <div class="container">
        <div class="post-title">
            <h2><?php the_title(); ?></h2>
        </div>
        <?php
        global $page, $numpages;
        boombox_single_post_link_pages( array(
            'before'                => '<div class="next-page">',
            'after'                 => '</div>',
            'prev'                  => false,
            'reverse'               => (boombox_get_theme_option( 'layout_post_navigation_direction' ) == 'to-oldest'),
            'paging'                => '<span class="pages">' . sprintf( '<b>%1$d</b> / %2$d', $page, $numpages ) . '</span>',
            'previous_page_link'    => '',
            'next_page_link'        => '<i class="icon icon-chevron-right"></i><span class="text">' . esc_html__( 'Next', 'boombox' ).'</span>',
            'previous_post_link'    => '',
            'next_post_link'        => '<i class="icon icon-chevron-right"></i><span class="text">' . esc_html__( 'Next Post', 'boombox' ).'</span>'
        ) );
        ?>
    </div>
</div>
