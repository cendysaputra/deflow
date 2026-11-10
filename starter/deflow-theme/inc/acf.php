<?php
/* ACF */

defined( 'ABSPATH' ) || exit;

/* Local JSON save */
function dfl_acf_json_save() {
	return DFL_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'dfl_acf_json_save' );

/* Local JSON load */
function dfl_acf_json_load() {
	return array( DFL_DIR . '/acf-json' );
}
add_filter( 'acf/settings/load_json', 'dfl_acf_json_load' );
