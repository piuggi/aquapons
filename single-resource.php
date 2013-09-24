<?php $section = 'resources'; ?>
<?php $view = 'single';?>

<?php if($_GET['json']) { 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	
	include('php/badges-json.php'); 
} else { ?>

<?php get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<?php $category = get_the_category(); ?>
	<section id="main" class="resource <?php echo $category[0]->slug ?>">

		<?php	$resource_type = get_post_meta($post->ID, 'resource_type', true);
				include(get_template_directory() . "/templates/template-resource-".$resource_type.".php");
		?>
			
<?php else : ?>

		No content found
		
	</section>
<?php endif; ?>

	</div><!-- #container -->
	
<?php get_footer(); ?>

<?php } ?>