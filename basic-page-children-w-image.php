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
    
    $search = '#<a(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*<\/a>#x';
    $replace = '<center><iframe width="560" height="315" src="http://www.youtube.com/embed/$2" frameborder="0" allowfullscreen></iframe></center>';
    $bodytext = preg_replace($search, $replace, $page->body);

?>

<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border"><h2 class='page-title'><?=$page->title; ?></h2>
		 <?=$img; ?>
    <span class='bodytext'><?=$bodytext; ?> </span>
	<div class='row padding-bottom-xs padding-top-xs'>
		<? $matches = $page->children->find("sort=sort");
				foreach($matches as $match) {
					$image = $match->image;
					if ($image) {
						$img_sized = $image->size(300);
					}
					echo "
							<div class='col-sm-3 col-xs-6 text-center padding-bottom-md'>
								<a class='margin-xs' href='{$match->url}' title='{$match->title}'>
                <div class='padding-left-lg padding-right-lg'><img src='{$img_sized->url}' class='img-responsive' alt='{$match->title}'></a></div>
								<a class='black' href='{$match->url}' title='{$match->title}'><span class='text-padding-tight'>{$match->title}</span></a>
							</div>
						 ";
				}
		 ?></div>
		<? include("./inc/inc_files.php"); ?>
	</div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

