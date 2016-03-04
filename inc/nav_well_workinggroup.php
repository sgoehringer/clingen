<?

$wg_template = $page->template->name;
if($wg_template == "working_group") {
  $wg_id  = $page->id;
} else {
  $wg_id  = $page->parents("template=working_group");
}
$wg_subgroups      = $pages->get("has_parent={$wg_id}, template=working_group_subgroups");
$wg_projects       = $pages->get("has_parent={$wg_id}, template=working_group_projects");
$wg_taskteam       = $pages->get("has_parent={$wg_id}, template=working_group_taskteams");
$wg                = $pages->get("{$wg_id}");

?>



<div class='col-sm-2 col-sm-offset-1 padding-left-md padding-top-sm margin-top-xl text-sm border-left' id="nav_well">
    	
      
      <ul class='list-icon icon-arrow-right padding-left-none'>
				<li class='margin-bottom-sm text-muted'><a href='<?=$wg->url ?>' class='text-muted'><?=$wg->title ?></a></li>
        
       <?php
           if(count($wg_subgroups)) {;
             echo "<li class=' margin-bottom-sm text-muted'><div class=' border-bottom'> Sub Groups</div>
                    <ul class='list-icon icon-arrow-right padding-left-none'>";
                foreach($wg_subgroups->children as $child) {
                   echo "<li class=' text-muted text-sm'><a class=' text-muted' href='{$child->url}'>{$child->title}</a></li>";
                }			
              echo "</ul></li>";
           }
           if(count($wg_taskteam )) {;
             echo "<li class=' margin-bottom-sm text-muted'><div class=' border-bottom'> Task Teams</div>
                    <ul class='list-icon icon-arrow-right padding-left-none'>";
                foreach($wg_taskteam ->children as $child) {
                   echo "<li class=' text-muted text-sm'><a class=' text-muted' href='{$child->url}'>{$child->title}</a></li>";
                }			
              echo "</ul></li>";
           }
           if(count($wg_projects)) {;
             echo "<li class=' margin-bottom-sm text-muted'><div class=' border-bottom'> Initiatives &amp; Updates</div>
                    <ul class='list-icon icon-arrow-right padding-left-none'>";
                foreach($wg_projects->children as $child) {
                   echo "<li class=' text-muted text-sm'><a class=' text-muted' href='{$child->url}'>{$child->title}</a></li>";
                }			
              echo "</ul></li>";
           }
			?>  
            
            
            
           </ul> 
        
      
        
    </div>