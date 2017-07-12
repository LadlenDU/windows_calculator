<?php
// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

/**
 * Hooks
 */
add_action( 'wp_enqueue_scripts', 'boombox_rate_and_vote_scripts' );
apply_filters( 'boombox_reactions_is_enabled', 'boombox_reactions_is_enabled' );

/**
 * Enqueue scripts
 */
function boombox_rate_and_vote_scripts() {
	wp_enqueue_script( 'boombox-ajax', BOOMBOX_RATE_VOTE_RESTRICTIONS_URL . 'js/ajax.js', array( 'jquery' ), '20160316', true );
	$ajax_array = array(
		'ajax_url' 		=> admin_url( 'admin-ajax.php' ),
		'track_view'	=> is_single() ? 1 : 0
	);
	wp_localize_script( 'boombox-ajax', 'boombox_ajax_params', $ajax_array );
}

/**
 * Enable/Disable Boombox Reactions
 */
function boombox_reactions_is_enabled(){
	$disable_reactions = boombox_get_theme_option( 'settings_reactions_disable' );
	if( $disable_reactions ){
		return false;
	}
	return true;
}

/**
 * Rate and Vote Restriction Modules
 */
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'class-boombox-exception-helper.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'vote/class-boombox-vote-restriction-trait.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'vote/class-boombox-vote-db-settings.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'vote/class-boombox-vote-settings.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'vote/class-boombox-vote-restriction.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'point-count/class-boombox-point-count-helper.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'view-count/class-boombox-view-count-helper.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'reaction/class-boombox-reaction-helper.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'rate/class-boombox-rate-job.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'rate/class-boombox-rate-time-range.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'rate/class-boombox-rate-criteria.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'rate/class-boombox-rate-query.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'rate/class-boombox-rate-cron.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'rate/class-boombox-rate-schedule.php');


require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'point-count/point-count.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'view-count/view-count.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'comment-count/comment-count.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'reaction/reaction.php');
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'rate/rate.php');

/**
 * Require Ajax
 */
require_once( BOOMBOX_RATE_VOTE_RESTRICTIONS_PATH . 'ajax.php');