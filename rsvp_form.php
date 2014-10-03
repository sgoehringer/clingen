<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";

	$image = $page->image;
		if ($image) {
			$img_sized = $image->size(600);
			$img = "<div class='pull-right col-sm-4'>
						<img src='{$img_sized->url}' class='img-responsive thumbnail hidden-sm hidden-xs' alt='{$page->image->description}'>
					</div>";
		} 



// Check to be sure the form was submitted
if($input->post->submit_rsvp) {
  
  	
	// Sanitize everything (well, almost everything
	$inputFirstName         = $sanitizer->text($input->post->inputFirstName);
	$inputLastName          = $sanitizer->text($input->post->inputLastName);
	$inputTitle             = $sanitizer->text($input->post->inputTitle);
	$inputInstitution       = $sanitizer->text($input->post->inputInstitution);
	$inputEmail             = $sanitizer->email($input->post->inputEmail);
  $inputRSVPID            = date(U)."-".bin2hex(openssl_random_pseudo_bytes(3));
  $inputRSVPDate          = date("m.d.y g:i a");
  
  $inputdata              = $inputFirstName." #### ".$inputLastName." #### ".$inputTitle." #### ".$inputInstitution." #### ".$inputEmail." #### ".$inputRSVPID." #### ".$inputRSVPDate;
  
	// Don't sanatize this... it would change it
	// $usr_email = $sanitizer->email($input->post->pass);
	
	// Error Checking
	if (empty($inputFirstName) || empty($inputLastName) || empty($inputTitle) || empty($inputInstitution) || empty($inputEmail)) {
					$message = "error";
	}
	
	// Now Process to be sure it works
	else {
	
        // Create RSPV
        $t = new Page();
        $t->template            = $templates->get("rsvp_data");
        $t->parent              = $pages->get("2116");  //$pages->get("2071"); 
        $t->title               = $inputRSVPID." - ".$inputFirstName." ".$inputLastName;
        $t->name                = $inputRSVPID;
        $t->relate_page         = $page->id;
        $t->summary             = $inputdata;
        $t->save();
  
        $message = "success";
	}
}





if($input->post->csv_download) {
  
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=rsvp_list_download.csv");
header("Pragma: no-cache");
header("Expires: 0");
$rsvps = $pages->find("template=rsvp_data, relate_page=$page->id"); 
          foreach($rsvps as $rsvp) {
            $replaced = str_replace("####", ",", "$rsvp->summary");
            echo "$replaced\n";
          }
          exit;
}




include("./inc/head.php");
?>

<div class="row">
	<div class="col-sm-9">
	<div class="content-space content-border">
  <? if($message == "success") { ?>
  
    <?
      $rsvps = count($pages->find("template=rsvp_data, relate_page=$page->id"));
      //echo $rsvps;
      if($rsvps > $page->var) { ?>  
      <div class="alert alert-warning" role="alert"><strong><?=$page->summary; ?></strong><br />RSVP ID: <?=$inputRSVPID?></div>
    <? } else { ?>
      <div class="alert alert-success" role="alert"><?=$page->body_secondary; ?><br />RSVP ID: <?=$inputRSVPID?></div>
    <? } ?>
  <? } else if ($message == "error") { ?>
      <div class="alert alert-error" role="alert"><strong>Oops...</strong> Something does not look correct, please try again.</div>
  <? } ?>
		<?=$img; ?>
		<span class='bodytext'><?=$page->body; ?> </span>
    
    <div class="clearfix"> </div>
    
    <div class="panel panel-default">
      <div class="panel-body">

        <form role="form" action="" enctype="multipart/form-data" method="post">
          <div class="form-group col-sm-6">
            <label for="inputFirstName">First Name</label>
            <input type="text" class="form-control" required id="inputFirstName" value="<?=$inputFirstName?>" name="inputFirstName" placeholder="First Name">
          </div>
          <div class="form-group col-sm-6">
            <label for="inputLastName">Last Name</label>
            <input type="text" class="form-control" required id="inputLastName" name="inputLastName" value="<?=$inputLastName?>" placeholder="Last Name">
          </div>
          <div class="form-group col-sm-6">
            <label for="inputTitle">Title</label>
            <input type="text" class="form-control" required id="inputTitle" name="inputTitle" value="<?=$inputTitle?>" placeholder="Title">
          </div>
          <div class="form-group col-sm-6">
            <label for="inputInstitution">Institution</label>
            <input type="text" class="form-control" required id="inputInstitution" name="inputInstitution" value="<?=$inputInstitution?>" placeholder="Institution">
          </div>
          <div class="form-group col-sm-12">
            <label for="inputEmail">Email Address</label>
            <input type="email" class="form-control" required id="inputEmail" name="inputEmail" value="<?=$inputEmail?>" placeholder="Email Address">
          </div>
          <div class="form-group col-sm-12">
          <button type="submit" class="btn btn-primary">Send Request</button>
          <input type="hidden" name='submit_rsvp' value="submit_rsvp" />
          </div>
        </form>
        
      </div>
    </div>
    
    
<?php if($user->isSuperuser()) { ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <form role="form" action="" enctype="multipart/form-data" method="post">
        
        
          <button type="submit" formtarget="_blank" class="btn btn-primary btn-xs pull-right text-xs">Download List</button>
          <input type="hidden" name='csv_download' value="csv_download" />
          <h3 class="panel-title">RSVP List - Admin View</h3>
          </form>
      </div>
      <div class="panel-body">
        <table class="table table-condensed table-striped text-xs">
        <? $rsvps = $pages->find("template=rsvp_data, relate_page=$page->id"); 
          foreach($rsvps as $rsvp) {
            $replaced = str_replace("####", "</td><td>", "$rsvp->summary");
            echo "<tr><td>$replaced</td></tr>";
          }
        
        ?>
        </table>
      </div>
    </div>
<? } ?>
	</div></div>
	<? include("./inc/nav_well.php"); ?>
</div>
	

<? include("./inc/foot.php"); 

