<?php
/**
 * The template part for displaying the site trending navigation
 *
 * @package BoomBox_Them
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_queried_object     = get_queried_object();
$boombox_trending_nav_items = boombox_get_trending_navigation_items();
if ( ! empty( $boombox_trending_nav_items ) ):  ?>
	<nav class="trending-navigation">
		<ul>
			<?php foreach ( $boombox_trending_nav_items as $trending_nav_item ):
					$active = '';
					if( $boombox_queried_object && ( 'page' == $boombox_queried_object->post_type && $trending_nav_item[ 'id' ] == $boombox_queried_object->ID ) ):
						$active = 'active';
					endif; ?>
					<li class="<?php echo esc_attr( $active ); ?>">
						<a href="<?php echo esc_url( $trending_nav_item[ 'href' ] ); ?>">
							<i class="icon icon-<?php echo esc_html( $trending_nav_item[ 'icon' ] ); ?>"></i>
							<?php echo esc_html( $trending_nav_item[ 'name' ] ); ?>
						</a>
					</li>
			<?php endforeach; ?>
		</ul>
	</nav>
<?php endif; ?>