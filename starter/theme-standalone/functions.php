<?php
/* Imajiner Theme */

defined( 'ABSPATH' ) || exit;

define( 'IMJ_DIR', get_stylesheet_directory() );
define( 'IMJ_URI', get_stylesheet_directory_uri() );

foreach ( array( 'helpers', 'setup', 'enqueue', 'acf', 'blocks' ) as $imj_file ) {
	require_once IMJ_DIR . '/inc/' . $imj_file . '.php';
}
