<?php

session_start();

if($_GET['logout']) {
	wp_logout();
	header("Refresh: 0; url=http://aquapons.info");
}

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
	
	wp_enqueue_script( 'misc-script', get_template_directory_uri() . '/js/scripts.js', array('jquery'));
	wp_enqueue_script( 'badge-review-script', get_template_directory_uri() . '/js/badges.js', array('jquery'));
	wp_enqueue_style( 'wp-style', get_stylesheet_uri() );
	wp_enqueue_style( 'main-style', get_bloginfo('template_directory') . '/style-main.css' );

}
add_action( 'wp_enqueue_scripts', 'load_scripts_styles' );


class themeCheck {
	
	public $theme = false;
	public $themeUrl;
	
	function __construct(){
		if(isset($_GET["theme"])){
			
			$this->theme=true;
			$this->themeUrl = "?theme={$_GET['theme']}";
			
		}
		
	}
	function returnUrl(){
		
		if($this->theme) return $this->themeUrl;
		else return "";
		
	}
	function url(){
		 if($this->theme) echo $this->themeUrl;
	}
	
}


function getBadgeStatus($badge_id, $dbresults = null) {
	if(!$dbresults) {
		global $current_user, $wpdb; 
		get_currentuserinfo();
		$dbresults = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$current_user->ID."'"); 
	}
	foreach($dbresults as $badge_status) {
		if($badge_status->badge_id == $badge_id) return $badge_status->status;
	}
	return 0;
}



function breadcrumb($curr_post) {
	echo "<ul class='breadcrumb'>";
	$link = "<li> ‹ <a href='%s'>%s</a>";
    $parent_id  = $curr_post->post_parent;  
    $breadcrumbs = array();  
    $delimiter = " </li> ";
    
    while($parent_id) {  
        $page = get_page($parent_id);  
        $url = get_permalink($page->ID);
        $breadcrumbs[] = sprintf($link, $url, get_the_title($page->ID));  
        $parent_id  = $page->post_parent;  
    }  
    $breadcrumbs = array_reverse($breadcrumbs);  
    for ($i = 0; $i < count($breadcrumbs); $i++) {  
        echo $breadcrumbs[$i];  
        if ($i != count($breadcrumbs)-1) echo $delimiter;  
    }  
    $before = '<li> ‹ <a href="'.get_permalink($curr_post->ID).'" >';
    $after = '</li></a>';
    echo $delimiter . $before . get_the_title($curr_post->ID) . $after; 
    echo "</ul>";
}



function insertSubmission($info){

	global $wpdb;
	$wpdb->insert(
		'aq_badge_submissions', 
		array(
			'id'                   => NULL,
			'user_id'              => $info['user_id'],
			'badge_id'             => $info['badge_id'],
			'activity_id'          => $info['activity_id'],
			'current_status'       => $info['current_status'],
			'type'				   => $info['type'],
			'data'                 => $info['data'],
			'submission_timestamp'  => $info['submission_timestamp']
		)
	);
}




if (function_exists( 'add_image_size' ) ) { 
	add_image_size( 'tutorial-thumb', 400, 300, true ); //300 pixels wide (and unlimited height)
}

//spit out activity upload nav for sidebar or main-col use.
function activityUploadNav(){ ?>
	
			<nav id="activity_upload">
				<section class="submission_nav upload">
					<h1></h1>
					<h4>Upload</h4>
					<hr>
					<p>Share your progress by uploading photos, videos or text files.</p>
					<form id="file_upload" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" style="display:none;">
						<select id="submission_type" name="submission_type">
							<option selected="selected" value="image">Image</option>
							<option value="video">Video</option>
							<option value="file">File</option>
						</select>
						<input id="activity_submission" type="file" name="activity_submission"/>
						<input id="activity_video" type="text" placeholder="" name="activity_video" style="display:none;"/>
						<input type="submit" name="post" value="Post it!"/>
		
						<p id="activity_video" class="form-help" style="display:none;" >Enter the video URL from Vimeo or YouTube <br/> (eg. http://vimeo.com/32100234)</p>
					</form>
				</section>
				<section class="submission_nav journal">
					<h1></h1>
					<h4>New Entry</h4>
					<hr>
					<p>Create a new journal entry to document your thinking about this activity.</p>
					<form id="journal_entry" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" style="display:none;">
						<input type="submit" name="entry" value="Create Journal Entry">
					</form>
				</section>
				<section class="submission_nav review" >
					<h1></h1>
					<h4>Submit for Review</h4>
					<hr>
					<p>Submit all of your documentation for this activity to be reviewed.</p>
					<form id="submit_activity" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" style="display:none;">
						<input type="submit" name="submit" value="Submit Activity For Review">
					</form>
				</section>
			</nav>
	
	
<?php 
}



?>