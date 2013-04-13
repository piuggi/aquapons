<?php $section = 'profile'; ?>

<?php

if($_SESSION['user_id']) $userid = $_SESSION['user_id'];
else $userid = get_current_user_id();

?>
<?php get_header(); ?>


	<section class="main">
		<section class="background text-content <?php if($current_user->ID == $userid) echo "editable"; ?>">
			
			<?php
			//if logged in and current profile page == current user, show edit buttons
			if($current_user->ID == $userid) { ?>
				<div class="edit_setting edit_background">Edit</div>
			<?php 
			}
			
			$background_info = $wpdb->get_row("SELECT * FROM aq_usermeta WHERE wp_user_id = '".$userid."'"); 
			?>
			
			<h2>Background</h2>
				
				<div class="background_display">
				<h4>Member Since</h4>
				<p><?php echo date("F, Y", strtotime(get_userdata($userid)->user_registered)); ?></p>
				
				<h4>Current City</h4>
				<p><?php echo $background_info->location; ?></p>
				
				<h4>Education</h4>
				<?php
				$schools = $wpdb->get_results("SELECT * FROM aq_education WHERE user_id = '".$userid."'"); 
				foreach($schools as $school) {
				?>
				<div class="school">
					<h5><a href="<?php echo $school->url; ?>"><?php echo $school->name; ?></a></h5>
					<h6><?php echo $school->accredidation; ?></h6>
				</div>
				<?php } ?>
				
				<h4>Professional Experience</h4>
				<div class="company">
					<h5><a href="">Some Company Name</a></h5>
					<h6>Nutritionist</h6>
				</div>
				
			</div>
			
			
			
			<div class="background_admin">
				
				<h4>Current City</h4>
				<input class='current_city' value='<?php echo $background_info->location; ?>'>
				
				<h4>Education</h4>
				<?php
				$schools = $wpdb->get_results("SELECT * FROM aq_education WHERE user_id = '".$userid."'"); 
				foreach($schools as $school) {
				?>
				<div class="school">
					<input class='school_name' value='<?php echo $school->name; ?>' placeholder="School Name">
					<input class='school_name' value='<?php echo $school->url; ?>' placeholder="School Website">
					<input class='school_name' value='<?php echo $school->accredidation; ?>' placeholder="Degree/Certificate earned">
				</div>
				<?php } ?>
				<div class="new school">
					<label>Add new school</label>
					<input class='school_name' placeholder="School Name">
					<input class='school_url' placeholder="School Website">
					<input class='degree' placeholder="Degree/Certificate earned">
				</div>
				
				<h4>Professional Experience</h4>
				<?php
				$jobs = $wpdb->get_results("SELECT * FROM aq_experience WHERE user_id = '".$userid."'"); 
				foreach($jobs as $job) {
				?>
				<div class="company">
					<input class='company_name' value='<?php echo $job->company; ?>' placeholder="Company/Institution Name">
					<input class='company_name' value='<?php echo $job->url; ?>' placeholder="Company/Institution Website">
					<input class='job_title' value='<?php echo $job->title; ?>' placeholder="Job Title">
				</div>
				<?php } ?>
				<div class="new company">
					<label>Add New:</label>
					<input class='company_name' placeholder="Company/Institution Name">
					<input class='company_name' placeholder="Company/Institution Website">
					<input class='job_title' placeholder="Job Title">
				</div>
				
				<input type="button" value="Save Changes">
			
			</div>
			
			
			
			<?php if($current_user->ID == $userid) { ?>
				<div class="edit_setting edit_resume">Upload</div>
			<?php } ?>
			
			<h4>Resume</h4>
			<p><a href="#">Download ›</a>
			
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
				<div class="aquapons badge <?php if(getBadgeStatus($query->post->ID, $badge_info) == 100) echo "complete"; ?>">			
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
					if(getBadgeStatus($badge_id->post_id, $badge_info) == 100) {
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
			<h3>Recently Completed</h3>
			<?php
			$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$current_user->ID."' AND `status` = 100 ORDER BY `updated` DESC LIMIT 3"); 
			?>
	
			<h3>Recently Started</h3>
			<?php
			$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$current_user->ID."' AND `status` != 100 ORDER BY `updated` DESC LIMIT 3"); 
			?>
	
			<h3>Recent Activity</h3>
			<?php
			// get most recent activity submissions
			$activity_info = $wpdb->get_results("SELECT * FROM aq_badge_submissions WHERE user_id = '".$current_user->ID."' ORDER BY `submission_timestamp` DESC LIMIT 10"); 
			// load related skills badges
			foreach($activity_info as $activity) {
				$badge_id_array[] = $activity->badge_id;
			}
			$badge_id_array = array_unique($badge_id_array);
			foreach($badge_id_array as $badge_id) {
				$badge_ids .= ' OR badge_id = '. $badge_id;
			}
			$badge_ids = substr($badge_ids, 3);
			$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$current_user->ID."' AND ($badge_ids) ORDER BY `updated` DESC LIMIT 3"); 
			?>		
		
		</section> <!-- .my_badges -->

	</section><!-- #main -->

<?php get_footer(); ?>