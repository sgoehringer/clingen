<?

if($child->image) {
	$image = $child->image;
	$img_sized = $image->size(300, 200);
	$placeimage = "
		<div class='pull-right col-sm-3 hidden-xs padding-bottom-none img-content-area'>
			<a href='{$child->url}' title='{$date_media} - {$child->title}'>
				<img src='{$img_sized->url}' class='img-responsive thumbnail {$tempcss}' alt='{$child->title}'>
			</a>
		</div>" ;
}

// Simply place $placeimage where you want on the included page
	