<?php
/**
 * Boombox Activation
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
add_action('after_switch_theme', 'boombox_setup_options');
function boombox_setup_options() {
	if ( isset($_GET['activated']) && is_admin() ) {

		//boombox_create_trending_pages();

		boombox_create_custom_tables();

		boombox_create_nsfw_category();

		update_option( 'boombox-theme-activated', true );
	}
}

/**
 * Create Trending Pages
 */
function boombox_create_trending_pages(){
	$meta = array(
		'_wp_page_template'              => 'page-trending-result.php',
		'boombox_hide_page_title'        => false,
		'boombox_pagination_type'        => 'load_more',
		'boombox_posts_per_page'         => get_option( 'posts_per_page' ),
		'boombox_page_ad'                => 'none'
	);
	$trending_pages = array(
		'trending' => array(
			'title' => 'Trending',
			'meta'  => $meta
		),
		'hot'      => array(
			'title' => 'Hot',
			'meta'  => $meta
		),
		'popular'  => array(
			'title' => 'Popular',
			'meta'  => $meta
		),
	);

	foreach($trending_pages as $slug => $trending_page) {
		$trending = get_page_by_path( $slug );
		if( null === $trending ){
			$page_settings = array(
				'post_type'    => 'page',
				'post_title'   => wp_strip_all_tags( $trending_page['title'] ),
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_content' => ''
			);
			$trending_page_id = wp_insert_post( $page_settings );

			if( is_int( $trending_page_id ) && 0 < $trending_page_id ){
				foreach ( $trending_page['meta'] as $meta_name => $meta_value ){
					update_post_meta( $trending_page_id, $meta_name, $meta_value );
				}
			}
		}
	}
}

/**
 * Create Custom Tables
 */
function boombox_create_custom_tables(){
	global $wpdb;
	$sql = '';
	$charset_collate = $wpdb->get_charset_collate();
	$point_total_table_name    = $wpdb->prefix . 'point_total';
	$points_table_name         = $wpdb->prefix . 'points';
	$reaction_total_table_name = $wpdb->prefix . 'reaction_total';
	$reactions_table_name      = $wpdb->prefix . 'reactions';
	$view_total_table_name     = $wpdb->prefix . 'view_total';
	$views_table_name          = $wpdb->prefix . 'views';
	$rate_schedule_table_name  = $wpdb->prefix . 'rate_schedule';

	/*Table structure for table `point_total` */
	$sql = "CREATE TABLE IF NOT EXISTS `{$point_total_table_name}`  (
				`post_id` bigint(20) NOT NULL,
				`total` bigint(20) NOT NULL,
			    PRIMARY KEY (`post_id`)
			) {$charset_collate}; ";
	$wpdb->query( $sql );


	/*Table structure for table `points` */
	$sql = "CREATE TABLE IF NOT EXISTS `{$points_table_name}` (
					`post_id` bigint(20) NOT NULL,
					`user_id` bigint(20) DEFAULT NULL,
					`ip_address` varchar(255) NOT NULL,
					`point` tinyint(1) NOT NULL,
					`created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					`session_id` varchar(255) NOT NULL
				) {$charset_collate}; ";
	$wpdb->query( $sql );

	/*Table structure for table `reaction_total` */
	$sql = "CREATE TABLE IF NOT EXISTS `{$reaction_total_table_name}` (
					`post_id` bigint(20) NOT NULL,
					`reaction_id` bigint(20) NOT NULL,
					`total` bigint(20) DEFAULT NULL,
					PRIMARY KEY (`post_id`,`reaction_id`)
				) {$charset_collate}; ";
	$wpdb->query( $sql );

	/*Table structure for table `reactions` */
	$sql = "CREATE TABLE IF NOT EXISTS `{$reactions_table_name}` (
				`post_id` bigint(20) NOT NULL,
				`user_id` bigint(20) DEFAULT NULL,
				`ip_address` varchar(255) NOT NULL,
				`created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`reaction_id` bigint(20) NOT NULL,
				`session_id` varchar(255) NOT NULL
			) {$charset_collate}; ";
	$wpdb->query( $sql );

	/*Table structure for table `view_total` */
	$sql = "CREATE TABLE IF NOT EXISTS `{$view_total_table_name}` (
				`post_id` bigint(20) unsigned NOT NULL,
				`total` bigint(20) unsigned NOT NULL,
				PRIMARY KEY (`post_id`)
			) {$charset_collate}; ";
	$wpdb->query( $sql );

	/*Table structure for table `views` */
	$sql = "CREATE TABLE IF NOT EXISTS `{$views_table_name}` (
				`post_id` bigint(20) unsigned NOT NULL,
				`user_id` bigint(20) unsigned DEFAULT NULL,
				`ip_address` varchar(255) NOT NULL,
				`created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`session_id` varchar(255) NOT NULL,
				KEY `fk_posts_id` (`post_id`),
				KEY `fk_users_id` (`user_id`),
				KEY `k_ip` (`ip_address`)
			) {$charset_collate}; ";
	$wpdb->query( $sql );

	/* Table structure for table `rate_schedule` */
	$sql = "CREATE TABLE IF NOT EXISTS `{$rate_schedule_table_name}` (
				`hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			    `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			    `limit` int(11) DEFAULT NULL,
			    PRIMARY KEY (`hash`)
			) {$charset_collate}; ";
	$wpdb->query( $sql );

}

/**
 * Create "NSFW" category
 */
function boombox_create_nsfw_category() {
	if ( ! term_exists( 'nsfw', 'category' ) ) {
		$args = array(
			'category_parent'   => ''
		);
		wp_insert_term( 'nsfw', 'category', $args);
	}
}
