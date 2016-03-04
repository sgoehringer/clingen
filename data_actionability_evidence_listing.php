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
    <a href="#sqm" class='pull-right text-xs text-muted'>Semi-quantitative Metric (SQM) Scoring Methology </a>
    <table class='table table-bordered sortTable text-sm'>
      <tr class="">
        <th class='text-sm text-muted col-sm-2' data-sort="string">Disorder curated</th>
        <th class='text-sm text-muted col-sm-2' data-sort="string">HGNC Gene Symbol(s)</th>
        <th class='text-sm text-muted col-sm-3' data-sort="string"><a href="#sqm">Outcome/ Intervention Pair</a></th>
        <th class='text-sm text-muted col-sm-1' data-sort="string"><a href="#sqm">Severity</a></th>
        <th class='text-sm text-muted col-sm-1' data-sort="string"><a href="#sqm">Likelihood</a></th>
        <th class='text-sm text-muted col-sm-1' data-sort="string"><a href="#sqm">Effectiveness</a></th>
        <th class='text-sm text-muted col-sm-1' data-sort="string"><a href="#sqm">Nature of the Intervention</a></th>
        <th class='text-sm text-muted col-sm-1' data-sort="string"><a href="#sqm">Total</a></th>
      </tr>
    <? foreach($page->children() as $match) {
      
        unset($files);
        foreach($match->files as $file) {
          $files .= "<a href='$file->url' target='_blank' class='btn btn-xs btn-default'><i class='glyphicon glyphicon-file'></i>  Report</a> ";
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
          $data_omim .= " <a href='http://omim.org/entry/{$omim}' target='_blank' class='text-muted'>$omim</a> ";
          }
        }
        
        if(!count($match->data_genes)) {
          $data_genes = "N/A";
        } else {
          foreach($match->data_genes as $gene) {
          $data_genes .= " <a href='http://www.genenames.org/cgi-bin/gene_symbol_report?hgnc_id={$gene->data_hgnc}' target='_blank' class='text-black'> <em>$gene->data_gene</em> </a> ";
          }
        }
      
      unset($i);
      foreach($match->data_actionability_score as $item) {
        $rows = count($match->data_actionability_score);
        $score_var = explode(",", $item->var);
        $i++;
        if($i == "1") {
            echo"<tr style='border-top: 3px double #ccc;'>";
            echo "<td rowspan='$rows'>$match->label<div class='text-xs text-muted'>OMIM: $data_omim</div> $files</td> 
            <td rowspan='$rows'>$data_genes</td>  
            ";
        } else {
        echo"<tr>";
        }
        echo "
            <td class=''>".$item->label."</td> 
            <td>".$score_var[0]."</td>  
            <td>".$score_var[1]."</td>  
            <td>".$score_var[2]."</td> 
            <td>".$score_var[3]."</td> 
            <td>".$score_var[4]."</td> 
          </tr>
      ";
      }
      
    unset($data_genes);
    unset($data_omim);
    }
    
    ?>
    </table>
   *Non-diagnostic, excludes newborn screening &amp; prenatal testing/screening 
   **Final classification upgraded after expert review
   
   <? } ?>
   <hr />
   <h3 id="sqm">Semi-quantitative Metric (SQM)</h3>
   <table class='table table-striped'>
     <tr height="29">
       <td height="29" width="88"><p>Category</p></td>
       <td width="330"><p>Levels</p></td>
       <td width="204"><p>Level of Evidence</p></td>
     </tr>
     <tr height="84">
       <td height="84" width="88"><p>Severity</p></td>
       <td width="330"><p>3 - sudden death</p>
         <p>2 - possible death or major morbidity</p>
         <p>1 -  modest morbidity</p>
         <p>0 - minimal or no morbidity</p></td>
       <td width="204"><p>NA</p></td>
     </tr>
     <tr height="103">
       <td height="103" width="88"><p>Likelihood of Disease</p></td>
       <td width="330"><p>3 - &gt;40% chance</p>
         <p>2 - 5-39% chance</p>
         <p>1 - 1-4% chance</p>
         <p>0 - &lt;1% chance or unknown</p></td>
       <td width="204"><p>A = substantial evidence</p>
         <p>B = moderate evidence</p>
         <p>C = minimal evidence</p>
         <p>D = poor evidence</p>
         <p>E = expert contributed evidence</p></td>
     </tr>
     <tr height="103">
       <td height="103" width="88"><p>Efficacy of Intervention</p></td>
       <td width="330"><p>3 - highly effective<br>
         2 - moderately effective<br>
         1 - minimally effective</p>
         <p>0 - ineffective/no intervention</p>
         <p>IN* – ineffective/no intervention</p></td>
       <td width="204"><p>A = substantial evidence</p>
         <p>B = moderate evidence</p>
         <p>C = minimal evidence</p>
         <p>D = poor or conflicting evidence</p>
         <p>E = expert contributed evidence</p></td>
     </tr>
     <tr height="142">
       <td height="142" width="88"><p>Nature of Intervention</p></td>
       <td width="330"><p>3 - low risk/medically acceptable/ low   intensity intervention</p>
         <p>2 - moderately acceptable/risk/   intensive interventions</p>
         <p>1 - greater risk/less acceptable/   substantial interventions</p>
         <p>0 - high risk/poor acceptable/   intensive or no intervention</p></td>
       <td width="204"><p>NA</p></td>
     </tr>
   </table>
	</div></div>
<? include("./inc/nav_well_workinggroup.php"); ?>
</div>
	


<? include("./inc/foot.php"); 

