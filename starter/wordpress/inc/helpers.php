<?php
/* Helpers */

defined( 'ABSPATH' ) || exit;

/* Asset URL */
function {{prefix}}_asset_url( $path ) {
	return {{PREFIX}}_URI . '/' . ltrim( $path, '/' );
}

/* Asset version */
function {{prefix}}_asset_version( $path ) {
	$file = {{PREFIX}}_DIR . '/' . ltrim( $path, '/' );

	return file_exists( $file ) ? (string) filemtime( $file ) : wp_get_theme()->get( 'Version' );
}

/* Safe ACF getter */
function {{prefix}}_field( $name, $post_id = false, $format = true ) {
	return function_exists( 'get_field' ) ? get_field( $name, $post_id, $format ) : null;
}

/* Global field */
function {{prefix}}_global( $name ) {
	static $source = null;

	if ( null === $source ) {
		$page   = function_exists( 'acf_add_options_page' ) ? null : get_page_by_path( 'global' );
		$source = $page ? $page->ID : 'option';
	}

	return {{prefix}}_field( $name, $source );
}

/* Component loader */
function {{prefix}}_component( $name, $args = array() ) {
	get_template_part( 'template-parts/components/' . $name, null, $args );
}

/* Section loader */
function {{prefix}}_section( $name, $args = array() ) {
	get_template_part( 'template-parts/sections/' . $name, null, $args );
}
