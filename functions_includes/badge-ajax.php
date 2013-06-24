<?php

function submittedToOBI() {
	$wpdb->update( 
			'aq_badge_submissions', 
			array( 
				'submitted_to_obi' => '1'
			), 
			array( 'id' => $_POST['submission_id'] )
		);
}
add_action('wp_ajax_submittedToOBI', 'submittedToOBI');


function reviewBadgeAjax() {
/*
		IF DENY
			SET BADGE_SUBMISSION TO DENIED
			CONNECT ANY COMMENTS TO SUBMISSION
	
		IF APPROVE 
			SET BADGE_SUBMISSION TO APPROVED
			CONNECT ANY COMMENTS TO SUBMISSION
				
			IF ACTIVITY LEADS TO BADGE(S)
				GRANT BADGES
				IF OBI IS SET UP
					GO THROUGH OPENBADGES PROCESS
*/

	global $wpdb, $user_info;
	
	if($_POST['badge_denied']) {
		$user_info = $wpdb->get_row("SELECT * FROM aq_usermeta WHERE user_token_id = '".$_POST['user_token']."'");
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
		updateBadgeStatus($user_info->wp_user_id, $_POST['badge_id']);
	}

	if($_POST['badge_approved']) {
		$user_info = $wpdb->get_row("SELECT * FROM aq_usermeta WHERE user_token_id = '".$_POST['user_token']."'");
		
		$wpdb->update( 
			'aq_badge_submissions', 
			array( 
				'current_status' => 'approved',
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

		
		
		$badgeId             = $_POST['badge_id'];
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
		
		
		
		
		// updateBadgeStatus($user_info->wp_user_id, $badgeId);
		
		
	/*
	
		// check requirements for badge
		$parent_badge_type = get_post_meta($badgeId, 'badge_type', true);
		$my_wp_query = new WP_Query();
		$all_wp_badges = $my_wp_query->query(array('post_type' => 'badge'));
		$siblings = get_page_children($badgeId, $all_wp_badges);
		// if skills badge, check all related activities
		// if all activities are complete, grant badge
		$percentage_complete = 0;
		$indiv_percent = 100/sizeof($siblings);
		if($parent_badge_type == "skill") {
			$grantBadge = true;
			
			foreach($siblings as $sibling) {
				$activity_info = $wpdb->get_row("SELECT * FROM aq_badge_submissions WHERE user_id = ".$user_info->wp_user_id." AND activity_id = ".$sibling->ID);
				//echo " activity status: ".$activity_info->current_status;
				if($activity_info->current_status == "approved") $percentage_complete += $indiv_percent;
			}
			echo "percent complete: ".round($percentage_complete);
		}
		// else check all sibling badges
		else {
			foreach($siblings as $sibling) {
				$activity_info = $wpdb->get_row("SELECT * FROM aq_badge_status WHERE user_id = ".$user_info->wp_user_id." AND badge_id = ".$sibling->ID);
				//echo " activity status: ".$activity_info->current_status;
				if($activity_info->status == 100) $percentage_complete += $indiv_percent;
			}
			echo "percent complete: ".round($percentage_complete);
			
		}
*/
		
		
		// IF BADGE IS COMPLETE, CHECK TO SEE IF IT COMPLETES PARENT BADGES
		
		
		
/*
		$badge_status = $wpdb->get_row("SELECT * FROM aq_badge_status WHERE user_id = ".$user_info->wp_user_id." AND badge_id = ".$_POST['badge_id']);
		print_r($badge_status);
		if($badge_status) {
			$wpdb->update( 
				'aq_badge_status', 
				array( 
					'status' => round($percentage_complete)
				), 
				array( 'user_id' => $user_info->wp_user_id, 'badge_id' => $_POST['badge_id'] )
			);
		} else {
			$wpdb->insert( 
				'aq_badge_status', 
				array( 
					'user_id' => $user_info->wp_user_id,
					'badge_id' => $_POST['badge_id'],
					'status' => round($percentage_complete)
				)
			);
		}
*/
		
		

		
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
		// check to see that status of badge is set to 100;
		if($badge_status->status == 100) {
			// if so, get user token and return assertion url
			$user_info = $wpdb->get_row("SELECT * FROM aq_usermeta WHERE wp_user_id = ".$_POST['user_id']);
			echo "http://aquapons.info/wp-content/json/assertion-".$_POST['badge_id']."-".$user_info->user_token_id.".json";
			
		} else {
			echo "You haven't completed this badge! Finish the objectives and try again.";
		}
		
		
	}
	
	

}	
add_action('wp_ajax_reviewBadgeAjax', 'reviewBadgeAjax');






function updateBadgeStatus($user_id, $parent_badge_id) {
	
	global $wpdb;
	
	// check requirements for badge
		//$my_wp_query = new WP_Query();
		//$all_wp_badges = $my_wp_query->query(array('post_type' => 'badge'));
		//$siblings = get_page_children($parent_badge_id, $all_wp_badges);
		
	$args = array(
		'post_parent' => $parent_badge_id,
		'post_type' => 'badge',
		'post_status' => 'publish'
	); 
	$siblings = get_posts($args); 
		
	// if skills badge, check all related activities
	$percentage_complete = 0;
	$indiv_percent = 100/sizeof($siblings);
	$parent_badge_type = get_field('badge_type', $parent_badge_id);
	if($parent_badge_type == "skill") {
		$grantBadge = true;
		foreach($siblings as $sibling) {
			$activity_info = $wpdb->get_row("SELECT * FROM aq_badge_submissions WHERE `user_id` = '$user_id' AND `activity_id` = '".$sibling->ID."' AND `type` = ''");
			//echo $sibling->ID ." activity status:".$activity_info->current_status;
			if($activity_info->current_status == "complete" || $activity_info->current_status == "reviewing") $percentage_complete += $indiv_percent;
		}
	}
	// else check all sibling badges
	else {
		foreach($siblings as $sibling) {
			$activity_info = $wpdb->get_row("SELECT * FROM aq_badge_status WHERE user_id = ".$user_info->wp_user_id." AND badge_id = ".$sibling->ID);
			//echo " activity status: ".$activity_info->current_status;
			if($activity_info->status == 100) $percentage_complete += $indiv_percent;
		}
		
	}
	
	$percentage_complete = round($percentage_complete);
	
	// UPDATE BADGE STATUS IN DB
	$badge_status = $wpdb->get_row("SELECT * FROM aq_badge_status WHERE user_id = ".$user_id." AND badge_id = ".$parent_badge_id);
	if($badge_status) {
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
	if($percentage_complete == 100) {
		writeBadgeJSON($badge_id);
		$ancestors = get_ancestors($badge_id);
		if($ancestors[0]) updateBadgeStatus($ancestors[0]);	
	} 

		
}



function writeBadgeJSON($badge_id) {
	
	//salt email 
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $salt = '';
    for ($i = 0; $i < 20; $i++) {
        $salt .= $characters[rand(0, strlen($characters) - 1)];
    }
    $hashed_email = hash('sha256', $badgeRecipientEmail  . $salt);

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



?>