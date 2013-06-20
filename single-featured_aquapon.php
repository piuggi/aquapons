<?php get_header(); ?>

	<section class="main">
	<?php if ( have_posts() ) : the_post(); ?>
	
	
		<header id="original">
			<section class="resource_title">
				<?php echo wp_get_attachment_image( get_post_meta($post->ID, 'image', true) ); ?>
				<h2 class="title"> <?php the_title(); ?> </h2>
				<p class="description"><?php echo get_post_meta($post->ID, 'instution', true); ?></p>
				<p class="description"><?php echo get_post_meta($post->ID, 'location', true); ?></p>
				<a href="<?php echo get_post_meta($post->ID, 'url', true); ?>" href="_blank"><p class="description">More Info</p></a>
			</section>
			</section>
		</header><!--header#original-->
		
		
		<section id="instructions" class="<?php print_aquapon_cat(); ?>">
		<article id="post-content">
			<?php echo get_post_meta($post->ID, 'bio', true); ?>
		</article>
		</section>

		
		</section><!-- #instructions .<?php print_aquapon_cat(); ?> -->
	
	
	
	
	
	
	
	<?php else : ?>

		No content found
		
	<?php endif; ?>

	</div><!-- #main .wrapper -->

<?php get_footer(); ?>
