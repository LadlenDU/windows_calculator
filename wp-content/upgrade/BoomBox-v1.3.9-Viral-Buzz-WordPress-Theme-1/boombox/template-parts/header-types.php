<?php
/**
 * The template part for generating header types.
 *
 * @package Boombox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

$boombox_header_settings = boombox_get_header_settings();

// load templates
$boombox_header_branding = boombox_load_template_part( 'template-parts/header/branding' );
$boombox_header_pattern  = boombox_load_template_part( 'template-parts/header/pattern' );
$boombox_header_search   = boombox_load_template_part( 'template-parts/header/search', 'box' );
$boombox_header_auth     = boombox_load_template_part( 'template-parts/header/auth', 'box' );
$boombox_header_badges   = boombox_load_template_part( 'template-parts/header/navigation', 'badges' );
$boombox_top_header      = boombox_load_template_part( 'template-parts/header/navigation', 'header-top' );
$boombox_bottom_header   = boombox_load_template_part( 'template-parts/header/navigation', 'header-bottom' );
$boombox_header_share    = boombox_load_template_part( 'template-parts/header/share', 'box' );
$boombox_header_more     = boombox_load_template_part( 'template-parts/header/more', 'box' );

// settings
$boombox_logo_position         = isset( $boombox_header_settings['logo_position'] ) ? $boombox_header_settings['logo_position'] : '';
$boombox_pattern_position      = isset( $boombox_header_settings['pattern_position'] ) && 'none' != $boombox_header_settings['pattern_position'] ? $boombox_header_settings['pattern_position'] : '';
$boombox_shadow_position       = isset( $boombox_header_settings['shadow_position'] ) && 'none' != $boombox_header_settings['shadow_position'] ? $boombox_header_settings['shadow_position'] : '';
$boombox_search_position       = isset( $boombox_header_settings['search_position'] ) && 'none' != $boombox_header_settings['search_position'] ? $boombox_header_settings['search_position'] : '';
$boombox_auth_position         = isset( $boombox_header_settings['auth_position'] ) && 'none' != $boombox_header_settings['auth_position'] ? $boombox_header_settings['auth_position'] : '';
$boombox_badges_position       = isset( $boombox_header_settings['badges_position'] ) && 'none' != $boombox_header_settings['badges_position'] ? $boombox_header_settings['badges_position'] : '';
$boombox_social_position       = isset( $boombox_header_settings['social_position'] ) && 'none' != $boombox_header_settings['social_position'] ? $boombox_header_settings['social_position'] : '';
$boombox_burger_nav_position   = isset( $boombox_header_settings['burger_nav_position'] ) && 'none' != $boombox_header_settings['burger_nav_position'] ? $boombox_header_settings['burger_nav_position'] : '';
$boombox_sticky_header         = isset( $boombox_header_settings['sticky_header'] ) && 'none' != $boombox_header_settings['sticky_header'] ? $boombox_header_settings['sticky_header'] : '';
$boombox_disable_top_header    = isset( $boombox_header_settings['disable_top_header'] ) && $boombox_header_settings['disable_top_header'] ? true : false;
$boombox_disable_bottom_header = isset( $boombox_header_settings['disable_bottom_header'] ) && $boombox_header_settings['disable_bottom_header'] ? true : false;
$boombox_top_header_height     = isset( $boombox_header_settings['top_header_height'] ) ? $boombox_header_settings['top_header_height'] : '';
$boombox_bottom_header_height  = isset( $boombox_header_settings['bottom_header_height'] ) ? $boombox_header_settings['bottom_header_height'] : '';
$boombox_top_header_width      = isset( $boombox_header_settings['top_header_width'] ) && 'boxed' == $boombox_header_settings['top_header_width'] ? $boombox_header_settings['top_header_width'] : '';
$boombox_bottom_header_width   = isset( $boombox_header_settings['bottom_header_width'] ) && 'boxed' == $boombox_header_settings['bottom_header_width'] ? $boombox_header_settings['bottom_header_width'] : '';
$boombox_top_menu_alignment    = isset( $boombox_header_settings['top_menu_alignment'] ) ? $boombox_header_settings['top_menu_alignment'] : '';
$boombox_bottom_menu_alignment = isset( $boombox_header_settings['bottom_menu_alignment'] ) ? $boombox_header_settings['bottom_menu_alignment'] : '';

// classes
$boombox_header_classes  = $boombox_pattern_position ? $boombox_pattern_position . '-bg' : '';
$boombox_header_classes .= $boombox_logo_position ? " {$boombox_logo_position}-logo" : '';
$boombox_header_classes .= $boombox_shadow_position ? ' ' . $boombox_shadow_position . '-shadow' : '';
$boombox_header_classes .= $boombox_header_settings['disable_top_header'] ? ' no-top' : '';
$boombox_header_classes .= $boombox_header_settings['disable_bottom_header'] ? ' no-bottom' : '';
if( is_single() ) {
	$boombox_single_options = boombox_get_single_page_settings();
	$boombox_template_options = $boombox_single_options['template_options'];
	if( !$boombox_template_options['floating_navbar'] ) {
		$boombox_header_classes .= $boombox_sticky_header ? ' fixed-header ' . 'fixed-' . $boombox_header_settings['sticky_header'] : '';
	}
} else {
	$boombox_header_classes .= $boombox_sticky_header ? ' fixed-header ' . 'fixed-' . $boombox_header_settings['sticky_header'] : '';
}

$boombox_top_header_classes    = $boombox_top_header_height;
$boombox_top_header_classes   .= $boombox_top_header_width ? ' ' . $boombox_top_header_width : '';
$boombox_top_header_classes   .= $boombox_top_menu_alignment ? ' menu-' . $boombox_top_menu_alignment : '' ;

$boombox_bottom_header_classes  = $boombox_bottom_header_height;
$boombox_bottom_header_classes .= $boombox_bottom_header_width ? ' ' . $boombox_bottom_header_width : '';
$boombox_bottom_header_classes .= $boombox_bottom_menu_alignment ? ' menu-' . $boombox_bottom_menu_alignment : '' ;
?>

<header id="header" class="header clearfix <?php echo esc_attr( $boombox_header_classes ); ?>">
	<?php if( !$boombox_disable_top_header ): ?>
		<div class="top clearfix <?php echo esc_attr( $boombox_top_header_classes ); ?>">
			<div class="container">

				<?php if( 'top' == $boombox_logo_position ) : ?>
				<div class="mobile-box">
					<?php echo  $boombox_header_branding; ?>

					<div class="account-box">
						<div class="wrapper">
							<?php echo $boombox_search_position ? $boombox_header_search : ''; ?>
							<?php echo $boombox_auth_position ? $boombox_header_auth : ''; ?>
							<button id="menu-button" class="menu-button icon-bars"></button>
						</div>
					</div>
				</div>
				<?php endif; ?>

				<?php echo 'top' == $boombox_logo_position ? $boombox_header_branding : ''; ?>

				<?php if( 'top' == $boombox_auth_position ): ?>
					<div class="account-box">
						<div class="wrapper">
							<?php echo 'top' == $boombox_search_position ? $boombox_header_search : ''; ?>
							<?php echo 'top' == $boombox_auth_position ? $boombox_header_auth : ''; ?>
						</div>
					</div>
				<?php else: ?>
					<?php echo 'top' == $boombox_search_position ? $boombox_header_search : ''; ?>
				<?php endif; ?>


				<?php echo 'top' == $boombox_badges_position ? $boombox_header_badges : ''; ?>

				<div class="navigation-box">
					<div class="wrapper">
						<div class="nav">
							<?php echo $boombox_top_header; ?>
							<?php echo 'top' == $boombox_burger_nav_position ? $boombox_header_more : ''; ?>
						</div>
						<?php echo 'top' == $boombox_social_position ? $boombox_header_share : ''; ?>
					</div>
				</div>


			</div>
			<?php echo 'top' === $boombox_pattern_position ? $boombox_header_pattern : ''; ?>
		</div>
	<?php endif; ?>

	<?php if( !$boombox_disable_bottom_header ): ?>
		<div class="bottom clearfix <?php echo esc_attr( $boombox_bottom_header_classes ); ?>">
			<div class="container">

				<?php if( 'bottom' == $boombox_logo_position ) : ?>
				<div class="mobile-box">
					<?php echo  $boombox_header_branding; ?>

					<div class="account-box">
						<div class="wrapper">
							<?php echo $boombox_search_position ? $boombox_header_search : ''; ?>
							<?php echo $boombox_auth_position ? $boombox_header_auth : ''; ?>
							<button id="menu-button" class="menu-button icon-bars"></button>
						</div>
					</div>
				</div>
				<?php endif; ?>

				<?php echo 'bottom' == $boombox_logo_position ? $boombox_header_branding : ''; ?>

				<?php if( 'bottom' == $boombox_auth_position ): ?>
					<div class="account-box">
						<div class="wrapper">
							<?php echo 'bottom' == $boombox_search_position ? $boombox_header_search : ''; ?>
							<?php echo 'bottom' == $boombox_auth_position ? $boombox_header_auth : ''; ?>
						</div>
					</div>
				<?php else: ?>
					<?php echo 'bottom' == $boombox_search_position ? $boombox_header_search : ''; ?>
				<?php endif; ?>

				<?php echo 'bottom' == $boombox_badges_position ? $boombox_header_badges : ''; ?>

				<div class="navigation-box">
					<div class="wrapper">
						<div class="nav">
							<?php echo $boombox_bottom_header; ?>
							<?php echo 'bottom' == $boombox_burger_nav_position ? $boombox_header_more : ''; ?>
						</div>
						<?php echo 'bottom' == $boombox_social_position ? $boombox_header_share : ''; ?>
					</div>
				</div>


			</div>
			<?php echo 'bottom' === $boombox_pattern_position ? $boombox_header_pattern : ''; ?>
		</div>
	<?php endif; ?>

	<span id="go-top" class="go-top">
                <i class="icon icon-arrow-up"></i>
            </span>
</header>

<div id="mainContainer" role="main">
<?php if( 'outside' == $boombox_badges_position && !is_single() ): ?>
	<div class="top-badge-list">
		<div class="container">
			<?php echo $boombox_header_badges; ?>
		</div>
	</div>
<?php endif; ?>
