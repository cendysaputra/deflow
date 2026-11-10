<?php
/* {{PROJECT_NAME}} Theme */

defined( 'ABSPATH' ) || exit;

define( '{{PREFIX}}_DIR', get_stylesheet_directory() );
define( '{{PREFIX}}_URI', get_stylesheet_directory_uri() );

foreach ( array( 'helpers', 'enqueue', 'acf', 'blocks' ) as ${{prefix}}_file ) {
	require_once {{PREFIX}}_DIR . '/inc/' . ${{prefix}}_file . '.php';
}
