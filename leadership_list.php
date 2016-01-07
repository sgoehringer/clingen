<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>

<div id="page_body" class="row">
	<div class='col-sm-9'>
		<h2><?php echo $page->title; ?></h2>
        
        
		<span class='bodytext'><?=$page->body; ?> </span>
      <ul class="nav nav-tabs">
  <?
    $matches = $pages->find("template=working_group, leadership>=1, sort=sort");
    foreach($matches as $match) {
      $i++; // Increments the key
      $tempclass = ($i == 1 ? 'active' : '');
      echo "<li class='{$tempclass}'><a href='#id_{$match->id}' data-toggle='tab'>{$match->title}</a></li>";
    }
    unset($tempclass);
  ?>
</ul>
<div class="tab-content">

<?
    $matches = $pages->find("template=working_group, leadership>=1, sort=sort");
    foreach($matches as $match) {
      $ii++; // Increments the key
      $tempclass = ($ii == 1 ? 'active' : '');
      echo "<div class='{$tempclass} tab-pane' id='id_{$match->id}'>";
        // Finds all of the working groups that this staff ID is tied with as a CHAIR.
      $submatches = $match->relate_staff_chair;
      unset($tempclass);
      if(count($submatches)) {
      echo "<h3>Chairs</h3><div class='row'>";
            foreach($submatches as $submatch) {
              $i++; // Increments the key
        $temprow = ($i % 3 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
          if($submatch->image) {
            $img_sized = $submatch->image->size(200,200)->url;
           $tempimg = "<img src='{$img_sized}' class='thumbnail img img-responsive img-rounded' alt='{$submatch->title}'>";
          } else {
           $tempimg = "<img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$submatch->title}'>";
          } 
          echo "<div class='col-sm-4 {$temprow} padding-bottom-lg margin-bottom-lg text-tight'>
                <a class='text-black  clearfix' href='{$submatch->url}' title='{$submatch->title} - {$submatch->staff_title}'>
                <div class='col-sm-10 col-sm-offset-1'>
                      {$tempimg}
                      {$submatch->title}
                      <div class='text-xs text-muted hidden-sm'>{$submatch->staff_title}</div>
                </div>
                
                </a>
              </div>
            ";
          }
          echo "</div>";
        unset($submatches);
        unset($i);
        unset($tempclass);
      }
      
      
        // Finds all of the working groups that this staff ID is tied with as a MEMBER.
       $submatches = $match->relate_staff;
       if(count($submatches)) {
      echo "<h3 class='clearfix'>Members</h3><div class='row'>";
            foreach($submatches as $submatch) {
              $i++; // Increments the key
        $temprow = ($i % 3 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
          if($submatch->image) {
            $img_sized = $submatch->image->size(200,200)->url;
           $tempimg = "<img src='{$img_sized}' class='thumbnail img img-responsive img-rounded' alt='{$submatch->title}'>";
          } else {
           $tempimg = "<img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$submatch->title}'>";
          } 
          echo "<div class='col-sm-4 {$temprow} padding-bottom-lg margin-bottom-lg text-tight'>
                <a class='text-black  clearfix' href='{$submatch->url}' title='{$submatch->title} - {$submatch->staff_title}'>
                <div class='col-sm-10 col-sm-offset-1'>
                      {$tempimg}
                      {$submatch->title}
                      <div class='text-xs text-muted hidden-sm'>{$submatch->staff_title}</div>
                </div>
                
                </a>
              </div>
            ";
          }
          echo "</div>";
        unset($submatches);
        unset($i);
        unset($tempclass);
      }
       // Finds all of the working groups that this staff ID is tied with as a Coordinator.
       $submatches = $match->relate_staff_coordinator;
      if(count($submatches)) {
      echo "<h3 class='clearfix'>Coordinators</h3><div class='row'>";
            foreach($submatches as $submatch) {
              $i++; // Increments the key
        $temprow = ($i % 3 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
          if($submatch->image) {
            $img_sized = $submatch->image->size(200,200)->url;
           $tempimg = "<img src='{$img_sized}' class='thumbnail img img-responsive img-rounded' alt='{$submatch->title}'>";
          } else {
           $tempimg = "<img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$submatch->title}'>";
          } 
          echo "<div class='col-sm-4 {$temprow} padding-bottom-lg margin-bottom-lg text-tight'>
                <a class='text-black  clearfix' href='{$submatch->url}' title='{$submatch->title} - {$submatch->staff_title}'>
                <div class='col-sm-10 col-sm-offset-1'>
                      {$tempimg}
                      {$submatch->title}
                      <div class='text-xs text-muted hidden-sm'>{$submatch->staff_title}</div>
                </div>
                
                </a>
              </div>
            ";
          }
          echo "</div>";
        unset($submatches);
        unset($i);
        unset($tempclass);
      }
      
      echo "</div>";
    }
  ?>
  
  </div></div>

<? include("./inc/nav_well.php"); ?>
</div>
<? include("./inc/foot.php"); 

