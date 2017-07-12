<?php
/**
 * Boombox theme setup
 *
 * @package BoomBox_Theme
 */

/**
 * Hooks
 */
add_action( 'after_setup_theme', 'boombox_setup' );
add_action( 'after_setup_theme', 'boombox_content_width', 0 );
add_action( 'wp_enqueue_scripts', 'boombox_styles' );
add_action( 'wp_enqueue_scripts', 'boombox_scripts' );
add_action( 'widgets_init', 'boombox_widgets_init' );
add_action( 'wp_head','boombox_global_page_id' );
add_action( 'init', 'boombox_authentication' );
add_action( 'wp_head', 'boombox_meta_tags', 0 );

add_filter( 'body_class', 'boombox_body_classes' );
add_filter( 'get_the_archive_title', 'boombox_get_the_archive_title' );
add_filter( 'comment_form_fields', 'boombox_move_comment_field_to_bottom' );
add_filter( 'wp_list_categories', 'boombox_archive_count_no_brackets' );
add_filter( 'mce_buttons', 'boombox_add_next_page_button', 1, 2 );
add_filter( 'excerpt_more', 'boombox_excerpt_more' );
add_filter( 'script_loader_tag', 'boombox_add_script_attribute', 10, 2);
add_filter( 'boombox_reaction_icons_path', 'boombox_add_theme_reaction_icons_path', 10, 1 );
add_filter( 'widget_title', 'boombox_change_widget_title', 10, 3 );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
if ( ! function_exists( 'boombox_setup' ) ) :
	function boombox_setup() {
		/*
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'boombox', get_stylesheet_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'boombox_image360x270', '360', '270', true );
		add_image_size( 'boombox_image360x180', '360', '180', true );
		add_image_size( 'boombox_image200x150', '200', '150', true );
		add_image_size( 'boombox_image768x450', '768', '450', true );
		add_image_size( 'boombox_image768', '768' );
		add_image_size( 'boombox_image545', '545' );
		add_image_size( 'boombox_image1600', '1600' );

		// This theme uses wp_nav_menu() in five locations.
		register_nav_menus( array(
			'top_header_nav'     => esc_html__( 'Top Header Menu', 'boombox' ),
			'bottom_header_nav'  => esc_html__( 'Bottom Header Menu', 'boombox' ),
			'badges_nav'         => esc_html__( 'Badges Menu', 'boombox' ),
			'burger_top_nav'     => esc_html__( 'Burger Top Menu', 'boombox' ),
			'burger_bottom_nav'  => esc_html__( 'Burger Bottom Menu', 'boombox' ),
			'burger_badges_nav'  => esc_html__( 'Burger Badges Menu', 'boombox' ),
			'footer_nav'         => esc_html__( 'Footer Menu', 'boombox' ),
			'profile_nav'		 => esc_html__( 'Profile Menu', 'boombox' )
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'status',
			'audio',
			'chat',
		) );

		/**
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'editor-style.css', boombox_fonts_url() ) );
	}
endif;

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function boombox_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'boombox_content_width', 1160 );
}

/**
 * Enqueue styles.
 */
function boombox_styles() {
	// Plugins
	wp_enqueue_style( 'boombox-styles-min', BOOMBOX_THEME_URL . 'js/plugins/plugins.min.css', array(), '20160316' );

	// Icon fonts
	wp_enqueue_style( 'boombox-icomoon-style', BOOMBOX_THEME_URL . 'fonts/icon-fonts/icomoon/style.css', array(), '20160316' );

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'boombox-fonts', boombox_fonts_url(), array(), null );

	// Icon fonts
	wp_enqueue_style( 'boombox-primary-style', BOOMBOX_THEME_URL . 'css/style.min.css', array(), '20160316' );

	// Enqueue stylesheet from the child theme
	if ( get_template_directory() !== get_stylesheet_directory() ) {
		wp_enqueue_style( 'boombox-style', get_stylesheet_uri() );
	}

	if( is_rtl() ) {
		wp_enqueue_style( 'boombox-style-rtl', BOOMBOX_THEME_URL . 'css/rtl.css', array(), '20160316' );
	}
}

