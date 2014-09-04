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
		
		$date_start = date("M j Y", $page->date_start); // Formating the date correctly
		$date_end = date("M j Y", $page->date_end); // Formating the date correctly
		
		if ($date_end == $date_start) { unset($date_end); }
		
		$event_time_start = date("g:i A", $page->date_start); // Formating the date correctly
		$event_time_end = date("g:i A", $page->date_end); // Formating the date correctly
?>

<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border"><h2 class='page-title'><?=$page->title; ?></h2>
		<h4 class="margin-xs">
			<?	
				$tempkey = "0";  // This tempkey to zero
				$tempcount = $page->relate_event_type->count();   // This checks how many events types are in the array
				
				foreach($page->relate_event_type as $child) {
					$tempkey++;  // This increments the tempkey above
					echo $child->title;
					if($tempcount > $tempkey) { echo " | "; }   // This checks to see if the event key is less then acount
				}
			?>
			~ <?=$date_start; ?> (<?=$event_time_start; ?>) <span class="text-muted">to</span> <?=$date_end; ?> (<?=$event_time_end; ?>)</h4>
		
		<hr />
		<div class="row">
			<div class="col-sm-6">
				<?=$page->event_location; ?>
				<div class="text-muted">
				<?=$page->mapmarker->address; ?>
				</div>
				<hr />
				<label>Date</label> <?=$date_start; ?> (<?=$event_time_start; ?>) <span class="text-muted">to</span> <?=$date_end; ?> (<?=$event_time_end; ?>)<br />
				<? if($page->webaddress) { ?>
				<label>Website</label> <?=$page->url_website; ?>
				<? } ?>
			</div>
			<div class="col-sm-6">
				<?
				
				$mapmarker = $modules->get('MarkupGoogleMap'); 
				echo $mapmarker->render($page, 'mapmarker'); 
				
				?>
			</div>
		</div>
        <hr />
		<?=$img; ?>
		<span class='bodytext'><?=$page->body; ?> </span>
		<? include("./inc/inc_webaddress.php"); ?>
		<? include("./inc/inc_files.php"); ?>
		
		
		
	</div></div>
	<? include("./inc/nav_well_root.php"); ?>
    <? include("./inc/nav_well_events.php"); ?>

</div>

<? include("./inc/foot.php"); 