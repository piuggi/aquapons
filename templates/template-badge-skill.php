<?php include(get_template_directory() . "/includes/badges_header.php"); ?>

<?php

if($_SESSION['user_id']) $userid = $_SESSION['user_id'];
else $userid = get_current_user_id();

$badgeid = $post->ID;
$badge_status = $wpdb->get_row("SELECT * FROM `aq_badge_status` WHERE user_id = '$userid' AND badge_id = '$badgeid' LIMIT 1");
if($badge_status->status == 100) $badge_complete = true;
?>

<section class="main">



	<?php breadcrumb($post); ?>
	

	<h2><?php the_title(); ?> - Skill Badge</h2>
	<p><?php echo get_post_meta($post->ID, 'badge_description', true); ?></p>

	<p><?php echo get_post_meta($post->ID, 'activity_description', true); ?></p>
	<?php if(get_post_meta($post->ID, 'activity_response_type', true) == "image") { ?>
		<input type="file" name="activity_submission">
	<?php } ?>

	
	<?php if($badge_complete) echo "<h3>BADGE COMPLETE</h3> <div class='button send_to_backpack' badge_id='".$badgeid."' user_id='".$userid."'>Send to Backpack</div>"; ?>

	
	<?php
	$args = array(
		'post_type' => 'badge',
		'post_status' => 'publish',
		'order' => 'ASC',
		'post_parent' => $post->ID
	);
	$children = new WP_Query( $args );

	while($children->have_posts()) : $children->the_post(); ?>
		
		<?php
		if($badge_complete) {
			$activity_status = "COMPLETE";
		} else {
			$activity_id = get_the_ID();
			// LOAD CURRENT STATUS
			$activity_info = $wpdb->get_row("SELECT * FROM aq_badge_submissions WHERE user_id = '$userid' AND activity_id = '$activity_id' ORDER BY submission_timestamp DESC LIMIT 1");
			$activity_status = $activity_info->current_status;
		} 
		?>
		<a href='<?php echo get_permalink() ?>'><?php echo get_the_title() ?></a> <?php echo $activity_status ?>

	<?php endwhile; ?> 

</section><!-- #main -->