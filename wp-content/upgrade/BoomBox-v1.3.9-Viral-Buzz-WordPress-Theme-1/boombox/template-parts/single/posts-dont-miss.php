<?php
/**
 * The template part for displaying single post "Don't Miss" section.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_disable_dont_miss_block    = boombox_get_theme_option( 'layout_post_disable_dont_miss_block' );
$boombox_dont_miss_entries_per_page = boombox_get_theme_option( 'layout_post_dont_miss_entries_per_page' );
$boombox_dont_miss_entries_heading  = boombox_get_theme_option( 'layout_post_dont_miss_entries_heading' );
$boombox_dont_miss_listing_type     = apply_filters( 'boombox_dont_miss_listing_type', 'grid' );

if ( !$boombox_disable_dont_miss_block ):
	$boombox_dont_miss_posts = boombox_get_dont_miss_posts_items( 'dont_miss', $boombox_dont_miss_entries_per_page );
	if ( null != $boombox_dont_miss_posts && count( $boombox_dont_miss_posts->posts ) > 0 ): ?>
		<div class="other-posts">

			<?php if ( $boombox_dont_miss_entries_heading ): ?>
				<h3 class="title"><?php echo esc_html( $boombox_dont_miss_entries_heading ); ?></h3>
			<?php endif; ?>

			<div <?php boombox_list_type_classes( $boombox_dont_miss_listing_type, 'col-3' ); ?>>

				<?php while ( $boombox_dont_miss_posts->have_posts() ) : $boombox_dont_miss_posts->the_post(); ?>

					<?php get_template_part( 'template-parts/content', $boombox_dont_miss_listing_type ); ?>

				<?php endwhile; ?>

				<?php wp_reset_postdata(); ?>
			</div>

			<?php boombox_the_advertisement( 'boombox-single-after-dont-miss-section', 'large' ); ?>

		</div>
	<?php
	endif;
endif;
wp_reset_query(); ?>