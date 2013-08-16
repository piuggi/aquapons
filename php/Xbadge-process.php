<?php

/*
		IF DENY
			SET BADGE_SUBMISSION TO DENIED
			CONNECT ANY COMMENTS TO SUBMISSION
	
		IF APPROVE 
			SET BADGE_SUBMISSION TO APPROVAL
			CONNECT ANY COMMENTS TO SUBMISSION
				
			IF ACTIVITY LEADS TO BADGE(S)
				GRANT BADGES
				IF OBI IS SET UP
					GO THROUGH OPENBADGES PROCESS
*/
	if($_POST['badge_denied']) {
		mysql_query("UPDATE `badge_submissions` SET `current_status` = 'denied', `reviewer_id` = '".$_POST['reviewer_id']."', `reviewer_comment` = '".$_POST['reviewer_comment']."', `review_timestamp` = 'NOW()' WHERE `id` = '".$_POST['submission_id']."';");
		// alert user of update?
	}

	if($_POST['badge_approved']) {
		
		mysql_query("UPDATE `badge_submissions` SET `current_status` = 'approved', `reviewer_id` = '".$_POST['reviewer_id']."', `reviewer_comment` = '".$_POST['reviewer_comment']."', `review_timestamp` = 'NOW()' WHERE `id` = '".$_POST['submission_id']."';");	
	
/*
		badge_id: $(this).attr('badge_id'),
		activity_id: $(this).attr('activity_id'),
		recipient: $(this).attr('user_id'),
		salt: $(this).attr(''),
		evidence: $(this).attr('evidence'),
		version: $(this).attr('version'),
		name: $(this).attr('badgename'),
		image: $(this).attr('badgeimage'),
		description: $(this).attr('description'),
		criteria: $(this).attr('criteria'),
		expires: $(this).attr('expires')
*/
	
	
		$badgeId             = $_POST['badge_id'];
		$badgeRecipientEmail = $_POST['recipient'];
		$badgeExperienceURL  = $_POST['evidence'];
		$badgeName           = $_POST['name'];
		$badgeImage          = $_POST['image'];
		$badgeDescription    = $_POST['description'];
		$badgeCriteria       = $_POST['criteria'];
		$badgeExpires        = $_POST['expires'];	
		$date = date('Y-m-d');
		$err = '';
		$msg = '';
		
		
		//salt email	
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $salt = '';
	    for ($i = 0; $i < 20; $i++) {
	        $salt .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    $hashed_email = hash('sha256', $badgeRecipientEmail  . $salt);
		
	
		//creates JSON file - will write over an existing badge for same badge and same user.
	
		$jsonFilePath = $_POST['json_dir'];
		$filename = $badgeId.'-'.$badgeRecipientEmail.'.json';
	
		$json_file = $jsonFilePath . $filename;
		$handle = fopen($json_file, 'w');
		$fileData = array(
			'recipient' => "sha256$".$hashed_email,
			'salt' => $salt,
			'evidence' => $badgeExperienceURL,
			'issued_on'=> $date,
			'badge' => array(
				'version' => $version,
				'name' => $badgeName,
				'image' => $issuer_url.$badge_images_dir.$badgeImage,
				'description' => $badgeDescription,
				'criteria' => $badgeCriteria,
				'expires' => $badgeExpires,
				'issuer' => array(
					'origin' => 'http://aquapons.info',
					'name' =>  - 'AQUAPONS',
					'org' => 'Sweet Water Foundation',
					'contact' => 'info@sweetwaterfoundation.com',
				)
			)
		);
		
		//Writes JSON file		
		if (fwrite($handle, json_encode($fileData)) === FALSE) {
		    echo $err = '<div class="badge-error">Cannot write to file ($jsonFilePath). Please check your \$json_dir in gadget_settings.php</div>';
		} else { 
			echo "http://aquapons.info/wp-content/json/".$filename;
		}
	
		
	} // if(approved)
	
?>