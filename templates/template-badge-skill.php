<?php include(get_template_directory() . "/includes/badges_header.php"); ?>

<?php

if($_SESSION['user_id']) $userid = $_SESSION['user_id'];
else $userid = get_current_user_id();

$badgeid = $post->ID;
$badge_status = $wpdb->get_row("SELECT * FROM `aq_badge_status` WHERE user_id = '$userid' AND badge_id = '$badgeid' LIMIT 1");
if($badge_status->status == 'complete') $badge_complete = true;
?>

	<section id="badge-nav">
		<?php breadcrumb($post); ?>
		
		<?php if($badge_complete) { ?>
		<div class="badge_status_container">
			<h3 class="this_badge_status">
				COMPLETE
			</h3>
			<!-- <div class='send_to_backpack' badge_id='".$badgeid."' user_id='".$userid."'><img src="<?php echo get_template_directory_uri() ?>/imgs/mozilla_obi.png" alt="Mozilla OBI Backpack"> Send to Backpack</div> -->
		</div>
		<?php } ?>
		
		<h2>
			<?php the_title(); ?>
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
	
	<section class="badge-outline">
		<p><?php echo get_field('badge_description'); ?></p>
		<hr>
		<div class="badge-objectives">
			<h3>Learning Objectives</h3>
			<?php echo get_field('badge_objectives'); ?>
		</div>
	</section>
	
	


	<section id="skill-badge-activities">	
	<h3>In order to earn this badge, you must complete these Activities:</h3>

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
		$ready_for_eval = true;
		while($children->have_posts()) : $children->the_post(); ?>
			
			
			<?php
			if($badge_complete) {
				$activity_status = "complete";
				//break;
			} else {
				$activity_id = get_the_ID();
				// LOAD CURRENT STATUS
				$activity_info = $wpdb->get_row("SELECT * FROM aq_badge_submissions WHERE user_id = '$userid' AND activity_id = '$activity_id' ORDER BY submission_timestamp DESC LIMIT 1");
				$activity_status = $activity_info->current_status;
				if(!get_field('self_evaluation') && $activity_status != 'complete') $ready_for_eval = false;
			} 
			?>
			
			<?php if(get_field('self_evaluation') && !$ready_for_eval) { ?>
			<article class="skill-activity disabled">
			<?php } else { ?>
			<a href='<?php echo get_permalink() ?>'>
			<article class="skill-activity">
			<?php } ?>
				<h4><?php echo get_the_title() ?></h4>
				<hr/>
				<h4 class="status_container badge_completion_label">
					<?php 
					if($activity_status == 'complete') echo "COMPLETE";
					else if(get_field('self_evaluation') && $activity_status == 'reviewing') echo "Reviewing";
					else if($activity_status) echo "In Progress";
					?>
				</h4>
			</article>
			</a>

		<?php  
			$c++;
			endwhile; ?> 
	</section>
