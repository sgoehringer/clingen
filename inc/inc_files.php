<?php
// Reviewed - Scott Goehringer - Oct 21 2014

// Count the files called on this page. if <0 then show
if(count($page->files)) {
  
  // Add HR rule and place in div
  echo "<hr />
        <div class='row-fluid'>";
  
  // Add the title and div/UL structure
  echo "<h4>Materials For Download</h4>
        <div class='padding-left-md'>
        <ul class='list-unstyled'>";
  
  // Loop through and find all of the files
  foreach($page->files as $match) { 
  
    // Check extension and add to val
    if($match->file->ext) {
    $tempval = " (".$match->file->ext.")";
    }
    
    // Print the following.  NOTE - The onClick is google tracking code
    echo "<li><a href='{$match->url}' title='{$match->title}' target='new' onClick=\"_gaq.push(['_trackEvent', 'resource', '', '{$match->title}', 1, true]);\"><span class='glyphicon glyphicon-file'></span> {$match->description} {$tempval}</a></li>
    ";
  
    // Unset the temp val
    unset($tempval);
    
  // End Loop
  }
  
  // complete the ul/div structuring
  echo "</ul></div></div>";
}
?> 
