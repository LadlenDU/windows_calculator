<?php
/**
 * The template part for displaying the share buttons section
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
$boombox_post_share_box_elements = boombox_get_theme_option( 'layout_post_share_box_elements' );
$boombox_post_share_buttons = boombox_is_plugin_active( 'mashsharer/mashshare.php' );
$show_share = $show_points = $show_comments = false;
?>

<div class="content <?php echo $boombox_post_share_buttons ? 'has-share-buttons' : ''; ?>">
<?php

if( !empty( $boombox_post_share_box_elements ) ):

	$show_share = in_array( 'share_count', $boombox_post_share_box_elements );
	if ( $show_share ) :
		boombox_post_share_count();
	endif;

	$show_points = in_array( 'points', $boombox_post_share_box_elements );
	if ( $show_points ) :
		boombox_post_points();
	endif;

	$show_comments = ( comments_open() && in_array( 'comments', $boombox_post_share_box_elements ) );
	if ( $show_comments ) :
		boombox_post_comments();
	endif;

endif;

if( $boombox_post_share_buttons ) :
	boombox_post_share_buttons();
	boombox_post_share_mobile_buttons( $show_comments, $show_share, $show_points );
endif;
?>
</div>

