<?php


function excerpt($text, $length = 300) {
	
	if(strlen($text) < $length-3) return $text;
	else return substr($text, 0, $length) . "…";
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


function badge_level_name($badge_level_num) {
	if($badge_level_num == 1) echo "Junior Apprentice";
	if($badge_level_num == 2) echo "Senior Apprentice";
	if($badge_level_num == 3) echo "Journeymon";
	if($badge_level_num == 4) echo "Master";
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
				<section class="submission_nav complete" >
					<h1></h1>
					<h4>Mark As Complete</h4>
					<hr>
					<p>Click here to complete this activity and move on to the next one.</p>
					<form id="submit_activity" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" style="display:none;">
						<input type="submit" name="complete" value="Complete Activity">
					</form>
				</section>
				<section class="submission_nav review" >
					<h1></h1>
					<h4>Submit for Review</h4>
					<hr>
					<p>Submit all of your documentation for this activity to be reviewed.</p>
					<form id="submit_activity" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" style="display:none;">
						<input type="submit" name="submit" value="Submit Activity for Review">
					</form>
				</section>
			</nav>
	
	
<?php 
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

//return how long ago a post was made
//http://upthemes.com/blog/2010/03/wordpress-master-tip-display-time-ago-for-posts-or-comments/
function time_ago( $type = 'post' ) {
	$d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';

	return human_time_diff($d('U'), current_time('timestamp')) . " " . __('ago');

}


function time_ago_comment($date){
		
	$unix = strtotime($date);
	return human_time_diff($unix, current_time('timestamp')) . " " . __('ago');
	
}

function establishedDate($rawdate){
	
	$year = substr($rawdate, 0, 4);
	$month = substr($rawdate, 4, 2);

	$monthName = date("F", mktime(0, 0, 0, intval($month), 10));
	$est = "Est. {$monthName}, {$year}";
	
	return $est;
}


function updateProfileInfo($info) {
	global $wpdb;
	// update metainfo
	$wpdb->update(
		'aq_usermeta',  
		array( 
			'location' => $info['location']
		),
		array( 'wp_user_id' => $info['userid'] )
	);


	// update education info
	
	
	// update experience info
	
}


function getUserToken($user_id) {
	global $wpdb;
	$user_info = $wpdb->get_row("SELECT `user_token_id` FROM aq_usermeta WHERE wp_user_id = '$user_id'");
	return $user_info->user_token_id;

}


?>