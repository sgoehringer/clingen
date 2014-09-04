<?php
$showchildren = "n";
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
		<? include("./inc/inc_documents_relate.php"); ?>
		<? include("./inc/inc_files.php"); ?>
	</div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

