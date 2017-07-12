<?php
/**
 * The template part for displaying the login form.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_login_popup_heading        	= boombox_get_theme_option( 'auth_login_popup_heading' );
$boombox_login_popup_text           	= boombox_get_theme_option( 'auth_login_popup_text' );
$boombox_registration_popup_heading 	= boombox_get_theme_option( 'auth_registration_popup_heading' );
$boombox_enable_login_captcha			= boombox_get_theme_option( 'auth_enable_login_captcha' );
$boombox_auth_captcha_type 				= boombox_auth_captcha_type();
$boombox_auth_google_recaptcha_site_key = boombox_get_theme_option( 'auth_google_recaptcha_site_key' ); ?>

<div id="sign-in" class="sign-in authentication">
	<div class="wrapper">

		<div class="content-wrapper">
			<header>
				<?php if( $boombox_login_popup_heading ): ?>
					<h3 class="title"><?php echo esc_html( $boombox_login_popup_heading ); ?></h3>
				<?php endif; ?>

				<?php if( $boombox_login_popup_text ): ?>
					<div class="intro"><?php echo wp_kses_post( $boombox_login_popup_text ); ?></div>
				<?php endif; ?>
			</header>
			<div class="content">

				<?php if( boombox_is_plugin_active( 'wordpress-social-login/wp-social-login.php' ) ) { ?>
					<?php do_action( 'wordpress_social_login' ); ?>
				<?php } else { ?>
				<div class="clearfix"><?php do_action( 'boombox_before_login_form', 'login' ); ?></div>
				<?php } ?>

				<p class="status"></p>

				<form id="boombox-login" class="ajax-auth" action="login" method="post">
					<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
					<div class="input-field">
						<input type="text" name="useremail" class="required"
						       placeholder="<?php esc_html_e( 'Your username or e-mail', 'boombox' ); ?>">
					</div>
					<div class="input-field">
						<input type="password" name="password" class="required"
						       placeholder="<?php esc_html_e( 'Your password', 'boombox' ); ?>">
						<a class="reset-password-link js-authentication"
						   href="#reset-password"><?php esc_html_e( 'Forgot password?', 'boombox' ); ?></a>
					</div>

					<?php if( $boombox_enable_login_captcha ) { ?>

						<?php if( $boombox_auth_captcha_type === 'image' ) { ?>
						<div class="input-field captcha-container">
							<div class="form-captcha">
								<img src="" alt="Captcha!" class="captcha">
								<a href="#refresh-captcha" class="auth-refresh-captcha refresh-captcha"></a>
							</div>
							<input type="text" class="required" name="captcha-code" placeholder="<?php esc_html_e( 'Enter captcha', 'boombox' ); ?>">
						</div>
						<?php } elseif( $boombox_auth_captcha_type === 'google' && $boombox_auth_google_recaptcha_site_key ) { ?>
						<div class="input-field text-center">
							<div class="google-captcha-code" id="boombox-login-captcha" data-sitekey="<?php echo $boombox_auth_google_recaptcha_site_key; ?>"></div>
						</div>
						<?php } ?>
					<?php } ?>
					<div class="input-field">
						<button class="bb-btn" type="submit"><?php esc_html_e( 'log in', 'boombox' ); ?></button>
					</div>
				</form>
				<?php do_action( 'boombox_after_login_form' ); ?>
			</div>
		</div>
		<?php if ( boombox_user_can_register() ): ?>
			<div class="bottom">
				<div class="text"><?php esc_html_e( 'Don\'t have an account?', 'boombox' ); ?></div>
				<a class="bb-btn bb-btn-default js-authentication" href="#registration">
					<?php echo esc_html( $boombox_registration_popup_heading ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>