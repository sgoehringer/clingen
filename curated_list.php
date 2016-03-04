<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");


// GRAB THE LOCAL GENE DOSAGE DATA
$url        = "./assets/dosage/data.json";
$json = file_get_contents($url); // this WILL do an http request for you
$dosageData = json_decode($json, true);


$data_clinical_validity           = $pages->find("template=data_clinical_validity");
$data_actionability_evidence      = $pages->find("template=data_actionability_evidence");

$resource_website = $pages->get(2796)->url;

// Grab the WG data_clinical_validity
$img_sized = $pages->get(2819)->image->size(50,50)->url;
$clinical_validity_img = "<img src='{$img_sized}' class='img img-rounded' alt='{$match->title}'>";
$clinical_validity_title = $pages->get(2819)->title;
$clinical_validity_url = $pages->get(2819)->url_website;

// Grab the WG data_clinical_actionability
$img_sized = $pages->get(2818)->image->size(50,50)->url;
$clinical_actionability_img = "<img src='{$img_sized}' class='img img-rounded' alt='{$match->title}'>";
$clinical_actionability_title = $pages->get(2818)->title;
$clinical_actionability_url = $pages->get(2818)->url_website;

// Grab the WG dosage_sensitivity
$img_sized = $pages->get(2808)->image->size(50,50)->url;
$dosage_sensitivity_img = "<img src='{$img_sized}' class='img img-rounded' alt='{$match->title}'>";
$dosage_sensitivity_title = $pages->get(2808)->title;
$dosage_sensitivity_url = $pages->get(2808)->url_website;

$match_genes_array = array();
foreach($data_clinical_validity as $match) {
  $gene = strtoupper($match->data_gene);
  if(!$match_genes_array[$gene]['validity']) {
    $match_genes_array[$gene]['validity'] = "false";
  }
  if(!$match_genes_array[$gene]['actionability']) {
    $match_genes_array[$gene]['actionability'] = "false";
  }
  if(!$match_genes_array[$gene]['dosage']) {
    $match_genes_array[$gene]['dosage'] = "false";
  }
  $match_genes_array[$gene]['gene'] = $match->data_gene;
  $match_genes_array[$gene]['validity'] = "true";
  foreach($match->relate_classification_gene_curation as $item) {
    $match_genes_array[$gene]['classification']['validity'][] = $item->title;
  }
}
foreach($data_actionability_evidence as $matches) {
  foreach($matches->data_genes as $match) {
  $gene = strtoupper($match->data_gene);
    if(!$match_genes_array[$gene]['validity']) {
      $match_genes_array[$gene]['validity'] = "false";
    }
    if(!$match_genes_array[$gene]['actionability']) {
      $match_genes_array[$gene]['actionability'] = "false";
    }
    if(!$match_genes_array[$gene]['dosage']) {
      $match_genes_array[$gene]['dosage'] = "false";
    }
    $match_genes_array[$gene]['gene'] = $match->data_gene;
    $match_genes_array[$gene]['actionability'] = "true";
  }
}
foreach($dosageData as $match) {
  $gene = strtoupper($match['Gene']);
  if(!$match_genes_array[$gene]['validity']) {
    $match_genes_array[$gene]['validity'] = "false";
  }
  if(!$match_genes_array[$gene]['actionability']) {
    $match_genes_array[$gene]['actionability'] = "false";
  }
  if(!$match_genes_array[$gene]['dosage']) {
    $match_genes_array[$gene]['dosage'] = "false";
  }
  $match_genes_array[$gene]['gene'] = $gene;
  $match_genes_array[$gene]['dosage'] = "true";
  
  $match_genes_array[$gene]['classification']['dosage']['haploinsufficiency'] = $match['Haploinsufficiency Description'];
  //if($match['Haploinsufficiency Description'] != $match['Triplosensitivity Description']) {
  $match_genes_array[$gene]['classification']['dosage']['triplosensitivity'] = $match['Triplosensitivity Description'];
  //  $dosage_match = "true";
  //}
  //if(($dosage_match == "true") && ($match['Triplosensitivity Description'] == "No evidence available")) {
  //  unset($match_genes_array[$gene]['classification']['dosage']['triplosensitivity']);
  //}
  unset($dosage_match);
}

//$match_genes_array = array_unique($match_genes_array);
ksort($match_genes_array);
$match_genes_array = array_values($match_genes_array);

