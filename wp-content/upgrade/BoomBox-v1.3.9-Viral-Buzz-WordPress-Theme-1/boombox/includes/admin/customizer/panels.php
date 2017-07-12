<?php
/**
 * WP Customizer panel section to handle post options
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

$panels = array(
    array(
        'id'    => 'boombox_design_panel',
        'args'  => array(
            'title'    => esc_html__( 'Design', 'boombox' ),
            'priority' => 200,
        )
    ),
    array(
        'id' => 'boombox_layouts_panel',
        'args' => array(
            'title'    => esc_html__( 'Layouts', 'boombox' ),
            'priority' => 200,
        )
    )
);

return $panels;