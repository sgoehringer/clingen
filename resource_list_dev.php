<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php"); 

if($pages->get(1)->toggle_yes_no == 1) {
  $enableSearch = "true";
}

// override
$enableSearch = "true";

function array_value_recursive($key, array $arr){
    $val = array();
    array_walk_recursive($arr, function($v, $k) use($key, &$val){
        if($k == $key) array_push($val, $v);
    });
    return count($val) > 1 ? $val : array_pop($val);
}


function array_find_gene($needle, $array, $type) 
{
    // $needle is what you are looking for
    // $array is the array that is passed in
    // $type allows the function to send back an array or just raw
    
    foreach($array as $key)
    {
       //$holder .= $key['Gene'];
       if($key['Gene'] === $needle) {
          $genekey = $key['Gene'];
          $holder['Gene'] = $key['Gene'];
          $holder['Location'] = $key['Genomic Location'];
          $holder['Haploinsufficiency_Score'] = $key['Haploinsufficiency Score'];
          $holder['Haploinsufficiency_Description'] = $key['Haploinsufficiency Description'];
          $holder['Triplosensitivity_Score'] = $key['Triplosensitivity Score'];
          $holder['Triplosensitivity_Description'] = $key['Triplosensitivity Description'];
          $holder['Date_Last_Evaluated'] = $key['Date Last Evaluated'];
       }
       if($type == true) {
        $genearray[$genekey] = $holder;
       } else {
         $genearray = $holder;
       }
    }
    if($type == true) {
      $genearray = array_filter($genearray);
    }
    return $genearray;
}

function array_find($haystack)
{
    $result = '';  //set default value

    foreach ($haystack as $key => $array) {
        foreach ( $array as $key => $value ) {
            if (false !== stripos($value,$needle))   // hasstack comes before needle
                {
                $result .= $value['curie'] . '|';  // concat results
                //return $result;
            }
        }
    }
    return $result;
}

$data_input         = $input->get['data_input'];
$data_curated       = $input->get['data_curated'];

$data_input         = $sanitizer->text($data_input);
$data_curated       = $sanitizer->text($data_curated);
$data_input         = explode("[",$data_input);
$data_input         = trim($data_input[0]);

// Set this... may need it later.
$resultGeneSearchArrayReturn = array();
$resultGeneSearchArray = array();

