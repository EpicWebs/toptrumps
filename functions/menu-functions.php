<?php

// Setup the theme and add menus/theme support.
add_action( 'after_setup_theme', 'basetheme_setup' );
function basetheme_setup() {
	load_theme_textdomain( 'basetheme', get_template_directory() . '/languages' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 780;

	register_nav_menus(
		array(
			'main-menu' => __( 'Main Menu', 'basetheme' ),
			'footer-menu' => __( 'Footer Menu', 'basetheme' ),
		)
	);
}