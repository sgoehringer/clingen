<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>

<div class="row">
	<div class="col-sm-12">
	<div class="content-space content-border">

	<div class='row padding-sm'>
  <div class='thumbnail padding-bottom-md'>
  <div class='col-sm-6 text-center '>
  <h2 class='padding-bottom-none margin-bottom-xs'>ClinGen has over <u><? echo $pages->find("template=partner")->count; ?></u>  Supporters</h2>
  <div class='margin-bottom-xs text-sm text-muted'>We proud of our international support by instititions, corporations, &amp; hospitals. </div><a href='<?=$pages->get(1114)->url ?>' class='btn btn-xs text-white text-xs btn-primary'>How to participate</a>
  </div>
  <div class='col-sm-6 text-center '>
  <h2 class='padding-bottom-none margin-bottom-none'>ClinVar Submitters</h2>
  <? 
    $tempvar = round(($pages->get(1382)->var / $pages->get(1381)->var)*100);
    ?>
  <div class="progress margin-bottom-sm">
  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?=$pages->get(1382)->var ?>" aria-valuemin="0" aria-valuemax="<?=$pages->get(1381)->var ?>" style="width: <?=$tempvar ?>%">
    <?=$tempvar ?>% TO FIRST TARGET GOAL
  </div>
</div> 
  <div class='text-sm text-muted'><strong>Over <?=$pages->get(1382)->var ?> variants</strong> with clinical assertions have been shared by ClinGen supporters.</div>
</div>
  <div class='clearfix'></div>
  </div>
  
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJGzT6wKTtC4zVcwm6m7VsrByVsFiOwl8&sensor=false"></script>
        
        <script type="text/javascript">
      
	  
	  
	  

function initialize() {
  var mapOptions = {
    zoom: 2,
    center: new google.maps.LatLng(11.505989, -51.608643),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'),
                                mapOptions);

  setMarkers(map, centers);
}

/**
 * Data for the markers consisting of a name, a LatLng and a zIndex for
 * the order in which these markers should display on top of each
 * other.
 */
var centers = [


<?php 

		$markers = $pages->find("template=partner, mapmarker!='', sort=title");
		$key = "0";
		$key++;
		foreach($markers as $item) {
      foreach($item->relate_supporter_type as $temp) {
        $relate_supporter_type = "{$temp->id}";
      } 
      if($relate_supporter_type == "1449") {
          $relate_supporter_type = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
        } elseif($relate_supporter_type == "1450") {
          $relate_supporter_type = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
        } elseif($relate_supporter_type == "14491450") {
          $relate_supporter_type = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
        } elseif($relate_supporter_type == "14501449") {
          $relate_supporter_type = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
        } elseif($relate_supporter_type == "2059") {
          $relate_supporter_type = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        } else {
          $relate_supporter_type = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
        }
			if(!$item->mapmarker->lat) continue; 
			if($item->mapmarker->lat == "0.000000") continue; 
			echo "['{$item->title}', {$item->mapmarker->lat}, {$item->mapmarker->lng}, {$key}, '{$item->url}', '{$relate_supporter_type}'],";
      unset($relate_supporter_type); 
		}

		?>
];

function setMarkers(map, locations) {
  // Add markers to the map

  // Marker sizes are expressed as a Size of X,Y
  // where the origin of the image (0,0) is located
  // in the top left of the image.

  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.
  /*var shadow = {
    url: '/site/templates/assets/brand-img/map_pin.png',
    // The shadow image is larger in the horizontal dimension
    // while the position and offset are the same as for the main image.
    size: new google.maps.Size(37, 32),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(0, 55)
  };*/
  // Shapes define the clickable region of the icon.
  // The type defines an HTML &lt;area&gt; element 'poly' which
  // traces out a polygon as a series of X,Y points. The final
  // coordinate closes the poly by connecting to the first
  // coordinate.
  //var shape = {
   //   coord: [37,0,57,11,53,32,53,56,23,57,17,27,15,7],
  //    type: 'poly'
  //};
  for (var i = 0; i < locations.length; i++) {
    var center = locations[i];
    var myLatLng = new google.maps.LatLng(center[1], center[2]);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        //shadow: shadow,
        icon: center[5],
        //shape: shape,
        title: center[0],
        zIndex: center[3]
		//url: center[4]
    });
  //google.maps.event.addListener(marker, 'click', function() {
    //window.location.href = this.url;
//});
  }
}

google.maps.event.addDomListener(window, 'load', initialize);


    </script>
  <div id="map-canvas" class='row' style='height:450px;'></div>
  
  <div class='padding-top-sm'>
  <span class="pull-right margin-left-md label label-danger"><span class='glyphicon glyphicon-map-marker'></span> PI Institutions</span>
  <span class="pull-right margin-left-md label label-primary"><span class='glyphicon glyphicon-map-marker'></span> Submitter</span>
  <span class="pull-right margin-left-md label label-success"><span class='glyphicon glyphicon-map-marker'></span> Supporter</span>
  </div>
  <?
	/*
	$items = $pages->find("template=partner, mapmarker!='', sort=title"); 
	$mapmarker = $modules->get('MarkupGoogleMap'); 
	echo $mapmarker->render($items, 'mapmarker'); 
	*/
	?>
  
  <div class='clearfix'></div>
  <? if ($page->body) {echo "<hr />"; } ?>
  <span class='bodytext'><?=$page->body; ?> </span>
  <hr />
  <ul class="list-icon icon-ok">
  <?
  // The following finds all of the locations this staff person is tied with, loops through and prints.
  $matches = $pages->find("template=partner, sort=title");
  foreach($matches as $match) {
    foreach($match->relate_supporter_type as $temp) {
    $relate_supporter_type .= "{$temp->id}
                 ";
    }
    $tempval .= "<li class='col-sm-6 padding-bottom-xs childnav support_type_{$relate_supporter_type}'>
                  {$match->title}
                 </li>
                 ";
                 //<a href='{$match->url}'>{$match->title}</a>
    unset($relate_supporter_type);
    unset($temp);
  }
   if($tempval) {
    echo $tempval;
   
   
   }
  ?> </ul> 
  </div>
  
    
  
  </div>
</div>
	

<? include("./inc/foot.php"); 

