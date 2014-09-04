<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>

<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border"><h2 class='page-title'><?=$page->title; ?></h2>
		
		
		
	<?
	
  // relate_supporter_type=1449 is the ClinGen site designation found in the HIDDEN Dir
	$items = $pages->find("template=partner, relate_supporter_type=1449, mapmarker!='', sort=title"); 
	$mapmarker = $modules->get('MarkupGoogleMap'); 
	echo $mapmarker->render($items, 'mapmarker'); 
	
	?>
	

	<hr>
	<div class='row padding-bottom-xs padding-top-xs'>
		<?
  // The following finds all of the locations this staff person is tied with, loops through and prints.
  $matches = $pages->find("template=partner, relate_supporter_type=1449, sort=alphabetical");
  foreach($matches as $match) {
    $i++; // Increments the key
    
    $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
        if ($match->image) {
          $img_sized = $match->image->size(300);
          $tempimg = "<div class='col-sm-4'>
                    <a href='{$match->url}' class='text-bold' title='{$match->title}'>
                    <img src='{$img_sized->url}' class='img-responsive ' alt='{$match->title} {$img_sized->description}'>
                    </a>
                  </div>";
          $tempcss = "padding-top-md";  // This helps push the text down to balance out the position of the text next to the image
        }
        $tempurl = parse_url($match->url_website);
        $tempurl = $tempurl['host']; // prints 'google.com'
        $tempval .= "<div class='col-sm-6 padding-bottom-xl $temprow'>
                    {$tempimg}
                      <div class='col-sm-8 $tempcss'>
                        <a href='{$match->url}' class='text-bold' title='{$match->title}'>{$match->title}</a>
                        <div class='text-muted text-sm'>{$match->mapmarker->address}</div>
                        <a href='{$match->url}' class='text-muted text-sm' title='{$match->url_website}'>{$tempurl}</a>
                      </div></div>";
    }
   if($tempval) {
    echo $tempval;
   
   unset($tempcss);
   unset($temptitle);
   unset($tempval);
   unset($tempimg);
   }
  ?>  
  
  
  </div></div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

