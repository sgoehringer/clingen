<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>

<div id="page_body" class="row">
	<div class='col-sm-9'>
        
        
		<span class='bodytext'><?=$page->body; ?></span>
      
<div class="pagination-tab-wrapper text-center">
                <ul class="pagination pagination-sm margin-bottom-none" role="tablist">
            <li role="presentation" class="active"><a href="#working-groups" aria-controls="working-groups" role="tab" data-toggle="tab">Working Groups</a></li>
            <li role="presentation"><a href="#projects-initiatives" aria-controls="projects-initiatives" role="tab" data-toggle="tab">Initiatives &amp; Updates</a></li>
          </ul>
          </div>

    <div class="tab-content">
    <div role="tabpanel" class="tab-pane" id="projects-initiatives"> 
    
    <? 
    
      // Find all of workinggroup project root projectS page
      $matches = $pages->find("template=working_group_projects");
      // Based on this check for child pages
      $matches = $pages->find("parent=$matches, sort=title");
      
      if(count($matches)) {;
             echo "<h3>Working Group Initiatives &amp; Updates</h3>
             <ul class='list-icon icon-arrow-right padding-left-none'>";
                foreach($matches as $child) {
                    if($child->summary) {
		                  $summary = $sanitizer->text($child->summary);
                    } else {
		                  $summary = $sanitizer->text($child->body); 
                    }
                    if(!$summary) {
                      $summary = "Additional information about ".$child->title." available by clicking the link above.";
                    }
		                $summary = (strlen($summary) > 255) ? substr($summary,0,250).'...' : $summary;
                   echo "<li class='padding-bottom-md'>
                          <em class='text-sm text-muted pull-right hidden-xs hidden-sm'>
                              <a class='text-muted italic' href='{$child->parent->parent->url}'>
                                {$child->parent->parent->title}
                              </a>
                          </em>
                          <a class='' href='{$child->url}'><strong>{$child->title}</strong></a>
                   
                   <div class='text-sm border-top'>{$summary}</div></li>";
                }			
              echo "</ul></li>";
           }
    ?>
    </div>
      <div role="tabpanel" class="tab-pane active" id="working-groups">   

  <?
  $matches = $pages->get("3786")->children("sort=sort");
  foreach($matches as $match) {
    echo "<div class='row clearfix'>
            <div class='col-sm-12'>
              <h5 class='text-muted border-bottom margin-top-lg margin-bottom-lg'>{$match->title}</h5>
            </div>
          </div>";
    ?>
    
    
    <?
  $submatches = $page->children->find("template=working_group, working_group_type=$match->id, sort=alphabetical");
  unset($i);
  foreach($submatches as $submatch) {
      $i++; // Increments the key
      $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
      
      if($submatch->image_icon) {
					$img_sized = $submatch->image_icon->size(200,200)->url;
         $tempimg = "<img src='{$img_sized}' class='img img-responsive img-rounded' alt='{$submatch->title}'>";
				} else {
         $tempimg = "";
				} 
      
      echo "<div class='col-sm-12 col-md-6 padding-left-none margin-bottom-md $temprow'>
      
        <div class='col-sm-2 col-xs-1 padding-right-none'><a href='{$submatch->url}' class='text-black' title='{$submatch->title}'>$tempimg</a></div>
      <div class='col-sm-10 col-xs-11'>
      <h4 class='margin-none'><a href='{$submatch->url}' class='text-black' title='{$submatch->title}'>{$submatch->title}</a></h4><div class='row padding-bottom-sm'>";
      if($submatch->summary) { echo "<div class='col-sm-12 text-muted text-sm'>{$submatch->summary} <a href='{$match->url}' title='{$submatch->title}'>Learn more</a>"; }
      if(count($submatch->children)) { 
        echo "<ul class='list-inline padding-left-xs'>
          ";
        foreach($submatch->children as $subsubmatch) {
          $tempval .= "<a class='text-muted  text-xs' href='{$subsubmatch->url}' title='{$subsubmatch->title}'>{$subsubmatch->title}</a> <span class='text-muted  text-xs'>|</span> ";
          }
          $tempval = rtrim($tempval, "| ");  // Strips the comma and space from the end
          echo $tempval;
        echo "</ul>"; 
        unset($temprow);
      }
    
    unset($tempval);
    unset($temprow);
    
    echo "</div></div></div></div>";
   }
  ?>
    
    
  <?
  echo "<div class='col-sm-12'></div>";
  }
  ?>
   </div></div>
  
   </div>


<? include("./inc/nav_well.php"); ?>
</div>
<? include("./inc/foot.php"); 

