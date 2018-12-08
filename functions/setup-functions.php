<?php

// Remove unnecessary scripts/css from WordPress header.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );

// Hide the contact form 7 css and scripts initially.
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

// Remove unnecessary link tags in the WordPress header.
add_filter( 'xmlrpc_enabled', '__return_false' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

// Remove the Optimised by Yoast comment in header.
if (defined('WPSEO_VERSION')) {
	add_action('get_header',function (){
		ob_start(function ($o){
			$o = preg_replace('/\n?<.*?yoast.*?>/mi','',$o);
			return $o;
		}); 
	});
	
	add_action('wp_head',function (){ ob_end_flush(); }, 999);
}

// Hides extra plugin styles.
add_action( 'wp_print_styles', 'hide_extra_style_blocks' );
function hide_extra_style_blocks() {
	wp_deregister_style('contact-form-7');
	wp_deregister_style('wpgmaps-style');
}

add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'wpse_233129_custom_menu_order' );
function wpse_233129_custom_menu_order() {
    return array( 'index.php', 'upload.php' );
}
	
// Removes the recent comments inline style tag in header.
add_action( 'widgets_init', 'basetheme_remove_recent_comments_style' );
function basetheme_remove_recent_comments_style() {  
    global $wp_widget_factory;  
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );  
}

// Compile the less files via PHP and then served the cached file.
add_action( 'wp_print_styles', 'compile_less_files_to_css' );
function compile_less_files_to_css() {
    require_once __DIR__ . '/../lib/less.php-master/lessc.inc.php';
    
	$theme_path = str_replace("\\functions", "", realpath(dirname(__FILE__)));

	$to_cache = array( $theme_path . "/../css/less/style.less" => get_bloginfo('wpurl') );
	Less_Cache::$cache_dir = $theme_path . "/../css/less/cache";
	
	Less_Cache::CleanCache();
	
	$parser_options['sourceMap']		= true;
	
	$vars = array("base_path" => '"' . get_bloginfo('wpurl') . '"');
	
	$css_file_name = Less_Cache::Get( $to_cache, $parser_options, $vars);
	
	wp_enqueue_style( 'style', get_template_directory_uri() . "/css/less/cache/" . $css_file_name );
}

// A title filter to return a correct title.
add_filter( 'the_title', 'basetheme_title' );
function basetheme_title( $title ) {
	if ( $title == '' ) {
		return '&rarr;';
	} else {
		return $title;
	}
}

// A filter title for main website.
add_filter( 'wp_title', 'basetheme_filter_wp_title' );
function basetheme_filter_wp_title( $title ) {
	return $title . esc_attr( get_bloginfo( 'name' ) );
}

// Change the more on the excerpt to three dots.
add_filter('excerpt_more', 'change_excerpt');
function change_excerpt( $more ) {
    return '...';
}

// Initalise a sidebar, html5 compliant.
add_action( 'widgets_init', 'basetheme_widgets_init' );
function basetheme_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Sidebar Widget Area', 'basetheme' ),
		'id' => 'primary-sidebar',
		'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
		'after_widget' => "</section>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

// Add a basetheme dashboard widget
add_action( 'wp_dashboard_setup', 'basetheme_add_dashboard_widgets' );
function basetheme_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'basetheme_dashboard_widget',            // Widget slug.
		'Hello!',    				             // Title.
		'basetheme_dashboard_widget_function'    // Display function.
    );
}

function basetheme_dashboard_widget_function() {
	echo "
	<p><strong>How to add new cards.</strong></p>
	<ul>
		<li>1) Click the cards menu item down the left hand side.</li>
		<li>2) Click add new to add a new card.</li>
		<li>3) Fill in the information for your new monster card and click publish.</li>
		<li>4) Your new card will now be inside the top trumps game!</li>
	</ul>
	";
}


// Remove default dashboard widgets
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['wpseo-dashboard-overview']);
}




//Recommend required plugins on theme activation.
require_once __DIR__ . '/../lib/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'basetheme_register_required_plugins' );
function basetheme_register_required_plugins() {

    $plugins = array(
 		array(
			'name'               => 'Advanced Custom Fields Pro', // The plugin name.
			'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory() . '/lib/plugins/advanced-custom-fields-pro.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		),
    );


    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'basetheme-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );
}

// Removes the nagging of updates in the admin section.
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');
function remove_core_updates(){
	global $wp_version;
	return(object) array( 'last_checked' => time(), 'version_checked' => $wp_version);
}

// Removes certain nodes on the WP admin bars.
add_action( 'admin_bar_menu', 'basetheme_cleanup_admin_bar', 999 );
function basetheme_cleanup_admin_bar( $wp_admin_bar ) {	
	$wp_admin_bar->remove_node( 'wp-logo' );
	$wp_admin_bar->remove_node( 'comments' );
}

// Removes the contextual help in the admin area.
add_filter( 'contextual_help', 'basetheme_remove_help_tabs', 999, 3 );
function basetheme_remove_help_tabs($old_help, $screen_id, $screen){
    $screen->remove_help_tabs();
    return $old_help;
}

// Remove the update nag.
add_action( 'admin_init', function(){ remove_action( 'admin_notices', 'update_nag', 3 ); } );

// Remove the wp logo in admin footer.
add_action('admin_bar_menu', 'remove_wp_logo', 999);
function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node('wp-logo');
}

// Removing the version from admin footer.
add_filter( 'update_footer', 'remove_footer_version', 9999 );
function remove_footer_version() {
    return '';
}
	
