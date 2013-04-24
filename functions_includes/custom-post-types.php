<?php


add_action( 'init', 'register_cpt_badge' );
add_theme_support( 'post-thumbnails' );

function register_cpt_badge() {

    $labels = array( 
        'name' => _x( 'Badges', 'badge' ),
        'singular_name' => _x( 'Badge', 'badge' ),
        'add_new' => _x( 'Add New', 'badge' ),
        'add_new_item' => _x( 'Add New Badge', 'badge' ),
        'edit_item' => _x( 'Edit Badge', 'badge' ),
        'new_item' => _x( 'New Badge', 'badge' ),
        'view_item' => _x( 'View Badge', 'badge' ),
        'search_items' => _x( 'Search Badges', 'badge' ),
        'not_found' => _x( 'No badges found', 'badge' ),
        'not_found_in_trash' => _x( 'No badges found in Trash', 'badge' ),
        'parent_item_colon' => _x( 'Parent Badge:', 'badge' ),
        'menu_name' => _x( 'Badges', 'badge' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category', 'post_tag', 'page-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 1,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'badge', $args );
}

function badge_image_meta_box() {
	global $wp_meta_boxes;
	unset( $wp_meta_boxes['post']['side']['core']['postimagediv'] );
	add_meta_box('postimagediv', __('Badge Image'), 'post_thumbnail_meta_box', 'badge', 'side', 'low');
}
add_action( 'add_meta_boxes', 'badge_image_meta_box', 0 );


add_action( 'init', 'register_cpt_resource' );

function register_cpt_resource() {

    $labels = array( 
        'name' => _x( 'Resources', 'resource' ),
        'singular_name' => _x( 'Resource', 'resource' ),
        'add_new' => _x( 'Add New', 'resource' ),
        'add_new_item' => _x( 'Add New Resource', 'resource' ),
        'edit_item' => _x( 'Edit Resource', 'resource' ),
        'new_item' => _x( 'New Resource', 'resource' ),
        'view_item' => _x( 'View Resource', 'resource' ),
        'search_items' => _x( 'Search Resources', 'resource' ),
        'not_found' => _x( 'No resources found', 'resource' ),
        'not_found_in_trash' => _x( 'No resources found in Trash', 'resource' ),
        'parent_item_colon' => _x( 'Parent Resource:', 'resource' ),
        'menu_name' => _x( 'Resources', 'resource' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'page-attributes' ),
        'taxonomies' => array( 'category', 'post_tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 10,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'resource', $args );
}


add_action( 'init', 'register_cpt_featured_aquapon' );

function register_cpt_featured_aquapon() {

    $labels = array( 
        'name' => _x( 'Featured Aquapons', 'featured_aquapon' ),
        'singular_name' => _x( 'Featured Aquapon', 'featured_aquapon' ),
        'add_new' => _x( 'Add New', 'featured_aquapon' ),
        'add_new_item' => _x( 'Add New Featured Aquapon', 'featured_aquapon' ),
        'edit_item' => _x( 'Edit Featured Aquapon', 'featured_aquapon' ),
        'new_item' => _x( 'New Featured Aquapon', 'featured_aquapon' ),
        'view_item' => _x( 'View Featured Aquapon', 'featured_aquapon' ),
        'search_items' => _x( 'Search Featured Aquapons', 'featured_aquapon' ),
        'not_found' => _x( 'No featured aquapons found', 'featured_aquapon' ),
        'not_found_in_trash' => _x( 'No featured aquapons found in Trash', 'featured_aquapon' ),
        'parent_item_colon' => _x( 'Parent Featured Aquapon:', 'featured_aquapon' ),
        'menu_name' => _x( 'Featured Aquapons', 'featured_aquapon' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'featured_aquapon', $args );
}

add_action('init', 'register_cpt_institution');

function register_cpt_institution(){
	
    $labels = array( 
        'name' => _x( 'Institutions', 'institution' ),
        'singular_name' => _x( 'Institution', 'institution' ),
        'add_new' => _x( 'Add New', 'institution' ),
        'add_new_item' => _x( 'Add New Institution', 'institution' ),
        'edit_item' => _x( 'Edit Institution', 'institution' ),
        'new_item' => _x( 'New Institution', 'institution' ),
        'view_item' => _x( 'View Institutions', 'institution' ),
        'search_items' => _x( 'Search Institutions', 'institution' ),
        'not_found' => _x( 'No Institutions found', 'institution' ),
        'not_found_in_trash' => _x( 'No Institutions found in Trash', 'institution' ),
        'parent_item_colon' => _x( 'Parent Institution:', 'institution' ),
        'menu_name' => _x( 'Institutions', 'institution' ),
    );
    
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 19,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
    
    register_post_type( 'institution', $args );
	
}

add_action('init', 'register_cpt_discussion');

function register_cpt_discussion(){
	
    $labels = array( 
        'name' => _x( 'Discussions', 'discussion' ),
        'singular_name' => _x( 'Discussion', 'discussion' ),
        'add_new' => _x( 'Add New', 'discussion' ),
        'add_new_item' => _x( 'Add New Discussion', 'discussion' ),
        'edit_item' => _x( 'Edit Discussion', 'discussion' ),
        'new_item' => _x( 'New Discussion', 'discussion' ),
        'view_item' => _x( 'View Discussions', 'discussion' ),
        'search_items' => _x( 'Search Discussions', 'discussion' ),
        'not_found' => _x( 'No Discussions found', 'discussion' ),
        'not_found_in_trash' => _x( 'No Discussions found in Trash', 'discussion' ),
        'parent_item_colon' => _x( 'Parent Discussion:', 'discussion' ),
        'menu_name' => _x( 'Discussions', 'discussion' ),
    );
    
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 15,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
    
    register_post_type( 'discussion', $args );
	
}




add_action( 'init', 'register_cpt_tip' );

function register_cpt_tip() {

    $labels = array( 
        'name' => _x( 'Tips', 'tip' ),
        'singular_name' => _x( 'Tip', 'tip' ),
        'add_new' => _x( 'Add New', 'tip' ),
        'add_new_item' => _x( 'Add New Tip', 'tip' ),
        'edit_item' => _x( 'Edit Tip', 'tip' ),
        'new_item' => _x( 'New Tip', 'tip' ),
        'view_item' => _x( 'View Tip', 'tip' ),
        'search_items' => _x( 'Search Tips', 'tip' ),
        'not_found' => _x( 'No tips found', 'tip' ),
        'not_found_in_trash' => _x( 'No tips found in Trash', 'tip' ),
        'parent_item_colon' => _x( 'Parent Tip:', 'tip' ),
        'menu_name' => _x( 'Tips', 'tip' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'custom-fields' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'tip', $args );
}



?>