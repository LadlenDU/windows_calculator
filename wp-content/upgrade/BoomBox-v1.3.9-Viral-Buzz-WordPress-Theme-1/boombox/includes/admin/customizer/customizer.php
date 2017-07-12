<?php
/**
 * Register theme sections into the WP Customizer
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Hooks
 */
add_action( 'customize_register', 'boombox_customize_register', 10 );
add_action( 'customize_controls_enqueue_scripts', 'boombox_customize_control_js' );

add_filter( 'boombox_listing_types_choices', 'boombox_listing_types_choices' );
add_filter( 'boombox_pagination_choices', 'boombox_pagination_choices' );
add_filter( 'boombox_conditions_choices', 'boombox_add_most_shared_to_conditions' );
add_filter( 'boombox_trending_conditions_choices', 'boombox_add_most_shared_to_conditions' );

/**
 * Register theme options
 *
 * @param WP_Customize_Manager $wp_customize WP Customizer instance.
 */
function boombox_customize_register( $wp_customize ) {
	$theme_name = boombox_get_theme_name();
	$customizer_defaults = boombox_get_theme_defaults();
	$boombox_customizer_defaults = $customizer_defaults[$theme_name];

	/** get custom libraries */
	require_once( BOOMBOX_ADMIN_PATH . 'customizer/lib/class-boombox-control-multiple-select.php' );
	require_once( BOOMBOX_ADMIN_PATH . 'customizer/lib/class-boombox-control-multiple-checkbox.php' );
	require_once( BOOMBOX_ADMIN_PATH . 'customizer/lib/class-boombox-custom-content.php' );
	require_once( BOOMBOX_ADMIN_PATH . 'customizer/lib/class-boombox-control-select-optgroup.php' );

	/** get panels */
	$panels = require_once( BOOMBOX_ADMIN_PATH . 'customizer/panels.php' );
	$sections = array(
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/site-identity.php' ),
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/design-global.php' ),
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/design-header.php' ),
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/design-footer.php' ),
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/design-badges.php' ),
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/site-auth.php' ),
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/layout-archive.php' ),
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/layout-post.php' ),
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/layout-page.php' ),
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/settings-rating.php' ),
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/settings-reactions.php' ),
		require_once ( BOOMBOX_ADMIN_PATH . 'customizer/settings-gif.php' )
	);

	/** Create panels */
	foreach( $panels as $panel ) {
		$wp_customize->add_panel( $panel[ 'id' ], $panel[ 'args' ] );
	}

	/** Create section and settings */
	foreach( $sections as $section ) {

		/** Create section */
		if( isset( $section[ 'section' ] ) ) {
			$wp_customize->add_section( $section[ 'section' ][ 'id' ], $section[ 'section' ][ 'args' ] );
		}

		/** Create settings  */
		if( isset( $section[ 'fields' ] ) ) {
			foreach( $section[ 'fields' ] as $field ) {
				/** Create setting */
				$setting = $field[ 'setting' ];
				$wp_customize->add_setting( $setting[ 'id' ], $setting[ 'args' ] );

				/** Create control */
				$control = $field[ 'control' ];
				$control['type'] = isset( $control['type'] ) ? $control['type'] : 'built-in';

				switch( $control['type'] ) {
					case 'color':
						$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $control[ 'id' ], $control[ 'args' ] ) );
						break;
					case 'multiple_select':
						$wp_customize->add_control( new Boombox_Customize_Control_Multiple_Select( $wp_customize, $control[ 'id' ], $control[ 'args' ] ) );
						break;
					case 'custom_content':
						$wp_customize->add_control( new Boombox_Custom_Content( $wp_customize, $control[ 'id' ], $control[ 'args' ] ) );
						break;
					case 'multiple_checkbox':
						$wp_customize->add_control( new Boombox_Customize_Control_Multiple_Checkbox( $wp_customize, $control[ 'id' ], $control[ 'args' ] ) );
						break;
					case 'image':
						$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $control[ 'id' ], $control[ 'args' ] ) );
						break;
					case 'select-optgroup':
						$wp_customize->add_control( new Boombox_Customize_Control_Select_Optgroup( $wp_customize, $control[ 'id' ], $control[ 'args' ] ) );
						break;
					default:
						$wp_customize->add_control( $control[ 'id' ], $control[ 'args' ] );
				}
			}
		}
	}

}

