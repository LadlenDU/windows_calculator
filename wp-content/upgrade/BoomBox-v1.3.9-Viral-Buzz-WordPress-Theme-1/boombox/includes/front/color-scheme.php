<?php
/**
 * Boombox color scheme
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}


/**
 * Enqueue front-end CSS for header styles
 *
 * @see wp_add_inline_style()
 */
function boombox_header_style_css() {
	$header_site_title_color         = boombox_get_theme_option( 'design_header_site_title_color' ); /* 1 */
	$header_top_background_color     = boombox_get_theme_option( 'design_header_top_background_color' ); /* 2 */
	$header_bottom_background_color  = boombox_get_theme_option( 'design_header_bottom_background_color' ); /* 3 */
	$header_top_text_color           = boombox_get_theme_option( 'design_header_top_text_color' ); /* 4 */
	$header_top_text_hover_color     = boombox_get_theme_option( 'design_header_top_text_hover_color' ); /* 5 */
	$header_bottom_text_color        = boombox_get_theme_option( 'design_header_bottom_text_color' ); /* 6 */
	$header_bottom_text_hover_color  = boombox_get_theme_option( 'design_header_bottom_text_hover_color' ); /* 7 */
	$header_button_background_color  = boombox_get_theme_option( 'design_header_button_background_color' ); /* 8 */
	$header_button_text_color        = boombox_get_theme_option( 'design_header_button_text_color' ); /* 9 */
	$global_content_background_color = boombox_get_theme_option( 'design_global_content_background_color' ); /* 10 */

	$css = '
		/* Custom Header Styles */

		/* --site title color */
		.branding h1 {
		  color: %1$s;
		}

		/* -top */
		.header .top {
		  background-color: %2$s;
		}

		.header .top .form-toggle:hover,
		.header .top .notifications-link:hover,
		.header .top .user-box:hover,
		.header .top .share-menu-item .share-icon:hover,
		.header .top .top-search.open .form-toggle,
		.header .top .account-box .user:hover,
		.header .top .main-navigation > ul > li:hover > a,
		.header .top .main-navigation > ul > li.current-menu-item > a {
		  color: %5$s;
		}

		/* --top pattern */
		.header .top svg {
		  fill: %2$s;
		}

		/* --top text color */
		.header .top {
		  color: %4$s;
		}

		.header .top .main-navigation ul li:before {
		  border-color: %4$s;
		}

		.header .top .account-box .create-post {
		  background-color: %8$s;
		}

		/* --top button color */
		.header .top .account-box .create-post {
		  color: %9$s;
		}

		.header .bottom .form-toggle:hover,
		.header .bottom .notifications-link:hover,
		.header .bottom .user-box:hover,
		.header .bottom .share-menu-item .share-icon:hover,
		.header .bottom .top-search.open .form-toggle,
		.header .bottom .account-box .user:hover,
		.header .bottom .main-navigation > ul > li:hover > a,
		.header .bottom .main-navigation > ul > li.current-menu-item > a {
		  color: %7$s;
		}

		/* -bottom */
		.header .bottom {
		  background-color: %3$s;
		}

		.header .bottom svg {
		  fill: %3$s;
		}

		/* --bottom text color */
		.header .bottom {
		  color: %6$s;
		}

		.header .bottom .main-navigation ul li:before,
		.header .bottom .account-box .user:after,
		.header .bottom .create-post:before,
		.header .bottom .menu-button:after {
		  border-color: %6$s;
		}

		.header .bottom .account-box .create-post {
		  background-color: %8$s;
		}

		/* --bottom button color */
		.header .account-box .create-post {
		  color: %9$s;
		}
	';

	wp_add_inline_style( 'boombox-primary-style',
		sprintf(
			$css,
			$header_site_title_color, /* 1 */
			$header_top_background_color, /* 2 */
			$header_bottom_background_color, /* 3 */
			$header_top_text_color, /* 4 */
			$header_top_text_hover_color,  /* 5 */
			$header_bottom_text_color, /* 6 */
			$header_bottom_text_hover_color, /* 7 */
			$header_button_background_color, /* 8 */
			$header_button_text_color, /* 9 */
			$global_content_background_color
		)
	);
}
add_action( 'wp_enqueue_scripts', 'boombox_header_style_css', 11 );


/**
 * Enqueue front-end CSS for footer styles
 *
 * @see wp_add_inline_style()
 */
