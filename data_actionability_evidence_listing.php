<? 

      $term = $sanitizer->text($input->urlSegment1);  // Grab the variable from first
      $term = strtolower($term);                      // make everything lower case
      
      if($term) {
      //echo $term."<br>";
      if (strpos($term,'omim') !== false) {
          //echo 'omim<br>';
          if (($pos = strpos($term, "_")) !== FALSE) { 
            $termClean = substr($term, $pos+1);
          }
          // Checks to see if the omim id was found
          $results = $pages->find("template=data_actionability_evidence, data_omim*=$termClean");
      } elseif (strpos($term,'hgnc') !== false) {
          //echo 'hgnc<br>';
          if (($pos = strpos($term, "_")) !== FALSE) { 
            $termClean = substr($term, $pos+1);
          }
          
          // Checks to see if the gene was found
          $results = $pages->find("template=data_actionability_evidence, data_genes.data_gene=$termClean");
          
          // if no results then check to see if it is a HGNC ID, not term
          if(!count($results)) {
            $termClean = "HGNC:".$termClean;
            $results = $pages->find("template=data_actionability_evidence, data_genes.data_hgnc=$termClean");
          }
      }
      //echo $termClean."<br>";
      $termClean = strtoupper($termClean);                      // make everything lower case
      //echo $termClean."<br>";
      //echo $results."<br>";
      if(count($results)) {
      if(count($results>1)) { $Classification = "s"; }
      }
      
      if(($term) && (!count($results))) {
       //throw new Wire404Exception();
      }
      }
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");
?>
 
<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border"><h2 class='page-title'><?=$page->title; ?></h2>
		<span class='bodytext'><?=$page->body; ?> </span>
    
    <? if(($term) && (count($results))) { ?>
    <div class="alert alert-info" role="alert">
    <h3 class='padding-none margin-top-none'>Actionability Summary Report<?=$Classification?></h3>
    <? 
    
    foreach($results as $result) { 
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
        
        if(!$result->data_omim) {
          $data_omim = "N/A";
        } else {
          $omims = explode(",", $result->data_omim);
          foreach($omims as $omim) {
            $omim = trim($omim, " ");
            $data_omim .= " <a href='http://omim.org/entry/{$omim}' target='_blank' class='text-info'>$omim</a> ";
          }
        }
        
        if(!count($result->data_genes)) {
          $data_genes = "N/A";
        } else {
          foreach($result->data_genes as $gene) {
            $data_genes .= " <a href='http://www.genenames.org/cgi-bin/gene_symbol_report?hgnc_id={$gene->data_hgnc}' target='_blank' class='badge'> <em>$gene->data_gene</em> <i class='glyphicon glyphicon-new-window text-xs text-white'></i></a> ";
          }
        }
    ?>
    <? if($ii>1) { echo"<div class='clearfix'><hr></div>"; } ?>
    <dl class="dl-horizontal padding-none margin-none">
      <dt>HGNC Gene Symbol(s)</dt>
      <dd class="padding-bottom-xs"><?=$data_genes ?></dd>
      <dt>Disorder curated</dt> 
      <dd class="padding-bottom-xs"><?=$result->label?><div class='text-sm'><?=$data_omim ?></div></dd>
      <dt>Actionability Summary Report</dt>
      <dd><?=$files?></dd>
      <dt>Date Last Evaluated</dt>
      <dd><?=date('d/m/Y', $result->date_start)?></dd>
    </dl>
      <? 
      
      unset($data_genes);
      unset($data_omim);
      } ?>
    </div>
    
    <? } else { ?>
    
    <table class='table table-striped sortTable'>
      <tr>
        <th data-sort="string">HGNC Gene Symbol(s)</th>
        <th data-sort="string">Disorder curated</th>
        <? // <th data-sort="string">Orphanet ID</th> ?>
        <th data-sort="string">OMIM ID</th>
        <th data-sort="string">Actionability Summary Report</th>
      </tr>
    <? foreach($page->children() as $match) {
      
        unset($files);
        foreach($match->files as $file) {
          $files .= "<a href='$file->url' target='_blank' class='btn btn-xs btn-default'><i class='glyphicon glyphicon-file'></i> $file->description</a> ";
        }
        if(!$files) {
          $files = "No Reported Evidence";
        }
        
        /*
        $orphanetId = strtoupper($match->data_orphanet);
        $orphanetId = trim($orphanetId, "ORPHA");
        
        if(!$match->data_orphanet) {
          $data_orphanet = "N/A";
        } else {
          $data_orphanet = "<a href='http://www.orpha.net/consor/cgi-bin/OC_Exp.php?lng=en&Expert={$orphanetId}' target='_blank' class=''> $match->data_orphanet <i class='glyphicon glyphicon-new-window text-xs text-muted'></i></a>";
        }
        */
        if(!$match->data_omim) {
          $data_omim = "N/A";
        } else {
          $omims = explode(",", $match->data_omim);
          foreach($omims as $omim) {
          $omim = trim($omim, " ");
          $data_omim .= " <a href='http://omim.org/entry/{$omim}' target='_blank' class=''>$omim</a> ";
          }
        }
        
        if(!count($match->data_genes)) {
          $data_genes = "N/A";
        } else {
          foreach($match->data_genes as $gene) {
          $data_genes .= " <a href='http://www.genenames.org/cgi-bin/gene_symbol_report?hgnc_id={$gene->data_hgnc}' target='_blank' class='badge'> <em>$gene->data_gene</em> <i class='glyphicon glyphicon-new-window text-xs text-white'></i></a> ";
          }
        }
        
      echo"
        <tr>
          <td>$data_genes </td> 
          <td>$match->label</td> 
          ";
          // <td nowrap>$data_orphanet</td>
          echo " 
          <td>$data_omim</td>
          <td> $files</td> 
        </tr>
      ";
      
    unset($data_genes);
    unset($data_omim);
    }
    
    ?>
    </table>
   *Non-diagnostic, excludes newborn screening &amp; prenatal testing/screening 
   **Final classification upgraded after expert review
   
   <? } ?>
	</div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	


<? include("./inc/foot.php"); 