/**
 * Binds the JS listener to make Customizer color_scheme control.
 */
function boombox_customize_control_js() {
	wp_enqueue_script( 'boombox-customize-controls', BOOMBOX_ADMIN_URL . 'customizer/js/customize-controls.js', array( 'jquery' ), '20160418', true  );
}

/**
 * @param $values
 * @return array
 */
function boombox_sanitize_multiple_checkbox_field( $values ) {

	$multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;

	return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}

/**
 * @param $values
 * @return array
 */
function boombox_sanitize_multiple_select_field( $values ) {

	$multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;

	return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}

/**
 * Theme Name
 *
 * @return string
 */
function boombox_get_theme_name(){
	return 'boombox_theme';
}

/**
 * Get default theme option values
 *
 * @return array
 */
function boombox_get_theme_defaults() {
	static $boombox_defaults;

	// Load only once.
	if ( ! $boombox_defaults ) {

		$theme_options_name = boombox_get_theme_name();

		$boombox_customizer_defaults = boombox_get_theme_customizer_default_values();

		$boombox_defaults = array(
			$theme_options_name => $boombox_customizer_defaults
		);
	}

	return $boombox_defaults;
}

function boombox_get_theme_customizer_default_values() {
	return array(
		// Site Identity.
		'branding_show_tagline'                               => true,
		'branding_logo'                                       => '',
		'branding_logo_width'                                 => '',
		'branding_logo_height'                                => '',
		'branding_logo_hdpi'                                  => '',
		'branding_logo_small'                                 => '',
		'footer_text'                                         => esc_html__( 'All Rights Reserved', 'boombox' ),
		'branding_404_image'                                  => BOOMBOX_THEME_URL . 'images/404.png',
		// Design Header
		'design_logo_position'                                => 'top',
		'design_pattern_position'                             => 'top',
		'design_pattern_type'								  => 'rags-header.svg',
		'design_shadow_position'                              => 'none',
		'design_badges_position'                              => 'outside',
		'design_auth_position'                                => 'top',
		'design_search_position'                              => 'top',
		'design_top_menu_alignment'                           => 'left',
		'design_bottom_menu_alignment'                        => 'left',
		'design_social_position'                              => 'top',
		'design_burger_navigation_position'                   => 'top',
		'design_header_community_text'                        => get_bloginfo( 'name' ) . ' ' . esc_html__( 'community', 'boombox' ),
		'design_sticky_header'                                => 'none',
		'design_disable_top_header'                           => false,
		'design_disable_bottom_header'                        => true,
		'design_top_header_height'                            => 'large',
		'design_bottom_header_height'                         => 'large',
		'design_top_header_width'                             => 'boxed',
		'design_bottom_header_width'                          => 'boxed',
		'design_header_button_text'                           => esc_html__( 'Create a post', 'boombox' ),
		'design_header_button_link'							  => '',
		'design_header_button_enable_plus_icon'               => false,
		'design_header_site_title_color'                      => '#1f1f1f',
		'design_header_top_background_color'                  => '#ffe400',
		'design_header_top_text_color'                        => '#505050',
		'design_header_top_text_hover_color'                  => '#505050',
		'design_header_bottom_background_color'               => '#ffffff',
		'design_header_bottom_text_color'                     => '#ffe400',
		'design_header_bottom_text_hover_color'               => '#505050',
		'design_header_button_background_color'               => '#1f1f1f',
		'design_header_button_text_color'                     => '#ffffff',
		// Design Footer
		'design_footer_hide_footer_top'                       => false,
		'design_footer_hide_footer_bottom'                    => false,
		'design_footer_top_background_color'                  => '#1f1f1f',
		'design_footer_top_heading_color'                     => '#ffffff',
		'design_footer_top_text_color'                        => '#ffffff',
		'design_footer_top_link_color'                        => '#ffffff',
		'design_footer_bottom_background_color'               => '#282828',
		'design_footer_top_primary_color'                     => '#ffe400',
		'design_footer_top_primary_text_color'                => '#000000',
		'design_footer_bottom_text_color'                     => '#ffffff',
		'design_footer_bottom_text_hover_color'               => '#ffe400',
		'design_footer_hide_pattern'                          => false,
		'design_footer_pattern_position'				      => 'top',
		'design_footer_pattern_type'						  => 'rags-footer.svg',
		'design_footer_disable_strip'                         => false,
		'design_footer_strip_conditions'                      => 'recent',
		'design_footer_strip_time_range'                      => 'all',
		'design_footer_strip_category'                        => '',
		'design_footer_strip_tags'                            => '',
		'design_footer_strip_items_count'                     => 18,
		'design_footer_hide_social_icons'                     => false,
		// Design Global
		'design_global_google_api_key'                        => '',
		'design_global_logo_font_family'                   	  => 'Arial, Helvetica',
		'design_global_primary_font_family'                   => 'Arial, Helvetica',
		'design_global_secondary_font_family'                 => 'Arial, Helvetica',
		'design_global_post_titles_font_family'               => 'Arial, Helvetica',
		'design_global_google_font_subset'                    => 'latin,latin-ext',
		'design_global_general_text_font_size'			      => '16',
		'design_global_single_post_heading_font_size'		  => '45',
		'design_global_widget_heading_font_size'			  => '17',
		'design_global_page_wrapper_width_type'               => 'full_width',
		'design_global_body_background_color'                 => '#ffffff',
		'design_global_body_background_image'                 => '',
		'design_badges_body_background_image_type'			  => 'cover',
		'design_global_body_background_link'                  => '',
		'design_global_content_background_color'              => '#ffffff',
		'design_global_primary_color'                         => '#ffe400',
		'design_global_primary_text_color'                    => '#000000',
		'design_global_base_text_color'                       => '#1f1f1f',
		'design_global_secondary_text_color'                  => '#a3a3a3',
		'design_global_heading_text_color'                    => '#1f1f1f',
		'design_global_link_text_color'                    	  => '#f43547',
		'design_global_secondary_components_background_color' => '#f7f7f7',
		'design_global_secondary_components_text_color'		  => '#1f1f1f',
		'design_global_border_color'                          => '#ececec',
		'design_global_border_radius'                         => 6,
		'design_global_inputs_buttons_border_radius'          => 24,
		'design_global_social_icons_border_radius'            => 24,
		'design_global_custom_css'							  => '',
		// Design Badges
		'design_badges_hide_reactions'                        => false,
		'design_badges_position_on_thumbnails'				  => 'outside-left',
		'design_badges_reactions_background_color'            => '#ffe400',
		'design_badges_reactions_text_color'                  => '#1f1f1f',
		'design_badges_reactions_type'                        => 'face-text',
		'design_badges_hide_trending'                         => false,
		'design_badges_trending_icon'						  => 'trending',
		'design_badges_trending_background_color'             => '#f43547',
		'design_badges_trending_icon_color'                   => '#ffffff',
		'design_badges_trending_text_color'                   => '#1f1f1f',
		'design_badges_hide_category'                         => false,
		'design_badges_show_for_categories'                   => array( 'quiz', 'poll' ),
		'design_badges_show_for_post_tags'					  => array( 'quiz', 'poll' ),
		'design_badges_category_background_color'             => '#6759eb',
		'design_badges_category_icon_color'                   => '#ffffff',
		'design_badges_category_text_color'                   => '#1f1f1f',
		'design_badges_hide_post_type_badges'				  => false,
		'design_badges_categories_for_post_type_badges'		  => array(  ),
		'design_badges_post_tags_for_post_type_badges'		  => array(  ),
		// Auth
		'disable_site_auth'                                   => false,
		'auth_login_popup_heading'                            => esc_html__( 'log in', 'boombox' ),
		'auth_login_popup_text'                               => '',
		'auth_registration_popup_heading'                     => esc_html__( 'sign up', 'boombox' ),
		'auth_registration_popup_text'                        => '',
		'auth_reset_password_popup_heading'                   => esc_html__( 'reset password', 'boombox' ),
		'auth_reset_password_popup_text'                      => '',
		'auth_terms_of_use_page'                              => 0,
		'auth_privacy_policy_page'                            => 0,
		'auth_enable_login_captcha'					  		  => true,
		'auth_enable_registration_captcha'					  => true,
		'auth_captcha_type'									  => 'image',
		'auth_google_recaptcha_site_key'					  => '',
		'auth_google_recaptcha_secret_key'					  => '',
		'disable_social_auth'                                 => true,
		'facebook_app_id'                                     => '',
		'google_oauth_id'                                     => '',
		'google_api_key'                                      => '',
		'twitter_consumer_key'                                => '',
		'twitter_consumer_secret'                             => '',
		'twitter_access_token'                                => '',
		'twitter_access_token_secret'                         => '',
		//Layouts Archive
		'layout_archive_disable_strip'                        => true,
		'layout_archive_strip_size'                           => 'big',
		'layout_archive_strip_title_position'				  => 'inside',
		'layout_archive_template'							  => 'right-sidebar',
		'layout_archive_strip_conditions'                     => 'recent',
		'layout_archive_strip_time_range'                     => 'all',
		'layout_archive_strip_category'                       => '',
		'layout_archive_strip_tags'                           => '',
		'layout_archive_strip_items_count'                    => 18,
		'layout_archive_disable_featured_area'                 => false,
		'layout_archive_featured_type'						  => '2',
		'layout_archive_featured_conditions'                  => 'recent',
		'layout_archive_featured_time_range'                  => 'all',
		'layout_archive_listing_type'                         => 'grid',
		'layout_archive_secondary_content_position'		      => 'right',
		'layout_archive_pagination_type'                      => 'load_more',
		'layout_archive_posts_per_page'                       => get_option( 'posts_per_page' ),
		'layout_archive_hide_elements'                        => array(),
		'layout_archive_ad'                                   => 'none',
		'layout_archive_inject_ad_instead_post'               => 1,
		'layout_archive_newsletter'                           => 'none',
		'layout_archive_inject_newsletter_instead_post'       => 1,
		//Layout Post
		'layout_post_template'                                => 'right-sidebar',
		'layout_post_navigation_direction'					  => 'to-oldest',
		'layout_post_disable_strip'                           => true,
		'layout_post_strip_size'                              => 'big',
		'layout_post_strip_title_position'                    => 'inside',
		'layout_post_strip_conditions'                        => 'recent',
		'layout_post_strip_time_range'                        => 'all',
		'layout_post_strip_category'                          => '',
		'layout_post_strip_tags'                              => '',
		'layout_post_strip_items_count'                       => 18,
		'layout_post_hide_elements'                           => array(),
		'layout_post_share_box_elements'                      => array( 'share_count', 'points' ),
		'layout_post_disable_full_post_button'				  => false,
		'layout_post_full_post_button_label'				  => esc_html__( 'View Full Post', 'boombox' ),
		'layout_post_disable_related_block'                   => false,
		'layout_post_related_entries_per_page'                => 6,
		'layout_post_related_entries_heading'                 => esc_html__( 'You may also like', 'boombox' ),
		'layout_post_disable_more_block'                      => false,
		'layout_post_more_entries_per_page'                   => 6,
		'layout_post_more_entries_heading'                    => esc_html__( 'More From:', 'boombox' ),
		'layout_post_disable_dont_miss_block'                 => false,
		'layout_post_dont_miss_entries_per_page'              => 6,
		'layout_post_dont_miss_entries_heading'               => esc_html__( 'DON\'T MISS', 'boombox' ),
		'layout_post_grid_sections_hide_elements'             => array(),
		// Layout Page
		'layout_page_strip_conditions'                        => 'recent',
		'layout_page_strip_size'                              => 'big',
		'layout_page_strip_title_position'					  => 'inside',
		'layout_page_strip_time_range'                        => 'all',
		'layout_page_strip_category'                          => '',
		'layout_page_strip_tags'                              => '',
		'layout_page_strip_items_count'                       => 18,
		'layout_page_featured_type'                           => '2',
		'layout_page_featured_conditions'                     => 'recent',
		'layout_page_featured_time_range'                     => 'all',
		'layout_page_featured_category'                       => '',
		'layout_page_featured_tags'                           => '',
		'layout_page_hide_elements'                           => array(),
		//Settings Post Rating
		'settings_rating_points_login_require'                => false,
		'settings_trending_conditions'                        => 'most_viewed',
		'settings_trending_disable'                           => false,
		'settings_trending_page'                              => 'trending',
		'settings_trending_posts_count'                       => 25,
		'settings_trending_minimal_score'                     => 5,
		'settings_trending_hide_badge'                        => false,
		'settings_hot_disable'                                => false,
		'settings_hot_page'                                   => 'hot',
		'settings_hot_posts_count'                            => 25,
		'settings_hot_minimal_score'                          => 5,
		'settings_hot_hide_badge'                             => false,
		'settings_popular_disable'                            => false,
		'settings_popular_page'                               => 'popular',
		'settings_popular_posts_count'                        => 25,
		'settings_popular_minimal_score'                      => 5,
		'settings_popular_hide_badge'                         => false,
		//Settings Post Reactions
		'settings_reactions_disable'                          => false,
		'settings_rating_reactions_login_require'             => false,
		'settings_reaction_award_minimal_score'               => 3,
		'settings_reactions_maximal_count_per_vote'           => 3,
		//Settings Gif Control
		'settings_gif_control_cloudconvert_app_key'			  => '',
		'settings_gif_control_storage'						  => 'local',
		'settings_gif_control_animation_event'				  => 'click',
		'settings_gif_control_aws_s3_access_key_id'			  => '',
		'settings_gif_control_aws_s3_secret_access_key'		  => '',
		'settings_gif_control_aws_s3_bucket_name'			  => ''
	);
}