/**
 * Enqueue scripts
 */
function boombox_scripts() {
	global $is_IE;
	global $post;

	if ( $is_IE ) {
		wp_enqueue_script( 'boombox-html5shiv-min', BOOMBOX_THEME_URL . '/js/html5shiv.min.js', array(), '' );
		wp_script_add_data( 'boombox-html5shiv-min', 'conditional', 'lt IE 9' );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$boombox_auth_is_disabled = boombox_disabled_site_auth();
	$boombox_auth_captcha_type = boombox_auth_captcha_type();
	$boombox_enable_login_captcha = boombox_get_theme_option( 'auth_enable_login_captcha' );
	$boombox_enable_registration_captcha = boombox_get_theme_option( 'auth_enable_registration_captcha' );


	if(
		!$boombox_auth_is_disabled && ( $boombox_auth_captcha_type == 'google' ) && ( $boombox_enable_login_captcha || $boombox_enable_registration_captcha ) // login/registration condition
		||
		is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'boombox_contact_form') //pages with contact form shortcodes
	) {
		wp_enqueue_script('boombox-google-recaptcha', 'https://www.google.com/recaptcha/api.js?render=explicit', array('jquery'), '', false);
	}

	// Site main scripts
	wp_enqueue_script( 'boombox-scripts-min', BOOMBOX_THEME_URL . 'js/scripts.min.js', array( 'jquery' ), '20160316', true );
	wp_add_inline_script( 'boombox-scripts-min', sprintf( 'var boombox_gif_event="%s";', boombox_get_theme_option( 'settings_gif_control_animation_event' ) ), 'before' );
}

/**
 * Register Google fonts for Boombox.
 *
 * @return string Google fonts URL for the theme.
 */
