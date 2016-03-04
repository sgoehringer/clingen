<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");

if($page->image) {
	$img_sized = $page->image->size(300)->url;
  $img = "<img src='{$img_sized}' class='img img-responsive img-rounded' alt='{$match->title}'>";

} else {
         $img = "<img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$match->title}'>";
				} 
  
?> 
<div id="page_body" class="row">
	<div class='col-sm-12 col-content'>
  <div class='col-sm-9 pull-right'>
    <div class='clearfix'><a href="<?=$page->parent->url ?>" class='btn btn-default pull-right'>&laquo; Return to <?=$page->parent->title ?></a></div>

  <h2><?=$page->title ?></h2>
	<p class='text-muted text-sm'><?=$page->staff_title ?></p>
	
  <span class='bodytext'><?=$page->body; ?> </span>
  
  
  <?
  // Finds all of the working groups that this staff ID is tied with as a CHAIR.
  $matches = $pages->find("template=working_group|working_group_subgroup|working_group_taskteam, relate_staff_chair=$page->id, sort=alphabetical");
      foreach($matches as $match) {
        $tempval .= "<li class='col-sm-6'><a href='{$match->url}.' title='{$match->title}.'>{$match->title} (Chair)</a></li>";
    }
  // Finds all of the working groups that this staff ID is tied with as a Coordinator.
  $matches = $pages->find("template=working_group|working_group_subgroup|working_group_taskteam, relate_staff_coordinator=$page->id, sort=alphabetical");
      foreach($matches as $match) {
        $tempval .= "<li class='col-sm-6'><a href='{$match->url}.' title='{$match->title}.'>{$match->title} (Coordinator)</a></li>";
    }
  // Finds all of the working groups that this staff ID is tied with as a MEMBER.
  $matches = $pages->find("template=working_group|working_group_subgroup|working_group_taskteam, relate_staff=$page->id, sort=alphabetical");
      foreach($matches as $match) {
        $tempval .= "<li class='col-sm-6'><a href='{$match->url}.' title='{$match->title}.'>{$match->title}</a></li> ";
    }
   if($tempval) {
    echo "<hr /><h3>Committees, Working Groups  &amp; Task Teams</h3>"; 
    echo " <ul class='list-icon icon-arrow-right'>";
    echo $tempval;
    echo " </ul>";
   }
   unset($tempval);
  ?>
 
  <?
  // The following finds all of the locations this staff person is tied with, loops through and prints.
  $matches = $pages->find("template=location, id=$page->relate_supporter, sort=alphabetical");
      foreach($matches as $match) {
        if ($match->image) {
          $img_sized = $match->image->size(300);
          $tempimg = "<div class='col-sm-3'>
                    <a href='{$match->url}.' class='text-bold thumbnail' title='{$match->title}.'>
                    <img src='{$img_sized->url}' class='img-responsive ' alt='{$match->title} {$img_sized->description}'>
                    </a>
                  </div>";
          $tempcss = "padding-top-xs";  // This helps push the text down to balance out the position of the text next to the image
        }
        $tempurl = parse_url($match->url_website);
        $tempurl = $tempurl['host']; // prints 'google.com'
        $tempval .= "{$tempimg}
                      <div class='col-sm-9 $tempcss'>
                        <a href='{$match->url}.' class='text-bold' title='{$match->title}.'>{$match->title}</a>
                        <div class='text-muted text-sm'>{$match->mapmarker->address}</div>
                        <a href='{$match->url}.' class='text-muted text-sm' title='{$match->url_website}.'>{$tempurl}</a>
                      </div>";
    }
   if($tempval) {
    $temptitle = $matches->count() == "1" ? "Location" : 'Locations';   // This changes the title to account for more than 1 location
    echo "<hr /><h3>{$temptitle}</h3>"; 
    echo $tempval;
    
   unset($tempurl);
   unset($$tempcss);
   unset($temptitle);
   unset($tempval);
   unset($tempimg);
   }
  ?>  
 </div>
 <div class='col-sm-3 pull-left'>
 <div class=" padding-right-xl padding-bottom-lg margin-right-xl">
   <?=$img ?> 
   
   <div class="list-group text-sm padding-top-sm">
    <? 
     if($page->relate_supporter) {
     foreach($page->relate_supporter as $match) {
       $tempval .= "<a href='{$match->url}' class='list-group-item text-muted'><span class='glyphicon glyphicon-map-marker'></span> {$match->title}</a>"; 
    }
      echo $tempval;
      unset($tempval);
     }
    ?>
    <?
      if($page->url_scholar) {
        $tempval = parse_url($page->url_scholar);
        $tempval = $tempval['host']; // prints 'google.com'
        echo "<a href='{$page->url_scholar}' class='list-group-item text-muted'><span class='glyphicon glyphicon-book'></span> {$tempval}</a>";
        unset($tempval);
      }
    ?>
    
    <?
      if($page->url_website) {
        $tempval = parse_url($page->url_website);
        $tempval = $tempval['host']; // prints 'google.com'
        echo "<a href='{$page->url_website}' class='list-group-item text-muted'><span class='glyphicon glyphicon-new-window'></span> {$tempval}</a>";
        unset($tempval);
      }
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


