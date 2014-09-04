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
		 <?=$img; $page->image; ?>
    <span class='bodytext'><?=$page->body; ?> </span>
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
     
     <div class='row padding-bottom-xs padding-top-xs'>
		<? $matches = $page->resource_repeater;
				foreach($matches as $match) {
          
          // Check to see if files exist
          if($match->files) {
          // Loop
            foreach($match->files as $temp) {
                // Check extension
                if($temp->ext) {
                  $tempext = " (".$temp->ext.")";
                }
                // Check if description provided... if not use file name
                if(!$temp->description) {
                  $description = $temp->name;
                } else {
                  $description = $temp->description;
                }
              // Add to resource var
              $resource .="<li><a href='{$temp->url}' title='{$description}' target='_blank' onClick=\"_gaq.push(['_trackEvent', 'resource', '', '{$temp->description}', 1, true]);\"><span class='glyphicon glyphicon-file'></span> {$description} {$tempext}</a></li>";
            }
            // Unset temp vars
            unset($temp);
            unset($tempext);
            unset($description);
          }
          
          // Check to see if images exist
          if($match->images) {
            // Loop
            foreach($match->images as $temp) {
                // Check extension
                if($temp->ext) {
                  $tempext = " (".$temp->ext.")";
                }
                // Check if description provided... if not use file name
                if(!$temp->description) {
                  $description = $temp->name;
                } else {
                  $description = $temp->description;
                }
              // Add to resource var
              $resource .="<li><a href='{$temp->url}' title='{$description}' target='_blank' onClick=\"_gaq.push(['_trackEvent', 'resource', '', '{$temp->description}', 1, true]);\"><span class='glyphicon glyphicon-picture'></span> {$description} {$tempext}</a></li>";
            }
            // Unset temp vars
            unset($temp);
            unset($tempext);
            unset($description);
          }
          
          // Check to see if page exist
          if($match->relate_pages) {
            // Loop
            foreach($match->relate_pages as $temp) {
              // Add to resource var
              $resource .="<li><a href='{$temp->url}' title='{$temp->title}'><span class='glyphicon glyphicon-link'></span> {$temp->title}</a></li>";
            }
            // Unset temp vars
            unset($temp);
            unset($tempext);
          }
          
          
          if($match->url_website) {
              $tempval = parse_url($match->url_website); 
              $tempval = $tempval['host'];
              $resource .="<li><a href='{$match->url_website}' title='{$match->url_website}' target='_blank' onClick=\"_gaq.push(['_trackEvent', 'resource', '', '{$match->url_website}', 1, true]);\"><span class='glyphicon glyphicon-new-window'></span> {$tempval}</a></li>";
          }
          
          if($resource) {
              $resource_list ="<ul class='list-unstyled padding-left-sm'>{$resource}</ul>";
          }
          
					echo "
							<div class='col-xs-11 margin-bottom-xl margin-left-xl padding-left-xl border-left-xl'>
								<h4>{$match->label}</h4>
								{$match->body}
                {$resource_list}
                {$match->textarea_links}
							</div>
						 ";
           unset($resource);
           unset($resource_list);
				}
        
		 ?></div>
     
		<? include("./inc/inc_files.php"); ?>
	</div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

