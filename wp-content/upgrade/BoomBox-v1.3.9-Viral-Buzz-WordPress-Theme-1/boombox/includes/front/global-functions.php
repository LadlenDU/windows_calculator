<?php
/**
 * Boombox global functions
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Header Settings
 *
 * @return array
 */
function boombox_get_header_settings() {
	static $header_settings;

	if ( ! $header_settings ) {

		$small_logo                     = boombox_get_theme_option( 'branding_logo_small' );
		$logo_position                  = boombox_get_theme_option( 'design_logo_position' );
		$pattern_position               = boombox_get_theme_option( 'design_pattern_position' );
		$shadow_position                = boombox_get_theme_option( 'design_shadow_position' );
		$badges_position                = boombox_get_theme_option( 'design_badges_position' );
		$auth_position                  = boombox_get_theme_option( 'design_auth_position' );
		$search_position                = boombox_get_theme_option( 'design_search_position' );
		$top_menu_alignment             = boombox_get_theme_option( 'design_top_menu_alignment' );
		$bottom_menu_alignment          = boombox_get_theme_option( 'design_bottom_menu_alignment' );
		$social_position                = boombox_get_theme_option( 'design_social_position' );
		$burger_nav_position            = boombox_get_theme_option( 'design_burger_navigation_position' );
		$header_community_text          = boombox_get_theme_option( 'design_header_community_text' );
		$sticky_header                  = boombox_get_theme_option( 'design_sticky_header' );
		$disable_top_header             = boombox_get_theme_option( 'design_disable_top_header' );
		$disable_bottom_header          = boombox_get_theme_option( 'design_disable_bottom_header' );
		$top_header_height              = boombox_get_theme_option( 'design_top_header_height' );
		$bottom_header_height           = boombox_get_theme_option( 'design_bottom_header_height' );
		$top_header_width               = boombox_get_theme_option( 'design_top_header_width' );
		$bottom_header_width            = boombox_get_theme_option( 'design_bottom_header_width' );
		$header_button_text             = boombox_get_theme_option( 'design_header_button_text' );
		$header_button_link				= boombox_get_theme_option( 'design_header_button_link' );
		$header_button_enable_plus_icon = boombox_get_theme_option( 'design_header_button_enable_plus_icon' );

		$header_settings = array(
			'small_logo'                 => esc_url( $small_logo ),
			'logo_position'              => esc_html( $logo_position ),
			'pattern_position'           => esc_html( $pattern_position ),
			'shadow_position'            => esc_html( $shadow_position ),
			'badges_position'            => esc_html( $badges_position ),
			'auth_position'              => esc_html( $auth_position ),
			'search_position'            => esc_html( $search_position ),
			'top_menu_alignment'         => esc_html( $top_menu_alignment ),// -
			'bottom_menu_alignment'      => esc_html( $bottom_menu_alignment ),  // -
			'social_position'            => esc_html( $social_position ),
			'burger_nav_position'        => esc_html( $burger_nav_position ),
			'header_community_text'      => esc_html( $header_community_text ),
			'sticky_header'              => esc_html( $sticky_header ),
			'disable_top_header'         => ( bool ) $disable_top_header,
			'disable_bottom_header'      => ( bool ) $disable_bottom_header,
			'top_header_height'          => esc_html( $top_header_height ),
			'bottom_header_height'       => esc_html( $bottom_header_height ),
			'top_header_width'           => esc_html( $top_header_width ),
			'bottom_header_width'        => esc_html( $bottom_header_width ),
			'header_button_text'         => esc_html( $header_button_text ),
			'header_button_link'		 => esc_html( $header_button_link ),
			'enable_plus_icon_on_button' => esc_html( $header_button_enable_plus_icon )
		);
	}

	return $header_settings;
}

/**
 * Footer Settings
 *
 * @return array
 */
function boombox_get_footer_settings() {
	static $footer_settings;

	if ( ! $footer_settings ) {
		$hide_footer_top    = boombox_get_theme_option( 'design_footer_hide_footer_top' );
		$hide_footer_bottom = boombox_get_theme_option( 'design_footer_hide_footer_bottom' );
		$hide_pattern       = boombox_get_theme_option( 'design_footer_hide_pattern' );
		$pattern_position   = boombox_get_theme_option( 'design_footer_pattern_position' );
		$disable_strip      = boombox_get_theme_option( 'design_footer_disable_strip' );
		$hide_social_icons  = boombox_get_theme_option( 'design_footer_hide_social_icons' );
		$footer_text        = boombox_get_theme_option( 'footer_text' );

		$classes = '';
		if ( ! $hide_pattern ) :
			$classes = sprintf( '%s-bg', $pattern_position );
		endif;

		$footer_settings = array(
			'classes'            => esc_attr( $classes ),
			'hide_footer_top'    => ( bool ) $hide_footer_top,
			'hide_footer_bottom' => ( bool ) $hide_footer_bottom,
			'hide_pattern'       => ( bool ) $hide_pattern,
			'pattern_position'	 => esc_attr( $pattern_position ),
			'disable_strip'      => ( bool ) $disable_strip,
			'hide_social_icons'  => ( bool ) $hide_social_icons,
			'footer_text'        => wp_kses_post( $footer_text ),
		);
	}

	return $footer_settings;
}

/**
 * Archive Template Settings
 *
 * @return array
 */
