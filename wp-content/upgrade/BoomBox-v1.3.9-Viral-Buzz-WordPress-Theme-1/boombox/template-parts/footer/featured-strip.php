<?php
/**
 * The template part for displaying the site footer featured-strip
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_footer_strip_query = boombox_get_footer_featured_strip_items();

if ( $boombox_footer_strip_query != null && $boombox_footer_strip_query->found_posts ): ?>
	<div class="featured-strip featured-carousel big-item outside-title">
		<?php while ( $boombox_footer_strip_query->have_posts() ): $boombox_footer_strip_query->the_post();
			$boombox_strip_has_post_thumbnail = has_post_thumbnail() ? true : false;
			$boombox_strip_item_class = $boombox_strip_has_post_thumbnail ? '' : 'no-thumbnail';?>
			<div class="item <?php echo esc_attr( $boombox_strip_item_class ); ?>">
				<figure class="media">
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php
						if( $boombox_strip_has_post_thumbnail ):
							the_post_thumbnail( 'boombox_image200x150' );
						endif; ?>
						<span class="title-inside"><?php echo wp_trim_words( get_the_title(), 8, '...' ); ?></span>
					</a>
				</figure>
				<h3 class="title">
					<a href="<?php echo esc_url( get_permalink() ); ?>">
						<?php echo wp_trim_words( get_the_title(), 8, '...' ); ?>
					</a>
				</h3>
			</div>
		<?php endwhile; ?>
	</div>
<?php endif;
wp_reset_postdata(); ?>