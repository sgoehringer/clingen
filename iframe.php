<?php 

/**
 * Product Home template
 *
 */
$showchildren = "y";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
 
 	$image = $page->image;
		if ($image) {
			$img_sized = $image->size(600);
			$img = "<div class='pull-right col-sm-6'>
						<img src='{$img_sized->url}' class='img-responsive thumbnail' alt='{$page->image->description}'>
					</div>";
		}
 
?>
<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border"><h2 class='page-title'><?=$page->title; ?></h2>
		<?=$img; ?> 
		<span class='bodytext'><?=$page->body; ?> </span>
		<hr />
		<iframe src="<? echo $page->url_website; ?>" width="100%" style="border:none;" scrolling="no" height="800"></iframe>
	</div>
		<? include("./inc/nav_well.php"); ?>
</div>

<? include("./inc/foot.php"); 


