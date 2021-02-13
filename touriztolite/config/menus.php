<?php
/**
 * Menus configuration.
 *
 * @package Touriztolite
 */

add_action( 'after_setup_theme', 'touriztolite_register_menus', 5 );
function touriztolite_register_menus() {

	register_nav_menus( array(
		'main'   => esc_html__( 'Main', 'touriztolite' ),
		'footer' => esc_html__( 'Footer', 'touriztolite' ),
		'social' => esc_html__( 'Social', 'touriztolite' ),
	) );
}
