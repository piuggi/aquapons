<?php

function submittedToOBI() {
	global $wpdb, $current_user;	
	echo $current_user->ID;
	echo $_POST['badge_id'];

	$wpdb->update( 
			'aq_badge_status', 
			array( 
				'submitted_to_obi' => '1'
			), 
			array( 
				'user_id' => $current_user->ID,
				'badge_id' => $_POST['badge_id']
			)
		);
}
add_action('wp_ajax_submittedToOBI', 'submittedToOBI');


function reviewBadgeAjax() {

	global $wpdb, $user_info;
	$user_info = $wpdb->get_row("SELECT * FROM aq_usermeta WHERE user_token_id = '".$_POST['user_token']."'");
	$user_data = get_userdata( $user_info->wp_user_id );
	$badge_info = $wpdb->get_row("SELECT post_title FROM aq_badge_submissions, wp_posts WHERE aq_badge_submissions.id = '".$_POST['submission_id']."' AND aq_badge_submissions.badge_id = wp_posts.ID");

	
	$badgeId             = $_POST['badge_id'];
	
	/* BADGE DEINED */
	if($_POST['badge_denied']) {
		// SET SUBMISSION TO DENIED
		$wpdb->update( 
			'aq_badge_submissions', 
			array( 
				'current_status' => 'denied',
				'reviewer_id' => $_POST['reviewer_id'],
				'reviewer_comment' => $_POST['reviewer_comment'],
				'review_timestamp' => date('Y-m-d H:i:s')
			), 
			array( 'id' => $_POST['submission_id'] )
		);
		
		// UPDATE BADGE SUBMISSION
		updateBadgeStatus($user_info->wp_user_id, $_POST['badge_id']);
		
		
		// SEND EMAIL TO USER
		$message = 
"<p>We're sorry, but your submission was not approved for the <b>".$badge_info->post_title."</b> badge.</p>	
<p>Your badge reviewer had these things to say about your submission:</p>
<h4>".$_POST['reviewer_comment']."</h4>
<p>If you would like to re-submit, make whatever changes are necessary to your badge submission and try again.</p>";
		
		wp_mail($user_data->user_email, "AQUAPONS: Badge Submission Denied", $message);
	}



	/* BADGE APPROVED */
	if($_POST['badge_approved']) {
		// UPDATE SUBMISSION TO APPROVED
		$wpdb->update( 
			'aq_badge_submissions', 
			array( 
				'current_status' => 'complete',
				'reviewer_id' => $_POST['reviewer_id'],
				'reviewer_comment' => $_POST['reviewer_comment'],
				'review_timestamp' => date('Y-m-d H:i:s')
			), 
			array( 'id' => $_POST['submission_id'] )
		);
		
		$wpdb->update( 
			'aq_badge_status', 
			array( 
				'status' => 'complete'
			), 
			array( 'user_id' => $user_info->wp_user_id, 'badge_id' => $_POST['badge_id'] )
		);
		updateBadgeStatus($user_info->wp_user_id, $badgeId);


		// SEND EMAIL TO USER
		$user_data->user_email;
		$message = 
"<h2>Congratulations!</h2>
<p>Your submission for the <b>".$badge_info->post_title."</b> badge has been approved.</p>	
<p>Your badge reviewer had these things to say about your submission:</p>
<h4>".$_POST['reviewer_comment']."</h4>
<p>You can see your new badge by visiting your <a href='http://aquapons.info/profile/'>profile</a> page, or visit the <a href='http://aquapons.info/badges/aquapons-badges/'>Badges</a> section of the site to start working on the next one!</p>";
		
		wp_mail($user_data->user_email, "AQUAPONS: Badge Submission Accepted", $message);
		
		
		
		$badgeRecipientEmail = $_POST['recipient'];
		$badgeExperienceURL  = $_POST['evidence'];
		$badgeName           = $_POST['name'];
		$badgeVersion       = $_POST['version'];
		$badgeImage          = $_POST['image'];
		$badgeDescription    = $_POST['description'];
		$badgeCriteria       = $_POST['criteria'];
		$badgeExpires        = $_POST['expires'];	
		$date = date('Y-m-d');
		$err = '';
		$msg = '';
		
					
		// if badge requirements are set, grant badge
		if($percentage_complete == 100) {
		
			
			//salt email	
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $salt = '';
		    for ($i = 0; $i < 20; $i++) {
		        $salt .= $characters[rand(0, strlen($characters) - 1)];
		    }
		    $hashed_email = hash('sha256', $badgeRecipientEmail  . $salt);
			
		
			//creates JSON file - will write over an existing badge for same badge and same user.
		
			$jsonFilePath = get_theme_root()."/../json/";
			$filename = "assertion-".$badgeId.'-'.$_POST['user_token'].'.json';
		
			$json_file = $jsonFilePath . $filename;
			$handle = fopen($json_file, 'w');
			$fileData = array( 
				'uid' => $badgeId.'-'.$_POST['user_token'],
				'recipient' => array(
					'type' => 'email',
					'hashed' => true,
					'salt' => $salt,
					'id' => "sha256$".$hashed_email
					),
				//'image' => $userImage,
				'evidence' => $badgeExperienceURL,
				'issuedOn' => time(),
				'badge' => $badgeCriteria."?json=true",
				'verify' => array(
					'type' => 'hosted',
					'url' => 'http://aquapons.info/wp-content/json/'.$filename
					)
				);
/*
			$fileData = array(
				'recipient' => "sha256$".$hashed_email,
				'salt' => $salt,
				'evidence' => $badgeExperienceURL,
				'issued_on'=> $date,
				'badge' => array(
					'version' => $badgeVersion,
					'name' => $badgeName,
					'image' => $badgeImage,
					'description' => $badgeDescription,
					'criteria' => $badgeCriteria,
					'expires' => $badgeExpires,
					'issuer' => array(
						'origin' => 'http://aquapons.info',
						'name' => 'AQUAPONS',
						'org' => 'Sweet Water Foundation',
						'contact' => 'info@sweetwaterfoundation.com',
					)
				)
			);
*/
			
			//Writes JSON file		
			if (fwrite($handle, json_encode($fileData)) === FALSE) {
			    echo $err = '<div class="badge-error">Cannot write to file.</div>';
			}
		}
		
	} // if(approved)
	
	
	
	
	if($_POST['get_assertion_url']) {
		$theme = $_POST['theme'];
		global $current_user;
		
		// get user token id
		$usermeta = $wpdb->get_row("SELECT user_token_id FROM aq_usermeta WHERE wp_user_id = '".$current_user->ID."'");
		
		// check to see that status of badge is set to COMPLETE;
		$badge_status = $wpdb->get_row("SELECT status FROM aq_badge_status WHERE user_id = '".$current_user->ID."' AND badge_id = '".$_POST['badge_id']."' AND status = 'complete' LIMIT 1");
		if($badge_status->status == 'complete') {
			// if so, get user token and return assertion url
			$user_info = $wpdb->get_row("SELECT * FROM aq_usermeta WHERE wp_user_id = ".$_POST['user_id']);
			echo get_permalink($_POST['badge_id'])."?json=true&user_token=".$usermeta->user_token_id."&theme=".$theme;
			//echo "http://aquapons.info/wp-content/json/assertion-".$_POST['badge_id']."-".$user_info->user_token_id.".json";
			
		} else {
			echo "You haven't completed this badge! Finish the objectives and try again.";
		}
		
		
	}
	
	

}	
add_action('wp_ajax_reviewBadgeAjax', 'reviewBadgeAjax');





