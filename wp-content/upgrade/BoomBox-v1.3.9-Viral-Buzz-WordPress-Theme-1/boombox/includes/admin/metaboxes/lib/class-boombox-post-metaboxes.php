<?php
/**
 * Register a post meta box using a class.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( ! class_exists( 'Boombox_Custom_Post_Meta_Box' ) ) {

	class Boombox_Custom_Post_Meta_Box {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'load-post.php', array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

		/**
		 * Singleton.
		 */
		static function get_instance() {
			static $Inst = null;
			if ( $Inst == null ) {
				$Inst = new self();
			}

			return $Inst;
		}

		/**
		 * Meta box initialization.
		 */
		public function init_metabox() {
			add_action( 'add_meta_boxes', array( $this, 'add_metabox' ), 1 );
			add_action( 'save_post', array( $this, 'save_metabox' ), 10, 2 );
			add_action( 'admin_print_styles-post.php', array( $this, 'post_post_admin_enqueue_scripts' ) );
			add_action( 'admin_print_styles-post-new.php', array( $this, 'post_post_admin_enqueue_scripts' ) );

		}

		/**
		 * Add the meta box.
		 */
		public function add_metabox() {
			/**
			 * Add Advanced Fields to Post screen
			 */
			add_meta_box(
				'boombox-post-metabox',
				__( 'Boombox Post Advanced Fields', 'boombox' ),
				array( $this, 'render_metabox' ),
				'post',
				'side',
				'high'
			);

			add_meta_box(
				'boombox-post-metabox-2',
				__( 'Boombox Post Advanced Fields', 'boombox' ),
				array( $this, 'render_metabox_2' ),
				'post',
				'normal',
				'high'
			);
		}

		/**
		 * Enqueue Scripts and Styles
		 */
		public function post_post_admin_enqueue_scripts() {
			global $current_screen;

			if ( isset( $current_screen ) && 'post' === $current_screen->id  ) {
				wp_enqueue_style( 'boombox-admin-meta-style', BOOMBOX_ADMIN_URL . 'metaboxes/css/boombox-metabox-style.css' );
				wp_enqueue_script( 'boombox-admin-meta-script', BOOMBOX_ADMIN_URL . 'metaboxes/js/boombox-metabox-script.js' );
			}
		}

		/**
		 * Render the advances fields meta box.
		 *
		 * @param $post
		 */
		public function render_metabox( $post ) {

			// Add nonce for security and authentication.
			wp_nonce_field( 'boombox_advanced_fields_nonce_action', 'boombox_nonce' );

			// Use get_post_meta to retrieve an existing value from the database.
			$boombox_is_featured = get_post_meta( $post->ID, 'boombox_is_featured', true );
			$boombox_is_featured = empty( $boombox_is_featured ) ? false : true;

			$boombox_keep_trending = get_post_meta( $post->ID, 'boombox_keep_trending', true );
			$boombox_keep_trending = empty( $boombox_keep_trending ) ? false : true;

			$boombox_keep_hot = get_post_meta( $post->ID, 'boombox_keep_hot', true );
			$boombox_keep_hot = empty( $boombox_keep_hot ) ? false : true;

			$boombox_keep_popular = get_post_meta( $post->ID, 'boombox_keep_popular', true );
			$boombox_keep_popular = empty( $boombox_keep_popular ) ? false : true;

			// Display the form, using the current value.
			?>
			<div class="boombox-post-advanced-fields">

				<?php // Featured Field ?>
				<div class="boombox-post-form-row">
					<input type="checkbox" id="boombox_is_featured"
					       name="boombox_is_featured" <?php checked( $boombox_is_featured, true, true ); ?> />
					<label for="boombox_is_featured"><?php esc_html_e( 'Featured', 'boombox' ); ?></label>
				</div>

				<?php // Keep Trending ?>
				<div class="boombox-post-form-row">
					<input type="checkbox" id="boombox_keep_trending"
					       name="boombox_keep_trending" <?php checked( $boombox_keep_trending, true, true ); ?> />
					<label for="boombox_keep_trending"><?php esc_html_e( 'Keep Trending', 'boombox' ); ?></label>
				</div>

				<?php // Keep Hot ?>
				<div class="boombox-post-form-row">
					<input type="checkbox" id="boombox_keep_hot"
					       name="boombox_keep_hot" <?php checked( $boombox_keep_hot, true, true ); ?> />
					<label for="boombox_keep_hot"><?php esc_html_e( 'Keep Hot', 'boombox' ); ?></label>
				</div>

				<?php // Keep Popular ?>
				<div class="boombox-post-form-row">
					<input type="checkbox" id="boombox_keep_popular"
					       name="boombox_keep_popular" <?php checked( $boombox_keep_popular, true, true ); ?> />
					<label for="boombox_keep_popular"><?php esc_html_e( 'Keep Popular', 'boombox' ); ?></label>
				</div>

			</div>
		<?php
		}

		/**
		 * Render the advances fields meta box.
		 *
		 * @param $post
		 */
		function render_metabox_2( $post ){

			// Add nonce for security and authentication.
			wp_nonce_field( 'boombox_advanced_fields_nonce_action', 'boombox_nonce' );

			// Use get_post_meta to retrieve an existing value from the database.
			$boombox_single_post_featured_image_variations = boombox_single_post_featured_image_choices();
			$boombox_hide_featured_image = get_post_meta( $post->ID, 'boombox_hide_featured_image', true );
			$boombox_hide_featured_image = empty( $boombox_hide_featured_image ) ? 'customizer' : $boombox_hide_featured_image;

			// Use get_post_meta to retrieve an existing value from the database.
			$boombox_video_url = get_post_meta( $post->ID, 'boombox_video_url', true );
			$boombox_video_url = $boombox_video_url ? $boombox_video_url : '';

			$boombox_post_template = get_post_meta( $post->ID, 'boombox_post_template', true );
			$boombox_post_template = $boombox_post_template ? $boombox_post_template : 'customizer';

			$boombox_template_choices = array_merge( array( 'customizer' => esc_html__( 'Customizer Global Value', 'boombox' ) ), boombox_get_post_template_choices() );
			?>

			<div class="boombox-post-advanced-fields">

				<?php // Hide Featured Image ?>
				<div class="boombox-post-form-row">
					<label for="boombox_hide_featured_image"><?php esc_html_e( 'Hide Featured Image', 'boombox' ); ?></label>
					<select id="boombox_hide_featured_image" name="boombox_hide_featured_image">
						<?php foreach ( $boombox_single_post_featured_image_variations as $key => $value ) { ?>
							<option value="<?php echo esc_html( esc_attr( $key ) ); ?>" <?php selected( $boombox_hide_featured_image, esc_html( esc_attr( $key ) ) ); ?>>
								<?php echo esc_html( $value ); ?>
							</option>
						<?php } ?>
					</select>
				</div>

				<?php // Post Template ?>
				<div class="boombox-post-form-row">
					<label for="boombox_post_template"><?php esc_html_e( 'Post Template', 'boombox' ); ?></label>
					<select id="boombox_post_template" name="boombox_post_template">
						<?php foreach ( $boombox_template_choices as $template_key => $template_name ) { ?>
							<option value="<?php echo esc_html( esc_attr( $template_key ) ); ?>" <?php selected( $boombox_post_template, esc_html( esc_attr( $template_key ) ) ); ?>>
								<?php echo esc_html( $template_name ); ?>
							</option>
						<?php } ?>
					</select>
				</div>

				<?php // Video URL ( mp4, youtube, video ) ?>
				<div class="boombox-post-form-row">
					<label for="boombox_video_url"><?php esc_html_e( 'Video URL ( mp4, youtube, vimeo )', 'boombox' ); ?></label>
					<input type="text" id="boombox_video_url" name="boombox_video_url" value="<?php echo esc_html( $boombox_video_url ); ?>"/>
				</div>

			</div>

			<?php
		}

		/**
		 * Handles saving the meta box.
		 *
		 * @param int $post_id Post ID.
		 * @param WP_Post $post Post object.
		 *
		 * @return null
		 */
		public function save_metabox( $post_id, $post ) {
			// Add nonce for security and authentication.
			$nonce_name   = isset( $_POST['boombox_nonce'] ) ? $_POST['boombox_nonce'] : '';
			$nonce_action = 'boombox_advanced_fields_nonce_action';

			// Check if nonce is set.
			if ( ! isset( $nonce_name ) ) {
				return;
			}

			// Check if nonce is valid.
			if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
				return;
			}

			// Check if user has permissions to save data.
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			// Check if not an autosave.
			if ( wp_is_post_autosave( $post_id ) ) {
				return;
			}

			// Check if not a revision.
			if ( wp_is_post_revision( $post_id ) ) {
				return;
			}


			/* OK, it's safe for us to save the data now. */
			$boombox_is_featured = false;
			if ( isset( $_POST['boombox_is_featured'] ) ) {
				$boombox_is_featured = $_POST['boombox_is_featured'] ? true : false;
			}
			update_post_meta( $post_id, 'boombox_is_featured', (int) $boombox_is_featured );

			$boombox_keep_trending = false;
			if ( isset( $_POST['boombox_keep_trending'] ) ) {
				$boombox_keep_trending = $_POST['boombox_keep_trending'] ? 999999999999 : false;
			}
			update_post_meta( $post_id, 'boombox_keep_trending', (int) $boombox_keep_trending );

			$boombox_keep_hot = false;
			if ( isset( $_POST['boombox_keep_hot'] ) ) {
				$boombox_keep_hot = $_POST['boombox_keep_hot'] ? 999999999999 : false;
			}
			update_post_meta( $post_id, 'boombox_keep_hot', (int) $boombox_keep_hot );

			$boombox_keep_popular = false;
			if ( isset( $_POST['boombox_keep_popular'] ) ) {
				$boombox_keep_popular = $_POST['boombox_keep_popular'] ? 999999999999 : false;
			}
			update_post_meta( $post_id, 'boombox_keep_popular', (int) $boombox_keep_popular );

			$boombox_video_url = '';
			if ( isset( $_POST['boombox_video_url'] ) ) {
				$video_url = trim( $_POST['boombox_video_url'] );

				while( true ) {
					$video_type = wp_check_filetype( $video_url );
					if( isset( $video_type['type'] ) && $video_type['type'] && preg_match("~^(?:f|ht)tps?://~i", $video_url ) ) {
						$boombox_video_url = $video_url;
						break;
					}

					preg_match( boombox_get_regex( 'youtube' ), $video_url, $youtube_matches );
					if( isset( $youtube_matches[1] ) && $youtube_matches[1] ) {
						$boombox_video_url = $video_url;
						break;
					}

					preg_match( boombox_get_regex( 'vimeo' ) , $video_url, $vimeo_matches );
					if( isset( $vimeo_matches[5] ) && $vimeo_matches[5] ) {
						$boombox_video_url = $video_url;
						break;
					}

					break;
				}

			}

			update_post_meta( $post_id, 'boombox_video_url', esc_html( $boombox_video_url ) );

			if ( isset( $_POST['boombox_post_template'] ) ) {
				update_post_meta( $post_id, 'boombox_post_template', sanitize_text_field( $_POST['boombox_post_template'] ) );
			}

			if ( isset( $_POST['boombox_hide_featured_image'] ) ) {
				update_post_meta( $post_id, 'boombox_hide_featured_image', sanitize_text_field( $_POST['boombox_hide_featured_image'] ) );
			}

		}


	}
}

Boombox_Custom_Post_Meta_Box::get_instance();