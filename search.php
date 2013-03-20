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
						<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
						<?php echo get_field('badge_description'); ?>
						<footer>
							Level: <span class="level">Senior Apprentice</span>
							<span class="approval">12 growers found this useful</span>
						</footer>
						
						
					</article>
					
				<?php } else if(get_post_type() == 'resource') { ?>
				
					<article class="search_result tutorial">
						<a href="<?php echo get_permalink(); ?>"><img src="" alt="<?php echo get_the_title(); ?>"></a>
						<h4 class="meta-info">Posted 3 days ago by <a>Username123</a> | 3 comments</h4>
						<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
						<?php the_excerpt(); ?>
						<footer>
							Level: <span class="level">Senior Apprentice</span>
							<span class="approval">12 growers found this useful</span>
						</footer>
					</article>
				
				
				
				<?php } ?>
			<?php endwhile; ?>

		<?php else : ?>
			
			No results found
			
		<?php endif; ?>

		</section><!-- #main-col -->
	</section><!-- #main -->

<?php get_footer(); ?>