<?php
/**
 * The template part for displaying post item for "small list" listing type
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_featured_image_size = 'thumbnail';
$boombox_post_classes        = 'post';
$boombox_has_post_thumbnail  = true;
$boombox_template_options    = boombox_get_template_grid_elements_options();

if ( !$boombox_template_options['media'] || !has_post_thumbnail() ):
	$boombox_post_classes       .= ' no-thumbnail';
	$boombox_has_post_thumbnail  = false;
endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $boombox_post_classes ); ?>>


		<!-- thumbnail -->
		<div class="post-thumbnail">
			<?php if ( $boombox_template_options['badges'] ) :
				$badges_list = boombox_get_post_badge_list();
				echo $badges_list['badges'];
			endif; ?>
			<?php if ( $boombox_has_post_thumbnail ) : ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>"
			   title="<?php echo esc_attr( the_title_attribute() ); ?>">
				<?php the_post_thumbnail( $boombox_featured_image_size ); ?>
			</a>
			<div class="post-meta">
				<?php if ( $boombox_template_options['share_count'] ) :
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
			endif; ?>

			<?php
			boombox_post_author_meta( array(
				'author' 		=> $boombox_template_options['author'],
				'author_args' 	=> array( 'with_avatar' => true ),
				'date' 			=> $boombox_template_options['date']
			) );
			?>

		</header>
		<!-- entry-header -->
	</div>

</article>