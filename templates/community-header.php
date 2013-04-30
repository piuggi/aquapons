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
			<li><a href="http://aquapons.info/community/featured-aquapons/">Featured Aquapons</a></li>
			<li><a href="http://aquapons.info/community/user-directory/">User Directory</a></li>
			<li><a href="http://aquapons.info/community/peer-evaluations/">Peer Evaluations</a></li>
		</ul>
	</section><!--#main-links-->

	
	
	
	<section id="page-search">
		<form role="search" method="get" id="searchform" action="<?php bloginfo('home'); ?>">
			<input type="text" name="s" placeholder="Search" value="<?php echo $_GET['s']; ?>">
			<input type="hidden" value="<?php echo $_GET['theme'] ?>" name="theme">
	        <input type="hidden" name="post_type" value="users" />
			<input type="submit" id="searchsubmit" value="Search">
		</form>
		<hr>
	</section>	<!--#page-search-->
</div> <!-- #secondary-nav -->