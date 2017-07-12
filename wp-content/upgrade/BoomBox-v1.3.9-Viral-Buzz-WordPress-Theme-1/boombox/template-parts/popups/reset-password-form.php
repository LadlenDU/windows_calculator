<?php
/**
 * The template part for displaying the reset password form.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_reset_password_popup_heading = boombox_get_theme_option( 'auth_reset_password_popup_heading' );
$boombox_reset_password_popup_text    = boombox_get_theme_option( 'auth_reset_password_popup_text' );
$boombox_login_popup_heading          = boombox_get_theme_option( 'auth_login_popup_heading' );?>

<div id="reset-password" class="authentication">
	<div class="wrapper">
		<div class="content-wrapper">
			<header>
				<?php if( $boombox_reset_password_popup_heading ): ?>
					<h3 class="title"><?php echo esc_html( $boombox_reset_password_popup_heading ); ?></h3>
				<?php endif; ?>

				<?php if( $boombox_reset_password_popup_text ): ?>
					<div class="intro"><?php echo wp_kses_post( $boombox_reset_password_popup_text ); ?></div>
				<?php endif; ?>
			</header>
			<div class="content">
				<form id="boombox_forgot_password" class="ajax-auth" action="forgot_password" method="post">
					<p class="status"></p>
					<?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>
					<div class="input-field">
						<input type="text" name="userlogin" class="required" placeholder="<?php esc_html_e('Your username or e-mail', 'boombox'); ?>">
					</div>
					<div class="input-field">
						<button class="bb-btn" type="submit"><?php esc_html_e('reset', 'boombox'); ?></button>
					</div>
				</form>

			</div>
		</div>
		<div class="bottom">
			<div class="text"><?php esc_html_e('Back to ', 'boombox'); ?></div>
			<a class="bb-btn bb-btn-default js-authentication" href="#sign-in"><?php echo esc_html( $boombox_login_popup_heading ); ?></a>
		</div>
	</div>
</div>