// UPDATES BADGE COMPLETION STATUS, ALONG WITH ALL PARENT BADGES
function updateBadgeStatus($user_id, $parent_badge_id) {
	
	global $wpdb;
	
		
	$args = array(
		'post_parent' => $parent_badge_id,
		'post_type' => 'badge',
		'post_status' => 'publish'
	); 
	$siblings = get_posts($args); 
		
		
		
	// if skills badge, check all related activities
	$percentage_complete = 0;
	$reviewing = false;
	
	$indiv_percent = 100/sizeof($siblings);
	$parent_badge_type = get_field('badge_type', $parent_badge_id);
	if($parent_badge_type == "skill") {
		$complete = true;
		foreach($siblings as $sibling) {
			$activity_info = $wpdb->get_row("SELECT * FROM aq_badge_submissions WHERE `user_id` = '$user_id' AND `activity_id` = '".$sibling->ID."' AND `type` = ''");
			if($activity_info->current_status == "complete" || $activity_info->current_status == "reviewing") $percentage_complete += $indiv_percent;
			if($activity_info->current_status == "reviewing") $reviewing = true;
			if($activity_info->current_status != "complete") $complete = false;
		}
	}	
	// else check all sibling badges
	else {
		foreach($siblings as $sibling) {
			$activity_info = $wpdb->get_row("SELECT * FROM aq_badge_status WHERE user_id = $user_id AND badge_id = ".$sibling->ID);
			if($activity_info->status == 'complete') $percentage_complete += $indiv_percent;
		}
	}
	
	$percentage_complete = round($percentage_complete);
	if($parent_badge_type != "skill" && $percentage_complete == 100) $percentage_complete = 'complete';
	if($complete) $percentage_complete = 'complete';
	if($reviewing) $percentage_complete = 'reviewing'; 
	
	//echo "perc: ".$percentage_complete."<br>";
	
	// UPDATE BADGE STATUS IN DB
	$badge_status = $wpdb->get_row("SELECT * FROM aq_badge_status WHERE user_id = ".$user_id." AND badge_id = ".$parent_badge_id);
	if($badge_status) {
		"update badge_status";
		$wpdb->update( 
			'aq_badge_status', 
			array( 
				'status' => $percentage_complete
			), 
			array( 'user_id' => $user_id, 'badge_id' => $parent_badge_id )
		);
	} else {
		$wpdb->insert( 
			'aq_badge_status', 
			array( 
				'user_id' => $user_id,
				'badge_id' => $parent_badge_id,
				'badge_type' => $parent_badge_type,
				'status' => $percentage_complete
			)
		);
	}
	
	
	// IF BADGE IS COMPLETE, CHECK TO SEE IF IT COMPLETES PARENT BADGES
	if($percentage_complete === 'complete') {
		writeBadgeJSON($parent_badge_id);
		$ancestors = get_ancestors($parent_badge_id, 'badge');
		if($ancestors[0]) updateBadgeStatus($user_id, $ancestors[0]);	
	} 
	
	// IF AQUAPONS BADGE IS COMPLETED, UPGRADE USER'S ROLE
	if($percentage_complete === 'complete' && $parent_badge_type == "aquapons") {
		$current_userdata = get_userdata($user_id);
		$user_role = $current_userdata->roles;
		if($user_role[0] == 'novice') $new_role = 'junior_apprentice';
		if($user_role[0] == 'junior_apprentice') $new_role = 'senior_apprentice';
		if($user_role[0] == 'senior_apprentice') $new_role = 'journeymon';
		if($user_role[0] == 'journeymon') $new_role = 'master';
		if($new_role) echo $new_role;
		wp_update_user( array ( 'ID' => $user_id, 'role' => $new_role ) ) ;
	}
		
}



?>