function boombox_footer_style_css() {
	$footer_top_background_color    = boombox_get_theme_option( 'design_footer_top_background_color' ); /* 1 */
	$footer_top_heading_color       = boombox_get_theme_option( 'design_footer_top_heading_color' );/* 2 */
	$footer_top_text_color          = boombox_get_theme_option( 'design_footer_top_text_color' );/* 3 */
	$footer_top_link_color          = boombox_get_theme_option( 'design_footer_top_link_color' );/* 4 */
	$footer_bottom_background_color = boombox_get_theme_option( 'design_footer_bottom_background_color' );/* 5 */
	$footer_bottom_text_color       = boombox_get_theme_option( 'design_footer_bottom_text_color' );/* 6 */
	$footer_bottom_text_hover_color = boombox_get_theme_option( 'design_footer_bottom_text_hover_color' );/* 7 */
	$footer_top_primary_color       = boombox_get_theme_option( 'design_footer_top_primary_color' ); /* 8 */
	$footer_top_primary_text_color  = boombox_get_theme_option( 'design_footer_top_primary_text_color' ); /* 9 */

	$css = '
		/* Custom Footer Styles */

		/* -top */
		.footer {
		  background-color: %1$s;
		}

		.footer .footer-top svg {
		  fill: %1$s;
		}

		.footer .footer-bottom svg {
		  fill: %5$s;
		}

		/* -primary color */
		/* --primary bg */
		#footer .cat-item.current-cat a,
		#footer .widget_mc4wp_form_widget:before,#footer .widget_create_post:before,
		#footer .cat-item a:hover,
		#footer button[type="submit"],
		#footer input[type="submit"],
		#footer .bb-btn, #footer .bnt.primary {
		  background-color: %8$s;
		}

		/* --primary text */
		#footer .widget_mc4wp_form_widget:before,#footer .widget_create_post:before,
		#footer button[type="submit"],
		#footer input[type="submit"],
		#footer .bb-btn, #footer .bb-bnt-primary {
		  color: %9$s;
		}

		/* --primary hover */
		#footer a:hover {
		  color: %8$s;
		}

		#footer .widget_categories ul li a:hover,
		#footer .widget_archive ul li a:hover,
		#footer .widget_pages ul li a:hover,
		#footer .widget_meta ul li a:hover,
		#footer .widget_nav_menu ul li a:hover {
		  background-color: %8$s;
		  color: %9$s;
		}

		#footer .slick-dots li.slick-active button:before,
		#footer .widget_tag_cloud a:hover {
		  border-color:%8$s;
		}

		/* -heading color */
		#footer .featured-strip .item .title,
		#footer .featured-strip .slick-next:before, #footer .featured-strip .slick-prev:before,
		#footer .slick-dots li button:before,
		#footer h1,#footer h2,#footer h3,#footer h4, #footer h5,#footer h6,
		#footer .widget-title {
		  color: %2$s;
		}

		/* -text color */
		#footer,
		#footer .widget_recent_comments .recentcomments .comment-author-link,
		#footer
		.widget_recent_comments .recentcomments a,
		#footer .byline, #footer .posted-on,
		#footer .widget_nav_menu ul li,
		#footer .widget_categories ul li,
		#footer .widget_archive ul li,
		#footer .widget_pages ul li,
		#footer .widget_meta ul li {
		  color: %3$s;
		}
		#footer .widget_tag_cloud  a, #footer select, #footer textarea, #footer input[type="tel"], #footer input[type="text"], #footer input[type="number"], #footer input[type="date"], #footer input[type="time"], #footer input[type="url"], #footer input[type="email"], #footer input[type="search"],#footer input[type="password"],
		#footer .widget_mc4wp_form_widget:after, #footer .widget_create_post:after {
			border-color: %3$s;
		}

		#footer .widget_categories ul li a,
		#footer .widget_archive ul li a,
		#footer .widget_pages ul li a,
		#footer .widget_meta ul li a,
		#footer .widget_nav_menu ul li a,
		#footer .widget_tag_cloud a {
		  color: %4$s;
		}

		/* -bottom */
		/* --text  color */
		#footer .footer-bottom {
		  background-color: %5$s;
		  color: %6$s;
		}

		/* --text  hover */
		#footer .footer-bottom a:hover {
		  color: %7$s;
		}
	';

	wp_add_inline_style( 'boombox-primary-style',
		sprintf(
			$css,
			$footer_top_background_color, /* 1 */
			$footer_top_heading_color, /* 2 */
			$footer_top_text_color, /* 3 */
			$footer_top_link_color, /* 4 */
			$footer_bottom_background_color, /* 5 */
			$footer_bottom_text_color, /* 6 */
			$footer_bottom_text_hover_color, /* 7 */
			$footer_top_primary_color, /* 8 */
			$footer_top_primary_text_color /* 9 */
		)
	);
}
add_action( 'wp_enqueue_scripts', 'boombox_footer_style_css', 11 );



/**
 * Enqueue front-end CSS for global styles
 *
 * @see wp_add_inline_style()
 */
