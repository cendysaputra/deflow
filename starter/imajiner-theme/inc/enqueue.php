<?php
/* Enqueue */

defined( 'ABSPATH' ) || exit;

/* Front assets */
function imj_enqueue_assets() {
	$deps = wp_style_is( 'astra-theme-css', 'registered' ) ? array( 'astra-theme-css' ) : array();

	foreach ( array( 'tokens', 'base', 'utilities', 'components' ) as $name ) {
		$path = 'assets/css/' . $name . '.css';
		wp_enqueue_style( 'imj-' . $name, imj_asset_url( $path ), $deps, imj_asset_version( $path ) );
		$deps = array( 'imj-' . $name );
	}

	$js = 'assets/js/main.js';
	wp_enqueue_script(
		'imj-main',
		imj_asset_url( $js ),
		array(),
		imj_asset_version( $js ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'imj_enqueue_assets', 20 );
