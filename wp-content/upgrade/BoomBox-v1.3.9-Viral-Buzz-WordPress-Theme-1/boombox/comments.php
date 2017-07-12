<?php
/**
 * The template for displaying comments
 *
 * @package BoomBox_Theme
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
$boombox_single_options     = boombox_get_single_page_settings();
$boombox_template_options   = $boombox_single_options[ 'template_options' ];
if( $boombox_template_options['comments'] ): ?>

	<div id="comments" class="comments">

		<?php if ( have_comments() ) : ?>
			<h2 class="comments-title">
				<?php
				$comments_number = get_comments_number();
				printf( '%1$s <span>%2$d</span>', _x( 'Comments', 'comments title', 'boombox' ), number_format_i18n( $comments_number ) );
				?>
			</h2>

			<?php the_comments_navigation(); ?>

			<ol class="comment-list">
				<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 42,
				) );
				?>
			</ol><!-- .comment-list -->

			<?php the_comments_navigation(); ?>

		<?php endif; // Check for have_comments(). ?>

		<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'boombox' ); ?></p>
		<?php endif; ?>

		<?php
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		$fields    = array(
			'author' =>
				'<div class="row"><div class="col-lg-6 col-md-6"><div class="input-field">' .
				'<input id="author" name="author" type="text" placeholder="' . esc_html__( 'Name *', 'boombox' ) . '" ' . $aria_req . ' ' .
				' value="' . esc_attr( $commenter['comment_author'] ) . '">' .
				'</div></div>',
			'email'  =>
				'<div class="col-lg-6 col-md-6"><div class="input-field">' .
				'<input id="email" name="email" type="text" placeholder="' . esc_html__( 'Email *', 'boombox' ) . '" ' . $aria_req . ' ' .
				'value="' . esc_attr( $commenter['comment_author_email'] ) . '">' .
				'</div></div></div>',
		);
		comment_form( array(
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
			'class_submit'       => 'submit-button',
			'label_submit'       => esc_html__( 'Post Your Reply', 'boombox' ),
			'fields'             => $fields,
			'must_log_in'        => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s" class="js-authentication">logged in</a> to post a comment.' ), '#sign-in' ) . '</p>',
			'comment_field'      =>
				'<div class="row"><div class="col-lg-12"><div class="input-field">' .
				'<textarea id="comment" name="comment" placeholder="' . esc_html__( 'Your Comment *', 'boombox' ) . '" aria-required="true"></textarea>' .
				'</div></div></div>',
		) );
		?>

	</div><!-- .comments-area -->

	<?php
	if( is_single() ){
		boombox_the_advertisement( 'boombox-single-after-comments-section', 'large' );
	} ?>

<?php endif; ?>