<?php
/**
 * The template for displaying the page with right sidebar
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

get_header();

$boombox_paged         = boombox_get_paged();
$boombox_page_settings = boombox_get_page_settings( $boombox_paged );

if ( true == $boombox_page_settings['enable_strip'] ):
	get_template_part( 'template-parts/featured', 'strip' );
endif;

if ( true != $boombox_page_settings['hide_page_title'] ): ?>
	<div class="container">
		<header class="page-header">
			<?php if ( have_posts() ) : the_post();
				the_title( '<h1 class="page-title">', '</h1>' );
			endif; ?>
		</header>
	</div>
	<?php
	rewind_posts();
endif;

if ( true == $boombox_page_settings['enable_featured_area'] ):
	get_template_part( 'template-parts/featured', 'area' );
endif; ?>

<div class="container">
	<?php boombox_the_advertisement( 'boombox-page-before-content', 'large' ); ?>
</div>

<div class="container <?php boombox_container_classes_by_type( $boombox_page_settings['listing_type'], $boombox_page_settings['three_column_sidebar_position'] ); ?>">

	<div id="main" class="site-main" role="main">

		<div class="main-container">

			<?php
			if ( empty( $boombox_page_settings['listing_type'] ) || 'none' == $boombox_page_settings['listing_type'] ):
				if ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endif;

			elseif ( null != $boombox_page_settings['query'] ) :
				global $wp_query;
				$tmp_query = $wp_query;
				$wp_query = $boombox_page_settings['query'];
				if ( Boombox_Loop_Helper::have_posts() ): ?>
					<div id="post-items" <?php boombox_list_type_classes( $boombox_page_settings['listing_type'], 'col-2' ); ?> >
						<?php
						while( Boombox_Loop_Helper::have_posts() ):
							$is_inject = Boombox_Loop_Helper::the_post();
							if( $is_inject['is_inject'] && $is_inject['is_adv'] ):
								$adv_settings = boombox_get_adv_settings(  $boombox_page_settings['listing_type'] );
								boombox_the_advertisement( $adv_settings['location'], array( $adv_settings['size'], 'post' ), $tmp_query, $wp_query );
							elseif( $is_inject['is_inject'] && $is_inject['is_newsletter'] ):
								boombox_mailchimp_form( array( 'location' => 'listing', 'classes' => 'post' ) );
							else:
								get_template_part( 'template-parts/content-' . $boombox_page_settings['listing_type'], get_post_format() );
							endif;
						endwhile; ?>
					</div>
					<?php
					if ( 'none' != $boombox_page_settings['pagination_type'] ):
						Boombox_Loop_Helper::prepare_query_for_pagination( $wp_query );
						get_template_part( 'template-parts/pagination/pagination', $boombox_page_settings['pagination_type'] );
					endif;
				endif;
				wp_reset_query();

			endif; ?>

			<?php boombox_the_advertisement( 'boombox-page-after-content', 'large' ); ?>

		</div>

		<?php get_template_part( 'template-parts/secondary', $boombox_page_settings['listing_type'] ); ?>

	</div>

	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>