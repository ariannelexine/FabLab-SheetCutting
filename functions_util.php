<?php
/*
Note:

The consoleLog functions will not work in the .php files that start with "ajax_";
this is because injecting a <script> tag via ".innerHTML" will not work.
*/


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
function consoleLogArray($data) {
	if($GLOBALS['output_to_client_console']){
		echo '<script>console.log("PHP: '; 
		$output = print_r($data, true); 
		$output = str_replace('"', '\'', $output); // Changes all double quotes into single quotes
		$output = trim(preg_replace('/\s+/', ' ', $output)); // Removes newline characters
		echo '");</script>'; 
	}
}

?>