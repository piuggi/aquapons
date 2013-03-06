<?php $section = 'badges'; ?>
<?php get_header(); ?>
	
	<?php include(get_template_directory() . "/includes/badges_header.php"); ?>

	<section class="main">

		<?php
		$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$current_user->ID."'"); 
		?>		
		<h3>My Aquapons Badges</h3>
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
					<?php echo $query->post->post_title; ?>
				</a>
			</div>
		<?php } ?>
		
		
		
		
		
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
					<?php if($has_badges == false) { $has_badges = true; ?><h4><?php echo $aquapons_levels[$x]; ?></h4><?php } ?>
					<div class="aquapons badge <?php  echo "complete"; ?>">
						<a href='<?php echo get_permalink($badge->ID); ?>'>
							<?php echo $badge->post_title; ?>
						</a>
					</div>
			<?php }
			} 
		} ?>
		

		
		
		<h3>My Skills Badges - <a href="http://aquapons.info/badges/skills-badges">View all ></a></h3>
		<h4>Recently Completed</h4>
		<?php
		$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$current_user->ID."' AND `status` = 100 ORDER BY `updated` DESC LIMIT 3"); 
		?>

		<h4>Recently Started</h4>
		<?php
		$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$current_user->ID."' AND `status` != 100 ORDER BY `updated` DESC LIMIT 3"); 
		?>

		<h4>Recent Activity</h4>
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

	</section><!-- #main -->

<?php get_footer(); ?>