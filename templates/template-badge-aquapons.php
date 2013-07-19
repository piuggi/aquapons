
<?php include(get_template_directory() . "/includes/badges_header.php"); ?>


<?php

if($_SESSION['user_id']) $userid = $_SESSION['user_id'];
else $userid = get_current_user_id();

$badgeid = $post->ID;
$badge_status = $wpdb->get_row("SELECT * FROM `aq_badge_status` WHERE user_id = '$userid' AND badge_id = '$badgeid' LIMIT 1");
if($badge_status->status == 'complete') $badge_complete = true;
?>

<section class="main">


	
	
	<section id="badge-nav">	
		
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
	
	


	<section id="skill-badge-activities">	
		<h3>In order to earn this badge, you must complete the badges in these content areas:</h3>
	
		<?php
		$args = array(
			'post_type' => 'badge',
			'post_status' => 'publish',
			'order' => 'ASC',
			'post_parent' => $post->ID
		);
		$children = new WP_Query( $args );
	
		while($children->have_posts()) : $children->the_post(); ?>
		
			<div class="content badge <?php echo sanitize_title(get_the_title()); echo ' level-'.$x; ?>" style="vertical-align: top; background: url(<?php echo get_field('badge_image', $badge_id->post_id); ?>) no-repeat center;">
				<a href='<?php echo get_permalink($page->ID); ?>'><?php the_title(); ?></a>
				<!--(l.<?php echo get_field('badge_level', $query->post->ID); ?>)-->
			</div>
			
	
		<?php endwhile; ?> 
				

	</section>

	
	


</section><!-- #main -->