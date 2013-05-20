<div id="secondary-nav">
	<section id="main-links">
		<h2 id="page-title">
			<?php 
			if($_GET['s']) echo 'Community';
			else echo get_the_title(); 
			?>
		</h2>
		<hr>
		<ul>
			<li><a href="http://aquapons.info/community/institutions/">Groups/Institutions</a></li>
		</ul>
	</section><!--#main-links-->

	
	
	
	<section id="page-search">
		<form role="search" method="get" id="searchform" action="<?php bloginfo('home'); ?>">
			<input type="text" name="s" placeholder="Search Aquapons" value="<?php echo $_GET['s']; ?>">
			<?php if($_GET['theme']) { ?><input type="hidden" value="<?php echo $_GET['theme'] ?>" name="theme"><?php } ?>
	        <input type="hidden" name="post_type" value="institution" />
			<input type="submit" id="searchsubmit" value="Search">
		</form>
		<hr>
	</section>	<!--#page-search-->
</div> <!-- #secondary-nav -->