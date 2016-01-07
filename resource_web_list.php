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
   
    
    <div role="tabpanel padding-top-lg">
    
  <ul class="nav nav-tabs" role="tablist">
      
  <?
  $tabs = $pages->get("2686")->children('sort=sort');
  $segmentTab = $input->urlSegment2;
  $activeTab = ($segmentTab == "" ? 'All' : $segmentTab);
  
  ?>
  <li role="presentation" class="<? echo ($activeTab == "All" ? 'active' : '') ?>"><a href="#All" aria-controls="All" role="tab" data-toggle="tab" onClick="ga('send', 'event', 'web-resources', 'tab', 'All', {'page': '<?=$page->path?><?=$input->urlSegment1?>', 'nonInteraction': 1});">All Resources</a></li>
  <?
    foreach($tabs as $tab) {
      $isActive = ($activeTab == $tab->name ? 'active' : '');
      echo "<li role='presentation' class='$isActive'><a href='#{$tab->name}' aria-controls='{$tab->name}' role='tab' data-toggle='tab'  onClick=\"ga('send', 'event', 'web-resources', 'tab', '{$tab->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\" >$tab->title</a></li>";
    }
    ?>
    
    <? /*
<li role="presentation" class="pull-right">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
        Contact Us
  </button>
</li>

*/ ?>
  </ul>
    <div class="row ">
     <div class="tab-content">
     
     
     <div role="tabpanel" class="tab-pane <?=($activeTab == "All" ? 'active' : '') ?> padding-top-lg" id="All">
  <?php
  
        echo "<div class='col-sm-12'>";
			$matches = $page->children("sort=sort");
		  foreach($matches as $match) {
      $i++; // Increments the key
      $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
				if($match->image) {
					$img_sized = $match->image->size(200,200)->url;
         $tempimg = "<img src='{$img_sized}' class=' margin-left-lg img img-responsive img-rounded' alt='{$match->title}'>";
				} else {
         $tempimg = "";
				} 
       foreach($match->relate_resource_type as $submatch) {
         //$type_info .= "<span class='label label-default'>". $submatch->title ."</span> ";
       }
       foreach($match->relate_resource_classification as $submatch) {
         $register_info .= "<span class='label label-warning pull-right'>". $submatch->title ."</span> ";
       }
       //$type_info = substr($type_info, 0, -3);
				echo "<div class='col-sm-6 {$temprow} padding-bottom-lg'>
              <div class='col-sm-2 col-xs-1 padding-none'>
                 <a class='padding-top-none' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-resources', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>{$tempimg}</a>
              </div>
              <div class='col-sm-9 col-xs-10  margin-left-lg padding-bottom-lg'>
                <strong>
                 <a class='text-black' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-resources', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>
                    {$match->title} <span class=' glyphicon text-sm text-muted glyphicon-new-window'></span>
                 </a></strong> $register_info
                    <div class='text-sm text-muted margin-top-sm'>{$match->summary}</div>
                    <div class='text-sm text-muted margin-top-sm'>{$type_info}</div>
                  
              </div>
            </div>
					";
		unset($type_info);
		unset($register_info);
			}
		unset($tempimg);
		unset($temprow);
		unset($i);
    echo "</div>";
	?>
  </div>
  
  
