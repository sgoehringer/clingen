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
		
		
    <?
    if(count($page->children)) { 
    echo "<div class='row padding-bottom-sm padding-top-sm'>";
    //$tempcss = ($i % 2 == 1 ? 'active' : '');
        echo "<div class='col-sm-12'><ul class='nav nav-tabs' role='tablist'>
          <li class='active'><a href='{$page->url}' title='{$page->title}'>Overview</a></li>";
        foreach($page->children as $match) {
          if($match->template == "rsvp_form") { $tempcss = "btn-info text-white";}
          $tempval .= "<li><a href='{$match->url}' class='$tempcss' style='' title='{$match->title}'>{$match->title}</a></li>";
            unset($tempcss);
          }
          
        
      
          echo $tempval;
        echo "</ul></div>"; 
    echo "</div>";
      }
    ?>
		
		<div class="row">
			<div class="col-sm-12">
      
			 <?php
	$key = 0;
	if(count($page->repeat_callout)) { 
		echo "<div class='row padding-top-md'>";
			foreach($page->repeat_callout as $match) {
       
       $templink = ($match->relate_page->url ? $match->relate_page->url : $match->url_website);
       if($templink) {
         $temphrefopen = "<a class='' href='{$templink}'>";
         $temphrefclose = "</a>";
         $temphrefmore = "<a class='btn btn-xs btn-default' title='{$match->label}' href='{$templink}'>more &raquo;</a>";
       }
				if($match->image){ 
					$img_sized	= $match->image->size(300,200);
					$img_src	= "<div class='col-xs-4'>{$temphrefopen}<img src='{$img_sized->url}' class='img-responsive thumbnail' alt='{$img_sized->title}' />{$temphrefclose}</div>";
				}
				echo "<div class='col-sm-12 col-xs-12 padding-bottom-md'>
						
            <div class='col-sm-8'>
						  {$temphrefopen}<h4 class='headingtight'>{$match->label}</h4> 	{$temphrefclose}
						  <p class=' hidden-xs text-sm text-muted'>{$match->summary}</p> {$temphrefmore}
          </div>{$img_src}
					  </div>
					";
      unset($templink);
      unset($temphrefopen);
      unset($temphrefclose);
      unset($temphrefmore);
			}
		echo "</div>";
	}
?> 
				
			</div>
      
    <div class="col-sm-12 padding-bottom-sm">
   <span class='bodytext'><?=$page->body; ?> </span>
    </div>
      
      <? if($page->event_location || $page->mapmarker) { ?>

			<div class="col-sm-12">
      <hr />
      <h4><?=$page->event_location; ?></h4>
      <div class='row'>
        <div class="col-sm-12">
				<?=$page->mapmarker->address; ?>
				</div>
        </div>
				<?
				
				$mapmarker = $modules->get('MarkupGoogleMap'); 
				echo $mapmarker->render($page, 'mapmarker'); 
				
				?>
			</div>
      <? } ?>
		</div>
        <hr />
		<?=$img; ?>
		
		
		
		
	</div></div>
	<? include("./inc/nav_well_root.php"); ?>

</div>

<? include("./inc/foot.php"); 
