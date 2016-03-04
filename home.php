<?php $showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php"); ?>

<div class="row">


<div class="col-sm-10 col-sm-offset-1 text-center">
<span class='bodytext'><?=$page->body_secondary ?></span>
</div>


<?php
	$key = 0;
	if(count($page->repeat_callout)) { 
		echo "<div class='row padding-top-xs'>";
			foreach($page->repeat_callout as $match) {
				if($match->image){  
					$img_sized	= $match->image->size(500,200);
					$img_src	= "<div class='row'><div class='padding-left-xs padding-right-xs text-center'><a class='' href='{$match->relate_page->url}'><img src='{$img_sized->url}' class='img-responsive  img-rounded' alt='{$img_sized->title}' /></a></div></div>";
				}
				echo "<div class='col-sm-4 col-xs-12 text-center'><div class='padding-left-sm padding-right-sm thumbnail'>
						{$img_src}
						  <a class='padding-none margin-none text-muted' href='{$match->relate_page->url}'><h4 class='headingtight padding-none margin-bottom-none text-center'>{$match->label}</h4><small class='text-muted'>{$match->summary}</small></a>   

					  </div></div>
					";
			}
		echo "</div>";
	}
?> 


<div class="col-sm-10 col-sm-offset-1 padding-top-none padding-bottom-none text-center">
<!--<h2 class='padding-none margin-none'>Recent ClinGen Announcements</h2>--><hr>
</div>

<?php
	$key = 0;
	if($page->repeat_callout_promote->count()) {
			
			$calloutnumberkey = "1";
			foreach($page->repeat_callout_promote as $callout) {
				$image = $callout->image;
				if ($image) {
					$img_sized = $image->size(400, 200);
				}
				$calloutnumber = $page->repeat_callout_promote->count();
				$calloutnumberkeyval = $calloutnumberkey++;
				$keyid = $key++;
				
				// The following checks to see if a link text was provided.  If not will use use the val defined
				// Use the 'ENT_QUOTES' quote style option, to ensure no XSS is possible and your application is secure
				if($callout->linktext) {
					$linktext = htmlEntities($callout->linktext, ENT_QUOTES);
				} else {
					$linktext = "Learn more";
				}
				
				// The following checks to see if a image description was provided.  If not will use use the caption
				// Use the 'ENT_QUOTES' quote style option, to ensure no XSS is possible and your application is secure
				if($img_sized->description) {
					$alttext = htmlEntities($img_sized->description, ENT_QUOTES);
				} else {
					$alttext = htmlEntities($callout->label, ENT_QUOTES);
				}
				
				echo "<div id='homepage_body_row_{$keyid}' class='padding-bottom-lg'>
        
						<div class='row padding-bottom-lg'>
							<div class='col-sm-3 hidden-xs " . (++$keyid%2 ? "pull-left odd" : "pull-right even") . "'>
								<a class='black' title='{$alttext}' href='{$callout->related_page_single->url}'>
									<img src='{$img_sized->url}' class='img-responsive img-rounded' alt='{$alttext}'>
								</a>
							</div>
							<div class='col-sm-9'>
								<a class='text-black' title='{$linktext}' href='{$callout->related_page_single->url}'><h4 class='padding-none margin-none'>{$callout->label}</h4></a>
								<p>{$callout->summary} <div class='col-padding-top-1x'><a class='btn btn-default' href='{$callout->related_page_single->url}' title='{$linktext}'>{$linktext} &raquo;</a></div></p>  
							</div>
					    </div>
					    </div>
					  </div>
					";
			}
	}
?> 









  </div>

</div>
</div>
<div class='background-light-grey padding-top-md'>
<div class='container background-trans'>
<div class="row ">

