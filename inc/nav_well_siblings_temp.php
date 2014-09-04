<div class='col-sm-3 col-lg-2 padding-left-md padding-right-none padding-top-sm' id="nav_well">
    	
            <?php
						
						echo "<ul class='list-unstyled padding-bottom-none text-sm'>";
				
				 
						foreach($page->siblings as $child) {
								$class = 'padding-top-xs padding-bottom-xs padding-left-none';
								$s = '';
								if($class) $class = " $class";
								$out .= "<li class=' $class'>\n\t\t<a class='$class' href='{$child->url}'><span class='glyphicon glyphicon-chevron-right'></span>
 {$child->title}</a>$s\n\t</li>";
						}
				    echo $out;
						echo"</ul>";
						
			?>  
            
            
        
      
        
    </div>