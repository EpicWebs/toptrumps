<?php

/** 
* Includes
**/

// Utility PHP functions
require('functions/utility-functions.php');

// The initial base setup of WordPress (removes extraneous bits)
require('functions/setup-functions.php');

// Creates menus for the admin area, Appearance > Menus
require('functions/menu-functions.php');

// Dequeue/Enqueue scripts on the front end
require('functions/enqueue_scripts-functions.php');

// Setup the options page and default fields
require('functions/global_text-functions.php');

// Setup text formats for the wysiwyg editor
require('functions/wysiwyg_formats-functions.php');

if ( is_admin() ) {
    add_action( 'wp_ajax_get-card-data', 'return_card_data' );
    add_action( 'wp_ajax_nopriv_get-card-data', 'return_card_data' );

    function return_card_data() {
        $ajax_check = check_ajax_referer('dnd-get-card-data', '_wpnonce', false);
            
        $card_id = filter_input( INPUT_POST, 'card_id', FILTER_SANITIZE_NUMBER_INT);

        $image = get_field('image', $card_id);

        $card = array(
            "card_id" => $card_id,
            "name" => get_the_title($card_id),
            "image_url" => $image['sizes']['medium'],
            "description" => get_field('description', $card_id),
            "strength" => get_field('strength', $card_id),
            "dexterity" => get_field('dexterity', $card_id),
            "constitution" => get_field('constitution', $card_id),
            "intelligence" => get_field('intelligence', $card_id),
            "wisdom" => get_field('wisdom', $card_id),
            "charisma" => get_field('charisma', $card_id),
        );

        echo json_encode( $card );

        wp_die();
    }
}