<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>
<div class="row"> 
	<div class="col-sm-12">
	<div class="content-space content-border"><h2 class='page-title'><?=$page->title; ?></h2>
    <span class='bodytext'><?=$page->body; ?> </span>
   
    <ul class="nav nav-tabs">
  
  <li class="active"><a href="#" data-toggle="tab">Leadership</a></li>
  <li class="active"><a href="#" data-toggle="tab">PI's</a></li>
  <li class="active"><a href="#Alphabetical" data-toggle="tab">Team</a></li>
  <li class=""><a href="#workinggroup" data-toggle="tab">Working Groups</a></li>
  <li class=""><a href="#location" data-toggle="tab">ClinGen Sites</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">


   <div class="tab-pane" id="location">
   
   
   <?
  $matches = $pages->find("template=location, sort=alphabetical");
  foreach($matches as $match) {
      echo "<h3>{$match->title}</h3><div class='row'><ul class='list-unstyled padding-top-xs padding-bottom-lg'>";
  // Finds all of the staff that are tied to this location.
  $matches1 = $pages->find("template=staff, relate_supporter=$match->id, sort=alphabetical");
      foreach($matches1 as $match1) {
        $tempval .= "<li class='col-sm-6'><a href='{$match1->url}.' title='{$match1->title}.'>{$match1->title}</a></li> ";
    }
   if($tempval) { 
    echo $tempval;
   }
   echo "</ul></div>";
   unset($tempval);
   }
  ?>
   
   
   </div>
  <div class="tab-pane" id="workinggroup">
  
   <?
  $matches = $pages->find("template=working_group, sort=alphabetical");
  foreach($matches as $match) {
      echo "<h3>{$match->title}</h3><div class='row'><ul class='list-unstyled padding-top-xs padding-bottom-lg'>";
  // Finds all of the staff that are tied to this location.
  $matches1 = $pages->find("template=staff, id=$match->relate_staff_chair, sort=alphabetical");
      foreach($matches1 as $match1) {
        $tempval .= "<li class='col-sm-6'><a href='{$match1->url}.' title='{$match1->title}.'>{$match1->title} <span class='text-muted'>(Chair)</span></a></li> ";
    }
  $matches1 = $pages->find("template=staff, id=$match->relate_staff_coordinator, sort=alphabetical");
      foreach($matches1 as $match1) {
        $tempval .= "<li class='col-sm-6'><a href='{$match1->url}.' title='{$match1->title}.'>{$match1->title} <span class='text-muted'>(Coordinator)</span></a></li> ";
    }
  $matches1 = $pages->find("template=staff, id=$match->relate_staff, sort=alphabetical");
      foreach($matches1 as $match1) {
        $tempval .= "<li class='col-sm-6'><a href='{$match1->url}.' title='{$match1->title}.'>{$match1->title}</a></li> ";
    }
   if($tempval) { 
    echo $tempval;
   }
   echo "</ul></div>";
   unset($tempval);
   }
  ?>
  
   </div>
  <div class="tab-pane active" id="Alphabetical">
  
  <br>
  <?php
			$matches = $pages->find("template=staff, sort=alphabetical, display_hide_from_list=0");
		  foreach($matches as $match) {
      $i++; // Increments the key
      $temprow = ($i % 3 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
				if($match->image) {
					$img_sized = $match->image->size(200,200)->url;
         $tempimg = "<img src='{$img_sized}' class='img img-responsive img-rounded' alt='{$match->title}'>";
				} else {
         $tempimg = "<img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$match->title}'>";
				} 
				echo "<div class='col-sm-4 {$temprow} padding-bottom-md text-tight'>
              <a class='text-black thumbnail clearfix' href='{$match->url}' title='{$match->title} - {$match->staff_title}'>
              <div class='col-sm-8 col-md-9'>
                    {$match->title}
                    <div class='text-xs text-muted hidden-sm'>{$match->staff_title}</div>
              </div>
              <div class='col-sm-4 col-md-3'>
                {$tempimg}
              </div>
              </a>
            </div>
					";
			}
		unset($tempimg)
	?>
  
  
  </div>
</div>

</div>
</div>
	

<? include("./inc/foot.php"); 


