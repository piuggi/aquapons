<?php
//global vars
//for passing between theme

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


function showBadge($badge_id) { 
	global $badge_info;
	?>
	<a href='<?php echo get_permalink($badge_id); ?>' class="<?php $cat = get_the_category($badge_id); echo $cat[0]->slug; ?>">
	<div class="skill badge <?php $cat = get_the_category($badge_id); echo $cat[0]->slug; ?> <?php echo sanitize_title(get_the_title($badge_id)); echo ' level-'.$x; ?>">
		<h4><?php echo get_the_title($badge_id); ?></h4>
		<hr>
		<div class="badge_level"><?php echo get_field('badge_level', $badge_id); ?></div>
		<?php if($current_badge_status = getBadgeStatus($badge_id, $badge_info)) { ?>
			<div class="status_container">
				<?php if($current_badge_status != 'complete' && $current_badge_status != 'reviewing') { ?>
					<div class="completion_container">
						<div class="badge_completion" style="width: <?php echo $current_badge_status/4; ?>px"><?php echo $current_badge_status; ?>%</div>
					</div>
				<?php } ?>
				<div class="badge_completion_label">
					<?php if($current_badge_status == 'complete') echo "COMPLETE";
					elseif($current_badge_status == 'reviewing') echo "REVIEWING";
					else echo $current_badge_status . "%"; ?>
					</div>
			</div>
			<?php if($current_badge_status == 'complete') { ?>
				<img class="skills_badge_image" src="<?php echo get_field('badge_image', $badge_id); ?>" alt="<?php echo get_the_title($badge_id); ?>">
			<?php } ?>
		<?php } ?>
	</div>
	</a>

<?php
}

function resourceThumb($id) {
?>
	<a href="<?php echo get_permalink($id); ?>">
		<?php if(get_field('resource_image')) { ?>
			<?php echo wp_get_attachment_image(get_field('resource_image', $id), 'tutorial-thumb'); ?>
		<?php } else if(get_field('link_url')) { 
			$clean_url = substr(get_field('link_url', $id), strpos(get_field('link_url', $id), '//')+2);
			?>
			<img src="http://s.wordpress.com/mshots/v1/http%3A%2F%2F<?php echo $clean_url; ?>?w=140" /> 
		<?php } else { ?>
			<img src="<?php echo get_template_directory_uri() ?>/imgs/placeholder-search.png" alt="<?php echo get_the_title($id); ?>">
		<?php } ?>
	</a>
						
<?php
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

function print_aquapon_cat(){		  
		  $cats = get_the_category();	  
		  if($cats) $class = $cats[0]->slug;
		  else $class = 'plant';
		  echo $class;
}

function get_aquapon_cat(){
		  $cats = get_the_category();	  
		  if($cats) $class = $cats[0]->slug;
		  else $class = 'plant';
		  return $class;
}




function check_postComments(){
	
		$post_id = get_the_ID();
		$user = wp_get_current_user();
		/* Check for various for types */
		if(isset($_POST["content"]) && is_user_logged_in() ){
	
		//we've gotten an anwser
		$answers = get_post_meta(get_the_ID(), 'answers', true);
		$answers++; update_post_meta(get_the_ID(), 'answers', $answers);
		
		global $wpdb;
		
		
		$insert_args = array(
		
			'comment_discussion'=> $post_id,
			'comment_author'=> $user->ID,
			'comment_date'=> date("Y-m-d H:i:s"),
			'comment_content'=> $_POST['content'],
			'comment_status'=> 'publish',
			'comment_rank'=> 0,
			'comment_flags'=> 0,
			'comment_has_children'=> false,
			'comment_is_child'=> false
		);
		
		$wpdb->insert('aq_discussion_comments', $insert_args);
		
	}elseif(isset($_POST["comment"])){
		
		global $wpdb;
		
		$insert_args = array(
		
			'comment_discussion'=> $post_id,
			'comment_author'=> $user->ID,
			'comment_date'=> date("Y-m-d H:i:s"),
			'comment_content'=> $_POST['comment'],
			'comment_status'=> 'publish',
			'comment_rank'=> 0,
			'comment_flags'=> 0,
			'comment_has_children'=> false,
			'comment_is_child'=> true,
			'comment_parent'=> $_POST['comment-id']
			
		);
		
		$wpdb->insert('aq_discussion_comments', $insert_args);
		
		$data = array('comment_has_children'=> true);
		$where = array('id'=> $_POST['comment-id'] );
		
		$wpdb->update('aq_discussion_comments', $data, $where );

		
	}elseif(isset($_POST["vote"])){
		
		$votes = get_post_meta(get_the_ID(), 'votes', true);
		$votes++; update_post_meta(get_the_ID(), 'votes', $votes);
		
		$vote = $_POST['vote'];
		$theID = $_POST['comment-id'];
		global $wpdb;
		
		
		$query = "UPDATE aq_discussion_comments SET comment_rank= comment_rank + $vote WHERE id='$theID'";

		$wpdb->query($query);
		
	}elseif(isset($_POST["flag"])){
		
		$flag = $_POST['flag'];
		$theID = $_POST['comment-id'];
		global $wpdb;
		$query = "UPDATE aq_discussion_comments SET comment_flags= comment_flags + $flag WHERE id ='$theID'";
		$wpdb->query($query);
		$result = $wpdb->get_row("SELECT comment_flags FROM aq_discussion_comments WHERE id = $theID", ARRAY_A);
		
		if($result['comment_flags']>=2){
			
			$answers = get_post_meta(get_the_ID(), 'answers', true);
			$answers--; if($answers>=0) update_post_meta(get_the_ID(), 'answers', $answers);
			
			$data = array('comment_status'=>'flagged');
			$where = array('id'=> $theID );
			
			$wpdb->update('aq_discussion_comments', $data, $where );
			
			//send notification to admins that comment has been flagged for review
			
		}
		
	} 
	
}
function updateSubmissionText(){
		$wpdb->update( 
			'aq_badge_submissions', 
			array( 'data'=>$_POST['activity_submission']), 
			array( 'id' => $_POST['submission_id'] )
		);

}

?>