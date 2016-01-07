<script>
$(document).ready(function(){
  $( "#research_input_search" ).focus(function() {
    $( "#search_results" ).slideToggle( "slow", function() {
      // Animation complete.
    });
  });
});
</script>



<script src="/site/templates/assets/resource_web_list_search_assets/js/EasyAutocomplete-1_1_4/jquery.easy-autocomplete.min.js"></script>
<script>
$(document).ready(function(){
    $("a.resourceLinks").click(function(e) {
      $('#resourceIframe').hide();
      $("#resource_external").hide();  
      //e.preventDefault();
      $('#resourceLoading').show();
      $("#resourceIframe").attr("src", $(this).attr("href"));
    })
      $("#resource_delayed").delay(3000).fadeIn(500);  // This will show message after 3 seconds
});

$('#resourceIframe').load(function() {
    $('#resourceIframe').show();
    $('#resourceLoading').hide();
    $("#resource_delayed").delay(3000).fadeIn(500);  // This will show message after 3 seconds
});

$(".resourceLinks").on("click", function (e) {
    e.preventDefault();
    $("#resource_delayed").hide();
    $("#resource_external").hide();  
    $(".resourceLinks").css("fontWeight", "normal");
    $(this).css("fontWeight", "bold");
    var resourceTitle = $(this).attr("data-resource-title");
    var resourceUrl = $(this).attr("href");
    $(".resource_title").html( resourceTitle );
    $(".resource_url_text").html( resourceUrl );
    $('.resource_url_link').attr("href", resourceUrl );
    $("#resource_delayed").delay(3000).fadeIn(500);  // This will show message after 3 seconds
});
$(".resourceLinksExternal").on("click", function (e) {
    $('#resourceIframe').hide();
    $('#resource_delayed').hide();
    var resourceTitle = $(this).attr("data-resource-title");
    var resourceUrl = $(this).attr("href");
    $(".resource_title").html( resourceTitle );
    $(".resource_url_text").html( resourceUrl );
    $('.resource_url_link').attr("href", resourceUrl );
    $("#resource_external").show();  
});
</script>
<script>

var myApp;
myApp = myApp || (function () {
    var pleaseWaitDiv = $('<div class="modal fade" id="pleaseWaitDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-body"><h3 class="text-center">Processing Request</h3><div class="progress"><div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="101" style="width: 100%"></div></div></div></div>');
    return {
        showPleaseWait: function() {
            pleaseWaitDiv.modal();
        },
        hidePleaseWait: function () {
            pleaseWaitDiv.modal('hide');
        },

    };
})();
</script>


<script>



jsonData = $.getJSON( "/site/templates/assets/resource_web_list_search_assets/data/localTerm_data.json", function() {
  console.log('JSON Data Loaded');
});
 
 
// Set another completion function for the request above
jsonData.complete(function(jsonData) {
  $('#basics').attr("placeholder", "Context Search Enabled: Type in a gene, condition or medication");
  $('#infoButtonSearcher').hide();
  $('#infoButtonSearcherMessage').show();
  var options = {
    url: '/site/templates/assets/resource_web_list_search_assets/data/localTerm_data.json',
    //getValue: "sN",
    list: {
      match: {
        enabled: true
      },
      onClickEvent: function() {
        $('#infoButtonSearcher').submit();
      }	
    }
  };
  $('#infoButtonSearcherMessage').hide();
  $('#infoButtonSearcher').show();
  $("#basics").easyAutocomplete(options);

});
</script>