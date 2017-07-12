<?php
/**
 * Register an attachment meta box using a class.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

if ( ! class_exists( 'Boombox_Custom_Attachment_Meta_Box' ) ) {

    class Boombox_Custom_Attachment_Meta_Box {

        private $post = null;
        private $postmeta = array();

        /**
        * Constructor.
        */
        public function __construct() {
            add_action( 'load-post.php', array( $this, 'init_metabox' ) );
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

        public function init_metabox() {

            add_action( 'add_meta_boxes', array( $this, 'add_metabox' ), 1, 2 );
            add_action( 'admin_print_styles-post.php', array( $this, 'post_attachment_admin_enqueue_scripts' ) );

        }

        /**
         * Enqueue Scripts and Styles
         */
        public function post_attachment_admin_enqueue_scripts() {
            global $current_screen;
            if ( isset( $current_screen ) && 'attachment' === $current_screen->id ) {
                wp_enqueue_style( 'boombox-admin-meta-style', BOOMBOX_ADMIN_URL . 'metaboxes/css/boombox-metabox-style.css' );
                wp_enqueue_script( 'boombox-admin-meta-script', BOOMBOX_ADMIN_URL . 'metaboxes/js/boombox-metabox-script.js' );
            }
        }

        /**
         * Add the meta box.
         */
        public function add_metabox( $post_type, $post ) {

            if( "attachment" == $post_type && "image/gif" == $post->post_mime_type ) {

                $this->post = $post;
                $this->postmeta = get_post_meta($post->ID);
                /**
                 * Add Advanced Fields to Page screen
                 */
                add_meta_box(
                    'boombox-attachment-metabox',
                    __('Boombox Attachment Advanced Fields', 'boombox'),
                    array($this, 'render_metabox'),
                    'attachment',
                    'normal',
                    'high'
                );
            }
        }

        /**
         * Render the advances fields meta box.
         *
         * @param $post
         */
        public function render_metabox( $post ) {

            $mp4_url = isset( $this->postmeta['mp4_url'][0] ) ? $this->postmeta['mp4_url'][0] : '';
            $jpg_url = isset( $this->postmeta['jpg_url'][0] ) ? $this->postmeta['jpg_url'][0] : '';

            ?>
            <div class="boombox-post-advanced-fields">

                <?php // Video URL ( Format: mp4 ) ?>
                <div class="boombox-post-form-row">
                    <label for="boombox_video_url"><?php esc_html_e( 'Video URL ( mp4 )', 'boombox' ); ?></label>
                    <input type="text" id="boombox_video_url" readonly value="<?php echo esc_html( $mp4_url ); ?>"/>
                </div>

                <?php // Image URL ( Format: jpg ) ?>
                <div class="boombox-post-form-row">
                    <label for="boombox_video_url"><?php esc_html_e( 'Image URL ( jpg )', 'boombox' ); ?></label>
                    <input type="text" id="boombox_video_url" readonly value="<?php echo esc_html( $jpg_url ); ?>"/>
                </div>

            </div>
            <?php
        }

    }
}

Boombox_Custom_Attachment_Meta_Box::get_instance();