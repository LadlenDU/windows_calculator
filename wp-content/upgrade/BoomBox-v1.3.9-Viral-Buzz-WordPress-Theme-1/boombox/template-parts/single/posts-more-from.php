<?php
/**
 * The template part for displaying single post "More From" section.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

global $post;
$boombox_disable_more_block     = boombox_get_theme_option( 'layout_post_disable_more_block' );
$boombox_more_entries_per_page  = boombox_get_theme_option( 'layout_post_more_entries_per_page' );
$boombox_more_entries_heading   = boombox_get_theme_option( 'layout_post_more_entries_heading' );
$boombox_more_from_listing_type = apply_filters( 'boombox_more_from_listing_type', 'list' );

if ( ! $boombox_disable_more_block ):
	$boombox_post_first_category = boombox_get_post_first_category( $post );
	if ( $boombox_post_first_category ):
		$boombox_more_from_posts = boombox_get_more_from_posts_items( 'more_from', $boombox_post_first_category, $boombox_more_entries_per_page );
		if (  null != $boombox_more_from_posts && count( $boombox_more_from_posts->posts ) > 0 ): ?>
			<div class="other-posts">

				<?php if ( $boombox_more_entries_heading ):
					$category_link = get_category_link( $boombox_post_first_category->term_id );
					$category_link = wp_kses_post( sprintf( '<a href="%1$s">%2$s</a>', esc_url( $category_link ), esc_html( $boombox_post_first_category->name ) ) ); ?>
					<h3 class="title"><?php echo esc_html( $boombox_more_entries_heading ) . ' ' . $category_link; ?></h3>
				<?php endif; ?>

				<div <?php boombox_list_type_classes( $boombox_more_from_listing_type ); ?>>

					<?php while ( $boombox_more_from_posts->have_posts() ) : $boombox_more_from_posts->the_post(); ?>

						<?php get_template_part( 'template-parts/content', $boombox_more_from_listing_type ); ?>

					<?php endwhile; ?>

					<?php wp_reset_postdata(); ?>
				</div>

				<?php boombox_the_advertisement( 'boombox-single-after-more-from-section', 'large' ); ?>

			</div>
		<?php
		endif;
	endif;
endif;
wp_reset_query(); ?>