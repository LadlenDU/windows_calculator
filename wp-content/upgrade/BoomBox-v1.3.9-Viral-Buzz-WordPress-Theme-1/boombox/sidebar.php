<?php
/**
 * The template for the sidebar
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

?>
<aside id="secondary" class="sidebar widget-area" role="complementary">
	<?php
	$boombox_sidebar_id         = '';
	$boombox_default_sidebar_id = 'default-sidebar' ;

	if( is_page() ){
		global $post;
		$boombox_sidebar_id = get_post_meta( $post->ID, 'boombox_sidebar_template', true );
		$boombox_sidebar_id = empty( $boombox_sidebar_id ) ? '' : $boombox_sidebar_id;
	}elseif( is_single() ){
		$boombox_sidebar_id = 'post-sidebar' ;
	}elseif( is_archive() ){
		$boombox_sidebar_id = 'archive-sidebar' ;
	}

	if ( empty( $boombox_sidebar_id ) || !is_active_sidebar( $boombox_sidebar_id ) ) {
		$boombox_sidebar_id = $boombox_default_sidebar_id ;
	}

	if ( is_active_sidebar( $boombox_sidebar_id ) ) :
		dynamic_sidebar( $boombox_sidebar_id );
	endif; ?>

</aside>