function boombox_global_style_css() {
	$global_primary_font_family                   		= boombox_get_theme_option( 'design_global_primary_font_family' ); /* 1 */
	$global_secondary_font_family                 		= boombox_get_theme_option( 'design_global_secondary_font_family' ); /* 2 */
	$global_page_wrapper_width                    		= boombox_get_theme_option( 'design_global_page_wrapper_width_type' ); /* 3 */
	$global_body_background_color                 		= boombox_get_theme_option( 'design_global_body_background_color' ); /* 4 */
	$global_content_background_color              		= boombox_get_theme_option( 'design_global_content_background_color' ); /* 5 */
	$global_primary_color                         		= boombox_get_theme_option( 'design_global_primary_color' ); /* 6 */
	$global_primary_text_color                    		= boombox_get_theme_option( 'design_global_primary_text_color' ); /* 7 */
	$global_base_text_color                       		= boombox_get_theme_option( 'design_global_base_text_color' ); /* 8 */
	$global_secondary_text_color                  		= boombox_get_theme_option( 'design_global_secondary_text_color' ); /* 9 */
	$global_heading_text_color                    		= boombox_get_theme_option( 'design_global_heading_text_color' ); /* 10 */
	$global_border_radius                         		= boombox_get_theme_option( 'design_global_border_radius' ); /* 11 */
	$global_inputs_buttons_border_radius          		= boombox_get_theme_option( 'design_global_inputs_buttons_border_radius' ); /* 12 */
	$global_border_color                          		= boombox_get_theme_option( 'design_global_border_color' ); /* 13 */
	$global_secondary_components_background_color 		= boombox_get_theme_option( 'design_global_secondary_components_background_color' ); /* 14 */
	$global_social_icons_border_radius            		= boombox_get_theme_option( 'design_global_social_icons_border_radius' );/* 15 */
	$global_post_titles_font_family               		= boombox_get_theme_option( 'design_global_post_titles_font_family' ); /* 16 */
	$global_logo_font_family               		 		= boombox_get_theme_option( 'design_global_logo_font_family' ); /* 17 */
	$global_design_global_general_text_font_size  		= boombox_get_theme_option( 'design_global_general_text_font_size' ); /* 18 */
	$global_design_global_single_post_heading_font_size = boombox_get_theme_option( 'design_global_single_post_heading_font_size' ); /* 19 */
	$global_design_global_widget_heading_font_size  	= boombox_get_theme_option( 'design_global_widget_heading_font_size' ); /* 20 */
	$global_link_text_color                    			= boombox_get_theme_option( 'design_global_link_text_color' ); /* 21 */
	$global_user_custom_css								= boombox_get_theme_option( 'design_global_custom_css' ); /* 22 */
	$design_global_secondary_components_text_color 		= boombox_get_theme_option( 'design_global_secondary_components_text_color' ); /* 23 */
	$design_badges_body_background_image_css			= boombox_get_theme_option( 'design_badges_body_background_image_type' ); /* 24 */
	switch( $design_badges_body_background_image_css ) {
		case 'cover':
			$design_badges_body_background_image_css = 'background-size:cover;';
			break;
		case 'repeat':
			$design_badges_body_background_image_css = 'background-repeat:repeat;';
			break;
		default:
			$design_badges_body_background_image_css = '';
	}

	switch( $global_page_wrapper_width ) {
		case 'boxed':
			$global_page_wrapper_width = '1200px';
			break;
		case 'full_width':
			$global_page_wrapper_width = '100%';
			break;
		default:
			$global_page_wrapper_width = '100%';
	}
	$global_border_radius                = $global_border_radius || 0 == $global_border_radius ? $global_border_radius . 'px' : '6px';
	$global_inputs_buttons_border_radius = $global_inputs_buttons_border_radius || 0 == $global_inputs_buttons_border_radius ? $global_inputs_buttons_border_radius . 'px' : '24px';
	$global_social_icons_border_radius   = $global_social_icons_border_radius || 0 == $global_social_icons_border_radius ? $global_social_icons_border_radius . 'px' : '24px';

	/* Use default font if set to google font but it is not possible to get it */
	$google_fonts = boombox_get_google_fonts();
	if( empty( $google_fonts ) ) {
		$default_fonts = boombox_get_default_fonts();

		$global_primary_font_family = array_key_exists( $global_primary_font_family, $default_fonts ) ? $global_primary_font_family : boombox_get_theme_option( 'design_global_primary_font_family', true );
		$global_secondary_font_family = array_key_exists( $global_secondary_font_family, $default_fonts ) ? $global_secondary_font_family : boombox_get_theme_option( 'design_global_secondary_font_family', true );
		$global_post_titles_font_family = array_key_exists( $global_post_titles_font_family, $default_fonts ) ? $global_post_titles_font_family : boombox_get_theme_option( 'design_global_post_titles_font_family', true );
		$global_logo_font_family = array_key_exists( $global_logo_font_family, $default_fonts ) ? $global_logo_font_family : boombox_get_theme_option( 'design_global_logo_font_family', true );

	}

	$css = '

		/* -body color */
		body {
		  	background-color: %4$s;
		  	font-size: %18$dpx;
		}

		#branding h1 {
			font-family: %17$s, sans-serif;
		}

		#background-image {
			%24$s
		}

		/* -Font sizes */

		h1 {
		  	font-size: %19$dpx;
		}

		.widget-title {
			font-size: %20$dpx;
		}

		/* -page color */
		.page-wrapper,
		#mainContainer,
		#mainContainer:before,
		#mainContainer:after,
		.authentication .wrapper,
		.header .more-menu,
		.header .account-box .user-box .menu,
		.header .main-navigation .sub-menu,
		.authentication,.inline-popup,
		.post-share-box .post-share-count,
		.post-share-box.stuck,
		.post-rating a,
		.fixed-pagination .page .content,
		.fixed-next-page,
		.mobile-navigation-wrapper,
		.mejs-container,
		.featured-area .featured-item:first-child,
		.featured-area .featured-item:first-child + .featured-item,
		.featured-area .featured-item:first-child + .featured-item + .featured-item {
		  background-color: %5$s;
		  border-color: %5$s;
		}

		/* -page width */
		.page-wrapper {
		  width: %3$s;
		}

		/* -primary color */
		/* --primary bg */
		.mark, mark,.box_list,
		.tooltip:before,
		#comments .bypostauthor .vcard .fn,
		.text-highlight.primary-color,
		#comments .nav-links a,
		.fancybox-close,
		.quiz_row:hover,
		.progress-bar-success,
		.onoffswitch,.onoffswitch2,
		.widget_nav_menu ul li a:hover,
		.widget_categories ul li a:hover,
		.widget_archive ul li a:hover,
		.widget_pages ul li a:hover,
		.widget_meta ul li a:hover,
		.widget_mc4wp_form_widget:before,.widget_create_post:before,
		.widget_calendar table th a,
		.widget_calendar table td a,
		.go-top,
		.mobile-navigation-wrapper .close,
		.pagination a, .page-links a,.vp_dash_pagina a,
		blockquote:before,
		.next-prev-pagination .nav a,
		.fixed-next-page .next-page a,
		.post-share-box .post-share-count,
		.cat-item.current-cat a,
		.cat-item a:hover,
		.fixed-pagination .page:hover .arrow,
		button[type="submit"],
		input[type="submit"],
		.bb-btn.bb-btn-primary,.bb-btn.bb-btn-primary:hover,.bb-btn.bb-btn-primary-outline:hover {
		  background-color: %6$s;
		}

		.tooltip:after {
			border-top-color:%6$s;
		}


		/* --primary text */
		.mark, mark,
		.tooltip:before,
		.bb-btn:hover, button:hover,
		.bb-btn:focus, button:focus,
		#comments .bypostauthor .vcard .fn,
		#comments .bypostauthor .vcard .fn a,
		.pagination a, .page-links a, .vp_dash_pagina a,
		.text-highlight.primary-color,
		#comments .nav-links a,
		.fancybox-close,
		.sr-only,.box_list,
		.quiz_row:hover,
		.onoffswitch,.onoffswitch2,
		.next-prev-pagination .nav a,
		.fixed-next-page .next-page a,
		.widget_nav_menu ul li a:hover,
		.widget_categories ul li a:hover,
		.widget_archive ul li a:hover,
		.widget_pages ul li a:hover,
		 .widget_meta ul li a:hover,
		 .cat-item.current-cat a,
		.widget_mc4wp_form_widget:before,.widget_create_post:before,
		.go-top,
		.widget_calendar table th a,
		.widget_calendar table td a,
		.mobile-navigation-wrapper .close,
		.post-share-box .post-share-count,
		.fixed-pagination .page:hover .arrow,
		button[type="submit"],
		input[type="submit"],
		.bb-btn.bb-btn-primary,.bb-btn.bb-btn-primary:hover,.bb-btn.bb-btn-primary-outline:hover {
		  color: %7$s;
		}


		.desktop ::-webkit-scrollbar-track {
		  -webkit-box-shadow: inset 0 0 3px rgba(0,0,0,0.3);
		  background-color: %5$s;
		  -webkit-border-radius: %11$s;
		  -moz-border-radius: %11$s;
		  border-radius: %11$s;
		}
		.desktop ::-webkit-scrollbar {
		  width: 10px;
		  background-color: %6$s;
		  -webkit-border-radius: %11$s;
		  -moz-border-radius: %11$s;
		  border-radius: %11$s;
		}
		.desktop ::-webkit-scrollbar-thumb {
		  -webkit-box-shadow: inset 0 0 3px rgba(0,0,0,.3);
		  background-color: %6$s;
		  opacity: 0.4;
		  -webkit-border-radius: %11$s;
		  -moz-border-radius: %11$s;
		  border-radius: %11$s;
		}


		/* --primary  hover */
		#cancel-comment-reply-link,
		.vp-entry legend,
		.main-navigation > ul .sub-menu li:hover > a,
		.main-navigation > ul .sub-menu li.current-menu-item a,
		#header .more-menu .section-navigation ul li:hover a,
		.header .account-box .menu ul li a:hover,
		.single.nsfw-post .single.post .nsfw-post h3,
		.sticky .post-thumbnail:after,
		.entry-no-lg,
		.entry-title:hover a,
		.post-types .item:hover .icon,
		.text-dropcup.primary-color,
		.bb-btn-primary-outline,
		.bb-btn-link:hover,
		.bb-btn-link,
		.more-link:hover,
		.post-navigation .nsfw-post h3,
		.post-thumbnail .nsfw-post h3{
		  color: %6$s;
		}

		.pagination a, .page-links a,
		.vp_dash_pagina .page-numbers,
		.post-types .item:hover,
		.more-load-button button:hover,
		.pagination span, .page-links span,
		.bb-btn-primary-outline,.bb-btn-primary:hover,
		.widget_tag_cloud .tagcloud a:hover {
		  border-color: %6$s;
		}


		/* -link color */
		a {color:%21$s}

		/* -text color */
		body, html,
		.widget_recent_comments .recentcomments .comment-author-link,.widget_recent_comments .recentcomments a,#header .more-menu,.header .main-navigation .sub-menu,
		.header .account-box .user-box .menu,
		.featured-strip .slick-next:before, .featured-strip .slick-prev:before,
		.featured-strip .slick-dots li button:before,
		.header .top-search form input,
		.more-load-button button,
		.vp-op-au-2 a,
		.fixed-next-page .next-page .pages,
		#comments .comment .comment-body .comment-content small a,
		.byline a,.byline .author-name  {
		  color: %8$s;
		}

		/* --heading text color */
		.vp-nameplate,
		.fixed-pagination .page .content .title,
		.more_items_x legend, .more_items legend, .more_items_glow,
		h1, h2, h3, h4, h5, h6 {
		  color: %10$s;
		}

		/* --secondary text color */
		s, strike, del,label,
		#TB_ajaxWindowTitle,
		.vp-media-caption,
		#header .more-menu .sections-header,
		.mobile-navigation-wrapper .more-menu .more-menu-body .sections-header,
		.post-share-box .post-rating .count .text:after,
		.inline-popup .intro,
		.authentication .intro,
		.post-types .item .icon,
		.post-rating a,.post-thumbnail .thumbnail-caption,
		table thead th,.post-share-box .mobile-info,
		.widget_create_post .text,
		.widget_footer .text,
		.author-vcard .about,
		.vp-op-au-2,
		.vp-op-au-4 .glyphicon,
		.vp-op-au-3 .glyphicon,
		.wp-caption .wp-caption-text, .wp-caption-dd,
		#comments .comments-title span,
		#comments .comment-notes,
		#comments .comment-metadata,
		.short-info .create-post .text,
		.post .cat-links,
		.byline,
		.posted-on,
		.post-date,
		.post-comments,
		.entry-sub-title,
		.page-header .taxonomy-description {
		  color: %9$s;
		}

		::-webkit-input-placeholder {
		  color: %9$s;
		}

		:-moz-placeholder {
		  color: %9$s;
		}

		:-ms-input-placeholder {
		  color: %9$s;
		}

		/* -font family */
		/* --base font family */
		body, html,
		#cancel-comment-reply-link,
		#comments .comments-title span {
		  font-family: %1$s, sans-serif;
		}

		/* --Post heading font family */
		.entry-title {
		 font-family: %16$s, cursive;
		}

		/* --secondary font family */
		.pagination, .page-links,.vp_dash_pagina,
		.comments-area h3,
		.entry-no-lg,.reaction-box .title,
		.reaction-item .reaction-vote-btn,
		#comments .comments-title, #comments .comment-reply-title,
		.page-trending .trending-navigation ul li a,
		.vp-entry legend,.widget-title,
		.badge .text,.post-number,
		.more_items_x legend, .more_items legend, .more_items_glow,
		section.error-404 .text,
		.inline-popup .title,
		.authentication .title,
		.other-posts .title,
		.page-header h1 {
		  font-family: %2$s, cursive;
		}


		/* -border-color */
		.page-header,
		.header .main-navigation .sub-menu,
		.header .more-menu,
		#header .more-menu .more-menu-header,
		#header .more-menu .more-menu-footer,
		.mobile-navigation-wrapper .more-menu .more-menu-header,
		.mobile-navigation-wrapper .more-menu .more-menu-footer,
		.header .account-box .user-box .menu,
		.social-box.inline-popup .popup-footer,
		.spinner-pulse,.author-vcard .byline:before,
		.border-thumb,#comments .pingback, #comments .comment,
		.more-load-button button,
		.post-rating .count .icon,
		.quiz_row,.post-grid .post .post-author-meta, .post-grid .page .post-author-meta, .post-list .post .post-author-meta, .post-list .page .post-author-meta,.post-list.standard .post,
		.post-list.standard .post,
		.post-list.standard .entry-sub-title,
		.header .top-search form input,
		.more-load-button:before,
		.vp-uploader,
		#TB_window .shares,
		.vp-glow fieldset,
		.vp-glow fieldset:hover,
		.wp-playlist,
		.post-types .item,
		.page-trending .trending-navigation,
		.widget_mc4wp_form_widget:after,.widget_create_post:after,
		.post-rating .inner,
		.post-rating .point-btn,
		.author-vcard,
		.vp-entry fieldset,
		.vp-op-au-5,.widget_social,
		.widget_subscribe,.post-navigation .meta-nav,
		.post-navigation .page,.post-tags a,
		.next-prev-pagination,
		.widget_tag_cloud .tagcloud a,
		select, textarea, input[type="tel"], input[type="text"], input[type="number"], input[type="date"], input[type="time"], input[type="url"], input[type="email"], input[type="search"], input[type="password"] {
		  border-color: %13$s;
		}
		hr {
		  background-color: %13$s;
		}

		/* -secondary components bg color */
		blockquote,.fixed-pagination .page .arrow,
		.captcha-container,
		.post-share-box .post-comments,
		table tbody tr:nth-child(2n+1) th,
		table tbody tr:nth-child(2n+1) td,
		.reaction-box .reaction-item .reaction-bar,
		.reaction-box .reaction-item .reaction-vote-btn,
		.tabs-menu li,#comments .pingback .comment-body .comment-reply-link, #comments .comment .comment-body .comment-reply-link,.bb-btn, button,
		.widget_sidebar_footer {
		  background-color: %14$s;
		}
		.tabs-content,
		 .tabs-menu li.active {
			border-color:%14$s;
		}

		/* -secondary components text color */
		.fixed-pagination .page .arrow,.post-share-box  .post-comments,
		 #comments .pingback .comment-body .comment-reply-link, #comments .comment .comment-body .comment-reply-link,.reaction-box .reaction-item .reaction-vote-btn,.reaction-box .reaction-item .reaction-bar,.bb-btn, button,.tabs-menu li,.widget_sidebar_footer {
			color:%23$s;
		}

		/* -border-radius */
		img,video,
		.captcha-container,
		.header .account-box .user-box:hover .menu,
		.post-thumbnail .video-wrapper,
		.post-thumbnail .view-full-post,
		.nsfw-post,
		.post-share-box .post-comments,
		.hy_plyr canvas,.featured-strip .item .media,
		.quiz_row,.box_list,
		.border-thumb,
		.advertisement .massage,
		[class^="mashicon-"],
		#TB_window,
		#score_modal .shares a div, #TB_window .shares a div,
		.vp_dash_pagina .page-numbers,
		vp-glow fieldset,
		.mobile-navigation-wrapper .close,
		.onoffswitch-label,
		.fancybox-close,
		.onoffswitch2-label,
		.next-prev-pagination .nav a,
		.fixed-next-page .next-page a,
		.post-types .item,
		.onoffswitch,.onoffswitch2,
		.page-trending .trending-navigation ul li.active a,
		.widget_mc4wp_form_widget:after,.widget_create_post:after,
		blockquote:before,
		.go-top,.author-vcard,
		.featured-area .featured-item:before,
		.widget_sidebar_footer,
		.tabs-menu li:before,.short-info,
		.inline-popup,.authentication,
		.reaction-box .reaction-item .reaction-bar,
		.reaction-item .reaction-vote-btn,
		.pagination a, .page-links a,.vp_dash_pagina a,
		.pagination span, .page-links span,.vp_dash_pagina span,
		.post-share-box .post-share-count,
		.featured-area .featured-item,
		.post-thumbnail,
		.share-button,
		.post-rating .inner,
		.page-header,
		.widget_subscribe,
		.widget_social,
		.sub-menu,
		.fancybox-skin,
		.authentication .wrapper,
		.widget_tag_cloud .tagcloud a,
		.post-tags a,
		.authentication .button,
		#respond .button,
		.more-menu {
		  -webkit-border-radius: %11$s;
		  -moz-border-radius: %11$s;
		  border-radius: %11$s;
		}

		/* --border-radius inputs, buttons */
		.form-captcha img,
		.bb-btn, input, select, textarea, button, .bb-btn, #comments  li .comment-body .comment-reply-link, .header .account-box .create-post{
		  -webkit-border-radius: %12$s;
		  -moz-border-radius: %12$s;
		  border-radius: %12$s;
		}

		/* --border-radius social icons */
		.social.circle ul li a {
		    -webkit-border-radius: %15$s;
		    -moz-border-radius: %15$s;
		    border-radius: %15$s;
		}
	';

	if( boombox_is_plugin_active( 'buddypress/bp-loader.php' ) ) {
		$css .= '

		/* --Buddypress styles */

        /* Base Text Color */
        .header .account-box .notifications-list.menu ul li a {
            color: %8$s;
        }

        /* Heading Text Color */
        #buddypress table th,
        #buddypress .item-header a,
		#buddypress .activity-header a,
		#buddypress .acomment-header a,
		#buddypress #invite-list label,
        #buddypress .standard-form label,
        #buddypress .standard-form legend,
        #buddypress .standard-form span.label,
        #buddypress .messages-notices .thread-from a,
        #buddypress .messages-notices .thread-info a,
        #buddypress #item-header-content .group-name,
        #buddypress #item-header-content .member-name {
            color: %10$s;
        }

        /* Secondary Text Color */
        #buddypress .vp_dash_pagina a,
        #buddypress .pagination-links a,
        #buddypress .vp_dash_pagina span,
        #buddypress .pagination-links span,
        #buddypress .pagination .pag-count,
        #buddypress .notification-description a,
        #buddypress #item-header-content .group-activity,
        #buddypress #item-header-content .member-activity {
            color: %9$s;
        }

        /* Global Border Color */
		#buddypress table td,
        #buddypress table th,
		#buddypress .bbp-item-info,
		#buddypress .activity-list li,
		#buddypress .activity-meta a,
        #buddypress .acomment-options a,
        #buddypress .item-list .item-action a,
        #buddypress .bbp-radio-check,
        #buddypress .bbp-checkbox-check,
        #buddypress .standard-form .submit,
        #buddypress #invite-list li,
        #buddypress #invite-list li:first-child,

        #buddypress #blogs-list,
        #buddypress #groups-list,
        #buddypress #member-list,
        #buddypress #friend-list,
        #buddypress #admins-list,
        #buddypress #mods-list,
        #buddypress #members-list,
        #buddypress #request-list,
        #buddypress #group-list,

        #buddypress #blogs-list li,
        #buddypress #groups-list li,
        #buddypress #member-list li,
        #buddypress #friend-list li,
        #buddypress #admins-list li,
        #buddypress #mods-list li,
        #buddypress #members-list li,
        #buddypress #request-list li,
        #buddypress #group-list li,

        #buddypress .vp_post_entry,
        #buddypress .vp_post_entry .col-lg-3 .entry-footer .post-edit-link {
		    border-color: %13$s;
		}

		.bp-avatar-nav ul,
        .bp-avatar-nav ul.avatar-nav-items li.current {
            border-color: %13$s;
        }

        .bp-avatar-nav ul.avatar-nav-items li.current {
            background-color: %13$s;
        }

		/* Primary Color */
		#buddypress button,
        #buddypress input[type=button],
        #buddypress input[type=reset],
        #buddypress input[type=submit],
        #buddypress ul.button-nav li a,
        #buddypress a.bp-title-button,
        #buddypress .comment-reply-link,
        #buddypress .activity-list .load-more a,
        #buddypress .activity-list .load-newest a {
            background-color: %6$s;
        }

        .header .account-box .notifications-list.menu ul li a:hover {
            color: %6$s;
        }

		%22$s
		';
	}

	wp_add_inline_style( 'boombox-primary-style',
		sprintf(
			$css,
			$global_primary_font_family, /* 1 */
			$global_secondary_font_family, /* 2 */
			$global_page_wrapper_width, /* 3 */
			$global_body_background_color, /* 4 */
			$global_content_background_color, /* 5 */
			$global_primary_color, /* 6 */
			$global_primary_text_color, /* 7 */
			$global_base_text_color, /* 8 */
			$global_secondary_text_color, /* 9 */
			$global_heading_text_color, /* 10 */
			$global_border_radius, /* 11 */
			$global_inputs_buttons_border_radius, /* 12 */
			$global_border_color, /* 13 */
			$global_secondary_components_background_color, /* 14 */
			$global_social_icons_border_radius, /* 15 */
			$global_post_titles_font_family, /* 16 */
			$global_logo_font_family, /* 17 */
			$global_design_global_general_text_font_size, /* 18 */
			$global_design_global_single_post_heading_font_size, /* 19 */
			$global_design_global_widget_heading_font_size, /* 20 */
			$global_link_text_color, /* 21 */
			$global_user_custom_css,	/* 22 */
			$design_global_secondary_components_text_color, /* 23 */
			$design_badges_body_background_image_css /* 24 */
		)
	);
}
add_action( 'wp_enqueue_scripts', 'boombox_global_style_css', 11 );


