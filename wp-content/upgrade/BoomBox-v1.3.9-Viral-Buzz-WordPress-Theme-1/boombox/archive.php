<?php
/**
 *  The template for displaying archive pages
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), etc.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

get_header();

$boombox_archive_settings = boombox_get_archive_settings();
if ( !$boombox_archive_settings['disable_strip'] ):
	get_template_part( 'template-parts/featured', 'strip' );
endif; ?>

	<div class="container">
		<header class="page-header" <?php echo $boombox_archive_settings['thumbnail_style']; ?>>
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
			boombox_the_title_badge(); ?>
		</header>
	</div>

<?php
if ( !$boombox_archive_settings['disable_featured_area'] ):
	get_template_part( 'template-parts/featured', 'area' );
endif; ?>

<?php boombox_the_advertisement( 'boombox-archive-before-content', 'large' ); ?>

<div class="container <?php boombox_container_classes_by_type( $boombox_archive_settings['listing_type'] ); ?>">
	<div id="main" class="site-main" role="main">
		<div class="main-container">
			<?php if ( Boombox_Loop_Helper::have_posts() ) : ?>

				<div id="post-items" <?php boombox_list_type_classes( $boombox_archive_settings['listing_type'], 'col-2' ); ?>>
					<?php
					global $wp_query;
					while( Boombox_Loop_Helper::have_posts() ):
						$is_inject = Boombox_Loop_Helper::the_post();
						if( $is_inject['is_inject'] && $is_inject['is_adv'] ):
							$adv_settings = boombox_get_adv_settings(  $boombox_archive_settings['listing_type'] );
							boombox_the_advertisement( $adv_settings['location'], array( $adv_settings['size'], 'post' ) );
						elseif( $is_inject['is_inject'] && $is_inject['is_newsletter'] ):
							boombox_mailchimp_form( array( 'location' => 'listing', 'classes' => 'post' ) );
						else:
							get_template_part( 'template-parts/content-' . $boombox_archive_settings['listing_type'], get_post_format() );
						endif;
					endwhile; ?>
				</div>

				<?php
				Boombox_Loop_Helper::prepare_query_for_pagination( $wp_query );
				get_template_part( 'template-parts/pagination/pagination',  $boombox_archive_settings['pagination_type'] ); ?>

				<?php wp_reset_postdata(); ?>

			<?php endif; ?>

		</div>

		<?php boombox_the_advertisement( 'boombox-archive-after-content', 'large' ); ?>

	</div>

	<?php if ('no-sidebar' != $boombox_archive_settings['template']):
		get_sidebar();
	endif; ?>
</div>

<?php get_footer(); ?>