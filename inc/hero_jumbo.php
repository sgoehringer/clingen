
<?php
	if($page->repeat_hero) {
		echo "
			<div id='{$temp_carousel_id}' class='carousel slide' data-ride='carousel'>	
			";
			
			
			// The following loops through images and text
			//echo "<div class='home_message'>
     // <div class='container background-tr text-center'>
      //  <h1>Welcome to ClinGen</h1>
     //   <h2>We are improving genomic interpretation for clinicians, researchers, and patients.</h2>
      //
      //</div></div></div>";
			echo "<div class='carousel-inner carousel-inner-typeahead background-blue background-blue-img'>";
			$key = 0;
				foreach($page->repeat_hero as $repeat) {
					if($repeat->relate_page){ 
						$link_src_open	= " <a class='text-white text-underline' href='{$repeat->relate_page->url}'>";
						$link_text	= " Learn more &raquo;";
						$link_src_close	= "</a>";
					}
					if($repeat->image){ 
						$img_sized	= $repeat->image->size(1500,550);
						$img_src	= "<a class='text-white text-underline' href='{$repeat->relate_page->url}'><img src='{$img_sized->url}' class='img-responsive margin-left-auto margin-right-auto' alt='{$repeat->repeat_label}' /></a>";
					}
					if($repeat->summary){ 
						$summary_src	= "<span class='hidden-xs hidden-sm home-message-text'>{$repeat->summary}
										{$link_src_open}{$link_text}{$link_src_close}<p></p> 	</span>";
					}
					if($repeat->label){ 
						$label_src	= "<h2 class='home-message margin-top-none'>{$repeat->label}</h2>";
					}
          
					if($summary_src || $label_src){ 
						$caption_src_open	= "<div class='container'>
           					<div class='carousel-caption carousel-caption-blue padding-bottom-sm'>
									<div class='carousel-caption-text text-center padding-bottom-none'>";
						$caption_src_close	= "</div>	</div></div>";
					}
					$tempkey = $key++;	
					$class = ($tempkey == '0' ? "active" : "");	// Makes sure the first item is set to active
          if($pages->get(1)->toggle_yes_no == 1) {
					echo "<div class='item {$class} '>
							  {$img_src}
							  $caption_src_open
										$label_src
                  $summary_src
                  
                  <form action='/clingen-tools-and-work-products/' method='get' id='remote' class='col-sm-10 col-sm-offset-1 padding-bottom-md tt-scrollable-dropdown-menu'>
                    <div class=' col-sm-10 padding-right-none'>
                  <input class='typeahead'  name='data_input' type='text' placeholder='Seeking info about a gene or disease? Type it...'>
                  </div>
                  <div class=' col-sm-2 padding-left-none'>
                  <button class='btn btn-default btn-typeahead' type='submit'>Go!</button>
                  </div>
                  <small>ClinGen's search feature will return relevant information from both <a class='text-white' style='text-decoration:underline' href='".$pages->get('3950')->url."'>ClinGen Curated Resources</a> and reputable external sources.</small>
                  
                  <!--
                   <input type='hidden' data-provide='typeahead' name='data_completion' value='' id='data_completion' />
                   <input type='hidden' name='data_labels' value='' id='data_labels' />
                   <input type='hidden' name='data_curie' value='' id='data_curie' />
                   <input type='hidden' name='data_synonyms' value='' id='data_synonyms' />
                   -->
                  </form>
									$caption_src_close
							</div>
						"; } else {
              echo "<div class='item {$class}'>
							  {$img_src}
							  $caption_src_open
										$label_src
                  $summary_src
                  
                  
										{$link_src} 	
									$caption_src_close
							</div>
						";
            }
        unset($caption_src_open); 
        unset($label_src);
        unset($summary_src);
        unset($caption_src_close);
				} 
        
			echo "</div>";
/*
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
      */
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
