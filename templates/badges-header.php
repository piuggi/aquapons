<?php $theme = new themeCheck(); ?>

<div id="sub-nav" style="display:none;">
	<ul id="crumb-nav">
		<li>‹ <a href="">Resources</a></li>
		<li>‹ <a href="">Forum</a></li>
	</ul>
</div><!--#sub-nav-->
<div id="secondary-nav">
<section id="main-links">
	<h2 id="page-title"><a href="">Badges</a></h2>
	<hr>
	<ul>
		<li><a href="http://aquapons.info/badges/aquapons-badges/<?php $theme->url();?>">Aquapons</a></li>
		<li><a href="http://aquapons.info/badges/skills-badges<?php $theme->url();?>">Skills</a></li>
		<li><a href="http://aquapons.info/badges/my-badges<?php $theme->url();?>">Mine</a></li>
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
	<p>Search</p>
	<form>
		<input type="text" name="search-item">
		<input type="hidden" value="" name="query">
		<input type="submit" value="Forum" name="SiteArea">
	</form>
	<hr>
</section>	<!--#page-search-->
