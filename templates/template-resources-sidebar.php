<aside class="sidebar">							
	<h4>Related resources </h4>
	<ul>
		<?php
		$resource_args = array(
			'post_type' => 'resource',
			'orderby' => 'post_date',
			'category_name'=> get_aquapon_cat(),
			'order' => 'ASC',
		);
		$resource_query = new WP_Query( $resource_args );
		while($resource_query->have_posts()) {
			$resource_query->the_post();
		?>

			<li class="recent_resource">
				<a href="<?php echo the_permalink(); ?>">
					<h5><?php echo get_the_title(); ?></h5>
				</a>
			</li>
			
		<?php } wp_reset_query(); ?>	
	</ul>	
		
</aside>