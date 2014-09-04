<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>  
 
<div class="row">
	<div class="col-sm-12">
	<div class="content-space content-border">
  <h2 class='page-title'><?=$page->title; ?></h2>
		<span class='bodytext'><?=$page->body; ?> </span>
  
  
  <?php
	$key = 0;
	if(count($page->repeat_callout)) { 
		echo "<div class='row padding-top-md'>";
			foreach($page->repeat_callout as $match) {
      $i++; // Increments the key
      $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
				if($match->relate_page->url) {
         $tempval = $match->relate_page->url;
         } else {
         $tempval = $match->url_website;
       }
       if($match->image){ 
					$img_sized	= $match->image->size(300,300);
					$img_src	= "<div class='col-xs-4'><a class='' href='{$tempval}'><img src='{$img_sized->url}' class='img-responsive thumbnail' alt='{$img_sized->title}' /></a></div>";
				}
				echo "<div class='col-sm-6 col-xs-12 {$temprow} padding-bottom-md'>
						{$img_src}
            <div class='col-sm-8'>
						  <a class='' href='{$tempval}'><h4 class='headingtight'>{$match->label}</h4> 	</a>
						  <p class=' hidden-xs text-sm text-muted'>{$match->summary}</p><a class='btn btn-sm btn-default' href='{$tempval}'>Access &raquo;</a>
          </div>
					  </div>
					";
			}
		echo "</div>";
	}
?> 
	</div>
</div>
	

<? include("./inc/foot.php"); 

