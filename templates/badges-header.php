<div id="secondary-nav">
	<section id="main-links">
		<h2 id="page-title"><a href="">
			<?php 
			if($_GET['s']) echo 'Badges';
			else echo get_the_title(); 
			?>
		</a></h2>
		<hr>
		<ul>
			<li><a href="http://aquapons.info/badges/aquapons-badges/">Aquapons</a></li>
			<li><a href="http://aquapons.info/badges/skills-badges/">Skills</a></li>
			<li><a href="http://aquapons.info/badges/my-badges/">Mine</a></li>
		</ul>
	</section><!--#main-links-->
	<?php 
	/*
	<section id="content-filter">
		<hr>
		<p><a href="">Filter</a></p>
	</section><!--#content-filter-->
	<section id="content-sort">
		<hr>
		<p><a href="">Content Area</a></p>
	</section><!--#content-sort-->
	*/ ?>
	
	
	
	
	<section id="page-search">
		<form role="search" method="get" id="searchform" action="<?php bloginfo('home'); ?>">
			<input type="text" name="s" placeholder="Search" value="<?php echo $_GET['s']; ?>">
			<input type="hidden" value="<?php echo $_GET['theme'] ?>" name="theme">
	        <input type="hidden" name="post_type" value="badge" />
			<input type="submit" id="searchsubmit" value="Search">
		</form>
		<hr>
	</section>	<!--#page-search-->
</div> <!-- #secondary-nav -->