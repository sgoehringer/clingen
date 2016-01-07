


 
<?php

include("./assets/resource_web_list_search_assets/inc/block-head-php.php");

$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>

<div class="row">
  <div class="col-sm-12">
    <div class="content-space content-border  padding-top-md"> <span class='bodytext'>
      <?=$page->body; ?>
      </span> 
      
      
     <?    
      include("./assets/resource_web_list_search_assets/inc/block1.php"); 
      
      ?>
      
      <div role="tabpanel padding-top-lg"> 
        
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <?
  //$tabs = $pages->get("2128")->children('sort=sort');
  $tabs = $pages->get("2686")->children('sort=sort');
  $segmentTab = $input->urlSegment1;
  $activeTab = ($segmentTab == "" ? 'all' : $segmentTab);
  
  ?>
          <li class='margin-right-lg padding-right-lg'>
            <h3 class='page-title margin-top-sm'>
              <?=$page->title; ?>
            </h3>
          </li>
          <li role="presentation" class="text-muted <? echo ($activeTab == "all" ? 'active' : '') ?>"><a href="<?=$page->path?>all/<?=$session->jsonResourceSearchCode?>" aria-controls="all" class='text-muted ' onClick="ga('send', 'event', 'web-resources', 'tab', 'All', {'page': '<?=$page->path?><?=$input->urlSegment1?>', 'nonInteraction': 1});">All Resources</a></li>
          <?
    foreach($tabs as $tab) {
      $isActive = ($activeTab == $tab->name ? 'active' : '');
      $thisHref = $page->path."".$tab->name."/".$session->jsonResourceSearchCode;
      echo "<li role='presentation' class='text-muted $isActive'><a href='$thisHref' aria-controls='{$tab->name}' class='text-muted ' onClick=\"ga('send', 'event', 'web-resources', 'tab', '{$tab->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\" >$tab->title</a></li>";
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
        
        <?    
      
      include("./assets/resource_web_list_search_assets/inc/block2.php"); 
      
      ?>
        
        <div class="row ">
          <div class="tab-content">
            <div class="col-sm-12 padding-top-lg">
              <div id='search_results' style="display:none;">
                <div class="text-center padding-bottom-sm"> <span class="img-thumbnail text-center text-muted" style='position: relative; top: 16px; z-index:1000'> <span class='glyphicon glyphicon-search'></span> Search Results <span class='glyphicon glyphicon-search'></span></span>
                  <div class="list-group text-left"> <a href="#" class="list-group-item">Cras justo odio</a> <a href="#" class="list-group-item">Dapibus ac facilisis in</a> <a href="#" class="list-group-item">Morbi leo risus</a> <a href="#" class="list-group-item">Porta ac consectetur ac</a> <a href="#" class="list-group-item">Vestibulum at eros</a> </div>
                </div>
              </div>
              <div class="text-center padding-bottom-md"> <span class="img-thumbnail text-center text-muted" style='position: relative; top: 36px;'> <span class='glyphicon glyphicon-download'></span> Resource Directory <span class='glyphicon glyphicon-download'></span></span>
                <hr />
              </div>
            </div>
            <?php if($activeTab == "all") { ?>
            <div role="tabpanel" class="tab-pane active padding-top-lg" id="All">
              <?php
  
        echo "<div class='col-sm-12'> <h4 class='border-bottom margin-bottom-md margin-top-none'>All Resources</h4>";
			//$matches = $pages->get(2132)->children("sort=sort");
      $matches = $pages->get(2713)->children("sort=sort");
      //$matches = $page->children("sort=sort");
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
            
            <? } ?>
            <?php
  
  
foreach($tabs as $tab) { 
  if($activeTab == $tab->name) {
    
  $tabpanelid = $tab->id;
  $children = $pages->get($tabpanelid)->children;
  
  if(!count($children)) {
  $nochildrencss = " padding-top-lg";
  }
  
  echo "<div role='tabpanel' class='tab-pane active $nochildrencss' id='$tab->name'>";
  //Checks to see if this page has children
    if(count($children)) {
		  foreach($children as $child) { 
        echo "<div class='col-sm-12'><h4 class='border-bottom margin-bottom-md margin-top-none'>$child->title</h4>";
        $resouceid = $child->id;
        // Starts looping through the matches
      //$matches = $pages->get(2132)->children("sort=sort, relate_resource_type=$resouceid");
      $matches = $pages->get(2713)->children("sort=sort, relate_resource_type=$resouceid");
      //$matches = $page->children("sort=sort, relate_resource_type=$resouceid");
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
        //$matches = $pages->get(2132)->children("sort=sort, relate_resource_type=$resouceid");
        $matches = $pages->get(2713)->children("sort=sort, relate_resource_type=$resouceid");
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
}
	?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?

/*
    // Print the results
    echo "<pre>jsonResourceSearchTerm<br>";
    print_r($session->jsonResourceSearchTerm);
    echo "</pre>";
    echo "<pre>jsonResourceSearchCode<br>";
    print_r($session->jsonResourceSearchCode);
    echo "</pre>";
    echo "<pre>jsonResourceSearchSystemsCode<br>";
    print_r($session->jsonResourceSearchSystemsCode);
    echo "</pre>";
    echo "<pre>jsonResourceSearchUrl<br>";
    print_r($session->jsonResourceSearchUrl);
    echo "</pre>";
    echo "<pre>jsonResourceSearchTab<br>";
    print_r($session->jsonResourceSearchTab);
    echo "</pre>";
    echo "<pre>jsonResourceSearchData<br>";
    print_r($session->jsonResourceSearchData);
    echo "</pre>";
    echo "<pre>resourceNavData<br>";
    print_r($resourceNavData);
    echo "</pre>";
    echo "<pre>$jsondata<br>";
    print_r($jsondata);
    echo "</pre>";
    */
    
?>

<? include("./inc/foot.php"); 
?>