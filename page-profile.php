<?php $section = 'profile'; ?>
<?php get_header(); ?>
<?php $theme = new ThemeCheck(); ?>
	<section class="main">
		<section class="background">
			<h3>Background</h3>
		</section>
		
		<section class="my_badges">
			<?php
			$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$current_user->ID."'"); 
			?>
			
			<h3>My Aquapons Badges</h3>
			<?php 
			$aquapons_badge_ids = array(34, 38, 40, 42);
			foreach($aquapons_badge_ids as $aquapons_badge) { 
				$badge = get_post($aquapons_badge);
				?>
			<div class="aquapons badge <?php if(getBadgeStatus($aquapons_badge, $badge_info) == 100) echo "complete"; ?>">
				<a href='<?php echo get_permalink($badge->ID) . $theme->url(); ?>'>
					<?php echo $badge->post_title; ?>
				</a>
			</div>
			<?php } ?>
			
			
			
			
			
			<h4>Junior Apprentice</h4>
			<h4>Senior Apprentice</h4>
			<h4>Journeymon</h4>
			<h4>Master</h4>
			
			
			
			
			<h3>My Skills Badges - View all></h3>
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

		
		</section>

	</section><!-- #main -->

<?php get_footer(); ?>