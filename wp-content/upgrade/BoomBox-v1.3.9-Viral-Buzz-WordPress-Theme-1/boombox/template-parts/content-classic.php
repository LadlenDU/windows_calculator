<?php
/**
 * The template part for displaying post item for "classic" listing type
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_featured_image_size 		= 'boombox_image768';
$boombox_post_classes        		= 'post';
$boombox_has_post_thumbnail  		= true;
$boombox_template_options    		= boombox_get_template_grid_elements_options();
$boombox_featured_video      		= boombox_get_post_featured_video( get_the_ID(), $boombox_featured_image_size );
$boombox_disable_full_post_button 	= boombox_get_theme_option( 'layout_post_disable_full_post_button' );
$boombox_full_post_button_label		= boombox_get_theme_option( 'layout_post_full_post_button_label' );
$boombox_is_mobile					= wp_is_mobile();

if ( !$boombox_template_options['media'] || !( has_post_thumbnail() || $boombox_featured_video ) ):
	$boombox_post_classes       .= ' no-thumbnail';
	$boombox_has_post_thumbnail  = false;
endif;

if( !$boombox_disable_full_post_button ):
	$boombox_post_classes .= ' full-post-show';
endif;?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $boombox_post_classes ); ?>>

	<!-- thumbnail -->
	<div class="post-thumbnail">
		<?php if ( $boombox_template_options['badges'] ) :
			$badges_list = boombox_get_post_badge_list();
			echo $badges_list['badges'];
		endif; ?>
		<?php if ( $boombox_has_post_thumbnail ) : ?>
		<?php
		if( $boombox_featured_video ):
			echo $boombox_featured_video;
		else: ?>

			<?php if( ! $boombox_is_mobile ) { ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( the_title_attribute() ); ?>" >
			<?php } ?>

			<?php the_post_thumbnail( $boombox_featured_image_size, array( 'play' => true ) ); ?>

			<?php if( ! $boombox_is_mobile ) { ?>
			</a>
			<?php } ?>

			<?php
		endif; ?>
			<?php if( ! boombox_is_nsfw_post() && !$boombox_featured_video && !$boombox_disable_full_post_button && $boombox_full_post_button_label && get_the_content() ) { ?>
				<a class="view-full-post" href="<?php echo esc_url( get_permalink() ); ?>">
					<span class="bb-btn bb-btn-primary"><?php echo esc_html( $boombox_full_post_button_label ); ?></span>
				</a>
			<?php } ?>
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

		<?php if ( $boombox_template_options['excerpt'] ) : ?>
			<div class="entry-content"><?php echo wp_trim_excerpt(); ?></div>
		<?php endif; ?>

	</div>

	<!-- entry-footer -->
	<footer class="entry-footer">
		<div class="post-share-box">
			<?php get_template_part( 'template-parts/single/share', 'box' ); ?>
		</div>
	</footer>
	<!-- entry-footer -->
</article>