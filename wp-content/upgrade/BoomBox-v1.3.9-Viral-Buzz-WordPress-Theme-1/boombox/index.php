<?php
/**
 * The main template file
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

get_header();

$boombox_index_settings = boombox_get_index_page_settings(); ?>

<div class="container">
	<?php boombox_the_advertisement( 'boombox-archive-before-content', 'large' ); ?>
</div>
	<div class="container <?php boombox_container_classes_by_type( $boombox_index_settings['listing_type'] ); ?>" >

		<div id="main" class="site-main" role="main">
			<div class="main-container">
				<?php if ( have_posts() ) : ?>
					<?php if ( is_home() && ! is_front_page() ) : ?>
						<header class="page-header">
							<h1 class="page-title"><?php single_post_title(); ?></h1>
						</header>
					<?php endif; ?>

					<div id="post-items" <?php boombox_list_type_classes( $boombox_index_settings['listing_type'], 'col-2' ); ?>>

						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'template-parts/content-' . $boombox_index_settings['listing_type'], get_post_format() );?>

						<?php endwhile; ?>

					</div>

					<?php get_template_part( 'template-parts/pagination/pagination', $boombox_index_settings['pagination_type'] ); ?>

					<?php wp_reset_postdata();

				endif; ?>
			</div>

			<?php boombox_the_advertisement( 'boombox-archive-after-content', 'large' ); ?>

		</div>

		<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>