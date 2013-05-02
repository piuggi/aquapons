<?php $section = 'resources'; ?>
<?php get_header(); ?>


		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();  
			
			$page_class = sanitize_title(get_the_title());
			$page_class = strtolower($page_class);
			?>
			<section id="main" class="<?php echo $page_class;?> text-content">
				
			 	<section class="main-col">
			 	
			 	
					<h2>Books <a href="http://aquapons.info/resources/books/">View all ›</a></h2>
					<?php
					$args = array(
						'post_type' => 'resource',
						'meta_key' => 'resource_type',
						'meta_value' => 'book',
						'orderby' => 'post_date',
						'order' => 'ASC',
						'posts_per_page' => 3
					);
					$query = new WP_Query( $args );
					while($query->have_posts()) {
						$query->the_post();
					?>
						<article class="resource">
							<a href="<?php echo get_permalink(); ?>"><?php echo wp_get_attachment_image(get_field('resource_image'), 'tutorial-thumb'); ?></a>
							<div class="info">
								<h4 class="meta-info">Posted <?php echo get_the_date(); ?> by <a><?php echo get_the_author(); ?></a> | <?php comments_number(); ?></h4>
								<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
								<?php the_excerpt(); ?>
								<p><a href="<?php echo get_field('link_url'); ?>">link</a></p>
								<footer>
									Level: <span class="level"><?php badge_level_name(get_field('resource_level')); ?></span>
									<span class="approval">12 growers found this useful</span>
								</footer>
							</div>
						</article>
					<?php } ?>	
			 	
					<h2>Articles <a href="http://aquapons.info/resources/articles/">View all ›</a></h2>
					<?php
					$args = array(
						'post_type' => 'resource',
						'meta_key' => 'resource_type',
						'meta_value' => 'article',
						'orderby' => 'post_date',
						'order' => 'ASC',
						'posts_per_page' => 3
					);
					$query = new WP_Query( $args );
					while($query->have_posts()) {
						$query->the_post();
					?>
						<article class="resource">
							<a href="<?php echo get_permalink(); ?>"><?php echo wp_get_attachment_image(get_field('resource_image'), 'tutorial-thumb'); ?></a>
							<div class="info">
								<h4 class="meta-info">Posted <?php echo get_the_date(); ?> by <a><?php echo get_the_author(); ?></a> | <?php comments_number(); ?></h4>
								<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
								<?php the_excerpt(); ?>
								<p><a href="<?php echo get_field('link_url'); ?>">link</a></p>
								<footer>
									Level: <span class="level"><?php badge_level_name(get_field('resource_level')); ?></span>
									<span class="approval">12 growers found this useful</span>
								</footer>
							</div>
						</article>
					<?php } ?>	
			 	
					<h2>Presentations <a href="http://aquapons.info/resources/presentations/">View all ›</a></h2>
					<?php
					$args = array(
						'post_type' => 'resource',
						'meta_key' => 'resource_type',
						'meta_value' => 'presentation',
						'orderby' => 'post_date',
						'order' => 'ASC',
						'posts_per_page' => 3
					);
					$query = new WP_Query( $args );
					while($query->have_posts()) {
						$query->the_post();
					?>
						<article class="resource">
							<a href="<?php echo get_permalink(); ?>"><?php echo wp_get_attachment_image(get_field('resource_image'), 'tutorial-thumb'); ?></a>
							<div class="info">
								<h4 class="meta-info">Posted <?php echo get_the_date(); ?> by <a><?php echo get_the_author(); ?></a> | <?php comments_number(); ?></h4>
								<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
								<?php the_excerpt(); ?>
								<p><a href="<?php echo get_field('link_url'); ?>">link</a></p>
								<footer>
									Level: <span class="level"><?php badge_level_name(get_field('resource_level')); ?></span>
									<span class="approval">12 growers found this useful</span>
								</footer>
							</div>
						</article>
					<?php } ?>	
			 	
					<h2>Recent Links <a href="http://aquapons.info/resources/links/">View all ›</a></h2>
					<?php
					$args = array(
						'post_type' => 'resource',
						'meta_key' => 'resource_type',
						'meta_value' => 'link',
						'orderby' => 'post_date',
						'order' => 'ASC',
						'posts_per_page' => 3
					);
					$query = new WP_Query( $args );
					while($query->have_posts()) {
						$query->the_post();
					?>
						<article class="resource">
							<a href="<?php echo get_permalink(); ?>"><?php echo wp_get_attachment_image(get_field('resource_image'), 'tutorial-thumb'); ?></a>
							<div class="info">
								<h4 class="meta-info">Posted <?php echo get_the_date(); ?> by <a><?php echo get_the_author(); ?></a> | <?php comments_number(); ?></h4>
								<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
								<?php the_excerpt(); ?>
								<p><a href="<?php echo get_field('link_url'); ?>">link</a></p>
								<footer>
									Level: <span class="level"><?php badge_level_name(get_field('resource_level')); ?></span>
									<span class="approval">12 growers found this useful</span>
								</footer>
							</div>
						</article>
					<?php } ?>	
			 	
					<h2>Products <a href="http://aquapons.info/resources/products/">View all ›</a></h2>
					<?php
					$args = array(
						'post_type' => 'resource',
						'meta_key' => 'resource_type',
						'meta_value' => 'product',
						'orderby' => 'post_date',
						'order' => 'ASC',
						'posts_per_page' => 3
					);
					$query = new WP_Query( $args );
					while($query->have_posts()) {
						$query->the_post();
					?>
						<article class="resource">
							<a href="<?php echo get_permalink(); ?>"><?php echo wp_get_attachment_image(get_field('resource_image'), 'tutorial-thumb'); ?></a>
							<div class="info">
								<h4 class="meta-info">Posted <?php echo get_the_date(); ?> by <a><?php echo get_the_author(); ?></a> | <?php comments_number(); ?></h4>
								<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
								<?php the_excerpt(); ?>
								<p><a href="<?php echo get_field('link_url'); ?>">link</a></p>
								<footer>
									Level: <span class="level"><?php badge_level_name(get_field('resource_level')); ?></span>
									<span class="approval">12 growers found this useful</span>
								</footer>
							</div>
						</article>
					<?php } ?>	
								
					</section>
			
			 
			<?php
				// print post results
				//the_title();
			endwhile;
			?>

		<?php else : ?>
			
			Oops. No content found.
			
		<?php endif; ?>

	</section><!-- #main -->

<?php get_footer(); ?>