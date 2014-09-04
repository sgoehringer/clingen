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
    
    
	<div class='row padding-bottom-xs padding-top-xs'>
		<? $matches = $page->children->find("sort=sort");
				foreach($matches as $match) {
					$image = $match->image;
					if ($image) {
						$img_sized = $image->size(300, 200);
					}
					echo "
							<div class='col-sm-12 col-xs-12 padding-bottom-md'>
                <div class='col-sm-3'>
								<a class='' href='{$match->url}' title='{$match->title}'>
                <img src='{$img_sized->url}' class='img-responsive' alt='{$match->title}'></a></div>
                <div class='col-sm-9'>
								<a class='black' href='{$match->url}' title='{$match->title}'><h4>{$match->title}</h4></a><div class=''>{$match->summary}</div>
							</div>
						 ";
				}
		 ?></div>
		<? include("./inc/inc_files.php"); ?>
	</div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

