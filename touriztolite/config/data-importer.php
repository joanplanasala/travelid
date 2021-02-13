<?php
add_action( 'init', 'touriztolite_data_importer_config', 9 );

/**
 * Register Jet Data Importer config
 * @return void
 */
function touriztolite_data_importer_config() {

	if ( ! is_admin() ) {
		return;
	}

	if ( ! function_exists( 'jet_data_importer_register_config' ) ) {
		return;
	}

	jet_data_importer_register_config( array(
		'xml' => false,
		'slider' => array(
			'path' => 'https://raw.githubusercontent.com/JetImpex/wizard-slides/master/slides.json',
		),
		'success-links' => array(
			'home' => array(
				'label'  => __( 'View your site', 'touriztolite' ),
				'type'   => 'primary',
				'target' => '_self',
				'url'    => home_url( '/' ),
			),
		),
		'export' => array(
			'options' => array(
				'site_icon',
				'elementor_cpt_support',
				'elementor_disable_color_schemes',
				'elementor_disable_typography_schemes',
				'elementor_container_width',
				'elementor_css_print_method',
				'elementor_global_image_lightbox',
				'elementor_space_between_widgets',
			),
		),
		'advanced_import' => array(
			'default' => array(
				'full'    => get_template_directory() . '/assets/demo-content/default/default-full.xml',
				'lite'    => false,
				'thumb'   => get_template_directory_uri() . '/assets/demo-content/default/default-thumb.png',
				'plugins' => false,
			),
		),
	) );
}