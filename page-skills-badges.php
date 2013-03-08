<?php $section = 'badges'; ?>
<?php get_header(); ?>


	<section class="main">

		<?php 
		$cats = array('Water', 'Fish', 'Plant', 'Design + Build');
			
		$args = array(
			'post_type' => 'badge',
			'posts_per_page' => 10,
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
		<section class="<?php echo sanitize_title(strtolower($cat)); ?>">
			<h2><?php echo $cat; ?> Badges <span class="show_category_descriptions">?</span></h2>
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
					<!--(l.<?php echo get_field('badge_level', $query->post->ID); ?>)-->
				</div>

			<?php } ?>

			<?php endwhile; ?>
		</section>
		
		<?php } ?>
		
		<?php else : ?>
			
			No content found
			
		<?php endif; ?>
		
		<section class="category_descriptions">
			<div class="close_category_descriptions">X</div>
			<?php 
			foreach($cats as $cat) { ?>
				<section class="category_info">
					<h2><?php echo $cat; ?></h2>
					<p><?php echo $cat_descriptions[$cat]; ?></p>
				</section>
			<?php } ?>
		</section>

	</section><!-- #main -->

<?php get_footer(); ?>