if ( ! function_exists( 'boombox_fonts_url' ) ) :

	function boombox_fonts_url() {
		$fonts_url               = '';
		$default_fonts 			 = boombox_get_default_fonts();
		$fonts                   = array();
		$logo_font_family		 = boombox_get_theme_option( 'design_global_logo_font_family' );
		$primary_font_family     = boombox_get_theme_option( 'design_global_primary_font_family' );
		$secondary_font_family   = boombox_get_theme_option( 'design_global_secondary_font_family' );
		$post_titles_font_family = boombox_get_theme_option( 'design_global_post_titles_font_family' );
		$google_font_subset      = boombox_get_theme_option( 'design_global_google_font_subset' );

		$subsets = ! empty( $google_font_subset ) ? $google_font_subset : 'latin,latin-ext';

		if ( !array_key_exists( $logo_font_family , $default_fonts ) ) {
			$fonts[] = "{$logo_font_family}:400,500,400italic,500italic,600,600italic,700,700italic";
		}

		if ( !array_key_exists( $primary_font_family , $default_fonts ) ) {
			$fonts[] = "{$primary_font_family}:400,500,400italic,600,700";
		}

		if ( !array_key_exists( $secondary_font_family , $default_fonts ) ) {
			$fonts[] = "{$secondary_font_family}:400,500,400italic,600,700";
		}

		if ( !array_key_exists( $post_titles_font_family , $default_fonts ) ) {
			$fonts[] = "{$post_titles_font_family}:700";
		}

		if ( (bool)$fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
endif;

/**
 * Registers a widget area.
 */
function boombox_widgets_init() {

	$register_sidebars = array(
		array(
			'name'          => esc_html__( 'Default', 'boombox' ),
			'id'            => 'default-sidebar',
			'description'   => esc_html__( 'The widgets added here will appear on all the pages, except the post single and the page sidebar.', 'boombox' ),
		),
		array(
			'name'          => esc_html__( 'Page 1', 'boombox' ),
			'id'            => 'page-sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your page sidebar.', 'boombox' ),
		),
		array(
			'name'          => esc_html__( 'Page 2', 'boombox' ),
			'id'            => 'page-sidebar-2',
			'description'   => esc_html__( 'Add widgets here to appear in your page sidebar.', 'boombox' ),
		),
		array(
			'name'          => esc_html__( 'Page 3', 'boombox' ),
			'id'            => 'page-sidebar-3',
			'description'   => esc_html__( 'Add widgets here to appear in your page sidebar.', 'boombox' ),
		),
		array(
			'name'          => esc_html__( 'Secondary', 'boombox' ),
			'id'            => 'page-secondary',
			'description'   => esc_html__( 'Add widgets here to appear with three column listing type.', 'boombox' ),
		),
		array(
			'name'          => esc_html__( 'Post Single', 'boombox' ),
			'id'            => 'post-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your post sidebar.', 'boombox' ),
		),
		array(
			'name'          => esc_html__( 'Archive', 'boombox' ),
			'id'            => 'archive-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your post sidebar.', 'boombox' ),
		),
		array(
			'name'          => esc_html__( 'Footer Left', 'boombox' ),
			'id'            => 'footer-left-widgets',
			'description'   => esc_html__( 'Add widgets here to appear in your footer left section.', 'boombox' ),
		),
		array(
			'name'          => esc_html__( 'Footer Middle', 'boombox' ),
			'id'            => 'footer-middle-widgets',
			'description'   => esc_html__( 'Add widgets here to appear in your footer middle section.', 'boombox' ),
		),
		array(
			'name'          => esc_html__( 'Footer Right', 'boombox' ),
			'id'            => 'footer-right-widgets',
			'description'   => esc_html__( 'Add widgets here to appear in your footer right section.', 'boombox' ),
		)
	);
	foreach( $register_sidebars as $register_sidebar ){

		register_sidebar( array(
			'name'          => $register_sidebar['name'],
			'id'            => $register_sidebar['id'],
			'description'   => $register_sidebar['description'],
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}

}

/**
 * Adds custom classes to the array of body classes.
 *
 * @since BoomBox 1.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array (Maybe) filtered body classes.
 */
function boombox_body_classes( $classes ) {

	if( term_exists('nsfw', 'category') && !is_user_logged_in() ){
		$classes[] = 'nsfw-post';
	}

	if ( is_singular( 'post' ) ) {
		$post_template = boombox_get_single_post_template();

		$classes[]     = 'full-width' == $post_template ? esc_attr( $post_template ) . ' ' . 'no-sidebar' : esc_attr( $post_template );
	}

	if( is_archive() || is_home() ) {

		$archive_template = boombox_get_theme_option( 'layout_archive_template' );
		$classes[] = esc_attr( $archive_template );

	}

	if( is_page() || is_archive() || is_home() ) {

		$disable_full_post_button = boombox_get_theme_option( 'layout_post_disable_full_post_button' );
		if( !$disable_full_post_button ) {
			$classes[] = 'has-full-post-button';
		}

	}

	if ( is_page_template( 'page-with-left-sidebar.php' ) ) {
		$classes[] = 'left-sidebar';
	}

	if ( is_page_template( 'page-no-sidebar.php' ) ) {
		$classes[] = 'no-sidebar';
	}

	if ( is_404() ) {
		$classes[] = 'error404 no-sidebar ';
	}

	$badges_reactions_type = boombox_get_theme_option( 'design_badges_reactions_type' );
	if ( $badges_reactions_type ) {
		$classes[] = 'badge-' . esc_attr( $badges_reactions_type );
	}

	$design_badges_position_on_thumbnails = boombox_get_theme_option( 'design_badges_position_on_thumbnails' );
	if( $design_badges_position_on_thumbnails ) {
		$classes[] = 'badges-' . esc_attr( $design_badges_position_on_thumbnails );
	}

	if( boombox_is_theme_option_changed( 'design_global_body_background_color' ) || boombox_is_theme_option_changed( 'design_global_body_background_image' ) ) {
		$classes[] = 'with-background-media';
	}

	return $classes;
}

/**
 * Get single post layout
 *
 * @return mixed
 */
function boombox_get_single_post_template() {
	static $post_template;

	if( !$post_template ) {
		global $post;

		$post_template = get_post_meta( $post->ID, 'boombox_post_template', true );
		$post_template = ( !$post_template || ($post_template == 'customizer') ) ? boombox_get_theme_option( 'layout_post_template' ) : $post_template;
	}

	return $post_template;
}

/**
 * Add Next Page/Page Break Button
 * in WordPress Visual Editor
 *
 * @param $buttons
 * @param $id
 *
 * @return mixed
 */
function boombox_add_next_page_button( $buttons, $id ){

	/* only add this for content editor */
	if ( 'content' != $id )
		return $buttons;

	/* add next page after more tag button */
	array_splice( $buttons, 13, 0, 'wp_page' );

	return $buttons;
}

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function boombox_excerpt_more( $more ) {
	return '...';
}

/**
 * Filter some scripts to add additional options
 *
 * @param $tag Current Tag
 * @param $handle Handle
 * @return mixed Modified Tag
 */
function boombox_add_script_attribute( $tag, $handle ) {
	if( in_array( $handle, array( 'boombox-google-recaptcha', 'facebook-jssdk', 'boombox-google-platform', 'boombox-google-client' ) ) ) {
		return str_replace( ' src', ' id="' . $handle . '" async defer src', $tag );
	}
	return $tag;
}

/**
 * Detect if Registration is active
 */
function boombox_user_can_register() {
	return (bool) get_option( 'users_can_register' );
}

/**
 * Remove 'category' from archive title
 *
 * @param $title
 *
 * @return string|void
 */
function boombox_get_the_archive_title( $title ) {
	if ( is_category() || is_tax('reaction') ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	}

	return $title;

}

/**
 * Get Page ID outside the Loop
 *
 * @return int
 */
function boombox_global_page_id() {
	static $cur_page_id;

	if ( ! $cur_page_id ) {
		global $post;
		if( $post ){
			$cur_page_id = $post->ID;
		}else{
			$cur_page_id = 0;
		}
	}

	return $cur_page_id;
}

/**
 * Moving the Comment Text Field to Bottom
 *
 * @param $fields
 *
 * @return mixed
 */
function boombox_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	return $fields;
}

