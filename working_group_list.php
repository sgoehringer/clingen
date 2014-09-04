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
  
  <li class="active"><a href="#workinggroup" data-toggle="tab">Working Groups</a></li>
  <li class=""><a href="#Alphabetical" data-toggle="tab">ClinGen Directory</a></li>
</ul>

<div class="tab-content">

<div class="tab-pane active" id="workinggroup">
  
   <?
  $matches = $page->children->find("template=working_group, leadership=0, sort=alphabetical");
  foreach($matches as $match) {
      echo "<h3><a href='{$match->url}' class='text-black' title='{$match->title}'>{$match->title}</a></h3><div class='row padding-bottom-sm'>";
      if($match->summary) { echo "<div class='col-sm-12'>{$match->summary} <a href='{$match->url}' title='{$match->title}'>Learn more</a></div>"; }
      if(count($match->children)) { 
        echo "<div class='col-sm-12'><ul class='list-inline'>
          <li class='text-muted'>Sub Groups: </li>";
        foreach($match->children as $submatch) {
          $tempval .= "<a href='{$submatch->url}' title='{$submatch->title}'>{$submatch->title}</a> | ";
          }
          $tempval = rtrim($tempval, "| ");  // Strips the comma and space from the end
          echo $tempval;
        echo "</ul></div>"; 
      }
    unset($tempval);
    echo "</div>";
   }
  ?>
  
   </div>
  
  <div class="tab-pane" id="Alphabetical">
  
  <br>
  <?php
			$matches = $pages->find("template=staff, sort=alphabetical, display_hide_from_list=0");
		  foreach($matches as $match) {
      $i++; // Increments the key
      $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
				if($match->image) {
					$img_sized = $match->image->size(200,200)->url;
         $tempimg = "<img src='{$img_sized}' class='img img-responsive img-rounded' alt='{$match->title}'>";
				} else {
         $tempimg = "<img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$match->title}'>";
				} 
				echo "<div class='col-sm-6 {$temprow} padding-bottom-md text-tight'>
              <a class='text-black thumbnail clearfix' href='{$match->url}' title='{$match->title} - {$match->staff_title}'>
              <div class='col-sm-10'>
                    {$match->title}
                    <div class='text-xs text-muted hidden-sm'>{$match->staff_title}</div>
              </div>
              <div class='col-sm-2'>
                {$tempimg}
              </div>
              </a>
            </div>
					";
			}
		unset($tempimg)
	?>
  
  
  </div>
 </div></div>

<? include("./inc/nav_well.php"); ?>
</div>
<? include("./inc/foot.php"); 

