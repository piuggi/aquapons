
<?php include(get_template_directory() . "/includes/badges_header.php"); ?>

<section class="main">

	<h2><?php the_title(); ?> - Aquapons Badge</h2>
	<p><?php echo get_post_meta($post->ID, 'badge_description', true); ?></p>

	<p><?php echo get_post_meta($post->ID, 'activity_description', true); ?></p>
	<?php if(get_post_meta($post->ID, 'activity_response_type', true) == "image") { ?>
		<input type="file" name="activity_submission">
	<?php } ?>
		
	<?php
	$args = array(
		'post_type' => 'badge',
		'post_status' => 'publish',
		'order' => 'ASC',
		'post_parent' => $post->ID
	);
	$children = new WP_Query( $args );

	while($children->have_posts()) : $children->the_post(); ?>
		
		<a href='<?php echo get_permalink($page->ID) ?>'><?php echo get_the_title($page->ID) ?></a>

	<?php endwhile; ?> 
	
	


</section><!-- #main -->