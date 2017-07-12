<?php
/**
 * The template for displaying 404 page
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

get_header();

$boombox_404_image = boombox_get_theme_option( 'branding_404_image' );?>

	<div id="main" class="site-main" role="main">
		<section class="error-404 not-found">
			<div class="row">
				<div class="col-lg-5 col-md-5">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops', 'boombox' ); ?></h1>
					</header>
					<!-- page-header -->

					<div class="page-content">
						<p class="text"><?php esc_html_e( 'We couldn\'t find the page you are looking for.', 'boombox' ); ?></p>

						<p class="text"><?php esc_html_e( 'It may have expired, or there could be a typo. Maybe you can find what you need from our homepage.', 'boombox' ); ?></p>
						<a class="back" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<span
								class="fa fa-long-arrow-left "></span><?php esc_html_e( 'Return To Home', 'boombox' ); ?>
						</a>

					</div>
					<!-- page-content -->
				</div>
				<div class="col-lg-7 col-md-7">
					<?php if ( $boombox_404_image ): ?>
						<img src="<?php echo esc_url( $boombox_404_image ); ?>" alt="">
					<?php endif; ?>
				</div>
			</div>
		</section>
	</div>

<?php get_footer(); ?>

<div class="head-bg">
    <div class="head-image-left"></div>
    <div class="headimage-right"></div>
</div>