<div class='col-sm-3 padding-left-none padding-top-sm' id="nav_well">
    	
            <?php
						
						echo "<ul class='list-icon icon-arrow-right padding-left-none'>";
				
				 
						foreach($page->children as $child) {
								$class = 'margin-bottom-sm text-muted';
								$s = '';
								if($class) $class = " $class";
								$out .= "<li class=' $class'>\n\t\t<a class='$class' href='{$child->url}'>
 {$child->title}</a>$s\n\t</li>";
						}
				    echo $out;
						echo"</ul>";
						
			?>  
            
            
        
      
        
    </div>