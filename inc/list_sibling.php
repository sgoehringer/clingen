<?php 

// Output navigation for any children below the bodycopy.
// This navigation cycles through the page's children and prints
// a link and summary: 

if($page->siblings) {

    echo "<div class='row'><div id='col-sm-12'><fieldset><label>Additional Information Within {$page->parent->title}</label><ul class='nav'>";

    foreach($page->siblings as $child) {
        echo "<li class='col-md-5'><p><a href='{$child->url}'>{$child->title}</a></p></li>"; 
    }

    echo "</ul></fieldset></div>";
}

?> 