/**
 * Enqueue front-end CSS for badges styles
 *
 * @see wp_add_inline_style()
 */
function boombox_badges_style_css() {
	$badges_reactions_background_color = boombox_get_theme_option( 'design_badges_reactions_background_color' ); /* 1 */
	$badges_reactions_text_color       = boombox_get_theme_option( 'design_badges_reactions_text_color' ); /* 2 */
	$badges_trending_background_color  = boombox_get_theme_option( 'design_badges_trending_background_color' ); /* 3 */
	$badges_trending_icon_color        = boombox_get_theme_option( 'design_badges_trending_icon_color' ); /* 4 */
	$badges_trending_text_color        = boombox_get_theme_option( 'design_badges_trending_text_color' ); /* 5 */
	$badges_category_background_color  = boombox_get_theme_option( 'design_badges_category_background_color' ); /* 6 */
	$badges_category_icon_color        = boombox_get_theme_option( 'design_badges_category_icon_color' ); /* 7 */
	$badges_category_text_color        = boombox_get_theme_option( 'design_badges_category_text_color' ); /* 8 */

	$css = '
		/* Custom Header Styles */

		/* -badge bg color */
		.reaction-item .reaction-bar .reaction-stat,
		.badge .circle {
		  background-color: %1$s;
		}

		.reaction-item .reaction-vote-btn:not(.disabled):hover,
		.reaction-item.voted .reaction-vote-btn {
			background-color: %1$s !important;
		}

		/* -badge text color */
		.reaction-item .reaction-vote-btn:not(.disabled):hover,
		.reaction-item.voted .reaction-vote-btn,
		.badge .text {
		  color: %2$s;
		}

		/* -poll,quiz bg color */
		.badge.category .circle{
		  background-color:  %6$s;
		}

		/* -poll,quiz text color */
		.badge.category .text {
		  color:  %8$s;
		}

		/* -poll,quiz icon color */
		.badge.category .circle i {
		  color:  %7$s;
		}

		/* --Trending */
		.badge.trending .circle,
		.page-trending .trending-navigation ul li.active a,
		.post-number {
		  background-color: %3$s;
		}

		.widget-title .icon,
		.trending-navigation ul li a .icon {
		  color: %3$s;
		}

		.badge.trending .circle i,
		.page-trending .trending-navigation ul li.active a,
		.page-trending .trending-navigation ul li.active a .icon,
		.post-number {
		  color: %4$s;
		}

		.badge.trending .text{
			color: %5$s;
		}

		%9$s
	';

	$terms_personal_background_colors = boombox_get_terms_personal_styles();

	wp_add_inline_style( 'boombox-primary-style',
		sprintf(
			$css,
			$badges_reactions_background_color, /* 1 */
			$badges_reactions_text_color, /* 2 */
			$badges_trending_background_color, /* 3 */
			$badges_trending_icon_color, /* 4 */
			$badges_trending_text_color, /* 5 */
			$badges_category_background_color, /* 6 */
			$badges_category_icon_color, /* 7 */
			$badges_category_text_color, /* 8 */
			$terms_personal_background_colors /* 9 */
		)
	);
}
add_action( 'wp_enqueue_scripts', 'boombox_badges_style_css', 11 );

function boombox_get_terms_personal_styles() {
	global $wpdb;

	$query = $wpdb->prepare(
		"SELECT `t`.`term_id`,`t`.`name`,`t`.`slug`,`tt`.`taxonomy`,`tm`.`meta_value` AS `color`
			FROM `{$wpdb->terms}` AS `t`
			LEFT JOIN `{$wpdb->term_taxonomy}` AS `tt` ON `tt`.`term_id` = `t`.`term_id`
			INNER JOIN `{$wpdb->termmeta}` AS `tm` ON `tm`.`term_id` = `t`.`term_id` AND `tm`.`meta_key` = %s",
		"term_icon_background_color"
	);

	$terms_color_data = $wpdb->get_results( $query );
	$css = '';

	foreach( $terms_color_data as $term_color_data ) {
		$css .= sprintf(
			'.badge.%1$s-%2$d .circle {
				background-color: %3$s;
			}

			',
			$term_color_data->taxonomy,
			$term_color_data->term_id,
			$term_color_data->color
		);
	}
	return $css;
}
