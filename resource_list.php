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
  $tabs = $page->children('sort=sort');
  $tab_first = $page->children('sort=sort')->first()->id;
  $has_parent = $page->id;
  $segmentTab = $input->urlSegment2;
  $activeTab = ($segmentTab == "" ? 'All' : $segmentTab);
  ?>
  <?
    foreach($tabs as $tab) {
      $isActive = ($tab_first == $tab->id ? 'active' : '');
      echo "<li role='presentation' class='$isActive'><a href='#{$tab->name}' aria-controls='{$tab->name}' role='tab' data-toggle='tab'  onClick=\"ga('send', 'event', 'web-list', 'tab', '{$tab->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\" >$tab->title</a></li>";
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
      <?php
  
  
foreach($tabs as $tab) { 
 
  $isActive = ($tab_first == $tab->id ? 'active' : '');
  $tabpanelid = $tab->id;
  $tabtemplate = $tab->template->name;
  // Grabs the children for the page
  $matches = $pages->get($tabpanelid)->children;
  
  if($tabtemplate == "resource_list_tab") {    // checks to see if it is the ALL tab... if not grab resources that match
    $matches = $pages->find("sort=sort, template=resource_list_item, relate_resource_list_tabs=$tabpanelid");
  }

   echo "<div role='tabpanel' class='tab-pane $isActive padding-top-lg' id='$tab->name'>";
        echo "<div class='col-sm-12'>";
			//$matches = $pages->find("sort=sort, template=resource_list_content, has_parent=$has_parent");
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
                 <a class='padding-top-none' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-link', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>{$tempimg} </a>
              </div>
              <div class='col-sm-9 col-xs-10  margin-left-lg padding-bottom-lg'>
                <strong>
                 <a class='text-black' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-link', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>
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
    echo "</div>";
	?>
  <?
}
	?>
  
  
  
  </div>
  </div>
</div>
</div></div>
</div>
	


<? include("./inc/foot.php"); 