<?php
  
  
foreach($tabs as $tab) { 
 
  $isActive = ($activeTab == $tab->name ? 'active' : '');
   $tabpanelid = $tab->id;
  // Grabs the children for the page
  $children = $pages->get($tabpanelid)->children;
  
  if(!count($children)) {
  $nochildrencss = " padding-top-lg";
  }
  
  echo "<div role='tabpanel' class='tab-pane $isActive $nochildrencss' id='$tab->name'>";
  //Checks to see if this page has children
    if(count($children)) {
		  foreach($children as $child) { 
        echo "<div class='col-sm-12'><h3 class='border-bottom margin-bottom-md'>$child->title</h3>";
        $resouceid = $child->id;
        // Starts looping through the matches
      $matches = $page->children("sort=sort, relate_resource_type=$resouceid");
      foreach($matches as $match) {
      $i++; // Increments the key
      $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
        if($match->image) {
          $img_sized = $match->image->size(200,200)->url;
         $tempimg = "<img src='{$img_sized}' class=' margin-left-lg img img-responsive img-rounded' alt='{$match->title}'>";
        } else {
         $tempimg = "";
        } 
       foreach($match->relate_resource_type as $submatch) {
         //$type_info .= "<span class='label label-default'>". $submatch->title ."</span> ";
       }
       foreach($match->relate_resource_classification as $submatch) {
         $type_info .= "<span class='label label-warning'>". $submatch->title ."</span> ";
       }
       //$type_info = substr($type_info, 0, -3);
        echo "<div class='col-sm-6 {$temprow} padding-bottom-lg'>
              <div class='col-sm-2 col-xs-1 padding-none'>
                 <a class='padding-top-none' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-resources', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>{$tempimg}</a>
              </div>
              <div class='col-sm-9 col-xs-10  margin-left-lg padding-bottom-lg'>
                <strong>
                 <a class='text-black' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-resources', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>
                    {$match->title} <span class=' glyphicon text-sm text-muted glyphicon-new-window'></span>
                 </a></strong>
                    <div class='text-sm text-muted margin-top-sm'>{$match->summary}</div>
                    <div class='text-sm text-muted margin-top-sm'>{$type_info}</div>
                  
              </div>
            </div>
          ";
      unset($type_info);
        }
      unset($tempimg);
      unset($temprow);
      unset($i);
      
    echo "</div>";
        }
        
        
   echo "</div>"; 
        
      } else {
        $resouceid = $tabpanelid;
        
        echo "<div class='col-sm-12'>";
        $matches = $page->children("sort=sort, relate_resource_type=$resouceid");
      foreach($matches as $match) {
      $i++; // Increments the key
      $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
        if($match->image) {
          $img_sized = $match->image->size(200,200)->url;
         $tempimg = "<img src='{$img_sized}' class=' margin-left-lg img img-responsive img-rounded' alt='{$match->title}'>";
        } else {
         $tempimg = "";
        } 
       foreach($match->relate_resource_type as $submatch) {
         //$type_info .= "<span class='label label-default'>". $submatch->title ."</span> ";
       }
       foreach($match->relate_resource_classification as $submatch) {
         $type_info .= "<span class='label label-warning'>". $submatch->title ."</span> ";
       }
       //$type_info = substr($type_info, 0, -3);
        echo "<div class='col-sm-6 {$temprow} padding-bottom-lg'>
              <div class='col-sm-2 col-xs-1 padding-none'>
                 <a class='padding-top-none' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-resources', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>{$tempimg}</a>
              </div>
              <div class='col-sm-9 col-xs-10  margin-left-lg padding-bottom-lg'>
                <strong>
                 <a class='text-black' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-resources', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>
                    {$match->title} <span class=' glyphicon text-sm text-muted glyphicon-new-window'></span>
                 </a></strong>
                    <div class='text-sm text-muted margin-top-sm'>{$match->summary}</div>
                    <div class='text-sm text-muted margin-top-sm'>{$type_info}</div>
                  
              </div>
            </div>
          ";
      unset($type_info);
        }
      unset($tempimg);
      unset($temprow);
      unset($i);
        echo "</div>";
        echo "</div>";
      }
      
      unset($nochildrencss);
}
	?>
  
  
  
  </div>
  </div>
</div>
</div></div>
</div>
	

<? /* 
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Contact The Web Resources Team</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10">
                <input type="email" required class="form-control" id="inputEmail3" placeholder="Email">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Institution</label>
              <div class="col-sm-10">
                <input type="email" required class="form-control" id="inputEmail3" placeholder="Email">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input type="email" required class="form-control" id="inputEmail3" placeholder="Email">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Comments</label>
              <div class="col-sm-10">
                <textarea required class="form-control" ></textarea>
              </div>
            </div>
            <div class="form-group margin-bottom-none">
              <div class="col-sm-12">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary pull-right">Send</button>
              </div>
              <div class="col-sm-12 text-sm text-muted padding-top-sm">
              All fields are required
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

*/ ?>
<? include("./inc/foot.php"); 