$match_phenotypes_array = array();
foreach($data_clinical_validity as $match) {
  $name = ucwords($match->label);
  $unqiue = $sanitizer->name($name);
  $omim = $match->data_omim.", ";
  if(!$match_phenotypes_array[$unqiue]['validity']) {
    $match_phenotypes_array[$unqiue]['validity'] = "false";
  }
  if(!$match_phenotypes_array[$unqiue]['actionability']) {
    $match_phenotypes_array[$unqiue]['actionability'] = "false";
  }
  $match_phenotypes_array[$unqiue]['phenotype'] = $name;
  $match_phenotypes_array[$unqiue]['omim'] = $omim;
  $match_phenotypes_array[$unqiue]['validity'] = "true";
  foreach($match->relate_classification_gene_curation as $item) {
    $match_phenotypes_array[$unqiue]['classification']['validity'][] = $item->title;
  }
}
foreach($data_actionability_evidence as $match) {
  $name = ucwords($match->label);
  $unqiue = $sanitizer->name($name);
  //foreach($match->data_omim as $item) {
  //  $omim .= $item." ,";
  //}
  $omim = $match->data_omim.", ";
  if(!$match_phenotypes_array[$unqiue]['validity']) {
    $match_phenotypes_array[$unqiue]['validity'] = "false";
  }
  if(!$match_phenotypes_array[$unqiue]['actionability']) {
    $match_phenotypes_array[$unqiue]['actionability'] = "false";
  }
  $match_phenotypes_array[$unqiue]['phenotype'] = $name;
  $match_phenotypes_array[$unqiue]['omim'] = $omim;
  $match_phenotypes_array[$unqiue]['actionability'] = "true";
}

ksort($match_phenotypes_array);
$match_phenotypes_array = array_values($match_phenotypes_array); 
?>

<div class="row">
	<div class="col-sm-12">
	<div class="content-space content-border"><h2 class='page-title'><?=$page->title; ?></h2>
		<span class='bodytext'><?=$page->body; ?> </span>
    
<div class="pagination-tab-wrapper">
              <nav class="text-center">
                <ul class="pagination pagination-sm margin-bottom-sm" role="tablist">
            <li role="presentation" class="active"><a href="#Genes" aria-controls="Genes" role="tab" data-toggle="tab">Curated Genes <span class="badge text-9px"><? echo count($match_genes_array)?></span></a></li>
            <li role="presentation"><a href="#Phenotypes" aria-controls="Phenotypes" role="tab" data-toggle="tab">Curated Diseases <span class="badge text-9px"><? echo count($match_phenotypes_array)?></span></a></li>
          </ul>
