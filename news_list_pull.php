<?php $showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>

<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border">
  <h2 class='page-title'><?=$page->title; ?></h2>
		
		
	<?php
    if($page->relate_new_list) {
        //echo $page->relate_new_list;
        $features = $pages->find("parent=$page->relate_new_list");  // Uses the Parent ID to search for entries that only have that as a parent
        foreach($features as  $feature) { 
          $date_media = date("M Y", $feature->date_start); // Formating the date correctly
              echo "<div class='row padding-bottom-sm'>
              <div class='col-sm-2' >{$date_media}</div>
              <div   class='col-sm-10' ><a href='{$feature->url}' title='{$date_media} - {$feature->title}'>{$feature->title}</a>";
              if($feature->title) {
              echo "<br />{$feature->summary}";
              }
              echo "</div></div>"; 
			}
    }
?> 


		
	</div>	
	</div>
	<? include("./inc/nav_well_root.php"); ?>

</div>

<? include("./inc/foot.php"); 