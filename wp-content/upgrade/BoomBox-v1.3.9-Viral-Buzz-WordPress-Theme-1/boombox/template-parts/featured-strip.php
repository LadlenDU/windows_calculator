<?php
/**
 * The template part for displaying the site strip
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_strip_settings      	= boombox_get_featured_strip_settings();
$boombox_strip_query         	= $boombox_strip_settings['query'];
$boombox_strip_size          	= $boombox_strip_settings['size'] ? $boombox_strip_settings['size'] . '-item' : 'big-item';
$boombox_strip_title_position   = sprintf( '%s-title', $boombox_strip_settings['title_position'] );
$boombox_featured_image_size 	= 'boombox_image200x150';
if ( $boombox_strip_query != null && $boombox_strip_query->found_posts ): ?>
	<div class="container">
		<div class="featured-strip featured-carousel <?php echo esc_attr( $boombox_strip_title_position ); ?> <?php echo esc_attr( $boombox_strip_size ); ?>">
			<?php while ( $boombox_strip_query->have_posts() ): $boombox_strip_query->the_post();
					$boombox_strip_has_post_thumbnail = has_post_thumbnail() ? true : false;
					$boombox_strip_item_class = $boombox_strip_has_post_thumbnail ? '' : 'no-thumbnail';
					$boombox_strip_item_title = wp_trim_words( get_the_title(), 8, '...' ); ?>
					<div class="item <?php echo esc_attr( $boombox_strip_item_class ); ?>">
						<figure class="media">
							<a href="<?php echo esc_url( get_permalink() ); ?>">
								<?php
								if( $boombox_strip_has_post_thumbnail ):
									the_post_thumbnail( $boombox_featured_image_size );
								endif; ?>
								<?php
									$badges = boombox_get_post_badge_list( array( 'badges' => false ) );
									echo $badges['post_type_badges'];
								?>
								<?php if( "inside" == $boombox_strip_settings['title_position'] ) { ?>
								<span class="title-inside"><?php echo $boombox_strip_item_title; ?></span>
								<?php } ?>
							</a>
						</figure>
						<?php if( "outside" == $boombox_strip_settings['title_position'] ) { ?>
						<h3 class="title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo $boombox_strip_item_title; ?></a></h3>
						<?php } ?>
					</div>
			<?php endwhile; ?>
		</div>
	</div>
<?php endif;
wp_reset_postdata(); ?>