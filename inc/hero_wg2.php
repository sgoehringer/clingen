
<?php
	//if($page->image_hero) {
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
				
					if($page->image_hero){ 
						$img_sized	= $page->image_hero->size(1500,400);
						$img_src	= "<img src='{$img_sized->url}' class='img-responsive margin-left-auto margin-right-auto' alt='{$repeat->repeat_label}' />";
					} else {
						$img_sized	= $pages->get("1")->repeat_hero->first()->image->size(1500,400);
						$img_src	= "<img src='{$img_sized->url}' class='img-responsive margin-left-auto margin-right-auto' alt='{$repeat->repeat_label}' />";
       }
					
					$tempkey = $key++;	
					$class = ($tempkey == '0' ? "active" : "");	// Makes sure the first item is set to active
					echo "<div class='item {$class} '>
							  {$img_src}
               <div class='container'>
           					<div class='carousel-caption bg-black-80 hero-wg padding-bottom-sm'>
									<div class='carousel-caption-text text-center padding-bottom-none'>
							<h2 class='headingtight'>{$page->title}</h2> 
							<h4 class='hidden-sm hidden-xs'>{$page->summary}</h4>
						  </div></div></div>
							</div>
						";
        
			echo "</div>";
			
		echo "</div>";
	//}
?> 
