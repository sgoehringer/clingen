<?php

// the onClick='trackOutboundLink(this, 'Outbound Links', '{$page->url_website}'); return false;' allows Google to track the number of times the link was clicked
	$key = 0;
	if($page->url_website) {
		echo "<div class='row-fluid'><hr /> 
				<a class=''  onClick='trackOutboundLink(this, 'Outbound Links', '{$page->url_website}'); return false;' href='{$page->url_website}' target='blank' title='{$page->title}' ><i class='glyphicon glyphicon-share '></i> Read More Online </a>
		   </div>";
	}
?> 