<?php
/**
 * The template part for displaying single post related entries.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_disable_related_block    = boombox_get_theme_option( 'layout_post_disable_related_block' );
$boombox_related_entries_per_page = boombox_get_theme_option( 'layout_post_related_entries_per_page' );
$boombox_related_entries_heading  = boombox_get_theme_option( 'layout_post_related_entries_heading' );
$boombox_related_listing_type     = apply_filters( 'boombox_related_listing_type', 'grid' );

if ( ! $boombox_disable_related_block ):
	$boombox_related_posts = boombox_get_related_posts_items( 'related', $boombox_related_entries_per_page );
	if ( null != $boombox_related_posts && count( $boombox_related_posts->posts ) > 0 ):  ?>
		<div class="other-posts">

			<?php if ( $boombox_related_entries_heading ): ?>
				<h3 class="title"><?php echo esc_html( $boombox_related_entries_heading ); ?></h3>
			<?php endif; ?>

			<div <?php boombox_list_type_classes( $boombox_related_listing_type, 'col-3' ); ?>>

				<?php while ( $boombox_related_posts->have_posts() ) : $boombox_related_posts->the_post(); ?>

					<?php get_template_part( 'template-parts/content', $boombox_related_listing_type ); ?>

				<?php endwhile; ?>

				<?php wp_reset_postdata(); ?>
			</div>

			<?php boombox_the_advertisement( 'boombox-single-after-also-like-section', 'large' ); ?>

		</div>
	<?php
	endif;
endif;
wp_reset_query(); ?>