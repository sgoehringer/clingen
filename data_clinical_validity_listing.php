<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>
 
<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border"><h2 class='page-title'><?=$page->title; ?></h2>
		<span class='bodytext'><?=$page->body; ?> </span>
    
    <? 
      $term = $sanitizer->text($input->urlSegment1);  // Grab the variable from first
      $term = strtolower($term);                      // make everything lower case
      //echo $term."<br>";
      if (strpos($term,'omim') !== false) {
          //echo 'omim<br>';
          if (($pos = strpos($term, "_")) !== FALSE) { 
            $termClean = substr($term, $pos+1);
          }
          // Checks to see if the omim id was found
          $results = $pages->find("template=data_clinical_validity, data_omim=$termClean");
      } elseif (strpos($term,'orphanet') !== false) {
          //echo 'orphanet<br>';
          if (($pos = strpos($term, "_")) !== FALSE) { 
            $termClean = substr($term, $pos+1);
          } 
          // Checks to see if the orphanet id was found
          $results = $pages->find("template=data_clinical_validity, data_orphanet=$termClean");
      } elseif (strpos($term,'hgnc') !== false) {
          //echo 'hgnc<br>';
          if (($pos = strpos($term, "_")) !== FALSE) { 
            $termClean = substr($term, $pos+1);
          }
          
          // Checks to see if the gene was found
          $results = $pages->find("template=data_clinical_validity, data_gene=$termClean");
          
          // if no results then check to see if it is a HGNC ID, not term
          if(!count($results)) {
            $termClean = "HGNC:".$termClean;
            $results = $pages->find("template=data_clinical_validity, data_hgnc=$termClean");
          }
      }
      //echo $termClean."<br>";
      $termClean = strtoupper($termClean);                      // make everything lower case
      //echo $termClean."<br>";
      //echo $results."<br>";
      
      if(count($results)) {
      if(count($results>1)) { $Classification = "s"; }
    ?>
    <div class="alert alert-info" role="alert">
    <h3 class='padding-none margin-top-none'>Clinical Validity Classification<?=$Classification?></h3>
    <? foreach($results as $result) { 
    $ii++;
      $orphanetId = strtoupper($result->data_orphanet);
      $orphanetId = trim($orphanetId, "ORPHA");
      
      unset($files);
        foreach($result->files as $file) {
          $files .= "<a href='$file->url' target='_blank' class='btn btn-xs btn-default'><i class='glyphicon glyphicon-file'></i> $file->description</a> ";
        }
        
        if(!$files) {
          $files = "No Reported Evidence";
        }
        
        if(!$result->data_orphanet) {
          $data_orphanet = "Orphanet: N/A";
        } else {
          $data_orphanet = "<a href='http://www.orpha.net/consor/cgi-bin/OC_Exp.php?lng=en&Expert={$orphanetId}' target='_blank' class='text-info'>Orphanet: $result->data_orphanet <i class='glyphicon glyphicon-new-window text-xs'></i></a>";
        }
        
        if(!$result->data_omim) {
          $data_omim = "OMIM: N/A";
        } else {
          $data_omim = "<a href='http://omim.org/entry/{$result->data_omim}' target='_blank' class='text-info'>OMIM: $result->data_omim <i class='glyphicon glyphicon-new-window text-xs'></i></a>";
        }
    ?>
    <? if($ii>1) { echo"<div class='clearfix'><hr></div>"; } ?>
    <dl class="dl-horizontal padding-none margin-none">
      <dt>HGNC Gene Symbol</dt>
      <dd class="padding-bottom-xs"><a href="http://www.genenames.org/cgi-bin/gene_symbol_report?hgnc_id=<?=$result->data_hgnc?>" target="_blank" class="text-info"><em><?=$result->data_gene?></em> <i class="glyphicon glyphicon-new-window text-xs"></i></a></dd>
      <dt>Disease curated</dt> 
      <dd class="padding-bottom-xs"><?=$result->label?><div class='text-sm'><?=$data_orphanet ?> &nbsp;&nbsp;|&nbsp;&nbsp; <?=$data_omim ?></div></dd>
      <dt>Classifications &amp; Files</dt>
      <dd><?=$files?></dd>
    </dl>
      <? } ?>
    </div>
    
    <? } else { ?>
    
    <table class='table table-striped'>
      <tr>
        <th>HGNC Gene Symbol</th>
        <th>Disease curated</th>
        <th>Orphanet ID</th>
        <th>OMIM ID</th>
        <th>Clinical Validity Classification</th>
      </tr>
    <? foreach($page->children() as $match) {
      
        unset($files);
        foreach($match->files as $file) {
          $files .= "<a href='$file->url' target='_blank' class='btn btn-xs btn-default'><i class='glyphicon glyphicon-file'></i> $file->description</a> ";
        }
        if(!$files) {
          $files = "No Reported Evidence";
        }
        $orphanetId = strtoupper($match->data_orphanet);
        $orphanetId = trim($orphanetId, "ORPHA");
        
        if(!$match->data_orphanet) {
          $data_orphanet = "N/A";
        } else {
          $data_orphanet = "<a href='http://www.orpha.net/consor/cgi-bin/OC_Exp.php?lng=en&Expert={$orphanetId}' target='_blank' class=''> $match->data_orphanet <i class='glyphicon glyphicon-new-window text-xs text-muted'></i></a>";
        }
        
        if(!$match->data_omim) {
          $data_omim = "N/A";
        } else {
          $data_omim = "<a href='http://omim.org/entry/{$match->data_omim}' target='_blank' class=''>$match->data_omim <i class='glyphicon glyphicon-new-window text-xs text-muted'></i></a>";
        }
        
      echo"
        <tr>
          <td><a href='http://www.genenames.org/cgi-bin/gene_symbol_report?hgnc_id={$match->data_hgnc}' target='_blank' class=''> <em>$match->data_gene</em> <i class='glyphicon glyphicon-new-window text-xs text-muted'></i></a></td> 
          <td>$match->label</td>
          <td nowrap>$data_orphanet</td>
          <td nowrap>$data_omim</td>
          <td> $files</td> 
        </tr>
      ";
      
    }
    ?>
    </table>
   *Final classification upgraded after expert review
   <? } ?>
	</div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

