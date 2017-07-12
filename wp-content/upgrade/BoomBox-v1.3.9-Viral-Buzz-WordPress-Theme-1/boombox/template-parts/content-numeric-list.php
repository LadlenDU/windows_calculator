<?php
/**
 * The template part for displaying post item for "listing" listing type
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

global $wp_query;

$boombox_template_options   = boombox_get_template_grid_elements_options();
$boombox_posts_per_page     = $wp_query->query_vars['posts_per_page'];
$boombox_paged              = ! isset( $wp_query->query['paged'] ) ? 1 : (int) $wp_query->query['paged'];
$boombox_current_item_index = (int) $wp_query->current_post + 1;
$boombox_index              = 1 == $boombox_paged ? $boombox_current_item_index : $boombox_posts_per_page * ( $boombox_paged - 1 ) + $boombox_current_item_index;
$boombox_featured_image_size = 'boombox_image360x180';
$boombox_post_classes        = 'post';
$boombox_has_post_thumbnail  = true;

if ( !$boombox_template_options['media'] || !has_post_thumbnail() ):
	$boombox_post_classes       .= ' no-thumbnail';
	$boombox_has_post_thumbnail  = false;
endif;  ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $boombox_post_classes ); ?>>


		<!-- thumbnail -->
		<div class="post-thumbnail">
			<div class="post-number">
				<?php echo esc_html( $boombox_index ); ?>
			</div>
			<?php if ( $boombox_has_post_thumbnail ) : ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>"
			   title="<?php echo esc_attr( the_title_attribute() ); ?>">
				<?php the_post_thumbnail( $boombox_featured_image_size ); ?>
			</a>
			<div class="post-meta">
				<?php if ( isset( $boombox_template_options['share_count'] ) && $boombox_template_options['share_count'] ) :
					boombox_post_share_count();
				endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<!-- thumbnail -->

	<div class="content">
		<!-- entry-header -->
		<header class="entry-header">
			<?php if ( $boombox_template_options['categories'] ) :
				boombox_categories_list();
			endif;
			if ( comments_open() && $boombox_template_options['comments_count'] ) :
				boombox_post_comments();
			endif;

			the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' );

			if ( $boombox_template_options['subtitle'] ) :
				boombox_the_post_subtitle();
			endif;


			boombox_post_author_meta( array(
				'before' 		=> '',
				'after'	 		=> '',
				'author' 		=> $boombox_template_options['author'],
				'author_args'	=> array( 'with_avatar' => true ),
				'date' 			=> $boombox_template_options['date']
			) ); ?>

		</header>
		<!-- entry-header -->
	</div>

</article>