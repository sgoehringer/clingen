<div class='col-sm-3' id="nav_well">
		<h5>Upcoming Events</h5>
    <ul class='list-unstyled padding-bottom-md'>
      <?php
    $key = 0;
    
            foreach($pages->find("template=event, date_end>=$today, sort=date_end") as $child) { 
			
				include("./inc/event_date_code.php");
				
               echo "<li class='padding-bottom-xs'>
							<a href='{$child->url}' title='{$date_media} - {$child->title}' class='text-black'>{$child->title}</a>
              <div class='text-11px text-muted'>{$date_start}{$date_end}</div>";
						echo "</li>
				"; 
				
			}
    
?> 

		
		
		</ul>
</div>
