<?php $theme = new themeCheck(); ?>


<div id="secondary-nav">
	<section id="main-links">
		<h2 id="page-title"><a href=""><?php echo get_the_title(); ?></a></h2>
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
		<form>
			<input type="text" name="search-item" placeholder="Search">
			<input type="hidden" value="" name="query">
			<input type="submit" value="Forum" name="SiteArea">
		</form>
		<hr>
	</section>	<!--#page-search-->