/**
 * Get Theme Options
 *
 * @param $name
 *
 * @return mixed
 */
function boombox_get_theme_option( $name, $force_default = false ){
	$theme_name = boombox_get_theme_name();
	$boombox_theme_options = get_option( $theme_name, array() );

	if( ! isset ( $boombox_theme_options[ $name ] ) || $force_default ){
		$defaults = boombox_get_theme_defaults();
		return $defaults[ $theme_name ][ $name ];
	} else {
		return $boombox_theme_options[ $name ];
	}
}

/**
 * Check if customizer value is changed
 *
 * @param $name
 * @return bool
 */
function boombox_is_theme_option_changed ( $name ) {
	return boombox_get_theme_option( $name ) != boombox_get_theme_option( $name, true );
}

/**
 * Get Logo
 *
 * @return array
 */
function boombox_get_logo(){
	$logo_array = array();

	$logo = boombox_get_theme_option('branding_logo');
	if( empty ( $logo ) ){
		return $logo_array;
	}

	$logo_array['src'] = $logo;
	$logo_array['width'] = boombox_get_theme_option('branding_logo_width');
	$logo_array['height'] = boombox_get_theme_option('branding_logo_height');

	$logo_2x = boombox_get_theme_option('branding_logo_hdpi');
	if( !empty ( $logo_2x ) ) {
		$logo_array['src_2x'] = $logo_2x . ' 2x,' . $logo . ' 1x';;
	}

	return $logo_array;
}