/**
 * Remove Post Count Parentheses From Widget
 *
 * @param $variable
 *
 * @return mixed
 */
function boombox_archive_count_no_brackets( $variable ) {
	$variable = str_replace( '(', '<span class="post_count"> ', $variable );
	$variable = str_replace( ')', ' </span>', $variable );

	return $variable;
}

/**
 * Check whether the plugin is active
 *
 * @param $plugin
 *
 * @return bool
 */
function boombox_is_plugin_active( $plugin ) {
	/**
	 * Detect plugin. For use on Front End only.
	 */
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	// check for plugin using plugin name
	return is_plugin_active( $plugin );
}

/**
 * Get Google fonts
 *
 * @return array
 */
function boombox_get_google_fonts() {
	$google_fonts = get_transient( 'google_fonts' );
	if ( !$google_fonts ) {
		$google_fonts = array();
		$google_api_key = boombox_get_theme_option( 'design_global_google_api_key' );
		if( $google_api_key ){
			$google_api_url = "https://www.googleapis.com/webfonts/v1/webfonts?key={$google_api_key}";
			$response       = wp_remote_retrieve_body( wp_remote_get( $google_api_url, array( 'sslverify' => false ) ) );
			if ( ! is_wp_error( $response ) ) {
				$data  = json_decode( $response, true );
				if ( isset( $data['items'] ) ){
					$google_fonts = $data['items'];
				}
			}
		}
		set_transient( 'google_fonts', $google_fonts, WEEK_IN_SECONDS );
	}

	return $google_fonts;
}

/**
 * Check if a post status is registered.
 *
 * @see get_post_status_object()
 *
 * @param string $postStatus Post status name.
 * @return bool Whether post status is registered.
 */
