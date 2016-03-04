<?

// The following checks to see if an interaction is in session and if not, creates one.
if(!$session->interaction) {
  $session->interaction_date               = date('U');
  $session->interaction_uuid               = uniqid();
  $session->interaction_ip                 = $_SERVER['REMOTE_ADDR'];
  $session->interaction                    = $session->interaction_date."_".$session->interaction_ip."_".$session->interaction_uuid;
}


//echo $session->interaction;
//echo "hello";
/*

searchType=HL7
&taskContext.c.c=MLREV
&taskContext.c.cs=2.16.840.1.113883.5.4
&mainSearchCriteria.v.c=213169
&mainSearchCriteria.v.cs=2.16.840.1.113883.6.88
&mainSearchCriteria.v.dn=clopidogrel
&subTopic.v.c=Q000009
&subTopic.v.cs=2.16.840.1.113883.6.177
&subTopic.v.dn=adverse effects','urn:uuid:b0dab7c3-75ca-456d-b027-ae8b1f6c9260

?searchType=HL7&taskContext.c.c=MLREV&taskContext.c.cs=2.16.840.1.113883.5.4&mainSearchCriteria.v.c=213169&mainSearchCriteria.v.cs=2.16.840.1.113883.6.88&mainSearchCriteria.v.dn=clopidogrel&subTopic.v.c=Q000009&subTopic.v.cs=2.16.840.1.113883.6.177&subTopic.v.dn=adverse effects','urn:uuid:b0dab7c3-75ca-456d-b027-ae8b1f6c9260


      $urlorganizationOID         = '?representedOrganization.id.root=clinicalgenome.org'; 
      $urlcodeSystemsTask         = '&taskContext.c.c='. $codeSystemsTask; 
      $urlmainSearchCriteriaVC    = '&mainSearchCriteria.v.c='.$resultCode;
      $urlmainSearchCriteriaVCS   = '&mainSearchCriteria.v.cs='.$resultCodeSystem;
      $urlmainSearchCriteriaVDN   = '&mainSearchCriteria.v.dn='. str_replace(' ', '%20', $resultDisplayName);
      $urlperformer               = '&performer='.$localPerformersPerformer;
      $urlinformationRecipient    = '&informationRecipient='.$localPerformersInformationRecipient;
      $urlEnd                     = '&knowledgeResponseType=application/json';
*/

// NOTE for gets with _ are periods in the URL - http://php.net/manual/en/language.variables.external.php

$searchType               = $sanitizer->text($input->get['searchType']);
$taskContextcc            = $sanitizer->text($input->get['taskContext_c_c']);
$taskContextccs           = $sanitizer->text($input->get['taskContext_c_cs']);
$mainSearchCriteriavc     = $sanitizer->text($input->get['mainSearchCriteria_v_c']);    
$mainSearchCriteriavcs    = $sanitizer->text($input->get['mainSearchCriteria_v_cs']);
$mainSearchCriteriavdn    = $sanitizer->text($input->get['mainSearchCriteria_v_dn']);
$subTopicvc               = $sanitizer->text($input->get['subTopic_v_c']);
$subTopicvcs              = $sanitizer->text($input->get['subTopic_v_cs']);
$subTopicvdn              = $sanitizer->text($input->get['subTopic_v_dn']);

$resultCode               = $mainSearchCriteriavc; 
$resultCodeSystem         = $mainSearchCriteriavcs; 
$resultDisplayName        = $mainSearchCriteriavdn; 

$knowledgeResponseType = "noneSpecified"; /*BRET added 10/12/2015 please delete this comment*/
/****HELP HELP HELP HELP ***/
$knowledgeResponseType = $sanitizer->text($input->get['knowledgeResponseType']); /*BRET added 10/12/2015 please delete this comment*/
$resultknowledgeResponseType = $knowledgeResponseType; /*BRET added 10/12/2015 please delete this comment*/

// This grabs the post and sanatizes the text
$searchResult = $sanitizer->text($input->post['EMRcontext']);

// Grab the first segment... this should be the user of the system
$searchResultUri = $sanitizer->text($input->urlSegment2);

