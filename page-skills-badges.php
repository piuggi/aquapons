<?php $section = 'badges'; ?>
<?php get_header(); ?>


	<section id="main" class="text-content">

		<?php 
		$cats = array('Water', 'Fish', 'Plant', 'Design + Build', 'Impact');
		
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
		<h2><?php echo $cat; ?> Badges <span class="show_category_descriptions help_button">?</span></h2>
		<section class="skills-row side-scroller">
			<?php
			/* Start the Loop */
			while ( $query->have_posts() ) : 
			$query->the_post(); 
			$wp_cats = wp_get_post_categories($query->post->ID);
			if(get_cat_name($wp_cats[0]) == $cat || get_cat_name($wp_cats[1]) == $cat) {
				$cat_descriptions[$cat] = category_description($wp_cats[0]);

				showBadge($query->post->ID);
			} ?>

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