if($data_input) {
// TERMINOLOGY ////////////////////////////////////

// http://54.146.173.15:9000/scigraph/vocabulary/autocomplete/
$data_input_encode  = rawurlencode($data_input);
//$url        = $termonologyService."vocabulary/search/".$data_input_encode."?limit=2000&searchSynonyms=true&searchAbbreviations=false&searchAcronyms=false&prefix=OMIM&prefix=NCBIGene";

// SEARCH

// &prefix=NCBIGene
if($enableSearch == "true") {
  $url        = $termonologyService."vocabulary/autocomplete/".$data_input_encode."?limit=200&searchSynonyms=true&searchAbbreviations=false&searchAcronyms=false&includeDeprecated=false&prefix=OMIM&prefix=NCBIGene";
  //$url        = $termonologyService."vocabulary/search/".$data_input_encode."?limit=2000&searchSynonyms=true&searchAbbreviations=false&searchAcronyms=false";
  
  $search_json = file_get_contents($url); // this WILL do an http request for you
  $search_array = json_decode($search_json, true);
  $search_terminology = $search_array[0]['concept']['curie'];
}
  
  // GRAB THE LOCAL GENE DOSAGE DATA
  $url        = "./assets/dosage/data.json";
  $json = file_get_contents($url); // this WILL do an http request for you
  $dosageData = json_decode($json, true); 

if($enableSearch == "true") { 
  // backup matches
  $url        = $termonologyService."vocabulary/search/".$data_input_encode."?limit=10&searchSynonyms=true&searchAbbreviations=false&searchAcronyms=false&prefix=OMIM&prefix=NCBIGene";
  $json = file_get_contents($url); // this WILL do an http request for you
  $search_similar = json_decode($json, true);
}
  $search_similar_url = $url;
  //Build a search similar
  $match_search_similar_array = array();
  foreach($search_similar as $terms) {
      foreach($terms['labels'] as $match) {
        $match_search_similar_array[] = strtoupper($match);
      }
      foreach($terms['synonyms'] as $match) {
        //$match_search_similar_array[] = strtoupper($match);
      }
  }
  //  Cleanup and order
  $match_search_similar_array = array_unique($match_search_similar_array);
  asort($match_search_similar_array);

// Check to see if a CURIE was found... if not, a match was not found
if($search_terminology) {
  $search_terminology_success = "true";
} else {
  $search_error = "no_match";
}

// Check to see if a data_curated was passed in
if($data_curated || ($search_error == "no_match" && !$data_curated)) {
  
  if(!$data_curated) {
    $data_curated = $data_input;
  }
  
  // Look through the two resources to see if the label finds a match
  $search_curated_match_validity_phenotype       = $pages->find("template=data_clinical_validity, label=$data_curated");
  $search_curated_match_validity_gene       = $pages->find("template=data_clinical_validity, data_gene=$data_curated");
  $search_curated_match_actionability_phenotype       = $pages->find("template=data_actionability_evidence, data_genes.data_gene=$data_curated");
  $search_curated_match_actionability_gene       = $pages->find("template=data_actionability_evidence, label=$data_curated");
  $resultGeneSearchArrayReturn = array_find_gene($data_curated, $dosageData, true);
  //$resultGeneSearchArrayReturn = array_filter($resultGeneSearchArrayReturn);

  // Check to see if something above was matched...
  if(count($search_curated_match_actionability_gene) || count($search_curated_match_actionability_phenotype) || count($search_curated_match_validity_gene) || count($search_curated_match_validity_phenotype) || count($resultGeneSearchArrayReturn)) {
    $search_curated_success = "true";
    $search_terminology_label = $data_curated;
    unset($search_error);                 // Unset becasue something was found...
  } else {
    $search_error = "no_match";
  }
}


// Check to search_terminology_success set
if($search_terminology_success) {
  
  $search_terminology_label = $search_array[0]['completion'];
  //$search_terminology_label = $search_array[0]['concept']['labels'][0];   // add to result cleaner for synonyms
  $search_category   = ucwords($search_array[0]['concept']['categories'][0]);  // also make sure uppercase
  
  if($search_category) {
    $search_category_label = " [".$search_category."]";
  }
  
  // graph is used to grab the definition...
  $url        = $termonologyService."graph/".$data_input_encode."?project=%2A";
  $json = file_get_contents($url); // this WILL do an http request for you
  $graph = json_decode($json, true);
  $search_definition = $graph['nodes'][0]['meta']['definition'][0];

  $curie_array =  array_find($search_array);
  $curie_arrayRaw =  $curie_array;
  $curie_array = explode("|", $curie_array);
  $curie_array = array_unique($curie_array);
  $curie_array = array_filter($curie_array);
  $curie_pipe = implode("|", $curie_array);

  function myFilter_OMIM($string) {
    $var = strpos($string, 'OMIM:') !== false;
    return $var;
  }
  function myFilter_HP($string) {
    $var = strpos($string, 'HP:') !== false;
    return $var;
  }
  function myFilter_DOID($string) {
    $var = strpos($string, 'DOID:') !== false;
    return $var;
  }
  function myFilter_MESH($string) {
    $var = strpos($string, 'MESH:') !== false;
    return $var;
  }

  $omim_array = array_filter($curie_array, 'myFilter_OMIM');
  $hp_array = array_filter($curie_array, 'myFilter_HP');
  $doid_array = array_filter($curie_array, 'myFilter_DOID');
  $mesh_array = array_filter($curie_array, 'myFilter_MESH');
  
  $indentifier_count = count($omim_array);
  $indentifier_count = count($hp_array) + $indentifier_count;
  $indentifier_count = count($doid_array) + $indentifier_count;
  $indentifier_count = count($mesh_array) + $indentifier_count;

  $omim_pipe    = implode("|", $omim_array);
  $hp_pipe      = implode("|", $hp_array);
  $doid_pipe    = implode("|", $doid_array);
  $mesh_pipe    = implode("|", $mesh_array);

  $omim_match = str_replace('OMIM:', '', $omim_pipe);

  //Build a synonyms list
  $match_synonyms_array = array();
  foreach($search_array as $terms) {
      foreach($terms['concept']['synonyms'] as $synonym) {
        //$term = strtolower($term);
        //$match_synonyms_array[] = array( 
        //  "synonym"              => ucwords($synonym),
        //  "category"             => ucwords($terms['concept']['categories'][0])
        //);
        
        // Grab the category so it can ba added
        $category = ucwords($terms['concept']['categories'][0]);
          if($category == "Phenotype") {
            $match_synonyms_array_phenotype[] = strtoupper($synonym) . 
              " [". ucwords($terms['concept']['categories'][0]) ."]";
          } else if($category == "Gene") {
            $match_synonyms_array_gene[] = strtoupper($synonym) . 
              " [". ucwords($terms['concept']['categories'][0]) ."]";
          }
      }
  }
  //  Cleanup and order
  $match_synonyms_array_phenotype = array_unique($match_synonyms_array_phenotype);
  asort($match_synonyms_array_phenotype);
  //  Cleanup and order
  $match_synonyms_array_gene = array_unique($match_synonyms_array_gene);
  asort($match_synonyms_array_gene);
  
} // END the search_terminology_success IF 


if($search_terminology_success OR $search_curated_success) {
  
  if($search_terminology_success) {
    // Checks to see if the omim id was found and run through the search for local data
    if ($omim_match) {
        $data_clinical_validity       = $pages->find("template=data_clinical_validity, data_omim=$omim_match");
        $data_actionability_match = array();
        foreach($omim_array as $term) { 
          $omim_match = str_replace('OMIM:', '', $term);
          $data_actionability_match[] = $pages->find("template=data_actionability_evidence, data_omim*=$omim_match");
        }
        $data_actionability_match = array_unique($data_actionability_match);
        $data_actionability_match = array_filter($data_actionability_match);
        $data_actionability_match     = implode("|", $data_actionability_match);
        //echo $data_actionability_match;
        $data_actionability_evidence     = $pages->find("id=$data_actionability_match");
    }
    if($search_category == 'Gene') {
      
      $gene_match = $search_terminology_label;
      strtoupper($gene_match);
      
      $data_clinical_validity       = $pages->find("template=data_clinical_validity, data_gene=$gene_match");
      $data_actionability_evidence     = $pages->find("template=data_actionability_evidence, data_genes.data_gene=$gene_match");
      $resultGeneSearchArrayReturn = array_find_gene($gene_match, $dosageData, true);
      
      //echo "<br>data_clinical_validity ". $data_clinical_validity;
      //echo "<br>data_actionability_evidence ". $data_actionability_evidence;
      //echo "<br>resultGeneSearchArrayReturn <pre>"; print_r($resultGeneSearchArrayReturn); echo "</pre>";

    }
  }
  
  // Required for the curated bypass
  if($search_curated_success) {
    if(count($search_curated_match_validity_gene) || count($search_curated_match_validity_phenotype)) {
      $data_clinical_validity          = $pages->find("id=$search_curated_match_validity_gene|$search_curated_match_validity_phenotype");
      }
    if(count($search_curated_match_actionability_gene) || count($search_curated_match_actionability_phenotype)) {
      $data_actionability_evidence     = $pages->find("id=$search_curated_match_actionability_gene|$search_curated_match_actionability_phenotype");
      }
    }
}

// INFOBUTTON ////////////////////////////////////


if($search_terminology_success) {  // Check to see if Termonolgy service found something...

  // Just grab the first term for now...
  if($search_category == 'Phenotype') {
    $resultCode = array_values($omim_array)[0];
    $resultCode = str_replace('OMIM:', '', $term);   // remove OMIM from the text
    $searchResult                   = $search_terminology_label;
    $resultDisplayName              = $search_terminology_label;
    $resultCodeSystem               = "2.16.840.1.113883.6.174";  // need to make this smarter but just OMIM
    $resultCode                     = $resultCode;   /// just grab the first one for now
  } else if ($search_category == 'Gene') {
    $searchResult                   = $search_terminology_label;
    $resultDisplayName              = $search_terminology_label;
    $resultCodeSystem               = "2.16.840.1.113883.6.281";  // need to make this smarter but just OMIM
    $resultCode                     = $search_terminology_label;   /// just grab the first one for now
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
                 0 => "PharmGKB",			
                1 => "GTR",  
                 2=> "CPIC Pharmacogenomics Guidelines", 
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
                0 => "ClinGen",
                 1 => "MedGen",
                2 => "Genetic Practice Guidelines",
                3 => "GTR",
                4 => "PharmGKB",
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
                0 => "ClinGen", 
                1 => "Genetic Practice Guidelines",
                2 => "GTR",
                3 => "OMIM",
                4 => "GTR",
                5 => "PharmGKB",
                6 => "Gene Reviews",
                7 => "MedGen",
                8 => "Genetics Home Reference",
                9 => "ClinVar",
                10 => "G2C2",
                11 => "1000 Genomes",
                );
              break;
       case "ORPHANET":
              $codeSystemsTask = "PROBLISTREV";
              $resultCodeSystem = "ORPHANET";
              $codeSystemsName = "ORPHANET";
              $showNews = "false";
              $showpatient = "false";
              $codeSystemContextSiteOrder = array(
                0 => "ClinGen", 
                1 => "Genetic Practice Guidelines",
                2 => "GTR",
                3 => "OMIM",
                4 => "GTR",
                5 => "PharmGKB",
                6 => "Gene Reviews",
                7 => "MedGen",
                8 => "Genetics Home Reference",
                9 => "ClinVar",
                10 => "G2C2",
                11 => "1000 Genomes",
                );
              break;
      }
    
  
        // These are set because we don't use the tabs yet.
        $localPerformersInformationRecipient = "PROV";
        $localPerformersCode = "";
        $localPerformersPerformer = "PROV";
       
        
        
        $urlBase                    = 'http://service.oib.utah.edu:8080/infobutton-service/infoRequest';
        //$urlorganizationOID         = '?representedOrganization.id.root=clinicalgenome.org_dev'; 
        $urlorganizationOID         = '?representedOrganization.id.root=clinicalgenome.org_demo'; 
        $urlcodeSystemsTask         = '&taskContext.c.c='. $codeSystemsTask; 
        $urlmainSearchCriteriaVC    = '&mainSearchCriteria.v.c='.$resultCode;
        $urlmainSearchCriteriaVCS   = '&mainSearchCriteria.v.cs='.$resultCodeSystem;
        $urlmainSearchCriteriaVDN   = '&mainSearchCriteria.v.dn='. str_replace(' ', '%20', $resultDisplayName);
        $urlperformer               = '&performer='.$localPerformersPerformer;
        $urlinformationRecipient    = '&informationRecipient='.$localPerformersInformationRecipient;
        $locationOfInterestaddr     = '&locationOfInterest.addr.ZIP0='.$session->interaction;
        $urlEnd                     = '&knowledgeResponseType=application/json';
        
        $jsonUrl = $urlBase."".$urlorganizationOID."".$urlcodeSystemsTask."".$urlmainSearchCriteriaVC."".$urlmainSearchCriteriaVCS."".$urlmainSearchCriteriaVDN."".$urlperformer."".$urlinformationRecipient."".$locationOfInterestaddr."".$urlEnd;
       
        $json = file_get_contents($jsonUrl);
        $dataInfoButton = json_decode($json, TRUE);
        
        
        //$order = array_search($item["title"]["value"][0], $codeSystemContextSiteOrder);
        $resourceNavData = array();
        // The following generates the left nav.
        foreach($dataInfoButton["feed"] as $item) {
         // Check to see if ClinGen... if not continue
         if($item["title"]["value"][0] != "ClinGen") {
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
        }
        // Resorts the nav based on the key
        ksort($resourceNavData);
        $resourceNavData = array_values($resourceNavData);
          
        // Following checks to see if array has data...
        // if not, set to false
          
    
    } // End InfoButton IF

}
    if(count($resourceNavData)) {
      $ResultsInfoButton = "true";
    } else {
      $ResultsInfoButton = "false";
    }
