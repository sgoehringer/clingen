
<?php 

// Output navigation for any children below the bodycopy.
// This navigation cycles through the page's children and prints
// a link and summary: 

if($showchildren != "n") {

if($page->numChildren) {

    echo "<div id='childpages'><fieldset><label>Additional {$page->title}</label><ul class='nav'>";

    foreach($page->children as $child) {
        echo "<li class='col-md-4'><p><a href='{$child->url}'>{$child->title}</a></p></li>"; 
    }

    echo "</fieldset></div></ul>";
}
}





?>


<?php 

// Output navigation for any children below the bodycopy.
// This navigation cycles through the page's children and prints
// a link and summary: 
if($showsiblings == "y") {
	include("./inc/list_sibling.php"); 
}
?>
							
				

	</div><!--/content-->


<? if($shownews != "n") { 
	//echo "<div id='footernews' class='container'>";
	//include("./inc/footer_news.php");
   // echo "</div>";
	}
?>


<div id="footer" class="container padding-top-xl">


<div id="" class="text-center visible-xs visible-sm hidden-print"><br  /><a name="footnav" id="footnav"></a>
          <?php
					// Create the top navigation list by listing the children of the homepage. 
					// If the section we are in is the current (identified by $page->rootParent)
					// then note it with <a class='on'> so we can style it differently in our CSS. 
					// In this case we also want the homepage to be part of our top navigation, 
					// so we prepend it to the pages we cycle through:		
						$homepage = $pages->get("/"); 
						$children = $homepage->children;
						// $children->prepend($homepage); 
						foreach($children as $child) {
							$class = $child === $page->rootParent ? "active" : '';
							echo "<div><a  class='btn btn-default btn-lg $class btn-block' href='{$child->url}' title='{$child->seotitle}' >{$child->title}</a></div>";
						}
						
			
				?>
        </div>

    		<div class="row">
              	<div class="col-md-4 col-sm-12 padding-sm"> 
                   <ul class="list-inline margin-none">
                      <li class='text-sm'>© <? echo date("Y"); ?> <a href="/" title="<?=$sitename_long?>" class=""><?=$sitename_long?></a> - All rights reserved</li>
                    </ul>
                </div>
				<div class="col-sm-8 padding-sm hidden-xs hidden-sm ">
				<ul class="list-inline margin-none pull-right ">
				<?php
				// Create the top navigation list by listing the children of the homepage. 
				// If the section we are in is the current (identified by $page->rootParent)
				// then note it with <a class='on'> so we can style it differently in our CSS. 
				// In this case we also want the homepage to be part of our top navigation, 
				// so we prepend it to the pages we cycle through:		
				$homepage = $pages->get("/"); 
				$children = $homepage->children;
				// $children->prepend($homepage); 
				foreach($children as $child) {
					echo "
						<li class='$class'>
							<a class='text-sm' href='{$child->url}' title='{$child->seotitle}' >{$child->title}</a>
						</li>";
					}
			?>
        <li><a  class="text-sm" href='<? echo $pages->get(1005)->url; ?>'>Site Map</a></li>
				</ul>
				</div>
            </div>
        
</div>

  


    <script src="<?php echo $config->urls->templates?>assets/js/jquery.js"></script>
	<script src="<?php echo $config->urls->templates?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo $config->urls->templates?>assets/js/bootstrap-hover-dropdown.js"></script>
	<script src="<?php echo $config->urls->templates?>assets/js/fullcalendar.min.js"></script>
	<script src="<?php echo $config->urls->templates?>assets/js/collapse.js"></script>
	<script src="<?php echo $config->urls->templates?>assets/js/transition.js"></script>
  
     
	<? /* <script src="<?php echo $config->urls->templates?>assets/js/jquery.anchor.js"></script>
	*/ ?>    
     
  
  <script type="text/javascript">
    $( ".btn_main_site_nav" ).click(function() {
		$( "#main_site_nav" ).slideToggle( "slow", function() {
			// Animation complete.
		});
	}); 
	
	
	//$( document.body ).click(function() {
	//	if ( $( "#btn_main_site_nav" ).is( ":hidden" ) ) {
	//		$( "#main_site_nav" ).slideDown( "slow" );
	//	} else {
	//		$( "#main_site_nav" ).slideUp( "slow");
	//	}
	//	});
  </script>
    

	<?php 
	 
