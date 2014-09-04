<?php $showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>

<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border">
		
    
   <?php
    $key = 0;
    if($page->numChildren) {
        echo "<div class='row'>";
            foreach($page->children as $child) {
                echo "<div class='col-sm-12 col-md-12'>
					  <a href='{$child->url}' title='{$sitename} {$child->title}'><h2 class='text-black'>{$child->title}</h2></a>";
					  	$parent = $child->id; // Figure out the ID of so the loop grabs what is needs.
					if($parent == "1071") {
				    	$features = $pages->find("template=news_event|iccg_conference_home, limit=6, sort=-date_start");  // Uses the Parent ID to search for entries that only have that as a parent
					} elseif($parent == "1041") {
				    	$features = $pages->find("parent=$parent, limit=6, sort=date_start");  // Uses the Parent ID to search for entries that only have that as a parent
					} else {
				    	$features = $pages->find("parent=$parent, limit=6, sort=-date_start");  // Uses the Parent ID to search for entries that only have that as a parent
					}
    					foreach($features as $feature) { 
							$date_media = date("M Y", $feature->date_start); // Formating the date correctly
        					echo "<div class='row paddme-bottom-sm'>
									<div class='col-sm-2' >{$date_media}</div>
									<div   class='col-sm-10' ><a href='{$feature->url}' title='{$date_media} - {$feature->title}'>{$feature->title}</a>";
									if($feature->title) {
									echo "<br />{$feature->summary}";
									}
								  echo "</div></div>"; 
						}
        		echo "<a href='{$child->url}' title='{$sitename} {$child->title}' class='col-lg-offset-2 col-lg-10 text-muted'>[Complete {$child->title} Archive]</a><br/><br/><br/></div>";
			}
        echo "</div>";
    }
?> 
   
		
	<?php
    $key = 0;
    
        echo "<div class='row'>"; 
            foreach($pages->children as $child) { 
			
				include("./inc/event_date_code.php");

				
				// the following allows an image to be placed.  Notice the $placeimage lower down 
				include("./inc/inc_placeimage.php");
				
               echo "<div class='col-sm-12 padding-bottom-sm'>
						<div class='col-sm-3 text-right' >{$date_start}{$date_end}</div>  
						<div class='col-sm-9'> 
							{$placeimage}
							<a href='{$child->url}' title='{$date_media} - {$child->title}' class='strong'>{$child->title}</a>";
							if($child->summary) {
							echo "<div>{$child->summary}</div>";
							}
						echo "</div>
					  </div>
				"; 
				
			}
        echo "</div>";
    
?> 

		
	</div></div>
	<? include("./inc/nav_well_root.php"); ?>

</div>

<? include("./inc/foot.php"); 