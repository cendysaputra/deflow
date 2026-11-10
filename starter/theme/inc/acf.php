<?php
/* ACF */

defined( 'ABSPATH' ) || exit;

/* Local JSON save */
function {{prefix}}_acf_json_save() {
	return {{PREFIX}}_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', '{{prefix}}_acf_json_save' );

/* Local JSON load */
function {{prefix}}_acf_json_load() {
	return array( {{PREFIX}}_DIR . '/acf-json' );
}
add_filter( 'acf/settings/load_json', '{{prefix}}_acf_json_load' );
