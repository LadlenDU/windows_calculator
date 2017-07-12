<?php
/**
 * Boombox contributor role permissions and settings
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

add_action( 'init', 'boombox_contributor_role_permissions', 100 );

function  boombox_contributor_role_permissions(){

	$current_user = wp_get_current_user();

	if( current_user_can( 'contributor' ) && in_array( 'contributor', $current_user->roles ) ) {

		if( is_admin() ){

			/**
			 * Removes from post and pages
			 */
			remove_post_type_support( 'post', 'comments' );
			remove_post_type_support( 'post', 'author' );

			/**
			 * Hooks
			 */
			add_action( 'admin_menu', 'boombox_remove_admin_menus' );
			add_action( 'wp_before_admin_bar_render', 'boombox_admin_bar_render' );
			add_action( 'admin_init', 'boombox_admin_menu_redirect');
			add_filter( 'logout_url', 'boombox_logout_url' );

			/**
			 * Removes from admin menu
			 */
			function boombox_remove_admin_menus() {
				remove_menu_page( 'edit-comments.php' );
				remove_menu_page( 'tools.php' );
				remove_menu_page( 'index.php' );
				remove_menu_page( 'about.php' );
			}

			/**
			 * Removes from admin bar
			 */
			function boombox_admin_bar_render() {
				global $wp_admin_bar;
				$wp_admin_bar->remove_menu('comments');
			}

			/**
			 * Redirect any user trying to access dashboard, comments or tools pages
			 */
			function boombox_admin_menu_redirect() {
				global $pagenow;
				$deprecated_pages = array(
					'index.php',
					'edit-comments.php',
					'tools.php',
					'about.php'
				);
				if ( in_array( $pagenow, $deprecated_pages ) ) {
					wp_redirect(admin_url( 'profile.php' )); exit;
				}
			}

			/**
			 * Change logout url
			 *
			 * @param $logout_url
			 *
			 * @return string
			 */
			function boombox_logout_url( $logout_url ) {
				return $logout_url . '&redirect_to=' . esc_url( home_url() );
			}
		}
	}
}

