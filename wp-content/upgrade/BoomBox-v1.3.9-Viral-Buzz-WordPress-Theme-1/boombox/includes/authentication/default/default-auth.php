<?php
/**
 * Boombox default authentication
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

// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_boombox_ajax_login', 'boombox_ajax_login' );

// Enable the user with no privileges to run ajax_register() in AJAX
add_action( 'wp_ajax_nopriv_boombox_ajax_register', 'boombox_ajax_register' );

// Enable the user with no privileges to run ajax_forgotPassword() in AJAX
add_action( 'wp_ajax_nopriv_boombox_ajax_forgot_password', 'boombox_ajax_forgot_password' );

// Enqueue scripts
add_action( 'wp_enqueue_scripts', 'boombox_default_auth_scripts' );


/**
 * Enqueue Global Authentication scripts
 */
function boombox_default_auth_scripts() {
	global $wp;
	wp_enqueue_script( 'boombox-validate-scripts', BOOMBOX_INCLUDES_URL . 'authentication/assets/js/jquery.validate.js', array( 'jquery' ), '20160407', true );
	wp_enqueue_script( 'boombox-default-auth-scripts', BOOMBOX_INCLUDES_URL . 'authentication/default/js/default-auth-scripts.js', array( 'jquery' ), '20160407', true );

	$current_url = esc_url( home_url( add_query_arg( array(), $wp->request ) ) );
	$ajax_auth_object = array(
		'ajaxurl'               		=> admin_url( 'admin-ajax.php' ),
		'login_redirect_url'    		=> apply_filters( 'boombox_auth_login_redirect_url', $current_url ),
		'register_redirect_url' 		=> apply_filters( 'boombox_auth_register_redirect_url', site_url() ),
		'nsfw_redirect_url'     		=> apply_filters( 'boombox_auth_nsfw_redirect_url', $current_url ),
		'loading_message'       		=> esc_html__( 'Sending user info, please wait...', 'boombox' ),
		'captcha_file_url'      		=> BOOMBOX_INCLUDES_URL . 'authentication/default/captcha/captcha-security-image.php',
		'enable_login_captcha'			=> boombox_get_theme_option( 'auth_enable_login_captcha' ),
		'enable_registration_captcha'	=> boombox_get_theme_option( 'auth_enable_registration_captcha' ),
		'captcha_type'					=> boombox_auth_captcha_type(),
		'site_primary_color'    		=> boombox_get_theme_option( 'design_global_primary_color' )
	);

	wp_localize_script( 'boombox-default-auth-scripts', 'ajax_auth_object', $ajax_auth_object );
}


/**
 * Ajax Login
 */
function boombox_ajax_login() {

	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'ajax-login-nonce', 'security' );

	$boombox_enable_login_captcha = boombox_get_theme_option( 'auth_enable_login_captcha' );
	if( $boombox_enable_login_captcha ) {
		$boombox_auth_captcha_type = boombox_auth_captcha_type();

		if( $boombox_auth_captcha_type === 'image' ) { // image captcha validation

			// Second check the captcha, if it fails the function will break
			if (session_id() == '' || session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			if (!isset($_SESSION["boombox_login_captcha_key"]) || !isset($_POST['captcha']) || $_SESSION["boombox_login_captcha_key"] != $_POST['captcha']) {
				echo json_encode(array(
					'loggedin' => false,
					'message' => esc_html__('Invalid Captcha. Please, try again.', 'boombox')
				));
				die();
			}
			session_write_close();

		} elseif( $boombox_auth_captcha_type === 'google' ) { // google captcha validation

			$gcaptcha = boombox_validate_google_captcha( 'captcha' );

			if( !$gcaptcha['success'] ) {
				echo json_encode(array(
					'loggedin' => false,
					'message' => esc_html__('Invalid Captcha. Please, try again.', 'boombox')
				));
				die();
			}

		}
	}

	// Nonce and captcha are checked, get the POST data and sign user on
	// Call auth_user_login
	boombox_auth_user_login( $_POST['useremail'], $_POST['password'], esc_html__( 'Login', 'boombox' ) );

	die();
}

/**
 * Ajax Registration
 */
function boombox_ajax_register() {

	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'ajax-register-nonce', 'security' );

	// Second check the captcha, if it fails the function will break
	$boombox_enable_registration_captcha = boombox_get_theme_option( 'auth_enable_registration_captcha' );
	if( $boombox_enable_registration_captcha ) {
		$boombox_auth_captcha_type = boombox_auth_captcha_type();

		if( $boombox_auth_captcha_type === 'image' ) { // image captcha validation

			if (session_id() == '' || session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			if (!isset($_SESSION["boombox_register_captcha_key"]) || !isset($_POST['captcha']) || $_SESSION["boombox_register_captcha_key"] != $_POST['captcha']) {
				echo json_encode(array(
					'loggedin' => false,
					'message' => esc_html__('Invalid Captcha. Please, try again.', 'boombox')
				));
				die();
			}
			session_write_close();

		} elseif( $boombox_auth_captcha_type === 'google' ) { // google captcha validation

			$gcaptcha = boombox_validate_google_captcha( 'captcha' );

			if( !$gcaptcha['success'] ) {
				echo json_encode(array(
					'loggedin' => false,
					'message' => esc_html__('Invalid Captcha. Please, try again.', 'boombox')
				));
				die();
			}

		}
	}

	// Nonce is checked, get the POST data and sign user on
	$info                  = array();
	$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_text_field( $_POST['username'] );
	$info['user_pass']     = sanitize_text_field( $_POST['password'] );
	$info['user_email']    = sanitize_email( $_POST['useremail'] );
	$info['role']          = get_option( 'default_role', 'contributor' );

	// Register the user
	$user_register = wp_insert_user( $info );
	if ( is_wp_error( $user_register ) ) {
		$error = $user_register->get_error_codes();

		if ( in_array( 'empty_user_login', $error ) ) {
			echo json_encode( array(
				'loggedin' => false,
				'message'  => esc_html( $user_register->get_error_message( 'empty_user_login' ) )
			) );
		} elseif ( in_array( 'existing_user_email', $error ) || in_array( 'existing_user_login', $error ) ) {
			echo json_encode( array(
				'loggedin' => false,
				'message'  => esc_html__( 'This email address is already registered.', 'boombox' )
			) );
		}
	} else {
		boombox_auth_user_login( $info['user_email'], $info['user_pass'], esc_html__( 'Registration', 'boombox' ) );
	}

	die();
}

