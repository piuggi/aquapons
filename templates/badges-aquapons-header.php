<?php $theme = new themeCheck(); ?>
<?php global $page; ?>

<div id="sub-nav" style="display:none;">
	<ul id="crumb-nav">
		<li>‹ <a href="">Resources</a></li>
		<li>‹ <a href="">Forum</a></li>
	</ul>
</div><!--#sub-nav-->
<div id="secondary-nav">
<section id="main-links" class="<?php echo $page;?>">
	<h2 id="page-title"><a href="">Badges</a></h2>
	<hr>
	<ul>
		<li><a href="http://aquapons.info/badges/aquapons-badges/">Aquapons</a></li>
		<li><a href="http://aquapons.info/badges/skills-badges">Skills</a></li>
		<li><a href="http://aquapons.info/badges/my-badges">Mine</a></li>
	</ul>
</section><!--#main-links-->

<section id="page-search">
	<p>Search</p>
	<form>
		<input type="text" name="search-item">
		<input type="hidden" value="" name="query">
		<input type="submit" value="Forum" name="SiteArea">
	</form>
	<hr>
</section>	<!--#page-search-->
