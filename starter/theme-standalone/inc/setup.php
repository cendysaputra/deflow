<?php
/* Setup */

defined( 'ABSPATH' ) || exit;

/* Theme support */
function imj_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );

	if ( class_exists( 'WooCommerce' ) ) {
		add_theme_support( 'woocommerce' );
	}

	register_nav_menus(
		array(
			'primary' => __( 'Menu utama', 'imajiner-theme' ),
			'footer'  => __( 'Menu footer', 'imajiner-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'imj_setup' );
