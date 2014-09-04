<?php

// the onClick allows Google to track the number of times the link was clicked
	$key = 0;
	if(count($page->relate_documentation)) {
		$tempid = $page->relate_documentation;
		echo "<hr /><h4>Additional Materials &amp; Documents</h4>  <ul class='list-unstyled'>";
			$submatches = $pages->find("template=resource_file, sort=sort, id=$tempid");
				foreach($submatches as $submatch) {
					if($submatch->file->ext) {
					$tempval = " (".$submatch->file->ext.")";
					}
					echo "<li><a href='{$submatch->url}' title='{$submatch->title}' target='new' onClick=\"_gaq.push(['_trackEvent', 'resource', '', '{$submatch->title}', 1, true]);\"><span class='glyphicon glyphicon-file'></span> {$submatch->title} {$tempval}</a></li>";
				} 
		echo "</ul>";
	}
?> 