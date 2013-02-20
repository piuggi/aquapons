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
				<p>User: <?php echo $user_email ?></p>
				<p><a href="<?php echo get_permalink($badge_id); ?>"><?php echo $badge_name ?></a></p>
				<p><a href="<?php echo get_permalink($activity_id); ?>"><?php echo $activity_name ?></a></p>
				<p>Description: <?php echo $description ?></p>
				<p>User Submission: <?php echo stripslashes($review->data); ?></p>
				<textarea class="approval_comments" placeholder="All rejected badge submissions must include a written explanation"></textarea>
				<div class="approve_badge button" submission_id="<?php echo $submission_id ?>" badge_id="<?php echo $badge_id ?>" activity_id="<?php echo $activity_id ?>" user_id="<?php echo $user_email ?>" user_token="<?php echo $user_token ?>" evidence="<?php echo $evidence ?>" version="<?php echo $version ?>" badgename="<?php echo $badge_name ?>" badgeimage="<?php echo $badge_image ?>" description="<?php echo $description ?>" criteria="<?php echo $criteria ?>" expires="<?php echo $expires ?>" reviewer_id="<?php echo get_current_user_id(); ?>">Approve</div>
				<div class="reject_badge button">Reject</div>
			</div>
			

		<?php } ?>
			
	</section><!-- #main -->

<?php get_footer(); ?>