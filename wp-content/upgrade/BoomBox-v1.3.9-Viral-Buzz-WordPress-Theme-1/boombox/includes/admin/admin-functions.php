<?php
/**
 * Boombox admin functions
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}


/**
 * Theme Activation
 */
require_once( BOOMBOX_ADMIN_PATH . 'activation/class-tgm-plugin-activation.php' );
require_once( BOOMBOX_ADMIN_PATH . 'activation/plugins-activation.php' );
require_once( BOOMBOX_ADMIN_PATH . 'activation/theme-activation.php' );

/**
 * Meta Boxes
 */
require_once( BOOMBOX_ADMIN_PATH . 'metaboxes/lib/class-boombox-page-metaboxes.php' );
require_once( BOOMBOX_ADMIN_PATH . 'metaboxes/lib/class-boombox-post-metaboxes.php' );
require_once( BOOMBOX_ADMIN_PATH . 'metaboxes/lib/class-boombox-category-metaboxes.php' );
require_once( BOOMBOX_ADMIN_PATH . 'metaboxes/lib/class-boombox-tag-metaboxes.php' );
require_once( BOOMBOX_ADMIN_PATH . 'metaboxes/lib/class-boombox-attachment-metaboxes.php' );

require_once( BOOMBOX_ADMIN_PATH . 'metaboxes/lib/class-boombox-menu-item-custom-fields.php' );
require_once( BOOMBOX_ADMIN_PATH . 'metaboxes/lib/class-boombox-walker-header-nav-menu.php' );
