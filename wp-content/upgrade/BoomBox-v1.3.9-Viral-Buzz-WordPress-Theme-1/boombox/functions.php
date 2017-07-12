<?php
/**
 * Boombox Theme functions and definitions
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( ! defined( 'BOOMBOX_THEME_PATH' ) ) {
	define( 'BOOMBOX_THEME_PATH', trailingslashit( get_template_directory() ) );
}
if ( ! defined( 'BOOMBOX_THEME_URL' ) ) {
	define( 'BOOMBOX_THEME_URL', trailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'BOOMBOX_INCLUDES_PATH' ) ) {
	define( 'BOOMBOX_INCLUDES_PATH', BOOMBOX_THEME_PATH . 'includes/' );
}
if ( ! defined( 'BOOMBOX_INCLUDES_URL' ) ) {
	define( 'BOOMBOX_INCLUDES_URL', BOOMBOX_THEME_URL . 'includes/' );
}

if ( ! defined( 'BOOMBOX_ADMIN_PATH' ) ) {
	define( 'BOOMBOX_ADMIN_PATH', BOOMBOX_INCLUDES_PATH . 'admin/' );
}
if ( ! defined( 'BOOMBOX_ADMIN_URL' ) ) {
	define( 'BOOMBOX_ADMIN_URL', BOOMBOX_INCLUDES_URL . 'admin/' );
}

if ( ! defined( 'BOOMBOX_FRONT_PATH' ) ) {
	define( 'BOOMBOX_FRONT_PATH', BOOMBOX_INCLUDES_PATH . 'front/' );
}
if ( ! defined( 'BOOMBOX_FRONT_URL' ) ) {
	define( 'BOOMBOX_FRONT_URL', BOOMBOX_INCLUDES_URL . 'front/' );
}

if ( ! defined( 'BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH' ) ) {
	define( 'BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH', BOOMBOX_INCLUDES_PATH . 'rate-and-vote-restrictions/' );
}
if ( ! defined( 'BOOMBOX_RATE_VOTE_RESTRICTIONS_URL' ) ) {
	define( 'BOOMBOX_RATE_VOTE_RESTRICTIONS_URL', BOOMBOX_INCLUDES_URL . 'rate-and-vote-restrictions/' );
}

/**
 * Load common resources (required by both, admin and front, contexts).
 */
require_once( BOOMBOX_INCLUDES_PATH . 'functions.php' );

/**
 * Contributor Functions
 */
require_once( BOOMBOX_INCLUDES_PATH . 'contributor-functions.php' );

/**
 * Load context resources.
 */
if ( is_admin() ) {
	require_once( BOOMBOX_INCLUDES_PATH . 'admin/admin-functions.php' );
} else {
	require_once( BOOMBOX_INCLUDES_PATH . 'front/front-functions.php' );
}