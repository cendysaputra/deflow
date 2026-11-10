<?php
/* Enqueue */

defined( 'ABSPATH' ) || exit;

/* Front assets */
function dfl_enqueue_assets() {
	$deps = wp_style_is( 'astra-theme-css', 'registered' ) ? array( 'astra-theme-css' ) : array();

	foreach ( array( 'tokens', 'base', 'utilities', 'components' ) as $name ) {
		$path = 'assets/css/' . $name . '.css';
		wp_enqueue_style( 'dfl-' . $name, dfl_asset_url( $path ), $deps, dfl_asset_version( $path ) );
		$deps = array( 'dfl-' . $name );
	}

	$js = 'assets/js/main.js';
	wp_enqueue_script(
		'dfl-main',
		dfl_asset_url( $js ),
		array(),
		dfl_asset_version( $js ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'dfl_enqueue_assets', 20 );
