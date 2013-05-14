<?php $section = 'badges'; ?>
<?php get_header(); ?>


	<section id="main" class="text-content">

		<?php 
		$cats = array('Water', 'Fish', 'Plant', 'Design + Build');
		
		$badge_info = $wpdb->get_results("SELECT * FROM aq_badge_status WHERE user_id = '".$current_user->ID."'"); 
		
		$args = array(
			'post_type' => 'badge',
			'posts_per_page' => -1,
			'meta_key' => 'badge_level',
			'orderby' => 'meta_value_num menu_order',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'badge_type',
					'value' => 'skill'
				)
			)
		);
		$query = new WP_Query( $args );
		?>
		<?php if ( $query->have_posts() ) : ?>
		<?php foreach($cats as $cat) { ?>
		<?php rewind_posts(); ?>
		<h2><?php echo $cat; ?> Badges <span class="show_category_descriptions">?</span></h2>
		<section class="skills-row <?php echo sanitize_title(strtolower($cat)); ?> side-scroller">
			<?php
			/* Start the Loop */
			while ( $query->have_posts() ) : 
			$query->the_post(); 
			$wp_cats = wp_get_post_categories($query->post->ID);
			if(get_cat_name($wp_cats[0]) == $cat) {
				$cat_descriptions[$cat] = category_description($wp_cats[0]);
			?>
			
				<div class="skill badge <?php echo sanitize_title(get_the_title()); echo ' level-'.$x; ?>">
					<a href='<?php echo get_permalink($page->ID); ?>'><?php the_title(); ?></a>
					<hr>
					<div class="badge_level"><?php echo get_field('badge_level', $query->post->ID); ?></div>
					<?php if($current_badge_status = getBadgeStatus($query->post->ID, $badge_info)) { ?>
						<div class="status_container">
							<?php if($current_badge_status < 100) { ?>
								<div class="completion_container">
									<div class="badge_completion" style="width: <?php echo $current_badge_status/4; ?>px"><?php echo $current_badge_status; ?>%</div>
								</div>
							<?php } ?>
							<div class="badge_completion_label">
								<?php if($current_badge_status == 100) echo "COMPLETE";
								else echo $current_badge_status . "%"; ?>
								</div>
						</div>
					<?php } ?>
				</div>

			<?php } ?>

			<?php endwhile; ?>
		</section>
		
		<?php } ?>
		
		<?php else : ?>
			
			No content found
			
		<?php endif; ?>
		<div class="category_descriptions_mask"></div>
		<div class="category_descriptions">
			<div class="close_category_descriptions">X</div>
			<?php 
			foreach($cats as $cat) { ?>
				<section class="category_info">
					<h2><?php echo $cat; ?></h2>
					<p><?php echo $cat_descriptions[$cat]; ?></p>
				</section>
			<?php } ?>
		</div>

	</section><!-- #main -->

<?php get_footer(); ?>