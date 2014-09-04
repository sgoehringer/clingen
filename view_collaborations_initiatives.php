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
    
    <hr />
    <div class='row'>
    <?
    foreach($pages->find("parent=1050") as $match) { 
      $collaborative = $match->id;
      $matches1 = $pages->find("relate_collaborations_initiatives_project=$collaborative");
        if(count($matches1)) {
        echo "<div class='col-sm-6'><h3>$match->title</h3>
          <ul class='list-unstyled'>"; 
          // The following finds all of the locations this staff person is tied with, loops through and prints.
          foreach($matches1 as $match) {
            $i++; // Increments the key
            //$temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
           // if ($match->image) {
           //   $img_sized = $match->image->size(300);
           //   $tempimg = "<img src='{$img_sized->url}' class='img-responsive ' alt='{$match->title} {$img_sized->description}' />";
           // } 
           // {$tempimg}
            $tempval .= "<li class='col-sm-12 {$temprow} padding-bottom-xs'>
                          <a href='{$match->url}' class='' title='{$match->title}'>
                            <div class='text-sm text-muted'>{$match->title}</div>
                          </a>
                         </li>
                         ";
          }
           if($tempval) {
           echo $tempval;
           unset($tempcss);
           unset($temptitle);
           unset($tempval);
           unset($tempimg);
           }
        echo "</div>";
      }
    }
    ?>
  </div>  
	</div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

