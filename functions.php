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
	wp_enqueue_style( 'wp-style', get_stylesheet_uri() );
	wp_enqueue_style( 'main-style', get_bloginfo('template_directory') . '/style-main.css' );

}
add_action( 'wp_enqueue_scripts', 'load_scripts_styles' );

if (function_exists( 'add_image_size' ) ) { 
	add_image_size( 'tutorial-thumb', 400, 300, true ); //300 pixels wide (and unlimited height)
}



?>