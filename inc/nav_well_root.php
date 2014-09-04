<div class='col-sm-2 col-sm-offset-1 padding-left-md padding-top-sm margin-top-xl text-sm border-left' id="nav_well">

            <?php
	

			 
			function atreeMenu(Page $page = null, Page $rootPage = null) {

						if(is_null($page)) $page = wire('page');
						if(is_null($rootPage)) $rootPage = wire('pages')->get('/');
						
						$out = "\n<ul class='list-icon icon-arrow-right padding-left-none'>";
				
						$parents = $page->parents;
				
						foreach($rootPage->children("limit=10") as $child) {
								$class = '';
								$s = '';
				
								//if($child->numChildren && $parents->has($child)) {
								//	$class = 'active nav_children';
								//		$s = str_replace("\n", "\n\t\t", treeMenu($page, $child));
								//}
								//if($child === $page) {
								//	$class = "active nav_children";
								//		if($page->numChildren) $s = str_replace("\n", "\n\t\t", treeMenu($page, $page));
								//}
				
								if($class) $class = " $class";
								$out .= "\n\t<li class='$class'>\n\t\t<a class='$class' href='{$child->url}'>{$child->title}</a>$s\n\t</li>";
						}
				
						$out .= "\n</ul>";
						return $out;
				}
			
				// no params: print out tree menu from current page to root parent
				//echo treeMenu(); 
				
				// or specify what you want it to display
				echo atreeMenu($page, $page->rootParent);			
			
			?>  
            
            
        
        
    </div>