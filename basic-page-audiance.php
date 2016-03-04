<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");

  $image = $page->image;
  if ($image) {
    $img_sized = $image->size(600);
    $img = "
          <img src='{$img_sized->url}' class='img-responsive thumbnail' alt='{$page->image->description}'>
        ";
  }
    
?> 

<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border">
  <div class='col-sm-8'>
  <h2 class='page-title'><?=$page->title; ?></h2>
		<span class='bodytext'><?=$page->body; ?> </span>
	</div>
  </div>
  <div class='col-sm-4'>
    <?=$img ?>
  </div>
  </div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