if($user->isSuperuser()) {
	// If the page is editable, then output a link that takes us straight to the page edit screen:
	if($page->editable()) {
		echo "<a class='nav hidden-print' id='editpage' href='{$config->urls->admin}page/edit/?id={$page->id}'>Edit</a>"; 
	}


	$siblings = $pages->find("parent=$page->id")->not("title=Admin, id=1101, title=Trash");
	echo "<br /><br /><br /><br /><br /><div class='container admininfo hidden-print'>";
		echo "<fieldset><label>ADMIN - Visable Children</label><ul class='nav'>";
	
		foreach($siblings as $child) {
			echo "<li class='col-md-4'><p><a href='{$child->url}'>{$child->title}</a></p></li>"; 
		}
	
		echo "</ul></fieldset>";
		echo "</div>";
	
	$siblings = $pages->find("parent=$page->id, status=hidden")->not("title=Admin, id=1101, title=Trash");
	echo "<div class='container admininfo'>";
		echo "<fieldset><label>ADMIN - Hidden Children</label><ul class='nav'>";
	
		foreach($siblings as $child) {
			echo "<li class='col-md-4'><p><a href='{$child->url}'>{$child->title}</a></p></li>"; 
		}
	
		echo "</ul></fieldset>";
		echo "</div>";
	
	$siblings = $pages->find("parent=1, include=hidden")->not("title=Admin, id=1101, title=Trash");
	echo "<div class='container admininfo'>";
		echo "<fieldset><label>ADMIN - Root Pages (All)</label><ul class='nav'>";
	
		foreach($siblings as $child) {
			echo "<li class='col-md-4'><p><a href='{$child->url}'>{$child->title}</a></p></li>"; 
		}
	
		echo "</ul></fieldset>";
		echo "</div>";

	echo "<div class='container admininfo'>";
		echo "<fieldset><label>ADMIN - Template Info</label><ul class='nav'>";
	
			echo "<div class='row'><li class='col-md-4'><p>Template: <strong>{$page->template->name}</strong> </p></li>";
			echo "<li class='col-md-4'><p>Title: <strong>{$page->title}</strong> </p></li>";
			echo "<li class='col-md-4'><p>uri: <strong>{$page->name}</strong> </p></li>";
			echo "<li class='col-md-4'><p>ID: <strong>{$page->id}</strong> </p></li>";
			echo "<li class='col-md-4'><p>Parent: <strong>{$page->parent}</strong> </p></li>
			</div><div class='row'>";
				echo "<li class='col-md-12'><p>URL: <strong>{$page->url}</strong> </p></li>"; 
				echo "<li class='col-md-12'><p>Template: ";
							foreach($page->template->fields as $child) {
							echo "<strong>{$child->name} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> "; 
						} echo "</li>"; 
				echo "<li class='col-md-12'><p>Children: ";
							foreach($page->children as $child) {
							echo "<strong><a title='{$child->title}' href='{$child->url}'>{$child->title}  ({$child->id})</a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "; 
						} echo "</li>"; 
				echo "<li class='col-md-12'><p>Siblings: ";
							foreach($page->siblings as $child) {
							echo "<strong><a title='{$child->title}' href='{$child->url}'>{$child->title}  ({$child->id})</a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "; 
						} echo "</li>"; 
				echo "<li class='col-md-12'><p>SEO Title: <strong>{$page->seotitle}</strong> </p></li>"; 
				echo "<li class='col-md-12'><p>SEO Summary: <strong>{$page->seosummary}</strong> </p></li>
			</div>"; 
		echo "</ul></fieldset>";
		echo "</div>";
	 
}

?>


    
</body>
</html>
