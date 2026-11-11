<?php
/* Enqueue */

defined( 'ABSPATH' ) || exit;

/* Library assets */
function {{prefix}}_register_assets() {
	$libraries = array(
		'swiper'    => array( '14.3.0', 'swiper-bundle.min' ),
		'glightbox' => array( '3.3.1', 'glightbox.min' ),
	);

	foreach ( $libraries as $name => $library ) {
		$base = 'assets/vendor/' . $name . '/' . $library[1];
		wp_register_style( '{{prefix}}-' . $name, {{prefix}}_asset_url( $base . '.css' ), array( '{{prefix}}-components' ), $library[0] );
		wp_register_script( '{{prefix}}-' . $name, {{prefix}}_asset_url( $base . '.js' ), array(), $library[0], true );
	}

	$features = array(
		'slider'   => 'swiper',
		'marquee'  => 'swiper',
		'lightbox' => 'glightbox',
	);

	foreach ( $features as $feature => $library ) {
		$path = 'assets/js/' . $feature . '.js';
		wp_register_script(
			'{{prefix}}-' . $feature,
			{{prefix}}_asset_url( $path ),
			array( '{{prefix}}-' . $library ),
			{{prefix}}_asset_version( $path ),
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', '{{prefix}}_register_assets', 5 );

/* Front assets */
function {{prefix}}_enqueue_assets() {
	$deps = wp_style_is( 'astra-theme-css', 'registered' ) ? array( 'astra-theme-css' ) : array();

	foreach ( array( 'tokens', 'base', 'utilities', 'components' ) as $name ) {
		$path = 'assets/css/' . $name . '.css';
		wp_enqueue_style( '{{prefix}}-' . $name, {{prefix}}_asset_url( $path ), $deps, {{prefix}}_asset_version( $path ) );
		$deps = array( '{{prefix}}-' . $name );
	}

	$js = 'assets/js/main.js';
	wp_enqueue_script(
		'{{prefix}}-main',
		{{prefix}}_asset_url( $js ),
		array(),
		{{prefix}}_asset_version( $js ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', '{{prefix}}_enqueue_assets', 20 );

/* Feature assets */
function {{prefix}}_use( $feature ) {
	$library = array(
		'slider'   => 'swiper',
		'marquee'  => 'swiper',
		'lightbox' => 'glightbox',
	);

	if ( empty( $library[ $feature ] ) ) {
		return;
	}

	wp_enqueue_style( '{{prefix}}-' . $library[ $feature ] );
	wp_enqueue_script( '{{prefix}}-' . $feature );
}
