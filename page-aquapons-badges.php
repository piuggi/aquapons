<?php $section = 'badges'; ?>
<?php get_header(); ?>


	<section class="main">

		<?php 
		$cats = array('Water', 'Fish', 'Plant', 'Design + Build');
		
		
		for($x = 1; $x <= 4; $x++) {
			// load all badges at this level
			$args = array(
				'post_type' => 'badge',
				'meta_key' => 'badge_level',
				'meta_value' => $x,
			);
			$query = new WP_Query( $args );
			
			// show aquapons badges
			while ( $query->have_posts() ) {
				$query->the_post();
				if(get_field('badge_type')=='aquapons') { ?>
					<div class="aquapons badge">
						<a href='<?php echo get_permalink($page->ID) ?>'><?php the_title(); ?></a>
						(l.<?php echo get_field('badge_level', $query->post->ID); ?>)
					</div>
				<?php }
			}
			
			
			
			foreach($cats as $cat) { 
				// show content badges
				rewind_posts();
				while ( $query->have_posts() ) {
					$query->the_post();
					$wp_cats = wp_get_post_categories($query->post->ID);
					if(get_field('badge_type')=='content' && get_cat_name($wp_cats[0]) == $cat) { ?>
						<div class="content badge">
							<a href='<?php echo get_permalink($page->ID) ?>'><?php the_title(); ?></a>
							(l.<?php echo get_field('badge_level', $query->post->ID); ?>)
						</div>
					<?php }
				}
				
				// show skill badges
				rewind_posts(); 
				while ( $query->have_posts() ) {
					$query->the_post();
					$wp_cats = wp_get_post_categories($query->post->ID);
					if(get_field('badge_type')=='skill' && get_cat_name($wp_cats[0]) == $cat) { ?>
						<div class="skill badge">
							<a href='<?php echo get_permalink($page->ID) ?>'><?php the_title(); ?></a>
							(l.<?php echo get_field('badge_level', $query->post->ID); ?>)
						</div>
					<?php }
				}
			
			} // foreach($cats as $cat)
				
				
			
			
		}
		?>

	</section><!-- #main -->

<?php get_footer(); ?>