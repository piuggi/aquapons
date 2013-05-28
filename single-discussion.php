<?php $section = 'resources'; ?>
<?php $view = 'single'; ?>
<?php get_header(); ?>


<section id="main" class="<?php echo $page_class;?>">
	<?php if ( have_posts() ) : the_post(); 
	//check_postComments();		
/*	
	<ul class="breadcrumb">
		<li>‹ <a href="/resources"> Resources </a></li>
		<li>‹ <a href="/resources/forum"> Forum </a></li>
		<li>‹ <a class="strong" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	</ul>
	<?php //keep a count of the views for each discussion item
		  $views =  get_post_meta($post_id, 'views', true); 
		  $views++; update_post_meta($post_id, 'views', $views);
		  
		  //get_aquapon_cat();
		*/
	?>
	<header id="original" class="<?php print_aquapon_cat(); ?>">
		<figure class="user_photo">
			<?php if(userphoto_exists( get_the_author_meta('ID') )) userphoto_thumbnail( get_the_author_meta('ID') ); 
				  else echo get_avatar( get_the_author_meta('user_email') , 100);//defaults to blank gravatar can substitute if we want 		
			?>
		</figure>
		<section class="original_post">
			<p class="author">Posted <?php echo time_ago(); ?> by <a class="<?php print_aquapon_cat(); ?>" href=""><?php echo get_the_author(); ?></a></p>
			<h2 class="title"> <?php the_title(); ?> </h2>
			<p class="desc"> <?php echo get_the_content();?> </p>
		</section>
	</header><!--header#original-->
	
	
	<section id="responses" class="<?php print_aquapon_cat(); ?>">
	<?php include('templates/template-resources-comments.php');?>
	<?php include('templates/template-resources-sidebar.php');?>

	</section><!--section#responses-->
	
	<section id="similar">
		<h2>Similar Discussions</h2>
		<?php 
	
		$discussion_args = array('post_type' => 'discussion', 
					  'posts_per_page'=> 5, 
					  'orderby'=>'date',
					  'category_name'=> $class,
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
					<div class="<?php print_aquapon_cat(); ?>"></div>
					<h3><a class="<?php print_aquapon_cat(); ?>" href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
					<p>Posted <?php echo time_ago(); ?> by <a class="<?php print_aquapon_cat(); ?>" href=""><?php echo get_the_author(); ?></a></p>
			</section><!--.qright-->
		</article><!--.question <?php echo get_the_title(); ?>  -->
		
		<?php endwhile; wp_reset_query(); ?>
	
	</section><!--#similar-->
	
	<?php endif;?>
</section><!--#main-->
<?php get_footer(); ?>
<?php /* Secret Form for page actions */ ?>
<form id="page_actions" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8" style="display: none;"></form>