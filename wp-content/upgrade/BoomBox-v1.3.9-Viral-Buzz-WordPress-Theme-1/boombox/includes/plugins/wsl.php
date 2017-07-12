<?php
/**
 * WSL plugin functions
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

if( is_plugin_active( 'wordpress-social-login/wp-social-login.php' ) ) {

    /**
     * Add boombox social icon sets to wsl
     */
    add_filter( 'wsl_component_loginwidget_setup_alter_icon_sets', 'boombox_wsl_add_icon_sets', 10, 1 );
    function boombox_wsl_add_icon_sets( $icon_sets ) {

        $icon_sets[ 'boombox' ] = esc_html__( 'Boombox social icons', 'boombox' );

        return $icon_sets;
    }

    /**
     * Modify social icon sets url
     */
    add_filter( 'wsl_render_auth_widget_alter_assets_base_url', 'boombox_check_icon_sets_base_url', 10, 1 );
    function boombox_check_icon_sets_base_url( $assets_base_url ) {
        $social_icon_set = get_option( 'wsl_settings_social_icon_set' );

        if( 'boombox' == $social_icon_set ) {
            $assets_base_url = BOOMBOX_THEME_URL . 'images/social-icons/';
        }

        return $assets_base_url;
    }

    if( !is_admin() ) {
        /***
         * Modify social icons markup to make it Boomboxed
         */
        add_filter('wsl_render_auth_widget_alter_provider_icon_markup', 'boombox_wsl_button_markup', 10, 3);
        function boombox_wsl_button_markup($provider_id, $provider_name, $authenticate_url) {
            $provider_id = strtolower( $provider_id );
            $icons_rewrite_map = array(
                'vkontakte'        => 'vk',
                'stackoverflow'    => 'stack-overflow',
                'twitchtv'          => 'twitch',
                'mailru'            => 'at',
                'google'            => 'google-plus'
            );

            $icon_name = isset( $icons_rewrite_map[ $provider_id ] ) ? $icons_rewrite_map[ $provider_id ] : $provider_id;

            return sprintf('<a rel="nofollow" href="%3$s" data-provider="%1$s" class="button _%1$s wp-social-login-provider wp-social-login-provider-%1$s"><i class="icon icon-%4$s"></i> %2$s</a>', $provider_id, $provider_name, $authenticate_url, $icon_name );
        }
    }

}