// Adds basetheme to the admin footer instead.
add_filter('admin_footer_text', 'basetheme_wordpress_developer_link');
function basetheme_wordpress_developer_link() {
    echo '<span id="footer-thankyou">Top Trumps!</span>';
}

// Standard nav walker for menus, so we can specify our own classes.
class Walker_Standard_Menu extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes = "";
		
		if(isset($item->classes)) {
			foreach($item->classes as $class) {
				$classes .= $class . " ";				
			}
		}
		
		if($item->object_id == get_the_ID()) {
			$classes .= "current ";
		}
		
		$classes = trim($classes);
		
		if(!empty($item->target)) {
			$output .= sprintf( "<li itemprop='name' class='%s'><a target='%s' itemprop='url' href='%s'>%s</a>", $classes, $item->target, $item->url, $item->title );
		} else {
			$output .= sprintf( "<li itemprop='name' class='%s'><a itemprop='url' href='%s'>%s</a>", $classes, $item->url, $item->title );
		}
    }
	
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

}

// Adds defaults for the breadcrumb nav xt plugin.
add_filter( 'bcn_settings_init', 'filter_bcn_settings_init', 10, 1 );
function filter_bcn_settings_init( $opt ) {
	
	$opt['bmainsite_display'] = true;
  	$opt['Hmainsite_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to %title%." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Hmainsite_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['bhome_display'] = true;
  	$opt['Hhome_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to %title%." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Hhome_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['bblog_display'] = true;
  	$opt['Hblog_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to %title%." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Hblog_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['hseparator'] = ' &gt; ';
  	$opt['bcurrent_item_linked'] = false;
  	$opt['Hpost_page_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to %title%." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Hpost_page_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['Hpost_post_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to %title%." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Hpost_post_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['Hpost_attachment_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to %title%." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Hpost_attachment_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['H404_template'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['Htax_post_tag_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to the %title% tag archives." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Htax_post_tag_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['Htax_post_format_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to the %title% archives." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Htax_post_format_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['Hauthor_template'] = 'Articles by: <a title="Go to the first page of posts by %title%." href="%link%" class="%type%">%htitle%</a>';
  	$opt['Htax_category_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to the %title% category archives." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Htax_category_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['Hdate_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to the %title% archives." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Hdate_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['Hpost_acf-field-group_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to %title%." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Hpost_acf-field-group_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['Hpost_acf-field_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to %title%." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Hpost_acf-field_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  	$opt['Hpost_wpcf7_contact_form_template'] = '<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to %title%." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>';
  	$opt['Hpost_wpcf7_contact_form_template_no_anchor'] = '<span property="itemListElement" typeof="ListItem"><span property="name">%htitle%</span><meta property="position" content="%position%"></span>';
  
	return $opt;
}


// Custom dashboard styles.
function admin_style() {
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

function remove_menus() {
	remove_menu_page( 'jetpack' );                    //Jetpack* 
	remove_menu_page( 'edit.php' );                   //Posts
	remove_menu_page( 'upload.php' );                 //Media
	remove_menu_page( 'edit.php?post_type=page' );    //Pages
	remove_menu_page( 'edit-comments.php' );          //Comments
}
add_action( 'admin_menu', 'remove_menus' );


add_filter('style_loader_tag', 'basetheme_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'basetheme_remove_type_attr', 10, 2);
function basetheme_remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

// Register Custom Post Type
function top_trump_cards() {

	$labels = array(
		'name'                  => _x( 'Cards', 'Post Type General Name', 'basetheme' ),
		'singular_name'         => _x( 'Card', 'Post Type Singular Name', 'basetheme' ),
		'menu_name'             => __( 'Cards', 'basetheme' ),
		'name_admin_bar'        => __( 'Card', 'basetheme' ),
		'archives'              => __( 'Card Archives', 'basetheme' ),
		'attributes'            => __( 'Card Attributes', 'basetheme' ),
		'parent_item_colon'     => __( 'Parent Card:', 'basetheme' ),
		'all_items'             => __( 'All Cards', 'basetheme' ),
		'add_new_item'          => __( 'Add New Card', 'basetheme' ),
		'add_new'               => __( 'Add New', 'basetheme' ),
		'new_item'              => __( 'New Card', 'basetheme' ),
		'edit_item'             => __( 'Edit Card', 'basetheme' ),
		'update_item'           => __( 'Update Card', 'basetheme' ),
		'view_item'             => __( 'View Card', 'basetheme' ),
		'view_items'            => __( 'View Cards', 'basetheme' ),
		'search_items'          => __( 'Search Card', 'basetheme' ),
		'not_found'             => __( 'Not found', 'basetheme' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'basetheme' ),
		'featured_image'        => __( 'Featured Image', 'basetheme' ),
		'set_featured_image'    => __( 'Set featured image', 'basetheme' ),
		'remove_featured_image' => __( 'Remove featured image', 'basetheme' ),
		'use_featured_image'    => __( 'Use as featured image', 'basetheme' ),
		'insert_into_item'      => __( 'Insert into Card', 'basetheme' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Card', 'basetheme' ),
		'items_list'            => __( 'Cards list', 'basetheme' ),
		'items_list_navigation' => __( 'Cards list navigation', 'basetheme' ),
		'filter_items_list'     => __( 'Filter Cards list', 'basetheme' ),
	);
	$rewrite = array(
		'slug'                  => 'card',
		'with_front'            => true,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'Card', 'basetheme' ),
		'description'           => __( 'Omni Cards', 'basetheme' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 4,
		'menu_icon'             => 'dashicons-list-view',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => false,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'cards', $args );

}
add_action( 'init', 'top_trump_cards', 0 );