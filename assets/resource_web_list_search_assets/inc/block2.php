<div class="col-sm-12 padding-top-lg">
<div id="infoButtonSearcherMessage">
 <div class="alert alert-success" role="alert">
    <h4>Establishing Connection With Context Search Engine...</h4>
 </div>
</div>
  <form style="display:none" class="form-search form-inline openInfoButtonSearchFilter" id="infoButtonSearcher" role="form" action="<?=$page->path ?><?=$segmentTab?>" method="post">
    <div class="input-group input-group-lg"	id="uiForOpenInfoButtonSearch">
      <input id="basics" type="text" name="EMRcontext" placeholder="Establishing Connection With Context Search Engine..." value="<?=$session->searchTerm?>" class="form-control lblue input-lg">
      <span class="input-group-btn">
      <button id="EMRcontextSearch" onclick="myApp.showPleaseWait();"	class="btn btn-primary "	type="submit"><span class='glyphicon glyphicon-search white'></span> Search</button>
      </span> </div>    <div class="text-xs text-right"> <a class="text-muted" onclick="$('#myModal2').modal('show');" href="#"><strong>Initial Release</strong>: Additional enhancements to contextual search coming soon!  Click for details!</a> </div>

<? 
  if($session->searchTerm) { 
  ?>
  <script type="text/javascript">
   document.body.onload = function() {
        ga('send', 'event', 'web-resources', 'Term', '<?=$session->searchTerm ?>', {'nonInteraction': 1});
   };
</script>
  <? } ?>
  </form>