?>
<div class="row"> 
	<div class="col-sm-12">
	<div class="content-space content-border padding-top-md">
  <? 
  
      // search_curated_match_actionability_gene
    // search_curated_match_actionability_phenotype
    // search_curated_match_validity_gene
    // search_curated_match_validity_phenotype
    //data_actionability_evidence
    //data_clinical_validity
  
  //echo "<pre>";
  //echo "<br>search_curated_match ".$search_curated_match;
  //echo "<br>search_curated_match_actionability_gene ".$search_curated_match_actionability_gene;
  //echo "<br>search_curated_match_actionability_phenotype ".$search_curated_match_actionability_phenotype;
  //echo "<br>search_curated_match_validity_gene ".$search_curated_match_validity_gene;
  //echo "<br>search_curated_match_validity_phenotype ".$search_curated_match_validity_phenotype;
  //echo "<br>data_actionability_evidence ".$data_actionability_evidence;
  //echo "<br>data_clinical_validity ".$data_clinical_validity;
  //echo "<br>search_terminology_success ".$search_terminology_success;
  //echo "<br>search_curated_success ".$search_curated_success;
  //echo "<br>".$search_terminology_success;
  //echo "<br>".$ResultsInfoButton;
  //print_r($resourceNavData);
  //echo "<br>".count($resourceNavData);
  //print_r($data['feed']);
  //echo "</pre>";
  
  
  // This checks to see if the search box should show.
  if($enableSearch == "true") {
    

      // ERROR MESSAGES HERE
     if($search_error == "no_match") { ?>
      <div class='row'>
        <div class='col-sm-12'>
          <div class="alert alert-info" role="alert"><h3 class='margin-top-none'>We're sorry...</h3>
            <strong><?=$data_input?></strong> didn't closely match one of the terms in our index. Please try another term or try one of our resources below.
            
            <? if(count($match_search_similar_array)) { ?>
           <div class='row padding-top-sm'> 
               <dl class="dl-horizontal padding-none margin-none">
                <dt class="text-sm">Similar matches</dt>
                <dd class="padding">
                  <? foreach($match_search_similar_array as $term) { 
                    echo "<a href='{$page->httpUrl}?data_input=".$term ."' class='text-info ellips col-sm-6 padding-none''>".$term ."</a>"; 
                  } ?>
                  </dd>
                  <div class='col-sm-12 text-xs clearfix'>&nbsp;</div>
                  </div>
           <? } ?>
          </div>
        </div>
      </div>

   <? } ?>
   <form action='/clingen-tools-and-work-products/'  method='get' id='remote' class='tt-inside col-sm-12 padding-left-none padding-bottom-md tt-scrollable-dropdown-menu'>
                    <div class=' col-sm-10 padding-right-none padding-left-none'>
                  <input class='typeahead'  value='<?=$data_input?><?=$search_category_label ?>' name='data_input' type='text' placeholder='Seeking info about a gene or disease? Type it...'>
                  </div>
                  <div class=' col-sm-2 padding-left-none'>
                  <button class='btn btn-default btn-typeahead' type='submit'>Go!</button>
                  </div>
                  <small>ClinGen's search feature will return relevant information from both <a href='<?=$pages->get('3950')->url?>'>ClinGen Curated Resources</a> and reputable external sources.</small>
                  
                  </form>
                  
   <? } ?>
   <? if($search_terminology_success OR $search_curated_success) { ?>

   <div class='col-sm-12 padding-bottom-sm'>
    <div class="panel panel-default">
    <div class="panel-heading">
    
    <!--
    <div class='pull-right'>
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-sm" disabled>Organize:</button>
          <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="">Default Summary</span>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="#"><strong>Clinician</strong> Summary &amp; Resources</a></li>
            <li><a href="#"><strong>Researcher</strong> Summary &amp; Resources</a></li>
            <li><a href="#"><strong>Laboratory</strong> Summary &amp; Resources</a></li>
            <li><a href="#"><strong>Researcher</strong> Summary &amp; Resources</a></li>
            <li><a href="#"><strong>Patient</strong> Summary &amp; Resources</a></li>
          </ul>
        </div>
    </div>
    -->
    
    <h3 class='padding-none margin-none'><span class='text-muted'>Match:</span> <?=$search_terminology_label?></h3></div>
    <? if($search_terminology_success) {  // check to see if termonoly found match?>
    <div class="panel-body">
   <dl class="dl-horizontal padding-none margin-none">
    <? if($search_definition) { ?>
     <dt class='text-sm text-muted'>Definition</dt>
        <dd class="padding-bottom-xs"><?=$search_terminology_label?> (<?=$search_terminology?>) - <?=$search_definition?></dd>
    <? } ?>
    <? if($indentifier_count) { ?>
        <dt class='text-sm text-muted'>Identifiers</dt>
        <dd class="padding"> <strong><?=$indentifier_count?></strong> different identifiers found <span id='toggle_button_Identifiers' class="btn btn-xs btn-default"><i class="glyphicon glyphicon-chevron-down text-xs"></i> refine results</span></dd>
    <? } ?>
         <dd class="padding-left-md" id='toggle_Identifiers' style='display:none'><div class='row padding-bottom-sm'>
        <small class='col-sm-12 border-bottom padding-left-none'>Refine your results refining the identifiers utlized</small>
        <div class='col-sm-12'>
          <? if(count($omim_array)) { ?>
            <? foreach($omim_array as $term) { echo "<label class='checkbox-inline col-sm-3 margin-none'>".$term ."</label>"; } ?>
          <? } ?>
          <? if(count($hp_array)) { ?>
            <? foreach($hp_array as $term) { echo "<label class='checkbox-inline col-sm-3 margin-none''>".$term ."</label"; } ?>
          <? } ?>
         <? if(count($doid_array)) { ?>    
            <? foreach($doid_array as $term) { echo "<label class='checkbox-inline col-sm-3 margin-none''>".$term ."</label>"; } ?>
        <? } ?>
         <? if(count($mesh_array)) { ?>       
            <? foreach($mesh_array as $term) { echo "<label class='checkbox-inline col-sm-3 margin-none''>".$term ."</label>"; } ?>
        <? } ?></div></div>
        <dt class='text-sm text-muted clear-left'>Synonyms</dt>
        <dd class="padding"> <strong><? echo count($match_synonyms_array_gene) + count($match_synonyms_array_phenotype); ?></strong> different synonyms found <span id='toggle_button_synonyms' class="btn btn-xs btn-default"><i class="glyphicon glyphicon-chevron-down text-xs"></i> refine results</span></dd>
        <dd class="padding-left-md" id='toggle_synonyms' style='display:none'><div class='row padding-bottom-sm'>
        <? if(count($match_synonyms_array_phenotype)) { ?>
        <small class='col-sm-12 border-bottom padding-left-none'>Phenotypes - Conduct a different search by clicking one of the synonyms below...</small>
            <? foreach($match_synonyms_array_phenotype as $term) { echo "<a href='{$page->httpUrl}?data_input=".$term ."' class='ellips col-sm-6 padding-none''>".$term ."</a>"; } ?>
            <div class='col-sm-12 text-xs clearfix'>&nbsp;</div>
        <? } ?>
        <? if(count($match_synonyms_array_gene)) { ?>
        <small class='col-sm-12 border-bottom padding-left-none'>Genes - Conduct a different search by clicking one of the synonyms below...</small>

            <? foreach($match_synonyms_array_gene as $term) { echo "<a href='{$page->httpUrl}?data_input=".$term ."' class='ellips col-sm-6 padding-none''>".$term ."</a>"; } ?>
        <? } ?>
        </div>
   <dl>
   </div>
   <? } // END search_terminology_success ?>
   <? if((count($data_clinical_validity)) || (count($data_actionability_evidence)) || (count($resultGeneSearchArrayReturn))) { 
      $img_sized = $pages->get(2819)->image->size(200,200)->url;
     $data_clinical_validity_img = "<img src='{$img_sized}' class=' margin-left-lg img img-responsive img-rounded' alt='{$match->title}'>";
     $img_sized = $pages->get(2818)->image->size(200,200)->url;
     $data_clinical_actionability_img = "<img src='{$img_sized}' class=' margin-left-lg img img-responsive img-rounded' alt='{$match->title}'>";
     $data_clinical_actionability_url = $pages->get(2818)->url_website;

     $img_sized = $pages->get(2808)->image->size(200,200)->url;
     $dosage_sensitivity_img = "<img src='{$img_sized}' class=' margin-left-lg img img-responsive img-rounded' alt='{$match->title}'>";
   ?>
  
        
  <? if(count($data_clinical_validity)) { 
  
    $renderClingenHtml .= "
    <div class='col-sm-1 hidden-xs'>{$data_clinical_validity_img}</div>
    <div class='col-sm-11 col-xs-12 padding-bottom-lg margin-bottom-lg'>
    <div class='pull-right text-xs'><button type='button' class='btn btn-sm btn-default btn-popover margin-bottom-xthin' data-placement='left' data-title='About this Working Group' data-toggle='popover' data-content='{$pages->get(2819)->summary}'><i class='glyphicon glyphicon-info-sign'></i></button></div>
    <h4 class='padding-none margin-top-none border-bottom'>{$pages->get(2819)->title}</h4> "; 
 
    foreach($data_clinical_validity as $result) { 
    $ii++;
      $orphanetId = strtoupper($result->data_orphanet);
      $orphanetId = trim($orphanetId, "ORPHA");
      
      unset($classification);
        foreach($result->relate_classification_gene_curation as $item) {
          $classification .= "<span class='label label-success text-12px '><i class='glyphicon glyphicon-info-sign'></i>{$item->title}</span> ";
        }
        
        if(!$files) {
          $files = "No Reported Evidence";
        }
        
      unset($files);
        foreach($result->files as $file) {
          $files .= "<a href='$file->url' target='_blank' class='text-black'><i class='glyphicon glyphicon-file text-muted'></i> View Report Document [$file->description]</a> ";
        }
        
        if(!$files) {
          $files = "No Reported Evidence";
        }
        
        if(!$result->data_orphanet) {
          $data_orphanet = "Orphanet: N/A";
        } else {
          $data_orphanet = "<a href='http://www.orpha.net/consor/cgi-bin/OC_Exp.php?lng=en&Expert={$orphanetId}' target='_blank' class='text-muted'>Orphanet: $result->data_orphanet <i class='glyphicon glyphicon-new-window text-xs text-muted'></i></a>";
            $resultIdentifier .= "<a class='highlightInfo' href='#data_".$result->data_orphanet."'>".$result->data_orphanet."</a>, ";
            $resultClass .= "found_data_".$result->data_orphanet." ";
        }
        
        if(!$result->data_omim) {
          $data_omim = "OMIM: N/A";
        } else {
          $data_omim = "<a href='http://omim.org/entry/{$result->data_omim}' target='_blank' class='text-muted'>OMIM: $result->data_omim <i class='glyphicon glyphicon-new-window text-xs text-muted'></i></a>";
            //$resultIdentifier .= "OMIM:".$result->data_omim.", ";
            $resultIdentifier .= "<a class='highlightInfo text-muted' href='#data_OMIM".$result->data_omim."'>OMIM:".$result->data_omim."</a>, ";
            $resultClass .= "found_data_OMIM".$result->data_omim." ";
        }
    
    if($ii>1) { 
      $renderClingenHtml .= "<div class='clearfix'><hr></div>"; 
    } 
    
    //$resultGenes .= $result->data_gene.", ";
    $resultGenes .= "<a class='highlightInfo' href='#data_".$result->data_gene."'>".$result->data_gene."</a>, ";
    $resultClass .= "found_data_".$result->data_gene." ";
    $resultGeneSearch .= $result->data_gene."|";
    //$resultPhenotype .= $result->label.", ";
    $resultPhenotype .= "<a class='highlightInfo' href='#data_". str_replace(' ', '', $result->label) ."'>".$result->label."</a>, ";
    $resultClass .= "found_data_". str_replace(' ', '', $result->label) ." ";
    $resultDate .= $result->date_start.", ";
    
    $renderClingenHtml .= "
    <dl class='dl-horizontal padding-none margin-none {$resultClass}'>
      <dt class='text-sm text-muted'>HGNC Gene Symbol</dt>
      <dd class='padding-bottom-xs'><a href='http://www.genenames.org/cgi-bin/gene_symbol_report?hgnc_id=<{$result->data_hgnc}' target='_blank' class='text-black'> <em><strong>{$result->data_gene}</strong></em> <i class='glyphicon glyphicon-new-window text-xs text-muted'></i></a> </dd>
      <dt class='text-sm text-muted'>Disease Curated</dt> 
      <dd class='padding-bottom-xs'><strong>{$result->label}</strong><div class='text-sm'>{$data_orphanet} &nbsp;&nbsp;|&nbsp;&nbsp; {$data_omim}</div></dd>
      <dt class='text-sm text-muted'>Classification</dt>
      <dd class='padding-bottom-xs'>{$classification}</dd>
      <dt class='text-sm text-muted'>Report &amp; Files</dt>
      <dd class='padding-bottom-xs'>{$files}</dd>
      <dt class='text-sm text-muted'>Date Last Evaluated</dt>
      <dd>".date('d/m/Y', $result->date_start)."</dd>
    </dl>"; 
     } 
     $renderClingenHtml .= "
    </div>
        <div class='col-sm-12 margin-padding-lg margin-top-lg'></div> ";
     }
     
     unset($resultClass);
     
      $resultGeneSearchArrayMerge = explode("|", $resultGeneSearch);
      //print_r($resultGeneSearchArrayMerge);
      $resultGeneSearchArray = $resultGeneSearchArray + $resultGeneSearchArrayMerge;
      $resultGeneSearchArray = array_unique($resultGeneSearchArray);
      $resultGeneSearchArray = array_filter($resultGeneSearchArray);
      //print_r($resultGeneSearchArray);
     ?>
    
  <? if(count($data_actionability_evidence)) { 
    unset($ii);
  $renderClingenHtml .= " 
  <div class='col-sm-1 hidden-xs'>{$data_clinical_actionability_img}</div>
  <div class='col-sm-11 col-xs-12 padding-bottom-lg margin-bottom-lg'>
  <div class='pull-right text-xs'><button type='button' class='btn btn-sm btn-default btn-popover margin-bottom-xthin' data-placement='left' data-title='About this Working Group' data-toggle='popover' data-content='{$pages->get(2818)->summary}'><i class='glyphicon glyphicon-info-sign'></i></button></div>
  <h4 class='padding-none margin-top-none border-bottom'>{$pages->get(2818)->title}</h4> ";
   foreach($data_actionability_evidence as $result) { 
    $ii++;
    $orphanetId = strtoupper($result->data_orphanet);
    $orphanetId = trim($orphanetId, "ORPHA");
    
    unset($files);
      foreach($result->files as $file) {
        $files .= "<a href='$file->url' target='_blank' class='text-black'><i class='glyphicon glyphicon-file text-muted'></i>  View Report Document</a> ";
      }
      
    unset($score);
      /*foreach($result->data_actionability_score as $item) {
        
        $score_var = explode(",", $item->var);
        $score .= "<ul class='list-inline padding-bottom-sm text-muted'>
          <li class=''><span class='label label-success text-12px '>".$item->label."</span></li>
          <li>Scores: <strong>".$score_var[0]."</strong> Severity </li>
          <li><strong>".$score_var[1]."</strong> Likelihood </li>
          <li><strong>".$score_var[2]."</strong> Effectiveness </li>
          <li><strong>".$score_var[3]."</strong> Intervention</li>
        </ul>";
      }
      */
      foreach($result->data_actionability_score as $item) {
        
        $score_var = explode(",", $item->var);
        $score .= "<tr>
                      <td>".$item->label."</td>
                      <td>".$score_var[0]."</td>
                      <td>".$score_var[1]."</td>
                      <td>".$score_var[2]."</td>
                      <td>".$score_var[3]."</td>
                      <td><a href='".$data_clinical_actionability_url."#sqm' class='label label-success text-12px '>".$score_var[4]."</span></td>
                    </tr>";
      }
      
      if(!$files) {
        $files = "No Reported Evidence";
      }
      
      if(!$result->data_omim) {
        $data_omim = "N/A";
      } else {
        $omims = explode(",", $result->data_omim);
        foreach($omims as $omim) {
          $omim = trim($omim, " ");
          $data_omim .= " <a href='http://omim.org/entry/{$omim}' target='_blank' class='text-muted'>OMIM: $omim <i class='glyphicon glyphicon-new-window text-xs text-muted'></i></a> ";
          //$resultIdentifier .= "OMIM:".$omim.", ";
          $resultIdentifier .= "<a class='highlightInfo' href='#data_OMIM".$omim."'>OMIM:".$omim."</a>, ";
          $resultClass .= "found_data_OMIM".$omim." ";
        }
      }
      
      if(!count($result->data_genes)) {
        $data_genes = "N/A";
      } else {
        foreach($result->data_genes as $gene) {
          $data_genes .= " <a href='http://www.genenames.org/cgi-bin/gene_symbol_report?hgnc_id={$gene->data_hgnc}' target='_blank' class='text-black'> <em>$gene->data_gene</em> <i class='glyphicon glyphicon-new-window text-xs text-muted'></i></a> ";
          //$resultGenes .= $gene->data_gene.", ";
          $resultGenes .= "<a class='highlightInfo' href='#data_".$gene->data_gene."'>".$gene->data_gene."</a>, ";
          $resultClass .= "found_data_".$gene->data_gene." ";
          $resultGeneSearch .= $gene->data_gene."|";
        }
      }
  if($ii>1) { 
    $renderClingenHtml .= "<div class='clearfix col-sm-12'><hr></div>"; 
  } 
  
  
  //$resultPhenotype .= $result->label." ";
  $resultPhenotype .= "<a class='highlightInfo' href='#data_". str_replace(' ', '', $result->label) ."'>".$result->label."</a>, ";
  $resultClass .= "found_data_". str_replace(' ', '', $result->label) ." ";
  if($result->date_start > $resultDate) {
    $resultDate = $result->date_start." ";
  }
  
  $renderClingenHtml .= " 
  <dl class='dl-horizontal padding-none margin-none {$resultClass}'>
    <dt class='text-sm text-muted'>HGNC Gene Symbol(s)</dt>
    <dd class='padding-bottom-xs'><strong>{$data_genes}</strong></dd>
    <dt class='text-sm text-muted'>Disorder curated</dt> 
    <dd class='padding-bottom-xs'><strong>{$result->label}</strong><div class='text-sm'>{$data_omim}</div></dd>
    <dt class='text-sm text-muted'>Score</dt>
    <dd class='padding-bottom-xs'><table class='table-condensed table'>
                                    <tr>
                                      <th style='border-top:none' class='text-muted padding-top-none text-sm'>Outcome/Intervention Pair</th>
                                      <th style='border-top:none' class='text-muted padding-top-none text-sm'>Severity</th>
                                      <th style='border-top:none' class='text-muted padding-top-none text-sm'>Likelihood</th>
                                      <th style='border-top:none' class='text-muted padding-top-none text-sm'>Effectiveness</th>
                                      <th style='border-top:none' class='text-muted padding-top-none text-sm'>Intervention</th>
                                      <th style='border-top:none' class='text-muted padding-top-none text-sm'>Total</th>
                                    </tr>
                                    {$score}
                                    </table>
    </dd>
    <dt class='text-sm text-muted'>Report &amp; Files</dt>
    <dd class='padding-bottom-xs'>{$files}</dd>
    <dt class='text-sm text-muted'>Date Last Evaluated</dt>
    <dd>".date('d/m/Y', $result->date_start)."</dd>
  "; 
   
   unset($data_genes);
   unset($data_omim);
  //</div>
   $renderClingenHtml .= "
      <div class='col-sm-12'></div> ";
   }
   $renderClingenHtml .= "</div>";
   
   unset($resultClass);
   unset($data_genes);
   
   
   $resultGeneSearchArrayMerge = explode("|", $resultGeneSearch);
    //print_r($resultGeneSearchArrayMerge);
    $resultGeneSearchArray = $resultGeneSearchArray + $resultGeneSearchArrayMerge;
    $resultGeneSearchArray = array_unique($resultGeneSearchArray);
    $resultGeneSearchArray = array_filter($resultGeneSearchArray);
    //print_r($resultGeneSearchArray);
   
   
   // Check to see if a phenotype search so dosage genes are matched...
   if($search_category == "Phenotype") {
     foreach($resultGeneSearchArray as $find) {
       $resultGeneSearchArrayReturnPhenotype[$find] = array_find_gene($find, $dosageData, false);
     }
    $resultGeneSearchArrayReturnPhenotype = array_filter($resultGeneSearchArrayReturnPhenotype);
   $resultGeneSearchArrayReturn = $resultGeneSearchArrayReturn + $resultGeneSearchArrayReturnPhenotype;
   }        
 }
   
   // Check the array and clean it up...
   
   // Check to see if anything is found in dosage...
   $resultGeneSearchArrayReturnMerge = array_find_gene($data_curated, $dosageData, true);
   // Merge what is found above with the main dosage array...
   $resultGeneSearchArrayReturn = $resultGeneSearchArrayReturn + $resultGeneSearchArrayReturnMerge;
   
   // Check to see if anything is found in dosage...
   //echo "<pre>resultGeneSearchArray 1";
//print_r($resultGeneSearchArray);
//print_r($resultGeneSearchArrayReturn);
   //echo "</pre>";
   if(count($resultGeneSearchArray)) {
     foreach($resultGeneSearchArray as $find) {
       $resultGeneSearchArrayReturnPhenotype[$find] = array_find_gene($find, $dosageData, false);
     }
    $resultGeneSearchArrayReturnPhenotype = array_filter($resultGeneSearchArrayReturnPhenotype);
    $resultGeneSearchArrayReturn = $resultGeneSearchArrayReturn + $resultGeneSearchArrayReturnPhenotype;
   }
   
   // Check to see if anything is found in dosage...
   //echo "<pre>resultGeneSearchArrayReturn 2";
//print_r($resultGeneSearchArrayReturn);
   //echo "</pre>";
   // Check to see if anything is found in dosage...
   $resultGeneSearchArrayReturnMerge = array_find_gene($resultGeneSearchArray, $dosageData, true);
   // Merge what is found above with the main dosage array...
   $resultGeneSearchArrayReturn = $resultGeneSearchArrayReturn + $resultGeneSearchArrayReturnMerge;
   
   
   //$resultGeneSearchArrayReturn = array_unique($resultGeneSearchArrayReturn);
   $resultGeneSearchArrayReturn = array_filter($resultGeneSearchArrayReturn);
   
if(count($resultGeneSearchArrayReturn)) { 
      unset($ii);
    $renderClingenHtml .= " 
    <div class='col-sm-1 hidden-xs'>{$dosage_sensitivity_img}</div>
    <div class='col-sm-11 col-xs-12'>
    <div class='pull-right text-xs'><button type='button' class='btn btn-sm btn-default btn-popover margin-bottom-xthin' data-placement='left' data-title='About this Working Group' data-toggle='popover' data-content='{$pages->get(2808)->summary}'><i class='glyphicon glyphicon-info-sign'></i></button></div>
    <h4 class='padding-none margin-top-none border-bottom'>{$pages->get(2808)->title}</h4> ";
     foreach($resultGeneSearchArrayReturn as $result) { 
    $ii++;
      
        if(!count($result)) {
          $data_genes = "N/A";
        } else {
            $gene = $result['Gene'];
            $data_genes .= " <em>$gene</em>";
            //$resultGenes .= $gene.", ";
            $resultGenes .= "<a class='highlightInfo' href='#data_".$gene."'>".$gene."</a>, ";
            $resultClass .= "found_data_".$gene." ";
            $resultGeneSearch .= $gene."|";
        }
    
    //if($ii>1) { $cssSpacer = 'padding-top-md'; } else { $cssSpacer = 'padding-none'; } 
    if($ii>1) { 
      $renderClingenHtml .= "<div class='clearfix col-sm-12'><hr></div>"; 
    } 
    
    $renderClingenHtml .= " 
    <dl class='dl-horizontal {$cssSpacer} margin-none {$resultClass}'>
      <dt class='text-sm text-muted'>HGNC Gene Symbol(s)</dt>
      <dd class='padding-bottom-xs'><strong>{$data_genes}</strong></dd>
      <dt class='text-sm text-muted'>Location</dt>
      <dd class='padding-bottom-xs'>".$result['Location']."</dd>
      <dt class='text-sm text-muted'>Haploinsufficiency</dt>
      <dd class='padding-bottom-xs'><span class='label label-success text-12px '>".$result['Haploinsufficiency_Description']."</span> <span class='text-muted'>Score: <strong>".$result['Haploinsufficiency_Score']."</strong></span></dd>
      <dt class='text-sm text-muted'>Triplosensitivity</dt>
      <dd class='padding-bottom-xs'><span class='label label-success text-12px '>".$result['Triplosensitivity_Description']."</span> <span class='text-muted'>Score: <strong>".$result['Triplosensitivity_Score']."</strong></span></dd>
      <dt class='text-sm text-muted'>Date Last Evaluated</dt>
      <dd class='padding-bottom-xs'>".$result['Date_Last_Evaluated']."</dd>
      <dt class='text-sm text-muted'>More</dt>
      <dd><a class='text-black' target='_blank' href='https://www.ncbi.nlm.nih.gov/projects/dbvar/clingen/clingen_gene.cgi?sym={$gene}&subject='>Addtional Information <i class='glyphicon glyphicon-new-window text-xs text-muted'></i></a></dd>
    "; 
     unset($data_genes);
     } 
     $renderClingenHtml .= "
    </div>
        <div class='col-sm-12 margin-padding-lg margin-top-lg'></div> ";
     }
     $renderClingenHtml .= "</div>";
     
     unset($resultClass);
     
     // Check to see if ClinGen HTML will render...
     // if so, then results are available
     if($renderClingenHtml) {
        $ResultsClingen = "true";
      }
     
     //echo "hello";
     //echo $pages->find("template=data_clinical_validity, data_gene*=PALB3");
     ?>
    
    
    
    
    
    <div class="panel-heading">
    <h3 class='padding-none margin-none'>ClinGen Summary</h3>
    <span class='text-muted'>ClinGen has uncovered information related to <strong><?=$search_terminology_label?></strong> as recently as <strong><? echo date('d/m/Y', $resultDate); ?></strong></span>
    </div>
  <div class="panel-body padding-bottom-none">
      <div class='padding-bottom-xs padding-left-xl text-sm text-muted'>Click a term and have it highlighted below and/or scroll down to the ClinGen Resources for additional information.</div>
      <dl class='dl-horizontal padding-none margin-none'>
      <? if(count($resultGenes)) { ?>
        <dt class='text-sm text-muted'>Curated Gene(s)</dt>
        <dd class='padding-bottom-xs'><? 
        
        foreach($resultGeneSearchArray as $match) {
         echo "<a class='highlightInfo' href='#data_".$match."'>".$match."</a>, ";
        }
        //echo substr($resultGenes, 0, -2); 
        
        ?></dd>
      <? } ?>
      <? if(count($resultPhenotype)) { ?>
        <dt class='text-sm text-muted'>Curated Phenotype(s)</dt>
        <dd class='padding-bottom-xs'><? echo substr($resultPhenotype, 0, -2); ?></dd>
      <? } ?>
      <? if(count($resultIdentifier)) { ?>
        <dt class='text-sm text-muted'>Curated Identifier(s)</dt>
        <dd class='padding-bottom-xs'><? echo substr($resultIdentifier, 0, -2); ?></dd>
      <? } ?>
    
    </div> 
  <div class="panel-body padding-top-none">
  <hr>
    <!--<h3 class='padding-none margin-none'>ClinGen Resources</h3>  -->
    <? echo $renderClingenHtml; ?>
    <? } ?>
    <? 
    
    // Check to see if INFOBUTTON info should show
    if($ResultsInfoButton == "true") { 
    ?>
    <div class="panel-heading"><h4 class='padding-none margin-none'>We also searched the following Genomic Resources below.</h4> <span class='text-muted'>Click "View Information" or "Open Website" to see if any results were returned.</span></div>
  <div class="panel-body">
    <? 
      //$matches = $pages->find("template=resource_web, limit=10, sort=random");
      //$matches = $dataInfoButton['feed'];
      $matches = $resourceNavData;
      foreach($matches as $match) {
        
    //foreach($match['entry'] as $submatch) {
    foreach($match['link'] as $submatch) {
      //$img_id = $match["title"]["value"][0]."_".$submatch["link"][0]['title'];
      $img_id = $match["title"]."_".$submatch["link"][0]['title'];
      $img_id = str_replace(' ', '', $img_id);
      $img_id = strtolower($img_id);
      
      $resource = $pages->find("template=resource_web|resource_list_item, label%=$img_id")->first();
        if($resource) { 
        $img_sized = $resource->image->size(200,200)->url;
        $temp_img = "<img src='{$img_sized}' class=' margin-left-lg img img-responsive img-rounded' alt='{$match->title}'>";
        } else {
          $temp_img = "<div class='text-right'><i class='glyphicon glyphicon-info-sign text-muted text-36px'></i></div>";
        }
      
      echo "<div class='row  padding-bottom-lg'><div class='col-sm-1 hidden-xs clear-left'>".$temp_img."</div>
      <div class='col-sm-11 col-xs-12'>
      <h4 class='padding-none margin-top-none border-bottom'>".$match["title"].": <span class='text-muted'>
      ".$submatch['title']."</span></h4>
      <div class='text-sm text-muted'>{$resource->summary}</div>
      <div class='text-sm text-muted margin-top-sm margin-bottom-sm'>
      
      ";
      if($match["title"] != "OMIM") { 
      echo "<button type='button' class='btn btn-primary btn-xs toggleResource' data-resourceUrl='".$submatch["href"]."'><i class='glyphicon glyphicon-arrow-down'></i> View Information</button> ";
      }
      echo " <a href='".$submatch['href']."' target='_blank' class='btn btn-default btn-xs'><i class='glyphicon glyphicon-new-window'></i> Open Website</a></div>
      
      </div>
      ";
      if($match["title"] != "OMIM") { 
      echo "
      <div class='col-sm-12 padding-none margin-nonw resourceIframeWrapper' style='display:none'>
         <iframe class='iframeSrc background-white' src='".$submatch['href']."' style='width:100%; height:600px'></iframe> 
      </div>";
      }
      echo " 
      </div>";
        }
      
      }
    ?>
  
  
        
   <?
   
   }  // Complete the INFObutton IF
   
   
   if((!$ResultsClingen && $ResultsInfoButton == "false") && !$search_curated_success) { ?>
     
     <? if(count($match_search_similar_array)) { ?>
       <div class="panel-heading">  <h3 class="padding-none margin-none">Insufficient Matches...</h3>
       
       <span class='text-muted'> We appologize, the search for <?=$search_terminology_label?> didn't provide insufficient matches. Please choose a similar match, conduct another search, or access one of the resources directly.</span>
       
       </div>
     <div class='panel-body'> 
         <dl class="dl-horizontal padding-none margin-none">
          <dt class="text-sm text-muted">Similar matches</dt>
          <dd class="padding">
            <? foreach($match_search_similar_array as $term) { 
              echo "<a href='{$page->httpUrl}?data_input=".$term ."' class='ellips col-sm-6 padding-none''>".$term ."</a>"; 
            } ?>
            </dd>
            <div class='col-sm-12 text-xs clearfix'>&nbsp;</div>
            </div>
     <? } ?>
        
   <? } 
   
 
   
   echo "</div></div>";  // Needed to close the panel
   
   // Add this variable to enhance the text below...
   $additional = "ClinGen's Directory Of ";
   } ?>
   
   
   
   
   <h2 class='page-title'><?=$additional; ?><?=$page->title; ?></h2>
    <div role="tabpanel padding-top-lg">
    
  <ul class="nav nav-tabs hidden-xs" role="tablist"> 
      
  <?
  $tabs = $page->children('sort=sort');
  $tab_first = $page->children('sort=sort')->first()->id;
  $has_parent = $page->id;
  $segmentTab = $input->urlSegment2;
  $activeTab = ($segmentTab == "" ? 'All' : $segmentTab);
  ?>
  <?
    foreach($tabs as $tab) {
      $isActive = ($tab_first == $tab->id ? 'active' : '');
      echo "<li role='presentation' class='$isActive'><a href='#{$tab->name}' aria-controls='{$tab->name}' role='tab' data-toggle='tab'  onClick=\"ga('send', 'event', 'web-list', 'tab', '{$tab->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\" >$tab->title</a></li>";
    }
    ?>
    
    <? /*
<li role="presentation" class="pull-right">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
        Contact Us
  </button>
</li>

*/ ?>
  </ul>
    <div class="row ">
     <div class="tab-content">
      <?php
  
  unset($i);