function boombox_auth_user_login( $user_email, $password, $login ) {
	$info = array();
	$user = get_user_by( 'email', $user_email );
	if ( ! $user && strtolower( $login ) == 'login' ) {
		$user = get_user_by( 'login', $user_email );
	}
	if ( $user ) {
		$info['user_login']    = $user->user_login;
		$info['user_password'] = $password;
		$info['remember']      = true;

		$user_signon = wp_signon( $info, false );
		if ( is_wp_error( $user_signon ) ) {
			echo json_encode( array(
				'loggedin' => false,
				'message'  => esc_html__( 'Wrong username or password.', 'boombox' )
			) );
		} else {
			wp_set_current_user( $user_signon->ID );
			echo json_encode( array(
				'loggedin' => true,
				'message'  => $login . esc_html__( ' successful, redirecting...', 'boombox' )
			) );
		}
	} else {
		echo json_encode( array(
			'loggedin' => false,
			'message'  => esc_html__( 'There is no user registered with that username or email address.', 'boombox' )
		) );
	}

	die();
}

/**
 * Ajax Forgot Password
 */
function boombox_ajax_forgot_password() {

	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'ajax-forgot-nonce', 'security' );
	$account = $_POST['userlogin'];
	$get_by  = 'email';

	if ( empty( $account ) ) {
		$error = esc_html__('Enter an username or e-mail address.', 'boombox' );
	} else {
		if ( is_email( $account ) ) {
			if ( email_exists( $account ) ) {
				$get_by = 'email';
			} else {
				$error = esc_html__( 'There is no user registered with that email address.', 'boombox' );
			}
		} else if ( validate_username( $account ) ) {
			if ( username_exists( $account ) ) {
				$get_by = 'login';
			} else {
				$error = esc_html__( 'There is no user registered with that username.', 'boombox' );
			}
		} else {
			$error = esc_html__( 'Invalid username or e-mail address.', 'boombox' );
		}
	}

	if ( empty ( $error ) ) {
		// lets generate our new password
		//$random_password = wp_generate_password( 12, false );
		$random_password = wp_generate_password();


		// Get user data by field and data, fields are id, slug, email and login
		$user = get_user_by( $get_by, $account );

		$update_user = wp_update_user( array( 'ID' => $user->ID, 'user_pass' => $random_password ) );

		// if  update user return true then lets send user an email containing the new password
		if ( $update_user ) {

			$from = get_option( 'admin_email' );

			if ( ! ( isset( $from ) && is_email( $from ) ) ) {
				$sitename = strtolower( $_SERVER['SERVER_NAME'] );
				if ( substr( $sitename, 0, 4 ) == 'www.' ) {
					$sitename = substr( $sitename, 4 );
				}
				$from = 'admin@' . $sitename;
			}

			$to      = $user->user_email;
			$subject = esc_html__( 'Your new password', 'boombox' );
			$sender  = 'From: ' . get_option( 'blogname' ) . ' <' . $from . '>' . "\r\n";

			$message = esc_html__( 'Your new password is', 'boombox' ) . ' ' . $random_password;

			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers[] = "X-Mailer: PHP \r\n";
			$headers[] = $sender;

			$mail = wp_mail( $to, $subject, $message, $headers );
			if ( $mail ) {
				$success = esc_html__( 'Check your email address for your new password.', 'boombox' );
			} else {
				$error = esc_html__( 'System is unable to send you mail contain your new password.', 'boombox' );
			}
		} else {
			$error = esc_html__( 'Oops! Something went wrong while updating your account.', 'boombox' );
		}
	}

	if ( ! empty( $error ) ) {
		echo json_encode( array( 'loggedin' => false, 'message' => $error ) );
	}

	if ( ! empty( $success ) ) {
		echo json_encode( array( 'loggedin' => false, 'message' => $success ) );
	}

	die();
}

if( !function_exists( 'boombox_validate_google_captcha' ) ) {
	/**
	 * Validate google captcha response
	 *
	 * @param $key The key in $_POST array where response is set
	 * @return array
	 */
	function boombox_validate_google_captcha($key)
	{
		$gcaptcha = array(
			'success' => false,
			'message' => '',
			'response' => wp_remote_retrieve_body(wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
				'body' => array(
					'secret' => boombox_get_theme_option('auth_google_recaptcha_secret_key'),
					'response' => isset($_POST[$key]) ? $_POST[$key] : ''
				),
			)))
		);

		if (!is_wp_error($gcaptcha['response'])) {
			$gcaptcha['response'] = json_decode($gcaptcha['response'], true);
			if (isset($gcaptcha['response']['success']) && $gcaptcha['response']['success']) {
				$gcaptcha['success'] = true;
			}
		}

		return $gcaptcha;
	}

}