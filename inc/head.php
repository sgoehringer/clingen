<?php
 //include("./inc/mobile_detect.php"); 
 if($session->referrer_id) $page->referrer_page = $pages->get($session->referrer_id); 
	$session->referrer_id = $page->id; 
 $sitename = "ClinGen | Clinical Genome Resource";
 $sitenameclean = "ClinGen | Clinical Genome Resource";
 $sitename_short = "ClinGen";
 $sitename_long = "ClinGen";
 $today = strtotime(date('Y-m-d')); // Today's Date
 $shareUrl = $page->httpUrl; // The complete URL for the Page
 $shareTitle = $page->title; // The title of the page
 $termonologyService = "https://terminologyservice.clinicalgenome.org/scigraph/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $page->title ?> - <? if($page->name != "home") { echo $sitename; } else { echo $sitename;} ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="><?php echo $page->title ?><?php echo $page->summary; ?> - <?php echo $sitename_long; ?>">
<meta name="keywords" content="><?php echo $page->title ?>, <?php echo $page->soe_keywords; ?>, <?php echo $sitename_short; ?>, <?php echo $sitename_long; ?>">

<link href="/site/templates/assets/css-v2/bootstrap.css" rel="stylesheet">
<link href="/site/templates/assets/css-v2/brand.css" rel="stylesheet">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]> 
      <script src="<?php echo $config->urls->templates?>assets/js/respond.min.js"></script>
      <script src="<?php echo $config->urls->templates?>assets/js/html5shiv.js"></script>
    <![endif]-->
<link rel="shortcut icon" href="<?php echo $config->urls->templates?>assets/ico/favicon.ico">
<link rel="touch-icon-precomposed" sizes="144x144" href="<?php echo $config->urls->templates?>assets/ico/touch-icon-144-precomposed.png"><link rel="touch-icon-precomposed" sizes="114x114" href="<?php echo $config->urls->templates?>assets/ico/touch-icon-114-precomposed.png"><link rel="touch-icon-precomposed" sizes="72x72" href="<?php echo $config->urls->templates?>assets/ico/touch-icon-72-precomposed.png"><link rel="apple-touch-icon-precomposed" href="<?php echo $config->urls->templates?>assets/ico/touch-icon-57-precomposed.png">

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49947422-1', 'auto');    //7
  ga('send', 'pageview');

</script>
<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?sensor=false'></script>

<?
  if($page->template->name == "resource_web_list_search") {
    include("./assets/resource_web_list_search_assets/inc/block-head.php"); 
  }
?>

</head>

<body class="<?=$page->name; ?>" id="i<?=$page->id; ?>">
<? // The following provides the primary navigation area used throughout the site // ?>
<? // The following provides the very top navigation area // ?>
<div class="" id="header">
	<div class="background-trans-white navbar navbar-fixed-top margin-none padding-none" role="navigation">
  
  <div class=" hidden-print padding-bottom-sm padding-top-sm" id="">
	<div class="container hidden-xs container-clear">
  <div class="pull-right padding-bottom-sm"> 
			<div class="pull-right padding-left-md btn-group btn-group-hover">
				<a aria-expanded="false" href="<? echo $pages->get(2743)->url; ?>" title="<? echo $sitename_long ?> <?=$pages->get(2743)->title?>" class="text-blue text-sm" data-hover='dropdown' ><i class='glyphicon glyphicon-user'></i> <?=$pages->get(2743)->title?></a> 
				<ul class="dropdown-menu hidden-sm hidden-xs" style="z-index:1001">
				   <?
				   $children = $pages->get(1119)->children;
				   foreach($children as $child) {
				     echo "<li class=''><a href='{$child->url}' title='{$child->title}'>{$child->title}</a></li>";
				   }
				   ?>
				  </ul>
			</div>
			<div class="pull-right padding-left-md"><a  href="<? echo $pages->get(3792)->url; ?>" title="<?=$pages->get(3792)->title?>" class="text-blue text-sm"><i class='glyphicon glyphicon-book'></i> <?=$pages->get(3792)->title?></a> </div>
			<div class="pull-right padding-left-md"><a  href="<? echo $pages->get(3831)->url; ?>" title="<? echo $sitename_long ?> <?=$pages->get(3831)->title?>" class="text-blue text-sm"><i class='glyphicon glyphicon-check'></i> <?=$pages->get(3831)->title?></a> </div>
			<div class="pull-right padding-left-md"><a  href="<? echo $pages->get(1491)->url; ?>" title="<? echo $sitename_long ?> <?=$pages->get(1491)->title?>" class="text-blue text-sm"><i class='glyphicon glyphicon-send'></i> <?=$pages->get(1491)->title?></a> </div>
		<!-- 
		<form class="col-sm-3 pull-right" role="form" action='<?php echo $config->urls->root?>references-and-policies/search/' method='get'>
			<div class="input-group ">
    		<input type="text" class="form-control lblue text-right input-xs" id="inputSearch" name="q" value='<?php echo htmlentities($input->whitelist('q'), ENT_QUOTES, 'UTF-8'); ?>' placeholder="Search">
  				<span class="input-group-btn">
   					<button type="submit" class="btn btn-xs btn-link"><span class="glyphicon glyphicon-search lblue"></span></button>
   				</span>
			</div>
		</form>
		--> 
	</div> 
