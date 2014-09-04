<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");

	
	   if (count($page->images)) {
		   		foreach($page->images as $image) {
				   $img_sized = $image->size(600);
					$imagesval .= "<div class='thumbnail clearfix text-sm text-muted'><img src='{$img_sized->url}' class='img-responsive' alt='{$image->description}'>{$image->description}</div>";
					
			   }
		   $img = "<div class='col-sm-4 pull-right padding-bottom-none padding-top-lg img-content-area'>{$imagesval}</div>";
		}
		
	
?>

<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border"><?=$img; ?>
		<h3 class='page-title'><?=$page->title; ?></h3>
		
		<span class='bodytext'><?=$page->body; ?> </span>
        

		<? include("./inc/inc_webaddress.php"); ?>
		<? include("./inc/inc_files.php"); ?>
		
		
		
		
	</div></div>
	<? include("./inc/nav_well_root.php"); ?>
</div>
	

<? include("./inc/foot.php"); 


