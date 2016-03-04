
<?php
	$key = 0;
	if($page->image_hero) {
		echo "<div class='row padding-top'>";
				if($page->image_hero){ 
					$img 		= $page->image_hero;
					$img_sized	= $img->size(2000, 500);
					$img_src	= "<img src='{$img_sized->url}' class='img-responsive' alt='{$img_sized->title}' />";
				}
				echo "<div>
						  {$img_src}
						  <div class='caption text-center bg-black-80 hero-wg' style=''>
							<h2 class='headingtight'>{$page->title}</h2> 
							<h4 class='hidden-sm hidden-xs'>{$page->summary}</h4>
						  </div>
					  </div>
					";
		echo "</div>";
	}
?> 