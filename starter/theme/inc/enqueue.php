<?php
/* Enqueue */

defined( 'ABSPATH' ) || exit;

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
