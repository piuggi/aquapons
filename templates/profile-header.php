<div id="sub-nav">
	<ul id="crumb-nav">
		<li>‹ <a href="">Resources</a></li>
		<li>‹ <a href="">Forum</a></li>
	</ul>
</div><!--#sub-nav-->
<div id="secondary-nav">
	<section id="main-links">
	
		<?php global $current_user; get_currentuserinfo(); ?>

		<h3><?php 
		$user_role = $current_user->roles; 
		echo ucwords(str_replace("_", " ", $user_role[0])); ?>
		</h3>
		<h2 id="page-title"><a href=""><?php echo $current_user->display_name; ?></a></h2>
		<hr>
		<ul>
			<li><a href="">Alerts</a></li>
			<li><a href="">Messages</a></li>
			<li><a href="">Active Discussions</a></li>
		</ul>
	</section><!--#main-links-->
	<section id="page-search">
		<p>Account Settings</p>
		<form>
			<input type="text" name="search-item">
			<input type="hidden" value="" name="query">
			<input type="submit" value="Forum" name="SiteArea">
		</form>
		<hr>
	</section>	<!--#page-search-->
</div><!--#secondary-nav-->