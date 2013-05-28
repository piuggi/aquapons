<header id="original" class="<?php print_aquapon_cat(); ?>">
	<section class="resource_title">
		<p class="author">Posted <?php echo time_ago(); ?> by <a class="<?php print_aquapon_cat(); ?>" href=""><?php echo get_the_author(); ?></a></p>
		<h2 class="title"> <?php the_title(); ?> </h2>
		<p class="description"><?php echo get_post_meta($post->ID, 'description', true); ?></p>
	</section>
	<section class="resource_label <?php print_aquapon_cat(); ?>">
	<ul>
		<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="comment">
			<img title="Comment on this post" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/imgs/discussion_comment.png"/>
		</li>
		<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="flag">
			<img title="Flag this post" src="<?php echo get_bloginfo('stylesheet_directory'); ?>/imgs/discussion_flag.png"/>
		</li>
	</ul>
	<p>Level: 
		<?php  $resource_level = get_post_meta($post->ID, 'resource_level', true);
			
			switch($resource_level){
				
				case 1: echo 'Junior Apprentice';break;
				case 2: echo 'Senior Apprentice';break;
				case 3: echo 'Journeymon';break;
				case 4: echo 'Master';break;
			}
		?>
	</p>
	<p> <?php $votes = get_post_meta($post->ID, 'votes', true); if($votes) echo $votes; else echo '0';  ?><em> growers found this helpful</em></p>
	</section>
</header><!--header#original-->

<section id="instructions" class="<?php print_aquapon_cat(); ?>">
	
	<article id="post-content">
		<?php the_content(); ?>
		<hr>
			<section class="reflect">	
				<ul class="rank">
					<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="up"></li>
					<li class="current"><?php echo $comment->comment_rank; ?></li>
					<li data-id="<?php echo $comment->ID; ?>" data-user="<?php echo $user->ID; ?>" class="down"></li>
				</ul>
				<p>Was this tutorial helpful?</p>
			</section>
		<hr>
	</article>

	<?php include('template-resources-sidebar.php');?>
	<?php include('template-resources-comments.php');?>

	
</section><!-- #instructions .<?php print_aquapon_cat(); ?> -->