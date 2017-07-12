<?php
/**
 * One Click Demo Import plugin functions
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

if ( boombox_is_plugin_active( 'one-click-demo-import/one-click-demo-import.php' ) ) {

    add_filter( 'pt-ocdi/import_files', 'boombox_demo_data' );
    add_action( 'pt-ocdi/after_import', 'boombox_after_import_setup', 10, 1 );

    /**
     * Configure Demo Content data
     */
    function boombox_demo_data() {

        $boombox_demos = boombox_get_demos();

        $demos = array();
        $boombox_demo_url = 'http://boombox.px-lab.com/demos';

        foreach( $boombox_demos as $name => $demo ) {
            $demo_content   = sprintf( '%1$s/%2$s/demo-content.xml', $boombox_demo_url, $name );
            $widgets        = sprintf( '%1$s/%2$s/widgets.wie', $boombox_demo_url, $name );
            $customizer     = sprintf( '%1$s/%2$s/customizer.dat', $boombox_demo_url, $name );
            $screenshot     = sprintf( '%1$s/%2$s/screenshot.jpg', $boombox_demo_url, $name );

            $demos[] = array(
                'name'                         => $name,
                'import_file_name'             => $demo['name'],
                'import_file_url'              => $demo_content,
                'import_widget_file_url'       => $widgets,
                'import_customizer_file_url'   => $customizer,
                'import_preview_image_url'     => $screenshot,
                'import_notice'                => $demo['description'],
            );
        }

        return $demos;

    }

    /**
     * Get static demos
     *
     * @return array
     */
    function boombox_get_demos() {
        return array(
            'original' => array(
                'name'          => esc_html__( 'Boombox Original', 'boombox' ),
                'description'   => esc_html__( 'Boombox Original Description', 'boombox' )
            ),
            'animatrix' => array(
                'name'          => esc_html__( 'Animatrix', 'boombox' ),
                'description'   => esc_html__( 'Animatrix Description', 'boombox' )
            ),
            'another-gag' => array(
                'name'          => esc_html__( 'Another GAG', 'boombox' ),
                'description'   => esc_html__( 'Another GAG Description', 'boombox' )
            ),
            'alternative' => array(
                'name'          => esc_html__( 'Boombox Alternative', 'boombox' ),
                'description'   => esc_html__( 'Boombox Alternative Description', 'boombox' )
            ),
            'buzzy' => array(
                'name'          => esc_html__( 'Buzzy', 'boombox' ),
                'description'   => esc_html__( 'Buzzy Description', 'boombox' )
            ),
            'lonely-panda' => array(
                'name'          => esc_html__( 'Lonely Panda', 'boombox' ),
                'description'   => esc_html__( 'Lonely Panda Description', 'boombox' )
            ),
            'boommag' => array(
                'name'          => esc_html__( 'Boommag', 'boombox' ),
                'description'   => esc_html__( 'Boommag Description', 'boombox' )
            ),
            'minimal' => array(
                'name'          => esc_html__( 'BoomBox Minimal', 'boombox' ),
                'description'   => esc_html__( 'BoomBox Minimal Description', 'boombox' )
            )
        );
    }

    /**
     * Callback to set menu locations some required data after import
     *
     * @param $selected_import
     */
    function boombox_after_import_setup( $selected_import ) {

        // update menues locations
        $menu_locations = array(
            'top_header_nav'    => 0,
            'bottom_header_nav' => 0,
            'badges_nav'        => 0,
            'burger_top_nav'    => 0,
            'burger_bottom_nav' => 0,
            'burger_badges_nav' => 0,
            'footer_nav'        => 0,
            'profile_nav'       => 0,
        );

        // front & blog page options
        $show_on_front = 'posts';
        $front_page_id = 0;
        $blog_page_id = 0;

        switch( $selected_import['name'] ) {

            case 'original':

                // assign menu locations
                $top_header_nav     = get_term_by( 'name', 'Top Header Navigation', 'nav_menu' );
                $badges_nav         = get_term_by( 'name', 'Badges Navigation', 'nav_menu' );
                $burger_top_nav     = get_term_by( 'name', 'Burger Top Navigation', 'nav_menu' );
                $burger_bottom_nav  = get_term_by( 'name', 'Burger Bottom Navigation', 'nav_menu' );
                $burger_badges_nav  = get_term_by( 'name', 'Burger Badges Navigation', 'nav_menu' );
                $footer_nav         = get_term_by( 'name', 'Footer Navigation', 'nav_menu' );

                $menu_locations['top_header_nav']       = $top_header_nav->term_id;
                $menu_locations['badges_nav']           = $badges_nav->term_id;
                $menu_locations['burger_top_nav']       = $burger_top_nav->term_id;
                $menu_locations['burger_bottom_nav']    = $burger_bottom_nav->term_id;
                $menu_locations['burger_badges_nav']    = $burger_badges_nav->term_id;
                $menu_locations['footer_nav']           = $footer_nav->term_id;

                // assign front and blog page options
                $show_on_front = 'page';

                $front_page = get_page_by_title( 'Home Page' );
                $front_page_id = $front_page->ID;

                break;

            case 'animatrix':

                // assign menu locations
                $top_header_nav     = get_term_by( 'name', 'Top Header Navigation', 'nav_menu' );
                $bottom_header_nav  = get_term_by( 'name', 'Bottom Header Navigation', 'nav_menu' );
                $badges_nav         = get_term_by( 'name', 'Badges Navigation', 'nav_menu' );
                $burger_bottom_nav  = get_term_by( 'name', 'Burger Bottom Navigation', 'nav_menu' );
                $footer_nav         = get_term_by( 'name', 'Footer Navigation', 'nav_menu' );

                $menu_locations['top_header_nav']       = $top_header_nav->term_id;
                $menu_locations['bottom_header_nav']    = $bottom_header_nav->term_id;
                $menu_locations['badges_nav']           = $badges_nav->term_id;
                $menu_locations['burger_bottom_nav']    = $burger_bottom_nav->term_id;
                $menu_locations['footer_nav']           = $footer_nav->term_id;

                // assign front and blog page options
                $front_page = get_page_by_title( 'Home Page' );

                $show_on_front = 'page';
                $front_page_id = $front_page->ID;

                break;

            case 'another-gag':

                // assign menu locations
                $top_header_nav     = get_term_by( 'name', 'Top Header Navigation', 'nav_menu' );
                $badges_nav         = get_term_by( 'name', 'Badges Navigation', 'nav_menu' );
                $burger_bottom_nav  = get_term_by( 'name', 'Burger Bottom Navigation', 'nav_menu' );
                $footer_nav         = get_term_by( 'name', 'Footer Navigation', 'nav_menu' );

                $menu_locations['top_header_nav']       = $top_header_nav->term_id;
                $menu_locations['badges_nav']           = $badges_nav->term_id;
                $menu_locations['burger_bottom_nav']    = $burger_bottom_nav->term_id;
                $menu_locations['footer_nav']           = $footer_nav->term_id;

                // assign front and blog page options
                $show_on_front = 'page';

                $front_page = get_page_by_title( 'Home Page' );
                $front_page_id = $front_page->ID;

                break;

            case 'alternative':

                // assign menu locations
                $bottom_header_nav  = get_term_by( 'name', 'Bottom Header Navigation', 'nav_menu' );
                $badges_nav         = get_term_by( 'name', 'Badges Navigation', 'nav_menu' );
                $burger_bottom_nav  = get_term_by( 'name', 'Burger Bottom Navigation', 'nav_menu' );

                $menu_locations['bottom_header_nav']    = $bottom_header_nav->term_id;
                $menu_locations['badges_nav']           = $badges_nav->term_id;
                $menu_locations['burger_bottom_nav']    = $burger_bottom_nav->term_id;

                // assign front and blog page options
                $show_on_front = 'page';

                $front_page = get_page_by_title( 'Home Page' );
                $front_page_id = $front_page->ID;

                break;

            case 'buzzy':

                // assign menu locations
                $bottom_header_nav  = get_term_by( 'name', 'Bottom Header Navigation', 'nav_menu' );
                $badges_nav         = get_term_by( 'name', 'Badges Navigation', 'nav_menu' );
                $burger_bottom_nav  = get_term_by( 'name', 'Burger Bottom Navigation', 'nav_menu' );
                $footer_nav         = get_term_by( 'name', 'Footer Navigation', 'nav_menu' );

                $menu_locations['bottom_header_nav']    = $bottom_header_nav->term_id;
                $menu_locations['badges_nav']           = $badges_nav->term_id;
                $menu_locations['burger_bottom_nav']    = $burger_bottom_nav->term_id;
                $menu_locations['footer_nav']           = $footer_nav->term_id;

                // assign front and blog page options
                $show_on_front = 'page';

                $front_page = get_page_by_title( 'Home Page' );
                $front_page_id = $front_page->ID;

                break;

            case 'lonely-panda':

                // assign menu locations
                $top_header_nav     = get_term_by( 'name', 'Top Header Navigation', 'nav_menu' );
                $bottom_header_nav  = get_term_by( 'name', 'Bottom Header Navigation', 'nav_menu' );
                $badges_nav         = get_term_by( 'name', 'Badges Navigation', 'nav_menu' );
                $burger_top_nav     = get_term_by( 'name', 'Burger Top Navigation', 'nav_menu' );
                $burger_bottom_nav  = get_term_by( 'name', 'Burger Bottom Navigation', 'nav_menu' );

                $menu_locations['top_header_nav']       = $top_header_nav->term_id;
                $menu_locations['bottom_header_nav']    = $bottom_header_nav->term_id;
                $menu_locations['badges_nav']           = $badges_nav->term_id;
                $menu_locations['burger_top_nav']       = $burger_top_nav->term_id;
                $menu_locations['burger_bottom_nav']    = $burger_bottom_nav->term_id;

                break;

            case 'boommag':

                // assign menu locations
                $top_header_nav     = get_term_by( 'name', 'Top Header Navigation', 'nav_menu' );
                $bottom_header_nav  = get_term_by( 'name', 'Bottom Header Navigation', 'nav_menu' );
                $badges_nav         = get_term_by( 'name', 'Badges Navigation', 'nav_menu' );
                $burger_top_nav     = get_term_by( 'name', 'Burger Top Navigation', 'nav_menu' );
                $burger_bottom_nav  = get_term_by( 'name', 'Burger Bottom Navigation', 'nav_menu' );
                $burger_badges_nav  = get_term_by( 'name', 'Burger Badges Navigation', 'nav_menu' );
                $footer_nav         = get_term_by( 'name', 'Footer Navigation', 'nav_menu' );

                $menu_locations['top_header_nav']       = $top_header_nav->term_id;
                $menu_locations['bottom_header_nav']    = $bottom_header_nav->term_id;
                $menu_locations['badges_nav']           = $badges_nav->term_id;
                $menu_locations['burger_top_nav']       = $burger_top_nav->term_id;
                $menu_locations['burger_bottom_nav']    = $burger_bottom_nav->term_id;
                $menu_locations['burger_badges_nav']    = $burger_badges_nav->term_id;
                $menu_locations['footer_nav']           = $footer_nav->term_id;

                // assign front and blog page options
                $show_on_front = 'page';

                $front_page = get_page_by_title( 'Home Page' );
                $front_page_id = $front_page->ID;

                break;

            case 'minimal':

                // assign menu locations
                $bottom_header_nav  = get_term_by( 'name', 'Bottom Header Navigation', 'nav_menu' );

                $menu_locations['bottom_header_nav']    = $bottom_header_nav->term_id;

                // assign front and blog page options
                $show_on_front = 'page';

                $front_page = get_page_by_title( 'Home Page' );
                $front_page_id = $front_page->ID;

                break;
        }

        // set menu locations
        set_theme_mod( 'nav_menu_locations', $menu_locations );

        // set front & blog page options
        update_option( 'show_on_front', $show_on_front );
        update_option( 'page_on_front', $front_page_id );
        update_option( 'page_for_posts', $blog_page_id );

    }

}