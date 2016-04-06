
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


<div id="footer" class="container  background-trans padding-top-xl">


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
                <div id="footer_disclaimer" class="col-md-12 text-sm text-muted">
                  <hr />
                  The information on this website is not intended for direct diagnostic use or medical decision-making without review by a genetics professional. Individuals should not change their health behavior solely on the basis of information contained on this website. If you have questions about the information contained on this website, please see a health care professional.
                  <hr />
                </div>
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
  
  $( "#toggle_button_Identifiers" ).click(function() {
    $( "#toggle_Identifiers" ).slideToggle( "slow", function() {
      // Animation complete.
    });
  });
  $( "#toggle_button_synonyms" ).click(function() {
    $( "#toggle_synonyms" ).slideToggle( "slow", function() {
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
	
	// Supports the ability to add tab code to url and have it show
	 var hash = window.location.hash;
	  hash && $('ul.nav a[href="' + hash + '"]').tab('show');
	  $('.nav-tabs a').click(function (e) {
	    $(this).tab('show');
	    var scrollmem = $('body').scrollTop();
	    window.location.hash = this.hash;
	    $('html,body').scrollTop(scrollmem);
	  });
    
    
    function UpdateTableHeaders() {
   $(".persist-area").each(function() {
   
       var el             = $(this),
           offset         = el.offset(),
           scrollTop      = $(window).scrollTop(),
           floatingHeader = $(".floatingHeader", this)
       
       if ((scrollTop > offset.top) && (scrollTop < offset.top + el.height())) {
           floatingHeader.css({
            "visibility": "visible"
           });
       } else {
           floatingHeader.css({
            "visibility": "hidden"
           });      
       };
   });
}


    
  </script>
  
  

  <?
  if($page->template->name == "resource_web_list_search") {
    include("./assets/resource_web_list_search_assets/inc/block-foot.php"); 
  } else {
    
?>
    

	<script src="<?php echo $config->urls->templates?>assets/js/typeahead.bundle.js"></script>    
    <script>
    
    (function($, global, undefiend) {
    $.removeElementFromCollection = function(collection,key) {
        // if the collections is an array
        if(collection instanceof Array) {
            // use jquery's `inArray` method because ie8 
            // doesn't support the `indexOf` method
            if($.inArray(key, collection) != -1) {
                collection.splice($.inArray(key, collection), 1);
            }
        }
        // it's an object
        else if(collection.hasOwnProperty(key)) {
            delete collection.key;
        }
    
        return collection;
    };
    })(jQuery, window); 
    
  var data = new Bloodhound({
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  datumTokenizer: Bloodhound.tokenizers.whitespace,
  //prefetch: 'http://54.146.173.15:9000/scigraph/vocabulary/autocomplete/brca',
  remote: {
    //url: '<?=$termonologyService?>vocabulary/autocomplete/%QUERY?limit=100', 
    //&prefix=DOID
    url: '<?=$termonologyService?>vocabulary/autocomplete/%QUERY?limit=100&prefix=OMIM&prefix=NCBIGene&prefix=Orphanet',
    wildcard: '%QUERY',
    filter: function (data) {
      
            var trim = "null";                          // set the trim var to something
            var terms = [];                             // define the array to hold the suitable terms
            $.each(data, function (index, value) {      // start the each loop to go through the data array
              var lastChecker = trim;                   // defines the lastchecked match with the trim val
              
              trim  = value.completion.toLowerCase();   // take the term and make it lowercase
              trim  = trim.replace(/-/g, '');            // remove the -
              trim  = trim.replace(/,/g, '');           // remove the ,
              trim  = trim.replace(/;/g, '');           // remove the ;
              trim  = trim.replace(/\s/g,'');           // remove the <space>
              curie = value.concept.curie.substring(0, value.concept.curie.indexOf(':'));
              
              temparray = {                             // start building a new array
                //completion : value.completion + ' [' + value.concept.categories + ' - ' + curie + ']',  // the display term
                completion : value.completion + ' [' + value.concept.categories + ']',  // the display term
                synonyms : value.concept.synonyms,      // store the sysnoyms
                categories : value.concept.categories,  // store the categories
                //checker : trim,                          // store the trimmed value
                //curie : curie              // store the trimmed value
                };
              count = value.concept.categories.length;  // count how many categories
              
              // check to make sure its not a prior used term at a category is assigned
              if((lastChecker != trim) && (count > 0) && (curie != 'HP') && (curie != 'MP') && (curie != 'UBERON') ) {      
                terms.push(temparray);
              }
              //console.log('last      ' + lastChecker);
              console.log('curie   ' + curie);
            });
            
            console.log(data);
            return terms;
        }
  },
});


data.initialize();

$('#remote .typeahead').typeahead(null, {
  display: 'completion',
  //name: 'completion',
  //valueKey: 'completion',
  limit: 20,
  minLength: 2,
  highlight: true,
  hint: false,
  source: data,
  autoselect:true,
});

$('.typeahead').bind('typeahead:selected',function(evt,data){
  console.log('SUBMIT');
  $('#remote').submit();
});
    //console.log(data);
    //console.log('completion==>' + data.completion); //selected datum object
    //$('.typeahead').val(data.completion);
    //console.log('labels==>' + data.concept.labels); //selected datum object
    //$('#data_labels').val(data.concept.labels);
    //console.log('curie==>' + data.concept.curie); //selected datum object
    //$('#data_curie').val(data.concept.curie);
    //console.log('synonyms==>' + data.concept.synonyms); //selected datum object
    //$('#data_synonyms').val(data.concept.synonyms);
//});
//$('.typeahead').bind('typeahead:change', function(ev, suggestion) {
//  console.log('change');
//});
//$('.typeahead').bind('typeahead:asyncreceive', function(ev, suggestion) {
//console.log('asyncreceive');
//});




$(".toggleResource").click(function () {
  var resourceUrl = $(this).attr('data-resourceUrl');
  $(this).parent().parent().siblings(".resourceIframeWrapper").toggle('fast')
    .children(".iframeSrc").attr("src", resourceUrl);
});



  $('.highlightInfo').on('click', function() {
          var id = $(this).attr('href').replace("#", "");
          $thisAns = $('.found_'+id);
           $thisAns.addClass("highlightInfoDiv");                      
          setTimeout(function(){
               $thisAns.removeClass("highlightInfoDiv");
          },2000);
          //alert(id);
          //alert($thisAns);
  });
  
  
  $('.btn-popover').popover();
  
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

</script>
    
    
    
    <? } ?>

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
