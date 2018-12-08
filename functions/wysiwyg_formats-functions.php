<?php

add_filter('mce_buttons_2', 'basetheme_mce_buttons');
function basetheme_mce_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 
function my_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'Intro Text',  
			'block' => 'div',  
			'classes' => 'intro-text',
			'wrapper' => true,
			
		),
		array(  
			'title' => 'Button',  
			'block' => 'div',  
			'classes' => 'wysiwyg-button',
			'wrapper' => true,
			
		),
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
}

add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );
function my_mce_before_init( $init_array ) {
	$init_array['theme_advanced_styles'] =
            'Intro Text=intro_text&Button=wysiwyg_button;';

	return $init_array;
}

function basetheme_add_editor_styles() {
    add_editor_style( 'basetheme-editor-style.css' );
}
add_action( 'admin_init', 'basetheme_add_editor_styles' );
