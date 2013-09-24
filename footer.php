
	<footer class="main">
		<header id="pagination" style='display:none;'>
			<p class="left"> <a =class="" href=""> ? Previous</a></p>
			<ul class="pages">
				<li><a>1</a></li>
				<li><a>2</a></li>
				<li><a>3</a></li>
				<li><a>4</a></li>
				<li><a>6</a></li>
			</ul>
			<p class="right"><a =class="" href="">  Next ?</a></p>

		</header>
		<footer>
			<ul>
				<li id="daily-tip">
					<h4>Daily Tip</h4>
					<hr class="fish">
					<?php 
					$args = array('post_type' => 'tip', 'posts_per_page'=> 10, 'orderby'=>'date','order'=>'DESC'); 
					$loop = new WP_Query($args);
					
					while( $loop->have_posts()) {
						$loop->the_post();
						?>
						<div class="tip">
							<?php echo get_field('tip_content'); ?>
						</div>
					<?php } ?>
					<div class="next_tip">Next ›</div>
				</li>
				<li id="feat-aquapon">
					<h4>Featured Aquapon</h4>
					<hr>
					
					<?php 
						//will have to add query to stop from finding COPPA Users
						
					$args = array('post_type' => 'featured_aquapon', 'posts_per_page'=> 1, 'orderby'=>'rand'); 
					$feat_grower = new WP_Query($args);
						 while($feat_grower->have_posts()) {
							$feat_grower->the_post();
					?>	 
					
					<div class="avatar">
						<?php 
						$imgId = get_field('image');
						$imgArray = wp_get_attachment_image_src( $imgId, 'thumbnail');
						?>
						<img class="aquapon_ledgend" src="<?php echo $imgArray[0];  ?>" alt="Featured Grower, <?php echo get_the_title(); ?>">
					</div>
					<h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
					<p><a href="<?php the_permalink(); ?>">Meet this grower ›</a></p>
						  
					<?php } ?>
					
<!--
					<div class="avatar"><img src="<?php bloginfo( 'template_url' ); ?>/imgs/feat_grower4.png" alt="Featured Grower"></div>
					<h3><a>John Smith</a></h3>
					<p><a>Meet this grower ›</a></p>
-->
				</li>
				<li id="contact-us">
					<h4>Contact Us</h4>
					<hr>
					<?php echo get_field('contact_info', 1026); ?>		
					</p>
				</li>
				<li id="site-desc">
					<h4>SweetWater Foundation</h4>
					<hr>
					
					<?php echo get_field('sweet_water_ribbon_content', 1026); ?>
				</li>
			</ul>
			<p id="copyright"> &copy; Aquapons 2013</p>

		</footer><!--footer-->

	</footer><!--footer#main-->
</div><!-- #container -->

<?php wp_footer(); ?>
</body>
</html>