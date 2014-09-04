<?php 

/**
 * Search template
 *
 */
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";

$out = '';

if($q = $sanitizer->selectorValue($input->get->q)) {

	// Send our sanitized query 'q' variable to the whitelist where it will be
	// picked up and echoed in the search box by the head.inc file.
	$input->whitelist('q', $q); 

	// Search the title, body and sidebar fields for our query text.
	// Limit the results to 50 pages. 
	// Exclude results that use the 'admin' template. 
	$matches = $pages->find("title|body|body_secondary|event_location|label|news_authors|summary|textarea_links%=$q, limit=50"); 

	$count = count($matches); 

	if($count) {
		$out .= "<h2>Found $count pages matching your query:</h2>" . 
			"<ul class='list-unstyled padding-top-sm margin-top-sm border-top'>";

		foreach($matches as $m) {
			$out .= "<li class='padding-bottom-md'><a class='padding-none text-bold' href='{$m->url}'>{$m->title}</a><div><a href='{$m->url}' class='text-muted text-sm'>{$m->url}</a></div>{$m->summary}</li>";
		}

		$out .= "</ul>";

	} else {
		$out .= "<h3 class='text-center'>Sorry, no results were found.</h3>";
	}
} else {
	$out .= "<h3 class='text-center'>Please enter a search term in the search box.</h3><br /><br /><br /><br /><br /><br />";
}

// Note that we stored our output in $out before printing it because we wanted to execute
// the search before including the header template. This is because the header template 
// displays the current search query in the search box (via the $input->whitelist) and 
// we wanted to make sure we had that setup before including the header template. 

include("./inc/head.php"); ?>

<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
	<div class="content-space content-border">
  
 <form class="form-search form-inline"   method="get" action="<? echo $pages->get(1000)->url; ?>">
    <div class="input-group input-group-lg">
      <span class="input-group-addon">Search</span>
      <input type="text" name="q" placeholder="" class="form-control">
      <span class="input-group-btn">
        <button class="btn btn-primary" type="submit">Go!</button>
      </span>
    
  </div>
    </form>
  
  <?=$out; ?>
	</div></div>
</div>
	

<? include("./inc/foot.php"); 

