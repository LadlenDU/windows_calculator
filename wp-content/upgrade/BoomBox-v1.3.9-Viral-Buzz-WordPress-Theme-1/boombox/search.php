<?php
/**
 * The template for displaying search results pages
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

get_header();

$boombox_listing_type    = apply_filters( 'boombox_search_result_listing_type', 'list2' );
$boombox_pagination_type = apply_filters( 'boombox_search_result_pagination_type', 'pages' ); ?>

<div class="container">
	<header class="page-header">
		<?php printf( '<span>%1$s</span> <h1 class="page-title">%2$s</h1>',
			esc_html__( 'Search Results for: ', 'boombox' ),
			esc_html( get_search_query() )
		); ?>
	</header>
</div>

<div class="container">
	<div id="main" class="site-main" role="main">
		<?php if ( have_posts() ) : ?>

			<div id="post-items" <?php boombox_list_type_classes( $boombox_listing_type, 'col-2' ); ?>>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content-' . $boombox_listing_type, get_post_format() );?>

				<?php endwhile; ?>

			</div>

			<?php get_template_part( 'template-parts/pagination/pagination', $boombox_pagination_type ); ?>

			<?php wp_reset_postdata();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</div>

	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>