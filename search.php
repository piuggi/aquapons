<?php 
if($_GET['post_type']=='badge') $section = 'badges';
if(strpos($_GET['post_type'], 'resource') !== false) $section = 'resources';
if($_GET['post_type']=='institution') $section = 'community';
?>

<?php get_header(); ?>
	<section class="main text-content">
		<section class="main-col">


		<h2>Search Results for "<?php echo $_GET['s']; ?>"</h2>
		
		
		
		<?php if($_GET['post_type']=='institution') { ?>
				
			<?php
			    $user_search = new WP_User_Query( 
					array(
						'search' => '*' . $_GET['s'] . '*' 
					));
					
				$users = $user_search->get_results();
				foreach($users as $user){
					$user_info = get_userdata($user->ID); ?>
					<article class="search_result user">
						
						<div class="info">
							<a href="http://aquapons.info/profile/?user=<?php echo getUserToken($user->ID); ?>"><?php echo $user_info->display_name; ?></a>
							<footer>
								Level: <span class="level">
								<?php
								$user_role = $user_info->roles; 
								echo ucwords(str_replace("_", " ", $user_role[0])); 
								?>
								</span>
							</footer>
						</div>
					</article>
				<?php } ?>
		
		
		
		<?php } //if($_GET['post_type']=='institutions') ?>
		
		<?php if ( have_posts() ) { ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) { the_post(); ?>
			
			
			
			
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
						<?php resourceThumb($post->ID); ?>
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
				
				
				
				<?php } else if(get_post_type() == 'institution') { ?>
					<article class="search_result instituion">						
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
				
				
				
				<?php } ?>
				
			<?php } ?>
			
			<?php if($wp_query->max_num_pages>1) { ?>
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
	        <?php }  ?>

		<?php } else { ?>
			
			No results found
			
		<?php } ?>
		
        <header id="pagination">
        	<?php echo paginate_links(); ?>
        </header> 
        

		</section><!-- #main-col -->
	</section><!-- #main -->

<?php get_footer(); ?>