// Grab the second segment for the URL... this is the active tab
$urlTab = $sanitizer->pageName($input->urlSegment1);

// This checks if a tab is not set... if it was not then it should be ALL
if(!$urlTab) {
  $urlTab = "all"; 
}

// Checks to see if this was a call to us via an HL7 GET
  if($searchType == "HL7") {
    
    
  // Set this to make sure the PHP is processed...
  $processThis = 'true';
  
  
  
  // Now check if this was a POST or a URL
  } elseif($searchResult || $searchResultUri) {
    
    // This function is used to search the array that is generated
    function searcharray($value, $key, $array) {
      foreach ($array as $k => $val) {
        if ($val[$key] == $value) {
          return $val;
        }
      }
      return null;
    }
    
    
    
    // Used to search for terms in the JSON and give refined recommendations
    function search_array($needle, $haystack, $urlTab) {
     $page = wire('page');
     $pages = wire('pages');
     $input = wire('input');
     $path = $page->path."".$urlTab; 
     
     
     $needle = str_replace("-", " ", $needle);  // Find the dash and replace with space
     $needle = str_replace("/", " ", $needle);  // Find the slash and replace with space
     $needle = preg_replace('/(\s)+/', ' ', $needle);     // Remove any extra white space
     
     $searchRecommendationsArray = array();
     $score_count = 0;
     foreach($haystack as $element) {
       
        $element_str = str_replace("-", " ", $element['searchName']);  // Find the dash and replace with space
        $element_str = str_replace("/", " ", $element_str);            // Find the slash and replace with space
        $element_str = preg_replace('/(\s)+/', ' ', $element_str);                   // Remove any extra white space
        //$pos = stripos($element_str, $needle) * 10;
        $pos = stripos($element_str, $needle);
        
        $score = 100;             // Set default score to 10000        
        $score = $score - $pos;
        
        if (stristr($element_str,$needle)) {         //  is case sensitive
        //$scorecount++;
        //$score = $score - $pos - $scorecount;   // Subtract the position from the score.
        
            $searchRecommendations .= "<a href='{$path}/". $element['code'] ."' class='col-sm-12 text-warning'><span class='glyphicon glyphicon-search'></span> ".$element['searchName']." == ".$score." == ".$pos."</a>";
            $searchRecommendationsArray[]  = array(
              "html" => "<a href='{$path}/". $element['code'] ."' class='col-sm-12 text-warning'><span class='glyphicon glyphicon-search'></span> ".$element['searchName']."</a>",
              "score" => $score,
              "pos" => $pos,
              //"scorecount" => $scorecount,
              "name" => $element['searchName'],
            );
        }
     }
     
     // Go through and change the sort order to the highest are at the top
     function sortByOrder($a, $b){
        $n = $b['score'] - $a['score'];
        if($n != 0) {
          return $n;
        }
        return strcmp($a['name'], $b['name']);
      }; 
     function sortByName($a, $b){
      //return $b['name'] - $a['name'];
      return strcmp($a['name'], $b['name']);
      }; 
     uasort($searchRecommendationsArray, 'sortByOrder');
     $searchRecommendationsArray = array_values($searchRecommendationsArray);
     //print_r($searchRecommendationsArray);
     
     //array_multisort(
     //           $searchRecommendationsArray['name'], SORT_STRING, SORT_DESC,
     //           $searchRecommendationsArray['score'], SORT_DESC, SORT_NUMERIC
     //           );
    
     //print_r($searchRecommendationsArray);
     
   return $searchRecommendationsArray;
}
    
    
     
     // Grab the JSON file and set it as a var
    $json_data = file_get_contents("./assets/resource_web_list_search_assets/data/localTermStdCode-complete.json");
  
    // Decodes the JSON file so it is an array
    $jsondata = json_decode($json_data, true);
  
    // Use the searcharray function to... yup, search the searchName field in the array for the submitted value
    if($searchResult) {
      $jsonResultArray = searcharray($searchResult, 'searchName', $jsondata);
    } else {
      // or search the code field
      $jsonResultArray = searcharray($searchResultUri, 'code', $jsondata);
    }
    
    // Set this to make sure the PHP is processed...
    $processThis = 'true';
  }
  
  
  
  if($processThis == 'true') {
    // This checks to see if results were found in the localTermStdCode
    if($searchType == 'HL7') {
      $searchSuccess        = "true";
      $searchResult         = $mainSearchCriteriavdn;
      $resultCode           = $mainSearchCriteriavc; 
      $resultCodeSystem     = $mainSearchCriteriavcs; 
      $resultDisplayName    = $mainSearchCriteriavdn; 
	  
	  $resultknowledgeResponseType = $knowledgeResponseType; /*BRET added 10/12/2015 please delete this comment*/
	  
    } elseif($jsonResultArray) {
      $searchSuccess        = "true";
      $searchResult         = $jsonResultArray['searchName'];
      $resultDisplayName    = $jsonResultArray['displayName'];
      $resultCodeSystem     = $jsonResultArray['codeSystem'];
      $resultCode           = $jsonResultArray['code'];
    } else {
      // or search the code field
      $searchSuccess = "false";
      $searchRecommendations = search_array($searchResult, $jsondata, $urlTab);
    }
    
    /*Switch to set values of the supported codeSystems, includes the task assigned too*/
    switch ($resultCodeSystem) {
        case "2.16.840.1.113883.6.88":
            $codeSystemsTask = "MLREV";
            $resultCodeSystem = "2.16.840.1.113883.6.88";
            $codeSystemsName = "RxNorm";
            $showNews = "false";
            $showpatient = "false";
            $codeSystemContextSiteOrder = array(
			  0=> "CPIC Pharmacogenomics Guidelines", /*BRET ADDED on 9/30/2015 at 11:50 am - please delete this comment*/ 
              1 => "GTR",
			  2 => "PharmGKB",			  
              3 => "MedGen",
              4 => "Genetic Practice Guidelines",
              5 => "Genetics Home Reference",
              6 => "OMIM",
              7 => "ClinVar",
              8 => "G2C2",
              9 => "1000 Genomes",
            );
            break;
        case "2.16.840.1.113883.6.281":
            $codeSystemsTask = "PROBLISTREV";
            $resultCodeSystem = "2.16.840.1.113883.6.281";
            $codeSystemsName = "HUGO HGNC gene symbols";
            $showNews = "false";
            $showpatient = "true";
            $codeSystemContextSiteOrder = array(
              0 => "MedGen",
              1 => "Genetic Practice Guidelines",
              2 => "GTR",
              3 => "PharmGKB",
			  4 => "ClinGen Genome Curation Page", /*BRET ADDED on 9/30/2015 at 11:50 am - please delete this comment*/
              5 => "OMIM",
              6 => "Genetics Home Reference",
              7 => "Gene Reviews",
              8 => "ClinVar",
              9 => "1000 Genomes"
              );
            break;
        case "2.16.840.1.113883.6.96":
            $codeSystemsTask = "PROBLISTREV";
            $resultCodeSystem = "2.16.840.1.113883.6.96";
            $codeSystemsName = "SNOMED-CT";
            $showNews = "false";
            $showpatient = "false";
            $codeSystemContextSiteOrder = array(
              0 => "PharmGKB",
              1 => "GTR",
              2 => "MedGen",
              3 => "Genetics Home Reference",
              4 => "OMIM",
              5 => "ClinVar",
              6 => "G2C2",
              7 => "1000 Genomes"
              );
            break;
        case "2.16.840.1.113883.6.174":
            $codeSystemsTask = "PROBLISTREV";
            $resultCodeSystem = "2.16.840.1.113883.6.174";
            $codeSystemsName = "OMIM";
            $showNews = "false";
            $showpatient = "false";
            $codeSystemContextSiteOrder = array(
              0 => "Genetic Practice Guidelines",
              1 => "GTR",
              2 => "OMIM",
              3 => "GTR",
              4 => "PharmGKB",
              5 => "Gene Reviews",
              6 => "Genetics Home Reference",
              7 => "ClinVar",
              8 => "G2C2",
              9 => "1000 Genomes",
              );
            break;
    }
  
    /*Switch to set values of the supported performs based on tab selection*/
    // This is grabbed from the URL segment variable assigned above. 
    switch ($urlTab) {
        case "All":
            $localPerformersInformationRecipient = "PROV";
            $localPerformersCode = "";
            $localPerformersPerformer = "PROV";
            break;
        case "clinician":
            $localPerformersInformationRecipient = "PROV";
            $localPerformersCode = "";
            $localPerformersPerformer = "PROV";
            break;
        case "laboratory":
            $localPerformersInformationRecipient = "PROV";
            $localPerformersCode = "";
            $localPerformersPerformer = "PROV";
            break;
        case "research":
            $localPerformersInformationRecipient = "PROV";
            $localPerformersCode = "";
            $localPerformersPerformer = "PROV";
            break;
        case "patient":
            $localPerformersInformationRecipient = "PAT";  // I thought these should be PAT
            $localPerformersCode = "";
            $localPerformersPerformer = "PAT";
            break;
        case "news":
            $localPerformersInformationRecipient = "News";  // I thought this should be News
            $localPerformersCode = "News";
            $localPerformersPerformer = "News";
            break;
        default:
            $localPerformersInformationRecipient = "PROV";
            $localPerformersCode = "";
            $localPerformersPerformer = "PROV";
            break;
    }
      
      
      $urlBase                    = 'http://service.oib.utah.edu:8080/infobutton-service/infoRequest';
      $urlorganizationOID         = '?representedOrganization.id.root=clinicalgenome.org'; 
      $urlcodeSystemsTask         = '&taskContext.c.c='. $codeSystemsTask; 
      $urlmainSearchCriteriaVC    = '&mainSearchCriteria.v.c='.$resultCode;
      $urlmainSearchCriteriaVCS   = '&mainSearchCriteria.v.cs='.$resultCodeSystem;
      $urlmainSearchCriteriaVDN   = '&mainSearchCriteria.v.dn='. str_replace(' ', '%20', $resultDisplayName);
      $urlperformer               = '&performer='.$localPerformersPerformer;
      $urlinformationRecipient    = '&informationRecipient='.$localPerformersInformationRecipient;
      $locationOfInterestaddr     = '&locationOfInterest.addr.ZIP0='.$session->interaction;
      $urlEnd                     = '&knowledgeResponseType=application/json';
      
	 
	 /*BRET ADDED on 10/12/2015 at 11:50 am - please delete this comment*/
	  if($searchType == 'HL7' && $resultknowledgeResponseType == 'text/xml' ) { /*this way we have a default of json in the request to OpenInfobutton but can alter it if HL7 XML or JSONP request...*/
		$urlEnd = "&knowledgeResponseType=".$resultknowledgeResponseType; 
		/*get/send-on XML response from Openinfobutton */
		$xmlUrl = $urlBase."".$urlorganizationOID."".$urlcodeSystemsTask."".$urlmainSearchCriteriaVC."".$urlmainSearchCriteriaVCS."".$urlmainSearchCriteriaVDN."".$urlperformer."".$urlinformationRecipient."".$locationOfInterestaddr."".$urlEnd;
		$xmlResponse = file_get_contents($xmlUrl);
    
    // SRG - NOV2 Added to allow the file storage to occur.
    //$xmlResponse = $sanitizer->textarea($xmlResponse);      
    $file = './assets/resource_web_list_search_assets/data/ib-data-xml.txt';
    // The new person to add to the file
    $data = "UUID: ".$session->interaction."\n".$xmlResponse."\n\n\n";
    // Write the contents to the file, 
    // using the FILE_APPEND flag to append the content to the end of the file
    // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
    file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Content-type: text/xml; charset=utf-8');
		/*header('data:'.$xmlRsponse);*/
		echo  $xmlResponse; 
		
	/*	HttpResponse::status(200);
HttpResponse::setContentType('text/xml');
HttpResponse::setHeader('From', 'ClinGen');
HttpResponse::setData($xmlResponse);
HttpResponse::send();
		*/
		
		exit;
		
	  }
	  
	  elseif($searchType == 'HL7' && $resultknowledgeResponseType == 'application/json' ) { /*this way we have a default of json in the request to OpenInfobutton but can alter it if HL7 XML or JSONP request...*/
		$urlEnd = "&knowledgeResponseType=".$resultknowledgeResponseType; 
		$jsonUrl = $urlBase."".$urlorganizationOID."".$urlcodeSystemsTask."".$urlmainSearchCriteriaVC."".$urlmainSearchCriteriaVCS."".$urlmainSearchCriteriaVDN."".$urlperformer."".$urlinformationRecipient."".$locationOfInterestaddr."".$urlEnd;
    

		$json = file_get_contents($jsonUrl);
    
    // SRG - NOV2 Added to allow the file storage to occur.      
    $file = '/www/html/site/templates/assets/resource_web_list_search_assets/data/ib-data.txt';
    // The new person to add to the file
    //$data = "John Smith\n";
    $json = $sanitizer->textarea($json);  
    $data = "{\"response\":{\"uuid\": \"".$session->interaction."\",\"data\":".$json."}},\n";
    // Write the contents to the file, 
    // using the FILE_APPEND flag to append the content to the end of the file
    // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
    file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

		/*send response as json*/
		/*change header here*/
		header('Cache-Control: no-cache, must-revalidate');
		header('Content-type: application/json');
		echo  $json;
		exit;
	  }
	 /*BRET ADDED on 10/12/2015 at 11:50 am - please delete this comment*/ /*noneSpecified*/
   
   // The following is the standard processing that happens..
	 else { 
   
    // This checks to see if resultCodeSystem is set... if not then a match was not found
    // If nothing was found then DONT send out to IB
    if(!$resultCodeSystem) {
        $session->results             = "false";
      } else {
        $jsonUrl = $urlBase."".$urlorganizationOID."".$urlcodeSystemsTask."".$urlmainSearchCriteriaVC."".$urlmainSearchCriteriaVCS."".$urlmainSearchCriteriaVDN."".$urlperformer."".$urlinformationRecipient."".$locationOfInterestaddr."".$urlEnd;
       $json = $sanitizer->textarea($json);
        $json = file_get_contents($jsonUrl);
        $data = json_decode($json, TRUE);
     }
     
        // echo $jsonUrl;
    //exit; 
     
      if (array_key_exists('feed', $data)) {   
        $session->results                             = "true";
      } else {
        $session->results                             = "false";
      }
      
      $session->jsonResourceSearchTerm                = $jsonResultArray['searchName'];
      $session->jsonResourceSearchCode                = $jsonResultArray['code'];
      $session->jsonResourceSearchSystemsCode         = $codeSystemsCode;
      $session->jsonResourceSearchUrl                 = $jsonUrl;
      $session->jsonResourceSearchTab                 = $urlTab;
      $session->jsonResourceSearchData                = $data;
      $session->jsonResourceSearchDataSorted          = $data;
      $session->searchTerm                            = $searchResult;
      //$session->searchSuccess                         = $searchSuccess;
      // Print the results
      //echo "<pre>";
      //print_r($data);
      //echo "</pre>";
      
      
      if($session->results == "true") {
        
        // Creates a json file with the response
        //$newFile = './assets/resource_web_list_search_assets/data/helloworld.json';
        //$newFile = './assets/resource_web_list_search_assets/data/'.$session->interaction.'_TIMESTAMP_'.date('U').'.json';
        //$myFile = fopen($newFile, 'w') or die('Cannot open file:  '.$newFile); //implicitly creates file
        //fwrite($myFile, $json);
        //fclose($myFile);
        
        // SRG - NOV2 Added to allow the file storage to occur.      
        $file = '/www/html/site/templates/assets/resource_web_list_search_assets/data/ib-data.txt';
        // The new person to add to the file
        //$data = "John Smith\n";
        $json = $sanitizer->textarea($json); 
        $data = "{\"response\":{\"uuid\": \"".$session->interaction."\",\"data\":".$json."}},\n";
        // Write the contents to the file, 
        // using the FILE_APPEND flag to append the content to the end of the file
        // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
        file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
      }
      
	  
  } /*BRET ADDED on 10/12/2015 at 11:50 am - please delete this comment*/	  
  } else {
      $session->jsonResourceSearchTerm                = "";
      $session->jsonResourceSearchCode                = "";
      $session->jsonResourceSearchSystemsCode         = "";
      $session->jsonResourceSearchUrl                 = "";
      $session->jsonResourceSearchTab                 = "";
      $session->jsonResourceSearchData                = "";
      $session->jsonResourceSearchDataSorted          = "";
      $session->searchTerm                            = "";
  }
