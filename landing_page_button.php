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
 
 $image = $page->image;
		if ($image) {
			$img_sized = $image->size(1200);
			$img = "<img src='{$img_sized->url}' class='img-responsive' alt='{$page->image->description}'>";
		}
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

<link href="<?php echo $config->urls->templates?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $config->urls->templates?>assets/css/brand.css" rel="stylesheet">
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

</head>

  <body>

    <!-- Begin page content -->
    <div class="container">
      <div class="col-sm-6 col-sm-offset-3 bodytext"> 
        <?=$img?>  
        <?=$page->body?> 
        <? if($page->url_website) { ?> 
        <div class='text-center padding-bottom-md'>
        <a href="<?=$page->url_website?>" class='btn btn-primary btn-lg'><?=$page->label?></a> 
        </div>
        <? } ?>
        <?=$page->body_secondary?>
        
        <div class='text-center padding-bottom-md padding-top-md'>
        <a href="https://clinicalgenome.org/" target='_blank' class='btn btn-default btn'>About ClinGen</a> 
        </div>
         <div class='text-center text-sm text-muted padding-bottom-sm margin-top-xs'>
        
        <hr />
        © <? echo date("Y"); ?> <a href="/" title="<?=$sitename_long?>" class=""><?=$sitename_long?></a> - All rights reserved</div>
      </div>
    </div>

    


     <script src="<?php echo $config->urls->templates?>assets/js/jquery.js"></script>
	<script src="<?php echo $config->urls->templates?>assets/js/bootstrap.min.js"></script>
  </body>
</html>
