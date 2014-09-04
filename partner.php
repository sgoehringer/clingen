<?php 

/**
 * Page template
 * 
 */
 $redirect = $page->parent->url;
 $url = $redirect;
 $session->redirect($url);
?>

<?php

/*
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");

if($page->image) {
	$img_sized = $page->image->size(300)->url;
  $img = "<img src='{$img_sized}' class='img img-responsive' alt='{$match->title}'>";

}
?>

<div id="page_body" class="row">
	<div class='col-sm-12 col-content'>

  <div class='col-sm-8 pull-right'>
  <div class='clearfix'><a href="<?=$page->parent->url ?>" class='btn btn-default pull-right'>&laquo; Return to <?=$page->parent->title ?></a></div>

  <h3><?=$page->title ?></h3>
	<p class='text-muted text-sm'><?=$page->mapmarker->address; ?></p>
	
  <span class='bodytext'><?=$page->body; ?> </span>
  
  <?
  // Finds all of the staff that are tied to this location.
  $matches = $pages->find("template=staff, relate_supporter=$page->id, sort=alphabetical");
      foreach($matches as $match) {
        $tempval .= "<li class='col-sm-6' ><a href='{$match->url}.' title='{$match->title}.'>{$match->title}</a></li>";
    }
   $tempval = rtrim($tempval, ", ");  // Strips the comma and space from the end
   if($tempval) {
    echo "<hr />
      <ul>
      {$tempval}
      </ul>
      <div class='clearfix'></div>
      <hr />
    "; 
   }
   unset($tempval);
  ?>
  
  

  <?
				$mapmarker = $modules->get('MarkupGoogleMap'); 
				echo $mapmarker->render($page, 'mapmarker'); 
	?>
 </div>
 <div class='col-sm-4 pull-left'>
 <div class=" padding-right-xl padding-bottom-lg margin-right-xl">
   <?=$img ?> 
   
   <div class="list-group text-sm padding-top-sm">
    
    <? foreach($page->relate_supporter as $match) {
       $tempval .= "<a href='{$match->url}' class='list-group-item text-muted'><span class='glyphicon glyphicon-map-marker'></span> {$match->title}</a>"; 
    }
      echo $tempval;
    ?>
    
    <?
        $tempval = parse_url($page->url_website);
        $tempval = $tempval['host']; // prints 'google.com'
        echo "<a href='{$page->url_website}' class='list-group-item text-muted'><span class='glyphicon glyphicon-new-window'></span> {$tempval}</a>";
    ?>
    <?
      if($page->phone) {
        echo "<a href='tel:{$page->phone}' class='list-group-item text-muted'><span class='glyphicon glyphicon-earphone'></span> {$page->phone}</a>";
      }
    ?>
    <div class="list-group-item text-center">
    <?
      if($page->social_twitter) {
        echo "<a href='http://www.twitter.com/{$page->social_twitter}' target='_blank'><img src='".$config->urls->templates."assets/img/glyphicons_social/png/glyphicons_social_31_twitter.png' alt='Twitter'/></a> ";
      }
      if($page->social_linkedin) {
        echo "<a href='{$page->social_linkedin}' target='_blank'><img src='".$config->urls->templates."assets/img/glyphicons_social/png/glyphicons_social_17_linked_in.png' alt='LinkedIn'/></a> ";
      }
      if($page->social_facebook) {
        echo "<a href='{$page->social_facebook}' target='_blank'><img src='".$config->urls->templates."/img/glyphicons_social/png/glyphicons_social_30_facebook.png' alt='Facebook'/></a> ";
      }
      if($page->email) {
        echo "<a href='mailto:{$page->email}'><img src='".$config->urls->templates."assets/img/glyphicons/png/glyphicons_010_envelope.png' alt='Facebook'/></a> ";
      }
      ?>
</div>
   </div>
   </div>
  </div>
  
  
	
</div>
	

<? include("./inc/foot.php"); 


