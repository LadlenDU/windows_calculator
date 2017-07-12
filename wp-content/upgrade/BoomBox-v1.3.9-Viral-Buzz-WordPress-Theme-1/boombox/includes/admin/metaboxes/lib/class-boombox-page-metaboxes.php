<?php
/**
 * Register a page meta box using a class.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( ! class_exists( 'Boombox_Custom_Page_Meta_Box' ) ) {

	class Boombox_Custom_Page_Meta_Box {

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
			add_action( 'admin_print_styles-post.php', array( $this, 'post_page_admin_enqueue_scripts' ) );
			add_action( 'admin_print_styles-post-new.php', array( $this, 'post_page_admin_enqueue_scripts' ) );
		}

		/**
		 * Add the meta box.
		 */
		public function add_metabox() {
			/**
			 * Add Advanced Fields to Page screen
			 */
			add_meta_box(
				'boombox-page-metabox',
				__( 'Boombox Page Advanced Fields', 'boombox' ),
				array( $this, 'render_metabox' ),
				'page',
				'normal',
				'high'
			);
		}

		/**
		 * Enqueue Scripts and Styles
		 */
		public function post_page_admin_enqueue_scripts() {
			global $current_screen;
			if ( isset( $current_screen ) && 'page' === $current_screen->id ) {
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
			$is_trending_page = $this->is_trending_admin_page_template( $post );

			// Add nonce for security and authentication.
			wp_nonce_field( 'boombox_advanced_fields_nonce_action', 'boombox_nonce' );

			// Use get_post_meta to retrieve an existing value from the database.
			$boombox_hide_page_title = get_post_meta( $post->ID, 'boombox_hide_page_title', true );
			$boombox_hide_page_title = empty( $boombox_hide_page_title ) ? false : true;

			$boombox_pagination_type = get_post_meta( $post->ID, 'boombox_pagination_type', true );
			$boombox_pagination_type = empty( $boombox_pagination_type ) ? 'load_more' : $boombox_pagination_type;

			$boombox_posts_per_page = get_post_meta( $post->ID, 'boombox_posts_per_page', true );
			$boombox_posts_per_page = empty( $boombox_posts_per_page ) ? get_option( 'posts_per_page' ) : $boombox_posts_per_page;

			$boombox_sidebar_template = get_post_meta( $post->ID, 'boombox_sidebar_template', true );
			$boombox_sidebar_template = empty( $boombox_sidebar_template ) ? '' : $boombox_sidebar_template;

			if( boombox_is_plugin_active('quick-adsense-reloaded/quick-adsense-reloaded.php') ){
				$boombox_page_ad = get_post_meta( $post->ID, 'boombox_page_ad', true );
				$boombox_page_ad = empty( $boombox_page_ad ) ? 'none' : $boombox_page_ad;

				$boombox_inject_ad_instead_post = get_post_meta( $post->ID, 'boombox_inject_ad_instead_post', true );
				$boombox_inject_ad_instead_post = empty( $boombox_inject_ad_instead_post ) ? 1 : $boombox_inject_ad_instead_post;
			}

			if( boombox_is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php') ){
				$boombox_page_newsletter = get_post_meta( $post->ID, 'boombox_page_newsletter', true );
				$boombox_page_newsletter = empty( $boombox_page_newsletter ) ? 'none' : $boombox_page_newsletter;

				$boombox_inject_newsletter_instead_post = get_post_meta( $post->ID, 'boombox_inject_newsletter_instead_post', true );
				$boombox_inject_newsletter_instead_post = empty( $boombox_inject_newsletter_instead_post ) ? 1 : $boombox_inject_newsletter_instead_post;
			}

			if( !$is_trending_page ){
				$boombox_show_strip = get_post_meta( $post->ID, 'boombox_show_strip', true );
				$boombox_show_strip = empty( $boombox_show_strip ) ? false : true;

				$boombox_show_featured_area = get_post_meta( $post->ID, 'boombox_show_featured_area', true );
				$boombox_show_featured_area = empty( $boombox_show_featured_area ) ? false : true;

				$boombox_listing_type = get_post_meta( $post->ID, 'boombox_listing_type', true );
				$boombox_listing_type = empty( $boombox_listing_type ) ? 'none' : $boombox_listing_type;

				$boombox_listing_condition = get_post_meta( $post->ID, 'boombox_listing_condition', true );
				$boombox_listing_condition = empty( $boombox_listing_condition ) ? 'recent' : $boombox_listing_condition;

				$boombox_listing_time_range = get_post_meta( $post->ID, 'boombox_listing_time_range', true );
				$boombox_listing_time_range = empty( $boombox_listing_time_range ) ? 'all' : $boombox_listing_time_range;

				$boombox_listing_categories = get_post_meta( $post->ID, 'boombox_listing_categories', true );
				$boombox_listing_categories = empty( $boombox_listing_categories ) ? '' : $boombox_listing_categories;

				$boombox_listing_tags = get_post_meta( $post->ID, 'boombox_listing_tags', true );
				$boombox_listing_tags = empty( $boombox_listing_tags ) ? '' : $boombox_listing_tags;

				$boombox_three_column_sidebar_position = get_post_meta( $post->ID, 'boombox_three_column_sidebar_position', true );
				$boombox_three_column_sidebar_position = empty( $boombox_three_column_sidebar_position ) ? 'right' : $boombox_three_column_sidebar_position;
			}

			// Display the form, using the current value.
			?>
			<div class="boombox-page-advanced-fields">
				<?php // Hide Page Title Field ?>
				<div class="boombox-page-form-row">
					<label for="boombox_hide_page_title"><?php esc_html_e( 'Hide Page Title', 'boombox' ); ?></label>
					<input type="checkbox" id="boombox_hide_page_title"
					       name="boombox_hide_page_title" <?php checked( $boombox_hide_page_title, true, true ); ?> />
				</div>
				<hr/>

				<?php if( !$is_trending_page ){ ?>

					<?php // Show Strip Field ?>
					<div class="boombox-page-form-row">
						<label for="boombox_show_strip"><?php esc_html_e( 'Show Strip', 'boombox' ); ?></label>
						<input type="checkbox" id="boombox_show_strip"
						       name="boombox_show_strip" <?php checked( $boombox_show_strip, true, true ); ?> />
					</div>

					<?php // Show Featured Area Field ?>
					<div class="boombox-page-form-row">
						<label for="boombox_show_featured_area"><?php esc_html_e( 'Show Featured Area', 'boombox' ); ?></label>
						<input type="checkbox" id="boombox_show_featured_area"
						       name="boombox_show_featured_area" <?php checked( $boombox_show_featured_area, true, true ); ?> />
					</div>
					<hr/>

					<?php
					// Listing Types Field
					$listing_types_choices = boombox_get_listing_types_choices(); ?>
					<?php if ( is_array( $listing_types_choices ) && ! empty( $listing_types_choices ) ) { ?>
						<div class="boombox-page-form-row">
							<label for="boombox_listing_type"><?php esc_html_e( 'Listing Type ', 'boombox' ); ?></label>
							<select id="boombox_listing_type" name="boombox_listing_type">
								<?php foreach ( $listing_types_choices as $listing_key => $listing_type ) {
									$selected = selected( $listing_key, $boombox_listing_type, false ); ?>
									<option
										value="<?php echo esc_attr( $listing_key ); ?>" <?php echo $selected; ?>><?php echo esc_html( $listing_type ); ?></option>
								<?php } ?>
							</select>
						</div>
					<?php } ?>


					<div class="boombox-listing-settings">
						<?php

						// Three Column Sidebar Position Fields
						$three_column_sidebar_position_choices = boombox_get_secondary_sidebar_position_choices(); ?>
						<?php if ( is_array( $three_column_sidebar_position_choices ) && ! empty( $three_column_sidebar_position_choices ) ) { ?>
							<div class="boombox-page-form-row">
								<label for="boombox_three_column_sidebar_position"><?php esc_html_e( 'Secondary Sidebar Position ', 'boombox' ); ?></label>
								<select id="boombox_three_column_sidebar_position" name="boombox_three_column_sidebar_position">
									<?php foreach ( $three_column_sidebar_position_choices as $position_key => $position ) {
										$selected = selected( $position_key, $boombox_three_column_sidebar_position, false ); ?>
										<option
											value="<?php echo esc_attr( $position_key ); ?>" <?php echo $selected; ?>><?php echo esc_html( $position ); ?></option>
									<?php } ?>
								</select>
							</div>
						<?php }

						// Listing Condition Field
						$listing_conditions_choices = boombox_get_conditions_choices(); ?>
						<?php if ( is_array( $listing_conditions_choices ) && ! empty( $listing_conditions_choices ) ) { ?>
							<div class="boombox-page-form-row">
								<label for="boombox_listing_condition"><?php esc_html_e( 'Listing Condition', 'boombox' ); ?></label>
								<select id="boombox_listing_condition" name="boombox_listing_condition">
									<?php foreach ( $listing_conditions_choices as $listing_condition_key => $listing_condition ) {
										$selected = selected( $listing_condition_key, $boombox_listing_condition, false );?>
										<option
											value="<?php echo esc_attr( $listing_condition_key ); ?>" <?php echo $selected; ?>><?php echo esc_html( $listing_condition ); ?></option>
									<?php } ?>
								</select>
							</div>
						<?php } ?>

						<?php
						// Listing Time Range Field
						$listing_time_range_choices = boombox_get_time_range_choices(); ?>
						<?php if ( is_array( $listing_time_range_choices ) && ! empty( $listing_time_range_choices ) ) { ?>
							<div class="boombox-page-form-row">
								<label for="boombox_listing_time_range"><?php esc_html_e( 'Listing Time Range', 'boombox' ); ?></label>
								<select id="boombox_listing_time_range" name="boombox_listing_time_range">
									<?php foreach ( $listing_time_range_choices as $listing_time_range_key => $listing_time_range ) {
										$selected = selected( $listing_time_range_key, $boombox_listing_time_range, false );  ?>
										<option
											value="<?php echo esc_attr( $listing_time_range_key ); ?>" <?php echo $selected; ?> ><?php echo esc_html( $listing_time_range ); ?></option>
									<?php } ?>
								</select>
							</div>
						<?php } ?>

						<?php
						// Listing Category Field
						$boombox_category_choices = boombox_get_category_choices(); ?>
						<?php if ( is_array( $boombox_category_choices ) && ! empty( $boombox_category_choices ) ) { ?>
							<div class="boombox-page-form-row">
								<label for="boombox_listing_categories"><?php esc_html_e( 'Listing Category', 'boombox' ); ?></label>
								<select id="boombox_listing_categories" name="boombox_listing_categories[]" multiple="multiple">
									<?php foreach ( $boombox_category_choices as $boombox_category_key => $boombox_category ) {
										if ( is_array( $boombox_listing_categories ) ) {
											$selected = selected( in_array( $boombox_category_key, $boombox_listing_categories, true ), true, false );
										} else {
											$selected = selected( $boombox_category_key, $boombox_listing_categories, false );
										} ?>
										<option
											value="<?php echo esc_attr( $boombox_category_key ); ?>" <?php echo $selected; ?>><?php echo esc_html( $boombox_category ); ?></option>
									<?php } ?>
								</select>
							</div>
						<?php } ?>

						<?php
						// Listing Tag Field
						$boombox_tag_choices = boombox_get_tag_choices(); ?>
						<?php if ( is_array( $boombox_tag_choices ) && ! empty( $boombox_tag_choices ) ) { ?>
							<div class="boombox-page-form-row">
								<label for="boombox_listing_tags"><?php esc_html_e( 'Listing Tag', 'boombox' ); ?></label>
								<select id="boombox_listing_tags" name="boombox_listing_tags[]" multiple="multiple">
									<?php foreach ( $boombox_tag_choices as $boombox_tag_key => $boombox_tag ) {
										if ( is_array( $boombox_listing_tags ) ) {
											$selected = selected( in_array( $boombox_tag_key, $boombox_listing_tags, true ), true, false );
										} else {
											$selected = selected( $boombox_tag_key, $boombox_listing_tags, false );
										} ?>
										<option
											value="<?php echo esc_attr( $boombox_tag_key ); ?>" <?php echo $selected; ?> ><?php echo esc_html( $boombox_tag ); ?></option>
									<?php } ?>
								</select>
							</div>
						<?php } ?>
						<hr/>

					</div>
				<?php } ?>

				<div class="boombox-listing-settings">
					<?php // Pagination Type Field
					$pagination_types_choices = boombox_get_pagination_types_choices();
					if ( is_array( $pagination_types_choices ) && ! empty( $pagination_types_choices ) ) { ?>
						<div class="boombox-page-form-row">
							<label for="boombox_pagination_type"><?php esc_html_e( 'Pagination Type ', 'boombox' ); ?></label>
							<select id="boombox_pagination_type" name="boombox_pagination_type">
								<?php foreach ( $pagination_types_choices as $pagination_key => $pagination_type ) {
									if ( is_array( $boombox_pagination_type ) ) {
										$selected = selected( in_array( $pagination_key, $boombox_pagination_type, true ), true, false );
									} else {
										$selected = selected( $pagination_key, $boombox_pagination_type, false );
									} ?>
									<option
										value="<?php echo esc_attr( $pagination_key ); ?>" <?php echo $selected; ?> ><?php echo esc_html( $pagination_type ); ?></option>
								<?php } ?>
							</select>
						</div>
					<?php } ?>

					<?php // Posts Per Page Field ?>
					<div class="boombox-page-form-row boombox-page-form-posts-per-page">
						<label for="boombox_posts_per_page"><?php esc_html_e( 'Posts Per Page', 'boombox' ); ?></label>
						<input type="number" id="boombox_posts_per_page" name="boombox_posts_per_page" min="1"
						       value="<?php echo esc_attr( $boombox_posts_per_page ); ?>"/>
					</div>

					<?php
					if( boombox_is_plugin_active('quick-adsense-reloaded/quick-adsense-reloaded.php') ){
						// Page Ad Field
						$page_ad_choices = boombox_get_page_ad_choices();  ?>
						<?php if ( is_array( $page_ad_choices ) && ! empty( $page_ad_choices ) ) { ?>
							<hr/>
							<div class="boombox-page-form-row">
								<label for="boombox_page_ad"><?php esc_html_e( 'Ad', 'boombox' ); ?></label>
								<select id="boombox_page_ad" name="boombox_page_ad">
									<?php foreach ( $page_ad_choices as $page_ad_key => $page_ad ) {
										if ( is_array( $boombox_page_ad ) ) {
											$selected = selected( in_array( $page_ad_key, $boombox_page_ad, true ), true, false );
										} else {
											$selected = selected( $page_ad_key, $boombox_page_ad, false );
										} ?>
										<option
											value="<?php echo esc_attr( $page_ad_key ); ?>" <?php echo $selected; ?> ><?php echo esc_html( $page_ad ); ?></option>
									<?php } ?>
								</select>
							</div>
						<?php } ?>

						<?php // Inject ad instead post ?>
						<div class="boombox-page-form-row boombox-page-form-adv-instead">
							<label for="boombox_inject_ad_instead_post"><?php esc_html_e( 'Inject ad instead of the post', 'boombox' ); ?></label>
							<input type="number" id="boombox_inject_ad_instead_post" name="boombox_inject_ad_instead_post" min="1"
							       value="<?php echo esc_attr( $boombox_inject_ad_instead_post ); ?>"/>
						</div>
					<?php } ?>

					<?php
					if( boombox_is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php') ){
						// Page Newsletter Field
						$page_newsletter_choices = boombox_get_page_newsletter_choices();  ?>
						<?php if ( is_array( $page_newsletter_choices ) && ! empty( $page_newsletter_choices ) ) { ?>
							<hr/>
							<div class="boombox-page-form-row">
								<label for="boombox_page_newsletter"><?php esc_html_e( 'Newsletter', 'boombox' ); ?></label>
								<select id="boombox_page_newsletter" name="boombox_page_newsletter">
									<?php foreach ( $page_newsletter_choices as $page_newsletter_key => $page_newsletter ) {
										if ( is_array( $boombox_page_newsletter ) ) {
											$selected = selected( in_array( $page_newsletter_key, $boombox_page_newsletter, true ), true, false );
										} else {
											$selected = selected( $page_newsletter_key, $boombox_page_newsletter, false );
										} ?>
										<option
											value="<?php echo esc_attr( $page_newsletter_key ); ?>" <?php echo $selected; ?> ><?php echo esc_html( $page_newsletter ); ?></option>
									<?php } ?>
								</select>
							</div>
						<?php } ?>

						<?php // Inject newsletter instead post ?>
						<div class="boombox-page-form-row boombox-page-form-newsletter-instead">
							<label for="boombox_inject_newsletter_instead_post"><?php esc_html_e( 'Inject newsletter instead of the post', 'boombox' ); ?></label>
							<input type="number" id="boombox_inject_newsletter_instead_post" name="boombox_inject_newsletter_instead_post" min="1"
							       value="<?php echo esc_attr( $boombox_inject_newsletter_instead_post ); ?>"/>
						</div>
					<?php } ?>

				</div>

				<?php
				// Sidebar Template
				$sidebar_templates = array(
					'default-sidebar' => esc_html__( 'Default', 'boombox' ),
					'page-sidebar-1'  => esc_html__( 'Page 1', 'boombox' ),
					'page-sidebar-2'  => esc_html__( 'Page 2', 'boombox' ),
					'page-sidebar-3'  => esc_html__( 'Page 3', 'boombox' )
				); ?>
				<?php if ( is_array( $sidebar_templates ) && ! empty( $sidebar_templates ) ) { ?>
					<hr/>
					<div class="boombox-page-form-row">
						<label for="boombox_sidebar_template"><?php esc_html_e( 'Sidebar Template', 'boombox' ); ?></label>
						<select id="boombox_sidebar_template" name="boombox_sidebar_template">
							<?php foreach ( $sidebar_templates as $sidebar_template_key => $sidebar_template ) {
								$selected = selected( $sidebar_template_key, $boombox_sidebar_template, false );  ?>
								<option
									value="<?php echo esc_attr( $sidebar_template_key ); ?>" <?php echo $selected; ?> ><?php echo esc_html( $sidebar_template ); ?></option>
							<?php } ?>
						</select>
					</div>
				<?php } ?>

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
			$hide_page_title = false;
			if ( isset( $_POST['boombox_hide_page_title'] ) ) {
				$hide_page_title = $_POST['boombox_hide_page_title'] ? true : false;
			}
			update_post_meta( $post_id, 'boombox_hide_page_title', (int) $hide_page_title );

			$show_strip = false;
			if ( isset( $_POST['boombox_show_strip'] ) ) {
				$show_strip = $_POST['boombox_show_strip'] ? true : false;
			}
			update_post_meta( $post_id, 'boombox_show_strip', (int) $show_strip );

			$show_featured_area = false;
			if ( isset( $_POST['boombox_show_featured_area'] ) ) {
				$show_featured_area = $_POST['boombox_show_featured_area'] ? true : false;
			}
			update_post_meta( $post_id, 'boombox_show_featured_area', (int) $show_featured_area );

			if ( isset( $_POST['boombox_listing_type'] ) ) {
				$listing_type = sanitize_text_field( $_POST['boombox_listing_type'] );
				update_post_meta( $post_id, 'boombox_listing_type', $listing_type );
			}

			if ( isset( $_POST['boombox_three_column_sidebar_position'] ) ) {
				$three_column_sidebar_position = sanitize_text_field( $_POST['boombox_three_column_sidebar_position'] );
				update_post_meta( $post_id, 'boombox_three_column_sidebar_position', $three_column_sidebar_position );
			}

			if ( isset( $_POST['boombox_listing_condition'] ) ) {
				$listing_condition = sanitize_text_field( $_POST['boombox_listing_condition'] );
				update_post_meta( $post_id, 'boombox_listing_condition', $listing_condition );
			}

			if ( isset( $_POST['boombox_listing_time_range'] ) ) {
				$listing_time_range = sanitize_text_field( $_POST['boombox_listing_time_range'] );
				update_post_meta( $post_id, 'boombox_listing_time_range', $listing_time_range );
			}

			$listing_categories = '';
			if ( isset( $_POST['boombox_listing_categories'] ) ) {
				$listing_categories = $_POST['boombox_listing_categories'];
			}
			update_post_meta( $post_id, 'boombox_listing_categories', $listing_categories );

			$listing_tags = '';
			if ( isset( $_POST['boombox_listing_tags'] ) ) {
				$listing_tags = $_POST['boombox_listing_tags'];
			}
			update_post_meta( $post_id, 'boombox_listing_tags', $listing_tags );

			if ( isset( $_POST['boombox_pagination_type'] ) ) {
				$pagination_type = sanitize_text_field( $_POST['boombox_pagination_type'] );
				update_post_meta( $post_id, 'boombox_pagination_type', $pagination_type );
			}

			if ( isset( $_POST['boombox_posts_per_page'] ) ) {
				$posts_per_page = (int) $_POST['boombox_posts_per_page'];
				if ( $posts_per_page <= 0 ) {
					$posts_per_page = get_option( 'posts_per_page' );
				}
				update_post_meta( $post_id, 'boombox_posts_per_page', $posts_per_page );
			}

			if( boombox_is_plugin_active('quick-adsense-reloaded/quick-adsense-reloaded.php') ){
				if ( isset( $_POST['boombox_page_ad'] ) ) {
					$page_ad = sanitize_text_field( $_POST['boombox_page_ad'] );
					update_post_meta( $post_id, 'boombox_page_ad', $page_ad );
				}

				if ( isset( $_POST['boombox_inject_ad_instead_post'] ) ) {
					$inject_ad_instead_post = (int) $_POST['boombox_inject_ad_instead_post'];
					if ( $inject_ad_instead_post <= 0 ) {
						$inject_ad_instead_post = 1;
					}
					update_post_meta( $post_id, 'boombox_inject_ad_instead_post', $inject_ad_instead_post );
				}
			}

			if( boombox_is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php') ){
				if ( isset( $_POST['boombox_page_newsletter'] ) ) {
					$page_newsletter = sanitize_text_field( $_POST['boombox_page_newsletter'] );
					update_post_meta( $post_id, 'boombox_page_newsletter', $page_newsletter );
				}

				if ( isset( $_POST['boombox_inject_newsletter_instead_post'] ) ) {
					$inject_newsletter_instead_post = (int) $_POST['boombox_inject_newsletter_instead_post'];
					if ( $inject_newsletter_instead_post <= 0 ) {
						$inject_newsletter_instead_post = 1;
					}
					update_post_meta( $post_id, 'boombox_inject_newsletter_instead_post', $inject_newsletter_instead_post );
				}
			}

			$sidebar_template = '';
			if ( isset( $_POST['boombox_sidebar_template'] ) ) {
				$sidebar_template = sanitize_text_field( $_POST['boombox_sidebar_template'] );
			}
			update_post_meta( $post_id, 'boombox_sidebar_template', $sidebar_template );

		}

		/**
		 * Get trending page id by type
		 *
		 * @param $type 'trending' |'hot' |'popular'
		 *
		 * @return int|mixed
		 */
		public function get_trending_page_id( $type ){
			$trending_page_id = 0;
			$customize_setting_slug = "settings_{$type}_page";
			$settings_trending_page  = boombox_get_theme_option( $customize_setting_slug );
			if( is_string( $settings_trending_page ) ){
				$trending_page_slug = esc_html( $settings_trending_page );
				$trending_page = get_page_by_path( $trending_page_slug );
				if ( null != $trending_page ){
					return $trending_page->ID;
				}
			}elseif( is_numeric( $settings_trending_page ) ){
				return $settings_trending_page;
			}
			return $trending_page_id;
		}

		/**
		 * Return true, if is admin trending page
		 *
		 * @param $post
		 *
		 * @return bool
		 */
		public function is_trending_admin_page_template( $post ){
			global $current_screen;
			$trending_page_id = $this->get_trending_page_id( 'trending' );
			$hot_page_id      = $this->get_trending_page_id( 'hot' );
			$popular_page_id  = $this->get_trending_page_id( 'popular' );
			$template_file = get_post_meta($post->ID,'_wp_page_template',true);
			if( 'page' == $current_screen->post_type && 'page-trending-result.php' == $template_file && ( $trending_page_id || $hot_page_id || $popular_page_id) ){
				return true;
			}
			return false;
		}
	}
}

Boombox_Custom_Page_Meta_Box::get_instance();