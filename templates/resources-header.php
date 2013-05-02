<div id="secondary-nav">
	<section id="main-links">
		<h2 id="page-title">
			<?php 
			if($_GET['s']) echo 'Resources';
			else echo get_the_title(); 
			?>
		</h2>
		<hr>
		<ul>
			<li><a href="/resources/tutorials/">Tutorials</a></li>
			<li><a href="/resources/forum/">Forum</a></li>
			<li><a href="/resources/library/">Library</a></li>
			<li><a href="/resources/jobs/">Jobs</a></li>
		</ul>
	</section><!--#main-links-->
	<section id="content-filter">
		<hr>
		<p><a href="">Filter</a></p>
	</section><!--#content-filter-->
	<section id="content-sort">
		<hr>
		<p><a href="">Content Area</a></p>
	</section><!--#content-sort-->
	<section id="page-search">
		<form role="search" method="get" id="searchform" action="<?php bloginfo('home'); ?>">
			<input type="text" name="s" placeholder="Search Resources" value="<?php echo $_GET['s']; ?>">
			<?php if($_GET['theme']) { ?><input type="hidden" value="<?php echo $_GET['theme'] ?>" name="theme"><?php } ?>
	        <input type="hidden" name="post_type" value="resource" />
			<input type="submit" id="searchsubmit" value="Search">
		</form>
		<hr>
	</section>	<!--#page-search-->
</div><!--#secondary-nav-->