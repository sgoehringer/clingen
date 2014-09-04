<?


if($child->relate_publication) {
	$image = $child->relate_publication->image;
	$img_sized = $image->size(200);
	$placeimage = "
		<div class='pull-right col-sm-3  hidden-xs padding-bottom-none img-content-area'>
			<a href='{$child->url}' title='{$date_media} - {$child->title}'>
				<img src='{$img_sized->url}' class='img-responsive {$tempcss}' alt='{$child->relate_publication->title}'>
			</a>
		</div>" ;
}

// Simply place $placeimage where you want on the included page
	