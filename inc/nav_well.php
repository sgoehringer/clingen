<div class='col-sm-2 col-sm-offset-1 padding-left-md padding-top-sm margin-top-xl text-sm border-left' id="nav_well">
    	
            <?php
            
           
function treeMenu(Page $page = null, Page $rootPage = null) {

        if(is_null($page)) $page = wire('page');
        if(is_null($rootPage)) $rootPage = wire('pages')->get('/');

        $out = "\n<ul class='{$classchild} list-icon icon-arrow-right padding-left-none'>";

        $parents = $page->parents;

        foreach($rootPage->children as $child) {
                $class = "level-" . (count($child->parents)-1);
                $classchild = "level-" . (count($child->parents)-1);
                $s = '';

                if($child->numChildren && $parents->has($child)) {
                        $class .= " on_parent";
                        $s = str_replace("\n", "\n\t\t", treeMenu($page, $child));

                } else if($child === $page) {
                        $class .= " on_page";
                        if($page->numChildren) $s = str_replace("\n", "\n\t\t", treeMenu($page, $page));
                }
                $currentaction = ($page->id == $child->id ? "activenav" : "");	
                $class = " $class margin-bottom-sm margin-top-sm text-muted";
                $out .= "\n\t<li class='childnav '>\n\t\t<a class='$class $currentaction' href='{$child->url}'>{$child->title}</a>$s\n\t</li>";
        }

        $out .= "\n</ul>";
        return $out;
}

//echo treeMenu(); 
echo treeMenu($page, $page->rootParent);          
			 
			
			
			?>  
            
            
        
      
        
    </div>