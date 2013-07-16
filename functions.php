<?php

session_start();

if($_COOKIE['previous_visitor'] != '1') $first_timer = true;
setcookie("previous_visitor", "1", time() + 9999999, '/');

if($_GET['logout']) {
	wp_logout();
	header("Refresh: 0; url=http://aquapons.info");
}

include('functions_includes/custom-post-types.php');

include('functions_includes/badge-ajax.php');

include('functions_includes/misc-functions.php');

include('functions_includes/custom-admin-pages.php');


//$_SESSION['user_id'] = "";
if($_GET['user']) {
	$user_meta = $wpdb->get_row("SELECT * FROM aq_usermeta WHERE user_token_id = '".$_GET['user']."' LIMIT 1");
	$_SESSION['user_id'] = $user_meta->wp_user_id;
	$_SESSION['reviewing'] = true;
}


include(get_stylesheet_directory() . '/php/less.inc.php');
$less = new lessc;
$less->compileFile(get_stylesheet_directory()."/style-main.less", get_stylesheet_directory()."/style-main.css");
//print_r($less);

function load_scripts_styles() {
	global $wp_styles;

	//wp_enqueue_script( 'load-script', get_template_directory_uri() . '/js/scripts.js', array(), '1.0', true );
	
	wp_enqueue_script( 'misc-script', get_template_directory_uri() . '/js/scripts.js', array('jquery'));
	wp_enqueue_script( 'badge-review-script', get_template_directory_uri() . '/js/badges.js', array('jquery'));
	wp_enqueue_script( 'jquery-cycle', get_template_directory_uri(). '/js/jquery.cycle.all.js', array('jquery'));
	wp_enqueue_script( 'load-slideshow',get_template_directory_uri().'/js/slideshow.js',array('jquery'));
	wp_enqueue_script( 'discussion',get_template_directory_uri().'/js/discussion.js',array('jquery'));
	wp_enqueue_script('single-activity', get_template_directory_uri().'/js/single-activity.js', array('jquery'));

	wp_enqueue_style( 'wp-style', get_stylesheet_uri() );
	wp_enqueue_style( 'main-style', get_bloginfo('template_directory') . '/style-main.css' );
}
add_action( 'wp_enqueue_scripts', 'load_scripts_styles' );

if (function_exists( 'add_image_size' ) ) { 
	add_image_size( 'tutorial-thumb', 400, 300, true ); //300 pixels wide (and unlimited height)
}


// Add User Meta Field to DB on user registration

function new_user_add_metainfo($user_id) {
	global $wpdb;
	
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$random_string = '';
	for ($i = 0; $i < 40; $i++) {
		$random_string .= $characters[rand(0, strlen($characters) - 1)];
	}
	
    $wpdb->insert( 
		'aq_usermeta', 
		array( 
			'wp_user_id' => $user_id, 
			'user_token_id' => $random_string 
		)
	);
	
	update_user_meta($user_id, 'private', 0);
}

add_action('user_register', 'new_user_add_metainfo');




// REMOVE ADMIN BAR FOR NON-ADMIN USERS
global $user_level;
if($user_level < 10) {
	add_action('after_setup_theme', 'remove_admin_bar');
	
	function remove_admin_bar() {
		if (!current_user_can('administrator') && !is_admin()) {
			show_admin_bar(false);
		}
	}
}



// ADD PRIVACY META TAG FOR NEW USERS. CAN REMOVE AFTER SEPTEMBER ------------
if(get_user_meta(get_current_user_id(), 'private', 1) == null) {
	add_user_meta(get_current_user_id(), 'private', 0);
}
// ----------- REMOVE TIL HERE


?>