/**
 * Return list of categories
 *
 * @return array
 */
function boombox_get_category_choices() {
	$choices    = array();
	$categories = get_categories( 'hide_empty=0' );

	$choices[''] = esc_html__( 'None', 'boombox' );

	foreach ( $categories as $category ) {
		$choices[ $category->slug ] = $category->name;
	}

	return $choices;
}

/**
 * Get list of tags
 *
 * @return array
 */
function boombox_get_tag_choices() {
	$choices = array();
	$tags    = get_tags( 'hide_empty=0' );

	$choices[''] = esc_html__( 'None', 'boombox' );

	foreach ( $tags as $tag ) {
		$choices[ $tag->slug ] = $tag->name;
	}

	return $choices;
}

/**
 * Get grid hide elements choices
 *
 * @return array
 */
function boombox_get_grid_hide_elements_choices(){
	return array(
		'share_count'    	=> esc_html__( 'Shares Count', 'boombox' ),
		'views_count'    	=> esc_html__( 'Views Count', 'boombox' ),
		'votes_count'    	=> esc_html__( 'Votes Count', 'boombox' ),
		'categories'     	=> esc_html__( 'Categories', 'boombox' ),
		'comments_count' 	=> esc_html__( 'Comments Count', 'boombox' ),
		'media'          	=> esc_html__( 'Media', 'boombox' ),
		'subtitle'       	=> esc_html__( 'Subtitle', 'boombox' ),
		'author'         	=> esc_html__( 'Author', 'boombox' ),
		'date'           	=> esc_html__( 'Date', 'boombox' ),
		'excerpt'        	=> esc_html__( 'Excerpt (for Classic Listing Types)', 'boombox' ),
		'badges'         	=> esc_html__( 'Badges', 'boombox' ),
		'post_type_badges'	=> esc_html__( 'Post Type Badges', 'boombox' ),
	);
}

