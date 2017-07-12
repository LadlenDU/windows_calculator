<?php
/**
 * The template part for displaying the registration form.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_registration_popup_heading 	= boombox_get_theme_option( 'auth_registration_popup_heading' );
$boombox_registration_popup_text    	= boombox_get_theme_option( 'auth_registration_popup_text' );
$boombox_terms_of_use_page          	= boombox_get_theme_option( 'auth_terms_of_use_page' );
$boombox_privacy_policy_page        	= boombox_get_theme_option( 'auth_privacy_policy_page' );
$boombox_login_popup_heading        	= boombox_get_theme_option( 'auth_login_popup_heading' );
$boombox_enable_registration_captcha	= boombox_get_theme_option( 'auth_enable_registration_captcha' );
$boombox_auth_captcha_type 				= boombox_auth_captcha_type();
$boombox_auth_google_recaptcha_site_key = boombox_get_theme_option( 'auth_google_recaptcha_site_key' );?>

<div id="registration" class="authentication">
	<div class="wrapper">
		<div class="content-wrapper">
			<header>
				<?php if( $boombox_registration_popup_heading ): ?>
					<h3 class="title"><?php echo esc_html( $boombox_registration_popup_heading ); ?></h3>
				<?php endif; ?>

				<?php if( $boombox_registration_popup_text ): ?>
					<div class="intro"><?php echo wp_kses_post( $boombox_registration_popup_text ); ?></div>
				<?php endif; ?>
			</header>
			<div class="content">
				<?php do_action( 'boombox_before_register_form', 'register' ); ?>
				<p class="status"></p>

				<form id="boombox-register" class="ajax-auth" action="register" method="post">
					<?php wp_nonce_field( 'ajax-register-nonce', 'signonsecurity' ); ?>
					<div class="input-field">
						<input type="email" name="signonemail" class="required"
						       placeholder="<?php esc_html_e( 'Your e-mail address', 'boombox' ); ?>">
					</div>
					<div class="input-field">
						<input type="text" name="signonusername" class="required"
						       placeholder="<?php esc_html_e( 'Your username', 'boombox' ); ?>">
					</div>
					<div class="input-field">
						<input type="password" name="signonpassword" class="required"
						       placeholder="<?php esc_html_e( 'Your password', 'boombox' ); ?>">
					</div>
					<?php if( $boombox_enable_registration_captcha ) { ?>
						<?php if( $boombox_auth_captcha_type === 'image' ) { ?>
						<div class="input-field captcha-container">
							<div class="form-captcha">
								<img src="" alt="Captcha!" class="captcha">
								<a href="#refresh-captcha" class="auth-refresh-captcha refresh-captcha"></a>
							</div>
							<input type="text" name="signoncaptcha" class="required" placeholder="<?php esc_html_e( 'Enter captcha', 'boombox' ); ?>">
						</div>
						<?php } elseif( $boombox_auth_captcha_type === 'google' && $boombox_auth_google_recaptcha_site_key ) { ?>
						<div class="input-field text-center">
							<div class="google-captcha-code" id="boombox-register-captcha" data-sitekey="<?php echo $boombox_auth_google_recaptcha_site_key; ?>"></div>
						</div>
						<?php } ?>
					<?php } ?>
					<div class="input-field">
						<button class="bb-btn" type="submit"><?php esc_html_e( 'sign up', 'boombox' ); ?></button>
					</div>
				</form>
				<?php do_action( 'boombox_after_register_form' ); ?>
			</div>
		</div>
		<div class="bottom">
			<div class="text"><?php esc_html_e( 'Back to ', 'boombox' ); ?></div>
			<a class="bb-btn bb-btn-default js-authentication" href="#sign-in"><?php echo esc_html( $boombox_login_popup_heading ); ?></a>
		</div>
	</div>

	<?php
	if( !empty($boombox_terms_of_use_page) || !empty($boombox_privacy_policy_page) ):
		$boombox_links = false;
		$boombox_terms_of_use_link   = $boombox_terms_of_use_page ? sprintf( ' %1$s <a href="%2$s" target="_blank">%3$s</a> ', esc_html__('the', 'boombox'), get_permalink( $boombox_terms_of_use_page ), esc_html__('terms of use', 'boombox') ) : false;
		$boombox_privacy_policy_link = $boombox_privacy_policy_page ? sprintf( ' %1$s <a href="%2$s" target="_blank">%3$s</a> ', esc_html__('the', 'boombox'), get_permalink( $boombox_privacy_policy_page ), esc_html__('privacy policy', 'boombox') ) : false;
		if( $boombox_terms_of_use_link && $boombox_privacy_policy_link ){
			$boombox_links = $boombox_terms_of_use_link . esc_html__('and', 'boombox') . $boombox_privacy_policy_link;
		}elseif( $boombox_terms_of_use_link ){
			$boombox_links = $boombox_terms_of_use_link;
		}elseif( $boombox_privacy_policy_link ){
			$boombox_links = $boombox_privacy_policy_link;
		}
		if( $boombox_links ): ?>
			<footer>
				<div class="content">
					<?php printf( esc_html__( 'By signing up, you agree that you have read and accepted %s', 'boombox' ), $boombox_links); ?>
				</div>
			</footer>
			<?php
		endif;
	endif; ?>
</div>