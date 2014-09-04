<?php $showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php"); ?>

<div class="row">

<div class="col-sm-10 col-sm-offset-1 text-center">
<span class='bodytext'><?=$page->body_secondary ?></span>
</div>
</div>

<?php
	$key = 0;
	if(count($page->repeat_callout)) { 
		echo "<div class='row padding-top-md'>";
			foreach($page->repeat_callout as $match) {
				if($match->image){  
					$img_sized	= $match->image->size(200,200);
					$img_src	= "<div class='row'><div class='col-xs-6 col-xs-offset-3 text-center'><a class='' href='{$match->relate_page->url}'><img src='{$img_sized->url}' class='img-responsive ' alt='{$img_sized->title}' /></a></div></div>";
				}
				echo "<div class='col-sm-4 col-xs-12 text-center'>
						{$img_src}
						  <a class='' href='{$match->relate_page->url}'><h4 class='headingtight text-center'>{$match->label}</h4> 	</a>   
						  <p class=' hidden-xs text-sm text-muted text-center'>{$match->summary} <a class='' href='{$match->relate_page->url}'>more &raquo;</a></p>

					  </div>
					";
			}
		echo "</div>";
	}
?> 

<div class="row">
<hr /> 
<div class="col-sm-5">
<h4><a href='https://twitter.com/ClinGenResource' class='text-muted' target='_blank'>@ClinGenResource</a> On Twitter</h4>
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
	$t->showRetweets = false; // show Twitter retweets in timeline? 
	// generated markup options:
	$t->listOpen = "<div class='row MarkupTwitterFeed'>";
	$t->listClose = "</div>";
	$t->listItemOpen = "<div class='col-sm-12 padding-bottom-sm' >";
	$t->listItemClose = "</div>";
	$t->listItemDateOpen = " - <span class='date'><em class='text-muted'><a href='https://twitter.com/ClinGenResource' class='text-muted' target='_blank'>";
	$t->listItemDateClose = "</a></em></span>";
	$t->listItemLinkOpen = " <a href='{href}' target='_blank'>";
	$t->listItemLinkClose = "</a>";
  echo $t->render();  
    ?> 

</span>
</div>
<div class="col-sm-5 col-sm-offset-2">
<h4>In The News</h4>
<ul class="list-unstyled padding-top-none">
<?
$matches = $pages->find("template=news_article, limit=3");
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

