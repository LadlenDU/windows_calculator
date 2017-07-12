<?php
/**
 * The template part for displaying the ViralPress create types popup.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>
<div id="post-types" class="post-types inline-popup">
	<header>
		<h3><?php esc_html_e( 'Choose post type', 'boombox' ); ?></h3>
	</header>

	<?php $boombox_viral_types = boombox_get_viralpress_post_types(); ?>
	<div class="content">
		<?php foreach ( $boombox_viral_types as $type ):
			$boombox_type_icon = $type['icon'];
			$boombox_type_title = $type['title'];
			$boombox_type_class = '';
			if( is_user_logged_in() ):
				$boombox_type_url = site_url( $type['url'] );
			else:
				$boombox_type_class = 'js-authentication';
				$boombox_type_url   = '#sign-in';
			endif; ?>
			<a class="item <?php echo esc_attr( $boombox_type_class ); ?>" href="<?php echo esc_url( $boombox_type_url ); ?>">
				<i class="icon icon-<?php echo esc_attr( $boombox_type_icon ); ?>"></i>
				<span class="text"><?php echo esc_html( $boombox_type_title ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</div>