/**
 * Get post hide elements choices
 *
 * @return array
 */
function boombox_get_post_hide_elements_choices(){
	return apply_filters('boombox_post_hide_elements_choices', array(
		'subtitle'       		=> esc_html__( 'Subtitle', 'boombox' ),
		'author'         		=> esc_html__( 'Author', 'boombox' ),
		'date'           		=> esc_html__( 'Date', 'boombox' ),
		'categories'     		=> esc_html__( 'Categories', 'boombox' ),
		'media'          		=> esc_html__( 'Media', 'boombox' ),
		'comments_count' 		=> esc_html__( 'Comments Count', 'boombox' ),
		'views'          		=> esc_html__( 'Views', 'boombox' ),
		'badges'         		=> esc_html__( 'Badges', 'boombox' ),
		'tags'           		=> esc_html__( 'Tags', 'boombox' ),
		'author_info'    		=> esc_html__( 'Author Info', 'boombox' ),
		'reactions'      		=> esc_html__( 'Reactions', 'boombox' ),
		'subscribe_form' 		=> esc_html__( 'Subscribe Form', 'boombox' ),
		'navigation'     		=> esc_html__( 'WP Navigation', 'boombox' ),
		'comments'       		=> esc_html__( 'WP Comments', 'boombox' ),
		'floating_navbar'		=> esc_html__( 'Floating Navbar', 'boombox' ),
		'top_sharebar'			=> esc_html__( 'Top Sharebar', 'boombox' ),
		'sticky_top_sharebar'	=> esc_html__( 'Sticky Top Sharebar', 'boombox' ),
		'bottom_sharebar'		=> esc_html__( 'Bottom Sharebar', 'boombox' ),
		'next_prev_buttons'		=> esc_html__( 'Next / Prev Buttons', 'boombox' ),
		'side_navigation'		=> esc_html__( 'Side Navigation', 'boombox' ),
	));
}

