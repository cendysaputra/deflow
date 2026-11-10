<?php
/* Helpers */

defined( 'ABSPATH' ) || exit;

/* Asset URL */
function imj_asset_url( $path ) {
	return IMJ_URI . '/' . ltrim( $path, '/' );
}

/* Asset version */
function imj_asset_version( $path ) {
	$file = IMJ_DIR . '/' . ltrim( $path, '/' );

	return file_exists( $file ) ? (string) filemtime( $file ) : wp_get_theme()->get( 'Version' );
}

/* Safe ACF getter */
function imj_field( $name, $post_id = false, $format = true ) {
	return function_exists( 'get_field' ) ? get_field( $name, $post_id, $format ) : null;
}

/* Global field */
function imj_global( $name ) {
	static $source = null;

	if ( null === $source ) {
		$page   = function_exists( 'acf_add_options_page' ) ? null : get_page_by_path( 'global' );
		$source = $page ? $page->ID : 'option';
	}

	return imj_field( $name, $source );
}

/* Component loader */
function imj_component( $name, $args = array() ) {
	get_template_part( 'template-parts/components/' . $name, null, $args );
}

/* Section loader */
function imj_section( $name, $args = array() ) {
	get_template_part( 'template-parts/sections/' . $name, null, $args );
}