</div>
  <div class="background-white navbar navbar-default navbar-static-top" role="navigation">
		<div class="container">
    <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
<a class="navbar-brand" href="/" title="<?=$sitenameclean ?>"><span>
			<?=$sitename_long?>
			</span></a>         </div>
			        <div class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<?php
				// Create the top navigation list by listing the children of the homepage. 
				// If the section we are in is the current (identified by $page->rootParent)
				// then note it with <a class='on'> so we can style it differently in our CSS. 
				// In this case we also want the homepage to be part of our top navigation, 
				// so we prepend it to the pages we cycle through:		
				$children = $pages->get("/")->children;
	      $key = 1;
				// $children->prepend($homepage); 
				foreach($children as $child) {
					$class = $child === $page->rootParent ? "active" : '';
					$tempid = $child->id;
         $tempkey = "nav_id_".$key++;
					echo "
						<li class='$class $classhidden $tempkey'>
							<a class='$class dropdown-toggle' data-hover='dropdown' href='{$child->url}' title='{$child->seotitle}' >{$child->title}</a>";
							$submatches = $pages->find("parent=$tempid");
             if(count($submatches)) {
               if($child == "1035") {
                  $submatches = $pages->get("1035")->children();
                  echo "<ul class='dropdown-menu hidden-xs  dropdown-menu-right' style='width:500px; left:-200px;'>";
                    foreach($submatches as $submatch) {
                      $i++; // Increments the key
                      $temprow = ($i % 4 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
                        if($submatch->image_icon) {
                          $img_sized = $submatch->image_icon->size(200,200)->url;
                         $tempimg = "<img src='{$img_sized}' class='img img-responsive img-rounded' alt='{$submatch->title}'>";
                        } else {
                         $tempimg = "";
                        } 
                        echo "<li class='col-sm-3 padding-sm $temprow'><a href='{$submatch->url}' class='text-muted' title='{$submatch->title}'>$tempimg <div class='text-xs text-center'>{$submatch->title}<div></a></li>";
                    }
                    unset($i);
                  echo "</ul>";
               } else if($child == "1001") {
                  $submatches = $pages->get("1001")->children("sort=title");
                  echo "<ul class='dropdown-menu hidden-xs  dropdown-menu-right' style='width:500px; left:-200px;'>";
                    foreach($submatches as $submatch) {
                      $i++; // Increments the key
                      $temprow = ($i % 4 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
                        if($submatch->image_icon) {
                          $img_sized = $submatch->image_icon->size(200,200)->url;
                         $tempimg = "<img src='{$img_sized}' class='img img-responsive img-rounded' alt='{$submatch->title}'>";
                        } else {
                         $tempimg = "";
                        } 
                        echo "<li class='col-sm-3 padding-sm $temprow'><a href='{$submatch->url}' class='text-muted' title='{$submatch->title}'>$tempimg <div class='text-xs text-center'>{$submatch->title}<div></a></li>";
                    }
                    unset($i);
                  echo "</ul>";
               } else if($child == "1001") {
                  $submatches = $pages->get("1001")->children("sort=sort");
                  echo "<ul class='dropdown-menu hidden-xs  dropdown-menu-right' style='width:500px; left:-200px;'>";
                    foreach($submatches as $submatch) {
                      $i++; // Increments the key
                      $temprow = ($i % 4 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
                        if($submatch->image_icon) {
                          $img_sized = $submatch->image_icon->size(200,200)->url;
                         $tempimg = "<img src='{$img_sized}' class='img img-responsive img-rounded' alt='{$submatch->title}'>";
                        } else {
                         $tempimg = "";
                        } 
                        echo "<li class='col-sm-3 padding-sm $temprow'><a href='{$submatch->url}' class='text-muted' title='{$submatch->title}'>$tempimg <div class='text-xs text-center'>{$submatch->title}<div></a></li>";
                    }
                    unset($i);
                  echo "</ul>";
               }  else if($child == "1040") {
                  $submatches = $pages->get("1040")->children("sort=sort");
                  echo "<ul class='dropdown-menu hidden-xs  dropdown-menu-right' style='width:500px; left:-375px;'>";
                    foreach($submatches as $submatch) {
                      $i++; // Increments the key
                      $temprow = ($i % 4 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
                        if($submatch->image_icon) {
                          $img_sized = $submatch->image_icon->size(200,200)->url;
                         $tempimg = "<img src='{$img_sized}' class='img img-responsive img-rounded' alt='{$submatch->title}'>";
                        } else {
                         $tempimg = "";
                        } 
                        echo "<li class='col-sm-3 padding-sm $temprow'><a href='{$submatch->url}' class='text-muted' title='{$submatch->title}'>$tempimg <div class='text-xs text-center'>{$submatch->title}<div></a></li>";
                    }
                    unset($i);
                  echo "</ul>";
               } else if($child == "2796") {
                  //$submatches = $pages->get("2983")->children("clingen_tool=1");
                  $submatches = $pages->get("2983")->children("template=resource_list_item, sort=title");
                  echo "<ul class='dropdown-menu hidden-xs  dropdown-menu-right' style='width:500px; left:-200px; padding-bottom:0px;'>";
                    foreach($submatches as $submatch) {
                      $i++; // Increments the key
                      $temprow = ($i % 4 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
                        if($submatch->image) {
                          $img_sized = $submatch->image->size(200,200)->url;
                         $tempimg = "<img src='{$img_sized}' class='img img-responsive img-circle' alt='{$submatch->title}'>";
                        } else {
                         $tempimg = "";
                        } 
                        echo "<li class='col-sm-3 padding-sm $temprow'><a href='{$submatch->url_website}' class='text-muted' title='{$submatch->title}'>$tempimg <div class='text-xs text-center'>{$submatch->title}<div></a></li>";
                    }
                    unset($i);
                    echo "<li class='col-sm-12 background-trans-blue'><a href='/clingen-tools-and-work-products/' class='text-center padding-sm text-white' title='More Tools &amp; Resources'>Additional ClinGen Tools, Documentation, &amp; Resources</a></li>";
                  echo "</ul>";
               } else {
                echo "<ul class='dropdown-menu dropdown-menu-right'>";
                  foreach($submatches as $submatch) {
                      echo "<li class=''><a href='{$submatch->url}' title='{$submatch->title}'>{$submatch->title}</a></li>";
                  }
                echo "</ul>";
               }
              }
						echo "</li>";
					}
			?>
			<li class="<?=$tempkey ?> visible-xs">
		      		<a href="<? echo $pages->get(2743)->url; ?>" title="<? echo $sitename_long ?> <?=$pages->get(2743)->title?>" class="text-blue" ><?=$pages->get(2743)->title?></a>
		      	</li>
			</ul>
		</div></div></div>
	</div> 
</div>
 
 
<?  if($page->template->name == "home") {
		$temp_carousel_arrows			= true;
		$temp_carousel_indicators		= true;
		$temp_carousel_id				= "heroCarousel";
		include("./inc/hero_jumbo.php");
	} elseif($page->template->name == "working_group") { 
		$temp_carousel_arrows			= true;
		$temp_carousel_indicators		= true;
		$temp_carousel_id				= "headerCarousel";
		include("./inc/hero_wg2.php"); 
	} else {
		$temp_carousel_arrows			= true;
		$temp_carousel_indicators		= true;
		$temp_carousel_id				= "headerCarousel";
		include("./inc/hero_header.php"); 
	}
?>
<div id="content" class="container padding-top-md padding-bottom-md"> 
<? if($page->id != 1) { // If the home page don't show the hero info ?>
<div class="" id="breadcrumb" >
		<ol class="breadcrumb text-muted text-sm background-white padding-none margin-none">
			<?php
            // Create breadcrumb navigation by cycling through the current $page's
            // parents in order, linking to each:
            foreach($page->parents as $parent) {
				$string = $parent->title;
				$string = (strlen($string) > 45) ? substr($string,0,42).'...' : $string;
                echo "<li class=''><a href='{$parent->url}' class='text-muted text-sm' title='{$parent->seotitle}'>{$string}</a></li>";
            }
				$string = $page->title;
				$string = (strlen($string) > 45) ? substr($string,0,42).'...' : $string;
                echo "<li class=''><a href='{$page->url}' class='text-muted text-sm' title='{$page->seotitle}'>{$string}</a></li>";
        ?>
		</ol>
</div>
<? } ?>