/**
 * Get listing type choices
 *
 * @return mixed|void
 */
function boombox_get_listing_types_choices(){
	return apply_filters('boombox_listing_types_choices', array(
		'grid'     => esc_html__( 'Grid', 'boombox' ),
		'list'     => esc_html__( 'List', 'boombox' ),
		'list2'    => esc_html__( 'List 2 ( small list )', 'boombox' ),
		'classic'  => esc_html__( 'Classic', 'boombox' ),
		'classic2' => esc_html__( 'Classic 2 ( fixed height )', 'boombox' ),
		'stream'   => esc_html__( 'Stream ( gif\'s & memes )', 'boombox' )
	));
}

/**
 * Get secondary content position choices
 *
 * @return mixed|void
 */
function boombox_get_secondary_sidebar_position_choices() {
	return apply_filters('boombox_secondary_sidebar_position_choices', array(
		'left'     => esc_html__( 'Left', 'boombox' ),
		'right'    => esc_html__( 'Right', 'boombox' )
	));
}

/**
 * Get pagination types
 *
 * @return array
 */
function boombox_get_pagination_types_choices(){
	return apply_filters('boombox_pagination_choices', array(
			'load_more'                 => esc_html__( 'Load More', 'boombox' ),
			'infinite_scroll'           => esc_html__( 'Infinite Scroll', 'boombox' ),
			'infinite_scroll_on_demand' => esc_html__( 'Infinite Scroll (first load via click)', 'boombox' ),
			'pages'                     => esc_html__( 'Numbering', 'boombox' ),
			'next_prev'					=> esc_html__( 'Next/Prev Buttons', 'boombox' )
		)
	);
}

