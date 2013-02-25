<?php $section = 'badges'; ?>
<?php get_header(); ?>


	<section class="main">

		<?php 
		$cats = array('Water', 'Fish', 'Plant', 'Design + Build');
			
		$args = array(
			'post_type' => 'badge',
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
		<section>
			<h3><?php echo $cat; ?> Badges</h3>
			<?php
			/* Start the Loop */
			while ( $query->have_posts() ) : 
			$query->the_post(); 
			$wp_cats = wp_get_post_categories($query->post->ID);
			if(get_cat_name($wp_cats[0]) == $cat) {?>

				<div class="content badge">
					<a href='<?php echo get_permalink($page->ID) ?>'><?php the_title(); ?></a>
					(l.<?php echo get_post_meta($query->post->ID, 'badge_level', true); ?>)
				</div>
			
			<?php } ?>

			<?php endwhile; ?>
		</section>
		
		<?php } ?>
		
		<?php else : ?>
			
			No content found
			
		<?php endif; ?>

	</section><!-- #main -->

<?php get_footer(); ?>