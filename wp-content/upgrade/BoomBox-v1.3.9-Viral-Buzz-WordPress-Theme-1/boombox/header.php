<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "mainContainer" div.
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

?>
<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<?php get_template_part('template-parts/header/ad'); ?>

		<?php get_template_part('template-parts/header/background', 'image'); ?>

		<?php get_template_part('template-parts/header/navigation', 'mobile'); ?>

		<div class="page-wrapper">
			<?php get_template_part('template-parts/header', 'types'); ?>

