<?php

// Unqueue jQuery.
add_action( 'init', 'dequeue_footer_jquery', 1 );
function dequeue_footer_jquery() {
	if ( !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
		if ( ! is_admin() ) {
			wp_deregister_script('jquery');
		}
	}
}

// Add all js scripts.
add_action( 'wp_footer', 'enqueue_footer_jquery', 1);
function enqueue_footer_jquery() {
    // Setup javascript files other files depend on
	wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr.min.js' );
	wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-2.1.4.min.js', array('modernizr') );

	wp_enqueue_script('jquery');
	
    // Only include the contact form 7 JS on a piece of content that uses the CF7 shortcode
	global $post;
	if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'contact-form-7') ) {
		if(function_exists('wpcf7_enqueue_scripts')) {
			wpcf7_enqueue_scripts();
		}
	}
}