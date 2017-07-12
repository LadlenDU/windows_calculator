<?php
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Boombox_Customize_Control_Select_Optgroup' ) ) {
	/**
	 * Boombox Multiple select customize control class.
	 */
	class Boombox_Customize_Control_Select_Optgroup extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered.
		 */
		public $type = 'select-optgroup';

		/**
		 * Displays the multiple select on the customize screen.
		 */
		public function render_content() {

			if ( empty( $this->choices ) )
				return;

			?>
			<label>
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif;
				if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>

				<select <?php $this->link(); ?>>
					<?php
					foreach ( $this->choices as $group => $data ) {

						echo '<optgroup label="' . $data['title'] . '">';

						foreach( $data['choices'] as $value => $label) {
							echo '<option value="' . esc_attr( $value ) . '"' . selected( in_array( $value, (array)$this->value(), true ), true, false ) . '>' . $label . '</option>';
						}

						echo '</optgroup>';
					}
					?>
				</select>
			</label>
		<?php }
}
}