function boombox_get_archive_settings(){
	$disable_strip         		= boombox_get_theme_option( 'layout_archive_disable_strip' );
	$template					= esc_html( boombox_get_theme_option( 'layout_archive_template' ) );
	$disable_featured_area 		= boombox_get_theme_option( 'layout_archive_disable_featured_area' );
	$archive_listing_type  		= boombox_get_theme_option( 'layout_archive_listing_type' );
	$secondary_content_position	= boombox_get_theme_option( 'layout_archive_secondary_content_position' );
	$pagination_type       		= boombox_get_theme_option( 'layout_archive_pagination_type' );
	$term_thumbnail_url    		= boombox_get_term_thumbnail_url();
	$term_thumbnail_style  		= $term_thumbnail_url ? 'style="background-image: url(\'' . esc_url( $term_thumbnail_url ) . '\')"' : '';

	return array(
		'disable_strip'         		=> (bool) $disable_strip,
		'template'						=> $template,
		'disable_featured_area' 		=> (bool) $disable_featured_area,
		'listing_type'          		=> $archive_listing_type,
		'secondary_content_position'	=> $secondary_content_position,
		'pagination_type'       		=> $pagination_type,
		'thumbnail_style'       		=> $term_thumbnail_style
	);
}

/**
 * Author Template Settings
 *
 * @return array
 */
function boombox_get_author_settings(){
	$listing_typ     = boombox_get_theme_option( 'layout_archive_listing_type' );
	$pagination_type = boombox_get_theme_option( 'layout_archive_pagination_type' );

	return array(
		'listing_type'    => $listing_typ,
		'pagination_type' => $pagination_type
	);
}

/**
 * index.php page Settings
 *
 * @return array
 */
function boombox_get_index_page_settings() {
	$listing_type    = boombox_get_theme_option( 'layout_archive_listing_type' );
	$pagination_type = boombox_get_theme_option( 'layout_archive_pagination_type' );

	$listing_type    = apply_filters( 'boombox_index_listing_type', $listing_type );
	$pagination_type = apply_filters( 'boombox_index_pagination_type', $pagination_type );

	return array(
		'listing_type'    => $listing_type,
		'pagination_type' => $pagination_type
	);
}

/**
 * Get page settings
 *
 * @param $paged
 *
 * @return array
 */
function boombox_get_page_settings( $paged ){
	global $post;
	$query = null;

	$hide_page_title    			= get_post_meta( $post->ID, 'boombox_hide_page_title', true );
	$show_strip         			= get_post_meta( $post->ID, 'boombox_show_strip', true );
	$show_featured_area 			= get_post_meta( $post->ID, 'boombox_show_featured_area', true );
	$listing_type       			= get_post_meta( $post->ID, 'boombox_listing_type', true );
	$three_column_sidebar_position  = get_post_meta( $post->ID, 'boombox_three_column_sidebar_position', true );
	$condition          			= get_post_meta( $post->ID, 'boombox_listing_condition', true );
	$time_range         			= get_post_meta( $post->ID, 'boombox_listing_time_range', true );
	$categories         			= get_post_meta( $post->ID, 'boombox_listing_categories', true );
	$tags               			= get_post_meta( $post->ID, 'boombox_listing_tags', true );
	$pagination_type    			= get_post_meta( $post->ID, 'boombox_pagination_type', true );
	$posts_per_page     			= get_post_meta( $post->ID, 'boombox_posts_per_page', true );
	$is_grid            			= 'grid' == $listing_type ? true : false;

	if ( 'none' == $pagination_type ) {
		$posts_per_page = - 1;
	}

	if ( 'none' != $listing_type ) {
		$query = boombox_get_posts_query( $condition, $time_range, $categories, $tags, $posts_per_page, 'post', $paged, - 1, $is_grid );
		if ( is_object( $query ) ) {
			$query->is_page = true;
			$query->is_singular = true;
		}

	}

	return array(
		'hide_page_title'      			=> (bool) $hide_page_title,
		'enable_strip'         			=> (bool) $show_strip,
		'enable_featured_area' 			=> (bool) $show_featured_area,
		'listing_type'         			=> $listing_type,
		'three_column_sidebar_position' => $three_column_sidebar_position,
		'pagination_type'      			=> $pagination_type,
		'posts_per_page'       			=> $posts_per_page,
		'query'                			=> $query
	);
}

/**
 * Get single page settings
 *
 * @param string $featured_image_size
 *
 * @return array
 */
function boombox_get_single_page_settings( $featured_image_size = 'boombox_image768' ){
	$template_options        = boombox_get_template_single_elements_options();
	$post_template           = boombox_get_single_post_template();
	$disable_strip           = boombox_get_theme_option( 'layout_post_disable_strip' );
	$featured_video          = boombox_get_post_featured_video( get_the_ID(), $featured_image_size );
	$boombox_is_nsfw_post    = has_category( 'nsfw', get_the_ID() );
	$boombox_article_classes = 'single post';
	$single_post_media 		 = get_post_meta( get_the_ID(), 'boombox_hide_featured_image', true );
	switch( $single_post_media ) {
		case 'show':
			$template_options['media'] = 1;
			break;
		case 'hide':
			$template_options['media'] = 0;
	}

	return array(
		'template_options'  		=> $template_options,
		'post_template'     		=> $post_template,
		'is_nsfw'           		=> $boombox_is_nsfw_post,
		'classes'           		=> $boombox_article_classes,
		'disable_strip'     		=> (bool) $disable_strip,
		'featured_video'    		=> $featured_video,
	);
}