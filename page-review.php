<?php $section = 'submissions'; ?>
<?php get_header(); ?>

	<section class="main">
	
		<?php
		if($_GET['result']) $current_result = $_GET['result'];
		else $current_result = 0;
		
		// PREVIOUS REVIEWS
		if($_GET['previous']) {
			$reviews = $wpdb->get_results("SELECT * FROM aq_badge_submissions WHERE current_status = 'approved' OR current_status = 'denied' ORDER BY submission_timestamp DESC LIMIT $current_result, 20");
			$pending_reviews = $wpdb->query("SELECT id FROM aq_badge_submissions WHERE current_status = 'approved' OR current_status = 'denied' ORDER BY submission_timestamp"); 
		} 
		// PENDING REVIEWS
		else {
			$reviews = $wpdb->get_results("SELECT * FROM aq_badge_submissions WHERE current_status = 'reviewing' ORDER BY submission_timestamp LIMIT $current_result, 20");
			$pending_reviews = $wpdb->query("SELECT * FROM aq_badge_submissions WHERE current_status = 'reviewing' ORDER BY submission_timestamp"); 
		}
		
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
					<h4>Status</h4>
					<p class="current_status <?php echo $review->current_status; ?>"><?php echo $review->current_status; ?></a></p>
					<h4>User</h4>
					<p><a href="/profile/?user=<?php echo $user_token; ?>"><?php echo $user_info->display_name; ?><br>
						<?php
						$user_role = $user_info->roles; 
						echo ucwords(str_replace("_", " ", $user_role[0])); ?>
					</a></p>
					<h4>Badge</h4>
					<p><a href="<?php echo get_permalink($badge_id); ?>?user=<?php echo $user_token; ?>"><?php echo $badge_name ?></a></p>
					<p><a class="button" href="<?php echo get_permalink($badge_id); ?>?user=<?php echo $user_token; ?>">View User's Submissions</a></p>
				</div>
				<div class="review_inputs">
					<label for="reviewer_comments"><h4>Reviewer Comments</h4></label>
					<textarea class="approval_comments" id="reviewer_comments" placeholder="All rejected badge submissions must include a written explanation of decision."><?php echo stripslashes($review->reviewer_comment); ?></textarea>
					<input type="button" class="approve_badge" submission_id="<?php echo $submission_id ?>" badge_id="<?php echo $badge_id ?>" activity_id="<?php echo $activity_id ?>" user_id="<?php echo $user_email ?>" user_token="<?php echo $user_token ?>" evidence="<?php echo $evidence ?>" version="<?php echo $version ?>" badgename="<?php echo $badge_name ?>" badgeimage="<?php echo $badge_image ?>" <?php /*description="< ?php echo $description ? >" criteria="< ?php echo $criteria ? >" */?> expires="<?php echo $expires ?>" reviewer_id="<?php echo get_current_user_id(); ?>" value="Approve">
					<input type="button" class="reject_badge" value="Reject">

				</div>
			</div>
			

		<?php 
		} 
		
		
		// PAGINATION
		if($pending_reviews > 20) { ?>
			<header id="pagination"><ul>
			<?php 
			if($_GET['previous']) $previous = "&previous=true";
			if($current_result != 0 && $current_result) {
				echo "<li><a href='review/?result=".($current_result - 20)."$previous'>Older Reviews</a></li>";	
			}
			if($current_result+20 < $pending_reviews) {
				echo "<li><a href='review/?result=".($current_result + 20)."$previous'>Newer Reviews</a><li>";	
			}
			?>
			</ul></header>
			
		<?php } ?>
		
		
		
		
		
		
		
			
	</section><!-- #main -->

<?php get_footer(); ?>