/**
 * Get Conditions
 *
 * @return mixed|void
 */
function boombox_get_conditions_choices(){
	$boombox_conditions_choices             = Boombox_Rate_Criteria::get_criteria_names();
	$boombox_conditions_choices['recent']   = esc_html__( 'Recent', 'boombox' );
	$boombox_conditions_choices['featured'] = esc_html__( 'Featured', 'boombox' );

	return apply_filters( 'boombox_conditions_choices', $boombox_conditions_choices );
}

/**
 * Get Trending Conditions
 *
 * @return mixed|void
 */
function boombox_get_trending_conditions_choices(){
	$boombox_conditions_choices = Boombox_Rate_Criteria::get_criteria_names();
	return apply_filters( 'boombox_trending_conditions_choices', $boombox_conditions_choices );
}

/**
 * Add "most_shared" choice, if Mashshare plugin activated
 *
 * @param $choices
 *
 * @return mixed
 */
function boombox_add_most_shared_to_conditions( $choices ){
	if ( boombox_is_plugin_active( 'mashsharer/mashshare.php' ) ) {
		$choices['most_shared'] = esc_html__( 'Most Shared', 'boombox' );
	}
	return $choices;
}

/**
 * Get time range choices
 *
 * @return mixed|void
 */
function boombox_get_time_range_choices(){
	return apply_filters( 'boombox_time_range_choices', Boombox_Rate_Time_Range::get_time_range_names() );
}

/**
 * Add to page additional listing types choices
 *
 * @param $choices
 *
 * @return mixed
 */
function boombox_listing_types_choices( $choices ) {
	global $current_screen;
	if( isset( $current_screen ) && 'page' === $current_screen ->id ) {
		$choices['numeric-list'] = esc_html__( 'Numeric List', 'boombox' );
		$choices['three-column'] = esc_html__( 'Three Column (Secondary Sidebar)', 'boombox' );
		$choices['none']    = esc_html__( 'None ( Show Page Content )', 'boombox' );
	}
	return $choices;
}

/**
 * Add to page additional pagination types choices
 *
 * @param $choices
 *
 * @return mixed
 */
function boombox_pagination_choices( $choices ) {
	global $current_screen;
	if( isset( $current_screen ) && 'page' === $current_screen ->id ) {
		$choices['none'] = esc_html__( 'None', 'boombox' );
	}
	return $choices;
}

function boombox_get_font_choices() {
	$font_choices = array();

	$default_fonts = boombox_get_default_fonts();
	if( ! empty( $default_fonts ) ) {
		$font_choices[ 'defaults' ] = array(
			'title' 	=> esc_html__( 'Universal Webfonts', 'boombox' ),
			'choices'	=> $default_fonts
		);
	}

	$google_fonts = boombox_get_google_fonts_choices();
	if( ! empty( $google_fonts ) ) {
		$font_choices[ 'google' ] = array(
			'title' 	=> esc_html__( 'Google', 'boombox' ),
			'choices' 	=> boombox_get_google_fonts_choices()
		);
	}

	return $font_choices;
}

/**
 * Get Google fonts choices
 *
 * @return array
 */
function boombox_get_google_fonts_choices(){
	$fonts_choices = array();
	$google_fonts = boombox_get_google_fonts();
	if( ! empty( $google_fonts ) && is_array( $google_fonts )){
		foreach( $google_fonts as $key => $font ){
			$fonts_choices[ $font['family'] ] = $font['family'];
		}
	}
	return $fonts_choices;
}

