<?php
/* Blocks */

defined( 'ABSPATH' ) || exit;

/* Register blocks */
function {{prefix}}_register_blocks() {
	foreach ( glob( {{PREFIX}}_DIR . '/blocks/*/block.json' ) ?: array() as $file ) {
		register_block_type( dirname( $file ) );
	}
}
add_action( 'init', '{{prefix}}_register_blocks' );
