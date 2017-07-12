<?php
/**
 * Theme authentication
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}


remove_all_actions('authenticate', 101);

$boombox_auth_is_disabled = boombox_disabled_site_auth();
if ( ! $boombox_auth_is_disabled ) {

	add_action( 'boombox_before_login_form', 'boombox_social_login_form' );
	add_action( 'boombox_before_register_form', 'boombox_social_login_form' );

	function boombox_social_login_form( $auth_type ) {
		$disable_social_auth = boombox_get_theme_option( 'disable_social_auth' );
		if ( ! $disable_social_auth ) {
			$enabled_facebook_auth = boombox_facebook_auth_enabled();
			$enabled_google_auth   = boombox_google_auth_enabled();
			if ( $enabled_facebook_auth || $enabled_google_auth ) {
		?>
				<?php if ( $enabled_facebook_auth ) {
				    echo sprintf( '<a class="button _facebook facebook-login-button-js" href="#"><i class="icon icon-facebook"></i> %1$s</a>', esc_html__( 'Facebook', 'boombox' ) );
                }
                if ( $enabled_google_auth ) {
                    echo sprintf( '<a class="button _google google-login-button-js" href="#"><i class="icon icon-google-plus"></i> %1$s</a>', esc_html__( 'Google', 'boombox' ) );
                }
                ?>
                
				<div class="_or"><?php esc_html_e( 'or', 'boombox' ); ?></div>
			<?php
			}
		}
	}

	/**
	 * Require global authentication
	 */
	require_once( BOOMBOX_INCLUDES_PATH . 'authentication/default/default-auth.php' );

	/**
	 * Require social authentication
	 */
	$disable_social_auth = boombox_get_theme_option( 'disable_social_auth' );
	if ( ! $disable_social_auth ) {
		require_once( BOOMBOX_INCLUDES_PATH . 'authentication/social/social-auth.php' );
	}
}