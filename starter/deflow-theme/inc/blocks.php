<?php
/* Blocks */

defined( 'ABSPATH' ) || exit;

/* Register blocks */
function dfl_register_blocks() {
	foreach ( glob( DFL_DIR . '/blocks/*/block.json' ) ?: array() as $file ) {
		register_block_type( dirname( $file ) );
	}
}
add_action( 'init', 'dfl_register_blocks' );
