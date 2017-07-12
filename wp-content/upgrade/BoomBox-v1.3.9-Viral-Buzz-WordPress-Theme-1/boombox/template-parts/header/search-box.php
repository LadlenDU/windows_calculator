<?php
/**
 * The template part for displaying the site header search box
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_search_placeholder = ucfirst( esc_html__( 'search and hit enter', 'boombox' ) );
$boombox_search_query       = get_search_query(); ?>
<div class="top-search">
	<button class="form-toggle js-toggle"></button>
	<form role="search" method="get" class="search-form form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" name="s" placeholder="<?php echo esc_attr( $boombox_search_placeholder ); ?>"
		       value="<?php echo esc_attr( $boombox_search_query ); ?>">
	</form>
</div>