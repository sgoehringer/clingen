<?
	echo "<strong><a href='{$pages->get($quickvar)->url}'>{$pages->get($quickvar)->title}</a></strong><ul class='list-unstyled'>";
	foreach($pages->get($quickvar)->children as $child) {
		echo "<li><a href='{$child->url}'>{$child->title}</a></li>"; 
	}
	echo "</ul>";
?>