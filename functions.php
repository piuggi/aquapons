<?php

session_start();

include('functions_includes/custom-post-types.php');

include('functions_includes/badge-ajax.php');

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
	
	wp_enqueue_script( 'badge-review-script', get_template_directory_uri() . '/js/badges.js', array('jquery'));
	wp_enqueue_style( 'wp-style', get_stylesheet_uri() );
	wp_enqueue_style( 'main-style', get_bloginfo('template_directory') . '/style-main.css' );

}
add_action( 'wp_enqueue_scripts', 'load_scripts_styles' );









function breadcrumb($curr_post) {
	$link = "<a href='%s'>%s</a>";
    $parent_id  = $curr_post->post_parent;  
    $breadcrumbs = array();  
    $delimiter = " > ";
    
    while($parent_id) {  
        $page = get_page($parent_id);  
        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));  
        $parent_id  = $page->post_parent;  
    }  
    $breadcrumbs = array_reverse($breadcrumbs);  
    for ($i = 0; $i < count($breadcrumbs); $i++) {  
        echo $breadcrumbs[$i];  
        if ($i != count($breadcrumbs)-1) echo $delimiter;  
    }  
    echo $delimiter . $before . get_the_title($curr_post->ID) . $after; 
}

/*
**
*/

class themeCheck {
	
	public $theme = false;
	public $themeUrl;
	
	function __construct(){
		if(isset($_GET["theme"])){
			
			$this->theme=true;
			$this->themeUrl = "?theme={$_GET['theme']}";
			
		}
		
	}
	
	function url(){
		 if($this->theme) echo $this->themeUrl;
	}
	
}
	


?>