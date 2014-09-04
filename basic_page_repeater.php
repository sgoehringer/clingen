<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>  

<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border"><h2 class='page-title'><?=$page->title; ?></h2>
		<span class='bodytext'><?=$page->body; ?> </span>
	
  
  
  <?php
	$key = 0;
	if(count($page->repeat_callout)) { 
		echo "<div class='row padding-top-md'>";
			foreach($page->repeat_callout as $match) {
       
       $templink = ($match->relate_page->url ? $match->relate_page->url : $match->url_website);
       if($templink) {
         $temphrefopen = "<a class='' href='{$templink}'>";
         $temphrefclose = "</a>";
         $temphrefmore = "<a class='btn btn-xs btn-default' title='{$match->label}' href='{$templink}'>more &raquo;</a>";
       }
				if($match->image){ 
					$img_sized	= $match->image->size(300,200);
					$img_src	= "<div class='col-xs-4'>{$temphrefopen}<img src='{$img_sized->url}' class='img-responsive thumbnail' alt='{$img_sized->title}' />{$temphrefclose}</div>";
				}
				echo "<div class='col-sm-12 col-xs-12 padding-bottom-md'>
						{$img_src}
            <div class='col-sm-8'>
						  {$temphrefopen}<h4 class='headingtight'>{$match->label}</h4> 	{$temphrefclose}
						  <p class=' hidden-xs text-sm text-muted'>{$match->summary}</p> {$temphrefmore}
          </div>
					  </div>
					";
      unset($templink);
      unset($temphrefopen);
      unset($temphrefclose);
      unset($temphrefmore);
			}
		echo "</div>";
	}
?> 
		<? include("./inc/inc_files.php"); ?>
	</div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

