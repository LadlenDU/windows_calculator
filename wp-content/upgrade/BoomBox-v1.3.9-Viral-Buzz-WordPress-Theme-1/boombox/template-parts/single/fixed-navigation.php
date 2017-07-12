<?php
/**
 * The template part for displaying the post fixed navigation
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

$boombox_reverse_pagination = (boombox_get_theme_option( 'layout_post_navigation_direction' ) == 'to-oldest');
?>

<div class="fixed-pagination">
    <?php
    $boombox_post = $boombox_reverse_pagination ? get_next_post() : get_previous_post();
    if ( ! empty( $boombox_post ) ) { ?>
        <div class="page prev">
            <?php $boombox_post_url = esc_url( get_permalink( $boombox_post->ID ) ); ?>
            <a class="arrow" href="<?php echo $boombox_post_url; ?>">
                <span class="info">
                    <?php /* <span class="pages"><b>3</b>/12</span> */ ?>
                    <i class="icon icon-chevron-left"></i>
                </span>
            </a>

            <a class="content" href="<?php echo $boombox_post_url; ?>">

                <?php if ( has_post_thumbnail( $boombox_post->ID ) ) { ?>
                <span class="thumb"><?php echo get_the_post_thumbnail( $boombox_post->ID, 'thumbnail' ); ?></span>
                <?php } ?>

                <span class="title"><?php echo wp_trim_words($boombox_post->post_title, 10, '...'); ?></span>

            </a>
        </div>
    <?php } ?>

    <?php
    $boombox_post = $boombox_reverse_pagination ? get_previous_post() : get_next_post();
    if ( ! empty( $boombox_post ) ) { ?>
        <div class="page next">
            <?php $boombox_post_url = esc_url( get_permalink( $boombox_post->ID ) ); ?>
            <a class="arrow " href="<?php echo $boombox_post_url; ?>">
                <span class="info">
                    <?php /* <span class="pages"><b>3</b>/12</span> */ ?>
                    <i class="icon icon-chevron-right"></i>
                </span>
            </a>
            <a class="content" href="<?php echo $boombox_post_url; ?>">

                <?php if ( has_post_thumbnail( $boombox_post->ID ) ) { ?>
                <span class="thumb"><?php echo get_the_post_thumbnail( $boombox_post->ID, 'thumbnail' ); ?></span>
                <?php } ?>

                <span class="title"><?php echo wp_trim_words($boombox_post->post_title, 10, '...'); ?></span>

            </a>
        </div>
    <?php } ?>

</div>