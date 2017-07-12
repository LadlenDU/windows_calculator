<?php
/**
 *  The template for displaying author pages
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

get_header();

$boombox_author_settings = boombox_get_author_settings(); ?>

<div class="container">
	<?php
	if ( have_posts() ) : the_post();
		boombox_post_author_short_info();
	endif;
	rewind_posts(); ?>
</div>

<?php boombox_the_advertisement( 'boombox-archive-before-content', 'large' ); ?>

<div class="container <?php boombox_container_classes_by_type( $boombox_author_settings['listing_type'] ); ?>">
	<div id="main" class="site-main" role="main">
		<div class="main-container">
			<?php if ( Boombox_Loop_Helper::have_posts() ) : ?>
				<div id="post-items" <?php boombox_list_type_classes( $boombox_author_settings['listing_type'], 'col-2' ); ?>>
					<?php
					global $wp_query;
					while( Boombox_Loop_Helper::have_posts() ):
						$is_inject = Boombox_Loop_Helper::the_post();
						if( $is_inject['is_inject'] && $is_inject['is_adv'] ):
							$adv_settings = boombox_get_adv_settings(  $boombox_author_settings['listing_type'] );
							boombox_the_advertisement( $adv_settings['location'], array( $adv_settings['size'], 'post' ) );
						elseif( $is_inject['is_inject'] && $is_inject['is_newsletter'] ):
							boombox_mailchimp_form( array( 'location' => 'listing', 'classes' => 'post' ) );
						else:
							get_template_part( 'template-parts/content-' . $boombox_author_settings['listing_type'], get_post_format() );
						endif;
					endwhile;?>
				</div>

				<?php
				Boombox_Loop_Helper::prepare_query_for_pagination( $wp_query );
				get_template_part( 'template-parts/pagination/pagination', $boombox_author_settings['pagination_type'] ); ?>

				<?php wp_reset_postdata(); ?>

			<?php endif; ?>
		</div>

		<?php boombox_the_advertisement( 'boombox-archive-after-content', 'large' ); ?>

	</div>
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>