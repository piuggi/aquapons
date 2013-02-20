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
        'menu_position' => 5,
        
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

    register_post_type( 'resource', $args );
}

?>