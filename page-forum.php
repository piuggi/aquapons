<?php 
	
	if(isset( $_POST['title'] )&& isset($_POST['question'])&& isset($_POST['category']) && is_user_logged_in() ){
				
		$post_args = array(
		
					'post_type'=> 'discussion',
					'post_status'=> 'publish',
					'post_title'=> $_POST['title'],
					'post_category'=>array($_POST['category']),
					'post_content'=> $_POST['question'],
					'post_author'=> get_current_user_id()
					
		
		);
		
		$id = wp_insert_post($post_args);
		add_post_meta($id, 'views', 0, true );
		add_post_meta($id, 'votes', 0, true );
		add_post_meta($id, 'answers', 0, true );
	}
	
?>

<?php $section = 'resources'; ?>
<?php get_header(); ?>


		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();  
			
			$page_class = sanitize_title(get_the_title());
			$page_class = strtolower($page_class);
			?>
			<section id="main" class="<?php echo $page_class;?>">
				<section id="overview">
					<section id="form" style="display:none;">
						<h2>Ask A Question</h2>
						<?php if(is_user_logged_in()): ?>
						<form id="new_discussion" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
							<input id="title" type="text" name="title" placeholder="Give this question a descriptive title...">
							<?php 
								$cats_args = array('type'=>'discussions', 'exclude'=>1);
								$cats = get_categories($cats_args); 
							?>

							<select id="category" name="category">
								<option value="">Relevant Content Area</option>
								<?php foreach($cats as $cat): ?>
								<option value="<?php echo $cat->cat_ID; ?>"><?php echo $cat->cat_name; ?></option>
								<?php endforeach; ?>
							</select>
							<textarea id="question" name="question" placeholder="What's the problem?"></textarea>
							<input type="submit" value="Post Question">
						</form>
						<?php else: ?>
						
						<p><a href='/sign-in?redirect=<?php echo $_SERVER['REQUEST_URI']; ?>'>You Must Log in to post a question</a></p>						
						<?php endif;?>
					</section>
					<header></header>
					<footer><p id="ask">Ask a Question</p></footer>
				</section><!--#Overview-->				

				<section class="text-content">

				 	<section id="discussions" class="main-col">
						<h2>Recent Discussions</h2>
						<?php 
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 

							$discussion_args = array('post_type' => 'discussion', 
										  'paged'=>$paged,
										  'orderby'=>'date',
										  'order'=>'DESC'); 
							
							$discussions = new WP_Query($discussion_args);
							
							while( $discussions->have_posts()): $discussions->the_post();
								$cats = get_the_category();
								//print_r($cats);
								
								if($cats) $class = $cats[0]->slug;
								else $class = 'plant';
							?>
							
							<article class="question">
								<section class="qleft">	
									<p><?php echo get_post_meta(get_the_ID(), 'votes', true) ?><em>votes</em></p>
									<hr>
									<p><?php echo get_post_meta(get_the_ID(), 'answers', true) ?><em>answers</em></p>	
								</section><!--.qleft-->
								<section class="qright">
										<div class="<?php echo $class; ?>"></div>
										<h3><a class="<?php echo $class; ?>" href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
										<p>Posted <?php echo time_ago(); ?> by <a class="<?php echo $class; ?>" href=""><?php echo get_the_author(); ?></a></p>
								</section><!--.qright-->
							</article><!--.question <?php echo get_the_title(); ?>  -->
							
							
							<?php endwhile; 
							
							
							wp_reset_query(); ?>
					</section><!--#discussions-->
			
				</section><!-- .text-content -->
			 
			<?php endwhile; ?>

		<?php else : ?>
			
			<h3> Oops. No content found.</h3>
			
		<?php endif; ?>
		<?php if($discussions->max_num_pages>1): ?>
			<?php
				$paginate_args = array( 'current' => $paged,
										'type'=> 'list',
										'base'=>'/resources/forum/%_%',
										'format'=> 'page/%#%',
	                                    'total' => $discussions->max_num_pages
	                                   );
	        ?>
	        <header id="pagination">
	        	<?php  echo paginate_links( $paginate_args); ?>
	        </header>
        <?php endif; ?>
	</section><!-- #main -->

<?php get_footer(); ?>