</nav>
</div>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="Genes">      
      <table class="table table-striped table-hover table-condensed text-center">
        <tr>
          <td class="col-sm-2 background-white" style="border-top:none"></td>
          <td style="border-top:none" class="col-sm-2 text-center background-white text-sm"><a href='<?=$clinical_validity_url?>' title='<?=$clinical_validity_title?>'><?=$clinical_validity_img?><div><?=$clinical_validity_title?></div></a></td>
          <td style="border-top:none" class="col-sm-2 text-center background-white text-sm"><a href='<?=$dosage_sensitivity_url?>' title='<?=$clinical_actionability_title?>'><?=$clinical_actionability_img?><div><?=$clinical_actionability_title?></div></a></td>
          <td style="border-top:none" class="col-sm-3 text-center background-white text-sm"><a href='<?=$dosage_sensitivity_url?>' title='<?=$dosage_sensitivity_title?>'><?=$dosage_sensitivity_img?><div><?=$dosage_sensitivity_title?> - Haploinsufficiency</div></a></td>
          <td style="border-top:none" class="col-sm-3 text-center background-white text-sm"><a href='<?=$dosage_sensitivity_url?>' title='<?=$dosage_sensitivity_title?>'><?=$dosage_sensitivity_img?><div><?=$dosage_sensitivity_title?> - Triplosensitivity</div></a></td>
        </tr>
      <? foreach ($match_genes_array as $match) { ?>
        <tr>
          <td class='text-left'><a class='btn btn-xs btn-default pull-right' href='<?=$resource_website?>?data_input=<?=$match['gene']?>&data_curated=<?=$match['gene']?>' data-toggle="tooltip" data-placement="top" title="Search <?=$match['gene']?>"><i class='glyphicon glyphicon-search'></i></a><a href='<?=$resource_website?>?data_input=<?=$match['gene']?>&data_curated=<?=$match['gene']?>'><?=$match['gene']?></a></td>
          <td class='border-left'>
            <? if($match['validity'] == "true") { ?>
              <? foreach ($match['classification']['validity'] as $item) { ?>
                <a class='btn-width-200 btn btn-xs btn-success' title='<?=$item?> :: <?=$match['gene']?> - <?=$clinical_validity_title?>' href='<?=$resource_website?>?data_input=<?=$match['gene']?>&data_curated=<?=$match['gene']?>' data-toggle="tooltip" data-placement="top"><i class='glyphicon glyphicon-info-sign text-white'></i> <?=$item?></a>
              <? } ?>
            <? } ?>
          </td>
          <td class='border-left'>
            <? if($match['actionability'] == "true") { ?>
            <a class='btn-width-200 btn btn-xs btn-success' title='<?=$match['gene']?> - <?=$clinical_actionability_title?>' href='<?=$resource_website?>?data_input=<?=$match['gene']?>&data_curated=<?=$match['gene']?>' data-toggle="tooltip" data-placement="top"><i class='glyphicon glyphicon-info-sign text-white'></i> Summary Available</a>
            <? } ?>
          </td>
          <td class='border-left'>
            <? if($match['dosage'] == "true") { ?>
            <? //foreach ($match['classification']['dosage']['haploinsufficiency'] as $key => $item) { ?>
                <a class='btn-width-200 btn btn-xs btn-success' title='<?=ucwords($match['classification']['dosage']['haploinsufficiency'])?> - <?=$match['classification']['dosage']['haploinsufficiency']['gene']?> - <?=$dosage_sensitivity_title?>' href='<?=$resource_website?>?data_input=<?=$match['classification']['dosage']['haploinsufficiency']['gene']?>&data_curated=<?=$match['classification']['dosage']['haploinsufficiency']['gene']?>' data-toggle="tooltip" data-placement="top"><i class='glyphicon glyphicon-info-sign text-white'></i>  <?=$match['classification']['dosage']['haploinsufficiency']?></a>

              <? //} ?>
            <? } ?>
          </td>
          <td class='border-left'>
            <? if($match['dosage'] == "true") { ?>
            <? //foreach ($match['classification']['dosage']['haploinsufficiency'] as $key => $item) { ?>
                <a class='btn-width-200 btn btn-xs btn-success' title='<?=ucwords($match['classification']['dosage']['triplosensitivity'])?> - <?=$match['classification']['dosage']['haploinsufficiency']['gene']?> - <?=$dosage_sensitivity_title?>' href='<?=$resource_website?>?data_input=<?=$match['classification']['dosage']['triplosensitivity']['gene']?>&data_curated=<?=$match['classification']['dosage']['triplosensitivity']['gene']?>' data-toggle="tooltip" data-placement="top"><i class='glyphicon glyphicon-info-sign text-white'></i>  <?=$match['classification']['dosage']['triplosensitivity']?></a>

              <? //} ?>
            <? } ?>
          </td>
        </tr>
      <? } ?> 
      </table>
      
      </div>
      <div role="tabpanel" class="tab-pane" id="Phenotypes">
      
      <table class="table table-striped table-hover table-condensed text-center">
        <tr>
          <td class="col-sm-6 background-white" style="border-top:none"></td>
          <td style="border-top:none" class="col-sm-3 text-center background-white text-sm"><a href='<?=$clinical_validity_url?>' title='<?=$clinical_validity_title?>'><?=$clinical_validity_img?><div><?=$clinical_validity_title?></div></a></td>
          <td style="border-top:none" class="col-sm-3 text-center background-white text-sm"><a href='<?=$clinical_actionability_url?>' title='<?=$clinical_actionability_title?>'><?=$clinical_actionability_img?><div><?=$clinical_actionability_title?></div></a></td>
        </tr>
      <? foreach ($match_phenotypes_array as $match) { ?>
        <tr>
          <td class='text-left'><a class='btn btn-xs btn-default pull-right' href='<?=$resource_website?>?data_input=<?=$match['phenotype']?>&data_curated=<?=$match['phenotype']?>'><i class='glyphicon glyphicon-search'></i></a><a href='<?=$resource_website?>?data_input=<?=$match['phenotype']?>&data_curated=<?=$match['phenotype']?>' data-toggle="tooltip" data-placement="top" title='Search <?=$match['phenotype']?>'><?=$match['phenotype']?></a>
          <? if(substr($match['omim'], 0, -2)) { ?>
            <div class='text-xs text-muted'>OMIM: <? echo substr($match['omim'], 0, -2); ?>
          <? } ?>
          </div></td>
          <td class='border-left'>
            <? if($match['validity'] == "true") { ?>
              <? foreach ($match['classification']['validity'] as $item) { ?>
                <a class='btn btn-xs btn-success' title='<?=$item?> :: <?=$match['phenotype']?> - <?=$clinical_validity_title?>' href='<?=$resource_website?>?data_input=<?=$match['phenotype']?>&data_curated=<?=$match['phenotype']?>' data-toggle="tooltip" data-placement="top"><i class='glyphicon glyphicon-info-sign text-white'></i> Summary Available <?=$item?></a>
              <? } ?>
            <? } ?>
          </td>
          <td class='border-left'>
            <? if($match['actionability'] == "true") { ?>
            <a class='btn btn-xs btn-success'  title='<?=$match['phenotype']?> - <?=$clinical_actionability_title?>'  href='<?=$resource_website?>?data_input=<?=$match['phenotype']?>&data_curated=<?=$match['phenotype']?>' data-toggle="tooltip" data-placement="top"><i class='glyphicon glyphicon-info-sign'></i></a>
            <? } ?>
          </td>
        </tr>
      <? } ?>
      </table>
      
      </div>
    </div>

    
    
    
	</div></div>
</div>

<? //print_r($dosageData); ?> 
	

<? include("./inc/foot.php"); 

