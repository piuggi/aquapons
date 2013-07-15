<?php $section = 'profile'; ?>

<?php

if($_SESSION['user_id']) $userid = $_SESSION['user_id'];
else $userid = get_current_user_id();


if(sizeof($_POST)) {

//print_r($_POST);
	// CHECK TO MAKE SURE LOGGED IN USER IS SAME AS PROFILE USER
	if($current_user->ID == $userid){
		// UPDATE PROFILE INFO
		$wpdb->update( 
			'aq_usermeta', 
			array( 
				'city' => $_POST['city'],
				'state' => $_POST['state'],
				'country' => $_POST['country'],
			), 
			array( 'wp_user_id' => $current_user->ID) 
		);
		
		// UPDATE EDUCATION INFO
		$school_ids = explode(',',$_POST['school_ids']);
		
		foreach($school_ids as $school_id) {
			// REMOVE UNWANTED SCHOOLS
			if($_POST['remove_school'.$school_id]) {
				$wpdb->query( 
					$wpdb->prepare("DELETE FROM aq_affiliations WHERE id='".$school_id."' AND user_id = '".$current_user->ID."'")
				);
			}
		
			// UPDATE SCHOOLS
			$school_name = $_POST['school_name'.$school_id];
			$school_url = $_POST['school_url'.$school_id];
			$school_accredidation = $_POST['school_accredidation'.$school_id];
			$wpdb->update( 
				'aq_affiliations', 
				array( 
					'name' => $school_name,
					'url' => $school_url,
					'degree' => $school_accredidation
				), 
				array( 'id' => $school_id, 'user_id' => $current_user->ID) 
			);
		}
		
		// ADD NEW SCHOOLS
		if($_POST['new_school_name']) {
			$wpdb->insert( 
				'aq_affiliations', 
				array( 
					'user_id' => $current_user->ID,
					'type' => 'education',
					'name' => $_POST['new_school_name'],
					'url' => $_POST['new_school_url'],
					'degree' => $_POST['new_school_accredidation']
				)
			);
		}
		
		// UPDATE EXPERIENCE INFO	
		$company_ids = explode(',',$_POST['company_ids']);
		
		foreach($company_ids as $company_id) {
			// REMOVE UNWANTED COMPANIES
			if($_POST['remove_company'.$company_id]) {
				$wpdb->query( 
					$wpdb->prepare("DELETE FROM aq_affiliations WHERE id='".$company_id."' AND user_id = '".$current_user->ID."'")
				);
			}
		
			// UPDATE COMPANIES
			$company_name = $_POST['company_name'.$company_id];
			$company_url = $_POST['company_url'.$company_id];
			$job_title = $_POST['job_title'.$company_id];
			$wpdb->update( 
				'aq_affiliations', 
				array( 
					'name' => $company_name,
					'url' => $company_url,
					'job_title' => $job_title
				), 
				array( 'id' => $company_id, 'user_id' => $current_user->ID) 
			);
		}
		
		// ADD NEW COMPANIES
		if($_POST['new_company_name']) {
			$wpdb->insert( 
				'aq_affiliations', 
				array( 
					'user_id' => $current_user->ID,
					'type' => 'experience',
					'name' => $_POST['new_company_name'],
					'url' => $_POST['new_company_url'],
					'job_title' => $_POST['new_job_title']
				)
			);
		}
	}
}

// HANDLE RESUME UPLOAD
if($_FILES['resume_upload']) {
	// CHECK TO MAKE SURE LOGGED IN USER IS SAME AS PROFILE USER
	if($current_user->ID == $userid){

		if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
		$uploadedfile = $_FILES["resume_upload"];
		$wpfile = wp_handle_upload($uploadedfile,array('test_form'=>false));
		$wpdb->update( 
			'aq_usermeta', 
			array( 
				'resume' => $wpfile['url']
			), 
			array( 'wp_user_id' => $current_user->ID) 
		);
	}
}


$affiliations = $wpdb->get_results("SELECT * FROM aq_affiliations WHERE user_id = '".$userid."'"); 

