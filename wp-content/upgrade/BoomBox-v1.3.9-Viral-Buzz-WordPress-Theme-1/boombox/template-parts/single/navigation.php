<?php
/**
 * The template part for displaying the post navigation
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

?>
<nav class="navigation post-navigation row" role="navigation">
	<?php
	$boombox_prev_post = get_previous_post();
	if ( ! empty( $boombox_prev_post ) ): ?>
		<div class="col-lg-6 col-md-6">
			<span class="meta-nav"><?php esc_html_e( 'Previous Post', 'boombox' ); ?></span>

			<div class="prev-page page">
				<?php if ( has_post_thumbnail( $boombox_prev_post->ID ) ) : ?>
					<a class="image" href="<?php echo esc_url( get_permalink( $boombox_prev_post->ID ) ); ?>">
						<div>
							<?php echo get_the_post_thumbnail( $boombox_prev_post->ID, 'thumbnail' ); ?>
						</div>
					</a>
				<?php endif; ?>
				<div class="content">
					<h6 class="post-title"><a
							href="<?php echo esc_url( get_permalink( $boombox_prev_post->ID ) ); ?>"><?php echo wp_trim_words($boombox_prev_post->post_title, 10, '...'); ?></a>
					</h6>
					<?php boombox_post_author( array('post_author_id' => $boombox_prev_post->post_author) ); ?>
				</div>
			</div>
		</div>
	<?php endif ?>

	<?php
	$boombox_next_post = get_next_post();
	if ( ! empty( $boombox_next_post ) ): ?>
		<div class="col-lg-6 col-md-6">
			<span class="meta-nav"><?php esc_html_e( 'Next Post', 'boombox' ); ?></span>

			<div class="next-page page">
				<?php if ( has_post_thumbnail( $boombox_next_post->ID ) ) : ?>
					<a class="image" href="<?php echo esc_url( get_permalink( $boombox_next_post->ID ) ); ?>">
						<div>
							<?php echo get_the_post_thumbnail( $boombox_next_post->ID, 'thumbnail' ); ?>
						</div>
					</a>
				<?php endif; ?>
				<div class="content">
					<h6 class="post-title"><a
							href="<?php echo esc_url( get_permalink( $boombox_next_post->ID ) ); ?>"><?php echo wp_trim_words($boombox_next_post->post_title, 10, '...'); ?></a>
					</h6>
					<?php boombox_post_author( array('post_author_id' => $boombox_next_post->post_author) ); ?>
				</div>
			</div>
		</div>
	<?php endif ?>
</nav>