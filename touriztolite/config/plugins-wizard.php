<?php

add_action( 'init', 'touriztolite_plugins_wizard_config', 9 );

/**
 * Register Jet Plugins Wizards config
 * @return void
 */
function touriztolite_plugins_wizard_config() {

	if ( ! is_admin() ) {
		return;
	}

	if ( ! function_exists( 'jet_plugins_wizard_register_config' ) ) {
		return;
	}

	jet_plugins_wizard_register_config( array(
		'license' => array(
			'enabled' => false,
		),
		'plugins' => array(
			'jet-data-importer' => array(
				'name'   => esc_html__( 'Jet Data Importer', 'touriztolite' ),
				'source' => 'remote',
				'path'   => 'https://github.com/ZemezLab/jet-data-importer/archive/master.zip',
				'access' => 'skins',
			),
			'elementor' => array(
				'name'   => esc_html__( 'Elementor Page Builder', 'touriztolite' ),
				'access' => 'skins',
			),
			'contact-form-7' => array(
				'name'   => esc_html__( 'Contact Form 7', 'touriztolite' ),
				'access' => 'skins',
			),
		),
		'skins'   => array(
			'advanced' => array(
				'default' => array(
					'full'  => array(
						'jet-data-importer',
						'elementor',
						'contact-form-7',
					),
					'lite'  => false,
					'demo'  => 'http://ld-wp.template-help.com/wordpress_free/23563',
					'thumb' => get_template_directory_uri() . '/assets/demo-content/default/default-thumb.png',
					'name'  => esc_html__( 'Touriztolite', 'touriztolite' ),
				),
			),
		),
		'texts'   => array(
			'theme-name' => esc_html__( 'Touriztolite', 'touriztolite' ),
		)
	) );
}
