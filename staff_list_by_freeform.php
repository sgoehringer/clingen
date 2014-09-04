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
	</div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