function boombox_get_default_fonts() {
	return array(
		'Georgia, serif'										=> 'Georgia, serif',
		'"Palatino Linotype", "Book Antiqua", Palatino, serif'  => 'Palatino Linotype, "Book Antiqua", Palatino, serif',
		'"Times New Roman", Times, serif'						=> 'Times New Roman, Times, serif',
		'Arial, Helvetica' 										=> 'Arial, Helvetica, sans-serif',
		'"Arial Black", Gadget' 								=> 'Arial Black, Gadget, sans-serif',
		'"Comic Sans MS", cursive' 								=> 'Comic Sans MS, cursive, sans-serif',
		'Impact, Charcoal'										=> 'Impact, Charcoal, sans-serif',
		'"Lucida Sans Unicode", "Lucida Grande"' 				=> 'Lucida Sans Unicode, Lucida Grande, sans-serif',
		'Tahoma, Geneva' 										=> 'Tahoma, Geneva, sans-serif',
		'"Trebuchet MS", Helvetica' 							=> 'Trebuchet MS, Helvetica, sans-serif',
		'Verdana, Geneva' 										=> 'Verdana, Geneva, sans-serif'
	);
}

/**
 * Get Google fonts subset choices
 *
 * @return mixed|void
 */
function boombox_get_google_fonts_subset_choices() {
	return apply_filters( 'boombox_google_fonts_subset_choices', array(
			'latin'        => esc_html__( 'Latin', 'boombox' ),
			'latin-ext'    => esc_html__( 'Latin Extended', 'boombox' ),
			'cyrillic'     => esc_html__( 'Cyrillic', 'boombox' ),
			'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'boombox' ),
			'greek'        => esc_html__( 'Greek', 'boombox' ),
			'greek-ext'    => esc_html__( 'Greek Extended', 'boombox' ),
			'vietnamese'   => esc_html__( 'Vietnamese', 'boombox' )
		)
	);
}

/**
 * Get Page Ad choices
 *
 * @return mixed|void
 */
function boombox_get_page_ad_choices(){
	return apply_filters( 'boombox_page_ad_choices', array(
		'inject_into_posts_list' => esc_html__( 'Inject Into Posts List', 'boombox' ),
		'none'                   => esc_html__( 'None', 'boombox' )
		)
	);
}

/**
 * Get Page Newsletter choices
 *
 * @return mixed|void
 */
function boombox_get_page_newsletter_choices(){
	return apply_filters( 'boombox_page_newsletter_choices', array(
		'inject_into_posts_list' => esc_html__( 'Inject Into Posts List', 'boombox' ),
		'none'                   => esc_html__( 'None', 'boombox' )
		)
	);
}

/**
 * Get Post template choices
 *
 * @return mixed|void
 */
function boombox_get_post_template_choices() {
	return apply_filters( 'boombox_post_template_choices', array(
		'left-sidebar'  => esc_html__( 'Left Sidebar', 'boombox' ),
		'right-sidebar' => esc_html__( 'Right Sidebar', 'boombox' ),
		'no-sidebar'    => esc_html__( 'No Sidebar', 'boombox' ),
//		'full-width'    => esc_html__( 'Full Width', 'boombox' )
		)
	);
}

/**
 * Get post featured image choices
 *
 * @return array
 */
function boombox_single_post_featured_image_choices() {
	return array(
		'customizer' => esc_html__( 'Customizer Global Value', 'boombox' ),
		'show'		 => esc_html__( 'Show', 'boombox' ),
		'hide'		 => esc_html__( 'Hide', 'boombox' ),
	);
}

/**
 * Get strip size choices
 *
 * @return array
 */
function boombox_get_strip_size_choices() {
	return array(
		'small' => esc_html__( 'Small', 'boombox' ),
		'big'   => esc_html__( 'Big', 'boombox' )
	);
}

/**
 * Get strip title position choices
 *
 * @return array
 */
function boombox_get_strip_title_position_choices() {
	return array(
		'inside' 	=> esc_html__( 'Inside', 'boombox' ),
		'outside'   => esc_html__( 'Outside', 'boombox' )
	);
}

/**
 * Get featured area type choices
 *
 * @return mixed|void
 */
function boombox_get_featured_type_choices() {
	return apply_filters( 'boombox_featured_type_choices', array(
		'1'	  => esc_html__( '1 Featured With Newsletter', 'boombox' ),
		'2'   => esc_html__( '2 Featured', 'boombox' ),
		'3'   => esc_html__( '3 Featured', 'boombox' )
	) );
}
