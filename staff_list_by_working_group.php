<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");

$workinggroup = $page->relate_working_group;
?>

<div id="page_body" class="row">
	<div class='col-sm-9'>
		<h2><?=$page->title; ?></h2>
		<span class='bodytext'><?=$page->body; ?> </span>
    
    
		<?
    // The following grabs the working group ID's tied to this page.
    $workinggroup = $page->relate_working_group;
    // Goes and finds the chairs for the working group
    $temp_relate_staff_chair = $pages->get("id=$workinggroup")->relate_staff_chair;
    // Goes and finds the coordinator for the working group
    $temp_relate_staff_coordinator = $pages->get("id=$workinggroup")->relate_staff_coordinator;
    // Goes and finds the members for the working group
    $temp_relate_staff = $pages->get("id=$workinggroup")->relate_staff;
    ?>
    
      <?
  // The following finds all of the chairs is tied with, loops through and prints.
  $matches = $temp_relate_staff_chair;
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
   }
  ?>  
  
  <?
  // The following finds all of the coordinator is tied with, loops through and prints.
  $matches = $temp_relate_staff_coordinator;
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
   }
  ?>  
   
    <?
  // The following finds all the staff person is tied with, loops through and prints.
  $matches = $temp_relate_staff;
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
   }
  ?>       

         
	</div>
<? include("./inc/nav_well.php"); ?>
</div>
<? include("./inc/foot.php"); 


