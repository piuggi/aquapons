
<?php include(get_template_directory() . "/includes/badges_header.php"); ?>

<section class="main">


	
	
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
	
	<section class="badge-outline">
		<p><?php echo get_field('badge_description'); ?></p>
		<hr>
		<div class="badge-objectives">
			<h3>Learning Objectives</h3>
			<?php echo get_field('badge_objectives'); ?>
		</div>
	</section>
	
	


	<section id="skill-badge-activities">	
		<h3>Content Badges</h3>
	
		<?php
		$args = array(
			'post_type' => 'badge',
			'post_status' => 'publish',
			'order' => 'ASC',
			'post_parent' => $post->ID
		);
		$children = new WP_Query( $args );
	
		while($children->have_posts()) : $children->the_post(); ?>
		
			<div class="content badge <?php echo sanitize_title(get_the_title()); echo ' level-'.$x; ?>" style="background: url(<?php echo get_field('badge_image', $badge_id->post_id); ?>);">
				<a href='<?php echo get_permalink($page->ID); ?>'><?php the_title(); ?></a>
				<!--(l.<?php echo get_field('badge_level', $query->post->ID); ?>)-->
			</div>
			
	
		<?php endwhile; ?> 
				

	</section>

	
	


</section><!-- #main -->