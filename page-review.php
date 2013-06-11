<?php $section = 'submissions'; ?>
<?php get_header(); ?>

	<section class="main">
	
	

		<?php 
		$reviews = $wpdb->get_results("SELECT * FROM aq_badge_submissions WHERE current_status = 'reviewing' ORDER BY submission_timestamp");
		
		foreach($reviews as $review) { ?>

			
			<?php 
			// load up review info
			
			$submission_id = $review->id;
			$badge_id = $review->badge_id;
			$activity_id = $review->activity_id;
			$activity_name = get_the_title($activity_id);
			
			
			
		
		
			$user_info = get_userdata($review->user_id);
			$user_email = $user_info->user_email;
			$user_meta = $wpdb->get_row("SELECT * FROM aq_usermeta WHERE wp_user_id = '".$review->user_id."' LIMIT 1");
			$user_token = $user_meta->user_token_id;
			$evidence = get_permalink($badge_id)."?user=".$user_token;
			$version = get_post_meta($badge_id, 'badge_version', true);
			$badge_name = get_the_title($badge_id);
			$badge_image = get_field('badge_image', $badge_id);//get_post_meta($badge_id, 'badge_image', true);
			$description = get_post_meta($badge_id, 'badge_description', true);
			$criteria = get_permalink($badge_id);
			$expires = "";
			
			
			
			// IF ACTIVITY, EITHER APPROVE OR DENY
			
			// IF ACTIVITY LEADS TO BADGE, APPROVE OR DENY, THEN GRANT BADGES, AND THEN GO THROUGH OPENBADGES PROCESS
			
			?>
			
			<div class="pending_review">
				<div class="submission_info">
					<h4>User</h4>
					<p><a href="/profile/?user=<?php echo $user_token; ?>"><?php echo $user_info->display_name; ?><br>
						<?php
						$user_role = $user_info->roles; 
						echo ucwords(str_replace("_", " ", $user_role[0])); ?>
					</a></p>
					<h4>Badge</h4>
					<p><a href="<?php echo get_permalink($badge_id); ?>?user=<?php echo $user_token; ?>"><?php echo $badge_name ?></a></p>
				</div>
				<div class="review_inputs">
					<!-- <p>Badge Description: <?php echo $description ?></p> -->
					<label for="reviewer_comments"><h4>Reviewer Comments</h4></label>
					<textarea class="approval_comments" id="reviewer_comments" placeholder="All rejected badge submissions must include a written explanation of decision."></textarea>
					<input type="button" class="approve_badge" submission_id="<?php echo $submission_id ?>" badge_id="<?php echo $badge_id ?>" activity_id="<?php echo $activity_id ?>" user_id="<?php echo $user_email ?>" user_token="<?php echo $user_token ?>" evidence="<?php echo $evidence ?>" version="<?php echo $version ?>" badgename="<?php echo $badge_name ?>" badgeimage="<?php echo $badge_image ?>" <?php /*description="< ?php echo $description ? >" criteria="< ?php echo $criteria ? >" */?> expires="<?php echo $expires ?>" reviewer_id="<?php echo get_current_user_id(); ?>" value="Approve">
					<input type="button" class="reject_badge" value="Reject">

				</div>
			</div>
			

		<?php } ?>
			
	</section><!-- #main -->

<?php get_footer(); ?>