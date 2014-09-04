<?php

// the onClick='trackOutboundLink(this, 'Outbound Links', '{$callout->url}'); return false;' allows Google to track the number of times the link was clicked
	$key = 0;
	if(count($page->files)) {
		
		
			
		echo "<hr /><div class='row-fluid'>";
			echo "
				<h4>Materials For Download</h4>    <div class='padding-left-md'><ul class='list-unstyled'>";
			foreach($page->files as $callout) { 
			
			
        if($submatch->file->ext) {
					$tempval = " (".$submatch->file->ext.")";
					}
			
				echo "<li><a href='{$submatch->url}' title='{$submatch->title}' target='new' onClick=\"_gaq.push(['_trackEvent', 'resource', '', '{$submatch->title}', 1, true]);\"><span class='glyphicon glyphicon-file'></span> {$submatch->title} {$tempval}</a></li>
					";
			}
		echo "</ul></div></div>";
	}
?> 