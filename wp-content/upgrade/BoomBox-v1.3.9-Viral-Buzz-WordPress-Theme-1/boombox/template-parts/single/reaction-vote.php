<?php
/**
 * The template part for displaying the reactions on single page
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if( !boombox_reactions_is_enabled() ){
	return;
}

global $post;
$boombox_reactions_settings      = boombox_get_post_reaction_settings( $post->ID );
$boombox_reaction_total          = $boombox_reactions_settings['reaction_total'];
$boombox_all_reactions           = $boombox_reactions_settings['all_reactions'];
$boombox_reaction_restrictions   = $boombox_reactions_settings['reaction_restrictions'];
$boombox_reactions_login_require = $boombox_reactions_settings['reactions_login_require'];
$boombox_reaction_item_class     = $boombox_reactions_settings['reaction_item_class'];
$boombox_authentication_url      = $boombox_reactions_settings['authentication_url'];
$boombox_authentication_class    = $boombox_reactions_settings['authentication_class'];
if ( ! empty( $boombox_all_reactions ) && is_array( $boombox_all_reactions ) ) : ?>
	<div class="reaction-box">
		<h6 class="title"><?php esc_html_e( "What's Your Reaction?", 'boombox' ); ?></h6>

		<div class="reaction-sections" data-post_id="<?php echo $post->ID; ?>">
			<?php foreach ( $boombox_all_reactions as $reaction ): ?>

				<?php
				if( ( isset( $boombox_reaction_restrictions[ $reaction->term_id ] ) && !$boombox_reaction_restrictions[ $reaction->term_id ][ 'can_react' ] ) ||
					( $boombox_reactions_login_require == true && ! is_user_logged_in() ) ){
					$disabled_class = 'disabled';
				} else {
					$disabled_class = '';
				}
				$boombox_single_reaction_item_class = $boombox_reaction_restrictions[ $reaction->term_id ][ 'reacted' ] ? $boombox_reaction_item_class . ' voted' : $boombox_reaction_item_class;
				?>

				<div class="reaction-item <?php echo esc_attr( $boombox_single_reaction_item_class ); ?> " data-reaction_id="<?php echo $reaction->term_id; ?>">
					<?php
					$reaction_icon_url = boombox_get_reaction_icon_url( $reaction->term_id );
					$image             = ! empty( $reaction_icon_url ) ? ' <img src="' . esc_url( $reaction_icon_url ) . '" alt="' . $reaction->name . '">' : '';
					?>
					<span class="badge <?php echo apply_filters( 'boombox_badge_wrapper_advanced_classes', $reaction->taxonomy, $reaction->taxonomy, $reaction->term_id ); ?>">
					    <span class="circle"><?php echo $image; ?></span>
					    <span class="text"><?php echo $reaction->name; ?></span>
					</span>

					<div class="reaction-bar">
						<div class="reaction-stat"
						     style="height: <?php echo isset( $boombox_reaction_total[ $reaction->term_id ] ) ? $boombox_reaction_total[ $reaction->term_id ]['height'] : 0; ?>%"></div>
						<div class="reaction-stat-count">
							<?php echo isset( $boombox_reaction_total[ $reaction->term_id ] ) ? $boombox_reaction_total[ $reaction->term_id ]['total'] : 0; ?>
						</div>
					</div>
					<a href="<?php echo esc_url( $boombox_authentication_url ); ?>" class="reaction-vote-btn <?php echo esc_attr( $disabled_class ); ?> <?php echo esc_attr( $boombox_authentication_class ); ?>"><?php echo $reaction->name; ?></a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>