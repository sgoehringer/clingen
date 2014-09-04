<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php"); ?>

<div class="row">
	<div class="col-sm-8">
	<div class="content-space content-border"><h2 class='page-title'><?=$page->title; ?></h2>
		<span class='bodytext'><?=$page->body; ?> </span>
		<form  class="form-horizontal" onsubmit="return validateForm()" name="myForm" method="POST" action="https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8">
			<input type="hidden" value="00DG0000000h9St" name="oid" id="oid">
			<input type="hidden" value="http://www.solren.com/contact-us/" name="retURL" id="retURL">
			<input type="hidden" value="Web" name="lead_source" id="lead_source">
			<div class="form-group">
				<div class="col-sm-6">
			<label for="first_name1">First Name &ndash; <span style="color: #da0003;">Req.</span></label>
			<input type="text"  class="form-control" maxlength="40" size="20" name="first_name" id="first_name">
			</div>
			
				<div class="col-sm-6">
			<label for="1last_name">Last Name &ndash; <span style="color: #da0003;">Req.</span></label>
			<input type="text"  class="form-control" maxlength="80" size="20" name="last_name" id="last_name">
			</div>
			</div>
			<div class="form-group">
			
				<div class="col-sm-12">
				<label for="1company">Company &ndash; <span style="color: #da0003;">Req.</span></label>
				<input type="text"  class="form-control"  maxlength="40" size="20" name="company" id="company">
				</div>
			</div>
			<div class="form-group">
			
				<div class="col-sm-6">
				<label for="1email">Email &ndash; <span style="color: #da0003;">Req.</span></label>
				<input type="text"  class="form-control"  maxlength="80" size="20" name="email" id="email">
			</div>
			
				<div class="col-sm-6">
				<label for="1phone">Phone &ndash; <span style="color: #da0003;">Req.</span></label>
				<input type="text"  class="form-control"  maxlength="40" size="20" name="phone" id="phone">
				</div>
			</div>
			<div class="form-group">
			<div class="col-sm-4">
				<label for="1Business Type">Country: &ndash; <span style="color: #da0003;">Req.</span></label>
			<select name="00NG0000009aveq"  class="form-control" title="Country" id="00NG0000009aveq">
				<option value="">&ndash;None&ndash;</option>
				<option value="USA" selected="selected">USA</option>
				<option value="Antigua and Barbuda">Antigua and Barbuda</option>
				<option value="Argentina">Argentina</option>
				<option value="Australia">Australia</option>
				<option value="Bahamas">Bahamas</option>
				<option value="Belgium">Belgium</option>
				<option value="Bolivia">Bolivia</option>
				<option value="Brazil">Brazil</option>
				<option value="British Virgin Islands">British Virgin Islands</option>
				<option value="Canada">Canada</option>
				<option value="Chile">Chile</option>
				<option value="China">China</option>
				<option value="Costa Rica">Costa Rica</option>
				<option value="Croatia">Croatia</option>
				<option value="Cuba">Cuba</option>
				<option value="Denmark">Denmark</option>
				<option value="Dominican Republic">Dominican Republic</option>
				<option value="Egypt">Egypt</option>
				<option value="France">France</option>
				<option value="Germany">Germany</option>
				<option value="Greece">Greece</option>
				<option value="Guam">Guam</option>
				<option value="Haiti">Haiti</option>
				<option value="Honduras">Honduras</option>
				<option value="Hong Kong">Hong Kong</option>
				<option value="India">India</option>
				<option value="Israel">Israel</option>
				<option value="Italy">Italy</option>
				<option value="Jamaica">Jamaica</option>
				<option value="Malaysia">Malaysia</option>
				<option value="Mexico">Mexico</option>
				<option value="Nigeria">Nigeria</option>
				<option value="Norway">Norway</option>
				<option value="Other">Other</option>
				<option value="Pakistan">Pakistan</option>
				<option value="Panama">Panama</option>
				<option value="Peshawar">Peshawar</option>
				<option value="Philippines">Philippines</option>
				<option value="Poland">Poland</option>
				<option value="Portugal">Portugal</option>
				<option value="Puerto Rico">Puerto Rico</option>
				<option value="Reunion">Reunion</option>
				<option value="Romania">Romania</option>
				<option value="Slovenia">Slovenia</option>
				<option value="South Africa">South Africa</option>
				<option value="South Korea">South Korea</option>
				<option value="Spain">Spain</option>
				<option value="Suriname">Suriname</option>
				<option value="Switzerland">Switzerland</option>
				<option value="Taiwan">Taiwan</option>
				<option value="Trinidad and Tobago">Trinidad and Tobago</option>
				<option value="Tunisia">Tunisia</option>
				<option value="Turkey">Turkey</option>
				<option value="UK">UK</option>
				<option value="United Arab Emirates">United Arab Emirates</option>
				<option value="US Virgin Islands">US Virgin Islands</option>
			</select>
			</div>
			<div class="col-sm-4">
				<label for="1State">State: &ndash; <span style="color: #da0003;">Req.</span></label>
			
			<select name="00NG0000009avev" class="form-control" title="State" id="00NG0000009avev">
				<option value="">&ndash;None&ndash;</option>
				<option value="AL">AL</option>
				<option value="AK">AK</option>
				<option value="AZ">AZ</option>
				<option value="AR">AR</option>
				<option value="CA">CA</option>
				<option value="CO">CO</option>
				<option value="CT">CT</option>
				<option value="DE">DE</option>
				<option value="FL">FL</option>
				<option value="GA">GA</option>
				<option value="HI">HI</option>
				<option value="ID">ID</option>
				<option value="IL">IL</option>
				<option value="IN">IN</option>
				<option value="IA">IA</option>
				<option value="KS">KS</option>
				<option value="KY">KY</option>
				<option value="LA">LA</option>
				<option value="ME">ME</option>
				<option value="MD">MD</option>
				<option value="MA">MA</option>
				<option value="MI">MI</option>
				<option value="MN">MN</option>
				<option value="MS">MS</option>
				<option value="MO">MO</option>
				<option value="MT">MT</option>
				<option value="NE">NE</option>
				<option value="NV">NV</option>
				<option value="NH">NH</option>
				<option value="NJ">NJ</option>
				<option value="NM">NM</option>
				<option value="NY">NY</option>
				<option value="NC">NC</option>
				<option value="ND">ND</option>
				<option value="OH">OH</option>
				<option value="OK">OK</option>
				<option value="OR">OR</option>
				<option value="PA">PA</option>
				<option value="RI">RI</option>
				<option value="SC">SC</option>
				<option value="SD">SD</option>
				<option value="TN">TN</option>
				<option value="TX">TX</option>
				<option value="UT">UT</option>
				<option value="VT">VT</option>
				<option value="VA">VA</option>
				<option value="WA">WA</option>
				<option value="WV">WV</option>
				<option value="WI">WI</option>
				<option value="WY">WY</option>
				<option value="DC">DC</option>
			</select>
			</div>
			
			<div class="col-sm-4">
				<label for="1Business Type">Business Type: &ndash; <span style="color: #da0003;">Req.</span></label>
			<select name="00NG0000009b1ZD" class="form-control" title="Business Type" id="00NG0000009b1ZD">
				<option value="">&ndash;None&ndash;</option>
				<option value="Developer">Developer</option>
				<option value="Distributor">Distributor</option>
				<option value="Engineer/Consultant">Engineer/Consultant</option>
				<option value="EPC">EPC</option>
				<option value="Financier">Financier</option>
				<option value="Government">Government</option>
				<option value="Manufacturer">Manufacturer</option>
				<option value="Other">Other</option>
				<option value="Owner">Owner</option>
				<option value="Press">Press</option>
				<option value="Utility">Utility</option>
			</select>
			</div>
			</div>
			<div class="form-group">
			
			<div class="col-sm-12">
				<label for="1description">Message</label>
				<textarea cols="4" class="form-control" name="description" id="description"></textarea>
				</div>
			</div>
			<div class="form-group">
			
			<div class="col-sm-12">
				<input type="submit" name="submit" value="Submit Request" class='btn btn-primary' id="submit">
						</div>

			</div>
		</form>
	</div>
  
	</div>
  <div class='col-sm-3 col-sm-offset-1 padding-left-md padding-top-sm margin-top-xl text-sm border-left' id="nav_well">
  
  <?
  // The following finds all of the locations this staff person is tied with, loops through and prints.
  $temp = $pages->get("template=working_group, relate_staff_coordinator>=1, sort=alphabetical")->relate_staff_coordinator;
  $matches = $pages->find("id=$temp, sort=alphabetical");
  $i = 0; // sets a key valye
  foreach($matches as $match) {
    if ($match->image) {
      $img_sized = $match->image->size(300);
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$img_sized->url}' class='img-responsive ' alt='{$match->title} {$img_sized->description}'>
                </a>
              </div>";
      $tempcss = "padding-top-md";  // This helps push the text down to balance out the position of the text next to the image
    }
    $tempval .= "<div class='col-sm-12'>
                {$tempimg}
                  <div class='col-sm-8 $tempcss'>
                    <a href='{$match->url}' class='text-bold' title='{$match->title}'>{$match->title}</a>
                    <div class='text-muted text-sm'>{$match->staff_title}</div>
                  </div>
                 </div>
                 ";
  }
   if($tempval) {
    $temptitle = $matches->count() == "1" ? "Coordinator" : 'Coordinators';   // This changes the title to account for more than 1 location
    echo "<h3>Coordinators</h3>"; 
    echo "<div class='row'>{$tempval}</div>";
    
   unset($tempcss);
   unset($temptitle);
   unset($tempval);
   unset($tempimg);
   }
  ?>  
  
  </div>
</div>
	
<? include("./inc/foot.php"); 


