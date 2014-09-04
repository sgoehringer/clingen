
     <h2 class="strikethrough hidden-xs"><span>Stay Up To Date</span></h2>
     <div class="col-sm-4">
     
        <div class=" text-center"><a href="https://twitter.com/XXXXXXXXX" target="Twitter"  title="<?= $sitename_long ?> On Twitter"><img src="<?php echo $config->urls->templates?>assets/brand/icons/twitter-sm.png" alt="<?= $sitename_long ?> On Twitter" width="48" height="37" /></a></div>
     <?php
	 /*
            $t = $modules->get('MarkupTwitterFeed');
	$t->limit = 3; // max items to show
	$t->cacheSeconds = 600; // seconds to cache the feed (3600 = 1 hour)*
	$t->dateFormat = 'F j g:i a'; // PHP date() or strftime() format for date field: December 4, 2013 1:17 pm
	$t->dateFormat = 'relative'; // Displays relative time, i.e. "10 minutes ago", etc.
	$t->linkUrls = true; // should URLs be linked?
	$t->showHashTags = true; // show hash tags in the tweets?
	$t->showAtTags = true; // show @user tags in the tweets?
	$t->showDate = 'after'; // show date/time: 'before', 'after', or blank to disable.
	$t->showReplies = false; // show Twitter @replies in timeline?
	$t->showRetweets = false; // show Twitter retweets in timeline? 
	// generated markup options:
	$t->listOpen = "<div class='row MarkupTwitterFeed'>";
	$t->listClose = "</div>";
	$t->listItemOpen = "<h6 class='col-sm-10 col-sm-offset-1 text-center padding-bottom-sm' ><a href='https://twitter.com/XXXXXXXXX' target='Twitter'  title='Twitter'>";
	$t->listItemClose = "</a></h6>";
	$t->listItemDateOpen = " - <span class='date'><em>";
	$t->listItemDateClose = "</em></span>";
	$t->listItemLinkOpen = " <a href='{href}'>";
	$t->listItemLinkClose = "</a>";
     echo $t->render();  
		
		*/
    ?> 
     
         </div>
<div class="col-sm-4">
     <h4 class="text-center padding-bottom-none"><span><a href="<? echo $pages->get(4669)->url; ?>" title="<? echo $pages->get(4669)->title; ?>"><?= $sitename_long ?> Events</a></span></h4>
     
     <? /*
	 echo "<div class='row'>"; 
            foreach($pages->find("template=pr_event, date_media>=$today, sort=date_media, limit=4") as $child) { 
				$date_media = date("M j, Y", $child->date_media); // Formating the date correctly
				
               echo "
			   
			   <h6 class='col-sm-10 col-sm-offset-1 text-center padding-bottom' ><a href='{$child->url}' title='{$date_media} - {$child->title}'>
						<strong>{$date_media}</strong> <br />{$child->title}</a></h6>
				"; 
			}
			echo "</div>";
			*/
	 ?>
     </div>
     <div class="col-sm-4">
     <div class=" text-center"><a href="https://facebook.com/pages/XXXXXXX/XXXXXXX" target="Facebook" title="Like <?= $sitename_long ?> on Facebook"><img src="<?php echo $config->urls->templates?>assets/brand/icons/facebook-sm.png" width="48" height="37" alt="Like <?= $sitename_long ?> on Facebook" /></a>
	 
	 
	 <? require("./inc/facebook-sdk/facebook.php"); 
	 
	 /*
		$app_id = "477651725673832";
		$app_secret = "fbb21ea2345252eb66eef79ccf576060";
		
		$facebook = new Facebook(array(
				'appId' => $app_id,
				'secret' => $app_secret,
				'cookie' => true
		));
		
		if(is_null($facebook->getUser()))
		{
				header("Location:{$facebook->getLoginUrl(array('req_perms' => 'user_status,publish_stream,user_photos'))}");
				exit;
		}
		
		
		
		
		//$feed = $facebook->api('/XXXXXXXX/feed');
		//var_dump($feed); 
		$msgkey = "0"; // sets the key to zero
		foreach($feed['data'] as $status)
		{	
			$msg = $status["message"];  //  Creates a message var
			$date = $status["updated_time"];   //  Creates a date var
			$newDate = date("M d Y", strtotime($date));  // Converts the time format to readable format
			$msgkeyval = $msgkey++; // increments the key
			$string = $msg;
			$string = (strlen($string) > 120) ? substr($string,0,112).'...' : $string;
			if($msgkeyval < 5 && $msg) {  // this checks to see if a message exists
				echo "<h6><a href='https://facebook.com/pages/XXXXXXX/XXXXXXX' target='Facebook' title='Like the ADMI on Facebook'>" . $string . " - <span class='date'><em>" . $newDate . "</em></span></a></h6>";
			}
		}
		*/
		
		?>
   
	 
	 
	 
	 
	 </div>
     </div>