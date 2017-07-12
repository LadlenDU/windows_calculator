<?php
/**
 * The template part for displaying ad before header
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

if( is_single() ) {
    $location = 'boombox-single-before-header';
} elseif( is_archive() ) {
    $location = 'boombox-archive-before-header';
} elseif( is_page() ) {
    $location = 'boombox-page-before-header';
} else {
    $location = false;
}

if( $location ) {
    boombox_the_advertisement( $location, 'large' );
}