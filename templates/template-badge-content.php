<?php include(get_template_directory() . "/includes/badges_header.php"); ?>

<?php

if($_SESSION['user_id']) $userid = $_SESSION['user_id'];
else $userid = get_current_user_id();

$badgeid = $post->ID;
$badge_status = $wpdb->get_row("SELECT * FROM `aq_badge_status` WHERE user_id = '$userid' AND badge_id = '$badgeid' LIMIT 1");
if($badge_status->status === 'complete') $badge_complete = true;
$current_userdata = get_userdata($userid);
?>

	<section id="badge-nav">	
		<?php breadcrumb($post); ?>
		
		<?php if(isset($_SESSION['reviewing'])) { ?>
			<div class="badge_status_container">
				<h3 class="this_badge_status"><a href="?stop_reviewing=true">X </a> CURRENTLY REVIEWING <?php echo $current_userdata->user_nicename; ?>'S WORK</h3>
			</div>
		<?php } elseif($badge_complete) { ?>
		<div class="badge_status_container">
			<h3 class="this_badge_status">
				COMPLETE
			</h3>
			<?php if($badge_complete && !$badge_status->submitted_to_obi) { ?>
				<?php if(!$userid || $current_user->ID == $userid){ ?>
					<div class="send_to_backpack" data-badge-id="<?php echo get_the_ID(); ?>" data-user-id="<?php echo $current_user->ID; ?>"><img src="http://aquapons.info/wp-content/uploads/2013/07/obi-icon.png" alt="Send to Mozilla Backpack"> <span>Send to Backpack</span></div>
				<?php } ?>
			<?php } ?>
		</div>
		<?php } ?>
		
		<h2>
			<?php the_title(); ?>
		</h2>
		<hr/>
		<ul id="skill-badge-subnav">
<!--
			<li><a>Activities Overview</a></li>
			<li>•</li>
			<li><a>Completed Activities</a></li>
			<li>•</li>
			<li><a>Activities in Progress</a></li>
			<li>•</li>
			<li><a>Related Resources</a></li>
-->
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
	<div class="toggle-outline">Badge Outline ↕</div>

	
	


	<section id="skill-badge-activities">	
		<h3>In order to earn this badge, you must complete these required Skills:</h3>

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
			
			<?php showBadge($children->post->ID); ?>


		<?php endwhile; ?> 
	</section>
