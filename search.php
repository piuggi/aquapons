<?php 
if($_GET['post_type']=='badge') $section = 'badges';
if(strpos($_GET['post_type'], 'resource') !== false) $section = 'resources';
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
						<a href="<?php echo get_permalink(); ?>">
							<?php if(get_field('badge_image')) { ?>
								<img src="<?php echo get_field('badge_image'); ?>" alt="<?php echo get_the_title(); ?>">
							<?php } else { ?>
								<img src="<?php echo get_template_directory_uri() ?>/imgs/placeholder-search.png" alt="<?php echo get_the_title(); ?>">
							<?php } ?>
						</a>
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
						<a href="<?php echo get_permalink(); ?>">
							<?php if(get_field('badge_image')) { ?>
								<img src="<?php echo get_field('resource_image'); ?>" alt="<?php echo get_the_title(); ?>">
							<?php } else { ?>
								<img src="<?php echo get_template_directory_uri() ?>/imgs/placeholder-search.png" alt="<?php echo get_the_title(); ?>">
							<?php } ?>
						</a>
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
				
				
				
				<?php } else if(get_post_type() == 'discussion') { ?>
				
					<article class="search_result discussion">						
						<a href="<?php echo get_permalink(); ?>">
							<img src="<?php echo get_template_directory_uri() ?>/imgs/placeholder-search.png" alt="<?php echo get_the_title(); ?>">
						</a>
						<div class="info">
							<h4 class="meta-info">Posted <?php echo get_the_date(); ?> by <a><?php echo get_the_author(); ?></a> | <?php comments_number(); ?></h4>
							<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
							<?php the_excerpt(); ?>
							<footer>
								<span class="approval"><?php echo get_field('answers'); ?> people have answered this | <?php echo get_field('votes'); ?> growers found this useful</span>
							</footer>
						</div>
					</article>
				
				
				
				<?php } ?>
				
			<?php endwhile; ?>
			
			<?php if($wp_query->max_num_pages>1): ?>
				<?php
					
				    $big = 999999999;
					$paginate_args = array(
						'type'=> 'list',
						'format'=> 'page/%#%',	                                            
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				        //'format' => '?paged=%#%',
				        'current' => max( 1, get_query_var('paged') ),
					    'total' => $wp_query->max_num_pages,
                       );
		        ?>
		        <header id="pagination">
		        	<?php  echo paginate_links( $paginate_args); ?>
		        </header>
	        <?php endif; ?>

		<?php else : ?>
			
			No results found
			
		<?php endif; ?>
		
        <header id="pagination">
        	<?php echo paginate_links(); ?>
        </header> 
        

		</section><!-- #main-col -->
	</section><!-- #main -->

<?php get_footer(); ?>