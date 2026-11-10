<?php
/* ACF */

defined( 'ABSPATH' ) || exit;

/* Local JSON save */
function imj_acf_json_save() {
	return IMJ_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'imj_acf_json_save' );

/* Local JSON load */
function imj_acf_json_load() {
	return array( IMJ_DIR . '/acf-json' );
}
add_filter( 'acf/settings/load_json', 'imj_acf_json_load' );
