<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");

echo "<div class='row'>
	<div class='col-sm-9'>
	<div class='content-space content-border'><h2 class='page-title'>{$page->title}</h2>";

function sitemapListPage($page) {

	echo "<li><a href='{$page->url}'>{$page->title}</a> ";	

	if($page->numChildren) {
		echo "<ul>";
		foreach($page->children as $child) sitemapListPage($child); 
		echo "</ul>";
	}

	echo "</li>";
}

echo "<ul class='sitemap'>";
sitemapListPage($pages->get("/")); 
echo "</ul></div></div>";
	include("./inc/nav_well.php");
echo "</div>";

include("./inc/foot.php"); 



