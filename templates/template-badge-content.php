<?php include(get_template_directory() . "/includes/badges_header.php"); ?>

<?php

if($_SESSION['user_id']) $userid = $_SESSION['user_id'];
else $userid = get_current_user_id();

$badgeid = $post->ID;
$badge_status = $wpdb->get_row("SELECT * FROM `aq_badge_status` WHERE user_id = '$userid' AND badge_id = '$badgeid' LIMIT 1");
if($badge_status->status == 100) $badge_complete = true;
?>

	<section id="badge-nav">
	<h2>
		<?php the_title(); ?>
		<?php if($badge_complete) echo "<span class='badge-complete'>BADGE COMPLETE</span> <span class='send_to_backpack' badge_id='".$badgeid."' user_id='".$userid."'>Send to Backpack</span>"; ?>
	</h2>
	<hr/>
	<ul id="skill-badge-subnav">
		<li><a>Activities Overview</a></li>
		<li>•</li>
		<li><a>Completed Activities</a></li>
		<li>•</li>
		<li><a>Activities in Progress</a></li>
		<li>•</li>
		<li><a>Related Resources</a></li>
	</ul>
	</section>
	
	<section id="skill-badge-outline">
		<p><?php echo get_post_meta($post->ID, 'badge_description', true); ?></p>
		<hr>
		<div class="badge-objectives">
			<?php echo get_field('badge_objectives', $post->ID); ?>
		</div>
	</section>
	
	


	<section id="skill-badge-activities">	
		<h3>Required Skills</h3>

		<?php
		$args = array(
			'post_type' => 'badge',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => -1,
			'post_parent' => $post->ID
		);
		$children = new WP_Query( $args );
		while($children->have_posts()) : $children->the_post(); ?>
			
			
			<?php
			if($badge_complete) {
				$activity_status = "COMPLETE";
				//break;
			} else {
				$activity_id = get_the_ID();
				// LOAD CURRENT STATUS
				$activity_info = $wpdb->get_row("SELECT * FROM aq_badge_submissions WHERE user_id = '$userid' AND activity_id = '$activity_id' ORDER BY submission_timestamp DESC LIMIT 1");
				$activity_status = $activity_info->current_status;
			} 
			?>
			
			<article class="badge skill">
				
				<a href='<?php echo get_permalink() ?>'><?php echo get_the_title() ?></a> 
				<hr/>
				<?php echo $activity_status ?>
			</article>

		<?php endwhile; ?> 
	</section>
