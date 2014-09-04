
<?php
	if($page->repeat_hero) {
		echo "
			<div id='{$temp_carousel_id}' class='carousel slide' data-ride='carousel'>	
			";
			
			// The following loops through to create the indicators dots
			if($temp_carousel_indicators == true) {
			if($page->repeat_hero->count() > 1) {  // checks to see if more than 1 are available
			$key = 0;
				echo "<ol class='carousel-indicators'>";
					foreach($page->repeat_hero as $repeat) {
					$tempkey = $key++;								// Increments the key to know the number of items
					$class = ($tempkey == '0' ? "active" : "");	// Makes sure the first item is set to active
						echo "<li data-target='#homeCarousel' data-slide-to='{$tempkey}' class='{$class}'></li>";
					}
				echo "</ol>";
			}
			}
			// The following loops through images and text
			echo "<div class='carousel-inner'>";
			$key = 0;
				foreach($page->repeat_hero as $repeat) { 
					if($repeat->image){ 
						$img_sized	= $repeat->image->size(1500,500);
						$img_src	= "<img src='{$img_sized->url}' class='img-responsive' alt='{$repeat->repeat_label}' />";
					}
					if($repeat->relate_page){ 
						$link_src	= " <a class='text-white text-underline' href='{$repeat->relate_page->url}'>Learn more &raquo;</a></p>";
					}
					$tempkey = $key++;	
					$class = ($tempkey == '0' ? "active" : "");	// Makes sure the first item is set to active
					echo "<div class='item {$class}'>
							  {$img_src}
							  <div class='container'>
           					<div class='carousel-caption carousel-caption-blue'>
									<div class='carousel-caption-text'>
										<h2>{$repeat->label}</h2>
                  {$repeat->summary}
										{$link_src} 	
									</div>				
							  	</div>
							  </div>
							</div>
						";
				}
			echo "</div>";


			if($temp_carousel_arrows == true) {
			if($page->repeat_hero->count() > 1) {  // checks to see if more than 1 are available
				echo "
					<a class='left carousel-control' href='#{$temp_carousel_id}' data-slide='prev'><span class='glyphicon glyphicon-chevron-left'></span></a>
      				<a class='right carousel-control' href='#{$temp_carousel_id}' data-slide='next'><span class='glyphicon glyphicon-chevron-right'></span></a>
					";
			}
			}
		echo "</div>";
	} else {
    
			echo "<div class='carousel-inner background-blue background-blue-img'>";
			$repeat = $pages->get("1")->repeat_hero->first();
					if($repeat->image){ 
						$img_sized	= $repeat->image->size(1500,225);
						$img_src	= "<img src='{$img_sized->url}' class='img-responsive margin-left-auto margin-right-auto' alt='{$repeat->repeat_label}' />";
					}
					echo "<div class='item active'>
							  {$img_src}
							</div>
						";
			echo "</div>";
	}
    
?> 