</div>
<? 
  if($searchType == "HL7") { 
?>

<? } ?>
<? 
  // Checks to see if the data was received/saves before printing
  if($searchSuccess == "true" && $session->results == "true") { 
?>
<div class="accordion" id="myInfoAccordion">
<div class="accordion-group">
  <div class="accordion-heading">
    <div class="text-center"> <span class="img-thumbnail text-center text-muted"
												style="position: relative; top: 36px;"> <span
												class="glyphicon glyphicon-download myInfoAccordionDisplay"></span> <a
												class="accordion-toggle" data-toggle="collapse"
												data-parent="#myInfoAccordion" id='toggleSearchResults' href="#InfoResultsAccordian"> Hide/Show Search Results </a> <span
												class="glyphicon glyphicon-download myInfoAccordionDisplay"></span></span>
      <hr>
    </div>
  </div>
  <div id="InfoResultsAccordian" class="accordion-body in">
    <div class='col-sm-3'>
      <div class="panel panel-default">
        <div class="panel-heading text-bold">ClinGen Interface Search Results</div>
      <ul class="list-group">
        <? 
          // Prints the nav out
          echo $resourceNav;
        ?>
      </ul>
    </div>
    </div>
    <div class='col-sm-9'>
    
      <div class="panel panel-default">
        <div class="panel-heading text-tight"><strong class='resource_title'><?=$resourceFirstTitle ?></strong>
          <a class='resource_url_link pull-right text-muted' href='<?=$resourceFirst ?>' target='_blank'>Open In Window <span class='glyphicon glyphicon-new-window'></span></a>
        </div>
        <div class="clearfix">
          <iframe name="resourceIframe" id="resourceIframe" src='<?=$resourceFirst ?>' width="100%" height="800" style='display:none'></iframe>
          <div id='resourceLoading' class='col-sm-8 col-sm-offset-2 text-center' style='display:block'>
            <h3>Loading <span></span> Resource</h3>
            <span id='resource_message'></span>
            <div class="progress">
              <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="101" style="width: 100%"> <span class="sr-only">Loading</span></div>
            </div>
            <div class='text-center' style="display:none" id='resource_delayed'><strong>Sorry, this resource is delayed...</strong> <br /> Would you like to open <a class='resource_url_link' href='<?=$resourceFirst ?>' target='_blank'> <span class='resource_title'><?=$resourceFirstTitle ?></span> in a new window? <span class='glyphicon glyphicon-new-window'></span></a><br /><br />
            </div>
            <div class='text-center' style="display:none" id='resource_external'><strong>The <span class='resource_title'><?=$resourceFirstTitle ?></span> resource was openned in a new window.</strong> <br /> <a class='resource_url_link' href='<?=$resourceFirst ?>' target='_blank'>Would you like to re-open?  <span class='glyphicon glyphicon-new-window'></span></a><br /><br />
            </div>
          </div>
        </div>
        <div class="panel-footer text-tight"><span class="text-xs text-muted" id=''><a class='resource_url_link text-muted' href='<?=$resourceFirst ?>' target='_blank'>New Window <span class='glyphicon glyphicon-new-window'></span> : <span class="resource_url_text"><?=$resourceFirst ?></span></a></span></div>
      </div>
      <div class="text-center">
        <a onclick="$('#myModal2').modal('show');" href="#" class="img-thumbnail text-center text-muted">Initial Release: Additional enhancements to contextual search coming soon! Click for details!</a>
      </div>
    </div>
  </div>
  <? } elseif($searchSuccess == "error" && $session->results == "error") {?>
   
  <div class='clearfix'></div>
  <div class='row padding-top-lg padding-left-lg padding-right-lg'>
  <div class="alert alert-danger" role="alert">
    <h4>Search Server Maintenance Underway</h4>
    We are not able to provide a list of resources for <strong><?=$session->searchTerm?></strong> at this time.
     
</div>
<div class="text-center">
        <a onclick="$('#myModal2').modal('show');" href="#" class="img-thumbnail text-center text-muted">Initial Release: Additional enhancements to contextual search coming soon! Click for details!</a>
      </div>
</div>

  <? } elseif($searchSuccess == "true" && $session->results == "false") {?>
  
  <div class='clearfix'></div>
  <div class='row padding-top-lg padding-left-lg padding-right-lg'>
  <div class="alert alert-warning" role="alert">
    <h4>We're sorry...</h4>
    We are not able to provide a list of resources for <strong><?=$session->searchTerm?></strong> at this time.  Please try switching to a different tab, a different another term, try one of our resources below.
     
</div>
<div class="text-center">
        <a onclick="$('#myModal2').modal('show');" href="#" class="img-thumbnail text-center text-muted">Initial Release: Additional enhancements to contextual search coming soon! Click for details!</a>
      </div>
</div>
  
  <? } elseif($searchSuccess == "false") {?>
  <div class='clearfix'></div>
  <div class='row padding-top-lg padding-left-lg padding-right-lg'>
  <div class="alert alert-warning" role="alert">
    <? if(!$searchRecommendations) { ?>
    <h4>We're sorry...</h4>
    <strong><?=$session->searchTerm?></strong> was not one of the terms or didn't closely match one of the terms in our index.  Please try another term, try one of our resources, or run a non-context aware free text search at one of the following sites.<br />
    
    <a class="text-warning" href='http://www.ncbi.nlm.nih.gov/gtr/all/?term=<?=$session->searchTerm?>' target="_blank"><span class='glyphicon glyphicon-new-window'></span> GTR</a><br />
    <a class="text-warning" href='http://ghr.nlm.nih.gov/search?query=<?=$session->searchTerm?>' target="_blank"><span class='glyphicon glyphicon-new-window'></span> Genetics Home Reference</a><br />
    <a class="text-warning" href='http://www.ncbi.nlm.nih.gov/medgen/?term=<?=$session->searchTerm?>' target="_blank"><span class='glyphicon glyphicon-new-window'></span> Medgen</a><br />
    <a class="text-warning" href='https://www.pharmgkb.org/search/search.action?typeFilter=&annoFilter=&exactMatch=false&query=<?=$session->searchTerm?>' target="_blank"><span class='glyphicon glyphicon-new-window'></span> PharmGKB</a>
    

    <? } ?>
    <? if($searchRecommendations) { ?>
    <h4>Mutliple matches found...</h4>
    <strong><?=$session->searchTerm?></strong> returned many possible matches.  Please choose one of the following for additional details.    <hr/>
    <? foreach ($searchRecommendations as $result) {
        echo $result[html]; 
      }
    ?>

    <div class='clearfix'></div>
    <? } ?>
    <div class="text-center">
        <a onclick="$('#myModal2').modal('show');" href="#" class="img-thumbnail text-center text-muted">Initial Release: Additional enhancements to contextual search coming soon! Click for details!</a>
      </div>
  </div>
</div>
  <? } ?>
</div>
<!--------- end Code addition block 3 of 4 ------------>