foreach($tabs as $tab) { 
 
  $isActive = ($tab_first == $tab->id ? 'active' : '');
  $tabpanelid = $tab->id;
  $tabtemplate = $tab->template->name;
  // Grabs the children for the page
  $matchesClinGen = $pages->get($tabpanelid)->children("template=resource_list_item");
  $matchesOther = $pages->get($tabpanelid)->children("template=resource_web");
  
  if($tabtemplate == "resource_list_tab") {    // checks to see if it is the ALL tab... if not grab resources that match
    $matchesClinGen = $pages->find("sort=sort, template=resource_list_item, relate_resource_list_tabs=$tabpanelid");
    $matchesOther = $pages->find("sort=sort, template=resource_web, relate_resource_list_tabs=$tabpanelid");
  }

   echo "<div role='tabpanel' class='tab-pane $isActive padding-top-none' id='$tab->name'>";
        echo "<div class='row col-sm-12'>";
			//$matches = $pages->find("sort=sort, template=resource_list_content, has_parent=$has_parent");
      echo "<div class='col-sm-12'><h5 class='text-muted border-bottom margin-top-lg margin-bottom-lg'>ClinGen Tools &amp; Resources</h5></div>";
		  foreach($matchesClinGen as $match) {
      $i++; // Increments the key
      $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
				if($match->image) {
					$img_sized = $match->image->size(200,200)->url;
         $tempimg = "<img src='{$img_sized}' class=' margin-left-lg img img-responsive img-rounded' alt='{$match->title}'>";
				} else {
         $tempimg = "";
				} 
       foreach($match->relate_resource_type as $submatch) {
         //$type_info .= "<span class='label label-default'>". $submatch->title ."</span> ";
       }
       foreach($match->relate_resource_classification as $submatch) {
         $register_info .= "<span class='label label-warning pull-right'>". $submatch->title ."</span> ";
       }
       if($match->template == "resource_list_item") {
         $clingen_resource = "<span class='label label-info pull-right'>ClinGen</span> ";
       }
       //$type_info = substr($type_info, 0, -3);
				echo "<div class='col-sm-6 {$temprow} padding-bottom-lg'>
              <div class='col-sm-2 hidden-xs padding-none'>
                 <a class='padding-top-none' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-link', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>{$tempimg} </a>
              </div>
              <div class='col-sm-9 col-xs-12  margin-left-lg padding-bottom-lg'>
                <strong>
                 <a class='text-black' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-link', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>
                    {$match->title} <span class=' glyphicon text-sm text-muted glyphicon-new-window'></span>
                 </a></strong> $register_info $clingen_resource
                    <div class='text-sm text-muted margin-top-sm'>{$match->summary}</div>
                    <div class='text-sm text-muted margin-top-sm'>{$type_info}</div>
                  
              </div>
            </div>
					";
		unset($type_info);
		unset($register_info);
		unset($clingen_resource);
			}
      
      
  unset($i);
  
  // check to see if INFOBUTTON Processed 
  
      echo "<div class='col-sm-12 '><h5 class='text-muted border-bottom margin-top-lg margin-bottom-lg'>Additional Genomic Resources</h5></div>";

      foreach($matchesOther as $match) {
      $i++; // Increments the key
      $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
				if($match->image) {
					$img_sized = $match->image->size(200,200)->url;
         $tempimg = "<img src='{$img_sized}' class=' margin-left-lg img img-responsive img-rounded' alt='{$match->title}'>";
				} else {
         $tempimg = "";
				} 
       foreach($match->relate_resource_type as $submatch) {
         //$type_info .= "<span class='label label-default'>". $submatch->title ."</span> ";
       }
       foreach($match->relate_resource_classification as $submatch) {
         $register_info .= "<span class='label label-warning pull-right'>". $submatch->title ."</span> ";
       }
       if($match->template == "resource_list_item") {
         $clingen_resource = "<span class='label label-info pull-right'>ClinGen</span> ";
       }
       //$type_info = substr($type_info, 0, -3);
				echo "<div class='col-sm-6 {$temprow} padding-bottom-lg'>
              <div class='col-sm-2 hidden-xs padding-none'>
                 <a class='padding-top-none' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-link', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>{$tempimg} </a>
              </div>
              <div class='col-sm-9 col-xs-12  margin-left-lg padding-bottom-lg'>
                <strong>
                 <a class='text-black' href='{$match->url_website}' onClick=\"ga('send', 'event', 'web-link', 'link', '{$match->title}', {'page': '{$page->path}{$input->urlSegment1}', 'nonInteraction': 1});\"  target='_blank' title='{$match->title}'>
                    {$match->title} <span class=' glyphicon text-sm text-muted glyphicon-new-window'></span>
                 </a></strong> $register_info $clingen_resource
                    <div class='text-sm text-muted margin-top-sm'>{$match->summary}</div>
                    <div class='text-sm text-muted margin-top-sm'>{$type_info}</div>
                  
              </div>
            </div>
					";
		unset($type_info);
		unset($register_info);
		unset($clingen_resource);
			}
      
		unset($tempimg);
		unset($temprow);
		unset($i);
    echo "</div>";
    echo "</div>";
  
	?>
  
  <?  }  	?>
  
  
  
  </div>
 
  </div>
