<?

$date_start = date("M j Y", $child->date_start); // Formating the date correctly
				$date_end = " <span class='text-11px nowrap text-muted'>until ".date("M j Y", $child->date_end)."</span>"; // Formating the date correctly
				if ($date_end == $date_start) { unset($date_end); }
				
				?>