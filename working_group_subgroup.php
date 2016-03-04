<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>

<div id="page_body" class="row">
	<div class='col-sm-9'>
		 <h2><?=$page->title; ?></h2>
		 <h5 class="padding-none margin-none text-muted">Sub group of <?=$page->parent()->parent()->title; ?></h5>
		<span class='bodytext'><?=$page->body; ?> </span>
    
     <?
  if($page->children("template=working_group")->count()) {
    echo "<ul class='list list-icon icon-chevron-right'>
          <li class='text-bold'>{$page->parent->title} Sub Groups</li>";
      foreach($page->children as $child) {
        echo "<li><a href='{$child->url}'>{$child->title}</a></li>"; 
      }
    echo "</ul>";
  }
  ?>  
      <?
  // The following finds all of the locations  this staff person is tied with, loops through and prints.
  $matches = $pages->find("id=$page->relate_staff_chair, sort=alphabetical");
  unset($i);
  foreach($matches as $match) {
    $i++; // Increments the key
    $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
    if ($match->image) {
      $img_sized = $match->image->size(300);
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$img_sized->url}' class='img-responsive ' alt='{$match->title} {$img_sized->description}'>
                </a>
              </div>";
      $tempcss = "padding-top-sm";  // This helps push the text down to balance out the position of the text next to the image
    } else {
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$match->title}'>
                </a>
              </div>";
      $tempcss = "padding-top-sm";
    }
    $tempval .= "<div class='col-sm-6 {$temprow}'>
                {$tempimg}
                  <div class='col-sm-8 $tempcss'>
                    <a href='{$match->url}' class='text-bold' title='{$match->title}'>{$match->title}</a>
                    <div class='text-muted text-xs'>{$match->staff_title}</div>
                  </div>
                 </div>
                 ";
  }
   if($tempval) {
    $temptitle = $matches->count() == "1" ? "Chair" : 'Chairs';   // This changes the title to account for more than 1 location
    echo "<hr /><h3>{$temptitle}</h3>"; 
    echo "<div class='row'>{$tempval}</div>";
    
   unset($tempcss);
   unset($temptitle);
   unset($tempval);
   unset($tempimg);
   unset($i);
   }
  ?>  
  
  <?
  // The following finds all of the locations this staff person is tied with, loops through and prints.
  $matches = $pages->find("id=$page->relate_staff_coordinator, sort=alphabetical");
  $i = 0; // sets a key valye
  foreach($matches as $match) {
    $i++; // Increments the key
    $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
    if ($match->image) {
      $img_sized = $match->image->size(300);
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$img_sized->url}' class='img-responsive ' alt='{$match->title} {$img_sized->description}'>
                </a>
              </div>";
      $tempcss = "padding-top-md";  // This helps push the text down to balance out the position of the text next to the image
    }else {
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$match->title}'>
                </a>
              </div>";
      $tempcss = "padding-top-sm";
    }
    $tempval .= "<div class='col-sm-6 {$temprow}'>
                {$tempimg}
                  <div class='col-sm-8 $tempcss'>
                    <a href='{$match->url}' class='text-bold' title='{$match->title}'>{$match->title}</a>
                    <div class='text-muted text-sm'>{$match->staff_title}</div>
                  </div>
                 </div>
                 ";
  }
   if($tempval) {
    $temptitle = $matches->count() == "1" ? "Coordinator" : 'Coordinators';   // This changes the title to account for more than 1 location
    echo "<hr /><h3>{$temptitle}</h3>"; 
    echo "<div class='row'>{$tempval}</div>";
    
   unset($tempcss);
   unset($temptitle);
   unset($tempval);
   unset($tempimg);
   unset($i);
   }
  ?>  
   
    <?
  // The following finds all of the locations this staff person is tied with, loops through and prints.
  $matches = $pages->find("id=$page->relate_staff, sort=alphabetical");
  foreach($matches as $match) {
    $i++; // Increments the key
    $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
    if ($match->image) {
      $img_sized = $match->image->size(300);
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$img_sized->url}' class='img-responsive ' alt='{$match->title} {$img_sized->description}'>
                </a>
              </div>";
      $tempcss = "padding-top-md";  // This helps push the text down to balance out the position of the text next to the image
    }else {
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$match->title}'>
                </a>
              </div>";
      $tempcss = "padding-top-sm";
    }
    $tempval .= "<div class='col-sm-6 {$temprow}'>
                {$tempimg}
                  <div class='col-sm-8 $tempcss'>
                    <a href='{$match->url}' class='text-bold' title='{$match->title}'>{$match->title}</a>
                    <div class='text-muted text-sm'>{$match->staff_title}</div>
                  </div>
                 </div>
                 ";
  }
   if($tempval) {
    $temptitle = $matches->count() == "1" ? "Member" : 'Members';   // This changes the title to account for more than 1 location
    echo "<hr /><h3>{$temptitle}</h3>"; 
    echo "<div class='row'>{$tempval}</div>";
    
   unset($tempcss);
   unset($temptitle);
   unset($tempval);
   unset($tempimg);
   unset($i);
   }
  ?>       

         
		<? include("./inc/inc_files.php"); ?>
	</div>
<? include("./inc/nav_well_workinggroup.php"); ?>
</div>
<? include("./inc/foot.php"); 


