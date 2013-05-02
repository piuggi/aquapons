<?php $section = 'community'; ?>
<?php get_header(); ?>


		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();  
			
			$page_class = sanitize_title(get_the_title());
			$page_class = strtolower($page_class);
			?>
			<section id="main" class="<?php echo $page_class;?>">
				

				<section class="text-content">
						
					<section class="main-col">						
							
						<h2>Institutions</h2>
							
						<?php  
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
							$institution_args = array(
									'post_type'=> 'institution',
									'orderby'=> 'date',
									'order'	=> 'DESC',
									'paged' => $paged,
									'posts_per_page' => 10		
								);
							$institutions = new WP_Query($institution_args);
							while($institutions->have_posts()){
								$institutions->the_post();
									?>
									<article class="institution">						
										<a href="<?php echo get_permalink(); ?>">
											<img src="<?php echo get_template_directory_uri() ?>/imgs/placeholder-search.png" alt="<?php echo get_the_title(); ?>">
										</a>
										<div class="info">
											<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
											<h4 class="meta-info"><?php echo get_field('institution_location'); ?></h4>
											<?php echo excerpt(get_field('institution_description')); ?>
											<footer>
												<span class="approval">52 members</span>
											</footer>
										</div>
									</article>
						
						
						
						<?php } wp_reset_query(); ?>
						
					</section>

					<section id="new_aquapons" class="sidebar">
						
						<h4>Newest Institutions</h4>
							<ul>
							<?php
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
							$new_institution_args = array(
									'post_type'=> 'institution',
									'orderby'=> 'date',
									'order'	=> 'DESC',
									'paged' => $paged,
									'posts_per_page' => 10		
								);
							$new_institutions = new WP_Query($new_institution_args);
							while($new_institutions->have_posts()){
								$new_institutions->the_post(); ?>

								<li><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></li>

							<?php } ?>
						</ul>			
					</section>
				
				
				

				
				</section><!-- .text-content -->
			 
			<?php
				// print post results
				//the_title();
			endwhile;
			?>

		<?php else : ?>
			
			Oops. No content found.
			
		<?php endif; ?>
		<?php if($institutions->max_num_pages>1): ?>
			<?php
				$paginate_args = array( 'current' => $paged,
										'type'=> 'list',
										'base'=>'/community/institutions/%_%',
										'format'=> 'page/%#%',
	                                    'total' => $institutions->max_num_pages
	                                   );
	        ?>
	        <header id="pagination">
	        	<?php  echo paginate_links( $paginate_args); ?>
	        </header>
        <?php endif; ?>
	</section><!-- #main -->

<?php get_footer(); ?>