<div class='col-sm-12 text-center padding-bottom-sm'>
<h2 class='padding-none margin-none'>ClinGen Tools &amp;  Resources</h2><p>Key ClinGen resources supporting our goal of building a genomic knowledge base to improve patient care.</p>
</div>
    <?
  $submatches = $pages->find("template=resource_list_item, sort=alphabetical, clingen_tool=1");
  //$submatches = $pages->find("template=resource_list_item, sort=title");
  unset($i);
  foreach($submatches as $submatch) {
      $i++; // Increments the key
      $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
      
      if($submatch->image) {
					$img_sized = $submatch->image->size(200,200)->url;
         $tempimg = "<img src='{$img_sized}' class='img img-responsive img-circle' alt='{$submatch->title}'>";
				} else {
         $tempimg = "";
				} 
      
      echo "<div class='col-sm-6 padding-left-none margin-bottom-lg $temprow'>
      
      <div class='col-sm-2 col-xs-1 padding-right-none'><a href='{$submatch->url_website}' class='text-black' title='{$submatch->title}'>$tempimg</a></div>
      <div class='col-sm-10 col-xs-11'>
      <h4 class='margin-none'><a href='{$submatch->url_website}' class='text-black' title='{$submatch->title}'>{$submatch->title}</a></h4><div class='row padding-bottom-sm'>";
      if($submatch->summary) { echo "<div class='col-sm-12 text-muted text-sm'>{$submatch->summary} <a href='{$submatch->url_website}' title='{$submatch->title}'>Learn more</a>"; }
      if(count($submatch->children)) { 
        echo "<ul class='list-inline padding-left-xs'>
          ";
        foreach($submatch->children as $subsubmatch) {
          $tempval .= "<a class='text-muted  text-xs' href='{$subsubmatch->url}' title='{$subsubmatch->title}'>{$subsubmatch->title}</a> <span class='text-muted  text-xs'>|</span> ";
          }
          $tempval = rtrim($tempval, "| ");  // Strips the comma and space from the end
          echo $tempval;
        echo "</ul>"; 
        
        unset($temprow);
      }
    unset($tempval);
    unset($temprow);
    echo "</div></div></div></div>";
   }
  ?>
  <div class='col-sm-12 text-center padding-bottom-md'>
  <a href='/clingen-tools-and-work-products/' class='btn-default btn' title='More Tools &amp; Resources'>Additional ClinGen Tools &amp; Resources</a>
  </div>
  
</div>
</div></div>


<div class='background-white'>
<div class='container background-trans'>

<div class="row"> 
<div class="col-sm-12 padding-top-md text-center">
<h2 class='border-bottom margin-bottom-md'>Stay Up To Date</h2>
</div>
<div class="col-sm-6">
<h4><strong><a href='https://twitter.com/ClinGenResource' class='text-muted' target='_blank'>@ClinGenResource</a> On Twitter</strong></h4>
<span class='bodytext'>

<?php
  $t = $modules->get('MarkupTwitterFeed');
	$t->limit = 4; // max items to show
	$t->cacheSeconds = 600; // seconds to cache the feed (3600 = 1 hour)*
	$t->dateFormat = 'F j g:i a'; // PHP date() or strftime() format for date field: December 4, 2013 1:17 pm
	$t->dateFormat = 'relative'; // Displays relative time, i.e. "10 minutes ago", etc.
	$t->linkUrls = true; // should URLs be linked?
	$t->showHashTags = true; // show hash tags in the tweets?
	$t->showAtTags = true; // show @user tags in the tweets?
	$t->showDate = 'after'; // show date/time: 'before', 'after', or blank to disable.
	$t->showReplies = false; // show Twitter @replies in timeline?
	$t->showRetweets = true; // show Twitter retweets in timeline? 
	// generated markup options:
	$t->listOpen = "<div class='row MarkupTwitterFeed'>";
	$t->listClose = "</div>";
	$t->listItemOpen = "<div class='col-sm-11 padding-bottom-sm' >";
	$t->listItemClose = "</div>";
	$t->listItemDateOpen = " - <span class='date'><em class='text-muted'><a href='https://twitter.com/ClinGenResource' class='text-muted' target='_blank'>";
	$t->listItemDateClose = "</a></em></span>";
	$t->listItemLinkOpen = " <a href='{href}' target='_blank'>";
	$t->listItemLinkClose = "</a>";
  echo $t->render();  
    ?> 

</span>
</div>
<div class="col-sm-6">
<h4><strong>In The News</strong></h4>
<ul class="list-unstyled padding-top-none">
<?
$matches = $pages->find("template=news_article, limit=5,  sort=-date_start");
		foreach($matches as $match) {
		$string1 = $match->title;
		$string1 = (strlen($string1) > 100) ? substr($string1,0,100).'...' : $string1;
		$string2 = $match->body;
		$string2 = (strlen($string2) > 100) ? substr($string2,0,100).'...' : $string2;
		echo "<li class='padding-bottom-xs text-muted'><a href='{$match->url}' title='{$match->title}' >{$string1}</a><div class='text-sm'>{$string2}</div></li>";
					}
?>
</ul>
</div>
</div>

<?

include("./inc/foot.php"); 

