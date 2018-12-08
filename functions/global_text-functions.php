<?php

// Add an ACF website settings option page.
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page('Website Settings');
}

// Add some default fields for the website settings section.
if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array (
	'key' => 'group_561f83860c9ef',
	'title' => 'Global Settings',
	'fields' => array (
		array (
			'key' => 'contact_information',
			'label' => 'Contact Information',
			'name' => 'contact_information',
			'type' => 'tab',
			'placement' => 'left',
		),
		array (
			'key' => 'telephone_number',
			'label' => 'Telephone Number',
			'name' => 'telephone_number',
			'type' => 'text',
		),
		array (
			'key' => 'postal_address',
			'label' => 'Address',
			'name' => 'postal_address',
			'type' => 'text',
		),
		array (
			'key' => 'email_address',
			'label' => 'Email Address',
			'name' => 'email_address',
			'type' => 'text',
		),
		array (
			'key' => 'social_media_information',
			'label' => 'Social Media Information',
			'name' => 'social_media_information',
			'type' => 'tab',
			'placement' => 'left',
		),
		array (
			'key' => 'twitter_link',
			'label' => 'Twitter Link',
			'name' => 'twitter_link',
			'type' => 'text',
		),
		array (
			'key' => 'linkedin_link',
			'label' => 'Linkedin Link',
			'name' => 'linkedin_link',
			'type' => 'text',
		),
		array (
			'key' => 'facebook_link',
			'label' => 'Facebook Link',
			'name' => 'facebook_link',
			'type' => 'text',
		),
		array (
			'key' => 'dribbble_link',
			'label' => 'Dribbble Link',
			'name' => 'dribbble_link',
			'type' => 'text',
		),
		array (
			'key' => 'behance_link',
			'label' => 'Behance Link',
			'name' => 'behance_link',
			'type' => 'text',
		),
		array (
			'key' => 'instagram_link',
			'label' => 'Instagram Link',
			'name' => 'instagram_link',
			'type' => 'text',
		),
		array (
			'key' => 'pinterest_link',
			'label' => 'Pinterest Link',
			'name' => 'pinterest_link',
			'type' => 'text',
		),
		array (
			'key' => 'google-plus_link',
			'label' => 'Google+ Link',
			'name' => 'google-plus_link',
			'type' => 'text',
		),
		array (
			'key' => 'scripts',
			'label' => 'Scripts',
			'name' => 'scripts',
			'type' => 'tab',
			'placement' => 'left',
		),
		array (
			'key' => 'third_party_scripts',
			'label' => 'Third Party Scripts',
			'name' => 'third_party_scripts',
			'type' => 'textarea',
            'instructions' => 'These will be placed in the footer of the website, useful for things like Google Analytics.',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-website-settings',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;