
<?php
	$key = 0;
	if($page->repeater_hero->count()) {
		echo "<div class='row padding-top'>";
			foreach($page->repeater_hero as $repeat) {
				if($repeat->repeat_image){ 
					$img 		= $repeat->repeat_image;
					$img_sized	= $img->size($temp_img_size);
					$img_src	= "<img src='{$img_sized->url}' class='img-responsive' alt='{$img_sized->title}' />";
				}
				echo "<div class='{$temp_col_size}'>
						<a class='thumbnail' href='{$repeat->replate_page->url}'>
						  {$img_src}
						  <div class='caption text-center'>
							<h4 class='headingtight'>{$repeat->repeat_label}</h4> 
							<p class='hidden-sm hidden-xs'>{$repeat->repeat_summary}</p>
						  </div>
						</a>
					  </div>
					";
			}
		echo "</div>";
	}
?> 