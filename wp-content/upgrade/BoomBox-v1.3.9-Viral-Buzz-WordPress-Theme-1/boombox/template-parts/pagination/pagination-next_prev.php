<?php
/**
 * The template part for displaying "Next/Prev" pagination.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

$has_prev = ( null !== get_previous_posts_link() );
$has_next = ( null !== get_next_posts_link() );
?>
<?php if( $has_prev || $has_next ) { ?>
<div class="next-prev-pagination no-pages">

    <span class="nav prev-page <?php echo $has_prev ? '' : 'disabled'; ?>">
        <a href="<?php echo $has_prev ? esc_url( get_previous_posts_page_link() ) : 'javascript:void(0)'; ?>">
            <i class="icon icon-chevron-left"></i>
            <span class="text"><?php esc_html_e('Previous', 'boombox'); ?></span>
            <span class="mobile-text"><?php esc_html_e('Previous', 'boombox'); ?></span>
        </a>
    </span>

    <span class="nav next-page <?php echo $has_next ? '' : 'disabled'; ?>">
        <a href="<?php echo $has_next ? esc_url( get_next_posts_page_link() ) : 'javascript:void(0)'; ?>">
            <i class="icon icon-chevron-right"></i>
            <span class="text"><?php esc_html_e('Next', 'boombox'); ?></span>
            <span class="mobile-text"><?php esc_html_e('Next', 'boombox'); ?></span>
        </a>
    </span>

</div>
<?php } ?>