</div>
</div></div>
</div>
	
<?
/*
//echo "<pre>dosageData<br>";
//      print_r($dosageData);
//echo "</pre>";

echo "<pre>Data Search: ";
echo "<br>resultGeneSearch: ";
echo $resultGeneSearch;
echo "<br>search_terminology: ";
echo $search_terminology;
echo "<br>search_terminology_success : ";
echo $search_terminology_success;
echo "<br>search_curated_success: ";
echo $search_curated_success;
echo "<br>gene_match: ";
echo $gene_match;
echo "<br>resultGeneSearchArray: ";
print_r($resultGeneSearchArray);
echo "<br>resultGeneSearchArrayReturn: ";
echo count($resultGeneSearchArrayReturn);
print_r($resultGeneSearchArrayReturn);
echo "<br>search_terminology_label: ";
echo $search_terminology_label;
echo "<br>search_definition: ";
echo $search_definition;
echo "<br>search_category: ";
echo $search_category;
echo "<br>curie_pipe: ";
echo $curie_pipe;
echo "<br>curie_arrayRaw: ";
print_r($curie_arrayRaw);
echo "<br>match_synonyms_array: ";
print_r($match_synonyms_array);
//echo "<br>resourceNavData: ";
//print_r($resourceNavData);
echo "<br>JSON search_array:<br> ";
print_r($search_array);
echo "</pre>";
//echo $data_input_encode;
//echo "<br>";
//echo $url;
echo "<pre>";
echo "data<br> ";
print_r($dataTerms);
echo "</pre>";
echo "<pre>";
echo "search_similar<br> ";
print_r($search_similar_url);
print_r($search_similar);
echo "</pre>";
echo "<pre>";
echo "graph<br>";
print_r($graph);
echo "</pre>";
echo "<pre>";
echo "neighbors<br>";
print_r($neighbors);
echo "</pre>";
echo "<pre>InfoButton<br>";
      print_r($data['feed']);
      echo "</pre>";

/*
?>

<? include("./inc/foot.php"); 


