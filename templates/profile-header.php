<div id="secondary-nav">
	<section id="main-links">

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
		<hr>
		<ul>
			<li><a href="">Account Settings</a></li>
		</ul>
		
	</section>	<!--#page-search-->
</div><!--#secondary-nav-->