?>
<?php get_header(); ?>


	<section class="main">
		<section class="background text-content <?php if($current_user->ID == $userid) echo "editable"; ?>">
			
			<?php
			//if logged in and current profile page == current user, show edit buttons
			if($current_user->ID == $userid) { ?>
				<div class="edit_setting edit_background"><span>Edit</span></div>
			<?php 
			}
			
			$background_info = $wpdb->get_row("SELECT * FROM aq_usermeta WHERE wp_user_id = '".$userid."'"); 
			?>
			
			<h2>Background</h2>
				
				<div class="background_display">
				<h4>Member Since</h4>
				<p><?php echo date("F, Y", strtotime(get_userdata($userid)->user_registered)); ?></p>
				
				<h4>Location</h4>
				<p class="city"><?php echo $background_info->city; ?><br>
				<?php echo $background_info->state; ?><br>
				<?php echo $background_info->country; ?></p>
				
				<h4>Education</h4>
				<div class="schools">
					<?php
					foreach($affiliations as $school) {
						if($school->type == 'education') {
					?>
					<div class="school">
						<h5><a href="<?php echo $school->url; ?>"><?php echo $school->name; ?></a></h5>
						<h6><?php echo $school->degree; ?></h6>
					</div>
					<?php }
					} ?>
				</div>
				
				<h4>Professional Experience</h4>
				<?php
				foreach($affiliations as $job) {
					if($job->type == 'experience') {
				?>
				<div class="companies">
					<div class="company">
						<h5><a href="<?php echo $job->url; ?>"><?php echo $job->name; ?></a></h5>
						<h6><?php echo $job->job_title; ?></h6>
					</div>
				</div>
				<?php }
				} ?>
			</div>
			
			
			<?php
			//if logged in and current profile page == current user, show edit buttons
			if($current_user->ID == $userid) { ?>
			<div class="background_admin">
			<form id="profile_background_form" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
				<h4>Current City</h4>
				<input name="city" class='edit_city' original_value='<?php echo $background_info->city; ?>' value='<?php echo $background_info->city; ?>'>
				<h4>State</h4>
				<input name="state" class='edit_state' original_value='<?php echo $background_info->state; ?>' value='<?php echo $background_info->state; ?>'>
				<h4>Country</h4>
				<input name="country" class='edit_country' original_value='<?php echo $background_info->country; ?>' value='<?php echo $background_info->country; ?>'>
				
				<h4>Education</h4>
				<?
				$school_ids = array();
				foreach($affiliations as $school) {
					if($school->type == 'education') {
					$school_ids[] = $school->id;
				?>
				<div class="edit_setting delete_school">Remove</div>
				<div class="school school_<?php echo $school->id; ?>">
					<input name="school_name<?php echo $school->id; ?>" class='edit_school_name' original_value='<?php echo $school->name; ?>' value='<?php echo $school->name; ?>' placeholder="School Name">
					<input name="school_url<?php echo $school->id; ?>" class='edit_school_url' original_value='<?php echo $school->url; ?>' value='<?php echo $school->url; ?>' placeholder="School Website">
					<input name="school_accredidation<?php echo $school->id; ?>" class='edit_school_accreditation' original_value='<?php echo $school->degree; ?>' value='<?php echo $school->degree; ?>' placeholder="Degree/Certificate earned">
					<input type="hidden" name="remove_school<?php echo $school->id; ?>" class="remove_school" value="false">
				</div>
				<?php }	
				} ?>
				<input type="hidden" name="school_ids" original_value="<?php echo implode(',', $school_ids); ?>" value="<?php echo implode(',', $school_ids); ?>">
				<div class="new school">
					<label>Add new school</label>
					<input name="new_school_name" class='edit_school_name' placeholder="School Name">
					<input name="new_school_url" class='edit_school_url' placeholder="School Website">
					<input name="new_school_accredidation" class='edit_school_accreditation' placeholder="Degree/Certificate earned">
				</div>
				
				<h4>Professional Experience</h4>
				<?php
				$company_ids = array();
				foreach($affiliations as $company) {
					if($company->type == 'experience') {
					$company_ids[] = $company->id;
				?>
				<div class="edit_setting delete_company">Remove</div>
				<div class="company company_<?php echo $company->id; ?>">
					<input name="company_name<?php echo $company->id; ?>" class='edit_company_name' original_value='<?php echo $company->name; ?>' value='<?php echo $company->name; ?>' placeholder="Company/Institution Name">
					<input name="company_url<?php echo $company->id; ?>" class='edit_company_url' original_value='<?php echo $company->url; ?>' value='<?php echo $company->url; ?>' placeholder="Company/Institution Website">
					<input name="job_title<?php echo $company->id; ?>" class='edit_job_title' original_value='<?php echo $company->job_title; ?>' value='<?php echo $company->job_title; ?>' placeholder="Job Title">
					<input type="hidden" name="remove_company<?php echo $company->id; ?>" class="remove_company" value="false">
				</div>
				<?php }
				} ?>
				<input type="hidden" name="company_ids" original_value="<?php echo implode(',', $company_ids); ?>" value="<?php echo implode(',', $company_ids); ?>">
				<div class="new company">
					<label>Add New:</label>
					<input name="new_company_name" class='edit_company_name' placeholder="Company/Institution Name">
					<input name="new_company_url" class='edit_company_name' placeholder="Company/Institution Website">
					<input name="new_job_title" class='edit_job_title' placeholder="Job Title">
				</div>
				
				<input type="submit" class="save_background_info" value="Save Changes">
				<a class="cancel_background_info">Cancel</a>
			</form>
			</div>
			<?php } ?>
			
			
			<?php if($current_user->ID == $userid) { ?>
				<form id="resume_upload_form" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<input type="file" name="resume_upload" class="edit_setting edit_resume">
				</form>
			<?php } ?>
			
			<?php if($background_info->resume) { ?>
				<h4>Resume</h4>
				<p><a href="<?php echo $background_info->resume; ?>">Download ›</a></p>
			<?php } else if($current_user->ID == $userid) { ?>
				<h4>Resume</h4>
				<p>Click the button to the left to update your resume</p>
			<?php } ?>
			
			<h2>Memberships</h2>
			
			
		</section>
		
		<section class="my_badges text-content">
			
			<?php
			$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$userid."'"); 
			?>		
			<h2>My Aquapons Badges</h2>
			<?php 
			$args = array(
				'post_type' => 'badge',
				'category_name' => 'aquapons',
				'orderby' => 'menu_order',
				'order' => 'ASC'
			);
			$query = new WP_Query( $args );
			$x = 1;
			while ( $query->have_posts() ) {
				$query->the_post();
				$aquapons_levels[$x++] = $query->post->post_title; ?>
				<div class="aquapons badge <?php if(getBadgeStatus($query->post->ID, $badge_info) === 'complete') echo "complete"; ?>">			
					<a href='<?php echo get_permalink($query->post->ID); ?>'>
						<span class="vertical_align">
						<?php echo $query->post->post_title; ?>
						</span>
					</a>
				</div>
			<?php } ?>
			
			
			
			<h2>My Content Badges</h2>
			<?php 
			// CONTENT BADGES
			for($x = 1; $x <= count($aquapons_levels); $x++) {
				$content_badge_ids = $wpdb->get_results("select * from $wpdb->postmeta AS t1 JOIN $wpdb->postmeta AS t2 JOIN $wpdb->posts as t3 
					WHERE t2.meta_value = '$x'
					AND t1.meta_key = 'badge_type' AND t1.meta_value = 'content' AND t2.meta_key = 'badge_level' AND t1.post_id = t2.post_id AND t1.post_id = t3.ID and t3.post_status = 'publish' ORDER BY t3.menu_order");
				$has_badges = false;
				foreach($content_badge_ids as $badge_id) {
					if(getBadgeStatus($badge_id->post_id, $badge_info) === 'complete') {
						$badge = get_post($badge_id);
						?>
						<?php if($has_badges == false) { $has_badges = true; ?><h3><?php echo $aquapons_levels[$x]; ?></h3><?php } ?>
						<div class="content badge <?php  echo "complete"; ?>" style="background: url(<?php echo get_field('badge_image', $badge_id->post_id); ?>) no-repeat center;">
							<a href='<?php echo get_permalink($badge->ID); ?>'>
								<?php echo $badge->post_title; ?>
							</a>
						</div>
				<?php }
				} 
			} ?>
			
	
			
			
			<h2>My Skills Badges <a href="http://aquapons.info/badges/skills-badges">View all ›</a></h2>

			<?php
			$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$userid."' AND `badge_type`='skill' AND `status` = 'complete' ORDER BY `updated` DESC LIMIT 3");
			
			if(count($badge_info)) { ?>
			<h3>Recently Completed</h3>
				<?php foreach($badge_info as $badge) {
					showBadge($badge->badge_id);
				} ?>
			<?php } ?>
	
			<?php
			$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$userid."' AND `badge_type`='skill' AND `status` != 'complete' ORDER BY `updated` DESC LIMIT 3"); 
			
			if(count($badge_info)) { ?>
			<h3>Recently Started</h3>
				<?php foreach($badge_info as $badge) { 
				showBadge($badge->badge_id);
				} ?>
			<?php } ?>
	
			<?php 
			// get most recent activity submissions
			$activity_info = $wpdb->get_results("SELECT badge_id, submission_timestamp FROM aq_badge_submissions WHERE user_id = '".$userid."' AND `current_status`='submission' ORDER BY `submission_timestamp` DESC LIMIT 15"); 

			if(count($activity_info)) { ?>
			<h3>Recent Activity</h3>

			<?php 
			// load related skills badges
			foreach($activity_info as $activity) {
				$badge_id_array[] = $activity->badge_id;
			}
			$badge_id_array = array_unique($badge_id_array);
			$badge_id_array = array_slice($badge_id_array, 0, 3);
			foreach($badge_id_array as $badge_id) {
				$badge_ids .= ' OR badge_id = '. $badge_id;
			}
			$badge_ids = substr($badge_ids, 3);
			$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$userid."' AND `badge_type`='skill' AND ($badge_ids) ORDER BY `updated` DESC LIMIT 3"); 
			
			foreach($badge_info as $badge) { ?>
				<?php showBadge($badge->badge_id); ?>
			<?php } 
			}
			?>	
		
		</section> <!-- .my_badges -->

	</section><!-- #main -->

<?php get_footer(); ?>