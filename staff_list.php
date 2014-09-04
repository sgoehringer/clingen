<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>
<div class="row"> 
	<div class="col-sm-9">
	<div class="content-space content-border"><h2 class='page-title'><?=$page->title; ?></h2>
    <span class='bodytext'><?=$page->body; ?> </span>
   
    
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
              <div class='col-sm-3'>
                 <a class='img-responsive' href='{$match->url}'  title='{$match->title} - {$match->staff_title}'>{$tempimg}</a>
              </div>
              <div class='col-sm-9'>
                 <a class='text-black' href='{$match->url}' title='{$match->title} - {$match->staff_title}'>
                    {$match->title}
                    <div class='text-xs text-muted'>{$match->staff_title}</div>
                  </a>
              </div>
            </div>
					";
			}
		unset($tempimg)
	?>
  
  

</div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 


