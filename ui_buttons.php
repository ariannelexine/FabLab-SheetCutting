<?php
echo '<div class="left_panel">';
// Sheet cutting buttons
makeLabel('Sheet cutting');
makeButton('View inventory', 'webpage_sheets_view_inventory.php');
makeButton('Add new material', 'webpage_sheets_new_material.php');
makeButton('Edit materials', '');

// Kiln loading buttons
makeLabel('Kiln loading');
makeButton('Add new object', '');
makeButton('Get next load', '');

// Debug buttons (Temporary; Remove this in the final version!)
makeDebugLabel('Debug');
makeDebugButton('View database tables', 'webpage_debug_view_tables.php');
makeDebugButton('Reset database', 'webpage_debug_reset_database.php');
echo '</div>';

function makeLabel($text){
	echo '<label class="ui_button_label">'.$text.'</label>';
}

function makeButton($text, $page_address){
	$current_page = basename($_SERVER['PHP_SELF']);
	
	if($page_address === '') {
		$text .= '<p style="color:#AA0000;line-height:0px;margin-top:0px;">(Not implemented)</p>';
	}
	
	if($current_page !== basename($page_address)) {
		echo '<a href="' . $page_address . '" class="ui_button">' . $text . '</a>';
	} else {
		echo '<a href="' . $page_address . '" class="ui_button ui_button_current">' . $text . '</a>';
	}
}

function makeDebugLabel($text){
	echo '<label class="ui_button_label ui_label_debug">'.$text.'</label>';
}

function makeDebugButton($text, $page_address){
	$current_page = basename($_SERVER['PHP_SELF']);
	
	if($page_address === '') {
		$text .= '<p style="color:#AA0000;line-height:0px;margin-top:0px;">(Not implemented)</p>';
	}
	
	if($current_page !== basename($page_address)) {
		echo '<a href="' . $page_address . '" class="ui_button ui_debug_button">' . $text . '</a>';
	} else {
		echo '<a href="' . $page_address . '" class="ui_button ui_debug_button_current">' . $text . '</a>';
	}
}

?>