<?php
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Boombox_Custom_Content' ) ) {
	/**
	 * Custom Content class.
	 *
	 * @access public
	 */
	class Boombox_Custom_Content extends WP_Customize_Control {

		public $content = '';

		/**
		 * Render the control's content.
		 *
		 * Allows the content to be overridden without having to rewrite the wrapper.
		 *
		 * @since   1.0.0
		 * @return  void
		 */
		public function render_content() {
			if ( isset( $this->label ) ) {
				echo '<span class="customize-control-title">' . wp_kses_post( $this->label ) . '</span>';
			}
			if ( isset( $this->content ) ) {
				echo wp_kses_post($this->content);
			}
			if ( isset( $this->description ) ) {
				echo '<span class="description customize-control-description">' . wp_kses_post( $this->description ) . '</span>';
			}
		}
	}
}