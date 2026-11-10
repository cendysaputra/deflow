<?php
/* Blocks */

defined( 'ABSPATH' ) || exit;

/* Register blocks */
function imj_register_blocks() {
	foreach ( glob( IMJ_DIR . '/blocks/*/block.json' ) ?: array() as $file ) {
		register_block_type( dirname( $file ) );
	}
}
add_action( 'init', 'imj_register_blocks' );
