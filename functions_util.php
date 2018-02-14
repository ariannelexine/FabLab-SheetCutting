<?php

$output_to_client_console = TRUE;
// Output to javascript console if $output_to_client_console is set to true.
function consoleLog($data) {
	if($GLOBALS['output_to_client_console']){
		$output = $data;
		if(is_array($output)) 
			$output = implode(',', $output);
		$output = str_replace('"', '\'', $output); // Changes all double quotes into single quotes
		$output = trim(preg_replace('/\s+/', ' ', $output)); // Removes newline characters
		echo '<script>console.log("PHP: ' . $output . '");</script>'; 
		//echo $output . "<br>"; 
	}
}

?>