function post_status_exists( $postStatus ) {
	return (bool) get_post_status_object( $postStatus );
}

/**
 * Return Featured Strip default image URL
 *
 * @return mixed|void
 */
function boombox_get_default_image_url_for_featured_strip(){
	return apply_filters('boombox_default_image_for_featured_strip', BOOMBOX_THEME_URL . 'images/nophoto.png');
}

/**
 * User Authentication
 */
function boombox_authentication() {
	if ( ! is_user_logged_in() ) {
		require_once( BOOMBOX_INCLUDES_PATH . 'authentication/auth.php' );
	}
}

/**
 * Returns site auth is disabled or not
 *
 * @return mixed
 */
function boombox_disabled_site_auth(){
	static $disabled;

	if( ! $disabled ){
		$disabled = ( bool ) boombox_get_theme_option( 'disable_site_auth' );
	}

	return $disabled;
}

function boombox_auth_captcha_type( $default = 'image' ) {
	static $captcha_type;

	if( !$captcha_type ) {
		$captcha_type = boombox_get_theme_option( 'auth_captcha_type' );
		$captcha_type = $captcha_type ? $captcha_type : $default;
	}

	return $captcha_type;
}

/**
 * Return HTML from file
 */
if ( ! function_exists( 'boombox_load_template_part' ) ) {
	function boombox_load_template_part( $template_name, $part_name = null ) {
		ob_start();
		get_template_part( $template_name, $part_name );
		$var = ob_get_contents();
		ob_end_clean();

		return $var;
	}
}


if ( ! function_exists( 'boombox_theme_reactions_folder_name' ) ) {
	/**
	 * Get custom reactions folder name
	 *
	 * @return string
	 */
	function boombox_theme_reactions_folder_name() {
		return 'reactions';
	}
}

if ( ! function_exists( 'boombox_add_theme_reaction_icons_path' ) ) {
	/**
	 * Add custom folder data to scan for icons
	 * @param $dirs
	 * @return array
	 */
	function boombox_add_theme_reaction_icons_path( $dirs ) {
		$theme_folder_name = boombox_theme_reactions_folder_name();
		array_unshift( $dirs, array(
			'path' => trailingslashit(get_stylesheet_directory()) . $theme_folder_name . '/',
			'url' => get_stylesheet_directory_uri() . '/' . $theme_folder_name . '/'
		) );

		return $dirs;
	}
}

/**
 * Get regular expression for provided type
 *
 * @param $type
 * @return string
 */
function boombox_get_regex( $type ) {

	switch( $type ) {
		case 'youtube':
			$regex = "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/";
			break;
		case 'vimeo':
			$regex = "/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/";
			break;
		default:
			$regex = '';
	}

	return $regex;
}

/**
 * Callback to modify widgets titles
 *
 * @param $title
 * @param $instance
 * @param $id_base
 *
 * @return string
 */
function boombox_change_widget_title( $title = '', $instance = array(), $id_base = '' ) {
	if( 'tag_cloud' == $id_base ) {
		$title = ( isset( $instance['title'] ) && $instance['title'] ) ? $instance['title'] : '';
	}
	return $title;
}

/**
 * Custom Opengraph Meta Tags
 */
function boombox_meta_tags() {

	if( ! is_single() ) return;

	global $post;
	$thumbnail_id = get_post_thumbnail_id( $post );

	if( ! $thumbnail_id ) return;

	$thumbnail_post = get_post( $thumbnail_id );
	if( !$thumbnail_post ) return;

	if( "image/gif" != $thumbnail_post->post_mime_type ) return;
	list( $thumbnail_url, $thumbnail_width, $thumbnail_height, $thumbnail_is_intermediate ) = wp_get_attachment_image_src( $thumbnail_post->ID, 'full' );

	$opengraph = PHP_EOL . '<meta property="og:type" content="website" />';
	$opengraph .= PHP_EOL . sprintf( '<meta property="og:url" content="%s" />', $thumbnail_url );

	echo $opengraph;
}