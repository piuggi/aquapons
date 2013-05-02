<?php $section = 'community'; ?>


<?php get_header(); ?>


	<section class="main">
	<?php if ( have_posts() ) : the_post(); ?>
	

			<section class="background text-content <?php if($institution_admin) echo "editable"; ?>">
				<h2>Background</h2>
				
				<div class="background_display">
					<h4>Location</h4>
					<p class="location"><?php echo get_field('institution_location'); ?></p>
					
					<h4>Established</h4>
					<p class="established"><?php echo date("F d, Y", strtotime(get_field('established_date'))); ?></p>
				</div>
				
				<div class="background_admin">
				
				</div>
			
			</section>
		
			<section class="my_badges text-content">
				<?php echo excerpt(get_field('institution_description')); ?>
			
			</section>
		</section>
	
	<?php else : ?>

		No content found
		
	<?php endif; ?>

	</div><!-- #main .wrapper -->
	
<?php get_footer(); ?>

