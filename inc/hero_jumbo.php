
<?php
	if($page->repeat_hero) {
		echo "
			<div id='{$temp_carousel_id}' class='carousel slide' data-ride='carousel'>	
			";
			
			// The following loops through to create the indicators dots
			if($temp_carousel_indicators == true) {
			if($page->repeat_hero->count() > 1) {  // checks to see if more than 1 are available
			$key = 0;
				echo "<ol class='carousel-indicators hidden-xs hidden-sm' style='bottom: 0;'>";
					foreach($page->repeat_hero as $repeat) {
					$tempkey = $key++;								// Increments the key to know the number of items
					$class = ($tempkey == '0' ? "active" : "");	// Makes sure the first item is set to active
						echo "<li data-target='#{$temp_carousel_id}' data-slide-to='{$tempkey}' class='{$class}'></li>";
					}
				echo "</ol>";
			}
			}
			// The following loops through images and text
			echo "<div class='carousel-inner background-blue background-blue-img'>";
			$key = 0;
				foreach($page->repeat_hero as $repeat) {
					if($repeat->relate_page){ 
						$link_src_open	= " <a class='text-white text-underline' href='{$repeat->relate_page->url}'>";
						$link_text	= " Learn more &raquo;";
						$link_src_close	= "</a>";
					}
					if($repeat->image){ 
						$img_sized	= $repeat->image->size(1500,600);
						$img_src	= "<a class='text-white text-underline' href='{$repeat->relate_page->url}'><img src='{$img_sized->url}' class='img-responsive margin-left-auto margin-right-auto' alt='{$repeat->repeat_label}' /></a>";
					}
					if($repeat->summary){ 
						$summary_src	= "<span class='hidden-xs hidden-sm'>{$repeat->summary}
										{$link_src_open}{$link_text}{$link_src_close}<p></p> 	</span>";
					}
					if($repeat->label){ 
						$label_src	= "<h2 class='margin-top-none'>{$repeat->label}</h2>";
					}
          
					if($summary_src || $label_src){ 
						$caption_src_open	= "<div class='container'>
           					<div class='carousel-caption carousel-caption-blue padding-bottom-sm'>
									<div class='carousel-caption-text text-center padding-bottom-none'>";
						$caption_src_close	= "</div>	</div></div>";
					}
					$tempkey = $key++;	
					$class = ($tempkey == '0' ? "active" : "");	// Makes sure the first item is set to active
					echo "<div class='item {$class} '>
							  {$img_src}
							  $caption_src_open
										$label_src
                  $summary_src
									$caption_src_close
							</div>
						";
        unset($caption_src_open); 
        unset($label_src);
        unset($summary_src);
        unset($caption_src_close);
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
	}
?> 
