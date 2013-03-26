<?php 
if($_GET['post_type']=='badge') $section = 'badges';
if($_GET['post_type']=='resource') $section = 'resources';
?>


<?php get_header(); ?>

	<section class="main text-content">
		<section class="main-col">
		
		<h2>Search Results for "<?php echo $_GET['s']; ?>"</h2>
		
		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>
			
			
			
			
				<?php if(get_post_type() == 'badge') { ?>
			
					<article class="search_result badge">
						<a href="<?php echo get_permalink(); ?>"><img src="<?php echo get_field('badge_image'); ?>" alt="<?php echo get_the_title(); ?>"></a>
						<div class="info">
							<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
							<?php echo get_field('badge_description'); ?>
							<footer>
								Level: <span class="level"><?php badge_level_name(get_field('badge_level')); ?></span>
								<span class="approval">12 growers found this useful</span>
							</footer>
							</div>
						
					</article>
					
				<?php } else if(get_post_type() == 'resource') { ?>
				
					<article class="search_result resource">
						<a href="<?php echo get_permalink(); ?>"><img src="" alt="<?php echo get_the_title(); ?>"></a>
						<div class="info">
							<h4 class="meta-info">Posted <?php echo get_the_date(); ?> by <a><?php echo get_the_author(); ?></a> | <?php comments_number(); ?></h4>
							<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
							<?php the_excerpt(); ?>
							<footer>
								Level: <span class="level"><?php badge_level_name(get_field('resource_level')); ?></span>
								<span class="approval">12 growers found this useful</span>
							</footer>
						</div>
					</article>
				
				
				
				<?php } ?>
			<?php endwhile; ?>

		<?php else : ?>
			
			No results found
			
		<?php endif; ?>

		</section><!-- #main-col -->
	</section><!-- #main -->

<?php get_footer(); ?>