//}



// Allows the var to be an array.
$resourceNavData = array();

// The following generates the left nav.
foreach($session->jsonResourceSearchData["feed"] as $item) {
    
    
    // Search through the array and reorders based on the switch above
    $order = array_search($item["title"]["value"][0], $codeSystemContextSiteOrder);
    
    //loop through the resource links 
    $entrylinks = $item["entry"];
       foreach($entrylinks as $entrylink) {
         $itemlinks[] = array(
          "title" => $entrylink["title"]["value"][0],
          "href" => $entrylink["link"][0]["href"]
         );
       }
    
    // Creates a clean array for the nav
    $resourceNavData["$order"] = array(
      "title"     => $item["title"]["value"][0],
      "link"      => $itemlinks
      );
    
    // Clear the var so it is not looped
    unset($itemlinks);

    
  }
  
  // Resorts the nav based on the key
  ksort($resourceNavData);
  $resourceNavData = array_values($resourceNavData); 
  // Sets the default for the first items to show from the array
  $resourceFirstTitle   = $resourceNavData[0]["title"]." - ". $resourceNavData[0]["link"][0]["title"];
  $resourceFirst        = $resourceNavData[0]["link"][0]["href"];
  $resourceFirstCss     = "style='font-weight: bold;'";
  $resourceGa     = "
    <script type=\"text/javascript\">
        document.body.onload = function() {
          ga(\"send\", \"event\", \"web-resources\", \"Search Resource\", \"" . $item["title"] ." - " . $link["title"] ."\", {\"nonInteraction\": 1});
          ga(\"send\", \"event\", \"web-resources\", \"Search Resource Interaction - iFrame\", \"" . $session->interaction ." - " . $item["title"] ." - " . $link["title"] ."\", {\"nonInteraction\": 1});
          ga(\"send\", \"event\", \"web-resources\", \"Search Resource and Term\", \"SITE: " . $item["title"] ." - " . $link["title"] ." TERM: $session->searchTerm \", {\"nonInteraction\": 1});
       };
    </script>
  ";

// Go through and generate the nav based on the array.
foreach($resourceNavData as $item) {
    
    $links = $item["link"];
    
    $resourceNav .= "<li class='list-group-item'><strong>". $item["title"] ."</strong>";
    foreach($links as $link) {
      if($item["title"] == "OMIM" || $item["title"] == "1000 Genomes") {
        $linkicon = "glyphicon glyphicon-new-window text-grey";
        $linkcss = "resourceLinksExternal";
        $linktarget = "target='_blank'";
      } else {
        $linkicon = "glyphicon glyphicon-expand text-grey";
        $linkcss = "resourceLinks";
        $linktarget = ""; 
      }
      $resourceNav .= "<div class='padding-bottom-xs text-tight'><span class='$linkicon pull-right'></span>
                        <a class='$linkcss'  onClick='ga(\"send\", \"event\", \"web-resources\", \"Search Resource\", \"" . $item["title"] ." - " . $link["title"] ."\", {\"nonInteraction\": 1});ga(\"send\", \"event\", \"web-resources\", \"Search Resource Interaction - iFrame\", \"" . $session->interaction ." - " . $item["title"] ." - " . $link["title"] ."\", {\"nonInteraction\": 1});ga(\"send\", \"event\", \"web-resources\", \"Search Resource and Term\", \"SITE: " . $item["title"] ." - " . $link["title"] ." TERM: $session->searchTerm \", {\"nonInteraction\": 1});' $resourceFirstCss href='". $link["href"] ."' $linktarget data-resource-title='" . $item["title"] ." - " . $link["title"] ."' > " . $link["title"] ."</a></div>";
      
      unset($resourceFirstCss);  // allows this to only show on the first.
    }
    $resourceNav .= "</li>";
    
    echo $resourceGa;
    unset($resourceFirstCss);  // allows this to only show on the first.
  }

//$session->searchTerm





    
?>
