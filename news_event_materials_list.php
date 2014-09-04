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
  <?
    if(count($page->siblings)) { 
    echo "<div class='row padding-bottom-sm padding-top-sm'>";
        echo "<div class='col-sm-12'><ul class='nav nav-tabs' role='tablist'>
          <li><a href='{$page->parent->url}' title='{$page->parent->title}'>Overview</a></li>";
        foreach($page->siblings as $match) {
          $tempcss = ($match->id == $page->id ? 'active' : '');
          $tempval .= "<li class='{$tempcss}'><a href='{$match->url}' title='{$match->title}'>{$match->title}</a></li>";
          }
          echo $tempval;
        echo "</ul></div>"; 
    echo "</div>";
    unset($tempval);
      }
    ?>
		
		<div class="row">
    <div class="col-sm-12 padding-bottom-sm">
    <?=$img ?>
		<span class='bodytext'><?=$page->body; ?> </span>
    
    
    <?
      if($page->repeat_materials) {
        echo "<hr /><dl>"; 
        foreach($page->repeat_materials as $match) {
          $date_start = date("M j Y", $match->date_start); // Formating the date correctly
          echo "<dt class='padding-top-md padding-bottom-xs'><span class='pull-right text-muted'>{$date_start}</span>{$match->label}</dt>";
            foreach($match->files as $submatch) {
            echo "<dd class='padding-bottom-xs'><span class='glyphicon glyphicon-file padding-left-sm text-muted'></span> <a href='{$submatch->url}' target='_blank' onClick=\"_gaq.push(['_trackEvent', 'file', '', '{$submatch->description}', 1, true]);\" title='{$submatch->description}'>{$submatch->description}</a></dd>";
            }
          }
        echo "<dl>";
      }
    ?>
    </div>
	</div></div></div>
	<? include("./inc/nav_well_root.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

