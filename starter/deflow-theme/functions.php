<?php
/* Deflow Theme */

defined( 'ABSPATH' ) || exit;

define( 'DFL_DIR', get_stylesheet_directory() );
define( 'DFL_URI', get_stylesheet_directory_uri() );

foreach ( array( 'helpers', 'enqueue', 'acf', 'blocks' ) as $dfl_file ) {
	require_once DFL_DIR . '/inc/' . $dfl_file . '.php';
}
